<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderItem extends Model
{
    protected $table = 'purchase_order_item';
	protected $primaryKey = ['poNo','itemID'];
	protected $foreignKey = ['poNo','itemID'];
	protected $property = ['quantity', 'amount', 'balance'];
	public $incrementing = false; 
	public $timestamps = false;
	
	public function item() {
		return $this->belongsTo('App\Item');
	}
	
	public function purchaseOrder() {
		return $this->belongsTo('App\PurchaseOrder');
	}
}
