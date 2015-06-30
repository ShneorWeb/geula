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

global $IS_LOCAL;
$pos1 = strpos(get_bloginfo('wpurl'), "127.0.0.1"); //dev	
if ($pos1 === false) $IS_LOCAL=false;
else $IS_LOCAL = true;

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

function swgeula_scripts() {	

	global $post;

	wp_enqueue_script( 'swgeula-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', false );

	wp_enqueue_script( 'swgeula-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', false );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}	
	if( is_page("settings") ) :
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
			'password-strength',
			get_stylesheet_directory_uri() . '/js/ng-password-strength.min.js'			
		);
		wp_enqueue_script(
			'vendor',
			get_stylesheet_directory_uri() . '/js/vendor.js'			
		);
		wp_enqueue_script(
			'my-scripts',
			get_stylesheet_directory_uri() . '/js/angular_main.js',
			array( 'angularjs', 'angularjs-route' )
		);	
	endif;	
	wp_localize_script(
		'my-scripts',
		'myLocalized',
		array(
			'theme_dir' => trailingslashit( get_template_directory_uri() ), 
			'wpadmin_dir' => trailingslashit( admin_url() ),
			'home_url' => trailingslashit( home_url() )
			)
	);
    
     
    
}

add_action( 'wp_enqueue_scripts', 'swgeula_scripts' );


/************************************************************************
erez styles and scripts
*************************************************************************/
 
/* styles */
function swgeula_styles() {
	wp_enqueue_style(
        'bootstrap_css', get_template_directory_uri() . '/css/bootstrap.css' 
    );    
   //hebrew version only
    if(is_rtl()){
         wp_enqueue_style(
            'bootstrap_rtl_css', get_template_directory_uri() . '/css/bootstrap-rtl.css' 
        );
    }
   
    /*wp_enqueue_style(
            'datepicker', get_template_directory_uri() . '/css/datepicker.css' 
    );*/
    wp_enqueue_style(
        'font-awesome', get_template_directory_uri() . '/css/font-awesome.css' 
    );
     wp_enqueue_style(
        'geulasw_font', get_template_directory_uri() . '/css/geulasw_font.css' 
    );
     wp_enqueue_style(
        'moris', get_template_directory_uri() . '/css/morris.css' 
    );
     wp_enqueue_style(
        'mCustomScrollbar_css', get_template_directory_uri() . '/css/jquery.mCustomScrollbar.min.css' 
    );
    
    /* theme css have to be last */
    wp_enqueue_style(
        'swgeula_style', get_template_directory_uri() . '/style.css'
    );
     wp_enqueue_style(
        'swgeula_profile_style', get_template_directory_uri() . '/css/profile.css'
    );
}

add_action( 'wp_enqueue_scripts', 'swgeula_styles' );

/* script */
function swgeula_manual_scripts(){
	wp_enqueue_script(
        'jquery', '//code.jquery.com/jquery-1.11.2.min.js', array(), '1.0.0'
    );
    if($_SERVER['REMOTE_ADDR']=='127.0.0.1'){
        wp_enqueue_script( 'live', get_template_directory_uri() . '/js/live.js', array(), '',true ); 
    }
    wp_enqueue_script(
        'bootstrap_script', get_template_directory_uri() . '/js/bootstrap.min.js', array(), '1.0.0'
    );
     wp_enqueue_script(
        'bootstrap-select', get_template_directory_uri() . '/js/bootstrap-select.js', array(), '1.0.0'
    );
     wp_enqueue_script(
        'moment-with-locales', '//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js', array()
    );     
    wp_enqueue_script(
        'moment-tzones', get_template_directory_uri() . '/js/moment-timezone-with-data.js', array()
    );    
    
    wp_enqueue_script(
        'bootstrap-tabcollapse', get_template_directory_uri() . '/js/bootstrap-tabcollapse.js', array(), '1.0.0'
    );
     wp_enqueue_script(
        'raphael', get_template_directory_uri() . '/js/raphael-min.js', array(), '1.0.0'
    );
     wp_enqueue_script(
        'morris', get_template_directory_uri() . '/js/morris.min.js', array(), '1.0.0'
    );
     wp_enqueue_script(
        'mCustomScrollbar', get_template_directory_uri() . '/js/jquery.mCustomScrollbar.concat.min.js', array(), '1.0.0'
    );
    
    
    /* theme js have to be last */
     wp_register_script(
        'theme_js', get_template_directory_uri() . '/js/theme.js', array(), '1.0.0'
    );
     wp_enqueue_script( 'theme_js' );
    // use wp_localize_script to pass PHP variables into javascript
     /*$site_name = get_bloginfo( 'name' );*/
     wp_localize_script( 'theme_js', 'ourPhpVariables', array( 
        'ajaxurl' => admin_url( 'admin-ajax.php' )
     ) );
	
}

add_action( 'wp_enqueue_scripts', 'swgeula_manual_scripts' );

/***************************LANGUAGE SETTINGS********************************************/
function lang_setup(){	
	if (is_user_logged_in()) {	    	 
			global $sitepress;			
		    
		    $current_user = wp_get_current_user();
			$uid = $current_user->ID;
			$lang = get_user_meta( $uid, 'user_lang', true );

			$lang  = strstr($lang,"_",true);			
			if (!is_admin()) $sitepress->switch_lang($lang);				
	}
	
    load_theme_textdomain('swgeulatr', get_template_directory() . '/languages');    
}
add_action('after_setup_theme', 'lang_setup');

function sw_setup() {
	global $gsLocale;
	global $gsLocaleShort;
	$gsLocale = "en_US";	
	$arrLangs = icl_get_languages();
	if ( is_array($arrLangs) ) {
	  foreach ($arrLangs as $arrLang)
	    if ($arrLang['active']==1) { //active language
	        $gsLocale = $arrLang['default_locale'];
	    }
	}
	$gsLocaleShort = strstr($gsLocale,"_",true);

	if ( is_user_logged_in() && !is_admin() && ($gsLocaleShort=="en") && !isset($_GET['lang']) && (strstr($_SERVER['REQUEST_URI'],"my-account/settings")===false) ) {  //fix for en links that don't have lang parameter
	  wp_redirect( add_query_arg( 'lang', 'en' ) );
	}
}
add_action('template_redirect', 'sw_setup');
/***************************END LANGUAGE SETTINGS********************************************/

/************************** user registration stuff: ************************************/
function swgeula_login_logo() { ?>
    <style type="text/css">
        body.login div#login h1 a {            
        	display:none;
        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'swgeula_login_logo' );

function swgeula_login_page( $login_url, $redirect ) {
    return home_url( '/my-account/sign-in/?action=login&redirecr='.$redirect);
}
add_filter( 'login_url', 'swgeula_login_page', 10, 2 );

function swgeula_reg_page( $register_url ) {
    return home_url( '/registration/' );
}
add_filter( 'register_url', 'swgeula_reg_page', 10, 2 );

function swgeula_lost_pass_page( $lostpassword_url, $redirect ) {
    return home_url( '/registration/?action=lostpassword&redirecr='.$redirect );
}
add_filter( 'lostpassword_url', 'swgeula_lost_pass_page', 10, 2 );


/*
function reset_password_message( $message, $key ) {

	$message = str_replace("wp-login.php","registration/",$message);	
	return $message;
}
add_filter('retrieve_password_message', reset_password_message, 10, 2);
*/


