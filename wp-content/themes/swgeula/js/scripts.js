angular.module('appgeula', ['ngRoute'])
.config(function($routeProvider, $locationProvider) {
	$locationProvider.html5Mode(true);
 
	$routeProvider
	.when('/', {
		templateUrl: myLocalized.partials + 'content.html',
		controller: 'Content'
	})
	.when('/:ID', {
		templateUrl: myLocalized.partials + 'single.html',
		controller: 'Single'
	});
	otherwise({
		if (document.location.href.indexOf("127.0.0.1")!=-1) redirectTo: '/geula'
        else redirectTo: '/'
    });
})
.controller('Content', function($scope, $http, $routeParams) {
	$http.get('wp-json/posts/').success(function(res){
		$scope.posts = res;
	});
})
.controller('Single', function($scope, $http, $routeParams) {
	$http.get('wp-json/posts/' + $routeParams.ID).success(function(res){
		$scope.post = res;
	});
});
