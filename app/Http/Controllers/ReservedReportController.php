<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Sale;
use \Auth, \Redirect;
use Illuminate\Http\Request;
use App\Http\Requests\SaleRequest;
use  \Validator, \Input, \Session;

class ReservedReportController extends Controller {

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
			$salesReport = Sale::where('reserved',1)
			->orwhere('deptor', '>', 0)->get();
			
		
			return view('report.reserved')->with('saleReport', $salesReport);
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
	public function store()
	{
		//
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
	public function update( $id)
	{
		// finish the sale and make the invoice unreserved*********

		$salesReport = Sale::find($id);
		// $salesReport->reserved = Input::get('reserved');
       $salesReport->reserved = 0;
        
        $salesReport->save();
         // return $salesReport;
           
             return Redirect::to('reserved');
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
