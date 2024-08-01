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
        Schema::table('purchase_orders', function (Blueprint $table) {
            // TODO: el campo "number" se dejara de usar
            // se separaran las ordenes de compra por garantia y gatos
            $table->string('order_number_warranty')->nullable()->after('number');
            $table->string('order_number_expenses')->nullable()->after('order_number_warranty');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchase_orders', function (Blueprint $table) {
            $table->dropColumn('order_number_warranty');
            $table->dropColumn('order_number_expenses');
        });
    }
};
