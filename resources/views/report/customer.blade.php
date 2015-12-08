@extends('app')

@section('content')


 
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">{{'تقرير حركة عميل'}}</div>

				<div class="panel-body">


                {!! Form::open(array( 'url' => 'reports/customer', 'class' => 'form-horizontal')) !!}


  <div class="form-horizontal col-md-12 well well-small"  role="form">
        
            <legend>البحث بتاريخ محدد</legend>

            
                                    <div class="form-group col-md-12">
                                        <label for="customer_id" class="col-sm-2 control-label">{{trans('إسم العميل')}}</label>
                                        <div class="col-sm-10">
              {!! Form::select('customer_id', $customer, Input::old('customer_id'), ['ng-model' => 'cselect' , 'class' => 'form-control']) !!}
                                       </div>
                                       </div>
                                       
           
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
                                            <button name="search" type="submit" class="btn btn-success btn-block">{{'بحث'}}</button>
                                            
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


  
 
    @if(isset($data['search'])) 
        
       <div class="form-group col-md-12">

<table class="table table-striped table-bordered">
<tr class="success">
        <td>  <label for="customer_id" class="col-sm-1 control-label ">{{trans('العميل')}}</label></td>
                                       
          <td class="col-sm-7">    {{$customersInfo->name}} </td>

      <td class="col-sm-2">{{'من: '}}{{ $date1 }}</td> 

      <td class="col-sm-2">{{'إلى: '}}{{$date2}}</td> 

                                      

                                       </tr>
                                       </table>
                                       </div>


<table class="table table-striped table-bordered">
    <thead>

        <tr class="info">
            
            <td>{{trans('رقم الفاتورة')}}</td>
            <td>{{trans('تايخ الحركة')}}</td>
            <td>{{trans('الحركة')}}</td>
            <td>{{trans('الرصيد مدين')}}</td>
            <td>{{trans('الرصيد دائن')}}</td>
            <td>{{trans('قيمة الحركة مدينة')}}</td>
            <td>{{trans('قيمة الحركة دائنة')}}</td>
            
            
        </tr>
    </thead>
    <tbody>
    <?php $b_debtor=0; $b_creditor=0;?>

      @foreach($transaction as $value)
        <tr class="success">
            <td>{{ $value->invoice_id }}</td>
<!--             <td>{{ $value->created_at }}</td>
 -->       <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $value->created_at)->format('d/m/Y') }}</td> 
            <td>{{ $value->remarks }}</td>



      


          @if($b_debtor<0)

         <td>{{ '0.00' }}</td>
          @else
           
            <td>{{ $b_debtor }}</td>
            @endif

            @if($b_creditor<0)
           
         <td>{{ '0.00' }}</td>
          @else
            <td>{{ $b_creditor}}</td>
            
        @endif

           <td>{{ $value->debtor }}</td>
           <td>{{ $value->creditor }}</td>
            
<?php $b_debtor=($b_debtor + $value->debtor) - $value->creditor;


 $b_creditor=($b_creditor+$value->creditor) - $value->debtor;?>
          

            </tr>

@endforeach
    </tbody>
</table>
<div class="form-group col-md-12">

<table class="table table-striped table-bordered">
<tr class="success">
        <td>  <label for="customer_id" class="col-sm-1 control-label ">{{trans('الصافي')}}</label></td>
                              @if($customersInfo->net_debtor>0)         
          <td class="col-sm-7">  {{'مدين'}}  {{$customersInfo->net_debtor}} </td>

    @else

          <td class="col-sm-7">  {{'دائن'}}  {{$customersInfo->net_creditor}} </td>

                                      
  @endif
                                       </tr>
                                       </table>
                                       </div
		 @endif		</div>
			</div>
		</div>
	</div>
</div>
@endsection