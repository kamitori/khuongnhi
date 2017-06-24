<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
    public function run()
   	{
		Model::unguard();

        // Add calls to Seeders here
		$this->call('UsersTableSeeder');
		$this->call('MenusTableSeeder');
		$this->call('OumsTableSeeder');
		$this->call('PdfTemplatesTableSeeder');
		$this->call('CompanyTypesTableSeeder');
		$this->call('CountriesTableSeeder');
		$this->call('ProvincesTableSeeder');
		$this->call('ProductTypesTableSeeder');
		$this->call('CompaniesTableSeeder');
		$this->call('AddressesTableSeeder');

		$this->call('ProductsTableSeeder');

		$this->call('PurchaseordersTableSeeder1');
		$this->call('SaleordersTableSeeder1');
		$this->call('ReturnPurchaseordersTableSeeder1');
		$this->call('ReturnSaleordersTableSeeder1');

		$this->call('MProductsTableSeeder');
		$this->call('SellPricesTableSeeder');
		//$this->call('PaidsTableSeeder');
		
		
	}

}
