<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('setRecentRequestPeriod', function(){ return view('setRecentRequestPeriod/index'); })->middleware('auth');

Route::post('setRecentRequestPeriod/route', 'setRecentRequestPeriodController@findPurchaseRequest')->name('setRecentRequestPeriod.route')->middleware('auth');

Route::post('mapPurchaseRequest/execute', 'MapPurchaseRequestController@submitAgreementAndInventory')->name('mapPurchaseRequest.execute')->middleware('auth');

Route::get('/', function () { return view('home'); })->middleware('auth');

Route::get('orders/createorderwithdetails', 'OrderController@createorderwithdetails')->name('orders.createorderwithdetails')->middleware('auth');

Route::post('orders/storewithdetails', 'OrderController@storewithdetails')->name('orders.storewithdetails')->middleware('auth');

Route::resource('orders', 'OrderController')->middleware('auth'); 

Route::resource('orderdetails', 'OrderDetailController')->middleware('auth');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');

Route::resource('itemCategory', 'ItemCategoryController')->middleware('auth');

Route::resource('supplier', 'SupplierController')->middleware('auth');

Route::resource('item', 'ItemController')->middleware('auth');

Route::resource('branchItem', 'BranchItemController')->middleware('auth');

Route::resource('branch', 'BranchController')->middleware('auth');

Route::post('branchItem', 'BranchItemController@index')->name('orders.storewithdetails')->middleware('auth');

Route::resource('agreementLine', 'AgreementLineController')->middleware('auth');

Route::get('agreementHeader/{agreementID}/{revision}/disable', 'AgreementHeaderController@disable')->name('agreementHeader.disable');

Route::resource('agreementHeader', 'AgreementHeaderController')->middleware('auth');

Route::get('agreementHeader/{agreementID}/{revision}/show', 'AgreementHeaderController@show')->name('agreementHeader.show');

Route::get('agreementHeader/{agreementID}/{revision}/edit', 'AgreementHeaderController@edit')->name('agreementHeader.edit');



Route::resource('purchaseRequest', 'PurchaseRequestController')->middleware('auth');



Route::get('agreementPriceBreak/{agreementID}/{revision}/{itemID}/edit', 'AgreementPriceBreakController@edit')->name('agreementPriceBreak.edit');

Route::get('agreementPriceBreak/{agreementID}/{revision}/{itemID}/{priceBreak}/destroy', 'AgreementPriceBreakController@destroy')->name('agreementPriceBreak.destroy');

Route::get('agreementPriceBreak/store', 'AgreementPriceBreakController@store')->name('agreementPriceBreak.store')->middleware('auth');


Route::get('purchaseRequest/createNewPRAndStorewithdetails', 'PurchaseRequestController@createNewPRAndStorewithdetails')->name('purchaseRequest.store')->middleware('auth');

Route::get('purchaseRequest/{requestID}/showDetails', 'PurchaseRequestController@showDetails')->middleware('auth');

Route::resource('purchaseRequestItem', 'PurchaseRequestItemController')->middleware('auth');

Route::get('purchaseRequestItem/destroy/{requestID}/{itemID}', 'PurchaseRequestItemController@destroy')->name('purchaseRequestItem.destroy')->middleware('auth');

Route::get('purchaseRequestItem/edit/{requestID}/{itemID}', 'PurchaseRequestItemController@edit')->name('purchaseRequestItem.edit')->middleware('auth');

Route::get('purchaseRequestItem/{requestID}/{branchID}/show', 'PurchaseRequestItemController@show')->name('purchaseRequestItem.index')->middleware('auth');

Route::get('mapPurchaseRequest/auto', 'MapPurchaseRequestController@auto')->name('mapPurchaseRequest.auto')->middleware('auth');

Route::get('mapPurchaseRequest/auto/{boolean}', 'AutomationSettingController@buttonClick')->name('mapPurchaseRequest.auto')->middleware('auth');

Route::get('mapPurchaseRequest/manual', 'MapPurchaseRequestController@manual')->name('mapPurchaseRequest.manual')->middleware('auth');

Route::get('mapPurchaseRequest/execute/{requestID}/', 'MapPurchaseRequestController@execute')->name('mapPurchaseRequest.execute')->middleware('auth');

Route::post('agreementHeader/storeWithDetails', 'AgreementHeaderController@storeWithDetails')->name('agreementHeader.storewithdetails')->middleware('auth');

Route::get('dispatchInstruction/showDetails/{diNo}/', 'DispatchInstructionController@showDetails')->name('dispatchInstruction.showDetails')->middleware('auth');

Route::resource('dispatchInstruction', 'DispatchInstructionController')->middleware('auth');

Route::get('deliveryNote/create/{diNo}','DeliveryNoteController@create')->middleware('auth');

Route::resource('deliveryNote', 'DeliveryNoteController')->middleware('auth');

Route::get('purchaseOrder/editStatus', 'PurchaseOrderController@editStatus')->middleware('auth');

Route::get('purchaseOrder/createSPO/{requestID}', 'PurchaseOrderController@createSPO' );


Route::get('createSPOWithDetail/{request}','PurchaseOrderController@createSPOWithDetail')->name('purchaseOrder.createSPOWithDetail')->middleware('auth');


Route::resource('purchaseOrder', 'PurchaseOrderController')->middleware('auth');

Route::get('mapPurchaseRequest/temp', 'AutomationPurchaseRequestMappingController@buttonClick')->middleware('auth');;

Route::get('mapPurchaseRequest/edit/{agreementID}/{revision}/{itemID}', 'AgreementPriceBreakController@edit')->middleware('auth');

Route::resource('mapPurchaseRequest','MapPurchaseRequestController')->middleware('auth');

Route::get('purchaseOrder/updateStatus/{poNo}','PurchaseOrderController@updateStatus')->name('purchaseOrder.updateStatus')->middleware('auth');

Route::get('updateStockCount/DI/{requestID}/{diNo}/{dnNo}','UpdateStockCountController@updateStockCountOfDI')->name('updateStockCount/DI')->middleware('auth');

Route::get('updateStockCount/{requestID}/{poNo}','UpdateStockCountController@updateStockCountOfPO')->name('updateStockCount.PO')->middleware('auth');

Route::resource('updateStockCount','UpdateStockCountController')->middleware('auth');


// tempAutomationPurchaseRequestMappingController

