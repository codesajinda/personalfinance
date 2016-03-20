angular.module('personalFinance').controller('MainController', ['$scope', 'Constants', function($scope, Constants){
	var self = this;	
  self.expense = {};
  self.saving = {};
  self.submitForm = submitForm;
	self.message = Constants.message;
  self.savingCategories = (Constants.savingCategories != '') ? JSON.parse(Constants.savingCategories) : [];
  self.expenseCategories = (Constants.expenseCategories != '') ? JSON.parse(Constants.expenseCategories) : [];


  $scope.$emit('notifyMessage', self.message);

  function submitForm(form, event){
    if(form.$invalid){
      event.preventDefault();
    }
  }

  function createFilterFor(query, name) {
    var lowercaseQuery = angular.lowercase(query);
    return function filterFn(text) {
      return (text[name].indexOf(lowercaseQuery) === 0);
    };
  }

}]);