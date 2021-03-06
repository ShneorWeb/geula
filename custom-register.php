<?php
ob_start();
/*
Template Name: Custom_Register
*/

/** Make sure that the WordPress bootstrap has run before continuing. */
require( ABSPATH . '/wp-load.php' );


include_once("header.php");


// Redirect to https login if forced to use SSL
if ( force_ssl_admin() && ! is_ssl() ) {
	if ( 0 === strpos($_SERVER['REQUEST_URI'], 'http') ) {
		wp_redirect( set_url_scheme( $_SERVER['REQUEST_URI'], 'https' ) );
		exit();
	} else {
		wp_redirect( 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] );
		exit();
	}
}

/**
 * Output the login page header.
 *
 * @param string   $title    Optional. WordPress Log In Page title to display in <title> element. Default 'Log In'.
 * @param string   $message  Optional. Message to display in header. Default empty.
 * @param WP_Error $wp_error Optional. The error to pass. Default empty.
 */
function login_header( $title = 'Log In', $message = '', $wp_error = '' ) {
	global $error, $interim_login, $action;

	// Don't index any of these forms
	add_action( 'login_head', 'wp_no_robots' );

	if ( wp_is_mobile() )
		//add_action( 'login_head', 'wp_login_viewport_meta' );

	if ( empty($wp_error) )
		$wp_error = new WP_Error();

	// Shake it!
	$shake_error_codes = array( 'empty_password', 'empty_email', 'invalid_email', 'invalidcombo', 'empty_username', 'invalid_username', 'incorrect_password' );
	/**
	 * Filter the error codes array for shaking the login form.
	 *
	 * @since 3.0.0
	 *
	 * @param array $shake_error_codes Error codes that shake the login form.
	 */
	$shake_error_codes = apply_filters( 'shake_error_codes', $shake_error_codes );

	if ( $shake_error_codes && $wp_error->get_error_code() && in_array( $wp_error->get_error_code(), $shake_error_codes ) )
		add_action( 'login_head', 'wp_shake_js', 12 );

	?>
	
	<?php

	unset( $login_header_url, $login_header_title );

	/**
	 * Filter the message to display above the login form.
	 *
	 * @since 2.1.0
	 *
	 * @param string $message Login message text.
	 */
	$message = apply_filters( 'login_message', $message );
	if ( !empty( $message ) )
		echo $message . "\n";

	// In case a plugin uses $error rather than the $wp_errors object
	if ( !empty( $error ) ) {
		$wp_error->add('error', $error);
		unset($error);
	}

	if ( $wp_error->get_error_code() ) {
		$errors = '';
		$messages = '';
		foreach ( $wp_error->get_error_codes() as $code ) {
			$severity = $wp_error->get_error_data( $code );
			foreach ( $wp_error->get_error_messages( $code ) as $error_message ) {

				//take out username error message because username is taken from email:
				if (strstr($error_message,"Please enter a username")) continue;

				if ( 'message' == $severity )
					$messages .= '	' . $error_message . "<br />\n";
				else
					$errors .= '	' . $error_message . "<br />\n";
			}
		}
		if ( ! empty( $errors ) ) {
			/**
			 * Filter the error messages displayed above the login form.
			 *
			 * @since 2.1.0
			 *
			 * @param string $errors Login error message.
			 */
			echo '<div class="login-error-msg">' . apply_filters( 'login_errors', $errors ) . "</div>\n";
		}
		if ( ! empty( $messages ) ) {
			/**
			 * Filter instructional messages displayed above the login form.
			 *
			 * @since 2.5.0
			 *
			 * @param string $messages Login messages.
			 */
			echo '<p class="message">' . apply_filters( 'login_messages', $messages ) . "</p>\n";
		}		
	}	
} // End of login_header()

/**
 * Outputs the footer for the login page.
 *
 * @param string $input_id Which input to auto-focus
 */
