<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

            Schema::create('transactions', function (Blueprint $table)
         {
            $table->increments('id');
            // $table->integer('item_id')->unsigned();
            // $table->foreign('item_id')->references('id')->on('items')->onDelete('restrict');
            $table->integer('customer_id')->unsigned();
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('restrict');
            $table->decimal('amount',15, 2);
            $table->decimal('debtor',15, 2);
            $table->decimal('creditor',15, 2);
            $table->string('remarks', 255);
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
        //
        Schema::drop('transactions');
    }
}
