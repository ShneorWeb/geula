var myApp = angular.module('appgeula', ['ngRoute','ui.bootstrap','pascalprecht.translate','countrySelect','angularFileUpload','ngPasswordStrength']).config(function($routeProvider, $locationProvider,$translateProvider) {		 
    
	$locationProvider.html5Mode(true);	

	$translateProvider.translations('en_US', {
	    Your_Account: 'Your Account',
	    Settings: 'Settings',	    
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
	    Select_Timezone : 'Select Timezone',
	    Data_Saved_Successfully : 'Data Saved Successfully!',
	    Forgot_Password : 'forgot password',
	    Strength : 'Strength',
	    Fill_Required_Fields : 'Please fill-in the required fields'
	  });
	  $translateProvider.translations('he_IL', {
	    Your_Account: 'החשבון שלך',
	    Settings: 'הגדרות',	    
	    Profile: 'פרופיל',	    
	    Picture: 'תמונה',	    
	    Alerts: 'התראות',	
	    Password: 'סיסמה',
	    Email: 'כתובת אימייל',	
	    Country: 'מדינה',	    
	    City: 'עיר',	    
	    Time_Zone: 'אזור זמן',	    
	    Language_UI: 'שפת ממשק',
	    Save_Details: 'שמירת שינויים',	     
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
		Select_Timezone : 'בחר אזור זמן',
		Data_Saved_Successfully : 'הנתונים נשמרו בהצלחה!',
		Forgot_Password : 'שכחתי את הסיסמה',
		Strength : 'חוזק',
        Your_Picture  : 'התמונה שלך',
        Photo_visible_to_everyone : 'התמונה גלויה לכולם',
        Select_an_image_to_upload : 'בחר תמונה להעלות',
        Back_to_Library : 'חזרה לספריה',
        Fill_Required_Fields : 'נא למלא את שדות החובה'
	  });
	$translateProvider.preferredLanguage(sCurLang);
 	
	$routeProvider				
	.when('/', {						
	});
	/*.when('/edit-profile', {		
		templateUrl: myLocalized.theme_dir + 'partials/profile.html',
		controller: 'Profile'
	})*/	
})

/*.controller('Content', function($scope, $http, $routeParams) {
	$http.get('wp-json/posts/').success(function(res){
		$scope.posts = res;
	});
})
.controller('Single', function($scope, $http, $routeParams) {
	$http.get('wp-json/posts/' + $routeParams.ID).success(function(res){
		$scope.post = res;
	});
})*/