function swgeula_registration_errors( $errors, $sanitized_user_login, $user_email ) {
        
        if ( empty( $_POST['full_name'] ) || !empty( $_POST['full_name'] ) && trim( $_POST['full_name'] ) == '' ) {
            $errors->add( 'full_name_error', __( '<strong>ERROR</strong>: Please type your full name.', 'mydomain' ) );
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


/*
// Redefine user notification function
if ( !function_exists('wp_new_user_notification') ) {

	function wp_new_user_notification( $user_id, $plaintext_pass = '' ) {

		$user = new WP_User( $user_id );

		$user_login = stripslashes( $user->user_login );
		$user_email = stripslashes( $user->user_email );

		$message  = sprintf( __('New user registration on %s:'), get_option('blogname') ) . "\r\n\r\n";
		$message .= sprintf( __('Username: %s'), $user_login ) . "\r\n\r\n";
		$message .= sprintf( __('E-mail: %s'), $user_email ) . "\r\n";

		@wp_mail(
			get_option('admin_email'),
			sprintf(__('[%s] New User Registration'), get_option('blogname') ),
			$message
		);

		if ( empty( $plaintext_pass ) )
			return;

		$message  = __('Hi there,') . "\r\n\r\n";
		$message .= sprintf( __("Welcome to %s! Here's how to log in:"), get_option('blogname')) . "\r\n\r\n";
		$message .= wp_login_url() . "\r\n";
		$message .= sprintf( __('Username: %s'), $user_login ) . "\r\n";
		$message .= sprintf( __('Password: %s'), $plaintext_pass ) . "\r\n\r\n";
		$message .= sprintf( __('If you have any problems, please contact me at %s.'), get_option('admin_email') ) . "\r\n\r\n";
		$message .= __('Adios!');

		wp_mail(
			$user_email,
			sprintf( __('[%s] Your username and password'), get_option('blogname') ),
			$message
		);
	}
}*/
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

 function compareDates($a, $b) {
            if ( $a['date'] == $b['date'] ) {
              return 0;
            }
            return ($a['date'] < $b['date']) ? 1 : -1;
}
function compareDates2($a, $b) {
            if ( $a['date'] == $b['date'] ) {
              return 0;
            }
            return ($a['date'] < $b['date']) ? -1 : 1;
}

function compareNames($a, $b) {
            if ( $a->name == $b->name ) {
              return 0;
            }
            return ($a->name < $b->name) ? -1 : 1;
}

/************************* Prevent access to wp-admin for subscribers  *********************************/
function sw_redirect_admin(){
	if ( is_user_logged_in() ) {

		$user = new WP_User( get_current_user_id() );
		if ( !empty( $user->roles ) && is_array( $user->roles ) ) {
			foreach ( $user->roles as $role ) :				
				if ($role=="subscriber" || $role=="instructor") {
					wp_safe_redirect(get_category_link(3));
					exit;		
				}
			endforeach;	
		}		
	}		
}
add_action( 'admin_init', 'sw_redirect_admin' );
/************************* End Prevent access to wp-admin for subscribers  *********************************/

/************************* Session Management *********************************/
/*
function myStartSession() {
    if(!session_id()) {
        session_start();
    }
}
function myEndSession() {
    session_destroy ();
}
add_action('init', 'myStartSession', 1);
add_action('wp_logout', 'myEndSession');
add_action('wp_login', 'myEndSession');
*/
/************************* END Session Management *********************************/
/****************Lessons Ajax ****************************************/
function set_video_loc() {
	global $wpdb;	
	
	$lessonID = (int)$_POST['lesson_id'];
	$catID = (int)$_POST['cat_id'];
	$vidLoc = (float)$_POST['video_loc'];
	$userID = (int)$_POST['user_id'];

	if ( is_int($userID) && is_numeric($vidLoc) && is_int($lessonID) && is_int($catID) ) :
			
		$results = $wpdb->get_results("SELECT * FROM wp_sw_user_lesson WHERE user_id = $userID AND lesson_id = $lessonID  LIMIT 1;",ARRAY_A);		
		
		if (count($results)>0) {

			foreach($results as $row) {								
				
				$rowid = $row['id']; 				
			
				$wpdb->update( 
					'wp_sw_user_lesson', 
					array( 
					  'video_pos' => $vidLoc,

					), 
					array( 'id' =>  $rowid)					
				); 			
			}			
		}
		else {					
			$wpdb->insert("wp_sw_user_lesson", array( 		
				'user_id' => $userID, 
				'lesson_id' => $lessonID, 
				'cat_id' => $catID, 
				'video_pos' => $vidLoc,
				'date_added' => date_create()->format('Y-m-d H:i:s'),
				'done' => 0
			));								
		}
		$wpdb->update( 
				'wp_sw_cats_learn', 
				array( 
					'cat_status' => 1
				), 
				array( 'cat_id' => $catID, 'user_id' => $userID )			
		);	
		echo("success");
		exit; 		

	endif;
	echo("fail");			
	exit;
}
add_action('wp_ajax_video_played', 'set_video_loc');
add_action('wp_ajax_nopriv_video_played', 'set_video_loc');

function getVideoLoc() {
	global $wpdb;	
	
	$lessonID = (int)$_POST['lesson_id'];
	$userID = (int)$_POST['user_id'];

	if ( is_int($userID) && is_int($lessonID) ) :

		$results = $wpdb->get_results("SELECT video_pos FROM wp_sw_user_lesson WHERE user_id = $userID AND lesson_id = $lessonID  ORDER BY id DESC LIMIT 1;",ARRAY_A);		
		
		if (count($results)>0) {

			foreach($results as $row) {																
				echo($row['video_pos']);				
				exit;
			}
		}		
	
	endif;
	echo(0);			
	exit;
}
add_action('wp_ajax_get_video_loc', 'getVideoLoc');
add_action('wp_ajax_nopriv_get_video_loc', 'getVideoLoc');



function setVideoDone() {
	global $wpdb;	
	
	$lessonID = (int)$_POST['lesson_id'];
	$userID = (int)$_POST['user_id'];
	$catID = (int)$_POST['cat_id'];

	if ( is_int($userID) && is_int($lessonID) ) :

		$wpdb->update( 
			'wp_sw_user_lesson', 
			array( 
				'done' => 1
			), 
			array( 'lesson_id' => $lessonID, 'user_id' => $userID )			
		);
		
		//now check if all lessons done mark category as done
		$results = $wpdb->get_results("SELECT id FROM wp_sw_user_lesson WHERE user_id = $userID AND cat_id = $catID AND done=0  LIMIT 1;",ARRAY_A);		
		
		if (count($results)==0) {
			$wpdb->update( 
					'wp_sw_cats_learn', 
					array( 
						'cat_status' => 2
					), 
					array( 'cat_id' => $catID, 'user_id' => $userID )			
			);	
		}

		echo(1);			
		exit;
							
	endif;
	echo(0);			
	exit;
}
add_action('wp_ajax_set_video_done', 'setVideoDone');
add_action('wp_ajax_nopriv_set_video_done', 'setVideoDone');

function googleUserReg() {	
	global $wpdb;	

	$uid_google = $_POST['uid'];
	$fname = $_POST['first_name'];
	$lname = $_POST['last_name'];
	$display_name = $_POST['display-name'];
	$imageUrl = $_POST['image_url'];
	$email = $_POST['primary_email'];
	$aboutMe = $_POST['about_me'];
	$language = $_POST['language'];
	$occupation = $_POST['occupation'];
	$lang = $_POST['language'];
	$plived = $_POST['places-lived'];

	

	$arrPlived = explode(",", $plived);
	if ( is_array($arrPlived) ) {
		if (isset($arrPlived[0])) $city = $arrPlived[0];
		if (isset($arrPlived[1])) $country = $arrPlived[1];
	}


	if ( !empty($uid_google) && !empty($email) && (!empty($fname) || !empty($lname)) ) :

		$results = $wpdb->get_results("SELECT user_id FROM wp_sw_google_users WHERE google_id = $uid_google LIMIT 1;",ARRAY_A);		
		
		if (count($results)>0) { //user found. login			
				wp_set_auth_cookie($results[0]['user_id']);				
				echo 11;
				exit;
		}
		elseif( !empty($email) ) { //user is regsitered with wordpress so link to google account			
			$results = $wpdb->get_results("SELECT ID FROM wp_users WHERE user_email = '$email' LIMIT 1;",ARRAY_A);	
			if (count($results)>0) { 
				$wpdb->insert("wp_sw_google_users", array( 		
						'user_id' => $results[0]['ID'], 
						'google_id' => $uid_google						
					));
				wp_set_auth_cookie($user_id);		
				echo 11;
				exit;			 
			}		
			else { //new user so sign him up and link to google account						
				$random_password = wp_generate_password( $length=12, $include_standard_special_chars=false );			    

				$userdata = array(
				    'user_login'  =>  $email,
				    'user_email' => $email,			     
				    'user_pass'   =>  $random_password,
				    'first_name' => $fname,
				    'last_name' => $lname,	
				    'display_name' => $display_name,
				    'description' => $aboutMe,
				    'subject' => $occupation
				);						
				$user_id = wp_insert_user( $userdata ) ;			
				
				if( !is_wp_error($user_id) ) { 						
				 		
						$wpdb->insert("wp_sw_google_users", array( 		
							'user_id' => $user_id, 
							'google_id' => $uid_google						
						));

						if ( !empty($imageUrl) ) {
							$imageUrl1 = str_replace("sz=50", "sz=60", $imageUrl);
							$imageUrl2 = str_replace("sz=50", "sz=100", $imageUrl);
							$imageUrl3 = str_replace("sz=50", "sz=160", $imageUrl);
							$imageUrl4 = str_replace("sz=50", "sz=240", $imageUrl);
							$imageUrl5 = str_replace("sz=50", "sz=49", $imageUrl);

							update_usermeta('', 'custom_avatar', $imageUrl1);
							update_usermeta($user_id, 'custom_avatar_100', $imageUrl2);
							update_usermeta($user_id, 'custom_avatar_160', $imageUrl3);
							update_usermeta($user_id, 'custom_avatar_240', $imageUrl4);
							update_usermeta($user_id, 'custom_avatar_49', $imageUrl5);
						}

						if (!empty($lang)) update_user_meta($user_id, 'user_lang', $lang);
						if (!empty($city)) update_user_meta($user_id, 'user_city', $city);
						if (!empty($country)) update_user_meta($user_id, 'user_country', $country);	 					

						wp_set_auth_cookie($user_id);		
						echo 1;
						exit;			 
				}
				else {
					echo 0;
					exit;	
				}
			}
		}			
	endif;

	echo 0;
	exit;		
}
add_action('wp_ajax_google_user_reg', 'googleUserReg');
add_action('wp_ajax_nopriv_google_user_reg', 'googleUserReg');


function getLessonStarted($lessonID,$userID) {
	global $wpdb;		
	

	if ( is_int($userID) && is_int($lessonID) ) :

		$results = $wpdb->get_results("SELECT lesson_id,video_pos,done FROM wp_sw_user_lesson WHERE user_id = $userID AND lesson_id = $lessonID ORDER BY id DESC LIMIT 1;",ARRAY_A);		
		
		if (count($results)>0) {			

			foreach($results as $row) {																
				
				if ($row['done']==1) return 2;				
				elseif ($row['video_pos']>0) return 1;	
				else return 0;										
			}
			
		}

	endif;	

	return 0;		
}

function getNextLessonToPlay($catID) {
	global $wpdb;		
	
	$userID = get_current_user_id();

	if ( is_int($catID) && ($catID>0) && is_int($userID) && ($userID>0) ) :


		$results = $wpdb->get_results("SELECT lesson_id,done FROM wp_sw_user_lesson WHERE user_id = $userID AND cat_id = $catID ORDER BY lesson_id ASC;",ARRAY_A);		

		if (count($results)>0) {			

			foreach($results as $row) {																				
				if ($row['done']==0) return $row['lesson_id'];					
			}			
			return $results[0]['lesson_id'];
		}
	endif;	
}


function addToMyLessons() {
	global $wpdb;	
	$userID = -1;
	$arrLessonIDs = array();

	if ( is_user_logged_in() ) { 		
		$catID = (int)$_POST['cat_id'];
		
		$current_user = wp_get_current_user();
		$userID = $current_user->ID;	

		
		if ( is_int($userID) && ($catID>0) ) :


			$results = $wpdb->get_results("SELECT id FROM wp_sw_cats_learn WHERE user_id = $userID AND cat_id = $catID LIMIT 1;",ARRAY_A);		
			$results2 = $wpdb->get_results("SELECT id FROM wp_sw_user_lesson WHERE user_id = $userID AND cat_id = $catID AND video_pos>0 LIMIT 1;",ARRAY_A);		
			
			if (count($results)>0) continue;
			else {
				$wpdb->insert("wp_sw_cats_learn", array( 		
						'user_id' => $userID,						
						'cat_id' => $catID, 										
						'date_added' => date('Y-m-d H:i:s'),
						'cat_status' => (count($results2)>0)?1:0
				));
			}
		
			echo 1;		
			exit;
				
		endif;	
	}

	echo 0;		
	exit;
}
add_action('wp_ajax_add_to_my_lessons', 'addToMyLessons');
add_action('wp_ajax_nopriv_add_to_my_lessons', 'addToMyLessons');

function removeFromMyLessons() {
	global $wpdb;	
	$userID = -1;	

	if ( is_user_logged_in() ) { 		
		$catID = (int)$_POST['cat_id'];
		
		$current_user = wp_get_current_user();
		$userID = $current_user->ID;		

		
		if ( is_int($userID) && ($catID>0) ) :			
				
				$wpdb->delete( 'wp_sw_cats_learn', array( 'user_id'=>$userID, 'cat_id' => $catID ) );
				echo 1;		
				exit;
				
		endif;	
	}

	echo 0;		
	exit;
}
add_action('wp_ajax_remove_from_my_lessons', 'removeFromMyLessons');
add_action('wp_ajax_nopriv_remove_from_my_lessons', 'removeFromMyLessons');

function getCatInMyLessons($catID) {
	global $wpdb;	
	if ( is_user_logged_in() ) :	
		
		if ($catID>0) :

			$current_user = wp_get_current_user();
			$userID = $current_user->ID;
			

			if (is_int($userID)) :

				$results = $wpdb->get_results("SELECT cat_status FROM wp_sw_cats_learn WHERE user_id = $userID AND cat_id = $catID LIMIT 1;",ARRAY_A);		
					
					if (count($results)>0) :								

						return $row['cat_status']; //2 - category done, 1 - being studied, 0 not started					
							

					endif;
			endif;		

		endif;	

	endif; //user logged in

	return(-1);	
}

function getMyCatsStudied() {
	global $wpdb;	

	if ( is_user_logged_in() ) :				
		$current_user = wp_get_current_user();
		$userID = $current_user->ID;

		if (is_int($userID)) :

				$arrRetVal = array();	

				$results = $wpdb->get_results("SELECT DISTINCT cat_id FROM wp_sw_cats_learn WHERE user_id = $userID AND cat_status>0 ORDER BY cat_id ASC;",ARRAY_A);		
					
				if (count($results)>0) :					
					
					foreach($results as $row) :			
						$checkCat = get_categories('hide_empty=>0,include=>'.$row['cat_id']); //get_categories only return categoires in current language					
						if (count($checkCat)>0) $arrRetVal[] = $row['cat_id'];	
					endforeach;

				endif;

				return $arrRetVal;
	 	endif;			

	 endif;
	 return array();
}

function getMyCatsNotYetStudied() {
	global $wpdb;	

	if ( is_user_logged_in() ) :				
		$current_user = wp_get_current_user();
		$userID = $current_user->ID;

		if (is_int($userID)) :

				$arrRetVal = array();	

				$results = $wpdb->get_results("SELECT DISTINCT cat_id FROM wp_sw_cats_learn WHERE user_id = $userID AND cat_status=0 ORDER BY cat_id ASC;",ARRAY_A);		
					
				if (count($results)>0) :					
					
					foreach($results as $row) :			
						$checkCat = get_categories('hide_empty=>0,include=>'.$row['cat_id']); //hack - get_categories only returns categories in current language - maybe change this todo					
						if (count($checkCat)>0) $arrRetVal[] = $row['cat_id'];	
					endforeach;

				endif;

				return $arrRetVal;
	 	endif;			

	 endif;
	 return array();
}

function getLessonNotYetDone() {
	global $wpdb;	

	if ( is_user_logged_in() ) :				
		$current_user = wp_get_current_user();
		$userID = $current_user->ID;

		if (is_int($userID)) :

				$arrRetVal = array();	

				$results = $wpdb->get_results("SELECT DISTINCT cat_id FROM wp_sw_cats_learn WHERE user_id = $userID AND cat_status!=2 ORDER BY id ASC;",ARRAY_A);		
					
				if (count($results)>0) :					
					
					foreach($results as $row) :			
						$checkCat = get_categories('hide_empty=>0,include=>'.$row['cat_id']); //get_categories only return categoires in current language					
						if (count($checkCat)>0) $arrRetVal[] = $row['cat_id'];	
					endforeach;

				endif;

				return (array)$arrRetVal;
	 	endif;			

	 endif;
	 return array();
}


function getMyCatsTeach($parentCat=-1,$userID) {

	global $wpdb;	
	$arrRetVal = array();			

	if (is_int($userID)) :							

			$args = array(
				'type'                     => 'post',
				'child_of'                 => ($parentCat==-1)?getCatIDOfLibrary():$parentCat,					
				'orderby'                  => 'name',
				'order'                    => 'ASC',
				'hide_empty'               => 0,					
				'taxonomy'                 => 'category'					
			); 
			$results = get_categories( $args );				
				
			if (count($results)>0) :					
				
				foreach($results as $row) :								
					$cat_authors = get_field('swauthors', "category_".$row->cat_ID);													
					if ( is_array($cat_authors) && count($cat_authors)>0 ) $authorID = $cat_authors['ID'];
					else $authorID=-1;

					if ( ($authorID == $userID) && !in_array($row->cat_ID,$arrRetVal) ) $arrRetVal[] = $row->cat_ID;	
				endforeach;				

			endif;							
	
 	endif;

 	return $arrRetVal;
}

function get_timezone_offset($remote_tz, $origin_tz = null) {
    if($origin_tz === null) {
        if(!is_string($origin_tz = date_default_timezone_get())) {
            return false; // A UTC timestamp was returned -- bail out!
        }
    }
    $origin_dtz = new DateTimeZone($origin_tz);
    $remote_dtz = new DateTimeZone($remote_tz);
    $origin_dt = new DateTime("now", $origin_dtz);
    $remote_dt = new DateTime("now", $remote_dtz);
    $offset = $origin_dtz->getOffset($origin_dt) - $remote_dtz->getOffset($remote_dt);
    return $offset;
}

function addSchedule() {
	global $wpdb;	

	if ( is_user_logged_in() ) { 		
		$current_user = wp_get_current_user();
		$userID = $current_user->ID;		

		$scheduleDay = (int)$_POST['schedule_day'];
		$scheduleTime = $_POST['schedule_time'];	
		$bAdd =  (int) $_POST['bool_add'];	

		$user_tz = get_user_meta( $userID, 'user_timezone', true );

		if (is_string($user_tz)) {
			$offset = get_timezone_offset($user_tz);
			$offset /= 3600; //change to hours			
			$hour = (int)substr($scheduleTime,0,(int)strpos($scheduleTime,":"));
			$mins = (int)substr($scheduleTime,strpos($scheduleTime,":")+1);							

			$hour += $offset;
			if ($hour>=24) {
				$hour -= 24;
				$scheduleDay += 1;
				if ($scheduleDay==8) $scheduleDay=1;
			}
			elseif ($hour<0) {
				$hour += 24;
				$scheduleDay -= 1;
				if ($scheduleDay==0) $scheduleDay=7;
			}
			$scheduleTime = ($hour>9?$hour:'0'.$hour) . ':' . ($mins>9?$mins:'0'.$mins);			
		}

		$wpdb->delete( 'wp_sw_schedules', array( 'user_id' => $userID, 'schedule_day' => $scheduleDay, 'schedule_time' => $scheduleTime) );

		if ($bAdd) {
			$wpdb->insert("wp_sw_schedules", array( 		
							'user_id' => $userID,
							'schedule_day' => $scheduleDay, 																		
							'schedule_time' => $scheduleTime,
							'repeat' => 1
							)				
				);
			echo '1';				
			exit;
		}
		else { //deleted scedule. Find out if another user is scheduled to same time
			$results = $wpdb->get_results("SELECT id FROM wp_sw_schedules WHERE schedule_day = $scheduleDay AND schedule_time='$scheduleTime';",ARRAY_A);		
			if (count($results)>0) echo '2';
			else echo '0';
			exit;
		}		
	}
	echo '0';
	exit;
}
add_action('wp_ajax_add_schedule', 'addSchedule');
add_action('wp_ajax_nopriv_add_schedule', 'addSchedule');

function getScheduleSlotsForDay($iDay) {
	$arrSlots = array(48); //48 half our slots. 1-taken, 0-free

	if ( is_user_logged_in() ) { 		
		$current_user = wp_get_current_user();
		$userID = $current_user->ID;			

		for ($i=0;$i<48;$i++) $arrSlots[$i]=0; //init to 0

		global $wpdb;	
		$results = $wpdb->get_results("SELECT schedule_time, user_id FROM wp_sw_schedules WHERE schedule_day = $iDay order by schedule_time ASC;",ARRAY_A);		
		if (count($results)>0) :
			foreach($results as $row) :	
				$hour = (int)substr($row['schedule_time'],0,(int)strpos($row['schedule_time'],":"));
				$mins = (int)substr($row['schedule_time'],strpos($row['schedule_time'],":")+1);							
				if ($mins>0) $mins /= 30; 			
				if ( $row['user_id']==$userID ) $arrSlots[$hour*2 + $mins] = 2; //2 - taken by me 
				elseif ($arrSlots[$hour*2 + $mins]==0) $arrSlots[$hour*2 + $mins] = 1; //1 - taken
			endforeach;
		endif;

		$user_tz = get_user_meta( $userID, 'user_timezone', true );
		$offset = get_timezone_offset($user_tz);
		$offset /= 3600; //change to hours	

		if ($offset<0) {			
			$offset *= -1;
			$tempArray = array(48);
			for ($i=0;$i<48;$i++) $tempArray[$i]=0; //init to 0

			for ($i=0;$i<(48-$offset*2) ;$i++) {
				$tempArray[$i+($offset*2)] = $arrSlots[$i];
			}
			
			//get necessary values from previous day:
			$iDay -= 1;
			if ($iDay<=0) $iDay=7;
			$results = $wpdb->get_results("SELECT schedule_time,user_id FROM wp_sw_schedules WHERE schedule_day = $iDay order by schedule_time ASC;",ARRAY_A);	
			if (count($results)>0) :
				foreach($results as $row) :	
					$hour = (int)substr($row['schedule_time'],0,(int)strpos($row['schedule_time'],":"));
					$mins = (int)substr($row['schedule_time'],strpos($row['schedule_time'],":")+1);							
					if ($mins>0) $mins /= 30; 
					if ($hour >= 24-$offset) {
						$hour += $offset;
						if ($hour>=24) $hour -= 24;
						if ( $row['user_id']==$userID ) $tempArray[$hour*2 + $mins] = 2; //2 - taken by me 
						elseif ($tempArray[$hour*2 + $mins]==0) $tempArray[$hour*2 + $mins] = 1;//1 - taken
					}
				endforeach;
			endif;

			$arrSlots = $tempArray;
		}
		elseif ($offset>0) {			
			$tempArray = array(48);
			for ($i=0;$i<48;$i++) $tempArray[$i]=0; //init to 0

			for ($i=47;$i>=($offset*2) ;$i--) {
				$tempArray[$i-($offset*2)] = $arrSlots[$i];
			}
			
			//get necessary values from next day:
			$iDay += 1;
			if ($iDay>7) $iDay=1;
			$results = $wpdb->get_results("SELECT schedule_time, user_id FROM wp_sw_schedules WHERE schedule_day = $iDay order by schedule_time ASC;",ARRAY_A);	
			if (count($results)>0) :
				foreach($results as $row) :	
					$hour = (int)substr($row['schedule_time'],0,(int)strpos($row['schedule_time'],":"));
					$mins = (int)substr($row['schedule_time'],strpos($row['schedule_time'],":")+1);							
					if ($mins>0) $mins /= 30; 
					if ($hour < $offset) {
						$hour += (24-$offset);
						if ( $row['user_id']==$userID ) $tempArray[$hour*2 + $mins] = 2; //2 - taken by me 
						elseif ($tempArray[$hour*2 + $mins]==0) $tempArray[$hour*2 + $mins] = 1; //1 - taken
					}
				endforeach;
			endif;

			$arrSlots = $tempArray;
		}


	}
	return $arrSlots;
}


function cmpDays($a, $b) {
    if ($a[0] == $b[0]) {        
    	return ($a[1] < $b[1]) ? -1 : 1;	
    }
    return ($a[0] < $b[0]) ? -1 : 1;
}

function getNextSchedule($userID) {
	global $wpdb;	
	$arrRetVal = array(2);

	if (is_int($userID)) :

			$date = new DateTime('NOW');
			$user_tzone = get_user_meta( $userID, 'user_timezone', true );
			if (is_string($user_tzone) && !empty($user_tzone)) $date->setTimezone(new DateTimeZone($user_tzone));
			$curDay = (int)$date->format('N');			
			$curHours = (int)$date->format('G');					 
			$curMins = (int)$date->format('i');					 

			$offset = get_timezone_offset($user_tzone);
			$offset /= 3600; //change to hours

			$offset *= -1; //when retreiving time convert backwards

			$results = $wpdb->get_results("SELECT schedule_day,schedule_time FROM wp_sw_schedules WHERE (user_id = $userID) AND (schedule_day>=$curDay)  ORDER BY schedule_day ASC,schedule_time ASC;",ARRAY_A);											

			if (count($results)==0) $results = $wpdb->get_results("SELECT schedule_day,schedule_time FROM wp_sw_schedules WHERE (user_id = $userID) ORDER BY schedule_day ASC,schedule_time ASC;",ARRAY_A);											


			if (count($results)>0 ) :	
				$arrDaysAndTimes = array();
				foreach($results as $row) :																																

						$scheduleHours = (int)substr($row['schedule_time'],0,(int)strpos($row['schedule_time'],":"));
						$scheduleMins = (int)substr($row['schedule_time'],strpos($row['schedule_time'],":")+1);

						$scheduleHours += $offset;
						if ($scheduleHours>=24) {
							$scheduleHours -= 24;
							$row['schedule_day'] += 1;
							if ($row['schedule_day']==8) $row['schedule_day']=1;
						}
						elseif ($scheduleHours<0) {
							$scheduleHours += 24;
							$row['schedule_day'] -= 1;
							if ($row['schedule_day']==0) $row['schedule_day']=7;
						}	

						$arrDaysAndTimes[] = array($row['schedule_day'],($scheduleHours>9?$scheduleHours:'0'.$scheduleHours).':'.($scheduleMins>9?$scheduleMins:'0'.$scheduleMins));					
										
				endforeach;

				uasort($arrDaysAndTimes, 'cmpDays');								

				foreach ($arrDaysAndTimes as $row) :
					if ($row[0] < $curDay) {
						$val = array_shift($arrDaysAndTimes);
						array_push($arrDaysAndTimes,$val);
					}
				endforeach;

				foreach ($arrDaysAndTimes as $row) :
					if ($row[0]==$curDay) {
						$scheduleHours = (int)substr($row[1],0,(int)strpos($row[1],":"));
						$scheduleMins = (int)substr($row[1],(int)strpos($row[1],":")+1);

						
						if ( ($scheduleHours < $curHours) || ($scheduleHours==$curHours && $scheduleMins<$curMins))  {
							$val = array_shift($arrDaysAndTimes);
							array_push($arrDaysAndTimes,$val);
						}
					}
				endforeach;

				$arrRetVal = array(2);
				$arrRetVal[0] = $arrDaysAndTimes[0][0];
				$arrRetVal[1] =  $arrDaysAndTimes[0][1];;								
				return $arrRetVal; 
				

			endif;
	endif;
	return (array)$arrRetVal;	
}


function getNextScheduledCat($userID) {
	global $wpdb;			

	if (is_int($userID)) :

			$arrCatsNotStudies = getLessonNotYetDone();			

			$results = $wpdb->get_results("SELECT id FROM wp_sw_schedules WHERE user_id = $userID LIMIT 1;",ARRAY_A);											

			if (is_array($results) && count($results)>0 && count($arrCatsNotStudies)>0 ) :																							
				return (array)$arrCatsNotStudies;														
			endif;

 	endif;			

		
	return -1;
}

function YTDurationToSeconds($sMatch) {		
  $di = new DateInterval($sMatch);      
  $seconds =$di->h*3600 + $di->i*60 + $di->s;
  return $seconds;
}
function getYoutubeDuration($video_id){
        
        //$data=@file_get_contents(filename)('http://gdata.youtube.com/feeds/api/videos/'.$video_id.'?v=2&alt=jsonc');
        //if (false===$data) return 0;					
		$curlSession = curl_init();									
		$sStr = 'https://www.googleapis.com/youtube/v3/videos?part=contentDetails&id='.$video_id.'&key=AIzaSyAobNQd_CHgf0eozaLmNSJp_7RyRjzmnuk';
	    curl_setopt($curlSession, CURLOPT_URL, $sStr);	    	    	    	    
	    curl_setopt($curlSession, CURLOPT_SSL_VERIFYPEER, false);
	    curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);
	    $obj = json_decode(curl_exec($curlSession));	    
	    curl_close($curlSession);         

        return YTDurationToSeconds($obj->items[0]->contentDetails->duration);
}
function formatHoursMinutes($secs) {
	$retVal = "";
	$hrs = intval(gmdate("H",$secs));
	$mins = intval(gmdate("i",$secs));

	if ($hrs>1) $retVal .= (_e($hrs) . _e (" ") . _e("hrs","swgeula"));
	elseif ($hrs>0) $retVal .= (_e("hour","swgeula"));
	if ($hrs>0 && $mins>0) $retVal .= _e(" ") . _e("and","swgeula") . _e(" ");
	if ($mins>0) $retVal .= ( _e($mins). _e(" ") . _e("mins","swgeula"));

	return $retVal;

}

function getTotalVideoDuration($arrLessonIDs) {
	global $wpdb;
	$retVal = 0;

	if (is_array($arrLessonIDs)) {

		$results = $wpdb->get_results("SELECT duration FROM wp_sw_videos WHERE lesson_id IN (".implode(",", $arrLessonIDs).") ORDER BY id DESC;",ARRAY_A);		
		
		if (count($results)>0) {
			
			foreach($results as $row) {	
				$retVal += (int)$row['duration'];
			}
		}
	}
	return $retVal;	
}
function getTotalVideoDurationCat($catID) {
	global $wpdb;
	$retVal = 0;

	if (is_numeric($catID)) :

		$mainQuery = new WP_Query( 'cat='.$catID.',post_status=publish,post_type=post' );

		if ( $mainQuery->have_posts() ) :

			while ( $mainQuery->have_posts() ) : $mainQuery->the_post();
				$arrLessonIDs[] = get_the_ID();
			endwhile;	

		endif;	

		if (is_array($arrLessonIDs) && count($arrLessonIDs)>0) :

			$results = $wpdb->get_results("SELECT duration FROM wp_sw_videos WHERE lesson_id IN (".implode(",", $arrLessonIDs).") ORDER BY id DESC;",ARRAY_A);		
			
				if (count($results)>0) {
						
						foreach($results as $row) {	
							$retVal += (int)$row['duration'];
						}
				}			
		endif;

	endif;	
	return $retVal;	
}

function getNumStudents($catID) {
	global $wpdb;

	$results = $wpdb->get_results("SELECT DISTINCT user_id FROM wp_sw_cats_learn WHERE cat_id=$catID AND cat_status=1 ORDER BY id DESC;",ARRAY_A);				
	
	return count($results);	
}

 function sw_update_video_table( $post_id, $post, $update) {	 	
 	global $wpdb;
 	global $IS_LOCAL;

	$vidURL = "";
	$vidID = -1;	

	$fieldID = $IS_LOCAL?'field_554136579a911':'field_554136579a911';	
	
	if (isset( $_REQUEST['fields'][$fieldID] )) {
		$vidURL = sanitize_text_field( $_REQUEST['fields'][$fieldID] );
		$vidArray = explode("/", $vidURL);
		$vidID = $vidArray[count($vidArray)-1];						
		
		if (preg_match('/(watch\?v=)(\S+)/',$vidID, $matches)) $vidID=$matches[2]; 		
	}
	
	if ( ($vidID!=-1)  && ($post->post_status=="publish") ) {		
		$wpdb->delete( 'wp_sw_videos', array( 'lesson_id' => $post_id ) );

		$wpdb->insert("wp_sw_videos", array( 		
				'video_id' => $vidID,
				'lesson_id' => $post_id, 				
				'duration' => getYoutubeDuration($vidID),				
				'date_added' => date('Y-m-d H:i:s')
		));
	}

	//if a new lesson is added then check if need to add to schedules of users:
	$arrCats = wp_get_post_categories($post_id);
	foreach ($arrCats  as $catid) :
		
		$results = $wpdb->get_results("SELECT user_id FROM wp_sw_user_lesson WHERE cat_id = $catid ORDER BY user_id ASC;",ARRAY_A);				
		if (count($results)>0) {
			foreach($results as $row) {	
				$results = $wpdb->get_results("SELECT user_id FROM wp_sw_user_lesson WHERE cat_id = $catid AND lesson_id=$post_id AND user_id=".$row['user_id']." ORDER BY user_id ASC LIMIT 1;",ARRAY_A);	
				if (count($results)<=0) {
					//add new lesson:
					$wpdb->insert("wp_sw_user_lesson", array( 		
							'user_id' => $row['user_id'],
							'lesson_id' => $post_id, 				
							'cat_id' => $catid,				
							'video_pos' => 0,							
							'date_added' => date('Y-m-d H:i:s'),
							'done' => 0
					));
				}
			}
		}

	endforeach;

}
add_action( 'save_post', 'sw_update_video_table', 10, 3 );

 function getVideoDuration($vidID) {
	global $wpdb;	

	$results = $wpdb->get_results("SELECT duration FROM wp_sw_videos WHERE video_id = '$vidID' ORDER BY id DESC LIMIT 1;",ARRAY_A);		
		
	if (count($results)>0) {
			
			foreach($results as $row) {	
				return $row['duration'];				
			}
	}
	return 0;	
}

function getNumLessons($catID) {
	if ( $catID>0 ) {
		$postsInCat = get_term_by('ID',$catID,'category');
		return $postsInCat->count;	
	}
	return 0;
}

function getCatBoxes() {		

	$parent_cat = (int)$_POST['parent_cat'];	
	$order = $_POST['order'];
	$orderby = $_POST['order_by'];
	$iAuthorID = (int)$_POST['author_id'];		
	$cat = (int)$_POST['cat'];		
	$this_category = get_category($cat);    	
    $parent = $this_category->parent;
    $parentcat = get_category($parent);    
    $bInNosse = (int)$_POST['in_nosse'];

	ob_start();
	include_once("inc/category_boxes.php");
	$inc = ob_get_clean();

	echo($inc);
	
	exit;
}

add_action('wp_ajax_get_cat_boxes', 'getCatBoxes');
add_action('wp_ajax_nopriv_get_cat_boxes', 'getCatBoxes');

function getCatBoxesTeach() {		

	$parent_cat = (int)$_POST['parent_cat'];			
	$order = $_POST['order'];
	$orderby = $_POST['order_by'];			    
	$authorID = (int)$_POST['author_id'];			    	


	$arrMyCats = array();
    $arrMyCats = getMyCatsTeach($parent_cat,$authorID);                                

    $bMyLessons = true;

	ob_start();
	include_once("inc/category_boxes.php");
	$inc = ob_get_clean();

	echo($inc);
	
	exit;
}

add_action('wp_ajax_get_cat_boxes_teach', 'getCatBoxesTeach');
add_action('wp_ajax_nopriv_get_cat_boxes_teach', 'getCatBoxesTeach');
/****************End Lessons Ajax ****************************************/

function getCatIDOfLibrary() {
	return 3;
}

show_admin_bar(false);


function getSWGeulaAvatar($size=60)  {
	global $current_user;
	$avtr = "";	
	$current_user = wp_get_current_user();
	$uid = $current_user->ID;

	if ($size==100 || $size==160 || $size==240 || $size==49) $avtr = get_user_meta( $uid, 'custom_avatar_'.$size, true );	
	else $avtr = get_user_meta( $uid, 'custom_avatar', true );

	if ( empty($avtr) || (is_array($avtr) && size($avtr)==0) ) $avtr = "";

	return $avtr;	
}
function getSWGeulaAvatarUID($uid,$size=96)  {
	$avtr = "";

	if ( !empty($uid) && is_numeric($uid) ) {				
		if ($size==100 || $size==160 || $size==240 || $size==49)  $avtr = get_user_meta( $uid, 'custom_avatar_'.$size, true );
		else $avtr = get_user_meta( $uid, 'custom_avatar', true );
		
		if ( empty($avtr) || (is_array($avtr) && size($avtr)==0) ) $avtr = "";
	}
	return $avtr;	
}

function my_custom_avatar( $avatar, $id_or_email, $size, $default, $alt ) {			

    if (!isset($size)) $size=60;

    if ( is_numeric( $id_or_email ) ) $id = (int)$id_or_email;       
    elseif ( is_object( $id_or_email ) ) {    	    	
        if ( !empty( $id_or_email->ID ) ) {        	
            $id = (int)$id_or_email->ID;                                                
        }        
        elseif ( !empty( $id_or_email->user_id ) ) {        	
            $id = (int)$id_or_email->user_id;                                                
        }
    }
    else {
    	$user = get_user_by( 'email', $id_or_email );
    	$id = (int) $user->ID;    	    	
    }

    if (is_numeric($id)) {    
        $customAvatarSrc = getSWGeulaAvatarUID($id,$size);        

        if ( !empty($customAvatarSrc) ) $avatar = '<img src="'.$customAvatarSrc.'"/>';                                            
    }

    return $avatar;
}
add_filter( 'get_avatar' , 'my_custom_avatar' , 1 , 5 );


function check_custom_authentication ($username) {
        global $wp_query;        
        
        $userID = username_exists($username);

        if ( !is_null($userID) && $userID>0 ) {
        	$vc = get_user_meta($userID,"verify_email_code",true);      	
        	
        	$referrer = $_SERVER['HTTP_REFERER']; 
        	$vc2 = "";
        	if (preg_match('/(vc=)(\S+)/',$referrer, $matches)) $vc2=$matches[2];         	
        	//$tempInd = (int)strpos($referrer,"vc=");
        	//$vc2 = substr($referrer,$tempInd+3);        	
			
        	if ( empty($vc) || ($vc == $vc2) ) return;
        	else {          		       		
				update_user_meta( $userID, 'verify_email_code', "" ); //delete verfication c
   	  			wp_redirect( add_query_arg( 'login', $vc2 ,$referrer ) ); 
   	  			exit;   	  			
        	}
        }

        if (is_wp_error($user) ) do_action('wp_login_failed', $username);
        

        return;           
}
add_action ('wp_authenticate' , 'check_custom_authentication');

/*****************************AJAX/ANGUALR FUNCTIONS******************/
function get_user_id() {
	if ( is_user_logged_in() ) {
		$current_user = wp_get_current_user();
		echo $current_user->ID;
		exit;
	}	
	echo "not logged in";
	exit;
}
add_action( 'wp_ajax_nopriv_getuserid', 'get_user_id' );
add_action( 'wp_ajax_getuserid', 'get_user_id' );

function get_user_profile() {   

	if( $_GET['action'] == 'getuser' ) {

	    if (is_user_logged_in()) {	    	 

		    global $current_user;
		    get_currentuserinfo(); 

		    $current_user = wp_get_current_user();
			$uid = $current_user->ID;
		    

		    $avtr = get_user_meta( $uid, 'custom_avatar', true );		    
		    $avtr_240 = get_user_meta( $uid, 'custom_avatar_240', true );
		    $lang = get_user_meta( $uid, 'user_lang', true );
		    $country = get_user_meta( $uid, 'user_country', true );
		    $city = get_user_meta( $uid, 'user_city', true );		    
		    $position = addslashes(get_user_meta( $uid, 'subject', true ));		    
		    $about = addslashes(get_user_meta( $uid, 'description', true ));		    		    
		    $timezone = get_user_meta( $uid, 'user_timezone', true );
		    $email_verified = get_user_meta( $uid, 'verify_email_code', true )==""?1:0;

		    $fname = str_replace("'","\'", addslashes($current_user->user_firstname));
		    $lname = str_replace("'","\'", addslashes($current_user->user_lastname));
		    $about = str_replace("'","\'", $about);
		    $position = str_replace("'","\'", $position);


		    
		    $response = '{"firstname":"'.$fname.
		    	'", "lastname":"'.$lname.
		    	'", "email":"'.$current_user->user_email.
		    	'","avatar":"'.$avtr.
		    	'","avatar_240":"'.$avtr_240.
		    	'","lang":"'.$lang.
		    	'","country":"'.$country.
		    	'","city":"'.$city.
		    	'","timezone":"'.$timezone.
		    	'","position":"'.$position.
		    	'","about":"'.$about.
		    	'","email_verified":'.$email_verified.
		    	'}'; 
		    
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
 
	if( $_POST['action'] == 'setuser' && is_user_logged_in()) {
	 	
		$error = '';
		 
		 $current_user = wp_get_current_user();
		 $uid = $current_user->ID;

		 $pswrd = trim( $_POST['password'] );
		 $pswrd2 = trim( $_POST['password2'] );
		 $country = trim($_POST['country']);
		 $city = trim($_POST['city']);
		 $timezone = trim($_POST['timezone']);
		 $lang = trim( $_POST['lang'] );
		 
		if( empty( $uid ) )
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
 
	if( $_POST['action'] == 'setuser2' && is_user_logged_in() ) {
	 	
		$error = '';
		 
		 $current_user = wp_get_current_user();
		 $uid = $current_user->ID;

		 $fname = trim($_POST['firstname']);
		 $lname = trim($_POST['lastname']);
		 $position = trim($_POST['position']);
		 $about = trim($_POST['about']);		 
		 
		if( empty( $uid ) )
		 $error .= '<p class="error">Enter UserID</p>';						 
			
		 
		if( empty( $fname ) )
		 $error .= '<p class="error">Enter First Name</p>';	
		 
		if( empty( $lname ) )
		 $error .= '<p class="error">Enter Last Name</p>';		 
		 
		if( empty( $error ) ){

			$userdata = array( 'ID' => $uid, 'first_name' => $fname, 'last_name' => $lname, 'display_name' => $fname.' '.$lname );
		 
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
		 		update_user_meta( $uid, 'subject', $position );
		 		if (!is_wp_error($status)) update_user_meta( $uid, 'description', $about );

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
	if( $_GET['action'] == 'setuser3' && is_user_logged_in() ) {
		$error = '';
		 
		 $current_user = wp_get_current_user();
		 $uid = $current_user->ID;		 

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

			  $path = pathinfo($status['url']);
			  $imgBaseName = $path['dirname'] . "/";


			  $image_editor1 = wp_get_image_editor($status['file']);
			  $image_editor2 = wp_get_image_editor($status['file']);
			  $image_editor3 = wp_get_image_editor($status['file']);
			  $image_editor4 = wp_get_image_editor($status['file']);
			  $image_editor5 = wp_get_image_editor($status['file']);
			  
			  if(empty($status['error'])){	
				//resize
				//$resized = image_resize($status['file'], 96, 96, $crop = true);	 
				$image_editor1->resize( 60, 60, true );
				$image_editor2->resize( 100, 100, true );				
				$image_editor3->resize( 160, 160, true );				
				$image_editor4->resize( 240, 240, true );				
				$image_editor5->resize( 49, 49, true );				
				$img1 = $image_editor1->save();				
				$img2 = $image_editor2->save();
				$img3 = $image_editor3->save();
				$img4 = $image_editor4->save();
				$img5 = $image_editor5->save();
			
				if(!is_wp_error($resized)) { //resize successful		
					//$uploads = wp_upload_dir();												
					$_POST['resized_url'] = $imgBaseName . $img1["file"];
					$_POST['resized_url_100'] = $imgBaseName . $img2["file"];										
					$_POST['resized_url_160'] = $imgBaseName . $img3["file"];										
					$_POST['resized_url_240'] = $imgBaseName . $img4["file"];										
					$_POST['resized_url_49'] = $imgBaseName . $img5["file"];										
				}
			  }
			  else {
			  	echo( $status['error'] );
			  	exit;
			  }	 
			}
			elseif ($_POST) {
				$_POST['resized_url']='';
				$_POST['resized_url_100']='';
				$_POST['resized_url_160']='';
				$_POST['resized_url_240']='';
				$_POST['resized_url_49']='';
			}


		 	$userdata['resized_url'] = $_POST['resized_url'];		
		 	$userdata['resized_url_100'] = $_POST['resized_url_100'];		
		 	$userdata['resized_url_160'] = $_POST['resized_url_160'];		
		 	$userdata['resized_url_240'] = $_POST['resized_url_240'];		
		 	$userdata['resized_url_49'] = $_POST['resized_url_49'];		
			
			if (!empty($userdata['resized_url'])) update_usermeta($uid, 'custom_avatar', $userdata['resized_url']);
			else $error .= '<p class="error">File not found</p>';	
			if (!empty($userdata['resized_url_100'])) update_usermeta($uid, 'custom_avatar_100', $userdata['resized_url_100']);
			else $error .= '<p class="error">File not found</p>';	
			if (!empty($userdata['resized_url_160'])) update_usermeta($uid, 'custom_avatar_160', $userdata['resized_url_160']);
			else $error .= '<p class="error">File not found</p>';	
			if (!empty($userdata['resized_url_240'])) update_usermeta($uid, 'custom_avatar_240', $userdata['resized_url_240']);
			else $error .= '<p class="error">File not found</p>';	
			if (!empty($userdata['resized_url_49'])) update_usermeta($uid, 'custom_avatar_49', $userdata['resized_url_49']);
			else $error .= '<p class="error">File not found</p>';	

			if( !empty( $error ) ) {			 
						 
				echo $error;			
				exit;
		 
		 	}
		 	else {	 
					$msg = $userdata['resized_url_240'];	 					
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

	$result = $wpdb->get_results( 'SELECT DISTINCT id,country FROM wp_countries ORDER BY country ASC;', OBJECT );

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

function get_country_by_id() {
	$cname =  trim($_GET['cname']);
	$retVal = "";

	if (!empty($cname)) {

		global $wpdb;			
		$result = $wpdb->get_results( "SELECT id FROM wp_countries WHERE country='$cname';", OBJECT );						
		foreach($result as $row) {			
			$retVal  = $row->id;					
		}						
	}
	echo $retVal;;
	exit;
}
add_action( 'wp_ajax_nopriv_getctrbyid', 'get_country_by_id' );
add_action( 'wp_ajax_getctrbyid', 'get_country_by_id' );

function get_cities() {
	$ctry = (int) trim($_GET['ctry']);

	if (!empty($ctry) && is_numeric($ctry)) { 
		global $wpdb;
		$retVal = "[";

		$result = $wpdb->get_results( "SELECT DISTINCT id,city FROM wp_cities WHERE country=$ctry ORDER BY city ASC;", OBJECT );

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
	else echo -1;
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

/*****************************WP EMAILS*****************************/
function sw_password_title() {
	return "Password Reset for Geulah VOD";
}
add_filter ("retrieve_password_title", "sw_password_title");


function sw_retrieve_password_message($message, $key, $user_login, $user_data) {

	$input = filter_input( INPUT_POST, 'user_login', FILTER_SANITIZE_STRING );
    if( is_email( $input ) ) {
        $user = get_user_by( 'email', $input );
    }
    else {
		$user = get_user_by( 'login', sanitize_user( $input ) );
    }

    $user_login = $user->user_login;

    $reset_url = trailingslashit(site_url()) . "registration/?action=rp&key=$key&login=" . rawurlencode($user_login); 

	
	ob_start();

	$sLang = $gsLocaleShort;

	$email_subject = __("Reset Password for Geulah VOD website","swgeula");
	
	$email_body = __("Someone requested that the password be reset for the following account:","swgeula");
	$email_body  .= __(" ");
	$email_body  .=  __("Username:","swgeula");
	$email_body  .=	__($user_login);
	$email_body  .=	__("<br /><br />");
	$email_body  .=	__("If this was a mistake, just ignore this email and nothing will happen.","swgeula");
	$email_body  .=	__("<br /><br />");
	$email_body  .=	__("To reset your password, visit the following address: ","swgeula");
	$email_body  .= __("<a href='".$reset_url."'>". $reset_url ."</a>");

	$email_disclaimer = __("This email was sent to you because you are are registered member of Geulah VOD. To unsubscribe please send an email to <a href='mailto:support@geulahvod.com'>support@geulahvod.com</a>","swgeula");
	

	include("email/email_tmpl.php");	
	
	$message = ob_get_contents();

	ob_end_clean();
  
	return $message;
}
add_filter ("retrieve_password_message", "sw_retrieve_password_message",10, 4);



function sw_wp_mail_content_type() {
	return "text/html";
}
add_filter ("wp_mail_content_type", "sw_wp_mail_content_type");
	
function sw_wp_mail_from() {
	return "noreply@geulahvod.com";
}
add_filter ("wp_mail_from", "sw_wp_mail_from");
	
function sw_wp_mail_from_name() {
	return "Geulah VOD";
}
add_filter ("wp_mail_from_name", "sw_wp_mail_from_name");
/*****************************END WP EMAILS************************/


/*****************************WP_CRON FUNCTIONS******************/

function sendEmailAlert($uid,$lessonID) {	
	
	$arrUsers = array();
	$arrUsers[] = $uid;

	$users = get_users( array('include'=>$arrUsers,'number'=>1) );
	
	foreach ( $users as $user ) {
		$user_email = $user->user_email;
	}	

	$lessonLink = get_permalink($lessonID);

	ob_start();

	$lang = get_user_meta( $user->ID, 'user_lang', true );
	$sLang  = strstr($lang,"_",true);				

	if ($sLang=="he") {
		$email_subject = "התראת שעור מאתר גאולה VOD";
		
		$email_body = 'זוהי התראת שעור. השעור המתוזמן שלך עומד להתחיל בעוד פחות משעה. אנא לחץ על הלינק למטה להתחלת הלימוד:';
		$email_body  .=	"<br /><br />";		
		$email_body .= 	"<a href=\"$lessonLink\">".$lessonLink . "</a><br/><br/>";	
		$email_body .= "תודה רבה" . "<br/><br/>";	
		$email_disclaimer = "הודעה זו נשלחה אליך מכיון שאתה מנוי באתר Geula VOD. להסרה אנא שלח הודעה לכתובת המייל: <a href='mailto:support@geulahvod.com'>support@geulahvod.com</a>";
	}
	else {
		$email_subject = "Lesson Alert from Geulah VOD website";
		
		$email_body = 'This is an alert. Your scheduled lesson is about to begin in less than an hour. Please click on the link below to start learning:';
		$email_body  .=	"<br /><br />";
		$email_body .= 	"<a href=\"$lessonLink\">".$lessonLink . "</a><br/><br/>";	
		$email_body .= "Thank you" . "<br/><br/>";	
		$email_disclaimer = "This email was sent to you because you are are registered member of Geulah VOD. To unsubscribe please send an email to <a href='mailto:support@geulahvod.com'>support@geulahvod.com</a>";
	}


	include("email/email_tmpl.php");	
	
	$message = ob_get_contents();

	ob_end_clean();	
	
	$blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);

	$title = sprintf( __('[%s] Geula Lesson Alert','swgeula'), $blogname );	
	
	$swheaders = 'From: Geulah VOD <noreply@geulahvod.com>' . "\r\n";

	if ( $message && !wp_mail( $user_email, wp_specialchars_decode( $title ), $message, $swheaders ) ) return 0;
	return 1;
}

function sw_send_alerts() {	
	global $wpdb;

	$userIDs = $wpdb->get_results("SELECT DISTINCT user_id FROM wp_sw_schedules ORDER BY user_ID ASC;",ARRAY_A);		

	foreach ($userIDs as $arrUserID) {

		$userID = $arrUserID['user_id'];		

		$results = $wpdb->get_results("SELECT id,sent_alert,schedule_day,schedule_time FROM wp_sw_schedules WHERE user_id = $userID ORDER BY id ASC;",ARRAY_A);						
		
		
		if (count($results)>0) {

			foreach($results as $result) :
				//get user timezone:
				$user_tzone = get_user_meta( $userID, 'user_timezone', true );						

				$date = new DateTime('NOW');
				$date->setTimezone(new DateTimeZone($user_tzone));
				
				$hours = (int)$date->format('H');
				$mins = (int)$date->format('i');

				$offset = get_timezone_offset($user_tzone);
				$offset /= 3600; //change to hours		


				$offset *= -1; //when retreiving day offset should be reversed

				$scheduledHours = (int)substr($result['schedule_time'],0,(int)strpos($result['schedule_time'],":"));
				$scheduledMins = (int)substr($result['schedule_time'],strpos($result['schedule_time'],":")+1);

				$scheduledHours += $offset;
				
				if ($scheduledHours>=24) {
					$scheduledHours -= 24;
					$result['schedule_day'] += 1;
					if ($result['schedule_day']==8) $result['schedule_day']=1;
				}
				elseif ($scheduledHours<0) {
					$scheduledHours += 24;
					$result['schedule_day'] -= 1;
					if ($result['schedule_day']==0) $result['schedule_day']=7;
				}

				if  ( ( ((int)$result['sent_alert']==0) && ($result['schedule_day'] == $date->format('N')) ) || //schedule is for today				
					( ($result['schedule_day'] == $date->format('N')+1) || ($result['schedule_day']==1 && $date->format('N')==7) )  &&  ($scheduledHours==0) && ($hours>=23) && ($mins>=$scheduledMins) ) { //this is a special case where the lesson is scheduled for hour 00 or 00:30 so need to send email at 23:00 the day before										
					

					if ( ($hours==$scheduledHours-1 && $mins>=$scheduledMins) ||  ($hours==$scheduledHours && $mins<$scheduledMins) ) {
						//check if email not sent send email
						$arrNextScheduled = getNextScheduledCat((int)$userID);                                                                      												
						$lessonID = (int)getNextLessonToPlay((int)$arrNextScheduled[0]);

						//echo("sending email to...".$userID.' about lesson id:'.$lessonID);
						if ($userID>0 && $lessonID>0) sendEmailAlert($userID,$lessonID);						

						//change db field to sent
						$wpdb->update('wp_sw_schedules', array('sent_alert' => 1), array( 'id' =>  $result['id']) ); 

					}
				} 
				elseif ( ((int)$result['sent_alert']==1) && ($date->format('N')>$result['schedule_day'] || ($date->format('N')==1 && $result['schedule_day']==7) ) ) {  //day after alert turn sent field to 0

					$wpdb->update('wp_sw_schedules', array('sent_alert' => 0), array( 'id' =>  $result['id']) ); 
				}					
			endforeach;	
		}

	}
}
sw_send_alerts();

add_action( 'send_alerts', 'sw_send_alerts' );

function add_custom_cron_intervals( $schedules ) {
    // $schedules stores all recurrence schedules within WordPress
    $schedules['every_5minutes'] = array(
        'interval'  => 300, 
        'display'   => 'Every 5 Minutes'
    );
 
    // Return our newly added schedule to be merged into the others
    return (array)$schedules; 
}
add_filter( 'cron_schedules', 'add_custom_cron_intervals', 10, 1 );


function send_lesson_alerts() {
   if( !wp_next_scheduled( 'send_alerts' ) ) {
        // Schedule the event
        wp_schedule_event( time(), 'every_5minutes', 'send_alerts' );
   }    
   
}
add_action( 'init', 'send_lesson_alerts'); //send_lesson_alerts

/*****************************END WP_CRON FUNCTIONS******************/

?>