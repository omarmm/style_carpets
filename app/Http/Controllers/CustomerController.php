<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Customer;
use App\Transaction;
use App\Http\Requests\CustomerRequest;
use \Auth, \Redirect, \Validator, \Input, \Session;
use Image;
use Illuminate\Http\Request;

class CustomerController extends Controller {

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
			$customers = Customer::all();
			return view('customer.index')->with('customer', $customers);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
			return view('customer.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(CustomerRequest $request)
	{
	            // store

	            $customers = new Customer;
	            $customers->name = Input::get('name');
	            $customers->customer_type = Input::get('customer_type');
	            $customers->email = Input::get('email');
	            $customers->phone_number = Input::get('phone_number');
	            $customers->address = Input::get('address');
	            $customers->city = Input::get('city');
	            $customers->state = Input::get('state');
	            // $customers->zip = Input::get('zip');
	            $customers->company_name = Input::get('company_name');
	            $customers->account = Input::get('account');
	            $customers->opening_debtor = Input::get('opening_debtor');
	            $customers->opening_creditor = Input::get('opening_creditor');
	            $customers->save();
	            // process avatar
	   //          $image = $request->file('avatar');
				// if(!empty($image)) {
				// 	$avatarName = 'cus' . $customers->id . '.' . 
				// 	$request->file('avatar')->getClientOriginalExtension();

				// 	$request->file('avatar')->move(
				// 	base_path() . '/public/images/customers/', $avatarName
				// 	);
				// 	$img = Image::make(base_path() . '/public/images/customers/' . $avatarName);
				// 	$img->resize(100, null, function ($constraint) {
    // 					$constraint->aspectRatio();
				// 	});
				// 	$img->save();
				// 	$customerAvatar = Customer::find($customers->id);
				// 	$customerAvatar->avatar = $avatarName;
		  //           $customerAvatar->save();
	   //      	}



 //process transaction

          $transactions = new Transaction;
		 		
   	   	    $transactions->customer_id = $customers->id;
			
			$transactions->remarks = 'رصيد افتتاحي';
			$transactions->debtor =  $customers->opening_debtor;
			$transactions->creditor = $customers->opening_creditor;
			$transactions->save();


//process customers transaction
			$customers = Customer::find($customers->id);
	            $customers->sum_debtor= $customers->sum_debtor + $customers->opening_debtor;
	            $customers->sum_creditor= $customers->sum_creditor + $customers->opening_creditor;

	            $customers->net_debtor= $customers->sum_debtor - $customers->opening_creditor;
	            $customers->net_creditor= $customers->sum_creditor - $customers->opening_debtor;
	            
                if($customers->net_creditor<0)
	            	$customers->net_creditor=0;
	            else
                   $customers->net_debtor=0;

	            $customers->save();

	            Session::flash('message', 'تم إضافة عميل جديد بنجاح');
	            return Redirect::to('customers');
	        
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
		$customers = Customer::find($id);
        return view('customer.edit')
            ->with('customer', $customers);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$rules = array(
			'name' => 'required|unique:customers,name,' . $id .'',
			'company_name' => 'required|unique:customers,company_name,' . $id .'',
			
			);
			$validator = Validator::make(Input::all(), $rules);
			if ($validator->fails()) 
			{
				 return Redirect::to('customers/' . $id . '/edit')
				->withErrors($validator);
			} else {
	            $customers = Customer::find($id);
	            $customers->name = Input::get('name');
	            $customers->customer_type = Input::get('customer_type');
	            $customers->email = Input::get('email');
	            $customers->phone_number = Input::get('phone_number');
	            $customers->address = Input::get('address');
	            $customers->city = Input::get('city');
	            $customers->state = Input::get('state');
	            // $customers->zip = Input::get('zip');
	            $customers->company_name = Input::get('company_name');
	            $customers->account = Input::get('account');
	            $customers->opening_debtor = Input::get('opening_debtor');
	            $customers->opening_creditor = Input::get('opening_creditor');
	            $customers->save();
	            // process avatar
	   //          $image = $request->file('avatar');
				// if(!empty($image)) {
				// 	$avatarName = 'cus' . $id . '.' . 
				// 	$request->file('avatar')->getClientOriginalExtension();

				// 	$request->file('avatar')->move(
				// 	base_path() . '/public/images/customers/', $avatarName
				// 	);
				// 	$img = Image::make(base_path() . '/public/images/customers/' . $avatarName);
				// 	$img->resize(100, null, function ($constraint) {
    // 					$constraint->aspectRatio();
				// 	});
				// 	$img->save();
				// 	$customerAvatar = Customer::find($id);
				// 	$customerAvatar->avatar = $avatarName;
		  //           $customerAvatar->save();
	   //      	}
	            // redirect
	            Session::flash('message', 'تم تحديث بيانات العميل بنجاح');
	            return Redirect::to('customers');
	        }
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		try
		{
			$customers = Customer::find($id);
	        $customers->delete();
	        // redirect
	        Session::flash('message', 'تم مسح بيانات العميل بنجاح');
	        return Redirect::to('customers');
        }
    	catch(\Illuminate\Database\QueryException $e)
		{
    		Session::flash('message', 'Integrity constraint violation: You Cannot delete a parent row');
    		Session::flash('alert-class', 'alert-danger');
	        return Redirect::to('customers');	
    	}
	}

}
