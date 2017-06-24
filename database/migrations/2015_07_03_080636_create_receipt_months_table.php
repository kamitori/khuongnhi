<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReceiptMonthsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('receipt_months', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('month')->unsigned()->default(0);
			$table->integer('year')->unsigned()->default(0);
			$table->integer('company_id')->unsigned()->default(0);
			$table->string('type_receipt', 50);
			$table->double('sum_amount')->default(0);
			$table->double('paid')->default(0);
			$table->double('no_cu')->default(0);
			$table->double('con_lai')->default(0);
			$table->boolean('locked')->unsigned()->default(0);
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
		Schema::drop('receipt_months');
	}

}
