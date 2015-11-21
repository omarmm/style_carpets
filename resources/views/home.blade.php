@extends('app')

@section('content')
<div class="layout-boxed">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">لوحة التحكم</div>

				<div class="panel-body">
					{{ trans('dashboard.welcome') }}
					<hr />
					<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">{{trans('dashboard.statistics')}}</h3>
  </div>
  <div class="panel-body">
    <div class="row">
    	<div class="col-md-4">
    		<div class="box box-success"><p class="bg-primary">{{trans('dashboard.total_employees')}} : </p> <br/> <p align="center">{{$employees}}</p></div>
    	</div>
    	<div class="col-md-4">
    		<div class="box box-primary">{{trans('dashboard.total_customers')}} : <br/>{{$customers}}</div>
    	</div>
    	<div class="col-md-4">
    		<div class="box box-success">{{trans('dashboard.total_suppliers')}} :<br/> {{$suppliers}}</div>
    	</div>
    </div>
  
    <div class="row">
      <div class="col-md-3">
        <div class="well">{{trans('dashboard.total_items')}} : <br/>{{$items}}</div>
      </div>
      <div class="col-md-3">
        <div class="well">{{trans('dashboard.total_item_kits')}} : <br/>{{$item_kits}}</div>
      </div>
      <div class="col-md-3">
        <div class="well">{{trans('dashboard.total_receivings')}} : <br/>{{$receivings}}</div>
      </div>
      <div class="col-md-3">
        <div class="well">{{trans('dashboard.total_sales')}} : {{$sales}}</div>
      </div>
    </div>

</div>
</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
