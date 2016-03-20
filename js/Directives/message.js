angular.module('personalFinance').directive('message', ['$mdToast', function($mdToast){
	return{
		replace:true,
		scope:{
			message:'=',
		},
		link:function(scope, element, attrs){	
			scope.$watch('message', function(newVal){
				if(newVal){
					toastClass = (newVal.success == '1') ? 'success-toast': 'error-toast';
					if(newVal.message != ""){
						$mdToast.show(
					      $mdToast.simple()
					        .textContent(newVal.message)
					        .position('bottom right')
					        .hideDelay(3000)
					        .theme(toastClass)
					    );
					}
				}
			 });
		}
	}
}]);