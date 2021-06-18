<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemCategory extends Model
{
    protected $table = 'item_category';
	protected $primaryKey = 'categoryID';
	protected $foreignKey = 'parentCategoryID';
	protected $fillable = ['categoryID', 'categoryName', 'parentCategoryID'];
	public $timestamps = false;
	
	public function items() {
		return $this->hasMany('App\Item', 'parentCategoryID', 'categoryID');
	}
	
	public function itemCategory() {
		return $this->hasOne('App\ItemCategory', 'parentCategoryID');
	}
	
	public function parentItemCategory() {
		return $this->hasOne(ItemCategory::class, 'parentCategoryID')->with('itemCategory');
	}
}
