angular.module('personalFinance').controller('NotificationController', ['$scope', function($scope){
	var self = this;	
	self.message = '';
  	self.redirectToPage = redirectToPage;

	//Set the global error message
	$scope.$on('notifyMessage', function(events, args){
		self.message = args;
	 });

	function redirectToPage(){
		switch(self.mode)
		{
			case 0:
				window.location.href = '/index.php';
				break;
			case 1:
				window.location.href = '/expenseReport.php';
				break;
			case 2:
				window.location.href = '/savingReport.php';
				break;
			case 3:
				window.location.href = '/expenseSaving.php';
				break;
			case 4:
				window.location.href = '/category.php';
				break;
		}
  	}

}]);