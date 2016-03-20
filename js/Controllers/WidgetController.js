angular.module('personalFinance').controller('WidgetController', ['$scope', 'Constants', function($scope, Constants){
	var self = this;	
	self.message = '';
	self.widgetOneExpense = 0;
	self.widgetOneSavings = 0;
	self.currentMonthExpenses = [];
	self.currentMonthSavings = [];
	self.expenses = [];
	self.savings = [];
	self.widgetOneSavingsClass = 'green-text';
	self.expenseSavings = (Constants.expenseSavings != '') ? JSON.parse(Constants.expenseSavings) : [];

	//Set the global error message
	$scope.$on('notifyMessage', function(events, args){
		self.message = args;
	 });

	buildExpenseSavingWidget();
	buildExpenseSavingWidgetTwo();

	function buildExpenseSavingWidget(){
		self.widgetOneExpense = 0;
		self.widgetOneSavings = 0;
		var savings = 0;
		if(self.expenseSavings.length > 0){
			for (var i = 0; i < self.expenseSavings[0].length; i++) {
				self.widgetOneExpense = self.widgetOneExpense + parseFloat(self.expenseSavings[0][i].Amount);
				self.expenses.push(self.expenseSavings[0][i]);
			}
			for (var i = 0; i < self.expenseSavings[1].length; i++) {
				savings = savings + parseFloat(self.expenseSavings[1][i].Amount);
				self.savings.push(self.expenseSavings[1][i]);
			}
		}
		self.widgetOneSavings = savings - self.widgetOneExpense;	
		self.widgetOneSavingsClass = (self.widgetOneSavings > 0) ? 'green-text':'red-text';

	}

	function buildExpenseSavingWidgetTwo(){
		var expense = 0;
		var saving  = 0;
		self.expenseOrSaving = 0;
		self.todaysDate = new Date();
		self.lastMonthDate = new Date(self.todaysDate.getFullYear(), self.todaysDate.getMonth() - 1, self.todaysDate.getDate());
		if(self.expenseSavings.length > 0){
			for (var i = 0; i < self.expenseSavings[0].length; i++) {
				var date = new Date(self.expenseSavings[0][i].ExpenseDate)		

				if(self.lastMonthDate >= date && date <= self.todaysDate){
					self.currentMonthExpenses.push(self.expenseSavings[0][i]);
					expense += self.expenseSavings[0][i].Amount + expense;
				}
			}
			for (var i = 0; i < self.expenseSavings[1].length; i++) {
				var date = new Date(self.expenseSavings[1][i].SavingDate)		

				if(self.lastMonthDate >= date && date <= self.todaysDate){
					self.currentMonthSavings.push(self.expenseSavings[1][i]);
					self.expenseSavings[1][i].Amount;
					saving += self.expenseSavings[1][i].Amount + saving;
				}
			}
		}
		self.expenseOrSaving = saving - expense;
		self.widgetTwoSavingsClass = (self.widgetTwoSavingsClass > 0) ? 'green-text':'red-text';
	}

}]);