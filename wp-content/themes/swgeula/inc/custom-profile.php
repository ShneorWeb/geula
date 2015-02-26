<?php
/*
Template Name: Custom_Profiler
*/
global $current_user, $wp_roles;
get_currentuserinfo();

/* Load the registration file. */
require_once( ABSPATH . WPINC . '/registration.php' );

function checkEmail( $email ){
    return filter_var( $email, FILTER_VALIDATE_EMAIL );
}
/* If profile was saved, update profile. */
if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['action'] == 'update-user' ) {	
	$error = array();
    /* Update user password. */
    if ( !empty($_POST['pass1'] ) && !empty( $_POST['pass2'] ) ) {
        if ($_POST['pass1'] != $_POST['pass2']) 
            $error[] = 'הסיסמאות שהזנת לא תואמות.  הסיסמה לא עודכנה.';
    }
	if (empty($_POST['user_email']) || !checkEmail($_POST['user_email']))  $error[] = 'נא למלא כתובת דוא"ל';	
	if (empty($_POST['user_neshei_nick']))  $error[] = 'נא למלא שם פרופיל';

	 if (count($error)==0)  {
		$userdata = array();	
		$userdata['ID'] = $current_user->id;
		$userdata['display_name'] = mb_substr($_POST['user_neshei_nick'],0);		
		if ( !empty($_POST['pass1'] ) && !empty( $_POST['pass2'] ) ) $userdata['user_pass'] = esc_attr($_POST['pass1']);
		if ( !empty($_POST['user_email']) && checkEmail($_POST['user_email'])) $userdata['user_email'] = $_POST['user_email'];
		
		add_action( 'profile_update', 'neshei_user_profile_notify', 10, 2 );		
		wp_update_user($userdata);
		remove_action( 'profile_update', 'neshei_user_profile_notify', 10, 2 );
	}
	
	
	if ($_POST['del_pic']=="1") update_usermeta($current_user->id, 'custom_avatar', '');
	else if (!empty($_POST['resized_url'])) update_usermeta($current_user->id, 'custom_avatar', $_POST['resized_url']);	

    /* Redirect so the page will show updated info. */
    if ( count($error)==0 ) {			
        wp_redirect( get_permalink() .'?updated=true');
        exit;
    }
}
?>

<?php get_header(); ?>


<?php if ( !is_user_logged_in() ) : ?>
                        <p class="warning">
                            <?php _e('עלייך להיות מחוברת למערכת כדי לעדכן את הפרופיל.', 'profile'); ?>
                        </p><!-- .warning -->
<?php else : ?>

<div id="profile-page" style="direction:rtl; text-align:right; margin-top:20px; margin-right:35px;">

<h3 class="loginTitle">הגדרות חשבון</h3>

</div>

<div style="direction:rtl; text-align:right; color:#000; background:#f6eff7; border-top:6px solid #d453d4; margin-top:15px; float:right;">
<div>
<?php if ( isset($_GET['updated']) ) {
	$d_url = $_GET['d'];?>
	<p class="message"><?php _e('הפרופיל עודכן בהצלחה','cp')?></p>
<?php } ?>
<?php if (count($error)>1) {
		foreach($error as $er) {
			echo ($er.'<br/>'); 
	  	}	 
	}
	else if (count($error)==1) echo $error[0];
