<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaleTempsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sale_temps', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('item_id')->unsigned();
			$table->foreign('item_id')->references('id')->on('items')->onDelete('restrict');
			$table->decimal('cost_price',9, 2);
			$table->decimal('selling_price',9, 2);
			$table->integer('quantity');
			$table->integer('pieces')->default(1);
            $table->decimal('metres',9, 2)->default(1);
			$table->decimal('total_cost',9, 2);
			$table->decimal('total_selling',9, 2);
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
		Schema::drop('sale_temps');
	}

}
