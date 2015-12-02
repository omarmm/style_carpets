(function(){
    var app = angular.module('tutapos', [ ]);

    app.controller("SearchItemCtrl", [ '$scope', '$http', function($scope, $http) {
        $scope.items = [ ];
        $http.get('api/item').success(function(data) {
            $scope.items = data;
        });


        $scope.suppliers = [ ];
        $http.get('api/supplier').success(function(data) {
            $scope.suppliers = data;
 
});


        $scope.receivingtemp = [ ];
        $scope.newreceivingtemp = { };
        $http.get('api/receivingtemp').success(function(data, status, headers, config) {
            $scope.receivingtemp = data;
        });
        $scope.addReceivingTemp = function(item,newreceivingtemp) {
            $http.post('api/receivingtemp', { item_id: item.id, type: item.type, cost_price: item.cost_price, selling_price: item.selling_price , metres_w:item.metres_w , metres_h:item.metres_h,
             metres_square:item.metres_w * item.metres_h,totalmetres_square:   item.metres_w * item.metres_h , 

             total_selling: (item.selling_price * item.metres_w * item.metres_h) ,
             total_prediscount:(item.selling_price * item.metres_w * item.metres_h) }).
            success(function(data, status, headers, config) {
                $scope.receivingtemp.push(data);
                    $http.get('api/receivingtemp').success(function(data) {
                    $scope.receivingtemp = data;
                    });
            });
        }
        $scope.updateReceivingTemp = function(newreceivingtemp) {
            $http.put('api/receivingtemp/' + newreceivingtemp.id, { quantity: newreceivingtemp.quantity,  metres_w: newreceivingtemp.item.metres_w, metres_h: newreceivingtemp.item.metres_h,
                metres_square:newreceivingtemp.item.metres_w * newreceivingtemp.item.metres_h,totalmetres_square:  newreceivingtemp.quantity * newreceivingtemp.item.metres_w * newreceivingtemp.item.metres_h,selling_price:newreceivingtemp.item.selling_price,
              discount:newreceivingtemp.discount,  total_cost: (newreceivingtemp.item.cost_price * newreceivingtemp.quantity * newreceivingtemp.item.metres_w * newreceivingtemp.item.metres_h) - newreceivingtemp.discount,
                total_prediscount: (newreceivingtemp.item.selling_price * newreceivingtemp.quantity * newreceivingtemp.item.metres_w * newreceivingtemp.item.metres_h) ,
                total_selling: (newreceivingtemp.item.selling_price * newreceivingtemp.quantity * newreceivingtemp.item.metres_w * newreceivingtemp.item.metres_h) - newreceivingtemp.discount }).
            success(function(data, status, headers, config) {
                });
        }
        $scope.removeReceivingTemp = function(id) {
            $http.delete('api/receivingtemp/' + id).
            success(function(data, status, headers, config) {
                $http.get('api/receivingtemp').success(function(data) {
                        $scope.receivingtemp = data;
                        });
                });
        }  

         $scope.prediscount = function(list) {
            var total=0;
            angular.forEach(list , function(newreceivingtemp){
                total+= parseFloat(newreceivingtemp.item.selling_price * newreceivingtemp.quantity * newreceivingtemp.item.metres_w * newreceivingtemp.item.metres_h );
            });
            return total;
        }


        $scope.sum = function(list) {
            var total=0;
            angular.forEach(list , function(newreceivingtemp){
                total+= parseFloat((newreceivingtemp.item.selling_price * newreceivingtemp.quantity * newreceivingtemp.item.metres_w * newreceivingtemp.item.metres_h) - newreceivingtemp.discount);
            });
            return total;
        }

    }]);
})();