function login_footer($input_id = '') {
	global $interim_login;

	// Don't allow interim logins to navigate away from the page.
	 ?>

	

	<?php if ( !empty($input_id) ) : ?>
	<script type="text/javascript">
	try{document.getElementById('<?php echo $input_id; ?>').focus();}catch(e){}
	if(typeof wpOnload=='function')wpOnload();
	</script>
	<?php endif; ?>

	<?php
	/**
	 * Fires in the login page footer.
	 *
	 * @since 3.1.0
	 */
	do_action( 'login_footer' ); ?>
	<div class="clear"></div>	
	<?php
}

function wp_shake_js() {
	if ( wp_is_mobile() )
		return;
?>
<script type="text/javascript">
addLoadEvent = function(func){if(typeof jQuery!="undefined")jQuery(document).ready(func);else if(typeof wpOnload!='function'){wpOnload=func;}else{var oldonload=wpOnload;wpOnload=function(){oldonload();func();}}};
function s(id,pos){g(id).left=pos+'px';}
function g(id){return document.getElementById(id).style;}
function shake(id,a,d){c=a.shift();s(id,c);if(a.length>0){setTimeout(function(){shake(id,a,d);},d);}else{try{g(id).position='static';wp_attempt_focus();}catch(e){}}}
addLoadEvent(function(){ var p=new Array(15,30,15,0,-15,-30,-15,0);p=p.concat(p.concat(p));var i=document.forms[0].id;g(i).position='relative';shake(i,p,20);});
</script>
<?php
}

function wp_login_viewport_meta() {
	?>
	<meta name="viewport" content="width=device-width" />
	<?php
}

/**
 * Handles sending password retrieval email to user.
 *
 * @uses $wpdb WordPress Database object
 *
 * @return bool|WP_Error True: when finish. WP_Error on error
 */
function retrieve_password() {
	global $wpdb, $wp_hasher;

	$errors = new WP_Error();

	if ( empty( $_POST['user_login'] ) ) {
		$errors->add('empty_username', __('<strong>ERROR</strong>: Enter a username or e-mail address.'));
	} else if ( strpos( $_POST['user_login'], '@' ) ) {
		$user_data = get_user_by( 'email', trim( $_POST['user_login'] ) );
		if ( empty( $user_data ) )
			$errors->add('invalid_email', __('<strong>ERROR</strong>: There is no user registered with that email address.'));
	} else {
		$login = trim($_POST['user_login']);
		$user_data = get_user_by('login', $login);
	}

	/**
	 * Fires before errors are returned from a password reset request.
	 *
	 * @since 2.1.0
	 */
	do_action( 'lostpassword_post' );

	if ( $errors->get_error_code() )
		return $errors;

	if ( !$user_data ) {
		$errors->add('invalidcombo', __('<strong>ERROR</strong>: Invalid username or e-mail.'));
		return $errors;
	}

	// Redefining user_login ensures we return the right case in the email.
	$user_login = $user_data->user_login;
	$user_email = $user_data->user_email;

	/**
	 * Fires before a new password is retrieved.
	 *
	 * @since 1.5.0
	 * @deprecated 1.5.1 Misspelled. Use 'retrieve_password' hook instead.
	 *
	 * @param string $user_login The user login name.
	 */
	do_action( 'retreive_password', $user_login );

	/**
	 * Fires before a new password is retrieved.
	 *
	 * @since 1.5.1
	 *
	 * @param string $user_login The user login name.
	 */
	do_action( 'retrieve_password', $user_login );

	/**
	 * Filter whether to allow a password to be reset.
	 *
	 * @since 2.7.0
	 *
	 * @param bool true           Whether to allow the password to be reset. Default true.
	 * @param int  $user_data->ID The ID of the user attempting to reset a password.
	 */
	$allow = apply_filters( 'allow_password_reset', true, $user_data->ID );

	if ( ! $allow )
		return new WP_Error('no_password_reset', __('Password reset is not allowed for this user'));
	else if ( is_wp_error($allow) )
		return $allow;

	// Generate something random for a password reset key.
	$key = wp_generate_password( 20, false );

	/**
	 * Fires when a password reset key is generated.
	 *
	 * @since 2.5.0
	 *
	 * @param string $user_login The username for the user.
	 * @param string $key        The generated password reset key.
	 */
	do_action( 'retrieve_password_key', $user_login, $key );

	// Now insert the key, hashed, into the DB.
	if ( empty( $wp_hasher ) ) {
		require_once ABSPATH . WPINC . '/class-phpass.php';
		$wp_hasher = new PasswordHash( 8, true );
	}	
	$hashed = $wp_hasher->HashPassword( $key );
	$wpdb->update( $wpdb->users, array( 'user_activation_key' => $hashed ), array( 'user_login' => $user_login ) );

	$message = __('Someone requested that the password be reset for the following account:') . "\r\n\r\n";
	$message .= network_home_url( '/' ) . "\r\n\r\n";
	$message .= sprintf(__('Username: %s'), $user_login) . "\r\n\r\n";
	$message .= __('If this was a mistake, just ignore this email and nothing will happen.') . "\r\n\r\n";
	$message .= __('To reset your password, visit the following address:') . "\r\n\r\n";
	$message .= '<' . network_site_url("registration/?action=rp&key=$key&login=" . rawurlencode($user_login), 'login') . ">\r\n";

	if ( is_multisite() )
		$blogname = $GLOBALS['current_site']->site_name;
	else
		/*
		 * The blogname option is escaped with esc_html on the way into the database
		 * in sanitize_option we want to reverse this for the plain text arena of emails.
		 */
		$blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);

	$title = sprintf( __('[%s] Password Reset'), $blogname );

	/**
	 * Filter the subject of the password reset email.
	 *
	 * @since 2.8.0
	 *
	 * @param string $title Default email title.
	 */
	$title = apply_filters( 'retrieve_password_title', $title );
	/**
	 * Filter the message body of the password reset mail.
	 *
	 * @since 2.8.0
	 *
	 * @param string $message Default mail message.
	 * @param string $key     The activation key.
	 */
	$message = apply_filters( 'retrieve_password_message', $message, $key );

	$swheaders = 'From: Geula Lessons Website <noreply@geulahvod.com>' . "\r\n";

	if ( $message && !wp_mail( $user_email, wp_specialchars_decode( $title ), $message, $swheaders ) )
		wp_die( __('The e-mail could not be sent.') . "<br />\n" . __('Possible reason: your host may have disabled the mail() function.') );

	return true;
}

