@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">{{trans('employee.update_employee')}}</div>

				<div class="panel-body">
					{!! Html::ul($errors->all()) !!}

					{!! Form::model($employee, array('route' => array('employees.update', $employee->id), 'method' => 'PUT')) !!}
					<div class="form-group">
					{!! Form::label('name', trans('employee.name').' *') !!}
					{!! Form::text('name', null, array('class' => 'form-control')) !!}
					</div>

					<div class="form-group">
					{!! Form::label('email', trans('employee.email').' *') !!}
					{!! Form::text('email', null, array('class' => 'form-control')) !!}
					</div>

					<div class="form-group">
					{!! Form::label('password', trans('employee.password')) !!}
					<input type="password" class="form-control" name="password" placeholder="Password">
					</div>

					<div class="form-group">
					{!! Form::label('password_confirmation', trans('employee.confirm_password')) !!}
					<input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password">
					</div>


                   @if(Auth::user()->permission_reports==1 &&  Auth::user()->permission_suppliers==1 && Auth::user()->permission_customers==1) 
					<div class="form-group">

              <label>الصلاحيات</label>
                <br><br>
                {!! Form::checkbox('permission_reports', '1') !!}
                 {!! Form::label('permission_reports', 'التقارير') !!}<br>
                {!! Form::checkbox('permission_customers', '1') !!}
                 {!! Form::label('permission_customers', 'العملاء') !!}<br>
                {!! Form::checkbox('permission_suppliers', '1') !!}
                {!! Form::label('permission_suppliers', 'الموردون') !!}

</div>
@endif


					{!! Form::submit(trans('employee.submit'), array('class' => 'btn btn-primary')) !!}

					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection