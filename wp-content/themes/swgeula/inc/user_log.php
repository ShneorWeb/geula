<?php if (is_user_logged_in()) : ?>                                                                     
	<div style="border: 1px solid #000; margin-bottom: 20px;">
		<?php global $userdata,$user_identity;; get_currentuserinfo();  ?>
		<h3><?php echo $user_identity; get_currentuserinfo(); ?></h3>
		<div class="usericon">
			<?php echo get_avatar($userdata->ID, 60); ?>

		</div>
		<div class="userinfo">
			<p><?php echo $user_identity; ?></p>
			<p>
				<a href="<?php echo wp_logout_url(home_url()); ?>" title="Logout">Log out</a> | 
				<a href="javascript:void(0);" onclick="jQuery('#div_edit_profile').toggle('slow', function() {});">edit profile</a>
					<div id="div_edit_profile" style="display:none;"><?php include_once("custom-profile.php");?></div>
			</p>
		</div>
	</div>         

	<?php else : // not logged in ?>
		
		<input type="button" value="לוגאין" onclick="document.location.href='<?php echo add_query_arg('action','login',get_site_url().'/my-account/sign-in/')?>'" />
		<input type="button" value="הרשם" onclick="document.location.href='<?php echo add_query_arg('action','register',get_site_url().'/my-account/sign-in/')?>'" />

	<?php endif; //of if logged in ?>

                    
