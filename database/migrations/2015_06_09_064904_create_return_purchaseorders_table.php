<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReturnPurchaseordersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('return_purchaseorders', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('company_id')->unsigned()->default(0);
			$table->string('company_name', 50);
			$table->integer('user_id')->unsigned()->default(0);
			$table->boolean('status')->unsigned()->default(0);
			$table->dateTime('date');
			$table->integer('address_id')->unsigned()->default(0);
			$table->string('company_phone', 12);
			$table->string('company_email', 50);
			$table->double('sum_amount')->default(0);
			$table->double('sum_invest')->default(0);
			$table->boolean('locked')->unsigned()->default(0);
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
		Schema::drop('return_purchaseorders');
	}

}
