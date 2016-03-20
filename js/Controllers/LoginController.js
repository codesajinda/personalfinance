angular.module('personalFinance').controller('LoginController', ['$scope', 'Constants', function($scope, Constants){
	var self = this;	
	self.message = Constants.message;

	$scope.$emit('notifyMessage', self.message);
}]);