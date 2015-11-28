<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sales', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('customer_id')->unsigned()->nullable();
			$table->foreign('customer_id')->references('id')->on('customers')->onDelete('restrict');
			$table->string('sales_man')->nullable();
			$table->string('customer_temp')->nullable();
			$table->string('customertemp_phone')->nullable();
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');
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
		Schema::drop('sales');
	}

}
