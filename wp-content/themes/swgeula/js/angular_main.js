var myApp = angular.module('appgeula', ['ngRoute','ui.bootstrap','pascalprecht.translate','countrySelect']).config(function($routeProvider, $locationProvider,$translateProvider) {		 
    
	$locationProvider.html5Mode(true);	

	$translateProvider.translations('en_US', {
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
	    About : 'About',
	    Current_Password : 'Current Password',
	    New_Password : 'New Password'
	  });
	  $translateProvider.translations('he_IL', {
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
	    About : 'אודות',
	    Current_Password : 'סיסמה נוכחית',
	    New_Password : 'סיסמה חדשה'
	  });
	$translateProvider.preferredLanguage('he_IL');
 	
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
.controller('Profile', function($scope, $http, $routeParams,$translate) {
	console.log("IN");
	//console.log($location.url());
	var userID = 1;		
	
	$scope.user = {};
	$scope.PSWRD_MATCH_ERROR = false;	
	$scope.user.password = '';
	$scope.user.password2 = '';

	$scope.tabs = [
  		{active: true, disabled: false},
  		{active: false, disabled: true},
  		{active: false, disabled: true},
  		{active: false, disabled: true}
	];

		
	console.log("lang="+$translate.preferredLanguage());		

	$scope.template = {name: "edit profile 1",url: myLocalized.theme_dir + 'partials/profile.html'};
	
	
	$http.get(myLocalized.wpadmin_dir + 'admin-ajax.php?action=getuser&uid=' + userID).success(function(res){	
		//console.log(res);
		$scope.user = res;		

		$scope.user.lang = $translate.preferredLanguage();

		/*$scope.changeLanguage = function (key) {
    		$translate.use(key);
  		};*/
	});

	$scope.checkError = function()  {
		console.log("IN checkError");		
		/*if ($scope.user.password.length && $scope.user.password2.length) {
			if ($scope.user.password != $scope.user.password2) {				
				$scope.PSWRD_MATCH_ERROR = true;				
				return true;
			}
		}*/
		return false;
	}

	/*$scope.isActiveTab = function(tab){
    	return $scope.tabs[tab].active?'active':'';
  	};*/

	

	$scope.submitTheForm = function(item, event) {
	    if ($scope.checkError()) return false;
       console.log("--> Submitting form");
       var dataStr = 'action=setuser' + 
       					'&uid=2' + 
       					'&password=' + $scope.user.password +
       					'&password2=' + $scope.user.password2+
       					'&lang=' + $scope.user.lang;                    
       
        

       console.log(dataStr);
      
	   $http({
            url: myLocalized.wpadmin_dir + 'admin-ajax.php?action=setuser',
            method: "POST",
            data: dataStr,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}            
        }).success(function (data, status, headers, config) {
                console.log(data);
                if (data==1) {                	    				    					
					   	$scope.tabs[1].disabled = false;
					   	$scope.tabs[0].active = false;		
					   	$scope.tabs[1].active = true;		

                }
            }).error(function (data, status, headers, config) {
                console.log(data);
            });
     }
	
});

