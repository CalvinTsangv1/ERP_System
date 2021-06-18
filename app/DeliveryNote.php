<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliveryNote extends Model
{
    protected $table = 'delivery_note';
	protected $primaryKey = 'dnNo';
	protected $foreignKey = ['diNo'];
	protected $property = ['createdDate', 'status'];
	public $timestamps = false;

	public function deliveryNoteItems() {
		return $this->hasMany('App\DeliveryNoteItem');
	}
	
	public function Items() {
		return $this->belongsToMany('App\Item');
	}
	
	public function dispatchInstruction() {
		return $this->belongsTo('App\DispatchInstruction');
	}
}
