<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('addresses', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('address');
			$table->string('zip_postcode', 50);
			$table->string('town_city');
			$table->integer('province_id')->unsigned()->default(0);
			$table->integer('country_id')->unsigned()->default(0);
			$table->integer('module_id')->unsigned()->default(0);
			$table->string('module_type');
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
		Schema::drop('addresses');
	}

}
