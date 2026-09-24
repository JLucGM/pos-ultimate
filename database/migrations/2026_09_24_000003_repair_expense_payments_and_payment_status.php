<?php

use App\Transaction;
use App\TransactionPayment;
use App\Utils\TransactionUtil;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $transactionUtil = new TransactionUtil();

        // 1. Corregir pagos de gastos que quedaron registrados en bolivares o sin amount_in_base_currency
        $expenseTransactions = Transaction::whereIn('type', ['expense', 'expense_refund'])
            ->with('payment_lines')
            ->get();

        foreach ($expenseTransactions as $transaction) {
            $rate = floatval($transaction->exchange_rate ?? 1.0);
            
            foreach ($transaction->payment_lines as $payment) {
                // Si el monto del pago supera el total del gasto en USD por más de 1.5x, es porque se guardó en Bs
                if ($rate > 1 && $payment->amount > ($transaction->final_total * 1.5)) {
                    $baseAmount = round($payment->amount / $rate, 4);
                    $payment->amount_in_base_currency = $baseAmount;
                    $payment->payment_exchange_rate = $rate;
                    if (empty($payment->payment_currency_id) && !empty($transaction->transaction_currency_id)) {
                        $payment->payment_currency_id = $transaction->transaction_currency_id;
                    }
                    $payment->save();
                } elseif (empty($payment->amount_in_base_currency) && !empty($payment->payment_exchange_rate) && $payment->payment_exchange_rate > 1) {
                    $payment->amount_in_base_currency = round($payment->amount / $payment->payment_exchange_rate, 4);
                    $payment->save();
                }
            }

            // Recalcular payment_status para la transacción
            $total_paid = $transactionUtil->getTotalPaid($transaction->id);
            if ($total_paid >= ($transaction->final_total - 0.005)) {
                $transaction->payment_status = 'paid';
                $transaction->save();
            } elseif ($total_paid > 0.005) {
                $transaction->payment_status = 'partial';
                $transaction->save();
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
