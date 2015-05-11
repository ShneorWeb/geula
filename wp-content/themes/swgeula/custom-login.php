<?php
/*
Template Name: Custom_Login
*/
?>

<?php include_once("header.php");?>

<script>
function signinCallback(authResult) {
  if (authResult['status']['signed_in'] && authResult['status']['method']=="PROMPT") {
    // Update the app to reflect a signed in user
    // Hide the sign-in button now that the user is authorized, for example:
    //document.getElementById('signinButton').setAttribute('style', 'display: none');    
    gapi.client.load('plus','v1', function(){ 
        // once we get this call back, gapi.client.plus.* will exist
        var user = gapi.client.plus.people.get( {'userId' : 'me'} ); 
        
        user.execute(function(resp) {                                       
                var primaryEmail;
                for (var i=0; i < resp.emails.length; i++) {
                  if (resp.emails[i].type === 'account') primaryEmail = resp.emails[i].value;
                }
                console.log(resp.aboutMe);                 

                var ajaxurl = gbLocal?'/geula/wp-admin/admin-ajax.php':'/wp-admin/admin-ajax.php';
                var data = {        
                        'action': 'google_user_reg',
                        'uid': resp.id,
                        'first_name': resp.name['givenName'],
                        'last_name': resp.name['familyName'],
                        'image_url': resp.image.url,
                        'primary_email': primaryEmail,
                        'about_me': resp.aboutMe,
                        'language': resp.language
                };                                                                                                            
                jQuery.post(ajaxurl, data, function(data) {                                    
                        //console.log(data);
                       // document.location.href="<?php echo home_url();?>";    
                });
        });
    });    
    
  }
  else {  
    // Update the app to reflect a signed out user
    // Possible error values:
    //   "user_signed_out" - User is signed-out
    //   "access_denied" - User denied access to your app
    //   "immediate_failed" - Could not automatically log in the user
    //console.log('Sign-in state: ' + authResult['error']);    
  }
}

(function($) {
        $(document).ready(function() {          
            $('#user_login').attr( "placeholder", "<?php _e( 'Email','swgeulatr' ); ?>" );
            $('#user_pass').attr( "placeholder", "<?php _e( 'Password','swgeulatr' );?>" );             
            
            var temp = $(".div-login .login-remember").html();
            $(".div-login .login-remember").html($(".div-login .login-submit").html());
            $(".div-login .login-submit").html(temp);
            $(".div-login .login-remember").addClass("login-submit");
            $(".div-login .login-remember").removeClass("login-remember");          
            $(".div-login .login-submit").addClass("login-remember");
            $(".div-login #user_login").removeClass("input");
            $(".div-login #user_login").addClass("form-control");
            $(".div-login #user_pass").removeClass("input");
            $(".div-login #user_pass").addClass("form-control");           
            $(".div-login #wp-submit").addClass("btn btn-success");                      
        })        
})(jQuery);
</script>


<div class="row">
    <div class="col-sm-5 col-sm-offset-4"> 
    <div class="panel" style="text-align:center;">
    <div class="div-login">       

    		<h1><?php _e("Login with an exisiting account","swgeulatr");?></h1>
    		<h2><?php _e("enter your email address and your password","swgeulatr");?></h2>

    <div class="col-sm-8 col-sm-offset-2">
        <?php 

        $login  = (isset($_GET['login']) ) ? $_GET['login'] : 0;  
        if ( $login === "failed" ) {  ?>
            <p class="login-error-msg"><strong><?php _e("ERROR:","swgeulatr");?></strong> <?php _e("Invalid username and/or password.","swgeulatr");?></p>  
        <?php } elseif ( $login === "empty" ) {  ?>
            <p class="login-error-msg"><strong><?php _e("ERROR:","swgeulatr");?></strong> <?php _e("Username and/or Password is empty","swgeulatr");?>.</p>
        <?php } elseif ( $login === "false" ) {  ?>
            <p class="login-error-msg"><strong><?php _e("ERROR:","swgeulatr");?></strong> <?php _e("You are logged out.","swgeulatr");?></p>  
        <?php } elseif  ( isset($_GET['checkemail']) && 'registered' == $_GET['checkemail'] ) {?>
            <p class="login-msg">    <?php echo _e('Registration complete. Please check your e-mail and login.','swgeulatr');?> </p>
            <?php  }   

        $redirect_to = !empty( $_REQUEST['redirecr'] ) ? $_REQUEST['redirecr'] : home_url();
            
        $args = array(                                
                'redirect' => ( isset($_GET['checkemail']) && $_GET['checkemail']=='registered' )?home_url('custom-profile-page'):$redirect_to, 
                'form_id' => 'loginform-custom',
                'label_username' => '',
                'label_password' => '',                
                'label_remember' => __( 'Remember Me','swgeulatr' ),
                'label_log_in' => __( 'Log In','swgeulatr' ),
                'remember' => true
        );
        wp_login_form($args); 
        ?>
    </div>
    <div class="col-sm-2"></div>
    
    <div style="clear:both;">
    <a href="<?php echo wp_lostpassword_url(); ?>" title="<?php esc_attr_e( 'Lost my password','swgeulatr' ); ?>"><?php _e( 'Lost my password','swgeulatr' ); ?></a>
    </div>

    <hr/>

    <h2 class="signin-google"><?php _e("Or sign in with your Google account", "swgeulatr");?></h2>

    <p>
    <span id="signinButton">
      <span
        class="g-signin"
        data-callback="signinCallback"
        data-clientid="1071363229202-e8nga4duksuc3vldrpm3guuikc9i82ae.apps.googleusercontent.com"
        data-cookiepolicy="single_host_origin"
        data-requestvisibleactions="http://schema.org/AddAction"
        data-scope="https://www.googleapis.com/auth/plus.login email profile"
        >
      </span>
    </span>
    </p>
</div>
</div>
</div>
<div class="col-sm-3"></div>

<div class="col-sm-5 col-sm-offset-4" style="text-align:center;"> 
    <div id="login-bottom-text"><span><?php echo _e("Is this your first time? ","swgeulatr"); ?></span> <span><a href="<?php echo site_url()."/custom-register-page/?action=register";?>"><?php echo _e("Create a new account","swgeulatr"); ?></a></span></div>
</div>
<div class="col-sm-3"></div>



