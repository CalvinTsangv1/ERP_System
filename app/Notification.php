<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
	protected $table = 'notification';
	protected $primaryKey = 'messageID';
	protected $foreignKey = 'staffID';
	protected $property = ['timestamp', 'subject', 'content', 'status'];
	protected $isTimestamp = true;

	public function staff() {
		return $this->belongsTo('App\Staff');
	}
}
