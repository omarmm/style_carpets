@extends('app')

@section('content')

<?php 


$total_selling = DB::table('sales')

->where('sales.reserved', '=', 0)
->where('deptor', '<=', 0)
->sum('total');


$total_cost = DB::table('sale_items')
->join('sales', 'sale_items.sale_id', '=', 'sales.id')
->where('sales.reserved', '=', 0)
->where('deptor', '<=', 0)
->sum('total_cost');



 ?>
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">{{trans('report-sale.reports')}} - {{trans('report-sale.sales_report')}}</div>

				<div class="panel-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="well well-sm">{{trans('report-sale.grand_total')}}: {{$total_selling}}</div>
                        </div>
                        <div class="col-md-4">
                            <div class="well well-sm">{{trans('report-sale.grand_profit')}}: {{$total_selling - $total_cost}}</div>
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
            <td>{{trans('report-sale.profit')}}</td>
            <td>{{trans('report-sale.payment_type')}}</td>
            <td>{{trans('report-sale.comments')}}</td>
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
            <td>{{DB::table('sale_items')->where('sale_id', $value->id)->sum('total_selling') - DB::table('sale_items')->where('sale_id', $value->id)->sum('total_cost')}}</td>
            <td>{{ $value->payment_type }}</td>
            <td>{{ $value->comments }}</td>
            <td>
                <a class="btn btn-small btn-info" data-toggle="collapse" href="#detailedSales{{ $value->id }}" aria-expanded="false" aria-controls="detailedReceivings">
                    {{trans('report-sale.detail')}}</a>
            </td>
        </tr>
        
            <tr class="collapse" id="detailedSales{{ $value->id }}">
                <td colspan="10">
                    <table class="table">
                        <tr>
                            <td>{{trans('report-sale.item_id')}}</td>
                            <td>{{trans('report-sale.item_name')}}</td>
                            <td>{{trans('report-sale.quantity_purchase')}}</td>
                            <td>{{trans('عدد الأمتار')}}</td>
                            <td>{{trans('عدد القطع')}}</td>
                            <td>{{trans('report-sale.total')}}</td>
                            <td>{{trans('report-sale.profit')}}</td>
                        </tr>
                        @foreach(ReportSalesDetailed::sale_detailed($value->id) as $SaleDetailed)
                        <tr>
                            <td>{{ $SaleDetailed->item_id }}</td>
                            <td>{{ $SaleDetailed->item->item_name }}</td>
                            <td>{{ $SaleDetailed->quantity }}</td>
                            <td>{{ $SaleDetailed->metres }}</td>
                            <td>{{ $SaleDetailed->pieces }}</td>
                            <td>{{ $SaleDetailed->selling_price * $SaleDetailed->quantity * $SaleDetailed->metres * $SaleDetailed->pieces}}</td>
                            <td>{{ ($SaleDetailed->quantity  * $SaleDetailed->metres * $SaleDetailed->pieces * $SaleDetailed->selling_price) - ($SaleDetailed->quantity  * $SaleDetailed->metres * $SaleDetailed->pieces * $SaleDetailed->cost_price)}}</td>
                        </tr>
                        @endforeach
                    </table>
                </td>
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