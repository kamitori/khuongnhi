<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Paid;
class PaidsTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		$faker = Faker::create();
        		foreach(range(1, 100) as $index)
		{
			$company_id = $faker->numberBetween(1,20);
			$date = $faker->dateTimeBetween($startDate = '-6 months', $endDate = 'now');
			$hinh_thuc =  $faker->randomElement($array = array('Tiền mặt', 'Chuyển khoản'));
			$sum_paid = $faker->numberBetween(10,300)*1000*1000;
			$type_paid = 'distribute';
			Paid::create([
					'company_id'	=>	$company_id,
					'date'		=>	$date,
					'hinh_thuc'	=>	$hinh_thuc,
					'sum_paid'	=>	$sum_paid,
					'type_paid'	=>	$type_paid
				]);
		}
        
	}

}
