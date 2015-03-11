var myApp = angular.module('appgeula', ['ngRoute','ui.bootstrap','pascalprecht.translate','countrySelect','angularFileUpload']).config(function($routeProvider, $locationProvider,$translateProvider) {		 
    
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
	    New_Password : 'New Password',
	    Choose_file_to_upload : 'Choose file to upload',
	    Drop_Text : 'Drop image here or click to upload',
	    Drop_Not_Supported : 'File Drag/Drop is not supported for this browser',
	    Select_Country : 'Select Country',
	    Select_City : 'Select City',
	    Select_Timezone : 'Select Timezone'
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
	    New_Password : 'סיסמה חדשה',
	    Choose_file_to_upload : 'בחר תמונה להעלות',
	    Drop_Text : 'גרור תמונה לכאן או לחץ לבחור תמונה',
	    Drop_Not_Supported : 'גרירה אינה נתמכת לדפדפן זה',
		Select_Country : 'בחר מדינה',
		Select_City : 'בחר עיר',
		Select_Timezone : 'בחר אזור זמן'
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
.controller('Profile', ['$scope', '$http', '$routeParams','$translate','$upload', function($scope, $http, $routeParams,$translate,$upload) {
	console.log("IN");
	//console.log($location.url());
	var userID = 1;		
	
	$scope.user = {};
	$scope.PSWRD_MATCH_ERROR = false;	
	$scope.user.password = '';
	$scope.user.password2 = '';
	$scope.countries = [];
	$scope.cities = [];	

	$scope.tabs = [
  		{active: true, disabled: false},
  		{active: false, disabled: false},
  		{active: false, disabled: false},
  		{active: false, disabled: false}
	];

		
	console.log("lang="+$translate.preferredLanguage());		

	$scope.template = {name: "edit profile 1",url: myLocalized.theme_dir + 'partials/profile.html'};
	
	
	$http.get(myLocalized.wpadmin_dir + 'admin-ajax.php?action=getuser&uid=2').success(function(res){	
		console.log(res);
		$scope.user = res;		

		$scope.user.lang = $translate.preferredLanguage();

		/*$scope.changeLanguage = function (key) {
    		$translate.use(key);
  		};*/
	});

	$http.get(myLocalized.wpadmin_dir + 'admin-ajax.php?action=getctrselect').success(function(res){		
		//console.log(res);
		 $scope.countries = eval(res);					
	});

	$scope.getCitiesForCountry = function(cntry) {		
		ctry = cntry.id + 236;
		//console.log("IN getCitiesForCountry. country="+ctry);
		$http.get(myLocalized.wpadmin_dir + 'admin-ajax.php?action=getcities&ctry='+ctry).success(function(res){		
			//console.log(res);
			$scope.cities = [];
			$scope.cities = eval(res);					
		});
	}
	$scope.getTimeZones = function(cntry) {				
		console.log("IN getTimeZones");
		$http.get(myLocalized.wpadmin_dir + 'admin-ajax.php?action=gettimez').success(function(res){		
			//console.log(res);									
			$scope.timezones = eval(res);	

			var tz = jstz.determine(); // Determines the time zone of the browser client
			console.log(tz.name());			
			var sLocalTZ = tz.name();
			if (sLocalTZ = 'Asia/Beirut') sLocalTZ = 'Asia/Jerusalem';//fix Israel TZ
			$scope.user.chosenTtimeZ = {id:sLocalTZ,value:''};    		
		});		
	}
	$scope.getTimeZones();	

	
	$scope.checkError = function()  {
		console.log("IN checkError");		
		/*if ($scope.user.password.length && $scope.user.password2.length) {
			if ($scope.user.password != $scope.user.password2) {				
				$scope.PSWRD_MATCH_ERROR = true;				
				return true;
			}
		}*/
		return false;
	};

	/*$scope.isActiveTab = function(tab){
    	return $scope.tabs[tab].active?'active':'';
  	};*/

	

	$scope.submitTheForm = function(item, event) {
		//console.log("pswrd="+$scope.user.password2);		
	   if ($scope.checkError()) return false;
	   var sPswrd = (typeof $scope.user.password === 'undefined')?'':$scope.user.password;
	   var sPswrd2 = (typeof $scope.user.password2 === 'undefined')?'':$scope.user.password2;
       console.log("--> Submitting form");
       var dataStr = 'action=setuser' + 
       					'&uid=2' + 
       					'&password=' + sPswrd +
       					'&password2=' + sPswrd2+
       					'&country=' + $scope.user.chosenCountry.name+
       					'&city=' + $scope.user.chosenCity.name+
       					'&timezone=' + $scope.user.chosenTtimeZ.id+
       					'&lang=' + $scope.user.lang;                    
       
        

       console.log("dataStr="+dataStr);
      
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

     $scope.submitTheForm2 = function(item, event) {
	    if ($scope.checkError()) return false;
       console.log("--> Submitting form");
       var dataStr = 'action=setuser2' + 
       					'&uid=2' + 
       					'&firstname=' + $scope.user.firstname +
       					'&lastname=' + $scope.user.lastname+
       					'&position=' + $scope.user.position+
       					'&about=' + $scope.user.about;                         

       console.log(dataStr);
      
	   $http({
            url: myLocalized.wpadmin_dir + 'admin-ajax.php?action=setuser2',
            method: "POST",
            data: dataStr,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}            
        }).success(function (data, status, headers, config) {
                console.log(data);
                if (data==1) {                	    				    					
					   	$scope.tabs[2].disabled = false;
					   	$scope.tabs[3].disabled = false;
					   	$scope.tabs[1].active = false;		
					   	$scope.tabs[2].active = true;							   						   	

                }
            }).error(function (data, status, headers, config) {
                console.log(data);
            });
     }

     /*$scope.submitTheForm3 = function(item, event) {
	    if ($scope.checkError()) return false;
       console.log("--> Submitting form");
       var dataStr = 'action=setuser3' + 
       					'&uid=2' + 
       					'&user_avatar=' + $scope.user.avatar;      					                        

       console.log(dataStr);
      
	   $http({
            url: myLocalized.wpadmin_dir + 'admin-ajax.php?action=setuser3',
            method: "POST",
            data: dataStr,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}            
        }).success(function (data, status, headers, config) {
                console.log(data);
                if (data==1) {                	    				    										   
					   	$scope.tabs[2].active = false;		
					   	$scope.tabs[3].active = true;							   						   	

                }
            }).error(function (data, status, headers, config) {
                console.log(data);
            });
     }*/     

     $scope.upload = function (files) {     	
        
        if (files && files.length) {       	        	
            for (var i = 0; i < files.length; i++) {
                var file = files[i];             

                $upload.upload({
                    url: myLocalized.wpadmin_dir + 'admin-ajax.php?action=setuser3&uid=2',                                        
                    headers: {'Content-Type': file.type},
                    method: "POST",
                    file: file,                    
            		data: file,            		         		
                }).progress(function (evt) {
                    var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
                    console.log('progress: ' + progressPercentage + '% ' +
                                evt.config.file.name);
                }).success(function (data, status, headers, config) {
                    console.log('file ' + config.file.name + ' uploaded. Response: ' +
                                JSON.stringify(data));
                });

            }
        }
    }
	
}]);

