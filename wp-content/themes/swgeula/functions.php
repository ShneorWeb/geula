<?php

/**
 * swgeula functions and definitions
 *
 * @package swgeula
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

if ( ! function_exists( 'swgeula_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function swgeula_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on swgeula, use a find and replace
	 * to change 'swgeula' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'swgeula', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	//add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'swgeula' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'swgeula_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // swgeula_setup
add_action( 'after_setup_theme', 'swgeula_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */


/**
 * Enqueue scripts and styles.
 */
function swgeula_scripts() {

	wp_enqueue_script( 'swgeula-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'swgeula-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'swgeula_scripts' );

/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

function my_scripts() {	
	
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


/************************************************************************
erez styles and scripts
*************************************************************************/

/* styles */
function swgeula_styles() {
	wp_enqueue_style(
        'bootstrap_css', get_template_directory_uri() . '/css/bootstrap.min.css' 
    );
    
    /* theme css have to be last */
    wp_enqueue_style(
        'swgeula_style', get_template_directory_uri() . '/style.css'
    );
}

add_action( 'wp_enqueue_scripts', 'swgeula_styles' );

/* script */
function swgeula_manual_scripts(){
	wp_enqueue_script(
        'jquery', '//code.jquery.com/jquery-1.11.2.min.js', array(), '1.0.0'
    );
    wp_enqueue_script(
        'live', get_template_directory_uri() . '/js/live.js', array(), '1.0.0'
    );
    wp_enqueue_script(
        'bootstrap_script', get_template_directory_uri() . '/js/bootstrap.min.js', array(), '1.0.0'
    );
    
    /* theme js have to be last */
     wp_enqueue_script(
        'theme_js', get_template_directory_uri() . '/js/theme.js', array(), '1.0.0'
    );
}

add_action( 'wp_enqueue_scripts', 'swgeula_manual_scripts' );


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
		 $pswrd = $_POST['password'];
		 $pswrd2 = $_POST['password2'];
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
		
		
		 
		if( empty( $error ) ){
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
		 	else {	 
				//now update meta data:
		 		update_user_meta( $uid, 'user_lang', $lang );

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
/*****************************END AJAX/ANGUALR FUNCTIONS******************/
?>