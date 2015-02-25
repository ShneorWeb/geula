<?php include_once("header.php");?>

	<div id="div-login">       

		<h1><?php _e("Login with an exisiting account","swgeulatr");?></h1>
		<h2><?php _e("enter your email address and your password","swgeulatr");?></h2>

<?php 

$login  = (isset($_GET['login']) ) ? $_GET['login'] : 0;  
if ( $login === "failed" ) {  ?>
    '<p class="login-error-msg"><strong><?php _e("ERROR:","swgeulatr");?></strong> <?php _e("Invalid username and/or password.","swgeulatr");?></p>  
<?php } elseif ( $login === "empty" ) {  ?>
    '<p class="login-error-msg"><strong><?php _e("ERROR:","swgeulatr");?></strong> <?php _e("Username and/or Password is empty","swgeulatr");?>.</p>
<?php } elseif ( $login === "false" ) {  ?>
    '<p class="login-error-msg"><strong><?php _e("ERROR:","swgeulatr");?></strong> <?php _e("You are logged out.","swgeulatr");?></p>  
<?php }  

$args = array(
        'redirect' => admin_url(), 
        'form_id' => 'loginform-custom',
        'label_username' => '',
        'label_password' => '',                
        'label_remember' => __( 'Remember Me','swgeulatr' ),
        'label_log_in' => __( 'Log In','swgeulatr' ),
        'remember' => true
);

wp_login_form($args); 
?>
<p><a href="<?php echo wp_lostpassword_url(); ?>" title="<?php esc_attr_e( 'Lost my password','swgeulatr' ); ?>"><?php _e( 'Lost my password','swgeulatr' ); ?></a></p>

<hr/>

<h2 class="signin-google"><?php _e("Or sign in with your Google account", "swgeulatr");?></h2>

<p>
<span id="signinButton">
  <span
    class="g-signin"
    data-callback="signinCallback"
    data-clientid="CLIENT_ID"
    data-cookiepolicy="single_host_origin"
    data-requestvisibleactions="http://schema.org/AddAction"
    data-scope="https://www.googleapis.com/auth/plus.login">
  </span>
</span>
</p>

 <script>    

    (function($) {
		$(document).ready(function() {			
			$('#user_login').attr( "placeholder", "<?php _e( 'Email','swgeulatr' ); ?>" );
			$('#user_pass').attr( "placeholder", "<?php _e( 'Password','swgeulatr' );?>" );				
			var temp = $("#div-login .login-remember").html();
			$("#div-login .login-remember").html($("#div-login .login-submit").html());
			$("#div-login .login-submit").html(temp);
			$("#div-login .login-remember").addClass("login-submit");
			$("#div-login .login-remember").removeClass("login-remember");			
			$("#div-login .login-submit").addClass("login-remember");
			$("#div-login .login-submit").removeClass("login-submit");						
		});				

	})(jQuery);
</script>  