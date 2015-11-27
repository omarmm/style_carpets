@extends('app')
@section('content')
{!! Html::script('js/angular.min.js', array('type' => 'text/javascript')) !!}
{!! Html::script('js/app.js', array('type' => 'text/javascript')) !!}
<style>
table td {
    border-top: none !important;
}
</style>
<div class="container-fluid">
   <div class="row">
        <div class="col-md-12" style="text-align:center">
            ستايل للسجاد        
        </div>
    </div>
    
        
        <div class="table-responsive">
        <table style="width:100%" >
        <td>
          <table class="table" border="1"  style="width:40%">
          <tr>

              <td bgcolor="#E1E4E6" style="width:30%">{{trans('sale.customer_temp')}}:</td> 
      
            @if($sales->customer_temp == null)
              <td>{{ $sales->customer->name}}</td>
            @else
            <td>{{$sales->customer_temp}}</td>
            @endif
          </tr>
            </table>
           <table class="table" border="1"  style="width:40%">

          <tr>
              <td bgcolor="#E1E4E6" style="width:60%">{{trans('sale.sale_id')}}:</td> <td> SALE{{$saleItemsData->sale_id}}</td>

          </tr>
          </table>
           
           </td>
        
      <td>
<table align="left" class="table" border="1"  style="width:40%">
    <tr>
              <td bgcolor="#E1E4E6" style="width:15%">{{'التاريخ'}}:</td> <td> {{$sales->created_at}}</td>

          </tr>
          
            </table>
            <br/><br/><br/><br/>
    <table align="left" class="table" border="1"  style="width:40%">

          <tr>
              <td bgcolor="#E1E4E6" style="width:30%">{{trans('sale.employee')}}:</td> <td>{{$sales->user->name}}</td>

          </tr>
            </table>
            </td>
            </table>
        </div>
    

    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
           <table class="table" border="1">
                <tr bgcolor="#E1E4E6">
                    <td>{{trans('sale.item')}}</td>
                    <td>{{trans('sale.price')}}</td>
                    <td>{{trans('sale.qty')}}</td>
                    <td>{{trans('item.metres_w')}}</td>
                    <td>{{trans('item.metres_h')}}</td>
                    <td>{{trans('sale.metres_square')}}</td>
                     <td>{{trans('sale.totalmetres_square')}}</td>
                     <td>{{trans('sale.discount')}}</td>
                    <td>{{trans('sale.total')}}</td>
                </tr>
                @foreach($saleItems as $value)
                <tr>
                    <td>{{$value->item->item_name}}</td>
                    <td>{{$value->selling_price}}</td>
                    <td>{{$value->quantity}}</td>

                    @if ($value->metres_w > 0 || $value->metres_h >0)
                    <td>{{$value->metres_w}}</td> 
                    <td>{{$value->metres_h}}</td> 
                    <td>{{$value->metres_square}}</td>
                    <td>{{$value->totalmetres_square}}</td>
                    @else 
                    <td>{{'-'}}</td>
                    <td>{{'-'}}</td>
                    <td>{{'-'}}</td>
                    <td>{{'-'}}</td>
                    @endif
                   
                    <!-- <td>{{$value->pieces}}</td> -->
                    <td>{{$value->discount}}</td>
                    <td>{{$value->total_selling}}</td>
                </tr>

                @endforeach
           
            </table>
            <table border="1" class="table">
            <tr>

            <td bgcolor="#E1E4E6" >{{'قيمة الفاتورة قبل الخصم'}}:</td>
            <td bgcolor="#E1E4E6" >{{'مجموع قيمة الخصومات'}}:</td>
            <td bgcolor="#E1E4E6" >{{'إجمالي قيمة الفاتورة'}}:</td>
            <td bgcolor="#E1E4E6" >{{'القيمة المدفوعة'}}:</td>
            <td bgcolor="#E1E4E6" >{{'المتبقي'}}:</td>

            </tr>
           <tr>
            <td>{{$saleItemsData->total_prediscount}}</td>
            <td>{{DB::table('sale_items')->where('sale_id', '=', $sales->id)->sum('discount')}}</td>
            <td>{{$sales->total}}</td>
            <td>{{$sales->deposit}}</td>
            <td>{{$sales->amount_due}}</td>
             </tr>
            </table> 

             


            <!-- debtor / creditor -->
<?php 


$total_credit= DB::table('sales')

->where('sales.customer_id', '=', $sales->customer->id)
->sum('creditor');


$total_debit= DB::table('sales')

->where('sales.customer_id', '=', $sales->customer->id)
->sum('deptor');



 ?>

 @if($sales->customer_id != 1)

 </table>
            <table border="1" class="table"  >
            <tr>

 <td bgcolor="#E1E4E6" style="width:40%">صافي حساب العميل عند طباعة الفاتورة</td>
            <td bgcolor="#E1E4E6" style="width:10%">{{'دائن'}}:</td><td>{{$total_credit}}</td>
 <td bgcolor="#E1E4E6" style="width:10%">{{'مدين'}}:</td><td>{{$total_debit}}</td>
            </tr>
            
</table>
@endif



        </div>
        </div>
    </div>
    <div class="row">
    
        <div class="col-md-12">
            {{trans('sale.payment_type')}}: {{$sales->payment_type}}

          

        </div>
    </div>
    <hr class="hidden-print"/>
    <div class="row">
        <div class="col-md-8">
            &nbsp;
        </div>
        <div class="col-md-2">
            <button type="button" onclick="printInvoice()" class="btn btn-info pull-right hidden-print">{{trans('sale.print')}}</button> 
        </div>
        <div class="col-md-2">
            <a href="{{ url('/sales') }}" type="button" class="btn btn-info pull-right hidden-print">{{trans('sale.new_sale')}}</a>
        </div>
    </div>
</div>
<script>
function printInvoice() {
    window.print();
}
</script>
@endsection