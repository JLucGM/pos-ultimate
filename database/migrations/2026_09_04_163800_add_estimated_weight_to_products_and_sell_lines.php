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
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'enable_estimated_weight')) {
                $table->boolean('enable_estimated_weight')->default(0)->after('weight');
            }
            if (!Schema::hasColumn('products', 'estimated_weight')) {
                $table->decimal('estimated_weight', 22, 4)->default(0)->after('enable_estimated_weight');
            }
        });

        Schema::table('transaction_sell_lines', function (Blueprint $table) {
            if (!Schema::hasColumn('transaction_sell_lines', 'pieces_quantity')) {
                $table->decimal('pieces_quantity', 22, 4)->default(0)->after('quantity');
            }
            if (!Schema::hasColumn('transaction_sell_lines', 'estimated_weight')) {
                $table->decimal('estimated_weight', 22, 4)->default(0)->after('pieces_quantity');
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
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'enable_estimated_weight')) {
                $table->dropColumn('enable_estimated_weight');
            }
            if (Schema::hasColumn('products', 'estimated_weight')) {
                $table->dropColumn('estimated_weight');
            }
        });

        Schema::table('transaction_sell_lines', function (Blueprint $table) {
            if (Schema::hasColumn('transaction_sell_lines', 'pieces_quantity')) {
                $table->dropColumn('pieces_quantity');
            }
            if (Schema::hasColumn('transaction_sell_lines', 'estimated_weight')) {
                $table->dropColumn('estimated_weight');
            }
        });
    }
};
