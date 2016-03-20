angular.module('personalFinance').controller('CategoryController', ['$scope', 'Constants', function($scope, Constants){
	var self = this;	
	self.categories = (Constants.categories) ? JSON.parse(Constants.categories) : [];
	self.category = {};
	self.categoryTypes = [{key:2, value:'Saving'},{key:1, value:'Expense'}];
	self.message = Constants.message;

	$scope.$emit('notifyMessage', self.message);
}]);