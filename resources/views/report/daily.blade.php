@extends('app')

@section('content')

 {!! Form::open(array('url' => 'reports/daily', 'class' => 'form-horizontal')) !!}

<div class="container">
  <form action="" class="form-horizontal"  role="form">
        <fieldset>
            <legend>Test</legend>
           
            <div class="form-group">
                <label for="dtp_input1" class="col-md-2 control-label">Date Picking</label>
                <div class="input-group date form_date col-md-5" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input1" data-link-format="yyyy-mm-dd">
                    <input class="form-control" size="16" type="text" value="" readonly>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>
                <input type="hidden" id="dtp_input1" name="date1" value="" /><br/>
            </div>

            <div class="form-group">
                <label for="dtp_input2" class="col-md-2 control-label">Date Picking</label>
                <div class="input-group date form_date col-md-5" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                    <input class="form-control" size="16" type="text" value="" readonly>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                </div>
                <input type="hidden" id="dtp_input2" name="date2" value="" /><br/>
            </div>
        
        </fieldset>
        <div class="form-group">
                                        <div class="col-sm-8">
                                            <button type="submit" class="btn btn-success btn-block">{{trans('sale.submit')}}</button>
                                            
                                        </div>
                                    </div>

                                </div>
                            
                            {!! Form::close() !!}
    </form>
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