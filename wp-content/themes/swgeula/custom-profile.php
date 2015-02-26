<div class="enter-user" id="user_login_box">                                                                                                                                   
                    
                                    
                    <div id="login-register-password">
                
                    <?php global $user_ID, $user_identity; get_currentuserinfo(); if (!$user_ID) { ?>
                
                    
                    <div class="tab_container_login">
                        <div id="tab1_login" class="tab_content_login">                                                         
                        
                        <div class="loginPopUpRightSide">
                        
                        <div class="login-msgs">
                            <?php $register = $_GET['register']; $checkemail = $_GET['checkemail'];                             
                            if ($register == true) { ?>             
                                <div class="reg-success">
                                <h3>ההרשמה הצליחה!</h3>
                                <p>אנא בדקי את המייל שלך והכנסי לאתר.</p>
                                </div>
                
                            <?php } elseif ($checkemail=='confirm') { ?>
                                
                                <div class="reg-success">   
                                <h3>נשלחה אליך הודעה עם קישור לאישור איפוס הסיסמה</h3>
                                <h3>אנא בדקי את המייל שלך והכנסי לאתר.</h3>                                                                
                                </div>
                           
                            <?php } elseif (isset($_GET['inv_up'])) {?>
                                <h3 style="padding-top:20px;">דוא"ל או סיסמה שגויים. אנא נסי שוב!</h3>
                            <?php
                            }
                            elseif (isset($_GET['pass_re'])) {?>
                                <h3 style="padding-top:20px;">הסיסמה נשמרה. אנא הכנסי למערכת!</h3>
                            <?php   
                            }
                            ?>                                          
                        </div>
                    
                <h3 class="loginTitle">התחברי</h3>
                            <form method="post" action="<?php echo site_url('/custom-login-page/', 'login_post') ?>" class="wp-user-form" onsubmit="return checkLoginForm(this)">
                                <div class="username-right">
                                    <label for="user_login"><?php _e('דוא"ל'); ?>: </label>
                                    <input type="text" name="log" value="<?php echo esc_attr(stripslashes($user_login)); ?>" size="20" id="user_login" tabindex="1" />
                                </div>
                                <div class="password" style="float:right;">
                                    <label for="user_pass"><?php _e('סיסמה'); ?>: </label>
                                    <input type="password" name="pwd" value="" size="20" id="user_pass" tabindex="2" />
                                </div>
                                <div class="login_fields" style="float:right;">
                                    <div class="rememberme">
                                        <label for="rememberme" >
                                            <input type="checkbox" name="rememberme" value="forever" checked="checked" id="rememberme" tabindex="3"  /> השאר אותי מחוברת
                                        </label>
                                    </div>
                                    <?php do_action('login_form'); ?>
                                    <input type="submit" name="user-submit" value="כניסה" tabindex="4" class="user-submit" />
                                    <input type="hidden" name="redirect_to" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />
                                    <input type="hidden" name="user-cookie" value="1" />
                                </div>
                            </form>
                            
                            <div style="clear:both; float:right; margin-top:30px;"></div>
                            <div id="forgot_link">
                                <a href="javascript:void(0)" onclick="$j('#forgot_form').show();">שכחת את הסיסמה?</a>
                            </div>
                            
                            <div id="forgot_form">
                            <form name="lostpasswordform" id="lostpasswordform" action="<?php echo esc_url( site_url( 'wp-login.php?action=lostpassword', 'login_post' ) ); ?>"  method="post" style="display:inline;" onsubmit="return checkForgotForm(this);">
                                <input type="hidden" name="redirect_to" value="<?php echo $_SERVER['REQUEST_URI']; ?>?checkemail=confirm" />
                                <div style="clear:both; float:right; margin-top:54px;"></div>                                
                                
                                <div class="username-right">
                                    <label for="user_login" ><?php _e('דוא"ל') ?></label>
                                    <input type="text" name="user_login" id="user_login" size="20" value="<?php echo esc_attr($user_login); ?>" />
                                </div>
                                
                                <?php do_action('lostpassword_form'); ?>                                
                                <div class="login_fields" style="float:right;">                                
                                <input type="submit" name="wp-submit" id="wp-submit" class="user-submit" value="<?php esc_attr_e('שלחי'); ?>" />
                                </div>
                          </form>
                          </div>
                </div>                           
                   
</div>                        
                        <script>
                        function changeUserName(f,str) {
                            f.elements['user_login'].value=str;
                        }
                        </script>
                        
                            <div class="loginPopUpLeftSide">
                        
                            <h3 class="loginTitle">הרשמי לאתר</h3>
<div class="loginPopUpLeftSide-text"> ההרשמה לנשים ובנות בלבד</div>
                            <form method="post" action="<?php echo site_url('/custom-login-page/?action=register', 'login_post') ?>" class="wp-user-form" enctype="multipart/form-data" onsubmit="return checkRegisterForm(this);">                                             
                            <input type="hidden" name="user_login" value="" size="20" id="user_login" />
                                <div class="username">
                                    <label for="first_name" class="fieldsSpacer1">שם פרטי: </label>
                                    <input type="text" name="first_name" value="" size="20" id="first_name" tabindex="5" />
                                </div>
                                <div class="username">
                                    <label for="last_name" class="fieldsSpacer1">שם משפחה: </label>
                                    <input type="text" name="last_name" value="" size="20" id="last_name" tabindex="6" />
                                </div>
                                
                                <div class="username">
                                    <label for="user_email">כתובת הדוא"ל
שלך:</label>
                                    <input type="text" name="user_email" onchange="changeUserName(this.form,this.value)" value="" size="20" id="user_email" tabindex="7" />
                                </div>
                                
                                <div class="username">
                                    <label for="user_email2">הזני שוב
כתובת דוא"ל:</label>
                                    <input type="text" name="user_email2" value="" size="20" id="user_email2" tabindex="8" />
                                </div>
                                
                                <div class="username">
                                    <label for="user_neshei_nick" class="fieldsSpacer2">שם פרופיל:<div style="font-size:10px;color:#777878;margin-top:-5px;">גלוי לכל המשתמשות</div></label>
                                    <input type="text" name="user_neshei_nick" value="" size="20" id="user_neshei_nick" tabindex="9" />
                                </div>
                                
                                <div class="username">
                                    <label for="pass1" class="fieldsSpacer1">צרי סיסמה:</label>
                                    <input type="password" name="pass1" value="" size="20" id="pass1" tabindex="10" autocomplete="off"  />
                                </div>        
                                <!--                        
                                <div class="username">
                                    <label for="pass2" class="fieldsSpacer1">הזיני שוב סיסמה:</label>
                                    <input type="password" name="pass2" value="" size="20" id="pass2" tabindex="2"  />
                                </div>
                                -->
                                 <div style="width:284px; float:left; margin-top:10px;">
                                        <div style="float:right;width:62px;clear:both;"><img src="<?php bloginfo('template_url'); ?>/images/user.png" width="64" height="64" /></div>
                                        <div style="float:left;width:217px; margin:-5px 5px 0 0;">הוסיפי תמונת פרופיל:<div style="color:#777878; margin-top:-3px;">גודל תמונה מומלץ</div><div style="color:#777878; margin-top:-3px;">200x200 px</div></div>                                                                                
                                    <div style="position:absolute;top:-400px;left:0px;"><input type="file" name="user_avatar" id="user_avatar" tabindex="11" onchange="var lastIndex=$j('#user_avatar').val().lastIndexOf('\\')+1;$j('#file_upload_cont').text($j('#user_avatar').val().substring(lastIndex));" /></div>
                                    <div style="display:inline-block;"><input type="button" name="but_pic" id="but_pic" value="בחרי" class="user-submit5" onclick="$j('#user_avatar').click();" /></div>
                                    <div id="file_upload_cont" style="display:inline-block; height:14px; font-size:12px; line-height:12px; width:90px; overflow:hidden;"></div>
                                        
                                    
                                    <div class="Terms-of-Use" style="margin-top:2px;">בלחיצה על "הרשמה" את מאשרת את <a href="#">תנאי השימוש והפרטיות באתר</a> ומצהירה כי הנך אשה</div>                                                                                
                                <div class="username">
                                <div class="login_fields" style="width:86px; clear:both;">
                                    <?php do_action('register_form'); ?>
                                    <input type="submit" name="user-submit" value="" class="user-submit2" tabindex="12" />                                  
                                    <input type="hidden" name="redirect_to" value="<?php echo $_SERVER['REQUEST_URI']; ?>?register=true" />
                                    <input type="hidden" name="user-cookie" value="1" />                                                                                                                                              
                                </div>                                
                               </div>
                            </form>
                        
                        
                            
                        
                    </div>
                    <div class="loginLinks">
                    <div class="loginLinksRight"><a href="#">צור קשר</a> | <a href="#">פרסום באתר</a> | <a href="#">שלח ידיעה</a></div>
                    <div class="loginLinksLeft"><a href="http://www.chabad.info/" target="_blank">לאתר חב"ד אינפו</a></div>
                    </div>
                    </div>