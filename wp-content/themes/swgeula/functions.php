<?php

function my_scripts() {	

	wp_enqueue_style( 'swgeula_style', get_template_directory_uri() . '/style.css');

	
	wp_enqueue_script(
		'angularjs',
		get_stylesheet_directory_uri() . '/angular/angular.min.js'
	);

	wp_enqueue_script(
		'angularjs-route',
		get_stylesheet_directory_uri() . '/angular/angular-route.min.js',
		array( 'angularjs')
	);
	wp_enqueue_script(
		'ui-bootstrap',
		get_stylesheet_directory_uri() . '/angular/ui-bootstrap-tpls-0.12.1.min.js',
		array( 'angularjs')
	);
	wp_enqueue_script(
		'angular-translate',
		get_stylesheet_directory_uri() . '/angular/angular-translate.min.js',
		array( 'angularjs')
	);
	wp_enqueue_script(
		'angular.country-select',
		get_stylesheet_directory_uri() . '/angular/angular.country-select.js	',
		array( 'angularjs')
	);
	wp_enqueue_script(
		'angular-timezones',
		get_stylesheet_directory_uri() . '/angular/angular-timezones.js	',
		array( 'angularjs')
	);		
	wp_enqueue_script(
		'angular-translate-loader-partial',
		get_stylesheet_directory_uri() . '/angular/angular-translate-loader-partial.min.js',
		array( 'angularjs')
	);
	wp_enqueue_script(
		'angular-file-upload',
		get_stylesheet_directory_uri() . '/angular/angular-file-upload.min.js	',
		array( 'angularjs')
	);
	wp_enqueue_script(
		'angular-file-upload-shim',
		get_stylesheet_directory_uri() . '/angular/angular-file-upload-shim.min.js	',
		array( 'angularjs')
	);	
	wp_enqueue_script(
		'detect-zone',
		get_stylesheet_directory_uri() . '/js/jstz-1.0.4.min.js	'			
	);			
	wp_enqueue_script(
		'my-scripts',
		get_stylesheet_directory_uri() . '/js/angular_main.js',
		array( 'angularjs', 'angularjs-route' )
	);		

	wp_localize_script(
		'my-scripts',
		'myLocalized',
		array(
			'theme_dir' => trailingslashit( get_template_directory_uri() ), 
			'wpadmin_dir' => trailingslashit( admin_url() )
			)
	);

}

add_action( 'wp_enqueue_scripts', 'my_scripts' );

/***************************LANGUAGE SETTINGS********************************************/
function lang_setup(){
    load_theme_textdomain('swgeulatr', get_template_directory() . '/languages');    
}
add_action('after_setup_theme', 'lang_setup');
/***************************END LANGUAGE SETTINGS********************************************/


/************************** user registration stuff: ************************************/
function swgeula_registration_errors( $errors, $sanitized_user_login, $user_email ) {
        
        if ( empty( $_POST['first_name'] ) || ! empty( $_POST['first_name'] ) && trim( $_POST['first_name'] ) == '' ) {
            $errors->add( 'first_name_error', __( '<strong>ERROR</strong>: Please type your first name.', 'mydomain' ) );
        }
         if ( empty( $_POST['last_name'] ) || ! empty( $_POST['last_name'] ) && trim( $_POST['last_name'] ) == '' ) {
            $errors->add( 'last_name_error', __( '<strong>ERROR</strong>: Please type your last name.', 'mydomain' ) );
        }

        return $errors;
}
add_filter( 'registration_errors', 'swgeula_registration_errors', 10, 3 );

function my_front_end_login_fail( $username ) {	
   $referrer = $_SERVER['HTTP_REFERER'];  // where did the post submission come from?
   // if there's a valid referrer, and it's not the default log-in screen
   if ( !empty($referrer) && !strstr($referrer,'wp-login') && !strstr($referrer,'wp-admin') ) {
      wp_redirect( add_query_arg( 'login', 'failed',$referrer ) );  // let's append some information (login=failed) to the URL for the theme to use
      exit;
   }
}
add_action( 'wp_login_failed', 'my_front_end_login_fail' );  // hook failed login

