<?php

namespace App\Console\Commands;

use App\Transaction;
use App\Utils\TransactionUtil;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SyncPaymentStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pos:sync-payment-status 
                            {--business_id= : Sincronizar solo para un ID de negocio específico} 
                            {--transaction_id= : Sincronizar solo para un ID de transacción específico} 
                            {--dry-run : Solo mostrar discrepancias sin actualizar la base de datos}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recalcula y sincroniza el estado de pago (payment_status) de las facturas/compras con sus pagos reales';

    /**
     * @var TransactionUtil
     */
    protected $transactionUtil;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(TransactionUtil $transactionUtil)
    {
        parent::__construct();
        $this->transactionUtil = $transactionUtil;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Iniciando verificación y sincronización de estados de pago...');

        $business_id = $this->option('business_id');
        $transaction_id = $this->option('transaction_id');
        $is_dry_run = (bool) $this->option('dry-run');

        if ($is_dry_run) {
            $this->warn('MODO PRUEBA (DRY-RUN) ACTIVO: No se realizarán cambios en la base de datos.');
        }

        $query = Transaction::query()
            ->whereIn('type', ['sell', 'purchase', 'expense', 'sell_return', 'purchase_return']);

        if (!empty($business_id)) {
            $query->where('business_id', $business_id);
        }

        if (!empty($transaction_id)) {
            $query->where('id', $transaction_id);
        }

        $transactions = $query->select(
            'id',
            'business_id',
            'type',
            'invoice_no',
            'ref_no',
            'final_total',
            'payment_status',
            'transaction_date'
        )->get();

        $this->info("Analizando {$transactions->count()} transacciones...");

        $discrepancies = [];
        $fixed_count = 0;

        foreach ($transactions as $transaction) {
            $total_paid = $this->transactionUtil->getTotalPaid($transaction->id);
            $calculated_status = $this->transactionUtil->calculatePaymentStatus($transaction->id, $transaction->final_total);

            if ($transaction->payment_status !== $calculated_status) {
                $ref = $transaction->invoice_no ?: $transaction->ref_no ?: ('#' . $transaction->id);

                $discrepancies[] = [
                    'id' => $transaction->id,
                    'business_id' => $transaction->business_id,
                    'type' => $transaction->type,
                    'ref' => $ref,
                    'final_total' => number_format((float) $transaction->final_total, 2, '.', ','),
                    'total_paid' => number_format((float) $total_paid, 2, '.', ','),
                    'old_status' => $transaction->payment_status,
                    'new_status' => $calculated_status,
                ];

                if (!$is_dry_run) {
                    $this->transactionUtil->updatePaymentStatus($transaction->id, $transaction->final_total);
                    $fixed_count++;
                }
            }
        }

        if (empty($discrepancies)) {
            $this->info('✓ Todas las transacciones tienen su estado de pago correctamente sincronizado.');
            return Command::SUCCESS;
        }

        $this->warn('Se encontraron ' . count($discrepancies) . ' transacciones con estado desincronizado:');

        $headers = ['ID', 'Negocio', 'Tipo', 'Doc/Factura', 'Total', 'Pagado', 'Estado Anterior', 'Estado Correcto'];
        $this->table($headers, $discrepancies);

        if (!$is_dry_run) {
            $this->info("✓ Se corrigieron exitosamente {$fixed_count} transacciones.");
        } else {
            $this->comment('Ejecute el comando sin --dry-run para aplicar las correcciones automáticamente.');
        }

        return Command::SUCCESS;
    }
}
