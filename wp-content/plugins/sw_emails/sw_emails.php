<?php
/*
Plugin Name: SW Emails
Plugin URI: http://www.shneorweb.com
Description: Use posts to edit wp_new_user_notification functions's content 
Version: 1.0
Author: ShneorWeb
*/

if (!function_exists('wp_new_user_notification')) : function wp_new_user_notification($user_id, $plaintext_pass) {	

	$user = new WP_User($user_id);

	$user_login = stripslashes($user->user_login);
	$user_email = stripslashes($user->user_email);
	$first_name = stripslashes($user->first_name);
	$last_name = stripslashes($user->last_name);
	
	$the_slug = (ICL_LANGUAGE_CODE=="he")?'email_newreg':'email_newreg_en';
	$args = array(
	  'name'        => $the_slug,
	  'post_type'   => 'post',
	  'post_status' => 'draft',
	  'numberposts' => 1
	);
	$my_posts = get_posts($args);	
	if( $my_posts ) :
	  	
	  	$email_subject = $my_posts[0]->post_title;
		$email_body = html_entity_decode($my_posts[0]->post_content);
		//replace here all shortcodes:		
		$patterns = array();
		$patterns[0] = '/\[user_login\]/';
		$patterns[1] = '/\[user_password\]/';
		$patterns[2] = '/\[login_url\]/';
		$replacements = array('','','');
		$replacements[0] = $user_login;
		$replacements[1] = $plaintext_pass;
		$replacements[2] = network_site_url('my-account/sign-in/?vc='.md5('swgeula'.$user_id.'vc24'));
		$email_body = preg_replace($patterns, $replacements, $email_body);

	endif;

	$sLang = ICL_LANGUAGE_CODE;
	
	ob_start();		
		
	include(get_template_directory()."/email/email_tmpl.php");	
	
		
	$message = ob_get_contents();	
	ob_end_clean();

	//send email to user:
	wp_mail($user_email, $email_subject, $message);

	//now send to admin:
	$email_subject2 = 'GEULAH VOD New ser Registration';
	$message2 = 'New user registration for GEULAH VOD Website: name: ' . $first_name.' '.$last_name  .' email: '.$user_email;
	wp_mail(get_option( 'admin_email', 'ofer@shneorweb.com' ), $email_subject2, $message2);


}
endif;

?>