?>
</div>

						<form method="post" action="<?php the_permalink(); ?>" class="wp-user-form" enctype="multipart/form-data" id="adduser">
                                <input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id; ?>" />                               
                            <div id="prof-right">
                                <div class="prof-section">                                	
                                	<div class="prof-sep"></div>
                                    <h4 class="prof-sec-title">פרטים אישיים</h4>
                                	<div class="prof-label" style="margin-bottom:20px;">שם פרטי:</div> <div class="prof-gray"><?php echo htmlspecialchars($userdata->first_name) ?></div>
                                    <div class="prof-label">שם משפחה:</div> <div class="prof-gray"><?php echo htmlspecialchars($userdata->last_name) ?></div>                                    
                                </div>
                                
                                <div style="clear:right"></div>
                                
                                <div class="prof-section">	
	                                <div class="prof-sep"></div>							                                     
                                	 <h4 class="prof-sec-title">פרופיל</h4>	                                 
                                     <div class="prof-black">	
                                        <label for="user_email">דוא"ל:<br/><span class="label-exp">אינו גלוי למשתמשות</span></label>
                                        <input type="text" name="user_email" value="<?php echo $userdata->user_email ?>" size="25" id="user_email" tabindex="3" />
                                    </div>
                                    <div class="prof-black">
                                        <label for="user_neshei_nick">שם פרופיל:<br/><span class="label-exp">גלוי לכל המשתמשות</span></label>
                                        <input type="text" name="user_neshei_nick" value="<?php echo htmlspecialchars($userdata->display_name); ?>" size="25" id="user_neshei_nick" tabindex="4" />
                                    </div>                                     
                                 </div>
								
                                 <div class="prof-section" id="password">	                                 	 
	                                 <div class="prof-sep"></div>
                                     <h4 class="prof-sec-title">שינוי סיסמה</h4>                                     
                                     <div class="label-exp" style="margin:-25px 0 20px 0; display:block;">הסיסמה לא תשתנה אם השדה ישאר ריק</div>
                                     <div class="prof-black">
                                        <label for="pass1">סיסמה:</label>
                                        <input type="password" name="pass1" value="" size="25" id="pass1" tabindex="5" />
                                    </div>
                                    <div class="prof-black">
                                        <label for="pass2">אימות סיסמה:</label>
                                        <input type="password" name="pass2" value="" size="25" id="pass2" tabindex="6" />
                                    </div>             
                                    <div id="pass-strength-result"></div>
									
                                 </div>  
                                 
                                 <div class="prof-section">	       
<!--                                 	 <div style="margin-right:110px;"><a href="<?php bloginfo('wpurl'); ?>/wp-login.php?action=lostpassword">שכחת את הסיסמה?</a></div>-->
	                                 <div class="prof-sep" style="margin-top:10px;"></div>
                                 </div>
                                 
                                 <div class="prof-section">	      
 	                                <?php echo $referer; ?>
									<input type="submit" name="user-submit" value="עדכון חשבון" class="user-submit3" style="margin-top:-10px;" tabindex="8" />
									<?php wp_nonce_field( 'update-user' ) ?>
                            		<input name="action" type="hidden" id="action" value="update-user" />
								</div>

                            </div>     
                            <div id="prof-left">                                                                                                                     
                                <div class="prof-section" style="height:350px;">
                                	<div><img src="<?php echo $userdata->custom_avatar ?>" width="200" height="200" /></div>                                    
									<label for="user_avatar">תמונת פרופיל</label>
                                    <div class="label-exp">גודל תמונה מומלץ 200x200 פיקסל </div>
                                    <div style="position:absolute;top:-400px;left:0px;"><input type="file" name="user_avatar" id="user_avatar" onchange="var lastIndex=$j('#user_avatar').val().lastIndexOf('\\')+1;$j('#file_upload_cont').text($j('#user_avatar').val().substring(lastIndex));" /></div>                                    
                                    <div style="display:inline-block;"><input type="button" name="but_pic" id="but_pic" value="שינוי" class="user-submit4" onclick="$j('#user_avatar').click();" /></div>
                                    <div id="file_upload_cont" style="display:inline-block; font-size:12px; line-height:12px; width:300px; overflow:hidden;"></div>
                                   <!--
                                    <div style="float:right; text-align:right; direction:rtl;">
                                    	<input type="file" name="user_avatar" id="user_avatar" tabindex="7" />                                   
                                        <div style="float:right; margin-right:14px;"><input type="checkbox" value="1" name="del_pic" id="del_pic" style="width:60px;" /></div><div style="float:right; margin-right:-10px;">מחק את התמונה</div>
                                    </div>                                    
                                    -->
                               </div>
                               
                               <div class="prof-section">
                               <div class="prof-links"><a href="">עזרה</a></div>
                               <div style="font-size:12px; margin-top:4px;"><a href="">תנאי השימוש והפרטיות</a></div>
                               </div>                               
                                
							</div>		
						</form>
</div>
<div style="clear:both; font-style:height:1px;"></div>

<script>
$j(document).ready(function(){	
    $j("#pass1").keyup(checkStrength);   
	$j("#pass2").keyup(checkSame);   
	if ($j("#pass1").val()!="") checkStrength();
})
</script>
                            
<?php endif; ?>       
<?php get_footer(); ?>                            