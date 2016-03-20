angular.module('personalFinance').service('HttpService', ['$http', '$httpParamSerializerJQLike', function($http, $httpParamSerializerJQLike){
	var httpService = {};
	httpService.post = function(url, data){
		var urlEncodedData = urlEncode(data);

		return $http.post(url, {data: data}, {headers:{'Content-Type': 'application/x-www-form-urlencoded'}});
	}
	httpService.get = function(url, method){
		return $http.get(url, {method:method});
	}

	function urlEncode(data){
		var encodeString = '?';
		angular.forEach(data, function(value, key) {
  			encodeString += key + '=' + value + '&';
		});
		encodeString = encodeString.substr(0, encodeString.lastIndexOf('&'));
		return encodeString;
	}
	return httpService;
}]);