<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $table = 'staff';
	protected $primaryKey = ['staffID'];
	protected $foreignKey = ['branchID'];
	protected $property = ['name', 'postTitle', 'password'];
	
	public function notifications() {
		return $this->hasMany('App\Notification');
	}
	
	public function branch() {
		return $this->belongsTo('App\Branch');
	}
}
