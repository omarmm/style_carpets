@extends('app')
@section('content')
{!! Html::script('js/angular.min.js', array('type' => 'text/javascript')) !!}
{!! Html::script('js/app.js', array('type' => 'text/javascript')) !!}

<div class="container-fluid">
   <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading"><span class="glyphicon glyphicon-inbox" aria-hidden="true"></span> {{trans('receiving.item_receiving')}}</div>

            <div class="panel-body">

                @if (Session::has('message'))
                    <div class="alert alert-info">{{ Session::get('message') }}</div>
                @endif
                {!! Html::ul($errors->all()) !!}

                <div class="row" ng-controller="SearchItemCtrl">

                    <div class="col-md-3">
                                       <label>{{trans('item.item_id')}} <input ng-model="searchKeyword.id" class="form-control" size="3" > </label>

                        <label style="text-align:center" >{{trans('sale.search_item')}} <input ng-model="searchKeyword.item_name" class="form-control" size="12" ></label>
                        <table class="table table-hover">
                        <tr ng-repeat="item in items  | filter: searchKeyword | limitTo:10" class="active">
                    
                        <td>@{{item.item_name}}</td>
                        <td><button class="btn btn-primary btn-xs" type="button" ng-click="addReceivingTemp(item, newreceivingtemp)"><span class="glyphicon glyphicon-share-alt" aria-hidden="true"></span></button></td>

                        </tr>
                        </table>
                    </div>

                    <div class="col-md-9">

                        <div class="row">
                            
                            {!! Form::open(array('url' => 'receivings', 'class' => 'form-horizontal')) !!}
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="invoice" class="col-sm-4 control-label">{{trans('receiving.invoice')}}</label>
                                        <div class="col-sm-8">
                                        <input type="text" class="form-control" id="invoice" value="@if ($receiving) {{$receiving->id + 1}} @else 1 @endif" readonly/>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label ng-show="blablabla" for="employee" class="col-sm-3 control-label">{{trans('receiving.employee')}}</label>
                                        <div class="col-sm-9">
                                        <input ng-show="blablabla" type="text" class="form-control" name="employee_id" id="employee" value="{{ Auth::user()->name }}" readonly/>
                                        </div>
                                    </div>


                    <!-- sales man info -->
                    <div class="form-group">
                                        <label for="sales_man"  class="col-sm-4 control-label" style="text-align:right">{{trans('sale.employee')}}</label>
                                        <div class="col-sm-8">
                                        <input   type="text" class="form-control" id="sales_man" name="sales_man"  />
                                        </div>
                                    </div>



                                </div>
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label for="supplier_id" class="col-sm-4 control-label">{{trans('receiving.supplier')}}</label>
                                        <div class="col-sm-8">
                                        <!-- {!! Form::select('customer_id', $customer, Input::old('customer_id'), array('class' => 'form-control')) !!} -->
<input ng-model="cselect" type="text"
                              placeholder="كود" autofocus size="3" class="col-sm-3">    
<select name="customer_id" id="cselect" ng-model="cselect" class="form-control form-control col-sm-8 col-md-offset-1">
      <option ng-repeat="supplier in suppliers" value="@{{supplier.id}}">@{{supplier.name}}</option>
    </select>


    <label for="amount_due" class="col-sm-3 control-label" ng-hide="cselect=='1'" >دائن</label>
<select name="customer_id" id="cselect" ng-model="cselect" class="form-control form-control col-sm-8 col-md-offset-1" ng-hide="cselect=='1'">
      <option ng-repeat="supplier in suppliers"  ng-style="set_color(creditor)" value="@{{supplier.id}}">@{{supplier.opening_creditor}}</option>
    </select>


    <label for="amount_due" class="col-sm-3 control-label" ng-hide="cselect=='1'" >مدين</label>
    <select name="customer_id" id="cselect" ng-model="cselect" class="form-control form-control col-sm-8 col-md-offset-1" ng-hide="cselect=='1'">
      <option ng-repeat="supplier in suppliers" value="@{{supplier.id}}">@{{supplier.opening_debtor}}</option>
    </select>




                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="payment_type" class="col-sm-4 control-label">{{trans('receiving.payment_type')}}</label>
                                        <div class="col-sm-8">
                                        {!! Form::select('payment_type', array('Cash' => 'Cash', 'Check' => 'Check', 'Debit Card' => 'Debit Card', 'Credit Card' => 'Credit Card'), Input::old('payment_type'), array('class' => 'form-control')) !!}
                                        </div>
                                    </div>
                                </div>
                        </div>
                           
                         <table class="table table-hover table-bordered table-striped">
                            <tr class="success"><th>{{trans('Receiving.item_id')}}</th><th>{{trans('Receiving.item_name')}}</th><th>{{trans('Receiving.price')}}</th><th>{{trans('Receiving.quantity')}}</th>
                            <th>{{trans('item.metres_w')}}</th><th>{{trans('item.metres_h')}}</th><th>{{trans('Receiving.metres_square')}}</th><th>{{trans('Receiving.totalmetres_square')}}</th>
                            <th>{{'الخصم نقدي'}}</th><th>{{'إجمالي السعر قبل الخصم'}}</th><th>{{trans('Receiving.total')}}</th><th>&nbsp;</th></tr>
                            <tr ng-repeat="newreceivingtemp in receivingtemp">
                            <td>@{{newreceivingtemp.item_id}}</td><td>@{{newreceivingtemp.item.item_name}}</td><td>@{{newreceivingtemp.item.cost_price | currency}}</td><td><input type="text" style="text-align:center" autocomplete="off" name="quantity" ng-change="updateReceivingTemp(newreceivingtemp)" ng-model="newreceivingtemp.quantity" size="2"></td><td>@{{newreceivingtemp.item.cost_price * newreceivingtemp.quantity | currency}}</td><td><button class="btn btn-danger btn-xs" type="button" ng-click="removeReceivingTemp(newreceivingtemp.id)"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button></td>
                            </tr>
                        </table>

                        <div class="row">
                            
                            
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label for="total" class="col-sm-5 control-label">{{trans('receiving.amount_tendered')}}</label>
                                        <div class="col-sm-7">
                                            <div class="input-group">
                                                <div class="input-group-addon">$</div>
                                                <input type="text" class="form-control" id="amount_tendered"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div>&nbsp;</div>
                                    <div class="form-group">
                                        <label for="employee" class="col-sm-4 control-label">{{trans('receiving.comments')}}</label>
                                        <div class="col-sm-8">
                                        <input type="text" class="form-control" name="comments" id="comments" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="supplier_id" class="col-sm-4 control-label">{{trans('receiving.grand_total')}}</label>
                                        <div class="col-sm-8">
                                            <p class="form-control-static"><b>@{{sum(receivingtemp) | currency}}</b></p>
                                        </div>
                                    </div>
                                    <div>&nbsp;</div>
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                        <button type="submit" class="btn btn-primary btn-block">{{trans('receiving.submit')}}</button>
                                        </div>
                                    </div>
                                </div>
                        </div>
                            {!! Form::close() !!}
                            
                        

                    </div>

                </div>

            </div>
            </div>
        </div>
    </div>
</div>
@endsection