function verify_username_password( $user, $username, $password ) {  
    $referrer = $_SERVER['HTTP_REFERER'];  // where did the post submission come from?
    if( empty($username) || empty($password) ) {  
    	if ( !empty($referrer) && !strstr($referrer,'wp-login') && !strstr($referrer,'wp-admin') ) {
        	wp_redirect( add_query_arg( 'login', 'empty',$referrer ) );  
        	exit;  
        }
    }  
}  
add_filter( 'authenticate', 'verify_username_password', 1, 3);  

/************************** end user registration stuff: ************************************/

add_theme_support ('menus');

function register_theme_menus() {

	register_nav_menus(
		array(
			'header-menu'	=> _('Header Menu'),
			'right-menu' => _( 'Right Menu' ),
			

      
			)
		);

		


}
add_action( 'init', 'register_theme_menus');



// Function for creating Widegets
function create_widget($name, $id, $description) {

	register_sidebar(array(
		'name' => __( $name ),	 
		'id' => $id, 
		'description' => __( $description ),
		'before_widget' => '<div class="widget">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>'
	));

}

// Create widgets in the footer
create_widget("Page Sidebar", "page", "Displays in the side navigation of pages");
create_widget("Blog Sidebar", "blog", "Displays in the side navigation of blog posts and main blog page");

create_widget("Footer Area", "footer", "Displays in bottom footer");

create_widget("Front Page Left", "front-left", "Displays on the left hand side of the homepage");
create_widget("Front Page Center", "front-center", "Displays in the center of the homepage");
create_widget("Front Page Right", "front-right", "Displays on the right hand side of the homepage");

 add_theme_support( 'post-formats', array('aside', 'gallery', 'link', 'image', 'quote', 'status', 'audio', 'chat', 'video')); // Add 3.1 post format theme support.
	
	add_theme_support( 'post-thumbnails' );
	add_image_size('category_image', 0, 290);


// Filter function
function add_contact_fields($profile_fields) {
	// Adding fields
	$profile_fields['subject'] = 'Subject';
	

	return $profile_fields;
}
// Adding the filter
add_filter('user_contactmethods', 'add_contact_fields');
/*****************************AJAX/ANGUALR FUNCTIONS******************/
function get_user_profile() {   

	if( $_GET['action'] == 'getuser' ) {

	    if (is_user_logged_in()) {

	    	 $uid = $_GET['uid'];

		    global $current_user;
		    get_currentuserinfo(); 



		    $avtr = get_user_meta( $uid, 'custom_avatar', true );
		    
		    $response = '{"firstName":"'.$current_user->user_firstname.'", "lastName":"'.$current_user->user_lastname.'", "email":"'.$current_user->user_email.'","avatar":"'.$avtr.'"}'; 
		    
		    header( "Content-Type: application/json" );    
		    echo $response; 
		}
		else {
			$error .= 'No Logged IN';
			echo $error;
		}   	    
	}
	exit;    
}
add_action( 'wp_ajax_nopriv_getuser', 'get_user_profile' );
add_action( 'wp_ajax_getuser', 'get_user_profile' );

