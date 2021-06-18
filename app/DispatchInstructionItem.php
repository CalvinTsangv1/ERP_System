<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DispatchInstructionItem extends Model
{
    protected $table = 'dispatch_instruction_item';
	protected $primaryKey = ['diNo','itemID'];
	protected $foreignKey = ['diNo','itemID'];
	protected $property = ['quantity', 'balance'];
	public $incrementing = false;
	public $timestamps = false;

	public function dispatchInstruction() {
		return $this->belongsTo('App\DispatchInstruction');
	}
	
	public function item() {
		return $this->belongsTo('App\Item');
	}
}
