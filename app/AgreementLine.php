<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AgreementLine extends Model
{
    protected $table = 'agreement_line';
	protected $primaryKey = ['agreementID','revision', 'itemID'];
	protected $foreignKey = ['agreementID','revision', 'itemID'];
	protected $property = ['promisedQuantity', 'balance', 'minimumOrderQuantity', 'price', 'reference'];
	public $timestamps = false;
	public $incrementing = false;

	public function agreementHeader() {
		return $this->belongsTo('App\AgreementHeader',['agreementID','revision']);
	}
	
	public function agreementPriceBreaks() {
		return $this->hasMany('App\AgreementPriceBreak',$primaryKey,$foreignKey);
	}
	
	//search by AgreementLine.itemID
	// return ('itemID', 'promisedQuantity', 'balance', 'minimumOrderQuantity', 'price', 'reference')
	public function getItemList($itemID) {
		return AgreementLine::select($attributes[2], $attributes[3], $attributes[4], 
							$attributes[5], $attributes[6], $attributes[7])->where('itemID','=',$itemID)->get();
	}
	
	//search by AgreementLine.itemID
	// public function getAgreementLineBy{
	// 	//
	// }
}

