@extends('app')

@section('content')


<?php 


$total_deposit = DB::table('sales')

->where('sales.reserved', '=', 1)
->orwhere('deptor', '>', 0)
->sum('deposit');


$total_deptor = DB::table('sales')

->where('sales.reserved', '=', 1)
->orwhere('deptor', '>', 0)
->sum('deptor');



 ?>
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">{{trans('report-sale.reports')}} - {{'تقارير الحجوزات'}}</div>

				<div class="panel-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="well well-sm">{{'إجمالي المبالغ المدفوعة مقدما'}}: {{$total_deposit}}</div>
                        </div>
                        <div class="col-md-4">
                            <div class="well well-sm">{{'اجمالي المبالغ المتبقية'}}: {{$total_deptor}}</div>
                        </div>
                    </div>
<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <td>{{trans('report-sale.sale_id')}}</td>
            <td>{{trans('report-sale.date')}}</td>
            <td>{{trans('report-sale.items_purchased')}}</td>
            <td>{{trans('report-sale.sold_by')}}</td>
            <td>{{trans('report-sale.sold_to')}}</td>
            <td>{{trans('report-sale.total')}}</td>
            <td>{{'المبلغ المدفوع'}}</td>
            <td>{{'المبلغ المتبقي'}}</td>
            <td>{{trans('report-sale.payment_type')}}</td>
            <td>{{trans('report-sale.comments')}}</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
    </thead>
    <tbody>
    @foreach($saleReport as $value)
        <tr>
            <td>{{ $value->id }}</td>
            <td>{{ $value->created_at }}</td>
            <td>{{DB::table('sale_items')->where('sale_id', $value->id)->sum('quantity')}}</td>
            <td>{{ $value->user->name }}</td>
            <td>{{ $value->customer->name }}</td>
            <td>L.E{{DB::table('sale_items')->where('sale_id', $value->id)->sum('total_selling')}}</td>
            <!-- <td>{{DB::table('sale_items')->where('sale_id', $value->id)->sum('total_selling') - DB::table('sale_items')->where('sale_id', $value->id)->sum('total_cost')}}</td> -->
            <td>{{ $value->deposit}}</td>
            <td>{{ $value->amount_due}}</td>
            <td>{{ $value->payment_type }}</td>
            <td>{{ $value->comments }}</td>
            <td>
 

                <a class="btn btn-small btn-info" data-toggle="collapse" href="#detailedSales{{ $value->id }}" aria-expanded="false" aria-controls="detailedReceivings">
                    {{trans('report-sale.detail')}}</a>
            </td>
     <td>
            {!! Form::model($value, array('route' => array('reserved.update', $value->id), 'method' => 'PUT')) !!}         
  <!-- <input name="reserved" type="checkbox" value="0" ng-model="val" ng-true-value="true" ng-false-value="false"/> -->
    
     <button type="submit" class="btn btn-success btn-block">{{trans('sale.submit')}}</button>
    </td>
        {!!Form::close() !!}
        </tr>
        
           <tr class="collapse" id="detailedSales{{ $value->id }}">
                <td colspan="10">
                    <table class="table">
                        <tr>
                            <td>{{trans('report-sale.item_id')}}</td>
                            <td>{{trans('report-sale.item_name')}}</td>
                            <td>{{'سعر البيع'}}</td>
                            <td>{{'سعر التكلفة'}}</td>
                            <td>{{trans('report-sale.quantity_purchase')}}</td>
                            <td>{{trans('اجمالي المتر المربع')}}</td>
                            <td>{{trans('اجمالي الامتار الطولية')}}</td>
                            <td>{{trans('االإجمالي قبل الخصم')}}</td>
                            <td>{{trans('خصم نقدي')}}</td>
                            <td>{{trans('report-sale.total')}}</td>
                            <td>{{trans('report-sale.profit')}}</td>
                        </tr>
                        @foreach(ReportSalesDetailed::sale_detailed($value->id) as $SaleDetailed)
                        <tr>
                            <td>{{ $SaleDetailed->item_id }}</td>
                            
                            <td>{{ $SaleDetailed->item->item_name }}</td>
                            <td>{{ $SaleDetailed->selling_price }}</td>
                            <td>{{ $SaleDetailed->cost_price }}</td>
                            <td>{{ $SaleDetailed->quantity }}</td>
                            <td>{{ $SaleDetailed->metres_w }}</td>
                            <td>{{ $SaleDetailed->metres_h }}</td>
                            <td>{{$SaleDetailed->selling_price * $SaleDetailed->quantity * $SaleDetailed->metres_w * $SaleDetailed->metres_h }}</td>
                            <td>{{ $SaleDetailed->discount }}</td>
                            <td>{{ ($SaleDetailed->selling_price * $SaleDetailed->quantity * $SaleDetailed->metres_w * $SaleDetailed->metres_h) - $SaleDetailed->discount }}</td>
                            <td>{{ (($SaleDetailed->quantity  * $SaleDetailed->metres_w * $SaleDetailed->metres_h * $SaleDetailed->selling_price)- $SaleDetailed->discount) - ($SaleDetailed->quantity  * $SaleDetailed->metres_w * $SaleDetailed->metres_h* $SaleDetailed->cost_price)}}</td>
                        </tr>
                        @endforeach
                    </table>    </td>
            </tr>

    @endforeach
    </tbody>
</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection