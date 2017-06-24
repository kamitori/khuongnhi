<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('companies', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 50);
			$table->integer('company_type_id')->unsigned()->default(0);
			$table->string('phone', 12);
			$table->string('fax', 12);
			$table->string('email', 50);
			$table->string('web', 50);
			$table->integer('address_id')->unsigned()->default(0);
			$table->boolean('system')->default(0);
			$table->boolean('is_customer')->default(0);
			$table->boolean('is_distribute')->default(0);
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
		Schema::drop('companies');
	}

}
