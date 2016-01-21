<?php
/*
Template Name: Logout Page
*/
?>
<?php
	if (is_user_logged_in()) {	    	 
		$current_user = wp_get_current_user();
		$uid = $current_user->ID;
		$lang = get_user_meta( $uid, 'user_lang', true );
		$lang  = strstr($lang,"_",true);	
	}	
	wp_logout();
	$redirect = "/my-account/sign-in/";			
	if ( isset($lang) && ($lang!="he") ) {
		wp_redirect( add_query_arg( 'lang', $lang, site_url($redirect) ) );		
	}
	else wp_redirect( site_url($redirect) );
?>