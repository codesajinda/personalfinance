angular.module('personalFinance').controller('WidgetController', ['$scope', 'Constants', '$filter', function($scope, Constants, $filter){
	var self = this;	
	self.message = '';
	self.widgetOneExpense = 0;
	self.widgetOneSavings = 0;
	self.currentMonthExpenses = [];
	self.currentMonthSavings = [];
	self.currentMonthCategoryExpenses = [];
	self.currentMonthCategoryExpenseTotal = 0;
	self.expenses = [];
	self.savings = [];
	self.widgetOneSavingsClass = 'green-text';
	self.expenseSavings = (Constants.expenseSavings != '') ? JSON.parse(Constants.expenseSavings) : [];
	console.log(self.expenseSavings);

	//Set the global error message
	$scope.$on('notifyMessage', function(events, args){
		self.message = args;
	 });

	buildExpenseSavingWidget();
	buildExpenseSavingWidgetTwo();
	buildCategoryExpenseWidgetThree();

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

				if( date >= self.lastMonthDate && date <= self.todaysDate){
					self.expenseSavings[0][i].ExpenseDate = $filter('date')(date, 'fullDate');
					self.currentMonthExpenses.push(self.expenseSavings[0][i]);
					expense = parseFloat(self.expenseSavings[0][i].Amount) + parseFloat(expense);
				}
			}
			for (var i = 0; i < self.expenseSavings[1].length; i++) {
				var date = new Date(self.expenseSavings[1][i].SavingDate)		

				if(date >= self.lastMonthDate && date <= self.todaysDate){
					self.expenseSavings[1][i].SavingDate = $filter('date')(date, 'fullDate');
					self.currentMonthSavings.push(self.expenseSavings[1][i]);
					self.expenseSavings[1][i].Amount;
					saving =  parseFloat(self.expenseSavings[1][i].Amount) +  parseFloat(saving);
				}
			}
		}
		self.expenseOrSaving = parseFloat(saving - expense);
		self.widgetTwoSavingsClass = (self.expenseOrSaving > 0) ? 'green-text':'red-text';
	}

	function buildCategoryExpenseWidgetThree(){
		var date = new Date();
		var firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
		var lastDay = new Date(date.getFullYear(), date.getMonth() + 1);
		var total = 0;
		if(self.expenseSavings.length > 0){
			for (var i = 0; i < self.expenseSavings[0].length; i++) {
				var date = new Date(self.expenseSavings[0][i].ExpenseDate)		

				if(date >= firstDay && date < lastDay){
					total = total + parseInt(self.expenseSavings[0][i].Amount);
					var mainObject =		
							{
								CategoryID: self.expenseSavings[0][i].CategoryID,
								CategoryName: self.expenseSavings[0][i].CategoryName,
								Amount: 0,
							};
					 var index = getIndexOfObject(self.currentMonthCategoryExpenses, mainObject, 'CategoryID');
					 if(index > -1){
					 	self.currentMonthCategoryExpenses[index].Amount = self.currentMonthCategoryExpenses[index].Amount + parseInt(self.expenseSavings[0][i].Amount);
					 	
					 }		
					 else{
					 	mainObject.Amount = mainObject.Amount + parseInt(self.expenseSavings[0][i].Amount);
					 	self.currentMonthCategoryExpenses.push(mainObject);
					 }			
					
				}
			}
			self.currentMonthCategoryExpenseTotal = total;
		}
	}

	function getIndexOfObject(array, obj, proprerty){
		var index = -1;
		for (var i = 0; i < array.length; i++) {
			if(array[i][proprerty] == obj[proprerty]){	
				index = i;
				break;
			}
		}
		return index;
	}

}]);