//
// Main
//
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'login';
$errors = new WP_Error();

if ( isset($_GET['key']) )
	$action = 'resetpass';

// validate action so as to default to the login screen
if ( !in_array( $action, array( 'postpass', 'logout', 'lostpassword', 'retrievepassword', 'resetpass', 'rp', 'register', 'login' ), true ) && false === has_filter( 'login_form_' . $action ) )
	$action = 'login';

nocache_headers();

//header('Content-Type: '.get_bloginfo('html_type').'; charset='.get_bloginfo('charset'));

if ( defined( 'RELOCATE' ) && RELOCATE ) { // Move flag is set
	if ( isset( $_SERVER['PATH_INFO'] ) && ($_SERVER['PATH_INFO'] != $_SERVER['PHP_SELF']) )
		$_SERVER['PHP_SELF'] = str_replace( $_SERVER['PATH_INFO'], '', $_SERVER['PHP_SELF'] );

	$url = dirname( set_url_scheme( 'http://' .  $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] ) );
	if ( $url != get_option( 'siteurl' ) )
		update_option( 'siteurl', $url );
}

//Set a cookie now to see if they are supported by the browser.
$secure = ( 'https' === parse_url( site_url(), PHP_URL_SCHEME ) && 'https' === parse_url( home_url(), PHP_URL_SCHEME ) );
/*setcookie( TEST_COOKIE, 'WP Cookie check', 0, COOKIEPATH, COOKIE_DOMAIN, $secure );
if ( SITECOOKIEPATH != COOKIEPATH )
	setcookie( TEST_COOKIE, 'WP Cookie check', 0, SITECOOKIEPATH, COOKIE_DOMAIN, $secure );*/

/**
 * Fires when the login form is initialized.
 *
 * @since 3.2.0
 */

 do_action( 'login_init' ); 
