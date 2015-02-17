angular.module('appgeula', ['ngRoute'])
.config(function($routeProvider, $locationProvider) {
	$locationProvider.html5Mode(true);
 
	$routeProvider
	.when('/', {
<<<<<<< HEAD
		templateUrl: myLocalized.partials + 'main.html',
		controller: 'Main'
	})
	.when('/:ID', {
		templateUrl: myLocalized.partials + 'content.html',
		controller: 'Content'
	});
})
.controller('Main', function($scope, $http, $routeParams) {
=======
		templateUrl: myLocalized.partials + 'content.html',
		controller: 'Content'
	})
	.when('/:ID', {
		templateUrl: myLocalized.partials + 'single.html',
		controller: 'Single'
	});
})
.controller('Content', function($scope, $http, $routeParams) {
>>>>>>> 1622975fcd9a395ad14f5f7f0d106eb4604e82b2
	$http.get('wp-json/posts/').success(function(res){
		$scope.posts = res;
	});
})
<<<<<<< HEAD
.controller('Content', function($scope, $http, $routeParams) {
=======
.controller('Single', function($scope, $http, $routeParams) {
>>>>>>> 1622975fcd9a395ad14f5f7f0d106eb4604e82b2
	$http.get('wp-json/posts/' + $routeParams.ID).success(function(res){
		$scope.post = res;
	});
});