.controller('Profile', ['$scope', '$http', '$routeParams','$translate','$upload','$location', function($scope, $http, $routeParams,$translate,$upload,$location) {	
	//console.log($location.url());	
	
	$scope.user = {};
	$scope.PSWRD_MATCH_ERROR = false;	
	$scope.user.password = '';
	$scope.user.password2 = '';
	$scope.countries = [];
	//$scope.cities = [];	
	$scope.User_Success=false;
	$scope.strength = 'fff';
	$scope.user.timezone = '';
	$scope.user.email_verified = false;
	$scope.lostPassURL = myLocalized.home_url + 'registration/?action=lostpassword';

	$scope.tabs = [
  		{active: true, disabled: false},
  		{active: false, disabled: false},
  		{active: false, disabled: false},
  		{active: false, disabled: false}
	];

		
	//console.log("lang="+$translate.preferredLanguage());		

	$scope.template = {name: "edit profile 1",url: myLocalized.theme_dir + 'partials/profile.html'};	
	

	function changeTabs(sLocHash) {		
		if (sLocHash.indexOf("profile-image")!=-1) {		
			$scope.tabs[2].active = true;				
		}
		else if (sLocHash.indexOf("profile")!=-1) {		
			$scope.tabs[1].active = true;				
		}		
		else if (sLocHash.indexOf("alerts")!=-1) {		
			$scope.tabs[3].active = true;				
		}
		else {
			$scope.tabs[0].active = true;	
		}
	}

	var sLocHash = $location.hash();
	changeTabs(sLocHash);		

	$scope.$on('$locationChangeSuccess', function(event) {
		var sLocHash = $location.hash();		
		changeTabs(sLocHash);
	});
	
		
	
	$scope.getTimeZones = function(cntry) {				
		//console.log("IN getTimeZones");
		$http.get(myLocalized.wpadmin_dir + 'admin-ajax.php?action=gettimez').success(function(res){		
			//console.log(res);									
			$scope.timezones = eval(res);	

			var tz = jstz.determine(); // Determines the time zone of the browser client
			//console.log(tz.name());			
			var sLocalTZ = tz.name();
			if (sLocalTZ == 'Asia/Beirut') sLocalTZ = 'Asia/Jerusalem';//fix Israel TZ
			if (sLocalTZ =="United Kingdom") sLocalTZ = 'Europe/London';//fix UK TZ

			if ($scope.user.timezone && $scope.user.timezone.length>0) $scope.user.chosenTtimeZ =  {id:$scope.user.timezone};    		 
			else $scope.user.chosenTtimeZ = {id:sLocalTZ};			
		});		
	}

	/*$scope.getCitiesForCountry = function(cntry) {		
		if (typeof cntry.name != 'undefined') {
			ctry = cntry.id + 236;				
			$http.get(myLocalized.wpadmin_dir + 'admin-ajax.php?action=getcities&ctry='+ctry).success(function(res){		
				//console.log("in get cities "+res);				
				$scope.cities = [];
				if ( angular.isArray( eval(res) ) ) {
					$scope.cities = eval(res);								
					$scope.user.chosenCity = {name:$scope.user.city}; 	
				}
			});
		}
	}*/		
	
	//get user data and init ui elemnts:
	$http.get(myLocalized.wpadmin_dir + 'admin-ajax.php?action=getuser').success(function(res){					
		console.log(res);	
		var objRes = res;				
		if (typeof objRes.firstname != 'undefined') objRes.firstname = objRes.firstname.toString().replace(/\\'/g,"'");				
		if (typeof objRes.lastname != 'undefined') objRes.lastname = objRes.lastname.toString().replace(/\\'/g,"'");				
		if (typeof objRes.about != 'undefined') objRes.about = objRes.about.toString().replace(/\\'/g,"'");				
		if (typeof objRes.position != 'undefined') objRes.position = objRes.position.toString().replace(/\\'/g,"'");						
		if ( (typeof objRes.lang != 'undefined') && (objRes.lang=="en_GB") )  objRes.lang = "en_US";						
		
		$scope.user = objRes;
		
		//get countries:
		$http.get(myLocalized.wpadmin_dir + 'admin-ajax.php?action=getctrselect').success(function(res){		
			//console.log(res);
		 	$scope.countries = eval(res);							 	
		});
		
		$scope.getTimeZones();		

		if ($scope.user.lang=="" || $scope.user.lang==null) $scope.user.lang = $translate.preferredLanguage();		


		$http.get(myLocalized.wpadmin_dir + 'admin-ajax.php?action=getctrbyid&cname='+$scope.user.country).success(function(res){					
				//console.log("cntry="+$scope.user.country);
			 	$scope.user.chosenCountry = {id:eval(res)}; 	
			 	//$scope.getCitiesForCountry({id:eval(res),name:$scope.user.country});			 				 	
		});		 	
		
	});			
	
	

	$scope.submitTheForm = function(item, event) {	
	   var sPswrd = (typeof $scope.user.password == 'undefined')?'':$scope.user.password;
	   var sPswrd2 = (typeof $scope.user.password2 == 'undefined')?'':$scope.user.password2;
	   var sCcountry = (typeof $scope.user.chosenCountry == 'undefined' || $scope.user.chosenCountry.name == 'undefined')?'':$scope.user.chosenCountry.name;
	   //var sCity = (typeof $scope.user.chosenCity == 'undefined' || typeof $scope.user.chosenCity.name == 'undefined')?'':$scope.user.chosenCity.name;
	   var sTimeZone = (typeof $scope.user.chosenTtimeZ == 'undefined')?'Asia/Jerusalem':$scope.user.chosenTtimeZ.id;
       //console.log("--> Submitting form");
       var dataStr = 'action=setuser' +        					
       					'&password=' + sPswrd +
       					'&password2=' + sPswrd2+
       					'&country=' + sCcountry+       					
       					'&timezone=' + sTimeZone+
       					'&lang=' + $scope.user.lang;                                 

       console.log("dataStr="+dataStr);
      
	   $http({
            url: myLocalized.wpadmin_dir + 'admin-ajax.php?action=setuser',
            method: "POST",
            data: dataStr,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}            
        }).success(function (data, status, headers, config) {
                //console.log(sCurLang);
                //console.log($scope.user.lang);
                if ($scope.user.lang != sCurLang) {
                	//window.location.href += gbLocal?("/geula/settings/?lang="+$scope.user.lang+"#profile"):("/settings/?lang="+$scope.user.lang+"#profile");
                	var sShortLang = $scope.user.lang.substr(0,$scope.user.lang.indexOf("_"));
                	$location.search('lang='+sShortLang);
                	$location.hash('profile');
                	$location.replace();
                	//window.location.href += "?lang="+$scope.user.lang+"#profile";                	
                	window.location.reload();
                }
                if (data==1) {                	    				    					
					   	$scope.tabs[1].disabled = false;
					   	$scope.tabs[0].active = false;		
					   	$scope.tabs[1].active = true;							   						   	
					   	$scope.User_Success=true;

                }
            }).error(function (data, status, headers, config) {
                //console.log(data);
            });
     }

     $scope.submitTheForm2 = function(item, event) {	    
      // console.log($scope.user.about);
       var dataStr = 'action=setuser2' +        					
       					'&firstname=' + $scope.user.firstname +
       					'&lastname=' + $scope.user.lastname+
       					'&position=' + $scope.user.position+
       					'&about=' + $scope.user.about;                         

       //console.log(dataStr);
      
	   $http({
            url: myLocalized.wpadmin_dir + 'admin-ajax.php?action=setuser2',
            method: "POST",
            data: dataStr,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}            
        }).success(function (data, status, headers, config) {
                console.log(data);
                if (data==1) {                	    				    					
                		document.getElementById('div-display-name').innerHTML = $scope.user.firstname + ' ' + $scope.user.lastname; //update menu on top
					   	$scope.tabs[2].disabled = false;
					   	$scope.tabs[3].disabled = false;
					   	$scope.tabs[1].active = false;		
					   	$scope.tabs[2].active = true;	
					   	$scope.User_Success=true;						   						   						   	

                }
            }).error(function (data, status, headers, config) {
                //console.log(data);
            });
     }
     

     $scope.upload = function (files) {     	
        
        if (files && files.length) {       	        	
            for (var i = 0; i < files.length; i++) {
                var file = files[i];             

                $upload.upload({
                    url: myLocalized.wpadmin_dir + 'admin-ajax.php?action=setuser3',                                        
                    headers: {'Content-Type': file.type},
                    method: "POST",
                    file: file,                    
            		data: file,            		         		
                }).progress(function (evt) {
                    var progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
                    //console.log('progress: ' + progressPercentage + '% ' +  evt.config.file.name);
                }).success(function (data, status, headers, config) {
                    //console.log('file ' + config.file.name + ' uploaded. Response: ' + JSON.stringify(data));
                    $scope.User_Success=true;
                    $scope.user.avatar_240 = data;
                });

            }
        }
    }
	
}]);