/**
 * Fires before a specified login form action.
 *
 * The dynamic portion of the hook name, $action, refers to the action
 * that brought the visitor to the login form. Actions include 'postpass',
 * 'logout', 'lostpassword', etc.
 *
 * @since 2.8.0
 */
do_action( 'login_form_' . $action ); 

$http_post = ('POST' == $_SERVER['REQUEST_METHOD']);
$interim_login = isset($_REQUEST['interim-login']);

switch ($action) {

case 'postpass' :
	require_once ABSPATH . WPINC . '/class-phpass.php';
	$hasher = new PasswordHash( 8, true );

	/**
	 * Filter the life span of the post password cookie.
	 *
	 * By default, the cookie expires 10 days from creation. To turn this
	 * into a session cookie, return 0.
	 *
	 * @since 3.7.0
	 *
	 * @param int $expires The expiry time, as passed to setcookie().
	 */
	$expire = apply_filters( 'post_password_expires', time() + 10 * DAY_IN_SECONDS );
	$secure = ( 'https' === parse_url( home_url(), PHP_URL_SCHEME ) );
	setcookie( 'wp-postpass_' . COOKIEHASH, $hasher->HashPassword( wp_unslash( $_POST['post_password'] ) ), $expire, COOKIEPATH, COOKIE_DOMAIN, $secure );

	wp_safe_redirect( wp_get_referer() );
	exit();

case 'logout' :
	check_admin_referer('log-out');
	wp_logout();

	$redirect_to = !empty( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : 'wp-login.php?loggedout=true';
	wp_safe_redirect( $redirect_to );
	exit();

case 'lostpassword' :
case 'retrievepassword' :
?>
<?php

	if ( $http_post ) {
		$errors = retrieve_password();
		if ( !is_wp_error($errors) ) {
			$redirect_to = !empty( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : network_site_url('/my-account/sign-in/?checkemail=confirm');
			wp_safe_redirect( $redirect_to );
			exit();
		}
	}

	if ( isset( $_GET['error'] ) ) {
		if ( 'invalidkey' == $_GET['error'] )
			$errors->add( 'invalidkey', __( 'Sorry, that key does not appear to be valid.' ) );
		elseif ( 'expiredkey' == $_GET['error'] )
			$errors->add( 'expiredkey', __( 'Sorry, that key has expired. Please try again.' ) );
	}

	$lostpassword_redirect = ! empty( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : '';
	/**
	 * Filter the URL redirected to after submitting the lostpassword/retrievepassword form.
	 *
	 * @since 3.0.0
	 *
	 * @param string $lostpassword_redirect The redirect destination URL.
	 */
	$redirect_to = apply_filters( 'lostpassword_redirect', $lostpassword_redirect );

	/**
	 * Fires before the lost password form.
	 *
	 * @since 1.5.1
	 */
	do_action( 'lost_password' );

	login_header(__('Lost Password'), '<p class="message">' . __('Please enter your username or email address. You will receive a link to create a new password via email.') . '</p>', $errors);

	$user_login = isset($_POST['user_login']) ? wp_unslash($_POST['user_login']) : '';

?>
<div class="col-sm-5 col-sm-offset-4"> 
	<div class="panel" style="text-align:center;">
    	<div class="div-login">
<form name="lostpasswordform" id="lostpasswordform" action="<?php echo esc_url( network_site_url( 'registration/?action=lostpassword', 'login_post' ) ); ?>" method="post">
	<p>
		<label for="user_login" class="control-label" ><?php _e('Username or E-mail:') ?><br />
		<input type="text" name="user_login" id="user_login" class="form-control" value="<?php echo esc_attr($user_login); ?>" size="20" /></label>
	</p>
	<?php
	/**
	 * Fires inside the lostpassword <form> tags, before the hidden fields.
	 *
	 * @since 2.1.0
	 */
	do_action( 'lostpassword_form' ); ?>
	<input type="hidden" name="redirect_to" value="<?php echo esc_attr( $redirect_to ); ?>" />
	<p class="submit"><input type="submit" name="wp-submit" id="wp-submit" class="btn btn-success" value="<?php esc_attr_e('Get New Password'); ?>" /></p>
</form>

<p id="nav">
<a href="<?php echo esc_url( wp_login_url() ); ?>"><?php _e('Log in') ?></a>
<?php
if ( get_option( 'users_can_register' ) ) :
	$registration_url = sprintf( '<a href="%s">%s</a>', esc_url( wp_registration_url() ), __( 'Register' ) );

	/** This filter is documented in wp-includes/general-template.php */
	echo ' | ' . apply_filters( 'register', $registration_url );
endif;
?>
</p>

		</div>
	</div>
</div>

<?php
login_footer('user_login');
break;


case 'resetpass' :
case 'rp' : 
?>
<?php
	list( $rp_path ) = explode( '?', wp_unslash( $_SERVER['REQUEST_URI'] ) );
	$rp_cookie = 'wp-resetpass-' . COOKIEHASH;		
	if ( isset( $_GET['key'] ) ) {
		$value = sprintf( '%s:%s', wp_unslash( $_GET['login'] ), wp_unslash( $_GET['key'] ) );				
		setcookie( $rp_cookie, $value, 0, $rp_path, COOKIE_DOMAIN, is_ssl(), true );												
		ob_end_flush();		
		wp_safe_redirect( remove_query_arg( array( 'key', 'login' ) ) );
		exit;
	}		
	
	if ( isset( $_COOKIE[ $rp_cookie ] ) && 0 < strpos( $_COOKIE[ $rp_cookie ], ':' ) ) {
		list( $rp_login, $rp_key ) = explode( ':', wp_unslash( $_COOKIE[ $rp_cookie ] ), 2 );
		$user = check_password_reset_key( $rp_key, $rp_login );
		if ( isset( $_POST['pass1'] ) && ! hash_equals( $rp_key, $_POST['rp_key'] ) ) {
			$user = false;
		}
	} 
	else {
		$user = false;
	}	

	if ( ! $user || is_wp_error( $user ) ) {
		setcookie( $rp_cookie, ' ', time() - YEAR_IN_SECONDS, $rp_path, COOKIE_DOMAIN, is_ssl(), true );
		if ( $user && $user->get_error_code() === 'expired_key' )
			wp_redirect( site_url( 'my-account/sign-in/?action=expiredkey' ) );
		else 
			wp_redirect( site_url( 'my-account/sign-in/?action=invalidkey' ) );				
		exit;
	}

	$errors = new WP_Error();

	if ( isset($_POST['pass1']) && $_POST['pass1'] != $_POST['pass2'] )
		$errors->add( 'password_reset_mismatch', __( 'The passwords do not match.' ) );

	/**
	 * Fires before the password reset procedure is validated.
	 *
	 * @since 3.5.0
	 *
	 * @param object           $errors WP Error object.
	 * @param WP_User|WP_Error $user   WP_User object if the login and reset key match. WP_Error object otherwise.
	 */
	do_action( 'validate_password_reset', $errors, $user );

	if ( ( ! $errors->get_error_code() ) && isset( $_POST['pass1'] ) && !empty( $_POST['pass1'] ) ) {
		reset_password($user, $_POST['pass1']);
		setcookie( $rp_cookie, ' ', time() - YEAR_IN_SECONDS, $rp_path, COOKIE_DOMAIN, is_ssl(), true );
		//login_header( __( 'Password Reset' ), '<p class="message reset-pass">' . __( 'Your password has been reset.' ) . ' <a href="' . esc_url( wp_login_url() ) . '">' . __( 'Log in' ) . '</a></p>' );
		//login_footer();
		wp_redirect( site_url( 'my-account/sign-in/?action=pcsignin' ) );				
		exit;
	}

	wp_enqueue_script('utils');
	wp_enqueue_script('user-profile');

	login_header(__('Reset Password'), '<p class="message reset-pass">' . __('Enter your new password below.') . '</p>', $errors );
	ob_end_flush();

?>
<div class="col-sm-5 col-sm-offset-4"> 
	<div class="panel" style="text-align:center;">
    	<div class="div-login">
<form name="resetpassform" id="resetpassform" action="<?php echo esc_url( network_site_url( 'registration/?action=resetpass', 'login_post' ) ); ?>" method="post" autocomplete="off">
	<input type="hidden" id="user_login" value="<?php echo esc_attr( $rp_login ); ?>" autocomplete="off" />

	<p>
		<label for="pass1"><?php _e('New password') ?><br />
		<input type="password" name="pass1" id="pass1" class="form-control" value="" autocomplete="off" /></label>
	</p>
	<p>
		<label for="pass2"><?php _e('Confirm new password') ?><br />
		<input type="password" name="pass2" id="pass2" class="form-control" value="" autocomplete="off" /></label>
	</p>

	<div id="pass-strength-result" class="hide-if-no-js"><?php _e('Strength indicator'); ?></div>
	<p class="description indicator-hint"><?php _e('Hint: The password should be at least seven characters long. To make it stronger, use upper and lower case letters, numbers, and symbols like ! " ? $ % ^ &amp; ).'); ?></p>

	<br class="clear" />

	<?php
	/**
	 * Fires following the 'Strength indicator' meter in the user password reset form.
	 *
	 * @since 3.9.0
	 *
	 * @param WP_User $user User object of the user whose password is being reset.
	 */
	do_action( 'resetpass_form', $user );
	?>
	<input type="hidden" name="rp_key" value="<?php echo esc_attr( $rp_key ); ?>" />
	<p class="submit"><input type="submit" name="wp-submit" id="wp-submit" class="btn btn-success" value="<?php esc_attr_e('Reset Password'); ?>" /></p>
</form>
		</div>
	<p id="nav">
<a href="<?php echo esc_url( wp_login_url() ); ?>"><?php _e( 'Log in' ); ?></a>		
<?php
if ( get_option( 'users_can_register' ) ) :
	$registration_url = sprintf( '<a href="%s">%s</a>', esc_url( wp_registration_url() ), __( 'Register' ) );

	/** This filter is documented in wp-includes/general-template.php */
	echo ' | ' . apply_filters( 'register', $registration_url );
endif;
?>
</p>

</div>
</div>	
<?php
login_footer('user_pass');
break;

case 'register' :
default:
	if ( is_multisite() ) {
		/**
		 * Filter the Multisite sign up URL.
		 *
		 * @since 3.0.0
		 *
		 * @param string $sign_up_url The sign up URL.
		 */
		wp_redirect( apply_filters( 'wp_signup_location', network_site_url( 'wp-signup.php' ) ) );
		exit;
	}

	if ( !get_option('users_can_register') ) {
		wp_redirect( site_url('wp-login.php?registration=disabled') );
		exit();
	}

	$user_login = '';
	$user_email = '';
	if ( $http_post ) {
		$user_login = $_POST['user_login'];
		$user_email = $_POST['user_email'];
		$first_name = $_POST['first_name'];
		$last_name = $_POST['last_name'];
		$user_password = $_POST['user_password'];

		if (!is_email($user_email)) $error1 = new WP_Error( 'email_not_valid', __( "This is not a valid email address", "swgeula" ) );		
		
		if ( !is_wp_error($error1) ) {
			//$random_password = wp_generate_password( $length=8, $include_standard_special_chars=false );
			$errors = wp_create_user($user_login,$user_password,$user_email); 
			if ( !is_wp_error($errors) ) {

				$userdata = array( 'ID' => $errors, 'first_name' => $first_name, 'last_name' => $last_name );		 
				$status = wp_update_user( $userdata );			 			

				if( !is_wp_error($status) ){
					//now add verification code:
					$vccode = md5("swgeula".$errors."vc24");
					update_user_meta( $errors, 'verify_email_code', $vccode );

					wp_new_user_notification( $errors, $user_password ); 

					$redirect_to = !empty( $_POST['redirect_to'] ) ? $_POST['redirect_to'] : site_url().'/my-account/sign-in/?checkemail=registered';
					//wp_safe_redirect( $redirect_to );
					?>
					<script>
					window.location.href = '<?php echo home_url(); ?>/my-account/sign-in/?checkemail=registered';
					</script>
					<?php
					exit();
				}
			}
		}		
	}

	$registration_redirect = ! empty( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : '';
	/**
	 * Filter the registration redirect URL.
	 *
	 * @since 3.0.0
	 *
	 * @param string $registration_redirect The redirect destination URL.
	 */	
?>

<div class="logAndReg_cont"> 
	<div class="panel" style="text-align:center;">
    	<div class="div-login">   		

    		<script>
    		function regSetFields(f)  {
    			f.user_login.value=f.user_email.value;
    			var arrName = f.full_name.value.split(" ");    			    			
    			f.first_name.value = arrName[0];
    			if ( arrName.length>1 ) f.last_name.value = arrName[1];
    			return true;

    		}
    		</script>

    		<h1><?php _e("Creating a new account","swgeulatr");?></h1>
    		<h2><?php _e("enter your full name and email address","swgeulatr");?></h2>
    		<?php
    		if (is_wp_error($error1)) {
    		?>
    		<div class="login-error-msg"><?php echo $error1->get_error_message() ?></div>
    		<?php } ?>

    		<?php
    			//$redirect_to = apply_filters( 'registration_redirect', $registration_redirect );
				login_header(__('Registration Form'), '', $errors);
			?>

			<form name="registerform" id="registerform" action="<?php echo esc_url( site_url('/registration/', 'login_post') ); ?>" method="post" novalidate="novalidate" onsubmit="return regSetFields(this)">				
					<input type="hidden" name="user_login" id="user_login" value="" />				
					<input type="hidden" name="first_name" id="first_name" value="" />				
					<input type="hidden" name="last_name" id="last_name" value="" />				
				<p>					
					<input type="text" class="form-control" name="full_name" id="full_name" placeholder="<?php _e('Name','swgeulatr'); ?>" value="<?php echo trim(esc_attr( wp_unslash( $first_name ) ) . ' ' . esc_attr( wp_unslash( $last_name )) ); ?>" />
				</p>
				<p>					
					<input type="email" class="form-control" name="user_email" id="user_email" placeholder="<?php _e('E-mail','swgeulatr') ?>" value="<?php echo esc_attr( wp_unslash( $user_email ) ); ?>" />
				</p>
				<?php
				/**
				 * Fires following the 'E-mail' field in the user registration form.
				 *
				 * @since 2.1.0
				 */
				do_action( 'register_form' );
				?>
				<p>					
					<input type="password" class="form-control" name="user_password" id="user_password" placeholder="<?php _e('Password','swgeulatr') ?>" value="" />
				</p>
				<input type="hidden" name="redirect_to" value="<?php echo esc_attr( $redirect_to ); ?>" />
				<p class="submit"><input type="submit" name="wp-submit" id="wp-submit" class="btn btn-success" value="<?php esc_attr_e('Register','swgeulatr'); ?>" /></p>
			</form>

			<hr/>

		    <h2><?php _e("Or register with your Google account", "swgeulatr");?></h2>	    
		    
			
		    <span id="signinButton">		    	
		      <span
		        class="g-signin"
		        data-callback="signinCallback"
		        data-clientid="1071363229202-e8nga4duksuc3vldrpm3guuikc9i82ae.apps.googleusercontent.com"
		        data-cookiepolicy="single_host_origin"
		        data-requestvisibleactions="http://schema.org/AddAction"
		        data-scope="https://www.googleapis.com/auth/plus.login"
		        data-width="wide"
		        data-height="tall"
		        >
		      </span>
		    </span>
		   					
		</div>		    
	</div>


	<div id="login-bottom-text"><span><?php echo _e("Already have an account? ","swgeulatr"); ?></span> <span><a href="<?php echo esc_url( site_url() ."/my-account/sign-in/" ); ?>"><?php echo _e("Enter with your existing account","swgeulatr"); ?></a></span></div>
		
</div><div class="col-sm-3"></div>

<?php
login_footer('user_login');
break;

} // end action switch
