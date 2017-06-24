<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRevenueOthersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('revenue_others', function(Blueprint $table)
		{
			$table->increments('id');
			$table->dateTime('date');
			$table->string('ly_do', 255);
			$table->integer('user_id')->unsigned()->default(0);
			$table->boolean('status')->unsigned()->default(0);
			$table->double('sum_amount')->default(0);
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
		Schema::drop('revenue_others');
	}

}
