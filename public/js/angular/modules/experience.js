angular.module('experience', []).controller('ExperienceController', function($scope, $http) {
	this.companyname='';
	this.companies = [];
	
	this.autocomplete = function autocomplete() {
		var responsePromise = $http.get('/ajax/company/search?format=autocomplete&limit=200&name=' + this.companyname);
		var companies = this.companies;
		
        responsePromise.success(function(data, status, headers, config) {
        	companies.length = 0;
        	for (i=0; i<data.length; i++) {
        		companies.push(data[i].source);
        	}
        });
        
        responsePromise.error(function(data, status, headers, config) {
            alert("AJAX failed!");
        });
	};
	
	$scope.select = function(id) {
		
	}
});