<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Customer;
use App\Transaction;
use App\Receiving;
use App\ReceivingTemp;
use App\ReceivingItem;
use App\Inventory;
use App\Supplier;
use App\Item;
use App\Http\Requests\CustomerRequest;
use App\Http\Requests\ReceivingRequest;
use \Auth, \Redirect, \Validator, \Input, \Session;
use Illuminate\Http\Request;

class ReceivingController extends Controller {

	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
			$receivings = Receiving::orderBy('id', 'desc')->first();
			$customers = Customer::where('customer_type', '=', 1)->orwhere('customer_type', '=', 2)->lists('name', 'id','company_name');
			return view('receiving.index')
				->with('receiving', $receivings)
				->with('customer', $customers);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(ReceivingRequest $request)
	{
		    $receivings = new Receiving;
            $receivings->customer_id = Input::get('supplier_id');
            
            $receivings->user_id = Auth::user()->id;
            $receivings->payment_type = Input::get('payment_type');
            $receivings->comments = Input::get('comments');
             $receivings->sales_man = Input::get('sales_man');
             $receivings->branch = Input::get('branch');
        $receivings->store = Input::get('store');
        $receivings->reserved = (Input::has('reserved')) ? true : false;
        $receivings->visacard = (Input::has('visa')) ? true : false;
        $receivings->deposit = Input::get('deposit');
        $receivings->amount_due = Input::get('amount_due');
        $receivings->total = Input::get('total');
        $receivings->creditor = Input::get('creditor');
        $receivings->debtor = Input::get('debtor');
            $receivings->save();


 //process transaction

			$transactions = new Transaction;
		 		
   	   	    $transactions->customer_id = $receivings->customer_id;
			$transactions->amount = $receivings->deposit;
			$transactions->remarks = 'مشتريات';
			$transactions->invoice_id=$receivings->id;
			$transactions->debtor = $receivings->debtor;
			$transactions->creditor = $receivings->creditor;
			$transactions->total = $receivings->total;
			$transactions->save();


//process customers transaction
			$customers = Customer::find($receivings->customer_id);
	            $customers->sum_debtor= $customers->sum_debtor + $receivings->debtor;
	            $customers->sum_creditor= $customers->sum_creditor + $receivings->creditor;

	            $customers->net_debtor= $customers->sum_debtor - $customers->sum_creditor;
	            $customers->net_creditor= $customers->sum_creditor - $customers->sum_debtor;
                
                if($customers->net_creditor<0)
	            	$customers->net_creditor=0;
	            else
                   $customers->net_debtor=0;


	            $customers->save();



            // process receiving items
            $receivingItems = ReceivingTemp::all();
			foreach ($receivingItems as $value) {
				$receivingItemsData = new ReceivingItem;
				$receivingItemsData->receiving_id = $receivings->id;
				$receivingItemsData->item_id = $value->item_id;
				$receivingItemsData->cost_price = $value->cost_price;
				$receivingItemsData->quantity = $value->quantity;
				
			
			$receivingItemsData->metres_w = $value->metres_w;
			$receivingItemsData->metres_h = $value->metres_h;
			$receivingItemsData->metres_square = $value->metres_square;
			$receivingItemsData->totalmetres_square = $value->totalmetres_square;
			$receivingItemsData->totalmetres_h = $value->totalmetres_h;
			$receivingItemsData->discount = $value->discount;
			$receivingItemsData->total_prediscount = $value->total_prediscount;
			$receivingItemsData->total_cost = $value->total_cost;
			$receivingItemsData->selling_price = $value->selling_price;
			$receivingItemsData->total_selling = $value->total_selling;
				$receivingItemsData->save();






				//process inventory
				$items = Item::find($value->item_id);
					$inventories = new Inventory;
				$inventories->item_id = $value->item_id;
				$inventories->user_id = Auth::user()->id;
                $inventories->totalmetres_square = $receivingItemsData->totalmetres_square;
                $inventories->totalmetres_h = $receivingItemsData->metres_h * $receivingItemsData->quantity;
				$inventories->in_out_qty = $value->quantity;
				$inventories->remarks = 'مشتريات';
				$inventories->invoice_id = $receivings->id;
				$inventories->branch = $receivings->branch;
                $inventories->store = $receivings->store;

				$inventories->save();
				//process item quantity
	            $items->quantity = $items->quantity + $value->quantity;
	            $items->totalmetres_square = $items->totalmetres_square + $value->totalmetres_square;
	            $items->totalmetres_h = $items->totalmetres_h + $value->totalmetres_h;
	            $items->save();
			}
			//delete all data on ReceivingTemp model
			ReceivingTemp::truncate();
			$itemsreceiving = ReceivingItem::where('receiving_id', $receivingItemsData->receiving_id)->get();
            Session::flash('message', 'تمت عملية الشراء بنجاح');
            $customers = Customer::find($receivings->customer_id);
            //return Redirect::to('receivings');
            return view('receiving.complete')
            	->with('receivings', $receivings)
            	->with('receivingItemsData', $receivingItemsData)
            	->with('receivingItems', $itemsreceiving)
            	->with('customer', $customers);


	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
            $items = Item::find($id);
            // process inventory
			$receivingTemps = new ReceivingTemp;
			$inventories->item_id = $id;
			$inventories->quantity = Input::get('quantity');
			$inventories->save();
			
            Session::flash('message', 'تم إضافة صنف بنجاح');
            return Redirect::to('receivings');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