function set_user_profile1(){
 
	if( $_POST['action'] == 'setuser' ) {
	 	
		$error = '';
		 
		 $uid = $_POST['uid'];
		 $pswrd = trim( $_POST['password'] );
		 $pswrd2 = trim( $_POST['password2'] );
		 $country = trim($_POST['country']);
		 $city = trim($_POST['city']);
		 $timezone = trim($_POST['timezone']);
		 $lang = trim( $_POST['lang'] );
		 
		if( empty( $_POST['uid'] ) )
		 $error .= 'Enter UserID';
		
		// if( empty( $_POST['mail_id'] ) )	
		 //$error .= '<p class="error">Enter Email Id</p>';
		 //elseif( !filter_var($email, FILTER_VALIDATE_EMAIL) )
		 //$error .= '<p class="error">Enter Valid Email</p>';

		if ( !empty($pswrd) && !empty($pswrd2) ) :
		 
			if( empty($pswrd) || empty($pswrd2) )
			 $error .= 'Password should not be blank';

			else {
				 global $current_user;
		    	get_currentuserinfo(); 
				if (!wp_check_password($pswrd, $current_user->user_pass))
					$error .= 'Your current password is incorrect';				
			}

		endif;	
		
		
		 
		if( empty($error) ) {
			if ( !empty($pswrd) && !empty($pswrd2)  ) {
				$userdata = array( 'ID' => $uid, 'user_pass' => $pswrd2 );		 
				$status = wp_update_user( $userdata );			 
				if( is_wp_error($status) ){				 
					$msg = '';				 
					 foreach( $status->errors as $key=>$val ){				 
					 	foreach( $val as $k=>$v ){				 
							 $msg = $v;
				 		}
			 		}		 
					echo $msg;
					exit;
			 
			 	}
			 }
			//now update meta data:
	 		if (!empty($lang)) update_user_meta( $uid, 'user_lang', $lang );
	 		if (!empty($country)) update_user_meta( $uid, 'user_country', $country );
	 		if (!empty($city)) update_user_meta( $uid, 'user_city', $city );
	 		if (!empty($timezone)) update_user_meta( $uid, 'user_timezone', $timezone );

	 		if( is_wp_error($status) ){				 
						$msg = '';				 
						 foreach( $status->errors as $key=>$val ){				 
						 	foreach( $val as $k=>$v ){				 
								 $msg = $v;
					 		}
				 		}		 
						echo $msg;
						exit;
				 
			}
			else {	 
					$msg = '1';	 
			 		echo $msg;
			 		exit;
			}		 	
		 
		}
		else {
		 
			echo $error;
			exit;
		}
		exit;
	}
}
add_action( 'wp_ajax_nopriv_setuser', 'set_user_profile1' );
add_action( 'wp_ajax_setuser', 'set_user_profile1' );

function set_user_profile2(){
 
	if( $_POST['action'] == 'setuser2' ) {
	 	
		$error = '';
		 
		 $uid = $_POST['uid'];
		 $fname = trim($_POST['firstname']);
		 $lname = trim($_POST['lastname']);
		 $position = trim($_POST['position']);
		 $about = trim($_POST['about']);		 
		 
		if( empty( $_POST['uid'] ) )
		 $error .= '<p class="error">Enter UserID</p>';						 
			
		 
		if( empty( $fname ) )
		 $error .= '<p class="error">Enter First Name</p>';	
		 
		if( empty( $lname ) )
		 $error .= '<p class="error">Enter Last Name</p>';		 
		 
		if( empty( $error ) ){

			$userdata = array( 'ID' => $uid, 'first_name' => $fname, 'last_name' => $lname );
		 
			$status = wp_update_user( $userdata );
			 
			if( is_wp_error($status) ){
				 
				$msg = '';
				 
				 foreach( $status->errors as $key=>$val ){
				 
				 	foreach( $val as $k=>$v ){
				 
						 $msg = '<p class="error">'.$v.'</p>';
			 		}
		 		}
		 
				echo $msg;
				exit;
		 
		 	}
		 	else {	 
				//now update meta data:
		 		update_user_meta( $uid, 'position', $position );
		 		if (!is_wp_error($status)) update_user_meta( $uid, 'about', $about );

		 		if( is_wp_error($status) ){				 
					$msg = '';				 
					 foreach( $status->errors as $key=>$val ){				 
					 	foreach( $val as $k=>$v ){				 
							 $msg = $v;
				 		}
			 		}		 
					echo $msg;
					exit;
			 
			 	}
			 	else {	 
					$msg = '1';	 
			 		echo $msg;
			 		exit;
			 	}
		 	}	 	


		 	//$user_id = 1;
			//$new_value = 'some new value';

			// will return false if the previous value is the same as $new_value
			//update_user_meta( $user_id, 'some_meta_key', $new_value );

			// so check and make sure the stored value matches $new_value
			//if ( get_user_meta($user_id,  'some_meta_key', true ) != $new_value )
				//wp_die('An error occurred');
		 
		}
		else {
		 
			echo $error;
			exit;
		}
		exit;
	}
}
add_action( 'wp_ajax_nopriv_setuser2', 'set_user_profile2' );
add_action( 'wp_ajax_setuser2', 'set_user_profile2' );


