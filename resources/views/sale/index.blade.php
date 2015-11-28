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
                                       <label>{{trans('item.item_id')}} <input ng-model="searchKeyword.id" class="form-control" size="3" > </label>

                        <label style="text-align:center" >{{trans('sale.search_item')}} <input ng-model="searchKeyword.item_name" class="form-control" size="12" ></label>
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
                                        <label for="invoice" class="col-sm-4 control-label" style="text-align:right">{{trans('sale.invoice')}}</label>
                                        <div class="col-sm-8">
                                        <input type="text" class="form-control" id="invoice" value="@if ($sale) {{$sale->id + 1}} @else 1 @endif" readonly/>
                                        </div>
                                    </div>
                    <!-- hide employee info -->
                                    <div class="form-group">
                                        <label for="employee" ng-show="blablabla" class="col-sm-4 control-label" style="text-align:right">{{trans('sale.employee')}}</label>
                                        <div class="col-sm-8">
                                        <input ng-show="blablabla"   type="text" class="form-control" id="employee" value="{{ Auth::user()->name }}" readonly/>
                                        </div>
                                    </div>


                     <!-- sales man info -->
                    <div class="form-group">
                                        <label for="sales_man"  class="col-sm-4 control-label" style="text-align:right">{{trans('sale.employee')}}</label>
                                        <div class="col-sm-8">
                                        <input   type="text" class="form-control" id="sales_man" name="sales_man"  />
                                        </div>
                                    </div>


                               <div class="form-group">
                                        <label  for="customer_temp" class="col-sm-4 control-label" style="text-align:right">{{trans('sale.customer_temp')}}</label>
                                        <div class="col-sm-8">
                                        <input  type="text" class="form-control" name="customer_temp" id="customer_temp"  />
                                        </div>
                                    </div>



                                </div>
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label for="customer_id" class="col-sm-4 control-label">{{trans('sale.customer')}}</label>
                                        <div class="col-sm-8">
<!--        original         {!! Form::select('customer_id', $customer, Input::old('customer_id'), ['ng-model' => 'cselect' , 'class' => 'form-control']) !!}
 -->                                       <!--  </div>  -->

                             <!-- <form class="form-group">
                             <input ng-model="SearchCustomer.id" type="text"
                              placeholder="كود" autofocus size="3" class="col-sm-3">
                               </form> -->
<!--        2-                       <select class="form-control col-sm-8 col-md-offset-1" name="customer_id" ng-model="customer" ng-options="customer.id as customer.name for customer in customers"> 
 -->                           


                        <!-- 3-   <option  ng-repeat="customer in customers| filter:SearchCustomer | orderBy: 'name' ">
        
                              @{{customer.name}}
    
        
                             </option> -->
<!--                               </select>

 -->  
 <input ng-model="cselect" type="text"
                              placeholder="كود" autofocus size="3" class="col-sm-3">    
<select name="customer_id" id="cselect" ng-model="cselect" class="form-control form-control col-sm-8 col-md-offset-1">
      <option ng-repeat="customer in customers" value="@{{customer.id}}">@{{customer.name}}</option>
    </select>


    <label for="amount_due" class="col-sm-3 control-label" ng-hide="cselect=='1'" >دائن</label>
<select name="customer_id" id="cselect" ng-model="cselect" class="form-control form-control col-sm-8 col-md-offset-1" ng-hide="cselect=='1'">
      <option ng-repeat="customer in customers"  ng-style="set_color(creditor)" value="@{{customer.id}}">@{{customer.opening_creditor}}</option>
    </select>


    <label for="amount_due" class="col-sm-3 control-label" ng-hide="cselect=='1'" >مدين</label>
    <select name="customer_id" id="cselect" ng-model="cselect" class="form-control form-control col-sm-8 col-md-offset-1" ng-hide="cselect=='1'">
      <option ng-repeat="customer in customers" value="@{{customer.id}}">@{{customer.opening_debtor}}</option>
    </select>

<!--   <select ng-model="cselect" value="@{{customer.id}}" ng-options="customer as customer.opening_creditor for customer in customers"> </select>
 -->
<?php $value='{{cselect}}'; ?>
<!-- <p>@{{cselect.opening_creditor}}</p> -->

<?php 


$debtor= DB::table('customers')
->where('id', '=', $value)
->sum('opening_debtor');


