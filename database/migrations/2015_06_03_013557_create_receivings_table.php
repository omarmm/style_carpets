<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReceivingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('receivings', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('supplier_id')->unsigned()->nullable();
			$table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('restrict');
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
			$table->string('sales_man')->nullable();
			$table->string('payment_type', 15)->nullable();
			$table->string('comments', 255)->nullable();
			$table->boolean('reserved')->default(0);
			$table->boolean('visacard')->default(0);
			$table->decimal('deposit',9, 2);
			$table->decimal('amount_due',9, 2);
			$table->decimal('total',9, 2);
			$table->decimal('creditor',9, 2);
			$table->decimal('debtor',9, 2);
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
		Schema::drop('receivings');
	}

}
