<?php
/**
 * The header for our theme.
 *
 * @package swgeula
 */
global $gsLocale;
global $gsLocaleShort;
?>
<!DOCTYPE html>
<html>
<head>
	<script>
		var newBase = document.createElement("base");
		newBase.setAttribute("href", document.location);
		document.getElementsByTagName("head")[0].appendChild(newBase);		

    var gbLocal = (document.location.href.indexOf("127.0.0.1")!=-1);    
    var gsLibraryDir = '<?php echo get_category_link(getCatIDOfLibrary());?>';
    var sCurLang = '<?php echo $gsLocale;?>';    
    //console.log("lang="+sCurLang);
	</script>  
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="<?php bloginfo('template_directory');?>/images/favicon.ico">

    <title>
      <?php wp_title( '|', true, 'right' ); ?>
      <?php bloginfo( 'name' ); ?>
    </title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
	<![endif]-->
  
  <?php if ( is_page("registration") || is_page("sign-in") ) {?>  
  <script src="https://apis.google.com/js/client:platform.js" async defer></script>
  <script src = "https://plus.google.com/js/client:plusone.js"></script>
  <?php } ?>
  
	<?php wp_head(); ?>


	<?php if ( is_page("settings") ) : ?>
    <script> 

    (function($) {

		$(document).ready(function() {                   
        $(".sidebar .menu a:not([href$='edit-profile/'])").attr("target","_self");
        $(".nav .menu-item a:not([href$='edit-profile/'])").attr("target","_self");


        if (document.location.href.indexOf("settings")!=-1) {          
            angular.element(document).ready(function() {
              angular.bootstrap(document,['appgeula']);                 
            });
        }
		});		

  

	})(jQuery);
	</script>  
  <?php endif;?>  

</head> 

<body <?php body_class(); ?>>
  
    <div class="navbar navbar-inverse navbar-fixed-top" >
       
      <header id="masthead" class="site-header" role="banner">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
           
          
          <div class="site-branding">
              <h1 class="site-title">
                  <a class="navbar-brand" href="<?php echo get_category_link(3); ?>" rel="home" class="nav-brand">
                      <?php bloginfo( 'name' ); ?>
                  </a>
              </h1>
          </div><!-- .site-branding -->

            
         <div class="menu-top" ><?php 
            $args = array(
              'menu'        => 'header-menu',
              'menu_class'  => 'nav navbar-nav',
              'container'   => 'false'
            );          
          ?></div>
        </div>        

         <div class="menu-top" >
          
          <?php if ( is_user_logged_in() ) {?> 

                <div class="profile hidden-xs">
                    
                    <div class="points profile_dtls">
                        <i class="fa fa-trophy"></i>
                        <div class="text">
                            <!-- TODO: get the points from user profile -->
                            31
                        </div>    
                    </div>
                    
                    <div class="timer profile_dtls">
                        <i class="icon-timer"></i>
                        <!-- TODO: get the timer from user profile -->
                    </div>
                    
                    <div class="profile_dtls notification_icon">
                        <i class="fa fa-bell-o"></i>
                        <!-- TODO: get the color(class) of notification_point from user profile -->
                        <div class="notification_point green"></div>
                    </div>
                    
                    <div class="profile_dtls avatar_image">                    
                      <?php if ( getSWGeulaAvatar()!="" ) : ?>
                          <img src="<?php echo getSWGeulaAvatar(); ?>"/>
                      <?php else : ?>
                          <img src="<?php echo get_template_directory_uri(); ?>/images/user.svg"/ width="38">
                      <?php endif; ?>                    
                    </div>
                    
                    
                    
                    <div class="profile_dtls dropdown">
                         <div id="div-display-name" class="avatar_name" data-toggle="dropdown">
                       <?php                           
                            $current_user = wp_get_current_user();                           
                            echo $current_user->display_name;                                                     
                       ?>
                    </div>
                        
                        <?php 
                            $args = array(
                              'menu'        => 'header-menu',
                              'menu_class'  => 'dropdown-menu',
                              'container'   => 'false'
                            );
                            wp_nav_menu( $args );
                         ?>
                        
                    </div>
                    
                </div>
             
              <div class="profile mob visible-xs">
                  <div class="dtls_cont">
                    
                    <div class="profile_dtls avatar_image">
                        <?php if ( getSWGeulaAvatar() != "" ) : ?>
                            <img src="<?php echo getSWGeulaAvatar(); ?>"/>
                        <?php else : ?>
                            <img src="<?php echo get_template_directory_uri(); ?>/images/user_light.svg"/>
                        <?php endif; ?>
                    </div>
                  
                <div class="name_and_points">
                    
                      <div class="profile_dtls">
                             <div class="avatar_name">
                               <?php
                                   $current_user = wp_get_current_user();
                                   /*
                                   echo 'Username: ' . $current_user->user_login . '<br />';
                                   echo 'User email: ' . $current_user->user_email . '<br />';
                                   echo 'User first name: ' . $current_user->user_firstname . '<br />';
                                   echo 'User last name: ' . $current_user->user_lastname . '<br />';
                                   */
                                   echo $current_user->display_name;
                                   /*echo 'User ID: ' . $current_user->ID . '<br />';*/
                               ?>
                            </div>

                        </div>

                        <div class="points profile_dtls">
                            <div class="text">
                                <!-- TODO: get the points from user profile -->
                                31
                            </div>    
                        </div>
                    
                    </div>      
                      
                  </div>
                   
                  <div class="icons_cont">
                    <div class="profile_dtls notification_icon">
                        <i class="fa fa-bell-o"></i>
                        <!-- TODO: get the color(class) of notification_point from user profile -->
                        <div class="notification_point green"></div>
                    </div>
                    <div class="timer profile_dtls">
                        <i class="icon-timer"></i>
                        <!-- TODO: get the timer from user profile -->
                    </div>
                  </div>                 
                    
                </div>
             
            </div>
            <?php }  //if user is logged in 
                  else   {
            ?>
              <div style="margin-left:20px;">
                <button type="button" class="btn btn-default" aria-label="Left Align" onclick="goToLogin()"><?php _e("Login","swgeula") ?></button>                
              </div>            
            <?php }
            ?>
        </div>


        <div class="navbar-collapse collapse">

           	<nav id="site-navigation" class="main-navigation" role="navigation">
                <ul class="drop">
                    <?php if ( !is_page("registration") && !is_page("sign-in") ) get_sidebar(); ?>
                    
                 </ul>
            </nav>
          </div><!--/.navbar-collapse -->
        
        </header>
        
      </div>
     

   
		<div id="content" class="site-content">

            <?php if(is_page_template( 'custom-profile.php' )){?>
            <div class="container-fluid">					
                <?php }else{?>
			<div class="container">
                <?php } ?>
            
               
                <div class="row">
    