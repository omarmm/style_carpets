<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Item;
use App\Inventory;
use App\Http\Requests\ItemRequest;
use \Auth, \Redirect, \Validator, \Input, \Session;
use Image;
use Illuminate\Http\Request;

class ItemController extends Controller {

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
			$items = Item::where('type', 1)->get();
			return view('item.index')->with('item', $items);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('item.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(ItemRequest $request)
	{
		    $items = new Item;
            // $items->item_code = Input::get('item_code');
            $items->item_name = Input::get('item_name');
            $items->item_type = Input::get('item_type');
            if($items->item_type==1)
            {

            $items->metres_w =1;
            $items->metres_h=1;
            $items->quantity = Input::get('quantity');
            $items->totalmetres_square= 0;
$items->totalmetres_h= 0;

        }
        elseif($items->item_type==3)

        {
            $items->metres_w = Input::get('metres_w');
            // $items->metres_h=1;
            $items->totalmetres_h=Input::get('totalmetres_h');
            $items->quantity = 1;
            $items->totalmetres_square=  $items->totalmetres_h * $items->metres_w  ;
        }

        else{
            $items->metres_w = Input::get('metres_w');
            $items->metres_h = Input::get('metres_h');
             $items->quantity = Input::get('quantity');
            $items->totalmetres_square= $items->metres_w * $items->metres_h * $items->quantity ;
            $items->totalmetres_h=$items->metres_h * $items->quantity ;
            }
            // $items->item_category = Input::get('item_category');
            //$items->size = Input::get('size');
            // $items->description = Input::get('description');
            $items->cost_price = Input::get('cost_price');
            $items->selling_price = Input::get('selling_price');
            // $items->opening_balance = Input::get('opening_balance');
           
            


            $items->save();

            // process inventory
            if(!empty(Input::get('quantity')))
			{
				$inventories = new Inventory;
				$inventories->item_id = $items->id;
				$inventories->user_id = Auth::user()->id;
				$inventories->in_out_qty = Input::get('quantity');
				$inventories->totalmetres_square = $items->totalmetres_square;
	            $inventories->totalmetres_h = $items->totalmetres_h;
				$inventories->remarks = 'رصيد افتتاحي';
				$inventories->save();
			}
            // process avatar
            $image = $request->file('avatar');
			if(!empty($image))
			{
				$avatarName = 'item' . $items->id . '.' . 
				$request->file('avatar')->getClientOriginalExtension();

				$request->file('avatar')->move(
				base_path() . '/public/images/items/', $avatarName
				);
				$img = Image::make(base_path() . '/public/images/items/' . $avatarName);
				$img->resize(100, null, function ($constraint) {
					$constraint->aspectRatio();
				});
				$img->save();
				$itemAvatar = Item::find($items->id);
				$itemAvatar->avatar = $avatarName;
	            $itemAvatar->save();
        	}
            Session::flash('message', 'تم إضافة صنف جديد بنجاح');
            return Redirect::to('items/create');
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
			$items = Item::find($id);
	        return view('item.edit')
	            ->with('item', $items);
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
			'item_name' => 'required|unique:items,item_name,' . $id .'',
			
			
			);
			$validator = Validator::make(Input::all(), $rules);
			if ($validator->fails()) 
			{
				 return Redirect::to('items/' . $id . '/edit')
				->withErrors($validator);
			} else {
            $items = Item::find($id);
            // process inventory
			$inventories = new Inventory;
			$inventories->item_id = $id;
			$inventories->user_id = Auth::user()->id;
			$inventories->in_out_qty = Input::get('quantity')- $items->quantity;

			$inventories->remarks = 'عن طريق الإدخال يدويا';
			$inventories->save();
			// save update
            // $items->upc_ean_isbn = Input::get('upc_ean_isbn');
             $items->item_name = Input::get('item_name');
            $items->item_type = Input::get('item_type');
            if($items->item_type==1)
            {

            $items->metres_w =1;
            $items->metres_h=1;
            $items->quantity = Input::get('quantity');
            $items->totalmetres_square= '';


        }
        elseif($items->item_type==3)

        {
            $items->metres_w = Input::get('metres_w');
            // $items->metres_h=1;
            $items->totalmetres_h=Input::get('totalmetres_h');
            $items->quantity = 1;
            $items->totalmetres_square=  $items->totalmetres_h * $items->metres_w  ;
        }

        else{
            $items->metres_w = Input::get('metres_w');
            $items->metres_h = Input::get('metres_h');
             $items->quantity = Input::get('quantity');
            $items->totalmetres_square= $items->metres_w * $items->metres_h * $items->quantity ;
            }
            // $items->item_category = Input::get('item_category');
            //$items->size = Input::get('size');
            // $items->description = Input::get('description');
            $items->cost_price = Input::get('cost_price');
            $items->selling_price = Input::get('selling_price');
            // $items->opening_balance = Input::get('opening_balance');
            $items->save();
            // process avatar
   //          $image = $request->file('avatar');
			// if(!empty($image)) {
			// 	$avatarName = 'item' . $id . '.' . 
			// 	$request->file('avatar')->getClientOriginalExtension();

			// 	$request->file('avatar')->move(
			// 	base_path() . '/public/images/items/', $avatarName
			// 	);
			// 	$img = Image::make(base_path() . '/public/images/items/' . $avatarName);
			// 	$img->resize(100, null, function ($constraint) {
			// 		$constraint->aspectRatio();
			// 	});
			// 	$img->save();
			// 	$itemAvatar = Item::find($id);
			// 	$itemAvatar->avatar = $avatarName;
	  //           $itemAvatar->save();
   //      	}
            Session::flash('message', 'تم تعديل بيانات الصنف بنجاح');
            return Redirect::to('items');

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
			$items = Item::find($id);
	        $items->delete();

	        Session::flash('message', 'تم حذف الصنف بنجاح');
	        return Redirect::to('items');
	}

}
