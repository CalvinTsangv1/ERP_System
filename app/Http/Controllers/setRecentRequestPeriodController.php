<?php

namespace App\Http\Controllers;

use App\Supplier;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\MessageBag;
use Carbon\Carbon;
use Validator;
use Input;
use Session;
use Redirect;
use Illuminate\Http\Request;
use App\PurchaseRequest;
use App\PurchaseRequestItem;
use App\BranchItem;
use App\Item;

class setRecentRequestPeriodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index(){
         
         return View::make('setRecentRequestPeriod.index');
     }
     
     public function findPurchaseRequest(Request $request)
    {
        $newArray = [];
        $class = new setRecentRequestPeriodController;
        
        foreach(PurchaseRequest::whereBetween('createdDate', [$request->from, $request->to])->get() as $key => $value)
        {
            foreach(PurchaseRequestItem::where("requestID", $value->requestID)->get()->pluck("itemID") as $item)
            {
                $itemValue = Item::where("itemID",$item)->first();
                array_push($newArray,[$value->createdDate, $value->requestID,$itemValue->name, $itemValue->description]);
            }
        }
        return View::make("setRecentRequestPeriod.route")->with("purchaseRequestResult", $newArray);
    }
}
