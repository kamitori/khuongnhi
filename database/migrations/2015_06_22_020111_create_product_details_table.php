<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductDetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('product_details', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('code');
			$table->integer('oum_id')->unsigned()->default(0);
			$table->integer('specification')->unsigned()->default(1);
			$table->boolean('status')->default(0);
			$table->double('in_stock')->unsigned()->default(0);
			$table->double('invest')->unsigned()->default(0);
			$table->double('origin_price')->unsigned()->default(0);
			$table->integer('product_id')->unsigned()->default(0);
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
		Schema::drop('product_details');
	}

}
