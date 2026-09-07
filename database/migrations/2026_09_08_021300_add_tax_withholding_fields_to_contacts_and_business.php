<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contacts', function (Blueprint $table) {
            if (!Schema::hasColumn('contacts', 'is_tax_withholding_agent')) {
                $table->boolean('is_tax_withholding_agent')->default(0)->after('tax_number')->comment('1 = Contribuyente Especial / Agente de Retencion SENIAT');
            }
            if (!Schema::hasColumn('contacts', 'tax_withholding_rate')) {
                $table->decimal('tax_withholding_rate', 5, 2)->default(75.00)->after('is_tax_withholding_agent')->comment('Porcentaje de Retencion de IVA (75%, 100%, etc.)');
            }
        });

        Schema::table('business', function (Blueprint $table) {
            if (!Schema::hasColumn('business', 'is_tax_withholding_agent')) {
                $table->boolean('is_tax_withholding_agent')->default(0)->after('tax_number_2')->comment('1 = La empresa es Agente de Retencion SENIAT');
            }
            if (!Schema::hasColumn('business', 'withholding_agent_resolution')) {
                $table->string('withholding_agent_resolution', 100)->nullable()->after('is_tax_withholding_agent')->comment('No. de Resolucion / Providencia de Designacion SENIAT');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contacts', function (Blueprint $table) {
            if (Schema::hasColumn('contacts', 'is_tax_withholding_agent')) {
                $table->dropColumn('is_tax_withholding_agent');
            }
            if (Schema::hasColumn('contacts', 'tax_withholding_rate')) {
                $table->dropColumn('tax_withholding_rate');
            }
        });

        Schema::table('business', function (Blueprint $table) {
            if (Schema::hasColumn('business', 'is_tax_withholding_agent')) {
                $table->dropColumn('is_tax_withholding_agent');
            }
            if (Schema::hasColumn('business', 'withholding_agent_resolution')) {
                $table->dropColumn('withholding_agent_resolution');
            }
        });
    }
};
