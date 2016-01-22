<?php
/*
Template Name: Custom_Login
*/
?>

<?php include_once("header.php");?>

<script>
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


<div class="logAndReg_cont"> 
       <div class="panel" style="text-align:center;">    
    <div class="div-login">       

    		<h1><?php _e("Login with an exisiting account","swgeulatr");?></h1>
    		<h2><?php _e("enter your email address and your password","swgeulatr");?></h2>

    

        <div class="login-error-msg"></div>

        <?php 

        $login  = (isset($_GET['login']) ) ? $_GET['login'] : 0;  
        if ( $login === "failed" ) {  ?>
            <p class="login-error-msg"><strong><?php _e("ERROR:","swgeulatr");?></strong> <?php _e("Invalid username and/or password.","swgeulatr");?></p>  
         <?php } elseif ( $login === "failedvc" ) {  ?>
            <p class="login-error-msg"><strong><?php _e("ERROR:","swgeulatr");?></strong> <?php _e("Please check your registration email and use the link to login","swgeulatr");?>.</p>    
        <?php } elseif ( $login === "empty" ) {  ?>
            <p class="login-error-msg"><strong><?php _e("ERROR:","swgeulatr");?></strong> <?php _e("Username and/or Password is empty","swgeulatr");?>.</p>
        <?php } elseif ( $login === "false" ) {  ?>
            <p class="login-error-msg"><strong><?php _e("ERROR:","swgeulatr");?></strong> <?php _e("You are logged out.","swgeulatr");?></p>  
        <?php } elseif ( isset($_GET['action']) && 'expiredkey' == $_GET['action'] ) {  ?>
            <p class="login-error-msg"><strong><?php _e("ERROR:","swgeulatr");?></strong> <?php _e("This key has expired.","swgeulatr");?></p>      
        <?php } elseif ( isset($_GET['action']) && 'invalidkey' == $_GET['action'] ) {  ?>
            <p class="login-error-msg"><strong><?php _e("ERROR:","swgeulatr");?></strong> <?php _e("This key is invalid.","swgeulatr");?></p>      
        <?php } elseif  ( isset($_GET['checkemail']) && 'registered' == $_GET['checkemail'] ) {?>                
            <p class="login-msg">    <?php echo _e('Registration complete. Please check your e-mail and login.','swgeulatr');?> </p>            
        <?php } elseif  ( isset($_GET['checkemail']) && 'confirm' == $_GET['checkemail'] ) {?>
            <p class="login-msg">    <?php echo _e('An email has been sent to you with reset instructions. Please check your email and follow the link to reset your password','swgeulatr');?> </p>                                     
        <?php } elseif  ( isset($_GET['action']) && 'pcsignin' == $_GET['action'] ) {?>
            <p class="login-msg">    <?php echo _e('Your password has been changed succesfully. Please login.','swgeulatr');?> </p>                        
        <?php  }                   

        $redirect_to = !empty( $_REQUEST['redirecr'] ) ? $_REQUEST['redirecr'] : get_category_link(getCatIDOfLibrary());        
            
        $args = array(                                
                'redirect' => ( (isset($_GET['checkemail']) && $_GET['checkemail']=='registered') || isset($_GET['vc']) )?get_category_link(getCatIDOfLibrary()):$redirect_to, 
                'form_id' => 'loginform-custom',
                'label_username' => '',
                'label_password' => '',                
                'label_remember' => __( 'Remember Me','swgeulatr' ),
                'label_log_in' => __( 'Log In','swgeulatr' ),
                'remember' => true
        );  
        //changed from home_url('settings') to library link

            if ( isset($_GET['vc']) ) :
        ?>
            <!-- now set timezone for this user: -->
            <script>
                var ajaxurl = gbLocal?'/geula/wp-admin/admin-ajax.php':'/wp-admin/admin-ajax.php';
                var tz = jstz.determine(); // Determines the time zone of the browser client      
                var sLocalTZ = tz.name();
                if (sLocalTZ == 'Asia/Beirut') sLocalTZ = 'Asia/Jerusalem';//fix Israel TZ
                if (sLocalTZ =="United Kingdom") sLocalTZ = 'Europe/London';//fix UK TZ
                var data = {        
                        'action': 'set_user_tz',                                       
                        'vc' : '<?php echo $_GET["vc"];?>',
                        'utimezone' : sLocalTZ
                    };                                               
                jQuery.post(ajaxurl, data, function(data) {                                    
                       //console.log(data);                       
                });

            </script>
            <!-- end set timezone -->
        <?php 
            endif;
        wp_login_form($args); 
        ?>
    
    
    
    <div style="clear:both;">
    <a class="frgtPassLink" href="<?php echo wp_lostpassword_url(); ?>" title="<?php esc_attr_e( 'Lost my password','swgeulatr' ); ?>"><?php _e( 'Lost my password','swgeulatr' ); ?></a>
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
        data-scope="https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/userinfo.email"
        data-width="wide"
        data-height="tall"
        >
      </span>
    </span>
    </p>
</div>
</div>

<div id="login-bottom-text"><span><?php echo _e("Is this your first time? ","swgeulatr"); ?></span> <span><a href="<?php echo site_url()."/registration/";?>"><?php echo _e("Create a new account","swgeulatr"); ?></a></span></div>

</div>






