(function(){
    var app = angular.module('tutapos', [ ]);


    app.controller("SearchItemCtrl", [ '$scope', '$http', function($scope, $http) {
        $scope.items = [ ];


        $http.get('api/item').success(function(data) {
            $scope.items = data;
        });

       
        $scope.customers = [ ];
        $http.get('api/customer').success(function(data) {
            $scope.customers = data;
 
});


//customer default value نقدي
$scope.cselect = '1';

// $scope.set_color = function (creditor) {
//   if (cselect > 0) {
//     return { color: "red" }
//   }
// }

// $scope.salecustomer = [ ];
//  $scope.newcustomer = { };
//   $http.get('api/customer').success(function(data, status, headers, config) {
//             $scope.salecustomer = data;
//         });
//  $scope.customer = function(customer, newcustomer) {
            
//             $http.post('api/customer/' , { customer_id:customer.id,opening_debtor: customer.opening_debtor }).
//             success(function(data, status, headers, config) {

//                  $scope.salecustomer.push(data);
//                     $http.get('api/customer').success(function(data) {
//                     $scope.salecustomer = data;
//                     });
                
//                 });
//         }

//  $scope.updateSaleCustomer = function(newcustomer) {
            
//             $http.put('api/customer/' + newcustomer.id, { opening_debtor: newcustomer.customer.opening_debtor  }).
//             success(function(data, status, headers, config) {
                
//                 });
//         }

// $http({
//     url: "api/customer",
//         method: "POST",
//         data:{opening_debtor:app.opening_debtor}
//     }).success(function(data, status, headers, config) {
//         $scope.data = data;
//     }).error(function(data, status, headers, config) {
//         $scope.status = status;
// });






        $scope.saletemp = [ ];
        $scope.newsaletemp = { };
        $http.get('api/saletemp').success(function(data, status, headers, config) {
            $scope.saletemp = data;
        });
        $scope.addSaleTemp = function(item, newsaletemp) {
        
            $http.post('api/saletemp', { item_id: item.id, cost_price: item.cost_price, selling_price: item.selling_price , metres_w:item.metres_w , metres_h:item.metres_h }).
            success(function(data, status, headers, config) {
                $scope.saletemp.push(data);
                    $http.get('api/saletemp').success(function(data) {
                    $scope.saletemp = data;
                    });
            });
        }
        $scope.updateSaleTemp = function(newsaletemp) {
            
            $http.put('api/saletemp/' + newsaletemp.id, { quantity: newsaletemp.quantity,  metres_w: newsaletemp.item.metres_w, metres_h: newsaletemp.item.metres_h,metres_square:newsaletemp.item.metres_w * newsaletemp.item.metres_h,totalmetres_square:  newsaletemp.quantity * newsaletemp.item.metres_w * newsaletemp.item.metres_h,  discount:newsaletemp.discount,  total_cost: (newsaletemp.item.cost_price * newsaletemp.quantity * newsaletemp.item.metres_w * newsaletemp.item.metres_h) - newsaletemp.discount,
                total_prediscount: (newsaletemp.item.selling_price * newsaletemp.quantity * newsaletemp.item.metres_w * newsaletemp.item.metres_h) ,
                total_selling: (newsaletemp.item.selling_price * newsaletemp.quantity * newsaletemp.item.metres_w * newsaletemp.item.metres_h) - newsaletemp.discount  }).
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
                total+= parseFloat(newsaletemp.item.selling_price * newsaletemp.quantity * newsaletemp.item.metres_w * newsaletemp.item.metres_h );
            });
            return total;
        }

        $scope.sum = function(list) {
            var total=0;
            angular.forEach(list , function(newsaletemp){
                total+= parseFloat((newsaletemp.item.selling_price * newsaletemp.quantity * newsaletemp.item.metres_w * newsaletemp.item.metres_h) - newsaletemp.discount);
            });
            return total;
        }

    }]);
})();