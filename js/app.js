angular.module('personalFinance', ['ngMaterial', 'ngMessages'])
.config(['$mdThemingProvider', function($mdThemingProvider) {	
  $mdThemingProvider.theme("success-toast")
  $mdThemingProvider.theme("error-toast")
  $mdThemingProvider.theme('default')
    .primaryPalette('blue')
}]);