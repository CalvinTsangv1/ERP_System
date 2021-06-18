<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class BranchItem extends Model
{
    protected $table = 'branch_item';
	protected $primaryKey = ['branchID', 'itemID'];
	protected $foreignKey = ['branchID', 'itemID'];
	protected $property = ['quantity', 'lowStockLevel'];
	public $incrementing = false;
	public $timestamps = false;

	public function branch() {
		return $this->belongsTo('App\Branch');
	}
	
	public function item() {
		return $this->belongsTo('App\Item');
	}
}
