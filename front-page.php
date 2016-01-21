<?php 
if (is_user_logged_in()) {
	wp_safe_redirect(get_category_link(3));
} else { 

get_header(); ?>


<div class="hero_image">
   <img src="<?php the_field('big_image', $post->ID);?>" class="bgImg hidden-xs hidden-sm">
    <img src="<?php the_field('big_image_mob', $post->ID);?>" class="bgImg visible-xs visible-sm ">
      
           <div class="quote_cont">
            <div class="quote">
              <?php the_field('quote', $post->ID); ?>
           </div>
            <div class="source">
              <?php the_field('source', $post->ID); ?>
           </div>
        </div>
    
</div>

<div class="register_cont">
   <div class="container">
        <h2><?php the_field('title_1', $post->ID); ?></h2>
        <p> <?php the_field('sub_title', $post->ID); ?></p>
        <script>
        function regSetFields(f)  {
          f.user_login.value=f.user_email.value;
          var arrName = f.full_name.value.split(" ");                   
          f.first_name.value = arrName[0];
          f.last_name.value = arrName[1];
          return true;

        }
        </script>
        <form name="registerform" id="registerform" action="<?php echo esc_url( site_url('/registration/', 'login_post') ); ?>" method="post" novalidate="novalidate" onsubmit="return regSetFields(this)">       
          <input type="hidden" name="user_login" id="user_login" value="" />        
          <input type="hidden" name="first_name" id="first_name" value="" />        
          <input type="hidden" name="last_name" id="last_name" value="" />  

            <input type="text" name="full_name" id="full_name" placeholder="<?php echo __('Name', 'swgeula'); ?>">
            <input type="email" name="user_email" id="user_email" placeholder="<?php echo __('Email', 'swgeula'); ?>">
            <input type="password" name="user_password" id="user_password" placeholder="<?php echo __('Password', 'swgeula'); ?>">
            <input type="submit" value="<?php echo __('Create free account', 'swgeula'); ?>">
        </form>

        <br/>
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




<?php
 } //of else logged in
?>
<?php get_footer(); ?>
				
					

