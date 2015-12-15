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

              <td bgcolor="#E1E4E6" style="width:30%">{{trans('receiving.supplier')}}:</td> 
      
            
              <td>{{ $receivings->customer->name}}</td>
           
            
           
          </tr>
            </table>
           <table class="table" border="1"  style="width:40%">

          <tr>
              <td bgcolor="#E1E4E6" style="width:60%">{{trans('receiving.receiving_id')}}:</td> <td> RECV{{$receivingItemsData->receiving_id}}</td>

          </tr>
          </table>
           
           </td>
        
      <td>
<table align="left" class="table" border="1"  style="width:40%">
    <tr>
              <td bgcolor="#E1E4E6" style="width:15%">{{'التاريخ'}}:</td> <td> {{$receivings->created_at}}</td>

          </tr>
          
            </table>
            <br/><br/><br/><br/>
    <table align="left" class="table" border="1"  style="width:40%">

          <tr>
              <td bgcolor="#E1E4E6" style="width:30%">{{trans('receiving.employee')}}:</td> <td>{{$receivings->user->name}}</td>

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
                    <td>{{trans('receiving.item')}}</td>
                    <td>{{trans('receiving.price')}}</td>
                    <td>{{trans('receiving.qty')}}</td>
                    <td>{{trans('item.metres_w')}}</td>
                    <td>{{trans('item.metres_h')}}</td>
                    <td>{{trans('receiving.metres_square')}}</td>
                     <td>{{trans('receiving.totalmetres_square')}}</td>
                     <td>{{trans('receiving.discount')}}</td>
                    <td>{{trans('receiving.total')}}</td>
                </tr>
                @foreach($receivingItems as $value)
                <tr>
                
                    <td>{{$value->item->item_name}}</td>
                    <td>{{$value->selling_price}}</td>
                    <td>{{$value->quantity}}</td>

                   @if ($value->metres_w !=1  && $value->metres_h !=1)
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
            <td>{{DB::table('receiving_items')->where('receiving_id', '=', $receivings->id)->sum('total_prediscount')}}</td>
            <td>{{DB::table('receiving_items')->where('receiving_id', '=', $receivings->id)->sum('discount')}}</td>
            <td>{{$receivings->total}}</td>
            <td>{{$receivings->deposit}}</td>
            <td>{{$receivings->amount_due}}</td>
             </tr>
            </table> 

             


            <!-- debtor / creditor -->
<?php 


$total_credit= DB::table('receivings')

->where('receivings.customer_id', '=', $receivings->customer->id)
->sum('creditor');


$total_debit= DB::table('receivings')

->where('receivings.customer_id', '=', $receivings->customer->id)
->sum('debtor');



 ?>

 @if($receivings->customer_id != 1)

 </table>
            <table border="1" class="table"  >
            <tr>

 <td bgcolor="#E1E4E6" style="width:40%">صافي حساب العميل عند طباعة الفاتورة</td>
            <td bgcolor="#E1E4E6" style="width:10%">{{'دائن'}}:</td><td>{{$customer->net_creditor}}</td>
 <td bgcolor="#E1E4E6" style="width:10%">{{'مدين'}}:</td><td>{{$customer->net_debtor}}</td>
            </tr>
            
</table>
@endif



        </div>
        </div>
    </div>
    <div class="row">
    
        <div class="col-md-12">
            {{trans('receiving.payment_type')}}: {{$receivings->payment_type}}

          

        </div>
    </div>
    <hr class="hidden-print"/>
    <div class="row">
        <div class="col-md-8">
            &nbsp;
        </div>
        <div class="col-md-2">
            <button type="button" onclick="printInvoice()" class="btn btn-info pull-right hidden-print">{{trans('receiving.print')}}</button> 
        </div>
        <div class="col-md-2">
            <a href="{{ url('/receivings') }}" type="button" class="btn btn-info pull-right hidden-print">{{trans('receiving.new_receiving')}}</a>
        </div>
    </div>
</div>
<script>
function printInvoice() {
    window.print();
}
</script>
@endsection