<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
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
        // 1. Corregir / actualizar la moneda de Venezuela en la tabla currencies
        $venezuela = DB::table('currencies')
            ->where('country', 'like', '%Venezuela%')
            ->orWhere('id', 128)
            ->first();

        if ($venezuela) {
            DB::table('currencies')->where('id', $venezuela->id)->update([
                'currency' => 'Bolívares (VES)',
                'code' => 'VES',
                'symbol' => 'Bs',
                'country' => 'Venezuela'
            ]);
            $venezuela_id = $venezuela->id;
        } else {
            $venezuela_id = DB::table('currencies')->insertGetId([
                'country' => 'Venezuela',
                'currency' => 'Bolívares (VES)',
                'code' => 'VES',
                'symbol' => 'Bs',
                'thousand_separator' => ',',
                'decimal_separator' => '.',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 2. Eliminar tasas erróneas que se crearon contra Bolivia (id: 14 / BOB)
        $bolivia = DB::table('currencies')->where('code', 'BOB')->first();
        if ($bolivia) {
            DB::table('exchange_rates')
                ->where('to_currency_id', $bolivia->id)
                ->where('rate', '>', 50) // Tasas de 800+ que corresponden a Venezuela pero tenían ID de Bolivia
                ->delete();
        }

        // 3. Reasignar cualquier tasa restante huérfana de Venezuela hacia el ID correcto de VES
        DB::table('exchange_rates')
            ->where('to_currency_id', 128)
            ->update(['to_currency_id' => $venezuela_id]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // No destructivo
    }
};
