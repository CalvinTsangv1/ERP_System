<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders'; // Define the table name
    protected $primaryKey = 'orderid'; // Define the primary key column name
    public $timestamps = false; // Disable Eloquent timestamps function
    protected $fillable = ['regno', 'regstate', 'custname','custphone', 
                           'vehbrand', 'vehmodel', 'vehyear',
                           'createddate', 'orderstatus', 'serialno']; // Mass assignment white-list
                               // Retrieve the order details of the order 
    public function orderdetails() {
        return $this->hasMany('App\OrderDetail', 'orderid', 'orderid')
        ; } 
}
