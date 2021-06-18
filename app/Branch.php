<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $table = 'branch';
	protected $primaryKey = ['branchID'];
	protected $fillable = ['name', 'type', 'telephone', 'address'];
	public $incrementing = false;
	
	
	public function branchItems() {
		return $this->hasMany('App\AgreementLine');
	}
	
	public function items() {
		return $this->belongsToMany('App\Item');
	}
	
	public function users() {
		return $this->hasMany('App\User');
	}
	
	public function staffs() {
		return $this->hasMany('App\Staff');
	}
	
	public function purchaseRequests() {
		return $this->hasMany('App\PurchaseRequest');
	}
}