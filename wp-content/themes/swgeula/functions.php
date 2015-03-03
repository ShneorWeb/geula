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
		get_stylesheet_directory_uri() . '/angular/angular.country-select.min.js	',
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
		'my-scripts',
		get_stylesheet_directory_uri() . '/js/angular_main.js',
		array( 'angularjs', 'angularjs-route' )
	);		

	wp_localize_script(
		'my-scripts',
		'myLocalized',
		array(
			'theme_dir' => trailingslashit( get_template_directory_uri() ) 
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


/*
function swgeula_register_form() {

    	$first_name = ( ! empty( $_POST['first_name'] ) ) ? trim( $_POST['first_name'] ) : '';
        
        ?>
        <p>
            <label for="first_name"><?php _e( 'First Name', 'mydomain' ) ?><br />
                <input type="text" name="first_name" id="first_name" placeholder="First Name" value="<?php echo esc_attr( wp_unslash( $first_name ) ); ?>" /></label>
        </p>
        <?php

        $last_name = ( ! empty( $_POST['last_name'] ) ) ? trim( $_POST['last_name'] ) : '';
        
        ?>
        <p>
            <label for="last_name"><?php _e( 'Last Name', 'mydomain' ) ?><br />
                <input type="text" name="first_name" id="first_name" placeholder="Last Name" value="<?php echo esc_attr( wp_unslash( $last_name ) ); ?>" /></label>
        </p>
        <?php
}
add_action( 'register_form', 'swgeula_register_form' );

//2. Add validation. In this case, we make sure first_name is required.
function swgeula_registration_errors( $errors, $sanitized_user_login, $user_email ) {
        
        if ( empty( $_POST['first_name'] ) || ! empty( $_POST['first_name'] ) && trim( $_POST['first_name'] ) == '' ) {
            $errors->add( 'first_name_error', __( '<strong>ERROR</strong>: You must include a first name.', 'mydomain' ) );
        }

        return $errors;
}
add_filter( 'registration_errors', 'swgeula_registration_errors', 10, 3 );

//3. Finally, save our extra registration user meta.
function swgeula_user_register( $user_id ) {
        if ( ! empty( $_POST['first_name'] ) ) {
            update_user_meta( $user_id, 'first_name', trim( $_POST['first_name'] ) );
        }
}
add_action( 'user_register', 'swgeula_user_register' );
*/
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
    if (is_user_logged_in()) {
	    global $current_user;
	    get_currentuserinfo(); 
	    
	    $response = '{"firstName":"'.$current_user->user_firstname.'", "lastName":"'.$current_user->user_lastname.'", "email":"'.$current_user->user_email.'"}'; 
	    
	    header( "Content-Type: application/json" );    
	    echo $response; 
	}
	else {
		$error .= 'No Logged IN';
		echo $error;
	}
    
    exit;
}
add_action( 'wp_ajax_nopriv_getuser', 'get_user_profile' );
add_action( 'wp_ajax_getuser', 'get_user_profile' );

function set_user_profile(){
 
	if( $_POST['action'] == 'setuser' ) {
	 	
		$error = '';
		 
		 $uid = trim( $_POST['uid'] );
		 //$email = trim( $_POST['mail_id'] );
		 //$fname = trim( $_POST['firname'] );
		 //$lname = trim( $_POST['lasname'] );
		 $pswrd = $_POST['password'];
		 
		if( empty( $_POST['uid'] ) )
		 $error .= '<p class="error">Enter UserID</p>';
		
		// if( empty( $_POST['mail_id'] ) )	
		 //$error .= '<p class="error">Enter Email Id</p>';
		 //elseif( !filter_var($email, FILTER_VALIDATE_EMAIL) )
		 //$error .= '<p class="error">Enter Valid Email</p>';
		 
		if( empty( $_POST['password'] ) )
		 $error .= '<p class="error">Password should not be blank</p>';


		//wp_check_password( $password, $hash) 
		 
		/*if( empty( $_POST['firname'] ) )
		 $error .= '<p class="error">Enter First Name</p>';
		 elseif( !preg_match("/^[a-zA-Z'-]+$/",$fname) )
		 $error .= '<p class="error">Enter Valid First Name</p>';
		 
		if( empty( $_POST['lasname'] ) )
		 $error .= '<p class="error">Enter Last Name</p>';
		 elseif( !preg_match("/^[a-zA-Z'-]+$/",$lname) )
		 $error .= '<p class="error">Enter Valid Last Name</p>';*/
		 
		if( empty( $error ) ){

			$userdata = array( 'ID' => $uid, 'user_pass' => $pswrd );
		 
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
				$msg = '<p class="success">Registration Successful</p>';	 
		 		echo $msg;
		 		exit;
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
add_action( 'wp_ajax_nopriv_setuser', 'set_user_profile' );
add_action( 'wp_ajax_setuser', 'set_user_profile' );
/*****************************END AJAX/ANGUALR FUNCTIONS******************/

?>