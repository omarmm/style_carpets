<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('items', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('item_code');
			$table->string('item_name',90);
			$table->string('item_type');
			$table->string('item_category');
			$table->string('size',20);
			$table->text('description');
			$table->string('avatar', 255)->default('no-foto.png');
			$table->decimal('metres_w',9, 2);
            $table->decimal('metres_h',9, 2);
			$table->decimal('cost_price',9, 2);
			$table->decimal('selling_price',9, 2);
			$table->decimal('opening_balance',9, 2);
			$table->integer('quantity');
			$table->integer('type')->default(1);
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
		Schema::drop('items');
	}

}
