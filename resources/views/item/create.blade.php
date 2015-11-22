@extends('app')

@section('content')

{!! Html::script('js/angular.min.js', array('type' => 'text/javascript')) !!}
{!! Html::script('js/createitem.js', array('type' => 'text/javascript')) !!}


<div class="container">
	<div class="row"  ng-app ng-controller="myCtrl">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">{{trans('item.new_item')}}</div>

				<div class="panel-body">
					@if (Session::has('message'))
					<div class="alert alert-info">{{ Session::get('message') }}</div>
					@endif
					{!! Html::ul($errors->all()) !!}

					{!! Form::open(array('url' => 'items', 'files' => true)) !!}

					<div class="form-group">
					{!! Form::label('item_code', trans('item.item_code')) !!}
					{!! Form::text('item_code', Input::old('item_code'), array('class' => 'form-control')) !!}
					</div>

					<div class="form-group">
					{!! Form::label('item_name', trans('item.item_name').' *') !!}
					{!! Form::text('item_name', Input::old('item_name'), array('class' => 'form-control')) !!}
					</div>



                  
                  <div class="form-group">
                         <label for="payment_type" class="control-label">{{trans('item.item_type')}}</label>
                          
            {!! Form::select('item_type', array('بالقطعة' => 'بالقطعة', '2' => 'سجادة (طول*عرض)', '3' => 'رول'), Input::old('item_type'), ['ng-model' => 'type'], array('class' => 'form-control')) !!}
                            
                          </div>
                           
       <div class="box box-success" >



       <!-- width * height  type -->

 <div class="col-md-5 col-md-offset-1 success">
					<div class="form-group" >
					{!! Form::label('metres_w', trans('item.metres_w'),['ng-show' => 'type==2']) !!}
					{!! Form::text('metres_w', Input::old('metres_w'), ['ng-show' => 'type==2', 'size'=>'3','style'=>'text-align:center']) !!}
					</div>
</div>
<div class="col-md-6">
					<div class="form-group">
					{!! Form::label('metres_h', trans('item.metres_h'),['ng-show' => 'type==2']) !!}
					{!! Form::text('metres_h', Input::old('metres_h'),['ng-show' => 'type==2', 'size'=>'3']) !!}
					</div>
					</div>




 <!-- roll  type -->
 <div class="col-md-5 col-md-offset-1 success">
					<div class="form-group" >
					{!! Form::label('metres_w', trans('item.metres_w'),['ng-show' => 'type==3']) !!}
					{!! Form::text('metres_w', Input::old('metres_w'), ['ng-show' => 'type==3', 'size'=>'3','style'=>'text-align:center']) !!}
					</div>

</div>


</div>

<br>


					<!-- <div class="form-group">
					{!! Form::label('item_category', 'تصنيف الصنف') !!}
					{!! Form::text('item_category', Input::old('item_category'), array('class' => 'form-control')) !!}
					</div> -->

					<div class="form-group">
					<div class="col-md-12">
					{!! Form::label('description', trans('item.description')) !!}</div>
					{!! Form::textarea('description', Input::old('description'), array('class' => 'form-control')) !!}
					</div>
					

					<div class="form-group">
					{!! Form::label('avatar', trans('item.choose_avatar')) !!}
					{!! Form::file('avatar', Input::old('avatar'), array('class' => 'form-control')) !!}
					</div>

					<div class="form-group">
					{!! Form::label('cost_price', trans('item.cost_price').' *') !!}
					{!! Form::text('cost_price', Input::old('cost_price'), array('class' => 'form-control')) !!}
					</div>

					<div class="form-group">
					{!! Form::label('selling_price', trans('item.selling_price').' *') !!}
					{!! Form::text('selling_price', Input::old('selling_price'), array('class' => 'form-control')) !!}
					</div>

					<div class="form-group">
					{!! Form::label('quantity', trans('item.quantity')) !!}
					{!! Form::text('quantity', Input::old('quantity'), array('class' => 'form-control')) !!}
					</div>


                   <div class="form-group">
					{!! Form::label('opening_balance', 'الرصيد الإفتتاحي' )!!}
					{!! Form::text('opening_balance', Input::old('opening_balance'), array('class' => 'form-control')) !!}
					</div>


					{!! Form::submit(trans('item.submit'), array('class' => 'btn btn-primary')) !!}

					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection