<?php

function my_scripts() {	

	wp_enqueue_style( 'swgeula_style', get_template_directory_uri() . '/style.css');

	wp_enqueue_script(
		'googlebutton',
		'https://apis.google.com/js/client:platform.js?defer&async'
	);

	
	wp_enqueue_script(
		'angularjs',
		get_stylesheet_directory_uri() . '/angular/angular.min.js'
	);

	wp_enqueue_script(
		'angularjs-route',
		get_stylesheet_directory_uri() . '/angular/angular-route.min.js'
	);
	wp_enqueue_script(
		'my-scripts',
		get_stylesheet_directory_uri() . '/js/scripts.js',
		array( 'angularjs', 'angularjs-route' )
	);

	wp_localize_script(
		'my-scripts',
		'myLocalized',
		array(
			'partials' => trailingslashit( get_template_directory_uri() ) . 'partials/'
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

function mb_basename($file) {
	return end(explode('/',$file));
}
function process_post(){	
 	if(count($_FILES)>0 && isset($_FILES["user_avatar"])){
		
	  // we need this for the wp_handle_upload function
	  require_once ABSPATH.'wp-admin/includes/file.php';	
	
	  // just be aware that GIFs are annoying as fuck
	  $allowed_image_types = array(
		'jpg|jpeg|jpe' => 'image/jpeg',
		'png'          => 'image/png',
		'gif'          => 'image/gif',
	  );	
	  
	  $status = wp_handle_upload($_FILES['user_avatar'], array('mimes' => $allowed_image_types, 'test_form' => FALSE));	    	  

	  if(empty($status['error'])){	
		//resize		
		$resized = image_resize($status['file'], 200, 200, $crop = true);	 
	
		if(!is_wp_error($resized)) { //resize successful		
			$uploads = wp_upload_dir();					
			$_POST['resized_url'] = $uploads['url'].'/'.mb_basename($resized); //resized_url will be used in register_extra_fields function							
		}
	  }	 
	}
	elseif ($_POST) $_POST['resized_url']='';
}
add_action('init', 'process_post');


function register_extra_fields($user_id, $password="", $meta=array())  {

	$userdata = array();
	
	$userdata['ID'] = $user_id;
	//Enter first/last name into DB
	$userdata['first_name'] = $_POST['first_name'];
	$userdata['last_name'] = $_POST['last_name'];
	$userdata['display_name'] = mb_substr($_POST['user_neshei_nick'],0);
	$userdata['user_pass'] = $_POST['pass1'];
	$userdata['resized_url'] = $_POST['resized_url'];
	$userdata['show_admin_bar_front'] = false;	
	$userdata['wp_user_level'] = 'subscriber';				
	wp_update_user($userdata);
	
	//custom meta data:
	$userdata['user_avatar'] = $_POST['user_avatar'];	
	
	//update_usermeta($user_id, 'display_name',$userdata['display_name']);
	if (!empty($userdata['resized_url'])) update_usermeta($user_id, 'custom_avatar', $userdata['resized_url']);
}
add_action('user_register', 'register_extra_fields');


function custom_avatars($avatar, $id_or_email, $size){	  	
  $current_id=-1; 
  $def_avatar=get_bloginfo('template_url').'/images/user.png';
  if (is_numeric($id_or_email)) $current_id=$id_or_email;
  elseif (is_string($id_or_email) && is_email($id_or_email)) {
	  	$current_user = get_user_by('email', $id_or_email);
		$current_id=$current_user->ID;
  }
  elseif(is_user_logged_in()) {
	  $current_user = wp_get_current_user(); 
	  $current_id=$current_user->ID;
  }

  if ($current_id>0) {
    $image_url = get_user_meta($current_id, 'custom_avatar', true);	
	if (empty($image_url)) $image_url=$def_avatar;
    else return '<img src="'.$image_url.'" class="avatar photo" width="'.$size.'" height="'.$size.'" alt="'.(is_object($current_user)?$current_user->display_name:'') .'" />';
  }
  return '<img src="'.$def_avatar.'" class="avatar photo" width="'.$size.'" height="'.$size.'"  />';
}
add_filter('get_avatar', 'custom_avatars', 10, 3);

function get_comment_avatar($uid, $size){	 	
    $image_url = get_user_meta($uid, 'custom_avatar', true);
	if (empty($image_url)) $image_url=get_bloginfo('template_url').'/images/user.png';
    if($user_avatar !== false) return '<img src="'.$image_url.'" class="avatar photo" width="'.$size.'" height="'.$size.'" alt="'.$uid->display_name .'" />';
	return $avatar;  
}
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



?>