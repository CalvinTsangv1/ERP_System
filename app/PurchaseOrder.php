<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    protected $table = 'purchase_order';
	protected $primaryKey = 'poNo';
	protected $foreignKey = ['requestID', 'agreementID', 'revision', 'supplierID'];
	protected $property = ['releaseNo', 'type', 'status', 'quotationNo', 'createdDate', 'account', 'shipmentAddress'];
	public $incrementing = true; 
	public $timestamps = false;

	public function agreementHeader() {
		return $this->belongsTo('App\AgreementHeader');
	}
	
	public function PurchaseRequest() {
		return $this->belongsTo('App\PurchaseRequest','requestID');
	}
	
	public function Supplier() {
		return $this->belongsTo('App\Supplier','supplierID');
	}
	
	public function purchaseOrderItems() {
		return $this->hasMany('App\PurchaseOrderItem', 'poNo', 'poNo');
	}
}
