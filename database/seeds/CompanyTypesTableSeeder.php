<?php

use Illuminate\Database\Seeder;

class CompanyTypesTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('company_types')->delete();
        
		\DB::table('company_types')->insert(array (
			0 => 
			array (
				'id' => 1,
				'name' => 'Shop',
				'created_by' => 0,
				'updated_by' => 0,
				'created_at' => '2015-06-09 10:27:52',
				'updated_at' => '2015-06-09 10:27:52',
			),
			1 => 
			array (
				'id' => 2,
				'name' => 'Doanh nghiệp tư nhân',
				'created_by' => 0,
				'updated_by' => 0,
				'created_at' => '2015-06-09 10:28:09',
				'updated_at' => '2015-06-09 10:28:09',
			),
			2 => 
			array (
				'id' => 3,
				'name' => 'Buôn bán lẻ',
				'created_by' => 0,
				'updated_by' => 0,
				'created_at' => '2015-06-09 10:28:41',
				'updated_at' => '2015-06-09 10:29:15',
			),
			3 => 
			array (
				'id' => 4,
				'name' => 'Công ty cổ phẩn',
				'created_by' => 0,
				'updated_by' => 0,
				'created_at' => '2015-06-09 10:28:56',
				'updated_at' => '2015-06-09 10:28:56',
			),
		));
	}

}
