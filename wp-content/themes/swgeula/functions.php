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
	    array('name' => '(UTC-03:00) Greenland', 'id' => 'America/Godthab'),
	    array('name' => '(UTC-02:00) Mid-Atlantic', 'id' => 'America/Noronha'),
	    array('name' => '(UTC-01:00) Azores', 'id' => 'Atlantic/Azores'),
	    array('name' => '(UTC-01:00) Cape Verde Is.', 'id' => 'Atlantic/Cape_Verde'),
	    array('name' => '(UTC+00:00) Casablanca', 'id' => 'Africa/Casablanca'),
	    array('name' => '(UTC+00:00) Edinburgh', 'id' => 'Europe/London'),
	    array('name' => '(UTC+00:00) Greenwich Mean Time : Dublin', 'id' => 'Etc/Greenwich'),
	    array('name' => '(UTC+00:00) Lisbon', 'id' => 'Europe/Lisbon'),
	    array('name' => '(UTC+00:00) London', 'id' => 'Europe/London'),
	    array('name' => '(UTC+00:00) Monrovia', 'id' => 'Africa/Monrovia'),
	    array('name' => '(UTC+00:00) UTC', 'id' => 'UTC'),
	    array('name' => '(UTC+01:00) Amsterdam', 'id' => 'Europe/Amsterdam'),
	    array('name' => '(UTC+01:00) Belgrade', 'id' => 'Europe/Belgrade'),
	    array('name' => '(UTC+01:00) Berlin', 'id' => 'Europe/Berlin'),
	    array('name' => '(UTC+01:00) Bern', 'id' => 'Europe/Berlin'),
	    array('name' => '(UTC+01:00) Bratislava', 'id' => 'Europe/Bratislava'),
	    array('name' => '(UTC+01:00) Brussels', 'id' => 'Europe/Brussels'),
	    array('name' => '(UTC+01:00) Budapest', 'id' => 'Europe/Budapest'),
	    array('name' => '(UTC+01:00) Copenhagen', 'id' => 'Europe/Copenhagen'),
	    array('name' => '(UTC+01:00) Ljubljana', 'id' => 'Europe/Ljubljana'),
	    array('name' => '(UTC+01:00) Madrid', 'id' => 'Europe/Madrid'),
	    array('name' => '(UTC+01:00) Paris', 'id' => 'Europe/Paris'),
	    array('name' => '(UTC+01:00) Prague', 'id' => 'Europe/Prague'),
	    array('name' => '(UTC+01:00) Rome', 'id' => 'Europe/Rome'),
	    array('name' => '(UTC+01:00) Sarajevo', 'id' => 'Europe/Sarajevo'),
	    array('name' => '(UTC+01:00) Skopje', 'id' => 'Europe/Skopje'),
	    array('name' => '(UTC+01:00) Stockholm', 'id' => 'Europe/Stockholm'),
	    array('name' => '(UTC+01:00) Vienna', 'id' => 'Europe/Vienna'),
	    array('name' => '(UTC+01:00) Warsaw', 'id' => 'Europe/Warsaw'),
	    array('name' => '(UTC+01:00) West Central Africa', 'id' => 'Africa/Lagos'),
	    array('name' => '(UTC+01:00) Zagreb', 'id' => 'Europe/Zagreb'),
	    array('name' => '(UTC+02:00) Athens', 'id' => 'Europe/Athens'),
	    array('name' => '(UTC+02:00) Bucharest', 'id' => 'Europe/Bucharest'),
	    array('name' => '(UTC+02:00) Cairo', 'id' => 'Africa/Cairo'),
	    array('name' => '(UTC+02:00) Harare', 'id' => 'Africa/Harare'),
	    array('name' => '(UTC+02:00) Helsinki', 'id' => 'Europe/Helsinki'),
	    array('name' => '(UTC+02:00) Istanbul', 'id' => 'Europe/Istanbul'),
	    array('name' => '(UTC+02:00) Jerusalem', 'id' => 'Asia/Jerusalem'),
	    array('name' => '(UTC+02:00) Kyiv', 'id' => 'Europe/Helsinki'),
	    array('name' => '(UTC+02:00) Pretoria', 'id' => 'Africa/Johannesburg'),
	    array('name' => '(UTC+02:00) Riga', 'id' => 'Europe/Riga'),
	    array('name' => '(UTC+02:00) Sofia', 'id' => 'Europe/Sofia'),
	    array('name' => '(UTC+02:00) Tallinn', 'id' => 'Europe/Tallinn'),
	    array('name' => '(UTC+02:00) Vilnius', 'id' => 'Europe/Vilnius'),
	    array('name' => '(UTC+03:00) Baghdad', 'id' => 'Asia/Baghdad'),
	    array('name' => '(UTC+03:00) Kuwait', 'id' => 'Asia/Kuwait'),
	    array('name' => '(UTC+03:00) Minsk', 'id' => 'Europe/Minsk'),
	    array('name' => '(UTC+03:00) Nairobi', 'id' => 'Africa/Nairobi'),
	    array('name' => '(UTC+03:00) Riyadh', 'id' => 'Asia/Riyadh'),
	    array('name' => '(UTC+03:00) Volgograd', 'id' => 'Europe/Volgograd'),
	    array('name' => '(UTC+03:30) Tehran', 'id' => 'Asia/Tehran'),
	    array('name' => '(UTC+04:00) Abu Dhabi', 'id' => 'Asia/Muscat'),
	    array('name' => '(UTC+04:00) Baku', 'id' => 'Asia/Baku'),
	    array('name' => '(UTC+04:00) Moscow', 'id' => 'Europe/Moscow'),
	    array('name' => '(UTC+04:00) Muscat', 'id' => 'Asia/Muscat'),
	    array('name' => '(UTC+04:00) St. Petersburg', 'id' => 'Europe/Moscow'),
	    array('name' => '(UTC+04:00) Tbilisi', 'id' => 'Asia/Tbilisi'),
	    array('name' => '(UTC+04:00) Yerevan', 'id' => 'Asia/Yerevan'),
	    array('name' => '(UTC+04:30) Kabul', 'id' => 'Asia/Kabul'),
	    array('name' => '(UTC+05:00) Islamabad', 'id' => 'Asia/Karachi'),
	    array('name' => '(UTC+05:00) Karachi', 'id' => 'Asia/Karachi'),
	    array('name' => '(UTC+05:00) Tashkent', 'id' => 'Asia/Tashkent'),
	    array('name' => '(UTC+05:30) Chennai', 'id' => 'Asia/Calcutta'),
	    array('name' => '(UTC+05:30) Kolkata', 'id' => 'Asia/Kolkata'),
	    array('name' => '(UTC+05:30) Mumbai', 'id' => 'Asia/Calcutta'),
	    array('name' => '(UTC+05:30) New Delhi', 'id' => 'Asia/Calcutta'),
	    array('name' => '(UTC+05:30) Sri Jayawardenepura', 'id' => 'Asia/Calcutta'),
	    array('name' => '(UTC+05:45) Kathmandu', 'id' => 'Asia/Katmandu'),
	    array('name' => '(UTC+06:00) Almaty', 'id' => 'Asia/Almaty'),
	    array('name' => '(UTC+06:00) Astana', 'id' => 'Asia/Dhaka'),
	    array('name' => '(UTC+06:00) Dhaka', 'id' => 'Asia/Dhaka'),
	    array('name' => '(UTC+06:00) Ekaterinburg', 'id' => 'Asia/Yekaterinburg'),
	    array('name' => '(UTC+06:30) Rangoon', 'id' => 'Asia/Rangoon'),
	    array('name' => '(UTC+07:00) Bangkok', 'id' => 'Asia/Bangkok'),
	    array('name' => '(UTC+07:00) Hanoi', 'id' => 'Asia/Bangkok'),
	    array('name' => '(UTC+07:00) Jakarta', 'id' => 'Asia/Jakarta'),
	    array('name' => '(UTC+07:00) Novosibirsk', 'id' => 'Asia/Novosibirsk'),
	    array('name' => '(UTC+08:00) Beijing', 'id' => 'Asia/Hong_Kong'),
	    array('name' => '(UTC+08:00) Chongqing', 'id' => 'Asia/Chongqing'),
	    array('name' => '(UTC+08:00) Hong Kong', 'id' => 'Asia/Hong_Kong'),
	    array('name' => '(UTC+08:00) Krasnoyarsk', 'id' => 'Asia/Krasnoyarsk'),
	    array('name' => '(UTC+08:00) Kuala Lumpur', 'id' => 'Asia/Kuala_Lumpur'),
	    array('name' => '(UTC+08:00) Perth', 'id' => 'Australia/Perth'),
	    array('name' => '(UTC+08:00) Singapore', 'id' => 'Asia/Singapore'),
	    array('name' => '(UTC+08:00) Taipei', 'id' => 'Asia/Taipei'),
	    array('name' => '(UTC+08:00) Ulaan Bataar', 'id' => 'Asia/Ulan_Bator'),
	    array('name' => '(UTC+08:00) Urumqi', 'id' => 'Asia/Urumqi'),
	    array('name' => '(UTC+09:00) Irkutsk', 'id' => 'Asia/Irkutsk'),
	    array('name' => '(UTC+09:00) Osaka', 'id' => 'Asia/Tokyo'),
	    array('name' => '(UTC+09:00) Sapporo', 'id' => 'Asia/Tokyo'),
	    array('name' => '(UTC+09:00) Seoul', 'id' => 'Asia/Seoul'),
	    array('name' => '(UTC+09:00) Tokyo', 'id'=> 'Asia/Tokyo'),
	    array('name' => '(UTC+09:30) Adelaide', 'id' => 'Australia/Adelaide'),
	    array('name' => '(UTC+09:30) Darwin', 'id' => 'Australia/Darwin'),
	    array('name' => '(UTC+10:00) Brisbane', 'id' => 'Australia/Brisbane'),
	    array('name' => '(UTC+10:00) Canberra', 'id' => 'Australia/Canberra'),
	    array('name' => '(UTC+10:00) Guam', 'id' => 'Pacific/Guam'),
	    array('name' => '(UTC+10:00) Hobart', 'id' => 'Australia/Hobart'),
	    array('name' => '(UTC+10:00) Melbourne', 'id' => 'Australia/Melbourne'),
	    array('name' => '(UTC+10:00) Port Moresby', 'id' => 'Pacific/Port_Moresby'),
	    array('name' => '(UTC+10:00) Sydney', 'id' => 'Australia/Sydney'),
	    array('name' => '(UTC+10:00) Yakutsk', 'id' => 'Asia/Yakutsk'),
	    array('name' => '(UTC+11:00) Vladivostok', 'id' => 'Asia/Vladivostok'),
	    array('name' => '(UTC+12:00) Auckland', 'id' => 'Pacific/Auckland'),
	    array('name' => '(UTC+12:00) Fiji', 'id' => 'Pacific/Fiji'),
	    array('name' => '(UTC+12:00) International Date Line West', 'id' => 'Pacific/Kwajalein'),
	    array('name' => '(UTC+12:00) Kamchatka', 'id' => 'Asia/Kamchatka'),
	    array('name' => '(UTC+12:00) Magadan', 'id' => 'Asia/Magadan'),
	    array('name' => '(UTC+12:00) Marshall Is.', 'id' => 'Pacific/Fiji'),
	    array('name' => '(UTC+12:00) New Caledonia', 'id' => 'Asia/Magadan'),
	    array('name' => '(UTC+12:00) Solomon Is.', 'id' => 'Asia/Magadan'),
	    array('name' => '(UTC+12:00) Wellington', 'id' => 'Pacific/Auckland'),
	    array('name' => '(UTC+13:00) Nuku\'alofa', 'id' => 'Pacific/Tongatapu')
	);
	echo json_encode($arrTimez);
	exit;	
}
add_action( 'wp_ajax_nopriv_gettimez', 'getTimeZones' );
add_action( 'wp_ajax_gettimez', 'getTimeZones' );

/*****************************END AJAX/ANGUALR FUNCTIONS******************/
?>