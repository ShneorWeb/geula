<?php

function my_scripts() {

	wp_enqueue_script(
		'jquery',
		'http://code.jquery.com/jquery-1.11.2.min.js'
	);
	wp_enqueue_script(
		'jquery',
		'http://code.jquery.com/jquery-migrate-1.2.1.min.js'
	);

	wp_enqueue_style( 'swgeula_style', get_template_directory_uri() . '/style.css');

	
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


?>