<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\SaleTemp;
use App\Item;
use \Auth, \Redirect, \Validator, \Input, \Session, \Response;
use Illuminate\Http\Request;

class SaleTempApiController extends Controller {

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
		
		return Response::json(SaleTemp::with('item')->get());
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('sale.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$SaleTemps = new SaleTemp;
		$SaleTemps->item_id = Input::get('item_id');
		$SaleTemps->cost_price = Input::get('cost_price');
        $SaleTemps->selling_price = Input::get('selling_price');
		 $SaleTemps->quantity = 1;
		// $SaleTemps->metres = 1;
		// $SaleTemps->pieces = 1;
         $SaleTemps->metres_w= Input::get('metres_w');
         $SaleTemps->metres_h= Input::get('metres_h');
         $SaleTemps->metres_square= Input::get('metres_square');
        $SaleTemps->totalmetres_h= Input::get('totalmetres_h');
        $SaleTemps->totalmetres_square= Input::get('totalmetres_square');
        $SaleTemps->total_prediscount = Input::get('total_prediscount');
        // $SaleTemps->discount= Input::get('discount');
        // $SaleTemps->total_prediscount = Input::get('total_prediscount');
		// $SaleTemps->total_cost = Input::get('total_cost');
       $SaleTemps->total_selling = Input::get('total_selling');
		$SaleTemps->save();
		return $SaleTemps;
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
		$SaleTemps = SaleTemp::find($id);
        $SaleTemps->quantity = Input::get('quantity');
        $SaleTemps->metres_w= Input::get('metres_w');
        $SaleTemps->metres_h= Input::get('metres_h');
        $SaleTemps->metres_square= Input::get('metres_square');
        $SaleTemps->totalmetres_square= Input::get('totalmetres_square');
        $SaleTemps->totalmetres_h= Input::get('totalmetres_h');
        $SaleTemps->discount= Input::get('discount');
        $SaleTemps->total_prediscount = Input::get('total_prediscount');
        $SaleTemps->total_cost = Input::get('total_cost');
        $SaleTemps->selling_price = Input::get('selling_price');
        $SaleTemps->total_selling = Input::get('total_selling');
        $SaleTemps->save();
        return $SaleTemps;
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		SaleTemp::destroy($id);
	}

}
