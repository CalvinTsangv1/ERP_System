<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseRequest extends Model
{
    protected $table = 'purchase_request';
	protected $primaryKey = 'requestID';
	protected $foreignKey = ['branchID'];
	protected $property = ['createdDate', 'expectedDeliveryDate', 'status', 'remarks'];
	public $timestamps=false;
	public $incrementing=false;

	public function dispatchInstructions() {
		return $this->hasMany('App\DispatchInstruction');
	}
	
	public function agreementpriceBreaks() {
		return $this->hasMany('App\AgreementPriceBreak');
	}
	
	public function branch() {
		return $this->belongsTo('App\Branch');
	}
	
	public function purchaseOrder() {
		return $this->hasMany('App\PurchaseOrder');
	}
}
