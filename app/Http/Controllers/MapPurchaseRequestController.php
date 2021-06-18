<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\MessageBag;
use Carbon\Carbon;
use Validator;
use Input;
use Session;
use Redirect;
use App\PurchaseRequestItem;
use App\PurchaseRequest;
use App\Item;
use App\BranchItem;
use App\Branch;
use App\AgreementLine;
use App\AgreementHeader;
use App\PurchaseOrder;
use App\PurchaseOrderItem;
use App\AgreementPriceBreak;
use App\DispatchInstruction;
use App\DispatchInstructionItem;
use App\Http\Controllers\AutomationSettingController;

class MapPurchaseRequestController extends Controller
{
    
    
    public function auto(){
        
        return View::make('mapPurchaseRequest.auto');
    }
    
    
    public function manual(){
        
        return View::make('mapPurchaseRequest.manual');
    }
    
    public function execute($requestID){
        $agreementHeaderList = [];
        $branchList= [];
        
        $purchaseRequestItem = PurchaseRequestItem::where('requestID',$requestID)->where('balance', '<>', 0)->get();
		$purchaseRequest= PurchaseRequest::where('requestID',$requestID)->first();
		foreach( $purchaseRequestItem as $key => $value) {
		    foreach( AgreementLine::where("itemID", $value->itemID)->pluck("agreementID") as $agreementID) {
		        array_push($agreementHeaderList, [ $value->itemID => AgreementHeader::where("agreementID", $agreementID)->where("status", "Active")->where("expiryDate", ">", Carbon::now())->get()]);
		    }
		    $warehouse = Branch::where("name","Warehouse")->pluck("branchID")[0];
		    $BranchItem = BranchItem::where("itemID", $value->itemID)->where("branchID", $warehouse);
            if($BranchItem->exists() ) {
                if($BranchItem->first()->quantity > 0) {
		            array_push($branchList, $BranchItem->first());
                }
            }
		} 
		
		$list = [];
		
		foreach($agreementHeaderList as $key => $value) {
		    foreach($value as $keyValue => $listing) {
		        foreach($listing as $agreement) {
		            $agreementLine = AgreementLine::where('agreementID', $agreement->agreementID)->where('revision', $agreement->revision)->where('itemID', $keyValue);
		             if($agreementLine->exists() ) {
		                if($agreementLine->first()->balance > 0) {
		                    array_push($list, ["agreementID" =>$agreement->agreementID, "revision" => $agreement->revision, "type" => $agreement->type, "itemID" => $keyValue, "balance" => $agreementLine->first()->balance, "price" => $agreementLine->first()->price]);
		                }
		            }
		        }
		    }
		}
		
		
        return View::make('mapPurchaseRequest.execute')->with('purchaseRequestItem',$purchaseRequestItem)->with('purchaseRequest',$purchaseRequest)->with('agreementHeaderList', $list)->with('branchList', $branchList);
    }
    
    //set all value when submit lists and values
    public function submitAgreementAndInventory(Request $request) {
        $agreementList = [];
        $branchList= [];

        $requestID = $request->requestID;
        $agreementQuantity = $request->agreementQuantity;
        $agreementID = $request->agreementID;
        $agreementRevision = $request->agreementRevision;
        $agreementItemID = $request->agreementItemID;
        
        $branchQuantity = $request->branchQuantity;
        $branchID = $request->branchID;
        $branchItemID = $request->branchItemID;
        

        if($agreementQuantity != null) {
            for($item = 0; $item < count($agreementQuantity); $item++) {
                if($agreementQuantity[$item] != null) {
                    if($this->agreementValidation($agreementID[$item], $agreementRevision[$item],  $agreementItemID[$item], $agreementQuantity[$item]) == false) {
                         return back()->withErrors('Your purchase quantity is larger than agreement quantity');
                    }
                    array_push($agreementList, ["agreementID" => $agreementID[$item], "revision" => $agreementRevision[$item], "itemID" => $agreementItemID[$item], "quantity" => $agreementQuantity[$item]]);
                }
            }
        }
        
        if($branchQuantity != null) {
            for($item = 0; $item < count($branchQuantity); $item++) {
                if($branchQuantity[$item] != null) {
                    if($this->inventoryValidation($branchID, $branchItemID[$item], $branchQuantity[$item]) == false) {
                        return back()->withErrors("Your purchase quantity is larager than inventory quantity");
                    }
                    array_push($branchList, ["branchID" => $branchID, "itemID" => $branchItemID[$item], "quantity" => $branchQuantity[$item]]);
                }
            }
        }
     
        
        // get BranchList / AgreementList and process the list quantity by itemID
        // After, update agreementList and BranchList
        
        foreach(PurchaseRequestItem::where("requestID", $requestID)->get() as $key) {
            $id = $key->itemID;
            $totalQuantity = 0;
            foreach($agreementList as $value) {
                if($value['itemID'] == $id) {
                    $totalQuantity = $totalQuantity + $value['quantity'];
                }
            }
            foreach($branchList as $value) {
                if($value['itemID'] == $id) {
                    $totalQuantity = $totalQuantity + $value['quantity'];
                }
            }
            if(PurchaseRequestItem::where("requestID", $requestID)->where("itemID", $id)->first()->balance < $totalQuantity) {
                return back()->withErrors('Your purchase total quantity is larger than [ inventory quantity, agreement quantity ].');
            }
        }
        
        foreach($agreementList as $value) {
            $this->processPurchaseOrder($value['agreementID'], $requestID, $value['revision'], $value['itemID'], $branchID, (int)$value['quantity']);
        }
        
        foreach($branchList as $value) {
            $this->processInventory($requestID, $value["branchID"], $value["itemID"], $value["quantity"]);
        }
                
        return back()->with('success',"Successfully Mapped ");
    }
    
