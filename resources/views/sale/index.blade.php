@extends('app')
@section('content')
{!! Html::script('js/angular.min.js', array('type' => 'text/javascript')) !!}
{!! Html::script('js/sale.js', array('type' => 'text/javascript')) !!}

<div class="container-fluid" >
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
                        <tr ng-repeat="item in items  | filter: searchKeyword | limitTo:10" class="active">

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
                                        {!! Form::select('customer_id', $customer, Input::old('customer_id'), ['ng-model' => 'cselect'], array('class' => 'form-control')) !!}
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
                           
                        <table class="table table-hover table-bordered table-striped">
                            <tr class="info"><th>{{trans('sale.item_id')}}</th><th>{{trans('sale.item_name')}}</th><th>{{trans('sale.price')}}</th><th>{{trans('sale.quantity')}}</th><th>{{'إجمالي الأمتار المربعة'}}</th><th>{{'إجمالي المتر الطولي'}}</th><th>{{'الخصم نقدي'}}</th><th>{{'إجمالي السعر قبل الخصم'}}</th><th>{{trans('sale.total')}}</th><th>&nbsp;</th></tr>
                            <tr class="success" ng-repeat="newsaletemp in saletemp">
                            <td>@{{newsaletemp.item_id}}</td><td>@{{newsaletemp.item.item_name}}</td><td>@{{newsaletemp.item.selling_price | currency:"L.E"}}</td>
                            <td><input type="text" style="text-align:center" autocomplete="off" name="quantity" ng-change="updateSaleTemp(newsaletemp)" ng-model="newsaletemp.quantity" size="2"></td>
                            <td><input type="text" style="text-align:center" autocomplete="off" name="metres_w" ng-change="updateSaleTemp(newsaletemp)" ng-model="newsaletemp.metres_w" size="3"></td>
                            <td><input type="text" style="text-align:center" autocomplete="off" name="metres_h" ng-change="updateSaleTemp(newsaletemp)" ng-model="newsaletemp.metres_h" size="3"></td>
                            <td><input type="text" style="text-align:center" autocomplete="off" name="discount" ng-change="updateSaleTemp(newsaletemp)" ng-model="newsaletemp.discount" size="3"></td>
                            <td>@{{newsaletemp.item.selling_price * newsaletemp.quantity *  newsaletemp.metres_w * newsaletemp.metres_h | currency:"L.E"}}</td>
                            <td>@{{(newsaletemp.item.selling_price * newsaletemp.quantity *  newsaletemp.metres_w * newsaletemp.metres_h) - newsaletemp.discount | currency:"L.E"}}</td>

                            <td><button class="btn btn-danger btn-xs" type="button" ng-click="removeSaleTemp(newsaletemp.id)"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button></td>
                            </tr>
                        </table>

                        <div class="row well well-small">
                        <div class="box box-success">
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

                                     <label for="supplier_id" class="col-sm-4 control-label">{{' قبل الخصم :'}}</label>
                                        <div class="col-sm-8">
                                            <p class="form-control-static"><b>@{{prediscount(saletemp) | currency:"L.E"}}</b></p>
                                        </div>


                                        <label for="supplier_id" class="col-sm-4 control-label">{{trans('sale.grand_total')}}</label>
                                        <div class="col-sm-8">
                                            <p class="form-control-static"><b>@{{sum(saletemp) | currency:"L.E"}}</b></p>
                                        </div>
                                      <!-- Hidden total selling input just to use it in invoice printing
                                      and to avoid employee editting (if we keep input text visible) -->
                                         <div class="input-group">
                                      <div class="input-group-addon" ng-show="hide">L.E</div>
                                      <input type="text" class="form-control" name="total"  size="5" ng-show="hide" value="@{{sum(saletemp)}}" />
                                    </div>

                                    <div class="form-group">
                                            <label for="amount_due" class="col-sm-4 control-label">{{trans('sale.amount_due')}}</label>
                                            <div class="col-sm-8">
                                            <p class="form-control-static">@{{add_payment - sum(saletemp) | currency:"L.E"}}</p>
                                            </div>
                                    </div>
                          </div>
</div>
</div></div></div>




                            <div class="col-md-4" >

               <!--  
                {!! Form::checkbox('reserved', '1') !!}
                 {!! Form::label('reserved', 'حجز') !!}<br> -->

              
                 <!-- deptor/creditor -->


         
                   <div class="input-group">
                   <label for="amount_due" class="col-sm-4 control-label" ng-show="cselect=='1'" >دائن</label>
                   <div class="col-sm-8">
                   <div class="input-group">
                   <div class="input-group-addon" ng-show="cselect=='1'">L.E</div>

                  <input type="text" class="form-control" name="creditor"  size="5"  ng-model="add_payment" ng-show="cselect==1" />
                </div>
                   </div>


                   <div class="input-group">
                   <label for="amount_due" class="col-sm-4 control-label" ng-show="cselect=='1'" >مدين</label>
                   <div class="col-sm-8">
                   <div class="input-group">
                   <div class="input-group-addon" ng-show="cselect=='1'">L.E</div>

                  <input type="text" class="form-control" name="deptor" size="5"  value="@{{sum(saletemp) -add_payment}}" ng-show="cselect==1" />
                
                   </div>
</div>
              </div>
</div>
 </div>
            <!-- reservation -->
            <div class="col-md-4">
                      <input name="reserved" type="checkbox" value="1"ng-model="val" ng-true-value="true" ng-false-value="false"/>
    
                 <label for="reserved">حجز</label><br>

                  <label ng-show="val">المبلغ المدفوع مقدما</label>
                   <div class="input-group">
                   <div class="input-group-addon" ng-show="val">L.E</div>
                  <input type="text" class="form-control" name="deposit" id="deposit" size="5" ng-show="val" ng-model="add_payment" />
                
                   </div>


                   <label ng-show="val">المبلغ المتبقي</label>
                   <div class="input-group">
                   <div class="input-group-addon" ng-show="val">L.E</div>
                  <input type="text" class="form-control" name="amount_due" id="amount_due" size="5" ng-show="val" value="@{{sum(saletemp) -add_payment}}" />
                
                   </div>
</div>
                   

<br><div class="col-md-4 col-md-offset-8">
                                    <div class="form-group">
                                        <div class="col-sm-8">
                                            <button type="submit" class="btn btn-success btn-block">{{trans('sale.submit')}}</button>
                                            
                                        </div>
                                    </div>

                                </div>
                            
                            {!! Form::close() !!}
                            
                        

                    

                

           
            
        </div>
    </div>
</div>
</div>
@endsection