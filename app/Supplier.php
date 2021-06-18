<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = 'supplier';
	protected $primaryKey = 'supplierID';
	protected $fillable = ['name', 'contactPerson', 'telephone', 'address'];
	public $timestamps = false;

	public function agreementHeaders() {
		return $this->hasMany('App\AgreementHeader','supplierID','supplierID');
	}
	
	public function PurchaseOrders() {
		return $this->hasMany('App\PurchaseOrder','supplierID','supplierID');
	}
	
	//search by Supplier.supplierID
	//return all information, as supplier table for viewing purpose
	public function getSupplier($supplierID) {
		return Supplier::find($supplierID)->get();
	}
	
	//return information count
	public function getSupplierCount() {
		return Supplier::all()->count();
	}
}
