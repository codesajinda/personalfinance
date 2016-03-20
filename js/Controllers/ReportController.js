angular.module('personalFinance').controller('ReportController', ['$scope', 'Constants', function($scope, Constants){
	var self = this;	
  self.expenseReport = {};
  self.savingReport = {};
  self.submitForm = submitForm;
  self.expenseCategories = (Constants.expenseCategories) ? JSON.parse(Constants.expenseCategories) : [];
  self.savingCategories = (Constants.savingCategories) ? JSON.parse(Constants.savingCategories) : [];
  self.expenseReportData = (Constants.expenseReportData) ? JSON.parse(Constants.expenseReportData) : [];
  self.savingReportData = (Constants.savingReportData) ? JSON.parse(Constants.savingReportData) : [];
	self.message = Constants.message;
  self.dateFromExpenseChanged = dateFromExpenseChanged;
  self.dateFromSavingChanged = dateFromSavingChanged; 
  self.totalAmount = 0;

  $scope.$emit('notifyMessage', self.message);

  function submitForm(form, event){
    if(form.$invalid){
      event.preventDefault();
    }
  }

  function dateFromExpenseChanged(){
    self.expenseReport.To = null;
  }

  function dateFromSavingChanged(){
    self.savingReport.To = null;
  }

  function calculateExpensesAmount(){
    for (var i = 0; i < self.expenseReportData.length; i++) {
        self.totalAmount = self.totalAmount + parseFloat(self.expenseReportData[i].Amount);
    }
  }
  function calculateSavingsAmount(){
    for (var i = 0; i < self.savingReportData.length; i++) {
        self.totalAmount = self.totalAmount + parseFloat(self.savingReportData[i].Amount);
    }
  }
  calculateExpensesAmount();
  calculateSavingsAmount();
}]);