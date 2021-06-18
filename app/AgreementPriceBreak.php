<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AgreementPriceBreak extends Model
{
    protected $table = 'agreement_price_break';
	protected $primaryKey = ['agreementID','revision', 'itemID', 'priceBreak'];
	protected $foreignKey = ['agreementID','revision', 'itemID'];
	protected $property = ['discount'];
	public $timestamps = false;
	public $incrementing = false;

	public function agreementLine() {
		return $this->belongsTo('App\AgreementLine', ['agreementID','revision','itemID']);
	}
}
