@extends('app')

@section('content')<html>


    

    




    
<div class="container">
  

    <div class="row">
        <div class="col-md-6" ng-controller="TestCtrl">
            <form name="dateForm" class="form-horizontal">
                <div class="form-group">
                    <label for="daterange1" class="control-label">Simple picker</label>
                    <input date-range-picker id="daterange1" name="daterange1" class="form-control date-picker" type="text"
                           ng-model="date" required/>
                </div>
                <div class="form-group" ng-class="{'has-error': dateForm.daterange2.$invalid}">
                    <label for="daterange2" class="control-label">Picker with min and max date</label>
                    <input date-range-picker id="daterange2" name="daterange2" class="form-control date-picker" type="text"
                           min="'2015-01-23'" max="'2015-08-25'" ng-model="date"
                           required/>
                    <div class="help-block" ng-messages="dateForm.daterange2.$error">
                        <p ng-message="min">Start date is too far in the past.</p>
                        <p ng-message="max">End date is too far in the future.</p>
                        <p ng-message="required">Range is required.</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="daterange3" class="control-label">Picker with custom locale</label>
                    <input date-range-picker id="daterange3" name="daterange3" class="form-control date-picker" type="text"
                           ng-model="date" options="opts" required/>
                </div>
                <div class="form-group">
                    <label for="daterange4" class="control-label">Clearable picker</label>
                    <input date-range-picker id="daterange4" name="daterange4" class="form-control date-picker" type="text"
                           ng-model="date" clearable="true" required/>
                </div>
                <div class="form-group">
                    <label for="daterange5" class="control-label">Picker with custom format</label>
                    <div class="input-group col-md-6" id="daterange5">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                        <input date-range-picker name="daterange5" class="form-control date-picker" type="text"
                           ng-model="date2" options="{locale: {format: 'MMMM D, YYYY'}}" required/>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-chevron-down"></span></span>
                    </div>
                </div>
                <button type="button" class="btn" ng-click="setStartDate()">Set Start Date</button>
                <button type="button" class="btn" ng-click="setRange()">Set Range</button>
            </form>

            <div class="row">
                <h4>Dates:</h4>
                <div class="col-md-12 well">
                    @{{date.endDate | date:'M-d-yyyy'}}<br>
                    @{{date2.endDate | date:'M-d-yyyy'}}<br>
                </div>
            </div>
        </div>
    </div>
</div>








<script>
exampleApp = angular.module('example', ['ngMessages', 'daterangepicker']);


exampleApp.controller('TestCtrl', function($scope) {

    $scope.date = {
         language:  'ar',
        startDate: moment().subtract(1, "days"),
        endDate: moment().format("d-M-YYYY")
    };
    $scope.date2 = {
       

        startDate: moment().subtract(1, "days"),
        endDate: moment()
    };

    $scope.opts = {
        locale: {
            applyClass: 'btn-green',
            applyLabel: "حفظ",
            fromLabel: "من",
            toLabel: "إلى",
            cancelLabel: 'إلغاء',
            customRangeLabel: 'تحديد تاريخ ',
            daysOfWeek: ['أحد', 'اثنين', 'ثلاثاء', 'أربعاء', 'خميس', 'جمعة', 'سبت'],
            firstDay: 7,
            monthNames: ['يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو', 'يوليو', 'أغسطس', 'سبتمبر',
                'أكتوبر', 'نوفمبر', 'ديسمبر'
            ]
        },
        ranges: {
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()]
        }
    };

    $scope.setStartDate = function () {
        $scope.date.startDate = moment().subtract(4, "days");
    };

    $scope.setRange = function () {
        $scope.date = {
            startDate: moment().subtract(5, "days"),
            endDate: moment()
        };
    };

    //Watch for date changes
    $scope.$watch('date', function(newDate) {
        console.log('New date set: ', newDate);
    }, false);

});

angular.bootstrap(document, ['example']);</script>


@endsection