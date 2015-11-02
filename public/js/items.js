(function(){
    var app = angular.module('tutapos', [ ]);

	
		/* app.config(function($interpolateProvider) {
  $interpolateProvider.startSymbol('{[');
  $interpolateProvider.endSymbol(']}');
}); */
	
	
    app.controller("SearchItemCtrl", [ '$scope', '$http', function($scope, $http) {
        $scope.items = [ ];
        $http.get('api/item').success(function(data) {
            $scope.items = data;
			
	
		
        });
        
        
        
        
        

    }]);
	

 

})();