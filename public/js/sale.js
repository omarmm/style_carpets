(function(){
    var app = angular.module('tutapos', [ ]);

    app.controller("SearchItemCtrl", [ '$scope', '$http', function($scope, $http) {
        $scope.items = [ ];
        $http.get('api/item').success(function(data) {
            $scope.items = data;
        });
        $scope.saletemp = [ ];
        $scope.newsaletemp = { };
        $http.get('api/saletemp').success(function(data, status, headers, config) {
            $scope.saletemp = data;
        });
        $scope.addSaleTemp = function(item, newsaletemp) {
            $http.post('api/saletemp', { item_id: item.id, cost_price: item.cost_price, selling_price: item.selling_price , item_width:item.metres_w , item_height:item.metres_h }).
            success(function(data, status, headers, config) {
                $scope.saletemp.push(data);
                    $http.get('api/saletemp').success(function(data) {
                    $scope.saletemp = data;
                    });
            });
        }
        $scope.updateSaleTemp = function(newsaletemp) {
            
            $http.put('api/saletemp/' + newsaletemp.id, { quantity: newsaletemp.quantity,  metres_w: newsaletemp.metres_w, metres_h: newsaletemp.metres_h, discount:newsaletemp.discount,  total_cost: (newsaletemp.item.cost_price * newsaletemp.quantity * newsaletemp.metres_w * newsaletemp.metres_h) - newsaletemp.discount,
                total_prediscount: (newsaletemp.item.selling_price * newsaletemp.quantity * newsaletemp.metres_w * newsaletemp.metres_h) ,
                total_selling: (newsaletemp.item.selling_price * newsaletemp.quantity * newsaletemp.metres_w * newsaletemp.metres_h) - newsaletemp.discount  }).
            success(function(data, status, headers, config) {
                
                });
        }
        $scope.removeSaleTemp = function(id) {
            $http.delete('api/saletemp/' + id).
            success(function(data, status, headers, config) {
                $http.get('api/saletemp').success(function(data) {
                        $scope.saletemp = data;
                        });
                });
        }

         $scope.prediscount = function(list) {
            var total=0;
            angular.forEach(list , function(newsaletemp){
                total+= parseFloat(newsaletemp.item.selling_price * newsaletemp.quantity * newsaletemp.metres_w * newsaletemp.metres_h );
            });
            return total;
        }

        $scope.sum = function(list) {
            var total=0;
            angular.forEach(list , function(newsaletemp){
                total+= parseFloat((newsaletemp.item.selling_price * newsaletemp.quantity * newsaletemp.metres_w * newsaletemp.metres_h) - newsaletemp.discount);
            });
            return total;
        }

    }]);
})();