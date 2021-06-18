<?php

use Illuminate\Database\Seeder;

class AgreementHeaderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$collection = array(
		['agreementID'=>1,  'revision'=>1, 'supplierID'=>10, 'type'=>'Blanket Purchase Agreement',  'createdDate'=>'2019-04-01', 'effectiveDate'=>'2019-04-01', 'expiryDate'=>'2020-03-31', 'status'=>'Expired',  'amountAgreed'=>'100000.00', 'currency'=>'HKD', 'termsAndCondition'=>'COD',          'tentativeSchedule'=>'',        'deliveryAddress'=>'Kerry TC Warehouse 1, 3 Kin Chuen Street, Kwai Chung, Hong Kong'],
		['agreementID'=>2,  'revision'=>1, 'supplierID'=>9,  'type'=>'Blanket Purchase Agreement',  'createdDate'=>'2019-06-01', 'effectiveDate'=>'2019-06-01', 'expiryDate'=>'2020-05-31', 'status'=>'Expired',  'amountAgreed'=>'100000.00', 'currency'=>'HKD', 'termsAndCondition'=>'COD',          'tentativeSchedule'=>'',        'deliveryAddress'=>'Kerry TC Warehouse 1, 3 Kin Chuen Street, Kwai Chung, Hong Kong'],
		['agreementID'=>3,  'revision'=>1, 'supplierID'=>8,  'type'=>'Planned Purchase Agreement',  'createdDate'=>'2019-08-01', 'effectiveDate'=>'2019-08-01', 'expiryDate'=>'2020-07-31', 'status'=>'Active',   'amountAgreed'=>'100000.00', 'currency'=>'HKD', 'termsAndCondition'=>'2% 10 Net 30', 'tentativeSchedule'=>'Weekly',  'deliveryAddress'=>'Kerry TC Warehouse 1, 3 Kin Chuen Street, Kwai Chung, Hong Kong'],
		['agreementID'=>4,  'revision'=>1, 'supplierID'=>7,  'type'=>'Blanket Purchase Agreement',  'createdDate'=>'2019-10-01', 'effectiveDate'=>'2019-10-01', 'expiryDate'=>'2020-09-30', 'status'=>'Active',   'amountAgreed'=>'100000.00', 'currency'=>'USD', 'termsAndCondition'=>'COD',          'tentativeSchedule'=>'',        'deliveryAddress'=>'Kerry TC Warehouse 1, 3 Kin Chuen Street, Kwai Chung, Hong Kong'],
		['agreementID'=>5,  'revision'=>1, 'supplierID'=>6,  'type'=>'Blanket Purchase Agreement',  'createdDate'=>'2019-12-01', 'effectiveDate'=>'2019-12-01', 'expiryDate'=>'2020-11-30', 'status'=>'Active',   'amountAgreed'=>'100000.00', 'currency'=>'HKD', 'termsAndCondition'=>'2% 10 Net 30', 'tentativeSchedule'=>'',        'deliveryAddress'=>'Kerry TC Warehouse 1, 3 Kin Chuen Street, Kwai Chung, Hong Kong'],
		['agreementID'=>6,  'revision'=>1, 'supplierID'=>5,  'type'=>'Blanket Purchase Agreement',  'createdDate'=>'2020-02-01', 'effectiveDate'=>'2020-02-01', 'expiryDate'=>'2021-01-31', 'status'=>'Active',   'amountAgreed'=>'100000.00', 'currency'=>'CNY', 'termsAndCondition'=>'Net 30',       'tentativeSchedule'=>'',        'deliveryAddress'=>'Kerry TC Warehouse 1, 3 Kin Chuen Street, Kwai Chung, Hong Kong'],
		['agreementID'=>7,  'revision'=>1, 'supplierID'=>4,  'type'=>'Contract Purchase Agreement', 'createdDate'=>'2020-04-01', 'effectiveDate'=>'2020-04-01', 'expiryDate'=>'2021-03-31', 'status'=>'Active',   'amountAgreed'=>'100000.00', 'currency'=>'HKD', 'termsAndCondition'=>'COD',          'tentativeSchedule'=>'',        'deliveryAddress'=>'Kerry TC Warehouse 1, 3 Kin Chuen Street, Kwai Chung, Hong Kong'],
		['agreementID'=>8,  'revision'=>1, 'supplierID'=>3,  'type'=>'Planned Purchase Agreement',  'createdDate'=>'2020-06-01', 'effectiveDate'=>'2020-06-01', 'expiryDate'=>'2021-05-30', 'status'=>'Active',   'amountAgreed'=>'100000.00', 'currency'=>'HKD', 'termsAndCondition'=>'1% 10 Net 30', 'tentativeSchedule'=>'Monthly', 'deliveryAddress'=>'Kerry TC Warehouse 1, 3 Kin Chuen Street, Kwai Chung, Hong Kong'],
		['agreementID'=>9,  'revision'=>1, 'supplierID'=>2,  'type'=>'Blanket Purchase Agreement',  'createdDate'=>'2020-08-01', 'effectiveDate'=>'2020-08-01', 'expiryDate'=>'2021-10-30', 'status'=>'Inactive', 'amountAgreed'=>'100000.00', 'currency'=>'USD', 'termsAndCondition'=>'COD',          'tentativeSchedule'=>'',        'deliveryAddress'=>'Kerry TC Warehouse 1, 3 Kin Chuen Street, Kwai Chung, Hong Kong'],
		['agreementID'=>10, 'revision'=>1, 'supplierID'=>9,  'type'=>'Planned Purchase Agreement', 'createdDate'=>'2020-07-01', 'effectiveDate'=>'2020-07-01', 'expiryDate'=>'2021-09-30', 'status'=>'Active', 'amountAgreed'=>'100000.00', 'currency'=>'HKD', 'termsAndCondition'=>'COD',          'tentativeSchedule'=>'Monthly',        'deliveryAddress'=>'Kerry TC Warehouse 1, 3 Kin Chuen Street, Kwai Chung, Hong Kong'],
	    ['agreementID'=>11, 'revision'=>1, 'supplierID'=>9,  'type'=>'Blanket Purchase Agreement', 'createdDate'=>'2020-07-01', 'effectiveDate'=>'2020-07-01', 'expiryDate'=>'2021-09-30', 'status'=>'Active', 'amountAgreed'=>'100000.00', 'currency'=>'HKD', 'termsAndCondition'=>'COD',          'tentativeSchedule'=>'',        'deliveryAddress'=>'Kerry TC Warehouse 1, 3 Kin Chuen Street, Kwai Chung, Hong Kong'],
	    ['agreementID'=>12, 'revision'=>1, 'supplierID'=>9,  'type'=>'Blanket Purchase Agreement', 'createdDate'=>'2020-07-01', 'effectiveDate'=>'2020-07-01', 'expiryDate'=>'2021-09-30', 'status'=>'Active', 'amountAgreed'=>'100000.00', 'currency'=>'HKD', 'termsAndCondition'=>'COD',          'tentativeSchedule'=>'',        'deliveryAddress'=>'Kerry TC Warehouse 1, 3 Kin Chuen Street, Kwai Chung, Hong Kong'],
	);
		
		for($i=0; $i<count($collection); $i++) {
			//for debug input data error
			//print_r(Arr::get($collection,$i));
			DB::table('agreement_header')->insert([Arr::get($collection,$i)]);
		}
    }
}
