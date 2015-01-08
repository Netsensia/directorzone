angular.module('experience', []).controller('ExperienceController', function($scope, $http) {
	$scope.companyname='';
	$scope.companies = [];
	$scope.history = [];
	
	$scope.autocomplete = function() {
		var responsePromise = $http.get('/ajax/company/search?format=autocomplete&limit=200&name=' + this.companyname);
		var companies = $scope.companies;
		
        responsePromise.success(function(data, status, headers, config) {
        	companies.length = 0;
        	for (i=0; i<data.length; i++) {
        		var companyDetails = data[i].source;
        		companyDetails['arrayindex'] = i;
        		companies.push(companyDetails);
        	}
        });
        
        responsePromise.error(function(data, status, headers, config) {
            alert("AJAX failed!");
        });
	};
	
	$scope.select = function(arrayindex) {
		
		var responsePromise = $http.get('/ajax/company/search?format=autocomplete&limit=200&name=' + this.companyname);
		
		responsePromise.success(function(data, status, headers, config) {
			$scope.history.push($scope.companies[arrayindex]);
			$scope.companies = [];
        });
        
        responsePromise.error(function(data, status, headers, config) {
            alert("AJAX failed!");
            $scope.companies = [];
        });
	}
});