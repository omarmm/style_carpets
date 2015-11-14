@extends('app')
@section('content')
{!! Html::script('js/angular.min.js', array('type' => 'text/javascript')) !!}
{!! Html::script('js/sale.js', array('type' => 'text/javascript')) !!}

<div class="container-fluid">
   <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading"><span class="glyphicon glyphicon-inbox" aria-hidden="true"></span> {{trans('sale.sales_register')}}</div>

            <div class="panel-body">

                @if (Session::has('message'))
                    <div class="alert alert-success">{{ Session::get('message') }}</div>
                @endif
                {!! Html::ul($errors->all()) !!}
                
                <div class="row" ng-controller="SearchItemCtrl">

                    <div class="col-md-3">
                        <label>{{trans('sale.search_item')}} <input ng-model="searchKeyword" class="form-control"></label>

                        <table class="table table-hover">
                        <tr ng-repeat="item in items  | filter: searchKeyword | limitTo:10">

                        <td>@{{item.item_name}}</td>
                        <td><button class="btn btn-success btn-xs" type="button" ng-click="addSaleTemp(item, newsaletemp)"><span class="glyphicon glyphicon-share-alt" aria-hidden="true"></span></button></td>

                        </tr>
                        </table>
                    </div>

                    <div class="col-md-9">

                        <div class="row">
                            
                            {!! Form::open(array('url' => 'sales', 'class' => 'form-horizontal')) !!}
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="invoice" class="col-sm-3 control-label">{{trans('sale.invoice')}}</label>
                                        <div class="col-sm-9">
                                        <input type="text" class="form-control" id="invoice" value="@if ($sale) {{$sale->id + 1}} @else 1 @endif" readonly/>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="employee" class="col-sm-3 control-label">{{trans('sale.employee')}}</label>
                                        <div class="col-sm-9">
                                        <input type="text" class="form-control" id="employee" value="{{ Auth::user()->name }}" readonly/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label for="customer_id" class="col-sm-4 control-label">{{trans('sale.customer')}}</label>
                                        <div class="col-sm-8">
                                        {!! Form::select('customer_id', $customer, Input::old('customer_id'), array('class' => 'form-control')) !!}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="payment_type" class="col-sm-4 control-label">{{trans('sale.payment_type')}}</label>
                                        <div class="col-sm-8">
                                        {!! Form::select('payment_type', array('Cash' => 'Cash', 'Check' => 'Check', 'Debit Card' => 'Debit Card', 'Credit Card' => 'Credit Card'), Input::old('payment_type'), array('class' => 'form-control')) !!}
                                        </div>
                                    </div>
                                </div>
                            
                        </div>
                           
                        <table class="table table-bordered">
                            <tr><th>{{trans('sale.item_id')}}</th><th>{{trans('sale.item_name')}}</th><th>{{trans('sale.price')}}</th><th>{{trans('sale.quantity')}}</th><th>{{'عدد الأمتار'}}</th><th>{{'عدد القطع'}}</th><th>{{trans('sale.total')}}</th><th>&nbsp;</th></tr>
                            <tr ng-repeat="newsaletemp in saletemp">
                            <td>@{{newsaletemp.item_id}}</td><td>@{{newsaletemp.item.item_name}}</td><td>@{{newsaletemp.item.selling_price | currency:"L.E"}}</td>
                            <td><input type="text" style="text-align:center" autocomplete="off" name="quantity" ng-change="updateSaleTemp(newsaletemp)" ng-model="newsaletemp.quantity" size="2"></td>
                            <td><input type="text" style="text-align:center" autocomplete="off" name="metres" ng-change="updateSaleTemp(newsaletemp)" ng-model="newsaletemp.metres" size="3"></td>
                            <td><input type="text" style="text-align:center" autocomplete="off" name="pieces" ng-change="updateSaleTemp(newsaletemp)" ng-model="newsaletemp.pieces" size="2"></td>
                            <td>@{{newsaletemp.item.selling_price * newsaletemp.quantity * newsaletemp.metres * newsaletemp.pieces | currency:"L.E"}}</td>
                            <td><button class="btn btn-danger btn-xs" type="button" ng-click="removeSaleTemp(newsaletemp.id)"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button></td>
                            </tr>
                        </table>

                        <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="total" class="col-sm-4 control-label">{{trans('sale.add_payment')}}</label>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <div class="input-group-addon">L.E</div>
                                                <input type="text" class="form-control" id="add_payment" ng-model="add_payment"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div>&nbsp;</div>
                                    <div class="form-group">
                                        <label for="employee" class="col-sm-4 control-label">{{trans('sale.comments')}}</label>
                                        <div class="col-sm-8">
                                        <input type="text" class="form-control" name="comments" id="comments" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="supplier_id" class="col-sm-4 control-label">{{trans('sale.grand_total')}}</label>
                                        <div class="col-sm-8">
                                            <p class="form-control-static"><b>@{{sum(saletemp) | currency:"L.E"}}</b></p>
                                        </div>
                                      <!-- Hidden total selling input just to use it in invoice printing
                                      and to avoid employee editting (if we keep input text visible) -->
                                         <div class="input-group">
                                      <div class="input-group-addon" ng-show="hide">L.E</div>
                                      <input type="text" class="form-control" name="total_selling" id="total_selling" size="5" ng-show="hide" value="@{{sum(saletemp)}}" />
                                    </div>

                                    <div class="form-group">
                                            <label for="amount_due" class="col-sm-4 control-label">{{trans('sale.amount_due')}}</label>
                                            <div class="col-sm-8">
                                            <p class="form-control-static">@{{add_payment - sum(saletemp) | currency:"L.E"}}</p>
                                            </div>
                                    </div>


                            <div class="form-group">

              
               <!--  
                {!! Form::checkbox('reserved', '1') !!}
                 {!! Form::label('reserved', 'حجز') !!}<br> -->

                      <input name="reserved" type="checkbox" value="1"ng-model="val" ng-true-value="true" ng-false-value="false"/>
    
                 <label for="reserved">حجز</label><br>

                  <label ng-show="val">المبلغ المدفوع مقدما</label>
                   <div class="input-group">
                   <div class="input-group-addon" ng-show="val">L.E</div>
                  <input type="text" class="form-control" name="deposit" id="deposit" size="5" ng-show="val" ng-model="add_payment" />
                
                   </div><!--  <div class="form-group" ng-show="val">
                                            <label for="amount_due" class="col-sm-4 control-label" ng-show="val">{{trans('sale.amount_due')}}</label>
                                            <div class="col-sm-8" ng-show="val">
                                            <input type="text" name="amount_due" class="form-control-static" ng-show="val" value="@{{sum(saletemp) -add_payment}}">
                                            </div>
                  </div> -->


                   <label ng-show="val">المبلغ المتبقي</label>
                   <div class="input-group">
                   <div class="input-group-addon" ng-show="val">L.E</div>
                  <input type="text" class="form-control" name="amount_due" id="amount_due" size="5" ng-show="val" value="@{{sum(saletemp) -add_payment}}" />
                
                   </div>

                   <br><br>


                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <button type="submit" class="btn btn-success btn-block">{{trans('sale.submit')}}</button>
                                            
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