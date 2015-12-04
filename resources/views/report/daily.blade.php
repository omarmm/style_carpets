@extends('app')

@section('content')


<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">{{'تقرير اليومية'}}</div>

				<div class="panel-body">
                    
<table class="table table-striped table-bordered">
    <thead>
        <tr>
            
            <td>{{trans('report.date')}}</td>
            <td>{{trans('report.remark')}}</td>
            <td>{{trans('report.invoice_id')}}</td>
            <td>{{trans('report.branch')}}</td>
            <td>{{trans('report.amount')}}</td>
            <td>{{trans('report.in_cash')}}</td>
            <td>{{trans('report.out_cash')}}</td>
            
            <td>&nbsp;</td>
        </tr>
    </thead>
    <tbody>
      @foreach($transaction as $value)
        <tr>
            
            <td>{{ $value->created_at }}</td>
            <td>{{ $value->remarks }}</td>
            <td>{{ $value->invoice_id }}</td>
            <td>&nbsp;</td>
            <td>{{ $value->total }}</td>
            @if($value->remarks=='مشتريات')
            <td>{{'0.0'}}</td>
            <td>{{ $value->amount }}</td>
            @elseif($value->remarks=='مبيعات')
            <td>{{ $value->amount }}</td>
            <td>{{'0.0'}}</td>
            @endif

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