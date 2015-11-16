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
              <td bgcolor="#E1E4E6" style="width:30%">{{trans('sale.customer')}}:</td> <td>{{ $sales->customer->name}}</td>

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
                    <td>{{'عدد الأمتار'}}</td>
                     <td>{{'عدد القطع'}}</td>
                    <td>{{trans('sale.total')}}</td>
                </tr>
                @foreach($saleItems as $value)
                <tr>
                    <td>{{$value->item->item_name}}</td>
                    <td>{{$value->selling_price}}</td>
                    <td>{{$value->quantity}}</td>

                    @if ($value->metres > 1)
                    <td>{{$value->metres}}</td> 
                    @else 
                    <td>{{'-'}}</td>
                    @endif
                   
                    <td>{{$value->pieces}}</td>
                    <td>{{$value->total_selling}}</td>
                </tr>

                @endforeach
           
            </table>
            <table border="1" class="table" align="left" style="width:30%">
            <tr><td bgcolor="#E1E4E6" style="width:30%">{{'إجمالي قيمة الفاتورة'}}:</td><td>{{$sales->total}}</td></tr>
            </table> 

             </table>
            <table border="1" class="table"  >
            <tr>
<?php 


$total_credit= DB::table('sales')

->where('sales.customer_id', '=', $sales->customer->id)
->sum('creditor');


$total_debit= DB::table('sales')

->where('sales.customer_id', '=', $sales->customer->id)
->sum('deptor');



 ?>
 <td bgcolor="#E1E4E6" style="width:40%">صافي حساب العميل عند طباعة الفاتورة</td>
            <td bgcolor="#E1E4E6" style="width:10%">{{'دائن'}}:</td><td>{{$total_credit}}</td>
 <td bgcolor="#E1E4E6" style="width:10%">{{'مدين'}}:</td><td>{{$total_debit}}</td>
            </tr>
            </table>





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