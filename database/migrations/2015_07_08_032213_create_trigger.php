<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrigger extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
// Create company  --> create address
		DB::unprepared("
			CREATE TRIGGER tr_Create_Company_Address AFTER INSERT ON `companies` FOR EACH ROW
			BEGIN
				INSERT INTO `khuongnhi`.`addresses` (`id`, `address`, `zip_postcode`, `town_city`, `province_id`, `country_id`, `module_id`, `module_type`, `created_by`, `updated_by`, `created_at`, `updated_at`) 
				VALUES (NULL, '', '', '', '0', '0', NEW.id, 'App\\\\Company', '0', '0', NOW(), NOW());
			END
		");

		DB::unprepared("
			CREATE TRIGGER tr_Delete_Company_Address AFTER DELETE ON `companies` FOR EACH ROW
			BEGIN
				DELETE  FROM `khuongnhi`.`addresses` WHERE `module_id`=OLD.id and `module_type` = 'App\\\\Company';
			END
		");

// Create order --> create address & create receipt month
		DB::unprepared("
			CREATE TRIGGER tr_Create_PO_Address AFTER INSERT ON `purchaseorders` FOR EACH ROW
			BEGIN
				INSERT INTO `khuongnhi`.`addresses` (`id`, `address`, `zip_postcode`, `town_city`, `province_id`, `country_id`, `module_id`, `module_type`, `created_by`, `updated_by`, `created_at`, `updated_at`) 
				VALUES (NULL, '', '', '', '0', '0', NEW.id, 'App\\\\Purchaseorder', '0', '0', NOW(), NOW());

			END
		");
		DB::unprepared("
			CREATE TRIGGER tr_Create_SO_Address AFTER INSERT ON `saleorders` FOR EACH ROW
			BEGIN
				INSERT INTO `khuongnhi`.`addresses` (`id`, `address`, `zip_postcode`, `town_city`, `province_id`, `country_id`, `module_id`, `module_type`, `created_by`, `updated_by`, `created_at`, `updated_at`) 
				VALUES (NULL, '', '', '', '0', '0', NEW.id, 'App\\\\Saleorder', '0', '0', NOW(), NOW());
				
			END
		");
		DB::unprepared("
			CREATE TRIGGER tr_Create_RPO_Address AFTER INSERT ON `return_purchaseorders` FOR EACH ROW
			BEGIN
				INSERT INTO `khuongnhi`.`addresses` (`id`, `address`, `zip_postcode`, `town_city`, `province_id`, `country_id`, `module_id`, `module_type`, `created_by`, `updated_by`, `created_at`, `updated_at`) 
				VALUES (NULL, '', '', '', '0', '0', NEW.id, 'App\\\\ReturnPurchaseorder', '0', '0', NOW(), NOW());
				
			END
		");
		DB::unprepared("
			CREATE TRIGGER tr_Create_RSO_Address AFTER INSERT ON `return_saleorders` FOR EACH ROW
			BEGIN
				INSERT INTO `khuongnhi`.`addresses` (`id`, `address`, `zip_postcode`, `town_city`, `province_id`, `country_id`, `module_id`, `module_type`, `created_by`, `updated_by`, `created_at`, `updated_at`) 
				VALUES (NULL, '', '', '', '0', '0', NEW.id, 'App\\\\ReturnSaleorder', '0', '0', NOW(), NOW());
				
			END
		");

// Delete order --> delete address

		DB::unprepared("
			CREATE TRIGGER tr_Delete_PO_Address AFTER DELETE ON `purchaseorders` FOR EACH ROW
			BEGIN
				DELETE  FROM `khuongnhi`.`addresses` WHERE `module_id`=OLD.id and `module_type` = 'App\\\\Purchaseorder';
			END
		");
		DB::unprepared("
			CREATE TRIGGER tr_Delete_SO_Address AFTER DELETE ON `saleorders` FOR EACH ROW
			BEGIN
				DELETE  FROM `khuongnhi`.`addresses` WHERE `module_id`=OLD.id and `module_type` = 'App\\\\Saleorder';
			END
		");
		DB::unprepared("
			CREATE TRIGGER tr_Delete_RPO_Address AFTER DELETE ON `return_purchaseorders` FOR EACH ROW
			BEGIN
				DELETE  FROM `khuongnhi`.`addresses` WHERE `module_id`=OLD.id and `module_type` = 'App\\\\ReturnPurchaseorder';
			END
		");
		DB::unprepared("
			CREATE TRIGGER tr_Delete_RSO_Address AFTER DELETE ON `return_saleorders` FOR EACH ROW
			BEGIN
				DELETE  FROM `khuongnhi`.`addresses` WHERE `module_id`=OLD.id and `module_type` = 'App\\\\ReturnSaleorder';
			END
		");

// Create mproduct --> create product stock
		DB::unprepared("
			CREATE TRIGGER tr_Create_Mproduct_Productstock AFTER INSERT ON `m_products` FOR EACH ROW
			BEGIN
				DECLARE status_po INT;
				IF(NEW.module_type = 'App\\\\Purchaseorder') THEN
					SET status_po = (SELECT `status` from `purchaseorders` where `id`=New.module_id);
					IF(status_po=1) THEN
						INSERT INTO `khuongnhi`.`product_stocks` (`id`, `m_product_id`, `product_id`, `in_stock`, `created_by`, `updated_by`, `created_at`, `updated_at`) 
						VALUES (NULL, NEW.id, NEW.product_id, NEW.quantity*NEW.specification, '0', '0', NOW(), NOW());
					ELSE
						INSERT INTO `khuongnhi`.`product_stocks` (`id`, `m_product_id`, `product_id`, `in_stock`, `created_by`, `updated_by`, `created_at`, `updated_at`) 
						VALUES (NULL, NEW.id, NEW.product_id, '0', '0', '0', NOW(), NOW());
					END IF;
				END IF;
				
				IF(NEW.module_type = 'in_stock') THEN
					INSERT INTO `khuongnhi`.`product_stocks` (`id`, `m_product_id`, `product_id`, `in_stock`, `created_by`, `updated_by`, `created_at`, `updated_at`) 
					VALUES (NULL, NEW.id, NEW.product_id, NEW.quantity*NEW.specification, '0', '0', NOW(), NOW());
				END IF;
			END
		");

		DB::unprepared("
			CREATE TRIGGER tr_Delete_Mproduct_Productstock AFTER DELETE ON `m_products` FOR EACH ROW
			BEGIN
				DELETE  FROM `khuongnhi`.`product_stocks` WHERE `m_product_id`=OLD.id;
			END
		");

// Update Mproduct --> update Amount or Invest
		DB::unprepared("
			CREATE TRIGGER tr_Update_Mproduct_Order AFTER UPDATE ON `m_products` 
			FOR EACH ROW
			BEGIN
			IF NEW.module_type = 'App\\\\Purchaseorder' THEN
			
				UPDATE `khuongnhi`.`purchaseorders` o
				INNER JOIN
				(
				SELECT `module_id`, SUM(`invest`) sum_amount
				FROM `m_products`
				WHERE `module_type` = 'App\\\\Purchaseorder'
				GROUP BY `module_id`
				) i ON o.id = i.module_id
				SET o.sum_amount = i.sum_amount
				WHERE o.id = NEW.module_id
				AND o.status = 1;
			END IF; 
			IF NEW.module_type = 'App\\\\ReturnPurchaseorder' THEN
			
				UPDATE `khuongnhi`.`return_purchaseorders` o
				INNER JOIN
				(
				SELECT `module_id`, SUM(`invest`) sum_amount
				FROM `m_products`
				WHERE `module_type` = 'App\\\\ReturnPurchaseorder'
				GROUP BY `module_id`
				) i ON o.id = i.module_id
				SET o.sum_amount = i.sum_amount
				WHERE o.id = NEW.module_id
				AND o.status = 1;
			END IF; 
			IF NEW.module_type = 'App\\\\Saleorder' THEN
			
				UPDATE `khuongnhi`.`saleorders` o
				INNER JOIN
				(
				SELECT `module_id`, SUM(`amount`) sum_amount
				FROM `m_products`
				WHERE `module_type` = 'App\\\\Saleorder'
				GROUP BY `module_id`
				) i ON o.id = i.module_id
				SET o.sum_amount = i.sum_amount
				WHERE o.id = NEW.module_id
				AND o.status = 1;
			END IF; 
			IF NEW.module_type = 'App\\\\ReturnSaleorder' THEN
			
				UPDATE `khuongnhi`.`return_saleorders` o
				INNER JOIN
				(
				SELECT `module_id`, SUM(`amount`) sum_amount
				FROM `m_products`
				WHERE `module_type` = 'App\\\\ReturnSaleorder'
				GROUP BY `module_id`
				) i ON o.id = i.module_id
				SET o.sum_amount = i.sum_amount
				WHERE o.id = NEW.module_id
				AND o.status = 1;
			END IF; 
			END
		");

// Update Mproduct
		DB::unprepared("
			CREATE TRIGGER tr_Update_Mproduct_Order_Before BEFORE UPDATE ON `m_products` 
			FOR EACH ROW
			BEGIN
				IF(NEW.specification <> OLD.specification OR NEW.quantity <> OLD.quantity OR NEW.origin_price <> OLD.origin_price OR NEW.sell_price <> OLD.sell_price) THEN
					SET NEW.amount = NEW.specification * NEW.quantity * NEW.sell_price;
					SET NEW.invest = NEW.specification * NEW.quantity * NEW.origin_price;
				END IF;
			END
		");

// Create Paid --> Create receipt month
		DB::unprepared("
			CREATE TRIGGER tr_Create_Paid_Receipt_Month AFTER INSERT ON `Paids` 
			FOR EACH ROW
			BEGIN
				IF(SELECT EXISTS(SELECT 1 FROM receipt_months WHERE month = MONTH(NEW.date) and year = YEAR(NEW.date) and type_receipt=NEW.type_paid and `company_id`=NEW.company_id and NEW.company_id > 0 LIMIT 1)=0) THEN
					INSERT INTO `khuongnhi`.`receipt_months` (`id`, `month`, `year`, `type_receipt`, `sum_amount`, `paid`, `no_cu`, `con_lai`, `created_at`, `updated_at`,`company_id`) VALUES (NULL, MONTH(NEW.date), YEAR(NEW.date), NEW.type_paid, '0', NEW.sum_paid, '0', '0', NOW(), NOW(),NEW.company_id);
				ELSE
					UPDATE `khuongnhi`.`receipt_months` SET 
					`paid`=`paid` + (NEW.sum_paid),
					`con_lai`= `sum_amount`+`no_cu`- `paid`
					WHERE `month` = MONTH(NEW.date)
					AND `year` = YEAR(NEW.date)
					AND `type_receipt` = NEW.type_paid
					AND `company_id` = NEW.company_id;
				END IF;
			END
		");
// Delete Paid --> Decrease receipt month
		DB::unprepared("
			CREATE TRIGGER tr_Delete_Paid_Receipt_Month AFTER DELETE ON `Paids` 
			FOR EACH ROW
			BEGIN
				UPDATE `khuongnhi`.`receipt_months` SET 
					`paid`=`paid` - (OLD.sum_paid),
					`con_lai`= `sum_amount`+`no_cu`- `paid`
					WHERE `month` = MONTH(OLD.date)
					AND `year` = YEAR(OLD.date)
					AND `type_receipt` = OLD.type_paid
					AND `company_id` = OLD.company_id;
			END
		");
// Update order --> update receipt month
		DB::unprepared("
			CREATE TRIGGER tr_Update_Paid_Receipt_Month AFTER UPDATE ON `Paids` 
			FOR EACH ROW
			BEGIN
				UPDATE `khuongnhi`.`receipt_months` SET 
				`paid`=`paid` + (NEW.sum_paid - OLD.sum_paid),
				`con_lai`= `sum_amount`+`no_cu`- `paid`
				WHERE `month` = MONTH(NEW.date)
				AND `year` = YEAR(NEW.date)
				AND `type_receipt` = NEW.type_paid
				AND `company_id` = NEW.company_id;
			END
		");

		DB::unprepared("
			CREATE TRIGGER tr_Update_PO_Receipt_Month AFTER UPDATE ON `purchaseorders` 
			FOR EACH ROW
			BEGIN
				IF(NEW.status =1 AND OLD.status =0) THEN
					IF(SELECT EXISTS(SELECT 1 FROM receipt_months WHERE month = MONTH(NEW.date) and year = YEAR(NEW.date) and type_receipt='distribute'  and `company_id`=NEW.company_id and NEW.company_id > 0 LIMIT 1)=0) THEN
						INSERT INTO `khuongnhi`.`receipt_months` (`id`, `month`, `year`, `type_receipt`, `sum_amount`, `paid`, `no_cu`, `con_lai`, `created_at`, `updated_at`,`company_id`) VALUES (NULL, MONTH(NEW.date), YEAR(NEW.date), 'distribute', NEW.sum_amount, '0', '0', NEW.sum_amount, NOW(), NOW(),NEW.company_id);
					ELSE

						UPDATE `khuongnhi`.`receipt_months` SET 
						`sum_amount`=`sum_amount` + NEW.sum_amount,
						`con_lai`= `sum_amount`+`no_cu`- `paid`
						WHERE  `month` = MONTH(NEW.date)
						AND `year` = YEAR(NEW.date)
						AND `type_receipt` = 'distribute'
						AND `company_id` = NEW.company_id;

					END IF;
				END IF;
				IF(NEW.status =0 AND OLD.status =1) THEN
					UPDATE `khuongnhi`.`receipt_months` SET 
						`sum_amount`=`sum_amount` - OLD.sum_amount,
						`con_lai`= `sum_amount`+`no_cu`- `paid`
						WHERE  `month` = MONTH(OLD.date)
						AND `year` = YEAR(OLD.date)
						AND `type_receipt` = 'distribute'
						AND `company_id` = OLD.company_id;
				END IF;
			END
		");
		DB::unprepared("
			CREATE TRIGGER tr_Update_RPO_Receipt_Month AFTER UPDATE ON `return_purchaseorders` 
			FOR EACH ROW
			BEGIN
				IF(NEW.status =1 AND OLD.status =0) THEN
					IF(SELECT EXISTS(SELECT 1 FROM receipt_months WHERE month = MONTH(NEW.date) and year = YEAR(NEW.date) and type_receipt='distribute'  and `company_id`=NEW.company_id and NEW.company_id > 0 LIMIT 1)=0) THEN
						INSERT INTO `khuongnhi`.`receipt_months` (`id`, `month`, `year`, `type_receipt`, `sum_amount`, `paid`, `no_cu`, `con_lai`, `created_at`, `updated_at`,`company_id`) VALUES (NULL, MONTH(NEW.date), YEAR(NEW.date), 'distribute', NEW.sum_amount, '0', '0', '0', NOW(), NOW(),NEW.company_id);
					ELSE

						UPDATE `khuongnhi`.`receipt_months` SET 
						`sum_amount`=`sum_amount` - NEW.sum_amount,
						`con_lai`= `sum_amount`+`no_cu`- `paid`
						WHERE  `month` = MONTH(NEW.date)
						AND `year` = YEAR(NEW.date)
						AND `type_receipt` = 'distribute'
						AND `company_id` = NEW.company_id;

					END IF;
				END IF;
				IF(NEW.status =0 AND OLD.status =1) THEN
					UPDATE `khuongnhi`.`receipt_months` SET 
						`sum_amount`=`sum_amount` + OLD.sum_amount,
						`con_lai`= `sum_amount`+`no_cu`- `paid`
						WHERE  `month` = MONTH(OLD.date)
						AND `year` = YEAR(OLD.date)
						AND `type_receipt` = 'distribute'
						AND `company_id` = OLD.company_id;
				END IF;
			END
		");

		DB::unprepared("
			CREATE TRIGGER tr_Update_SO_Receipt_Month AFTER UPDATE ON `saleorders` 
			FOR EACH ROW
			BEGIN
				IF(NEW.status =1 AND OLD.status =0) THEN
					IF(SELECT EXISTS(SELECT 1 FROM receipt_months WHERE month = MONTH(NEW.date) and year = YEAR(NEW.date) and type_receipt='customer'  and `company_id`=NEW.company_id and NEW.company_id > 0 LIMIT 1)=0) THEN
						INSERT INTO `khuongnhi`.`receipt_months` (`id`, `month`, `year`, `type_receipt`, `sum_amount`, `paid`, `no_cu`, `con_lai`, `created_at`, `updated_at`,`company_id`) VALUES (NULL, MONTH(NEW.date), YEAR(NEW.date), 'customer', NEW.sum_amount, '0', '0', NEW.sum_amount, NOW(), NOW(),NEW.company_id);
					ELSE

						UPDATE `khuongnhi`.`receipt_months` SET 
						`sum_amount`=`sum_amount` + NEW.sum_amount,
						`con_lai`= `sum_amount`+`no_cu`- `paid`
						WHERE  `month` = MONTH(NEW.date)
						AND `year` = YEAR(NEW.date)
						AND `type_receipt` = 'customer'
						AND `company_id` = NEW.company_id;

					END IF;
				END IF;
				IF(NEW.status =0 AND OLD.status =1) THEN
					UPDATE `khuongnhi`.`receipt_months` SET 
						`sum_amount`=`sum_amount` - OLD.sum_amount,
						`con_lai`= `sum_amount`+`no_cu`- `paid`
						WHERE  `month` = MONTH(OLD.date)
						AND `year` = YEAR(OLD.date)
						AND `type_receipt` = 'customer'
						AND `company_id` = OLD.company_id;
				END IF;
			END
		");

		DB::unprepared("
			CREATE TRIGGER tr_Update_RSO_Receipt_Month AFTER UPDATE ON `return_saleorders` 
			FOR EACH ROW
			BEGIN
				IF(NEW.status =1 AND OLD.status =0) THEN
					IF(SELECT EXISTS(SELECT 1 FROM receipt_months WHERE month = MONTH(NEW.date) and year = YEAR(NEW.date) and type_receipt='customer'  and `company_id`=NEW.company_id and NEW.company_id > 0 LIMIT 1)=0) THEN
						INSERT INTO `khuongnhi`.`receipt_months` (`id`, `month`, `year`, `type_receipt`, `sum_amount`, `paid`, `no_cu`, `con_lai`, `created_at`, `updated_at`,`company_id`) VALUES (NULL, MONTH(NEW.date), YEAR(NEW.date), 'customer', NEW.sum_amount, '0', '0', '0', NOW(), NOW(),NEW.company_id);
					ELSE

						UPDATE `khuongnhi`.`receipt_months` SET 
						`sum_amount`=`sum_amount` - NEW.sum_amount,
						`con_lai`= `sum_amount`+`no_cu`- `paid`
						WHERE  `month` = MONTH(NEW.date)
						AND `year` = YEAR(NEW.date)
						AND `type_receipt` = 'customer'
						AND `company_id` = NEW.company_id;

					END IF;
				END IF;
				IF(NEW.status =0 AND OLD.status =1) THEN
					UPDATE `khuongnhi`.`receipt_months` SET 
						`sum_amount`=`sum_amount` + OLD.sum_amount,
						`con_lai`= `sum_amount`+`no_cu`- `paid`
						WHERE  `month` = MONTH(OLD.date)
						AND `year` = YEAR(OLD.date)
						AND `type_receipt` = 'customer'
						AND `company_id` = OLD.company_id;
				END IF;
			END
		");
	}
			
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::unprepared('DROP TRIGGER `tr_Create_Company_Address`');
		DB::unprepared('DROP TRIGGER `tr_Delete_Company_Address`');

		DB::unprepared('DROP TRIGGER `tr_Create_PO_Address`');
		DB::unprepared('DROP TRIGGER `tr_Create_SO_Address`');
		DB::unprepared('DROP TRIGGER `tr_Create_RPO_Address`');
		DB::unprepared('DROP TRIGGER `tr_Create_RSO_Address`');

		DB::unprepared('DROP TRIGGER `tr_Delete_PO_Address`');
		DB::unprepared('DROP TRIGGER `tr_Delete_SO_Address`');
		DB::unprepared('DROP TRIGGER `tr_Delete_RPO_Address`');
		DB::unprepared('DROP TRIGGER `tr_Delete_RSO_Address`');

		DB::unprepared('DROP TRIGGER `tr_Create_Mproduct_Productstock`');
		DB::unprepared('DROP TRIGGER `tr_Delete_Mproduct_Productstock`');

		DB::unprepared('DROP TRIGGER `tr_Update_Mproduct_Order`');
		DB::unprepared('DROP TRIGGER `tr_Update_Mproduct_Order_Before`');


		DB::unprepared('DROP TRIGGER `tr_Create_Paid_Receipt_Month`');
		DB::unprepared('DROP TRIGGER `tr_Delete_Paid_Receipt_Month`');


		DB::unprepared('DROP TRIGGER `tr_Update_Paid_Receipt_Month`');
		DB::unprepared('DROP TRIGGER `tr_Update_PO_Receipt_Month`');
		DB::unprepared('DROP TRIGGER `tr_Update_RPO_Receipt_Month`');
		DB::unprepared('DROP TRIGGER `tr_Update_SO_Receipt_Month`');
		DB::unprepared('DROP TRIGGER `tr_Update_RSO_Receipt_Month`');

	}

}
