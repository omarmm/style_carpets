<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Sale;
use App\SaleTemp;
use App\SaleItem;
use App\Inventory;
use App\Customer;
use App\Transaction;
use App\Item, App\ItemKitItem;
use App\Http\Requests\SaleRequest;
use \Auth, \Redirect, \Validator, \Input, \Session;
use Illuminate\Http\Request;

class SaleController extends Controller {

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
		$sales = Sale::orderBy('id', 'desc')->first();
		$customers = Customer::where('customer_type', '=', 1)->orwhere('customer_type', '=', 2)->lists('name', 'id','company_name');
		return view('sale.index')
			->with('sale', $sales)
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
	public function store(SaleRequest $request)
	{
	    $sales = new Sale;
        $sales->customer_id = Input::get('customer_id');
        $sales->customer_temp = Input::get('customer_temp');
        $sales->user_id = Auth::user()->id;
        $sales->sales_man = Input::get('sales_man');
        $sales->payment_type = Input::get('payment_type');
        $sales->comments = Input::get('comments');
        $sales->reserved = (Input::has('reserved')) ? true : false;
        $sales->visacard = (Input::has('visa')) ? true : false;
        $sales->deposit = Input::get('deposit');
        $sales->amount_due = Input::get('amount_due');
        $sales->total = Input::get('total');
        $sales->creditor = Input::get('creditor');
        $sales->debtor = Input::get('debtor');
        $sales->save();


     //process transaction

			$transactions = new Transaction;
		 		
   	   	    $transactions->customer_id = $sales->customer_id;
			$transactions->amount = $sales->deposit;
			$transactions->remarks = 'مبيعات';
			$transactions->invoice_id=$sales->id;
			$transactions->debtor = $sales->debtor;
			$transactions->creditor = $sales->creditor;
			$transactions->total = $sales->total;
			$transactions->save();


//process customers transaction
			$customers = Customer::find($sales->customer_id);
	            $customers->sum_debtor= $customers->sum_debtor + $sales->debtor;
	            $customers->sum_creditor= $customers->sum_creditor + $sales->creditor;

               $customers->net_debtor= $customers->sum_debtor - $customers->sum_creditor;
	            $customers->net_creditor= $customers->sum_creditor - $customers->sum_debtor;

	            if($customers->net_creditor<0)
	            	$customers->net_creditor=0;
	            else
                   $customers->net_debtor=0;

	            $customers->save();



        // process sale items
        $saleItems = SaleTemp::all();
		foreach ($saleItems as $value) {
			$saleItemsData = new SaleItem;
			$saleItemsData->sale_id = $sales->id;
			$saleItemsData->item_id = $value->item_id;
			$saleItemsData->cost_price = $value->cost_price;
			$saleItemsData->selling_price = $value->selling_price;
			$saleItemsData->quantity = $value->quantity;
			$saleItemsData->metres_w = $value->metres_w;
			$saleItemsData->metres_h = $value->metres_h;
			$saleItemsData->metres_square = $value->metres_square;
			$saleItemsData->totalmetres_square = $value->totalmetres_square;
			$saleItemsData->discount = $value->discount;
			$saleItemsData->total_prediscount = $value->total_prediscount;
			$saleItemsData->total_cost = $value->total_cost;
			$saleItemsData->total_selling = $value->total_selling;
			$saleItemsData->save();


     



			//process inventory
			$items = Item::find($value->item_id);
			if($items->type == 1)
			{
				$inventories = new Inventory;
				$inventories->item_id = $value->item_id;
				$inventories->user_id = Auth::user()->id;
				$inventories->in_out_qty = -($value->quantity);
				$inventories->remarks = 'SALE'.$sales->id;
				$inventories->save();
				//process item quantity
	            $items->quantity = $items->quantity - $value->quantity;
	            $items->save();
        	}
        	else
        	{
	        	$itemkits = ItemKitItem::where('item_kit_id', $value->item_id)->get();
				foreach($itemkits as $item_kit_value)
				{
					$inventories = new Inventory;
					$inventories->item_id = $item_kit_value->item_id;
					$inventories->user_id = Auth::user()->id;
					$inventories->in_out_qty = -($item_kit_value->quantity * $value->quantity);
					$inventories->remarks = 'SALE'.$sales->id;
					$inventories->save();
					//process item quantity
					$item_quantity = Item::find($item_kit_value->item_id);
		            $item_quantity->quantity = $item_quantity->quantity - ($item_kit_value->quantity * $value->quantity);
		            $item_quantity->save();
				}
        	}
		}
		//delete all data on SaleTemp model
		SaleTemp::truncate();
        $itemssale = SaleItem::where('sale_id', $saleItemsData->sale_id)->get();
            Session::flash('message', 'تمت عملية البيع بنجاح');
            //return Redirect::to('receivings');
            return view('sale.complete')
            	->with('sales', $sales)
            	->with('saleItemsData', $saleItemsData)
            	->with('saleItems', $itemssale);

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
		//
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
