<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMProductsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('m_products', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('module_type', 50);
			$table->integer('module_id')->unsigned()->default(0);
			$table->integer('product_id')->unsigned()->default(0);
			$table->integer('company_id')->unsigned()->default(0);
			$table->integer('oum_id')->unsigned()->default(0);
			$table->double('origin_price')->default(0);
			$table->double('sell_price')->default(0);
			$table->integer('specification')->unsigned()->default(0);
			$table->double('amount')->default(0);
			$table->double('invest')->default(0);
			$table->integer('m_product_id')->unsigned()->default(0);
			$table->integer('m_product_id_so')->unsigned()->default(0);
			$table->double('amount_interest')->default(0);
			$table->double('order')->unsigned()->default(0);
			$table->integer('quantity')->default(0);
			$table->integer('created_by')->default(0);
			$table->integer('updated_by')->default(0);
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
		Schema::drop('m_products');
	}

}
