angular.module('experience', []).controller('ExperienceController', function() {
	this.companyname='a company';
	this.companies = ['a', 'b'];
	
	this.autocomplete = function autocomplete() {
		var url = '/ajax/company/search?format=autocomplete&limit=20&name=' + this.companyname;
		
		var companies = this.companies;
		
        $.ajax({
            url: url,
            success: function(data) {
            	companies.length = 0;
            	for (i=0; i<data.length; i++) {
            		companies.push(data[i].label);
            	}
            }
        });
	};
});