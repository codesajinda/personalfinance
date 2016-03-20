angular.module('personalFinance').controller('UserController', ['$scope', 'Constants', function($scope, Constants){
	var self = this;	
  self.submitForm = submitForm;
	self.message = Constants.message;

  $scope.$emit('notifyMessage', self.message);

  function submitForm(form, event){
    if(form.$invalid){
      event.preventDefault();
    }
  }

}]);