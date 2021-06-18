<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
	protected $table = 'item';
	protected $primaryKey = 'itemID';
	protected $foreignKey = 'categoryID';
	protected $property = ['virtualItemID', 'name', 'unitOfMeasurement', 'description'];
	protected $fillable = ['categoryID','virtualItemID', 'name', 'unitOfMeasurement', 'description'];
	public $timestamps = false;
	
	
	//Item Category
	public function itemCategory() {
		return $this->belongsTo('App\ItemCategory');
	}
	
	//Delivery Note , Delivery Note Item
	public function deliveryNoteItems() {
		return $this->hasMany('App\DeliveryNoteItem');
	}
	
	public function deliveryNotes() {
		return $this->belongsToMany('App\DeliveryNote');
	}
		
	//Dispatch Instruction , Dispatch Instruction Item
	public function dispatchInstructionItems() {
		return $this->hasMany('App\DispatchInstructionItem');	
	}
	
	public function dispatchInstructions() {
		return $this->belongsToMany('App\DispatchInstruction');
	}
	
	//Purchase Request , Purchase Request Item
	public function purchaseRequestItems() {
		return $this->hasMany('App\PurchaseRequestItem');
	}
	
	public function purchaseRequests() {
		return $this->belongsToMany('App\PurchaseRequest');
	}
	
	//Agreement Lines
	public function agreementLines() {
		return $this->hasMany('App\AgreementLine');
	}
	
	//Branch Item , Branch
	public function branchItems() {
		return $this->hasMany('App\BranchItem');
	}
	
	public function branches() {
		return $this->belongsToMany('App\Branch');
	}
	
	//Purchase Order Item , Purchase Order
	public function purchaseOrderItems() {
		return $this->hasMany('App\PurchaseOrderItem');
	}
	
	public function purchaseOrders() {
		return $this->hasMany('App\PurchaseOrder');
	}
	
}
