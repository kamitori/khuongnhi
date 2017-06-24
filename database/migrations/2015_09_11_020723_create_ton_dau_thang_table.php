<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTonDauThangTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ton_dau_thangs', function(Blueprint $table)
		{
			$table->integer('m_product_id')->unsigned();
			$table->integer('month')->unsigned();
			$table->integer('year')->unsigned();
			$table->integer('quantity')->unsigned();
			$table->primary(array('product_id','month','year'));
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
		Schema::drop('ton_dau_thangs');
	}

}
