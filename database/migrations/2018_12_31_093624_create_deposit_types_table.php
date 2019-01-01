<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepositTypesTable extends Migration
{
    /**
     * Run the migrations.
     *  $table->string('transaksi');
            $table->integer('tipe');
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deposit_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('transaction_name');
            $table->integer('type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deposit_types');
    }
}
