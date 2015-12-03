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
                                        <!-- {!! Form::select('supplier_id', $customer, Input::old('supplier_id'), array('class' => 'form-control')) !!} -->
<input ng-model="cselect" type="text"
                              placeholder="كود" autofocus size="3" class="col-sm-3">    
<select name="supplier_id" id="cselect" ng-model="cselect" class="form-control form-control col-sm-8 col-md-offset-1">
      <option ng-repeat="supplier in suppliers" value="@{{supplier.id}}">@{{supplier.name}}</option>
    </select>


    <label for="amount_due" class="col-sm-3 control-label" ng-hide="cselect=='1'" >دائن</label>
<select name="supplier_id" id="cselect" ng-model="cselect" class="form-control form-control col-sm-8 col-md-offset-1" ng-hide="cselect=='1'">
      <option ng-repeat="supplier in suppliers"  ng-style="set_color(creditor)" value="@{{supplier.id}}">@{{supplier.sum_creditor}}</option>
    </select>


    <label for="amount_due" class="col-sm-3 control-label" ng-hide="cselect=='1'" >مدين</label>
    <select name="supplier_id" id="cselect" ng-model="cselect" class="form-control form-control col-sm-8 col-md-offset-1" ng-hide="cselect=='1'">
      <option ng-repeat="supplier in suppliers" value="@{{supplier.id}}">@{{supplier.sum_debtor}}</option>
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
                            <tr ng-repeat="newreceivingtemp in receivingtemp" class="info">
                            <td>@{{newreceivingtemp.item_id}}</td><td>@{{newreceivingtemp.item.item_name}}</td>
                            <td ><input   type="text" style="text-align:center" autocomplete="off" name="selling_price" ng-change="updateReceivingTemp(newreceivingtemp)" ng-model="newreceivingtemp.item.selling_price" size="5"></td>
                            <td ng-show="newreceivingtemp.item.item_type!='3'" ><input ng-show="newreceivingtemp.item.item_type!='3'" type="text" style="text-align:center" autocomplete="off" name="quantity" ng-change="updateReceivingTemp(newreceivingtemp)" ng-model="newreceivingtemp.quantity" size="2"></td>
                            <td ng-show="newreceivingtemp.item.item_type=='3'" style="text-align:center">@{{newreceivingtemp.quantity}}</td>

                            <!-- Hidden field just to retrieve item type  or newreceivingtemp.item.item_type=='3'  -->
                           <td ng-show="hohoho"> <input type="text" style="text-align:center" autocomplete="off" name="item_type" ng-change="updateReceivingTemp(newreceivingtemp)" ng-model="newreceivingtemp.item.item_type" size="3"></td>
                           
                             <td>@{{newreceivingtemp.item.metres_w}}</td>
                       <!-- 
                       if roll (type=3) make it (show) input text, else show fixed text -->
                            <td ng-show="newreceivingtemp.item.item_type=='3'"><input ng-show="newreceivingtemp.item.item_type=='3'"  type="text" style="text-align:center" autocomplete="off" name="metres_h" ng-change="updateReceivingTemp(newreceivingtemp)" ng-model="newreceivingtemp.item.metres_h" size="3"></td>
                         
                            <td ng-show="newreceivingtemp.item.item_type!='3'">@{{newreceivingtemp.item.metres_h}}</td>
                            <td>@{{ newreceivingtemp.item.metres_w * newreceivingtemp.item.metres_h}}</td>
                         <td>@{{ newreceivingtemp.item.metres_w * newreceivingtemp.item.metres_h*newreceivingtemp.quantity}}</td>
                             <td><input type="text" style="text-align:center" autocomplete="off" name="discount" ng-change="updateReceivingTemp(newreceivingtemp)" ng-model="newreceivingtemp.discount" size="3"></td>
                            <td>@{{newreceivingtemp.item.selling_price * newreceivingtemp.quantity *  newreceivingtemp.item.metres_w * newreceivingtemp.item.metres_h | currency:"L.E"}}</td>
                            <td>@{{(newreceivingtemp.item.selling_price * newreceivingtemp.quantity *  newreceivingtemp.item.metres_w * newreceivingtemp.item.metres_h) - newreceivingtemp.discount | currency:"L.E"}}</td>

                            <td><button class="btn btn-danger btn-xs" type="button" ng-click="removeReceivingTemp(newreceivingtemp.id)"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button></td>
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
                                            <p class="form-control-static"><b>@{{prediscount(receivingtemp) | currency:"L.E"}}</b></p>
                                        </div>


                                        <label for="supplier_id" class="col-sm-4 control-label">{{trans('sale.grand_total')}}</label>
                                        <div class="col-sm-8">
                                            <p class="form-control-static"><b>@{{sum(receivingtemp) | currency:"L.E"}}</b></p>
                                        </div>
                                      <!-- Hidden total selling input just to use it in invoice printing
                                      and to avoid employee editting (if we keep input text visible) -->
                                         <div class="input-group">
                                      <div class="input-group-addon" ng-show="hide">L.E</div>
                                      <input type="text" class="form-control" name="total"  size="5" ng-show="hide" value="@{{sum(receivingtemp)}}" />
                                    </div>

                                    <div class="form-group">
                                            <label for="amount_due" class="col-sm-4 control-label">{{trans('sale.amount_due')}}</label>
                                            <div class="col-sm-8">
                                            <p class="form-control-static">@{{add_payment - sum(receivingtemp) | currency:"L.E"}}</p>
                                            </div>
                                    </div>
                                          </div>
                                                </div>
                                                       </div>
                                                               </div>
                            
                            
                         <!-- close main col-md-9 -->

                    </div>


 <div class="col-md-4" >

               <!--  
                {!! Form::checkbox('reserved', '1') !!}
                 {!! Form::label('reserved', 'حجز') !!}<br> -->

              
                 <!-- debtor/creditor -->


         
                   <div class="input-group">
                   <label for="amount_due" class="col-sm-4 control-label" ng-hide="cselect=='1'" >مدين</label>
                   <div class="col-sm-8">
                   <div class="input-group">
                   <div class="input-group-addon" ng-hide="cselect=='1'">L.E</div>

                  <input type="text" class="form-control" name="debtor"  size="5"  ng-model="add_payment" ng-hide="cselect=='1'" />
                </div>
                   </div>


                   <div class="input-group">
                   <label for="amount_due" class="col-sm-4 control-label" ng-hide="cselect=='1'" >دائن</label>
                   <div class="col-sm-8">
                   <div class="input-group">
                   <div class="input-group-addon" ng-hide="cselect=='1'">L.E</div>

                  <input type="text" class="form-control" name="creditor" size="5"  value="@{{sum(receivingtemp) -add_payment}}" ng-hide="cselect=='1'" />
                
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
                  <input type="text" class="form-control" name="amount_due" id="amount_due" size="5" ng-show="val" value="@{{sum(receivingtemp) -add_payment}}" />
                
                   </div>
</div>
                   



 <!-- visa card -->
            <div class="col-md-4">
                      <input name="visa" type="checkbox" value="1"ng-model="visa" ng-true-value="true" ng-false-value="false"/>
    
                 <label for="visa">Visa card</label><br>

                  <label ng-show="visa">المبلغ المدفوع مقدما</label>
                   <div class="input-group">
                   <div class="input-group-addon" ng-show="visa">L.E</div>
                  <input type="text" class="form-control" name="deposit" id="deposit" size="5" ng-show="visa" ng-model="add_payment" />
                
                   </div>


                   <label ng-show="visa">المبلغ المتبقي</label>
                   <div class="input-group">
                   <div class="input-group-addon" ng-show="visa">L.E</div>
                  <input type="text" class="form-control" name="amount_due" id="amount_due" size="5" ng-show="visa" value="@{{sum(receivingtemp) -add_payment}}" />
                
                   </div>
</div>





<br><br><div class="col-md-4 col-md-offset-8">
                                    <div class="form-group">
                                        <div class="col-sm-8">
                                            <button type="submit" class="btn btn-success btn-block">{{trans('receiving.submit')}}</button>
                                            
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
@endsection