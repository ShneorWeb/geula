var myApp = angular.module('appgeula', ['ngRoute','ui.bootstrap','pascalprecht.translate']).config(function($routeProvider, $locationProvider,$translateProvider) {		 
    
	$locationProvider.html5Mode(true);	

	$translateProvider.translations('en', {
	    Your_Account: 'Your Account',
	    Settings: 'Settings.',	    
	    Profile: 'Profile.',	    
	    Picture: 'Picture.',	    
	    Alerts: 'Alerts.',	    
	    Password: 'Password',
	    Email: 'Email',	    
	    Country: 'Country',	    
	    City: 'City',	    
	    Time_Zone: 'Time Zone',	    
	    Language_UI: 'Language UI',	
	    Save_Details: 'Save Details',	
	  });
	  $translateProvider.translations('he', {
	    Your_Account: 'החשבון שלך',
	    Settings: 'הגדרות',	    
	    Profile: 'פרופיל.',	    
	    Picture: 'תמונה.',	    
	    Alerts: 'התראות.',	
	    Password: 'סיסמה',
	    Email: 'אימייל',	
	    Country: 'מדינה',	    
	    City: 'עיר',	    
	    Time_Zone: 'אזור זמן',	    
	    Language_UI: 'שפת ממשק',
	    Save_Details: 'שמירת נתונים',	     
	  });
	$translateProvider.preferredLanguage('he');
 	
	$routeProvider				
	.when('/', {				
		controller: 'Profile'
	})
	.when('/edit-profile', {		
		templateUrl: myLocalized.partials + 'profile.html',
		controller: 'Profile'
	})	
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
})
.controller('Profile', function($scope, $http, $routeParams,$location,$window) {
	console.log("IN");
	console.log($location.url());
	$scope.tabs = [
	    { title:'Dynamic Title 1', content:'Dynamic content 1' },
	    { title:'Dynamic Title 2', content:'Dynamic content 2', disabled: true }
	  ];

	  $scope.alertMe = function() {
	    setTimeout(function() {
	      $window.alert('You\'ve selected the alert tab!');
	    });
	  };


	if ($location.url().indexOf("eprf")!=-1) $scope.template = {name: "edit profile 1",url: myLocalized.partials + 'profile.html'};	
	//else $scope.template = {name: "edit profile 2",url: myLocalized.partials + 'profile2html'};	

	//if ($location.url().indexOf("edit-profile/2")!=-1) $location.path("/edit-profile/2");
	//else $location.path("/edit-profile");
	//$scope.$routeParams = $routeParams;		
	/*myApp.run(['$route', function($route)  {
  		$route.reload();
	}]);*/
	//myApp.run(['$route', angular.noop]);
	/*$scope.templates =
    [ { name: 'profile1', url: 'partials/profile1.html'},
      { name: 'profile2', url: 'partials/profile2.html'} ];
  	$scope.template = $scope.templates[0];	
	console.log("IN2");*/
});

/*.controller('MainCtrl',[ // <- Use this controller outside of the ng-view!
  '$rootScope','$window',
  function($rootScope,$window){
    $rootScope.$on("$routeChangeStart", function (event, next, current) {
      // next.$$route <-not set when routed through 'otherwise' since none $route were matched
      if (next && !next.$$route) {
        event.preventDefault(); // Stops the ngRoute to proceed with all the history state logic
        // We have to do it async so that the route callback 
        // can be cleanly completed first, so $timeout works too
        $rootScope.$evalAsync(function() {
          // next.redirectTo would equal be 'http://yourExternalSite.com/404.html'
          $window.location.href = next.redirectTo;
        });
      }
    });
  }
]);*/
/*
myApp.run(function($location, $rootElement) {
  		$rootElement.off('click');
	})
}*/
/*
angular.module('appgeula',['appgeula.directives']);
var myModule = angular.module('appgeula.directives', []);

myModule.directive('edprofile', function() {
    return { 
        restrict:'E',
        replace:true,
        templateUrl: myLocalized.partials + 'profile1.html',
    }
});
*/
