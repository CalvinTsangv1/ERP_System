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
use App\Http\Controllers\UpdateStockCountController;
use App\PurchaseOrder;
use App\DeliveryNote;
use App\BranchItem;
use App\PurchaseOrderItem;
use App\PurchaseRequestItem;
use App\PurchaseRequest;
use App\DispatchInstructionItem;
use App\DispatchInstruction;

class UpdateStockCountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$purchaseOrder=PurchaseOrder::where('status', '=', 'Pending for Delivery')->get();
    	$deliveryNote=DeliveryNote::where('status', '=', 'Pending for Delivery')->get();
    	return View::make('updateStockCount.index')->with('purchaseOrder', $purchaseOrder) 
												   ->with('deliveryNote', $deliveryNote);
    }
    
    public function updateStockCountOfPO($requestID, $poNo){
        $purchaseOrderItem=PurchaseOrderItem::where('poNo', $poNo)->get();
	    $requestID=PurchaseOrder::where('poNo', $poNo)->first()->requestID;
	    $branchID=self::getBranchID($requestID);
	    
	    foreach($purchaseOrderItem as $key =>$value){
	        if(self::checkBranchItem($branchID, $value->itemID)){
	            $existBranchItem = BranchItem::where('branchID', $branchID)->where('itemID', $value->itemID)->first();
	            $totalQty = $existBranchItem->quantity + $value->quantity;
	            $existBranchItem = BranchItem::where('branchID',$branchID)->where('itemID',$value->itemID)->update(['quantity'=>$totalQty]);
            }else{
                $branchItem =new BranchItem;
                $branchItem->branchID = $branchID;
                $branchItem->itemID = $value->itemID;
                $branchItem->quantity= $value->quantity;
                $branchItem->lowStockLevel = 0;
                $branchItem->save();
            }
        }
        
        $purchaseOrderItem = PurchaseOrderItem::where('poNo', $poNo)->get();
        $checkPOItem = true;
        
        foreach($purchaseOrderItem as $key =>$value){
            if($value->balance != 0)
                $checkPOItem == false;
        }
    	
    	$purchaseRequestItem = PurchaseRequestItem::where('requestID', $requestID)->get();
    	$checkPRItem = true;
    	
    	foreach($purchaseRequestItem as $key =>$value){
    	    if($value->balance != 0)
    	        $checkPRItem == false;
    	}
    	
    	if($checkPOItem == true){
    	    $purchaseOrder=PurchaseOrder::where('poNo', $poNo)->update(['status' => 'Pending for Payment']);
        }else if($checkPRItem == true){
            $purchaseRequest=PurchaseRequest::where('requestID', $requestID)->update(['status' => 'Completed']);
        }
        return back()->with('success','Successfully');
    }
    
    public function updateStockCountOfDI($requestID, $diNo, $dnNo){
        
        $dispatchInstructionItem = DispatchInstructionItem::where('diNo', $diNo)->get();
    	$requestID = DispatchInstruction::where('diNo', $diNo)->first()->requestID;
    	$branchID = self::getBranchID($requestID);
    	
    	foreach($dispatchInstructionItem as $key => $value){
    	    
    	    if(self::checkBranchItem($branchID, $value->itemID)){
    	        $existBranchItem = BranchItem::where('branchID', $branchID)->where('itemID', $value->itemID)->first();
    	        $totalQty = $existBranchItem->quantity + $value->quantity;
    	        $existBranchItem = BranchItem::where('branchID', $branchID)->where('itemID',$value->itemID)->update(['quantity'=>$totalQty]);
            }else{
                $branchItem = new BranchItem;
                $branchItem->branchID = $branchID;
                $branchItem->itemID = $value->itemID;
                $branchItem->quantity= $value->quantity;
                $branchItem->lowStockLevel = 0;
                $branchItem->save();
            }
            
            $dispatchInstructionItem = DispatchInstructionItem::where('diNo', $diNo)->where('itemID', $value->itemID)->first();
            $qtyAfterDeduct = $dispatchInstructionItem->quantity - $value->quantity;
            $dispatchInstructionItem = DispatchInstructionItem::where('diNo', $diNo)->where('itemID', $value->itemID)->update(['quantity' => $qtyAfterDeduct]);
    	}
    	
    	$dispatchInstruction = DispatchInstruction::where('diNo', $diNo)->get();
    	
    	$dispatchInstruction = DispatchInstruction::where('diNo', $diNo)->update(['status' => 'Completed']);
    	$purchaseRequest = PurchaseRequest::where('requestID', $requestID)->update(['status' => 'Completed']);
    	$deliveryNote = DeliveryNote::where('diNo', $diNo)->where('dnNo', $dnNo)->update(['status'=>'Delivered']);
    	
    	return back()->with('success','Successfully');
    }
    
    public function getBranchID($requestID){
    	return PurchaseRequest::where('requestID', $requestID)->first()->branchID;
    }
    
    public function checkBranchItem($branchID,$itemID){
	
	    $checkBranchItem=BranchItem::where('branchID',$branchID)->get();
    	
    	foreach($checkBranchItem as $key => $value){
    	    if($value->itemID == $itemID){
    	        return true;
    	    }
    	}
    	return false;
    }
}
