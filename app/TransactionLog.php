<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionLog extends Model
{
    protected $table = 'transaction_log';
	protected $primaryKey = ['logID'];
	protected $property = ['timestamp', 'action'];
}
