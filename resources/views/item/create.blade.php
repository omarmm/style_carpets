@extends('app')

@section('content')
<div class="container">
	<div class="row">
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


					<!--<div class="container">
  <h3>نوع الصنف</h3>
  
  <form role="form">
    <div class="radio">
      <label><input type="radio" name="item_type" value="بالقطعة">بالقطعة</label>
    </div>
    <div class="radio">
      <label><input type="radio" name="item_type" value="سجادة (طول*عرض)">سجادة (طول*عرض)</label>
    </div>
    <div class="radio">
      <label><input type="radio" name="item_type" value="رول (الحجم)" >رول (الحجم)</label>
    </div>
  </form>
</div> -->
<div class="form-group">

              {!! Form::label('item_type', trans('item.item_type')) !!}
                <br><br>
                {!! Form::radio('item_type', 'بالقطعة') !!}
                 {!! Form::label('item_type', 'بالقطعة') !!}<br>
                {!! Form::radio('item_type', 'سجادة (طول*عرض') !!}
                 {!! Form::label('item_type', 'سجادة (طول*عرض)') !!}<br>
                {!! Form::radio('item_type', 'رول (الحجم)') !!}
                {!! Form::label('item_type', 'رول (الحجم)') !!}

</div>
					<div class="form-group">
					{!! Form::label('item_category', 'تصنيف الصنف') !!}
					{!! Form::text('item_category', Input::old('item_category'), array('class' => 'form-control')) !!}
					</div>

					<div class="form-group">
					{!! Form::label('description', trans('item.description')) !!}
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