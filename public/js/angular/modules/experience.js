angular.module('experience', []).controller('ExperienceController', function($scope, $http) {
	
	$scope.companyname='';
	$scope.companies = [];
	$scope.history = [];
	$scope.selectedJobArea = [];
	$scope.selectedJobStatus = [];
	$scope.selectedCommitteeRole = [];
	
	$scope.lookups = [];
	
	$scope.lookups.jobstatus = [];
	loadLookupData('jobstatus');
	
	$scope.lookups.committeerole = [];
	loadLookupData('committeerole');
	
	$scope.lookups.jobarea = [];
	loadLookupData('jobarea');
	
	function loadLookupData(resourceName)
	{
		var responsePromise = $http.get('/api/lookup/' + resourceName);
		
        responsePromise.success(function(data, status, headers, config) {
        	$scope.lookups[resourceName] = data._embedded[resourceName];
        	
        	var checks = ['jobarea', 'jobstatus', 'committeerole'];
        	var allDone = true;
        	for (var i=0; i<checks.length; i++) {
        		if (checks[i].length == 0) {
        			allDone = false;
        		}
        	}
        	
        	if (allDone) {
        		loadHistory();
        	}
        });
        
        responsePromise.error(function(data, status, headers, config) {
            alert("Loading lookup data for " + resourceName + " failed.");
        });
	}

	$scope.$watch(function() {return element.attr('class'); }, function(newValue){ alert(newValue);});
	
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
            alert("Autocomplete AJAX failed!");
        });
	};
	
	function findDropDownObject(resourceName, index) {
		for (var i=0; i<$scope.lookups[resourceName].length; i++) {
			if ($scope.lookups[resourceName][i][resourceName + 'id'] == index) {
				return $scope.lookups[resourceName][i];
			}
		}
		
		var key = resourceName + 'id';
		var retVal = {};
		retVal[key] = -1;
		
		return retVal;
		
 	}
	
	function loadHistory() {
		var historyPromise = $http.get('/ajax/experience/history');
		
		historyPromise.success(function(data, status, headers, config) {
			$scope.history = [];
			for (var i=0; i<data.length; i++) {
				$scope.history[i] = {
					'arrayindex': i,
					'companyid': -1,
					'companydirectoryid': data[i].companydirectoryid,
					'name': data[i].name,
					'fromdate': data[i].fromdate,
					'todate': data[i].todate,
					'title': data[i].title,
					"jobstatus":findDropDownObject('jobstatus', data[i].jobstatusid),
					'jobarea': findDropDownObject('jobarea', data[i].jobareaid),
					"committeerole":findDropDownObject('committeerole', data[i].committeeroleid),
				};
			}
		});
		
		historyPromise.error(function(data, status, headers, config) {
			alert("Load history AJAX failed!");
		});
	}
	
	$scope.updateHistory = function() {

		var flatHistory = [];
		
		for (var i=0; i<$scope.history.length; i++) {
			flatHistory[i] = {
				'companyid' : $scope.history[i].companyid,
				'companydirectoryid' : $scope.history[i].companydirectoryid,
				'fromdate': $scope.history[i].fromdate,
				'name': $scope.history[i].name,
				'todate': $scope.history[i].todate,
				'title': $scope.history[i].title,
				'jobstatusid': $scope.history[i].jobstatus.jobstatusid,
				'jobareaid': $scope.history[i].jobarea.jobareaid,
				'committeeroleid': $scope.history[i].committeerole.committeeroleid
			}
		}
		
		var historyPromise = $http.post('/ajax/experience/history', flatHistory);
		
		historyPromise.success(function(data, status, headers, config) {
		});
		
		historyPromise.error(function(data, status, headers, config) {
			alert("Update History AJAX failed!");
		});
	}
	
	/**
	 * New company added to list
	 */
	$scope.select = function(arrayindex) {
		
		$scope.history.push({
			'arrayindex': $scope.history.length,
			'companyid': $scope.companies[arrayindex].companyid,
			'companydirectoryid': '',
			'name': $scope.companies[arrayindex].name,
			'fromdate': '',
			'todate': '',
			'title': '',
			'jobstatus': {'jobstatusid':-1},
			'jobarea': {'jobareaid':-1},
			'committeerole': {'committeeroleid':-1},
		});
		
		var elementId = '#companyid-' + $scope.companies[arrayindex].companyid;
		
		setTimeout(function () {
			$(elementId).css('display', 'none');
			$(elementId).fadeIn(1200, function () {});
		}, 0);
		
		$scope.companies = [];
		
		$scope.updateHistory();
	}
	
	$scope.remove = function(companyId) {
		
		if (confirm('Do you wish to remove this company from your history?')) {
			var elementId = '#companyid-' + companyId;
			
			$(elementId).fadeOut('slow', function () {
				var foundIndex = -1;
				
				for (var i=0; i<$scope.history.length; i++) {
					if ($scope.history[i].companyid == companyId) {
						foundIndex = i;
						break;
					}
				}
		
				if (foundIndex != -1) {
					$scope.history.splice(foundIndex, 1);
				}
				
				setTimeout(function () {
					$scope.updateHistory();
				});
			});

		}
	}
	
	function setupDatefields()
	{
		alert(1);
		$('.date-entry').datepicker( { 
			changeYear: true, yearRange: "1920:2020",
			dateFormat: "yy-mm-dd",
			inline: true,
			defaultDate: 0,
	        showOtherMonths: true,  
	        dayNamesMin: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat']}
		);
	}

});