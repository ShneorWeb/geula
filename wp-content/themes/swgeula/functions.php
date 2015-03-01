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
			

      
			)
		);

		


}
add_action( 'init', 'register_theme_menus');

function register_my_menus() {
register_nav_menus(
array(
			
			'right-menu' => _( 'Right Menu' ),

      
			)
);
}
add_action( ‘init’, ‘register_my_menus’ );

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
	add_image_size('category_image', 1371, 0);

?>