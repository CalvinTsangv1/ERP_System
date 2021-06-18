<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DispatchInstruction extends Model
{
    protected $table = 'dispatch_instruction';
	protected $primaryKey = 'diNo';
	protected $foreignKey = 'requestID';
	protected $property = ['createdDate', 'status'];
	public $incrementing = false;
	public $timestamps = false;

	public function deliveryNotes() {
		return $this->hasMany('App\DeliveryNote');
	}
	
	public function dispatchInstructionItems() {
		return $this->hasMany('App\DispatchInstructionItem');
	}
	
	public function items() {
		return $this->belongsToMany('App\Item');
	}
	
	public function purchaseRequest() {
		return $this->belongsTo('App\PurchaseRequest');
	}
}
