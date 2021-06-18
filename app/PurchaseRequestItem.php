<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseRequestItem extends Model
{
    protected $table = 'purchase_request_item';
	protected $primaryKey = ['requestID','itemID'];
	protected $foreignKey = ['requestID','itemID'];
	protected $property = ['quantity', 'balance'];
	public $timestamps=false;
	public $incrementing=false;

	public function purchaseRequest() {
		return $this->belongsTo('App\PurchaseRequest');
	}

	public function branch() {
		return $this->belongsTo('App\Branch');
	}

}
