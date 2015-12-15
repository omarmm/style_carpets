@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">{{trans('item.update_item')}}</div>

				<div class="panel-body">
					{!! Html::ul($errors->all()) !!}

					{!! Form::model($item, array('route' => array('items.update', $item->id), 'method' => 'PUT', 'files' => true)) !!}

					

					<div class="form-group">
					{!! Form::label('item_name', trans('item.item_name').' *') !!}
					{!! Form::text('item_name', null, array('class' => 'form-control')) !!}
					</div>



                  
                  <div class="form-group">
                         <label for="payment_type" class="control-label">{{trans('item.item_type')}}</label>
                          
            {!! Form::select('item_type', array('1' => 'بالقطعة', '2' => 'سجادة (طول*عرض)', '3' => 'رول'), null, ['ng-model' => 'type'], array('class' => 'form-control')) !!}
                            
                          </div>
                           
       <div class="box box-success" >



       <!-- width * height  type -->
        <div class="col-md-12 well well-small">

 <div class="col-md-5 col-md-offset-1 success">
					<div class="form-group" >
					{!! Form::label('metres_w', trans('item.metres_w'),['ng-hide' => 'type==1']) !!}
					{!! Form::text('metres_w',null, ['ng-hide' => 'type==1', 'size'=>'3','style'=>'text-align:center']) !!}
					</div>
</div>
<div class="col-md-6">
					<div class="form-group">
					{!! Form::label('metres_h', trans('item.metres_h'),['ng-show' => 'type==2']) !!}
					{!! Form::text('metres_h', null,['ng-show' => 'type==2', 'size'=>'3','style'=>'text-align:center']) !!}
					</div>
					</div>




 <!-- roll  type -->
 <!-- <div class="col-md-5 col-md-offset-1 success">
					<div class="form-group" >
					{!! Form::label('metres_w', trans('item.metres_w'),['ng-show' => 'type==3']) !!}
					{!! Form::text('metres_w', Input::old('metres_w'), ['ng-show' => 'type==3', 'size'=>'3','style'=>'text-align:center']) !!}
					</div>

</div>
 -->

</div>
</div>

<br>


					<!-- <div class="form-group">
					{!! Form::label('item_category', 'تصنيف الصنف') !!}
					{!! Form::text('item_category', Input::old('item_category'), array('class' => 'form-control')) !!}
					</div> -->

					<!-- <div class="form-group">
					<div class="col-md-12">
					{!! Form::label('description', trans('item.description')) !!}</div>
					{!! Form::textarea('description', Input::old('description'), array('class' => 'form-control')) !!}
					</div> -->
					
<!-- 
					<div class="form-group">
					{!! Form::label('avatar', trans('item.choose_avatar')) !!}
					{!! Form::file('avatar', Input::old('avatar'), array('class' => 'form-control')) !!}
					</div> -->

					<div class="form-group">
					{!! Form::label('cost_price', trans('item.cost_price').' *') !!}
					{!! Form::text('cost_price', null, array('class' => 'form-control')) !!}
					</div>

					<div class="form-group">
					{!! Form::label('selling_price', trans('item.selling_price').' *') !!}
					{!! Form::text('selling_price', null, array('class' => 'form-control')) !!}
					</div>

					<div class="form-group">
					{!! Form::label('quantity', trans('item.quantity'),['ng-hide' => 'type==3']) !!}
					{!! Form::text('quantity', null, array('class' => 'form-control' ,'ng-hide' => 'type==3')) !!}
					</div>

					<div class="form-group">
					{!! Form::label('totalmetres_h', trans('إجمال المتر الطولي').' *' , ['ng-show' => 'type==3']) !!}
					{!! Form::text('totalmetres_h', null, array('class' => 'form-control' ,'ng-show' => 'type==3')) !!}
					</div>



                   <!-- <div class="form-group">
					{!! Form::label('opening_balance', 'الرصيد الإفتتاحي' )!!}
					{!! Form::text('opening_balance', null, array('class' => 'form-control')) !!}
					</div> -->


					{!! Form::submit(trans('item.submit'), array('class' => 'btn btn-primary')) !!}

					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection