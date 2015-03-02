var myApp = angular.module('appgeula', ['ngRoute','ui.bootstrap','pascalprecht.translate','countrySelect']).config(function($routeProvider, $locationProvider,$translateProvider) {		 
    
	$locationProvider.html5Mode(true);	

	$translateProvider.translations('en', {
	    Your_Account: 'Your Account',
	    Settings: 'Settings.',	    
	    Profile: 'Profile',	    
	    Picture: 'Picture',	    
	    Alerts: 'Alerts',	    
	    Password: 'Password',
	    Email: 'Email',	    
	    Country: 'Country',	    
	    City: 'City',	    
	    Time_Zone: 'Time Zone',	    
	    Language_UI: 'Language UI',	
	    Save_Details: 'Save Details',	
	    Hebrew: 'Hebrew',
	    English: 'English',
	    First_Name : 'First Name',
	    Last_Name : 'Last Name',
	    Position : 'Position',
	    About : 'About'
	  });
	  $translateProvider.translations('he', {
	    Your_Account: 'החשבון שלך',
	    Settings: 'הגדרות',	    
	    Profile: 'פרופיל',	    
	    Picture: 'תמונה',	    
	    Alerts: 'התראות',	
	    Password: 'סיסמה',
	    Email: 'אימייל',	
	    Country: 'מדינה',	    
	    City: 'עיר',	    
	    Time_Zone: 'אזור זמן',	    
	    Language_UI: 'שפת ממשק',
	    Save_Details: 'שמירת נתונים',	     
	    Hebrew: 'עברית',
	    English: 'אנגלית',
	    First_Name : 'שם פרטי',
	    Last_Name : 'שם משפחה',
	    Position : 'תפקיד',
	    About : 'אודות'
	  });
	$translateProvider.preferredLanguage('he');
 	
	$routeProvider				
	.when('/', {						
	});
	/*.when('/edit-profile', {		
		templateUrl: myLocalized.theme_dir + 'partials/profile.html',
		controller: 'Profile'
	})*/	
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
	var userID = 1;

	$scope.template = {name: "edit profile 1",url: myLocalized.theme_dir + 'partials/profile.html'};
	
	$http.get('/geula/wp-admin/admin-ajax.php?action=getuser&uid=' + userID).success(function(res){	
		console.log(res);
		$scope.user = res;
	});
	
});

