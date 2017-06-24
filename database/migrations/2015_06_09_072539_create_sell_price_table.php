<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSellPriceTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sell_prices', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->double('price')->unsigned()->default(0);
			$table->integer('product_id')->unsigned()->default(0);
			$table->integer('m_product_id')->unsigned()->default(0);
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
		Schema::drop('sell_prices');
	}

}
