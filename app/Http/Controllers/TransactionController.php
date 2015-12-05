<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\Http\Requests;
use App\Transaction;
use App\Http\Controllers\Controller;
use \Auth, \Redirect, \Validator, \Input, \Session;
use Carbon\Carbon ;
class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
   
$date1 = Carbon::today();
$date2 = Carbon::now()->addDay();
 // $date1 = Carbon::parse($date1);
 // $date2 = Carbon::parse($date2);
// dd($date1);
   $transactions = Transaction::whereBetween('created_at', [$date1, $date2])->get();
            return view('report.daily')->with('transaction', $transactions);
   // $transactions = Transaction::all();
   //          return view('report.daily')->with('transaction', $transactions);



    }


    public function filter()
    {
        //


   $date1 = Input::get('date1');
$date2 = Input::get('date2');

  $date1 = Carbon::parse($date1);
  $date2 = Carbon::parse($date2);

 $transactions = Transaction::whereBetween('created_at', [$date1, $date2])->get();
            return view('report.daily')->with('transaction', $transactions);

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