//echo $value;
 ?>
 <!-- {{$value}} -->
 <!-- {{$debtor}} -->

                            </div>


                                    </div>

                                    <div class="form-group">
                                        <label for="payment_type" class="col-sm-4 control-label">{{trans('sale.payment_type')}}</label>
                                        <div class="col-sm-8">
                                        {!! Form::select('payment_type', array('Cash' => 'Cash', 'Check' => 'Check', 'Debit Card' => 'Debit Card', 'Credit Card' => 'Credit Card'), Input::old('payment_type'), array('class' => 'form-control')) !!}
                                        </div>
                                    </div>


                             <div class="form-group">
                                        <label for="customertemp_phone" class="col-sm-4 control-label">{{trans('sale.customertemp_phone')}}</label>
                                        <div class="col-sm-8">
                                        <input type="text" class="form-control" name="customertemp_phone" id="customertemp_phone" />
                                        </div> 
                                        </div>

                                </div>

                    
                   
                   <div class="col-sm-6">
                               
                             </div>
                       <div class="col-sm-6">
                            
                                        </div>


                                       
                            
                        </div>
                           
                        <table class="table table-hover table-bordered table-striped">
                            <tr class="info"><th>{{trans('sale.item_id')}}</th><th>{{trans('sale.item_name')}}</th><th>{{trans('sale.price')}}</th><th>{{trans('sale.quantity')}}</th><th>{{trans('item.metres_w')}}</th><th>{{trans('item.metres_h')}}</th><th>{{trans('sale.metres_square')}}</th>
                            <th>{{trans('sale.totalmetres_square')}}</th><th>{{'الخصم نقدي'}}</th><th>{{'إجمالي السعر قبل الخصم'}}</th><th>{{trans('sale.total')}}</th><th>&nbsp;</th></tr>
                            <tr class="success" ng-repeat="newsaletemp in saletemp">
                            <td>@{{newsaletemp.item_id}}</td><td>@{{newsaletemp.item.item_name}}</td><!-- <td>@{{newsaletemp.item.selling_price | currency:"L.E"}}</td> -->
                            <td ><input   type="text" style="text-align:center" autocomplete="off" name="selling_price" ng-change="updateSaleTemp(newsaletemp)" ng-model="newsaletemp.item.selling_price" size="5"></td>

                            <td ng-show="newsaletemp.item.item_type!='3'"><input ng-show="newsaletemp.item.item_type!='3'" type="text" style="text-align:center" autocomplete="off" name="quantity" ng-change="updateSaleTemp(newsaletemp)" ng-model="newsaletemp.quantity" size="2"></td>
                            <td ng-show="newsaletemp.item.item_type=='3'" style="text-align:center">@{{newsaletemp.quantity}}</td>
                            <!-- Hidden field just to retrieve item type  or newsaletemp.item.item_type=='3'  -->
                           <td ng-show="hohoho"> <input type="text" style="text-align:center" autocomplete="off" name="item_type" ng-change="updateSaleTemp(newsaletemp)" ng-model="newsaletemp.item.item_type" size="3"></td>
                             
                            <td>@{{newsaletemp.item.metres_w}}</td>
                       <!-- 
                       if roll (type=3) make it (show) input text, else show fixed text -->
                            <td ng-show="newsaletemp.item.item_type=='3'"><input ng-show="newsaletemp.item.item_type=='3'"  type="text" style="text-align:center" autocomplete="off" name="metres_h" ng-change="updateSaleTemp(newsaletemp)" ng-model="newsaletemp.item.metres_h" size="3"></td>
                         
                            <td ng-show="newsaletemp.item.item_type!='3'">@{{newsaletemp.item.metres_h}}</td>
                            <td>@{{ newsaletemp.item.metres_w * newsaletemp.item.metres_h}}</td>
                         <td>@{{ newsaletemp.item.metres_w * newsaletemp.item.metres_h*newsaletemp.quantity}}</td>
                             <td><input type="text" style="text-align:center" autocomplete="off" name="discount" ng-change="updateSaleTemp(newsaletemp)" ng-model="newsaletemp.discount" size="3"></td>
                            <td>@{{newsaletemp.item.selling_price * newsaletemp.quantity *  newsaletemp.item.metres_w * newsaletemp.item.metres_h | currency:"L.E"}}</td>
                            <td>@{{(newsaletemp.item.selling_price * newsaletemp.quantity *  newsaletemp.item.metres_w * newsaletemp.item.metres_h) - newsaletemp.discount | currency:"L.E"}}</td>

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

              
                 <!-- debtor/creditor -->


         
                   <div class="input-group">
                   <label for="amount_due" class="col-sm-4 control-label" ng-hide="cselect=='1'" >دائن</label>
                   <div class="col-sm-8">
                   <div class="input-group">
                   <div class="input-group-addon" ng-hide="cselect=='1'">L.E</div>

                  <input type="text" class="form-control" name="creditor"  size="5"  ng-model="add_payment" ng-hide="cselect=='1'" />
                </div>
                   </div>


                   <div class="input-group">
                   <label for="amount_due" class="col-sm-4 control-label" ng-hide="cselect=='1'" >مدين</label>
                   <div class="col-sm-8">
                   <div class="input-group">
                   <div class="input-group-addon" ng-hide="cselect=='1'">L.E</div>

                  <input type="text" class="form-control" name="debtor" size="5"  value="@{{sum(saletemp) -add_payment}}" ng-hide="cselect=='1'" />
                
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
                  <input type="text" class="form-control" name="amount_due" id="amount_due" size="5" ng-show="visa" value="@{{sum(saletemp) -add_payment}}" />
                
                   </div>
</div>





<br><br><div class="col-md-4 col-md-offset-8">
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