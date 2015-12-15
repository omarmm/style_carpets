@extends('app')

@section('content')

 
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">{{'تقرير اليومية'}}</div>

				<div class="panel-body">


                {!! Form::open(array('url' => 'reports/daily', 'class' => 'form-horizontal')) !!}


  <div class="form-horizontal col-md-12 well well-small"  role="form">
        
            <legend>البحث بتاريخ محدد</legend>
           
            <div class="form-group col-md-5">
                <label for="dtp_input1" class="col-sm-4 control-label">من تاريخ</label>
                <div class="input-group date form_date col-sm-8" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input1" data-link-format="yyyy-mm-dd">
                    <input class="form-control" size="16" type="text" value="" readonly>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>
                <input type="hidden" id="dtp_input1" name="date1" value="" /><br/>
            </div>

            <div class="form-group col-md-5">
                <label for="dtp_input2" class="col-sm-4 control-label">إلى تاريخ</label>
                <div class="input-group date form_date col-sm-8" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                    <input class="form-control" size="16" type="text" value="" readonly>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>
                <input type="hidden" id="dtp_input2" name="date2" value="" /><br/>
            </div>
        
        
        
                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-success btn-block">{{'بحث'}}</button>
                                            
                                        </div>
                                    

                                
                            
                            {!! Form::close() !!}
    </div>


<script type="text/javascript">
    
    $('.form_date').datetimepicker({
         language:  'ar',
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        maxView: 0,
        forceParse: 0
    });
   
</script>
                    
<table class="table table-striped table-bordered">
    <thead>
        <tr class="info">
            
            <td>{{trans('report.date')}}</td>
            <td>{{trans('report.remark')}}</td>
            <td>{{trans('report.invoice_id')}}</td>
            <td>{{trans('report.branch')}}</td>
            <td>{{trans('report.amount')}}</td>
            <td>{{trans('report.in_cash')}}</td>
            <td>{{trans('report.out_cash')}}</td>
            
            
        </tr>
    </thead>
    <tbody>
      @foreach($transaction as $value)
        <tr class="success">
            
            <td>{{ $value->created_at }}</td>
            <td>{{ $value->remarks }}</td>
            <td>{{ $value->invoice_id }}</td>
            <td>{{$value->branch}}</td>
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