function set_user_profile3(){ 
	if( $_GET['action'] == 'setuser3' ) {
		$error = '';
		 
		 $uid = $_GET['uid'];		 

		 if( empty( $uid ) )
		 	$error .= '<p class="error">Enter UserID</p>';		

		 if( empty( $error ) ) {
		 	

		 	$filename = $_FILES['file']['name'];
		 			 	

		 	if(count($_FILES)>0 && isset($_FILES["file"])){
		
			  // we need this for the wp_handle_upload function
			  require_once ABSPATH.'wp-admin/includes/file.php';	
			
			  // just be aware that GIFs are annoying as fuck
			  $allowed_image_types = array(
				'jpg|jpeg|jpe' => 'image/jpeg',
				'png'          => 'image/png',
				'gif'          => 'image/gif',
			  );	
			  $status = wp_handle_upload($_FILES['file'], array('mimes' => $allowed_image_types, 'test_form' => FALSE));	    	  
			  
			  if(empty($status['error'])){	
				//resize
				$resized = image_resize($status['file'], 96, 96, $crop = true);	 
			
				if(!is_wp_error($resized)) { //resize successful		
					$uploads = wp_upload_dir();		
					$_POST['resized_url'] = $uploads['url'].'/'.basename($resized); 					
				}
			  }
			  else {
			  	echo( $status['error'] );
			  	exit;
			  }	 
			}
			elseif ($_POST) $_POST['resized_url']='';


		 	$userdata['resized_url'] = $_POST['resized_url'];		
			
			if (!empty($userdata['resized_url'])) update_usermeta($uid, 'custom_avatar', $userdata['resized_url']);
			else $error .= '<p class="error">File not found</p>';	

			if( !empty( $error ) ) {			 
						 
				echo $error;			
				exit;
		 
		 	}
		 	else {	 
					$msg = '1';	 
			 		echo $msg;
			 		exit;
			 }

		}
		else {
		 
			echo $error;
			exit;
		}
		exit;
	}
}
add_action( 'wp_ajax_nopriv_setuser3', 'set_user_profile3' );
add_action( 'wp_ajax_setuser3', 'set_user_profile3' );

function get_country_select() {
	global $wpdb;
	$retVal = "[";

	$result = $wpdb->get_results( 'SELECT id,country FROM wp_countries ORDER BY country ASC;', OBJECT );

	$bFirst = true;
	foreach($result as $row) {
		//$retVal  .= '{name: "'.$row->country.'", code=""}'.',';
		if (!$bFirst) $retVal .= ",";
		$retVal  .= "{id: ".$row->id.", name: '".$row->country."'}";		
		$bFirst=false;
	}

	$retVal .= "];";

	echo $retVal;
	exit;
}
add_action( 'wp_ajax_nopriv_getctrselect', 'get_country_select' );
add_action( 'wp_ajax_getctrselect', 'get_country_select' );

function get_cities() {
	$ctry = (int) trim($_GET['ctry']);

	if (!empty($ctry) && is_numeric($ctry)) { 
		global $wpdb;
		$retVal = "[";

		$result = $wpdb->get_results( "SELECT id,city FROM wp_cities WHERE country=$ctry ORDER BY city ASC;", OBJECT );

		$bFirst = true;
		foreach($result as $row) {
			//$retVal  .= '{name: "'.$row->country.'", code=""}'.',';
			if (!$bFirst) $retVal .= ",";
			$retVal  .= "{id: ".$row->id.", name: '".$row->city."'}";		
			$bFirst=false;
		}

		$retVal .= "];";

		echo $retVal;
		exit;
	}
	else echo "error - no country provided";
	exit;
}
add_action( 'wp_ajax_nopriv_getcities', 'get_cities' );
add_action( 'wp_ajax_getcities', 'get_cities' );

