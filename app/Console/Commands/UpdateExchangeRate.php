<?php

namespace App\Console\Commands;

use App\Services\ExchangeRateService;
use Illuminate\Console\Command;

class UpdateExchangeRate extends Command
{
    protected $signature = 'exchange:update
                            {--source=oficial : Fuente de la tasa (oficial o paralelo)}
                            {--business= : ID del negocio específico (si no se indica, actualiza todos)}';

    protected $description = 'Actualizar tasa de cambio USD/Bs desde DolarApi.com (BCV)';

    public function handle()
    {
        $service = new ExchangeRateService();
        $source = $this->option('source');
        $business_id = $this->option('business');

        $this->info("Consultando DolarApi.com (fuente: {$source})...");

        if ($business_id) {
            $result = $service->updateRate((int) $business_id, $source);
            $this->outputResult($business_id, $result);
        } else {
            $results = $service->updateAllBusinesses($source);
            foreach ($results as $bid => $result) {
                $this->outputResult($bid, $result);
            }
        }

        return 0;
    }

    private function outputResult($business_id, array $result): void
    {
        if ($result['success']) {
            $this->info("  Negocio #{$business_id}: {$result['message']}");
        } else {
            $this->error("  Negocio #{$business_id}: {$result['message']}");
        }
    }
}
