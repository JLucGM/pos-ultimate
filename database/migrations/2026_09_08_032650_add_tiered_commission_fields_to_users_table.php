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
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'cmmsn_type')) {
                $table->string('cmmsn_type', 20)->default('fixed')->after('cmmsn_percent')->comment('fixed = Fija, tiered = Escalonada por dias');
            }
            if (!Schema::hasColumn('users', 'cmmsn_tiered_rules')) {
                $table->text('cmmsn_tiered_rules')->nullable()->after('cmmsn_type')->comment('JSON con tramos de comision por dias de cobro');
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
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'cmmsn_type')) {
                $table->dropColumn('cmmsn_type');
            }
            if (Schema::hasColumn('users', 'cmmsn_tiered_rules')) {
                $table->dropColumn('cmmsn_tiered_rules');
            }
        });
    }
};