/*
function getTimeZones() {	

		$zones = timezone_identifiers_list();
		$locations = array();

		foreach ($zones as $zone) {
		    $zone = explode('/', $zone); // 0 => Continent, 1 => City		    
		    
		    if ($zone[0] == 'Africa' || $zone[0] == 'America' || $zone[0] == 'Antarctica' || $zone[0] == 'Arctic' || $zone[0] == 'Asia' || $zone[0] == 'Atlantic' || $zone[0] == 'Australia' || $zone[0] == 'Europe' || $zone[0] == 'Indian' || $zone[0] == 'Pacific')
		    //if ($zone[0] == $continent) 
		    {        
		        if (isset($zone[1]) != '')
		        {
		        	if (!is_array($locations[$zone[0]]))	$locations[$zone[0]] = array();
		            array_push($locations[$zone[0]], array('name' => str_replace('_', ' ', $zone[1]).'/'.$zone[0], 'id' => str_replace('_', ' ', $zone[1]), 'zonegroup' => $zone[0] ) ); 
		        } 
		    }
		}
		//echo($locations['Africa'][0]);
		echo json_encode($locations);
		exit;	
}
*/
function getTimeZones() {	
	$arrTimez = array (
	    array('name' => 'Midway Island (UTC-11:00)', 'id' => 'Pacific/Midway'),
	    array('name' => 'Samoa (UTC-11:00)', 'id' => 'Pacific/Samoa'),
	    array('name' => 'Hawaii (UTC-10:00)', 'id' => 'Pacific/Honolulu'),
	    array('name' => 'Alaska (UTC-09:00)', 'id' => 'US/Alaska'),
	    array('name' => 'Pacific Time (US & Canada) (UTC-08:00)', 'id' => 'America/Los_Angeles'),
	    array('name' => 'Tijuana (UTC-08:00)', 'id' => 'America/Tijuana'),
	    array('name' => 'Arizona (UTC-07:00)', 'id' => 'US/Arizona'),
	    array('name' => 'Chihuahua (UTC-07:00)', 'id' => 'America/Chihuahua'),
	    array('name' => 'La Paz (UTC-07:00)', 'id' => 'America/Chihuahua'),
	    array('name' => 'Mazatlan (UTC-07:00)', 'id' => 'America/Mazatlan'),
	    array('name' => 'Mountain Time (US & Canada) (UTC-07:00)', 'id' => 'US/Mountain'),
	    array('name' => 'Central America (UTC-06:00)', 'id' => 'America/Managua'),
	    array('name' => 'Central Time (US & Canada) (UTC-06:00)', 'id' => 'US/Central'),
	    array('name' => 'Guadalajara (UTC-06:00)', 'id' => 'America/Mexico_City'),
	    array('name' => 'Mexico City (UTC-06:00)', 'id' => 'America/Mexico_City'),
	    array('name' => 'Monterrey (UTC-06:00)', 'id' => 'America/Monterrey'),
	    array('name' => 'Saskatchewan (UTC-06:00)', 'id' => 'Canada/Saskatchewan'),
	    array('name' => 'Bogota (UTC-05:00)', 'id' => 'America/Bogota'),
	    array('name' => 'Eastern Time (US & Canada) (UTC-05:00)', 'id' => 'US/Eastern'),
	    array('name' => 'Indiana (East) (UTC-05:00)', 'id' => 'US/East-Indiana'),
	    array('name' => 'Lima (UTC-05:00)', 'id' => 'America/Lima'),
	    array('name' => 'Quito (UTC-05:00)', 'id' => 'America/Bogota'),
	    array('name' => 'Atlantic Time (Canada) (UTC-04:00)','id' => 'Canada/Atlantic'),
	    array('name' => 'Caracas (UTC-04:30)', 'id' => 'America/Caracas'),
	    array('name' => 'La Paz (UTC-04:00)', 'id' => 'America/La_Paz'),
	    array('name' => 'Santiago (UTC-04:00)', 'id' => 'America/Santiago'),
	    array('name' => 'Newfoundland (UTC-03:30)', 'id' => 'Canada/Newfoundland'),
	    array('name' => 'Brasilia (UTC-03:00)', 'id' => 'America/Sao_Paulo'),
	    array('name' => 'Buenos Aires (UTC-03:00)', 'id' => 'America/Argentina/Buenos_Aires'),
	    array('name' => 'Georgetown (UTC-03:00)', 'id' => 'America/Argentina/Buenos_Aires'),
	    array('name' => 'Greenland (UTC-03:00)', 'id' => 'America/Godthab'),
	    array('name' => 'Mid-Atlantic (UTC-02:00)', 'id' => 'America/Noronha'),
	    array('name' => 'Azores (UTC-01:00)', 'id' => 'Atlantic/Azores'),
	    array('name' => 'Cape Verde Is.(UTC-01:00)', 'id' => 'Atlantic/Cape_Verde'),
	    array('name' => 'Casablanca (UTC+00:00)', 'id' => 'Africa/Casablanca'),
	    array('name' => 'Edinburgh (UTC+00:00)', 'id' => 'Europe/London'),
	    array('name' => 'Greenwich Mean Time : Dublin (UTC+00:00)', 'id' => 'Etc/Greenwich'),
	    array('name' => 'Lisbon (UTC+00:00)', 'id' => 'Europe/Lisbon'),
	    array('name' => 'London (UTC+00:00)', 'id' => 'Europe/London'),
	    array('name' => 'Monrovia (UTC+00:00)', 'id' => 'Africa/Monrovia'),
	    array('name' => 'UTC (UTC+00:00)', 'id' => 'UTC'),
	    array('name' => 'Amsterdam (UTC+01:00)', 'id' => 'Europe/Amsterdam'),
	    array('name' => 'Belgrade (UTC+01:00)', 'id' => 'Europe/Belgrade'),
	    array('name' => 'Berlin (UTC+01:00)', 'id' => 'Europe/Berlin'),
	    array('name' => 'Bern (UTC+01:00)', 'id' => 'Europe/Berlin'),
	    array('name' => 'Bratislava (UTC+01:00)', 'id' => 'Europe/Bratislava'),
	    array('name' => 'Brussels (UTC+01:00)', 'id' => 'Europe/Brussels'),
	    array('name' => 'Budapest (UTC+01:00)', 'id' => 'Europe/Budapest'),
	    array('name' => 'Copenhagen (UTC+01:00)', 'id' => 'Europe/Copenhagen'),
	    array('name' => 'Ljubljana (UTC+01:00)', 'id' => 'Europe/Ljubljana'),
	    array('name' => 'Madrid (UTC+01:00)', 'id' => 'Europe/Madrid'),
	    array('name' => 'Paris (UTC+01:00)', 'id' => 'Europe/Paris'),
	    array('name' => 'Prague (UTC+01:00)', 'id' => 'Europe/Prague'),
	    array('name' => 'Rome (UTC+01:00)', 'id' => 'Europe/Rome'),
	    array('name' => 'Sarajevo (UTC+01:00)', 'id' => 'Europe/Sarajevo'),
	    array('name' => 'Skopje (UTC+01:00)', 'id' => 'Europe/Skopje'),
	    array('name' => 'Stockholm (UTC+01:00)', 'id' => 'Europe/Stockholm'),
	    array('name' => 'Vienna (UTC+01:00)', 'id' => 'Europe/Vienna'),
	    array('name' => 'Warsaw (UTC+01:00)', 'id' => 'Europe/Warsaw'),
	    array('name' => 'West Central Africa (UTC+01:00)', 'id' => 'Africa/Lagos'),
	    array('name' => 'Zagreb (UTC+01:00)', 'id' => 'Europe/Zagreb'),
	    array('name' => 'Athens (UTC+02:00)', 'id' => 'Europe/Athens'),
	    array('name' => 'Bucharest (UTC+02:00)', 'id' => 'Europe/Bucharest'),
	    array('name' => 'Cairo (UTC+02:00)', 'id' => 'Africa/Cairo'),
	    array('name' => 'Harare (UTC+02:00)', 'id' => 'Africa/Harare'),
	    array('name' => 'Helsinki (UTC+02:00)', 'id' => 'Europe/Helsinki'),
	    array('name' => 'Istanbul (UTC+02:00)', 'id' => 'Europe/Istanbul'),
	    array('name' => 'Jerusalem (UTC+02:00)', 'id' => 'Asia/Jerusalem'),
	    array('name' => 'Kyiv (UTC+02:00)', 'id' => 'Europe/Helsinki'),
	    array('name' => 'Pretoria (UTC+02:00)', 'id' => 'Africa/Johannesburg'),
	    array('name' => 'Riga (UTC+02:00)', 'id' => 'Europe/Riga'),
	    array('name' => 'Sofia (UTC+02:00)', 'id' => 'Europe/Sofia'),
	    array('name' => 'Tallinn (UTC+02:00)', 'id' => 'Europe/Tallinn'),
	    array('name' => 'Vilnius (UTC+02:00)', 'id' => 'Europe/Vilnius'),
	    array('name' => 'Baghdad (UTC+03:00)', 'id' => 'Asia/Baghdad'),
	    array('name' => 'Kuwait (UTC+03:00)', 'id' => 'Asia/Kuwait'),
	    array('name' => 'Minsk (UTC+03:00)', 'id' => 'Europe/Minsk'),
	    array('name' => 'Nairobi (UTC+03:00)', 'id' => 'Africa/Nairobi'),
	    array('name' => 'Riyadh (UTC+03:00)', 'id' => 'Asia/Riyadh'),
	    array('name' => 'Volgograd (UTC+03:00)', 'id' => 'Europe/Volgograd'),
	    array('name' => 'Tehran (UTC+03:30)', 'id' => 'Asia/Tehran'),
	    array('name' => 'Abu Dhabi (UTC+04:00)', 'id' => 'Asia/Muscat'),
	    array('name' => 'Baku (UTC+04:00)', 'id' => 'Asia/Baku'),
	    array('name' => 'Moscow (UTC+04:00)', 'id' => 'Europe/Moscow'),
	    array('name' => 'Muscat (UTC+04:00)', 'id' => 'Asia/Muscat'),
	    array('name' => 'St. Petersburg (UTC+04:00)', 'id' => 'Europe/Moscow'),
	    array('name' => 'Tbilisi (UTC+04:00)', 'id' => 'Asia/Tbilisi'),
	    array('name' => 'Yerevan (UTC+04:00)', 'id' => 'Asia/Yerevan'),
	    array('name' => 'Kabul (UTC+04:30)', 'id' => 'Asia/Kabul'),
	    array('name' => 'Islamabad (UTC+05:00)', 'id' => 'Asia/Karachi'),
	    array('name' => 'Karachi (UTC+05:00)', 'id' => 'Asia/Karachi'),
	    array('name' => 'Tashkent (UTC+05:00)', 'id' => 'Asia/Tashkent'),
	    array('name' => 'Chennai (UTC+05:30)', 'id' => 'Asia/Calcutta'),
	    array('name' => 'Kolkata (UTC+05:30)', 'id' => 'Asia/Kolkata'),
	    array('name' => 'Mumbai (UTC+05:30)', 'id' => 'Asia/Calcutta'),
	    array('name' => 'New Delhi (UTC+05:30)', 'id' => 'Asia/Calcutta'),
	    array('name' => 'Sri Jayawardenepura (UTC+05:30)', 'id' => 'Asia/Calcutta'),
	    array('name' => 'Kathmandu (UTC+05:45)', 'id' => 'Asia/Katmandu'),
	    array('name' => 'Almaty (UTC+06:00)', 'id' => 'Asia/Almaty'),
	    array('name' => 'Astana (UTC+06:00)', 'id' => 'Asia/Dhaka'),
	    array('name' => 'Dhaka (UTC+06:00)', 'id' => 'Asia/Dhaka'),
	    array('name' => 'Ekaterinburg (UTC+06:00)', 'id' => 'Asia/Yekaterinburg'),
	    array('name' => 'Rangoon (UTC+06:30)', 'id' => 'Asia/Rangoon'),
	    array('name' => 'Bangkok (UTC+07:00)', 'id' => 'Asia/Bangkok'),
	    array('name' => 'Hanoi (UTC+07:00)', 'id' => 'Asia/Bangkok'),
	    array('name' => 'Jakarta (UTC+07:00)', 'id' => 'Asia/Jakarta'),
	    array('name' => 'Novosibirsk (UTC+07:00)', 'id' => 'Asia/Novosibirsk'),
	    array('name' => 'Beijing (UTC+08:00)', 'id' => 'Asia/Hong_Kong'),
	    array('name' => 'Chongqing (UTC+08:00)', 'id' => 'Asia/Chongqing'),
	    array('name' => 'Hong Kong (UTC+08:00)', 'id' => 'Asia/Hong_Kong'),
	    array('name' => 'Krasnoyarsk (UTC+08:00)', 'id' => 'Asia/Krasnoyarsk'),
	    array('name' => 'Kuala Lumpur (UTC+08:00)', 'id' => 'Asia/Kuala_Lumpur'),
	    array('name' => 'Perth (UTC+08:00)', 'id' => 'Australia/Perth'),
	    array('name' => 'Singapore (UTC+08:00)', 'id' => 'Asia/Singapore'),
	    array('name' => 'Taipei (UTC+08:00)', 'id' => 'Asia/Taipei'),
	    array('name' => 'Ulaan Bataar (UTC+08:00)', 'id' => 'Asia/Ulan_Bator'),
	    array('name' => 'Urumqi (UTC+08:00)', 'id' => 'Asia/Urumqi'),
	    array('name' => 'Irkutsk (UTC+09:00)', 'id' => 'Asia/Irkutsk'),
	    array('name' => 'Osaka (UTC+09:00)', 'id' => 'Asia/Tokyo'),
	    array('name' => 'Sapporo (UTC+09:00)', 'id' => 'Asia/Tokyo'),
	    array('name' => 'Seoul (UTC+09:00)', 'id' => 'Asia/Seoul'),
	    array('name' => 'Tokyo (UTC+09:00)', 'id'=> 'Asia/Tokyo'),
	    array('name' => 'Adelaide (UTC+09:30)', 'id' => 'Australia/Adelaide'),
	    array('name' => 'Darwin (UTC+09:30)', 'id' => 'Australia/Darwin'),
	    array('name' => 'Brisbane (UTC+10:00)', 'id' => 'Australia/Brisbane'),
	    array('name' => 'Canberra (UTC+10:00)', 'id' => 'Australia/Canberra'),
	    array('name' => 'Guam (UTC+10:00)', 'id' => 'Pacific/Guam'),
	    array('name' => 'Hobart (UTC+10:00)', 'id' => 'Australia/Hobart'),
	    array('name' => 'Melbourne (UTC+10:00)', 'id' => 'Australia/Melbourne'),
	    array('name' => 'Port Moresby (UTC+10:00)', 'id' => 'Pacific/Port_Moresby'),
	    array('name' => 'Sydney (UTC+10:00)', 'id' => 'Australia/Sydney'),
	    array('name' => 'Yakutsk (UTC+10:00)', 'id' => 'Asia/Yakutsk'),
	    array('name' => 'Vladivostok (UTC+11:00)', 'id' => 'Asia/Vladivostok'),
	    array('name' => 'Auckland (UTC+12:00)', 'id' => 'Pacific/Auckland'),
	    array('name' => 'Fiji (UTC+12:00)', 'id' => 'Pacific/Fiji'),
	    array('name' => 'International Date Line West (UTC+12:00)', 'id' => 'Pacific/Kwajalein'),
	    array('name' => 'Kamchatka (UTC+12:00)', 'id' => 'Asia/Kamchatka'),
	    array('name' => 'Magadan (UTC+12:00)', 'id' => 'Asia/Magadan'),
	    array('name' => 'Marshall Is. (UTC+12:00)', 'id' => 'Pacific/Fiji'),
	    array('name' => 'New Caledonia (UTC+12:00)', 'id' => 'Asia/Magadan'),
	    array('name' => 'Solomon Is. (UTC+12:00)', 'id' => 'Asia/Magadan'),
	    array('name' => 'Wellington (UTC+12:00)', 'id' => 'Pacific/Auckland'),
	    array('name' => 'Nuku\'alofa (UTC+13:00)', 'id' => 'Pacific/Tongatapu')
	);
	echo json_encode($arrTimez);
	exit;	
}
add_action( 'wp_ajax_nopriv_gettimez', 'getTimeZones' );
add_action( 'wp_ajax_gettimez', 'getTimeZones' );

/*****************************END AJAX/ANGUALR FUNCTIONS******************/
?>