<?php

use Illuminate\Database\Seeder;

class PurchaseordersTableSeeder1 extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('purchaseorders')->delete();
        
		\DB::table('purchaseorders')->insert(array (
			0 => 
			array (
				'id' => 1,
				'company_id' => 0,
				'company_name' => '',
				'user_id' => 0,
				'status' => 0,
				'date' => '2015-07-09 11:40:26',
				'address_id' => 0,
				'company_phone' => '',
				'company_email' => '',
				'sum_amount' => 0,
				'locked' => 0,
				'created_by' => 0,
				'updated_by' => 0,
				'created_at' => '2015-07-09 11:40:26',
				'updated_at' => '2015-07-09 11:40:26',
			),
		));
	}

}
