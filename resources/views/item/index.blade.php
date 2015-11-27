@extends('app')

@section('content')


{!! Html::script('js/angular.min.js', array('type' => 'text/javascript')) !!}
{!! Html::script('js/items.js', array('type' => 'text/javascript')) !!}


<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">{{trans('item.list_items')}}</div>
               
				<div class="panel-body">
				<a class="btn btn-small btn-success" href="{{ URL::to('items/create') }}">{{trans('item.new_item')}}</a>
				<hr />
@if (Session::has('message'))
	<div class="alert alert-info">{{ Session::get('message') }}</div>
@endif

<div  ng-controller="SearchItemCtrl" >
             <!-- <table class="table table-striped table-bordered">  -->  
             
             <table class="table table-hover table-bordered table-striped">          
                        <thead>
        <tr class="info">
           
            <td>{{trans('item.item_code')}}</td>
            <td>{{trans('item.item_name')}}</td>
            <!-- <td>{{'تصنيف الصنف'}}</td> -->
            <td>{{trans('item.cost_price')}}</td>
            <td>{{trans('item.selling_price')}}</td>
            <td>{{trans('item.quantity')}}</td>
            <td>&nbsp;</td>
            <td>{{trans('item.avatar')}}</td>
        </tr>
    </thead>         
                    
                        <label>{{'البحث بكود الصنف'}} <input ng-model="search.id" class="form-control" ></label>&nbsp;
                        <label>{{'البحث باسم المنتج'}} <input ng-model="search.item_name" class="form-control"></label>&nbsp;
                        
<!--                         <label>{{'البحث بالتصنيف'}} <input ng-model="search.item_category" class="form-control"></label>
 -->                   <tbody>
                        <tr class="success" ng-repeat="item in items  | filter: search" ng-init="filter_len = (items | filter: search).length">
                        <td >@{{item.id}}</td>
                        <td>@{{item.item_name}}</td>
                        <!-- <td>@{{item.item_category}}</td> -->
                        <td>@{{item.cost_price}}</td>
                        <td>@{{item.selling_price}}</td>
                        <td>@{{item.quantity}}</td>
                      
                      <!-- <td>@{{filter_len}}</td> -->
                      

            <td>
                
             <a class="btn btn-small btn-success" href="../index.php/inventory/@{{item.id}}/edit">{{trans('item.inventory')}}</a>
                <a class="btn btn-small btn-info" href="../index.php/items/@{{item.id}}/edit">{{trans('item.edit')}}</a>
                <!-- {!! Form::open(array('url' => 'items/' . '1', 'class' => 'pull-right')) !!}
                    {!! Form::hidden('_method', 'DELETE') !!}
                    {!! Form::submit(trans('item.delete'), array('class' => 'btn btn-warning')) !!}
                {!! Form::close() !!} -->
               <form ng-init="myPath = '{{ URL::to("items/") }}/'+ item.id " action="@{{myPath}}" method="POST"  accept-charset="UTF-8" class="pull-right"><input name="_token" type="hidden" value="d5DnqFfsqNpHtto9tJFGxXwWaVqOOlhXAnm1gmqu">
                    <input name="_method" type="hidden" value="DELETE">
                    <input class="btn btn-warning" type="submit" value="مسح">
                </form>

            </td>
           <!-- <td>{!! Html::image(url() . '/images/items/' . '@{{item.avatar}}', 'a picture', array('class' => 'thumb')) !!}</td> -->
            <td><img src="../images/items/@{{item.avatar}}" class="thumb" alt="a picture"></td>
        </tr>
     
    </tbody>
</table>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
@endsection