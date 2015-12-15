@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">{{trans('item.inventory_data_tracking')}}</div>

				<div class="panel-body">
					@if (Session::has('message'))
						<div class="alert alert-info">{{ Session::get('message') }}</div>
					@endif

					{!! Html::ul($errors->all()) !!}

					<table class="table table-bordered">
					<!-- <tr><td>UPC/EAN/ISBN</td><td>{{ $item->upc_ean_isbn }}</td></tr> -->
					<!-- <tr><td>{{trans('item.item_code')}}</td><td>{{ $item->item_code }}</td></tr> -->
					<tr><td>{{trans('item.item_name')}}</td><td>{{ $item->item_name }}</td></tr>
					<tr><td>{{trans('item.current_quantity')}}</td><td>{{ $item->quantity }}</td></tr>
					@if($item->item_type!=1)
					<tr><td>{{trans('الكمية الحالية بالأمتار المربعة')}}</td><td>{{ $item->totalmetres_square }}</td></tr>
					<tr><td>{{trans('الكمية الحالية بالمتر الطولي')}}</td><td>{{ $item->totalmetres_h }}</td></tr>
					@endif
					{!! Form::model($item->inventory, array('route' => array('inventory.update', $item->id), 'method' => 'PUT')) !!}
					<tr><td>{{trans('item.inventory_to_add_subtract')}} *</td><td>{!! Form::text('in_out_qty', Input::old('in_out_qty'), array('class' => 'form-control')) !!}</td></tr>
					<tr><td>{{trans('item.comments')}}</td><td>{!! Form::text('remarks', Input::old('remarks'), array('class' => 'form-control')) !!}</td></tr>
					<tr><td>&nbsp;</td><td>{!! Form::submit(trans('item.submit'), array('class' => 'btn btn-primary')) !!}</td></tr>
					{!! Form::close() !!}
					</table>

					<table class="table table-striped table-bordered">
					    <thead>
					        <tr>
					            <td>{{trans('item.inventory_data_tracking')}}</td>
					            <!-- <td>{{trans('item.employee')}}</td> -->
					            <td>{{trans('نوع الحركة')}}</td>
					            <td>{{'المتعامل'}}</td>
					            <td>{{trans('الكمية بالعدد')}}</td>
					            @if($item->item_type!=1)
					            <td>{{'الكمية بالمتر المربع'}}</td>
					            <td>{{'الكمية بالمتر الطولي'}}</td>
					            @endif
					            <td>{{'رقم المستند'}}</td>
					            <td>{{'المخزن'}}</td>
					        </tr>
					    </thead>
					    <tbody>
					    @foreach($item->inventory as $value)
					        <tr>
					            <td>{{ $value->created_at }}</td>
					            <td>{{ $value->remarks }}</td>
					            <td>{{ $value->branch }}</td>
					           <!--  <td>{{ $value->user->name }}</td> -->

					            <td>{{ $value->in_out_qty }}</td>
					            @if($item->item_type!=1)
					            <td>{{ $value->totalmetres_square }}</td>
					            <td>{{ $value->totalmetres_h }}</td>
					            @endif
					            <td>{{ $value->invoice_id }}</td>
					            <td>{{ $value->store }}</td>
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