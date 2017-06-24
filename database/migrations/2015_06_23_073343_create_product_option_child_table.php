<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductOptionChildTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('product_option_child', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 50);
			$table->integer('parent_option_id')->default(0);
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
		Schema::drop('product_option_child');
	}

}
