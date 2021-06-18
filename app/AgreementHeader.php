<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class AgreementHeader extends Model
{
    protected $table = 'agreement_header';
	protected $primaryKey = ['agreementID','revision'];
	protected $foreignKey = 'supplierID';
	protected $property = ['type', 'createdDate', 'effectiveDate', 'expiryDate', 'status', 'amountAgreed', 'currency', 'termsAndCondition', 'tentativeSchedule', 'deliveryAddress'];
	public $incrementing = false;
	public $timestamps=false;


	public function agreementLines() {
		return $this->hasMany('App\AgreementLine',['agreementID','revision'],['agreementID','revision']);
	}
	
	public function PurchaseOrders() {
		return $this->hasMany('App\PurchaseOrders',['agreementID','revision','supplierID'],['agreementID','revision','supplierID']);
	}
	    
		//     /**
		//  * Set the keys for a save update query.
		//  *
		//  * @param  \Illuminate\Database\Eloquent\Builder  $query
		//  * @return \Illuminate\Database\Eloquent\Builder
		//  */
		// protected function setKeysForSaveQuery(Builder $query)
		// {
		//     $keys = $this->getKeyName();
		//     if(!is_array($keys)){
		//         return parent::setKeysForSaveQuery($query);
		//     }
		
		//     foreach($keys as $keyName){
		//         $query->where($keyName, '=', $this->getKeyForSaveQuery($keyName));
		//     }
		
		//     return $query;
		// }
		
		// /**
		//  * Get the primary key value for a save query.
		//  *
		//  * @param mixed $keyName
		//  * @return mixed
		//  */
		// protected function getKeyForSaveQuery($keyName = null)
		// {
		//     if(is_null($keyName)){
		//         $keyName = $this->getKeyName();
		//     }
		
		//     if (isset($this->original[$keyName])) {
		//         return $this->original[$keyName];
		//     }
		
		//     return $this->getAttribute($keyName);
		// }
			

	
}
