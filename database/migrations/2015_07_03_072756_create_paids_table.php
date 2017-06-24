<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaidsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('paids', function(Blueprint $table)
		{
			$table->increments('id');
			$table->dateTime('date');
			$table->string('hinh_thuc', 255);
			$table->integer('company_id')->unsigned()->default(0);
			$table->integer('user_id')->unsigned()->default(0);
			$table->boolean('status')->unsigned()->default(0);
			$table->string('type_paid', 50);
			$table->double('sum_paid')->default(0);
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
		Schema::drop('paids');
	}

}