    public function processPurchaseOrder($agreementID, $requestID, $revision, $itemID, $branchID, $quantity) {
        
        
        $agreementHeader = AgreementHeader::where("agreementID", $agreementID)->where("revision", $revision)->first();
        $agreementLine = AgreementLine::where("agreementID", $agreementID)->where("revision", $revision)->where("itemID", $itemID)->first();
        $poNo = (int)PurchaseOrder::orderBy("poNo", "desc")->first()->poNo + 1;
        $purchaseOrder = new PurchaseOrder;
        $purchaseOrder->poNo = $poNo;
        $purchaseOrder->requestID = $requestID;
        $purchaseOrder->agreementID = $agreementID;
        $purchaseOrder->revision = $revision;
        $purchaseOrder->releaseNo = (int)PurchaseOrder::where("agreementID", $agreementID)->count() + 1;
        $purchaseOrder->supplierID =$agreementHeader->supplierID;
        switch($agreementHeader->type) {
            case "Blanket Purchase Agreement":
                $purchaseOrder->type = "Blanket Purchase Release";
                break;
            case "Planned Purchase Agreement":
                $purchaseOrder->type = "Planned Purchase Release";
                break;
            case "Contract Purchase Agreement":
                $purchaseOrder->type = "Standard Purchase Order";
                break;
        }
        $purchaseOrder->status = "Pending for Delivery";
        $purchaseOrder->quotationNo = 0;
        $purchaseOrder->createdDate = Carbon::now();
        $purchaseOrder->account = 0;
        $purchaseOrder->shipmentAddress = Branch::where('branchID', $branchID)->first()->address;
        $purchaseOrder->save();
        
        $purchaseOrderItem = new PurchaseOrderItem;
        $purchaseOrderItem->poNo = $poNo;
        $purchaseOrderItem->itemID = $itemID;
        $purchaseOrderItem->quantity = $quantity;
        $purchaseOrderItem->balance = $quantity;
        $priceBreak = AgreementPriceBreak::where('agreementID', $agreementID)->where('revision', $revision)->where('itemID', $itemID)->where('priceBreak', '<=', $quantity)->orderBy('priceBreak','desc')->first();
        if($priceBreak != null)
        {
            $purchaseOrderItem->amount = $quantity * (int)$agreementLine->price * (int)$priceBreak->discount;
        }else {
            $purchaseOrderItem->amount = $quantity * (int)$agreementLine->price;
        }
        $purchaseOrderItem->save();
        
        $this->updateAgreementLine($agreementLine, $agreementID, $revision, $itemID, $quantity);
        $this->updatePurchaseRequest($requestID, $itemID, $quantity);
    }
    
    public function updateAgreementLine($agreementLine, $agreementID, $revision, $itemID, $quantity) {
        $amount = (int)$agreementLine->balance - $quantity;
        AgreementLine::where("agreementID", $agreementID)->where("revision", $revision)->where("itemID", $itemID)->update(["balance"=>$amount]);
    }
    
    public function processInventory($requestID, $branchID, $itemID, $quantity)
    {
        $warehouse = Branch::where("name","Warehouse")->pluck("branchID")[0];
        $currentQuantity = (int)BranchItem::where("branchID", $warehouse)->where("itemID", $itemID)->first()->quantity -(int)$quantity;
        BranchItem::where("branchID", $warehouse)->where("itemID", $itemID)->update(["quantity"=>$currentQuantity]);
        $this->updateDispatchInstruction($requestID, $itemID, $quantity);
        $this->updatePurchaseRequest($requestID, $itemID, $quantity);
    }
    
    public function updateDispatchInstruction($requestID, $itemID, $quantity) {
        
        $diNo = (int)DispatchInstruction::orderBy("diNo", "desc")->first()->diNo + 1;
        $dispatchInstruction = new DispatchInstruction;
        $dispatchInstruction->diNo = $diNo;
        $dispatchInstruction->requestID = $requestID;
        $dispatchInstruction->createdDate = Carbon::now();
        $dispatchInstruction->status = "Incomplete";
        $dispatchInstruction->save();
        
        $dispatchInstructionItem = new DispatchInstructionItem;
        $dispatchInstructionItem->diNo = $diNo;
        $dispatchInstructionItem->itemID = $itemID;
        $dispatchInstructionItem->quantity = $quantity;
        $dispatchInstructionItem->balance = $quantity;
        $dispatchInstructionItem->save();
    }
    
    public function updatePurchaseRequest($requestID, $itemID, $quantity) {
        $balance = (int)PurchaseRequestItem::where("requestID", $requestID)->where("itemID", $itemID)->first()->balance;
        $balance = $balance - $quantity;
        PurchaseRequestItem::where("requestID", $requestID)->where("itemID", $itemID)->update(["balance"=>$balance]);
        $checkingBalance = true;
        foreach(PurchaseRequestItem::where("requestID", $requestID)->pluck("balance") as $value)
        {
            if($value > 0) {
                $checkingBalance = false;
            }
        }
        if($checkingBalance) {
            PurchaseRequest::where("requestID", $requestID)->update(["status"=>"Pending for delivery"]);
        }
    }
    
    public function agreementValidation($agreementID, $revision, $itemID, $quantity) {
        if( AgreementLine::where("agreementID", $agreementID)->where("revision", $revision)->where("itemID", $itemID)->first()->balance >= $quantity) {
            return true;
        }
        return false;
    }
    
    public function inventoryValidation($branchID, $itemID, $quantity) {
        $warehouse = Branch::where("name","Warehouse")->pluck("branchID")[0];
        if(BranchItem::where("branchID", $warehouse)->where("itemID", $itemID)->first()->quantity >= $quantity) {
            return true;
        }
        return false;
    } 
    
}
