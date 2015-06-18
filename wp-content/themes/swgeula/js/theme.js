var filterBoxes;
var filterBoxesTeach;
var addToMyLessons;
var removeFromMyLessons;
var hideCat;
var addSchedule;


function goToLogin() {
  var sLang = sCurLang.indexOf("_")!=-1?sCurLang.substr(0,sCurLang.indexOf("_")):sCurLang;  
  window.location.href=gbLocal?'/geula/my-account/sign-in/?lang='+sLang:'/my-account/sign-in/?lang='+sLang;
}


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
               // console.log(resp);
                var ajaxurl = gbLocal?'/geula/wp-admin/admin-ajax.php':'/wp-admin/admin-ajax.php';
                var data = {        
                        'action': 'google_user_reg',
                        'uid': resp.id,
                        'first_name': resp.name['givenName'],
                        'last_name': resp.name['familyName'],
                        'display-name' : resp.displayName,
                        'image_url': resp.image.url,
                        'primary_email': primaryEmail,
                        'about_me': resp.aboutMe,
                        'language': resp.language,
                        'occupation' : resp.occupation,
                        'language' : resp.language,
                        'places-lived' : jQuery.isArray(resp.placesLived)?resp.placesLived[0].value:''
                    };                               
                console.log(data);
                    
                jQuery.post(ajaxurl, data, function(data) {                                    
                       //console.log(data);
                       if (data==2) jQuery("div.login-error-msg").text('this email is already registered');
                       else if (data==0) jQuery("div.login-error-msg").text('an error occured');
                       else if (data==1) document.location.href= gbLocal?'/geula/my-account/settings/':'/my-account/settings/';                       
                       else if (data==11) document.location.href= gsLibraryDir;   
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
    
//global vars
var highestBox1;
var highestBox2;    
var ajaxurl = gbLocal?'/geula/wp-admin/admin-ajax.php':'/wp-admin/admin-ajax.php';
    
//global functions    

filterBoxes = function(iAuthorID,parentCat,sSort,iCatID,bInNosse) {    
  
  sOrderby = "ID";
  if (sSort == 'new_to_old') sOrder = "desc";  
  else if (sSort == 'old_to_new') sOrder = "asc"; 
  if (sSort == "alphabet") { 
    sOrderby = "name";
    sOrder = "asc";  
  }  

  $.ajax({
          type : "post",
          data : {
              'action': 'get_cat_boxes',
              'order_by': sOrderby,
              'order': sOrder,
              'parent_cat': parentCat,
              'author_id': iAuthorID,
              'cat' : iCatID,
              'in_nosse' : bInNosse
          },          
          url: ajaxurl,          
          success    : function(data){
             
               //$data = $(data);
               //$data.hide();
               //console.log(data);
               //$content.append($data);
               //$data.fadeIn(500);
               $("#div-cat-boxes").html(data);
          },
          error     : function(jqXHR, textStatus, errorThrown) {
              console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
          }      
  });
}

filterBoxesTeach = function(parentCat,sSort,iAuthorID) {    
  
  sOrderby = "ID"; 
  if (sSort == 'new_to_old') sOrder = "desc";  
  else if (sSort == 'old_to_new') sOrder = "asc"; 
  if (sSort == "alphabet") { 
    sOrderby = "name";
    sOrder = "asc";  
  }  

  $.ajax({
          type : "post",
          data : {
              'action': 'get_cat_boxes_teach',
              'order_by': sOrderby,
              'order': sOrder,
              'parent_cat': parentCat,
              'author_id':iAuthorID              
          },          
          url: ajaxurl,          
          success    : function(data){
             
               //$data = $(data);
               //$data.hide();
               //console.log(data);
               //$content.append($data);
               //$data.fadeIn(500);
               $("#div-cat-boxes").html(data);
          },
          error     : function(jqXHR, textStatus, errorThrown) {
              console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
          }      
  });
}

addSchedule = function(el,scheduleDay,scheduleTime) {

  console.log($(el));
  var clickedDiv = $(el).find('.table_rect');

  var boolAdd = 1;
  if ( $(clickedDiv).hasClass('green') ) boolAdd=0; //delete schedule

  $.ajax({
          type : "post",
          data : {
              'action': 'add_schedule',
              'schedule_day': scheduleDay,     
              'schedule_time': scheduleTime,
              'bool_add' : boolAdd
          },          
          url: ajaxurl,          
          success    : function(data){                                        
              //console.log(data);
              //console.log("in success");
              if (boolAdd) { 
                $(clickedDiv).removeClass('yellow');               
                $(clickedDiv).addClass('green');
              }
              else {
                $(clickedDiv).removeClass('green');
                if (data=="2") $(clickedDiv).addClass('yellow');                
              }
              //$('#dp1').hide();                                                                                     
          },
          error     : function(jqXHR, textStatus, errorThrown) {
            console.log("in error");
              console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
          }      
  });

}


addToMyLessons = function(catid) {      
  
  $.ajax({
          type : "post",
          data : {
              'action': 'add_to_my_lessons',
              'cat_id': catid,                           
          },          
          url: ajaxurl,          
          success    : function(data){                                        
              //console.log("in success");
              //console.log(data);
              if (data==1) {
                $('#btn_add_'+catid).hide();
                $('#btn_rm_'+catid).show();                
              }
              
          },
          error     : function(jqXHR, textStatus, errorThrown) {
            console.log("in error");
              console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
          }      
  });
}

removeFromMyLessons = function(catid) {
  $.ajax({
          type : "post",
          data : {
              'action': 'remove_from_my_lessons',
              'cat_id': catid,                           
          },          
          url: ajaxurl,          
          success    : function(data){                                        
              //console.log("in success");
              //console.log(data);
              if (data==1) {
                $('#btn_add_'+catid).show();
                $('#btn_rm_'+catid).hide();                
              }
              
          },
          error     : function(jqXHR, textStatus, errorThrown) {
            console.log("in error");
              console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
          }      
  });
}

hideCat = function(catid,spanID) {
    $("#catbox_"+catid).hide();
    var myLessonsNum = parseInt($("#"+spanID).text());
    myLessonsNum--;    
    $("#"+spanID).text(myLessonsNum);
}
    
function profile_to_mob(){
    if($(window).width() < 768-17){
        $('.sidebar .menu').prepend($('.menu-top'));
    }else{
        $('.site-header .navbar-header').append($('.menu-top'));
    }
}
    
 //equal heights for div's http://stackoverflow.com/a/11688385/2721050
function equal_heights(){
        $('.product_list').each(function(){  
         highestBox1 = 0;
           $('.category_square_content', this).each(function(){
               if($(this).height() > highestBox1){
                    highestBox1 = $(this).height(); 
               } else{
                   $(this).css('height','auto');
               }
                 
           });  
            
            $(this).find('.category_square_content').height(highestBox1);
            $(this).find('.category_square_content .bottom_cont').css('position','absolute');
           
        
          highestBox2 = 0;
            $('.category_single', this).each(function(){

               if($(this).height() > highestBox2) {
                   highestBox2 = $(this).height();
               }else{
                   $(this).css('height','auto');
               }
                   
           });  
           $(this).find('.category_single').height(highestBox2);

       });  
}    
    
function hero_height(){
    var bgImgHeight= $('.home .hero_image img.bgImg').height();
    $('.home .hero_image').height(bgImgHeight);
}
    
    
 
 $(document).ready(function(){    
    
    $("a[id^='btn_add_']").click(function(e){ e.stopPropagation(); });
    $("a[id^='btn_rm_']").click(function(e){ e.stopPropagation(); });
     
     //menu icons
     $('.tachometer').prepend('<i class="fa fa-tachometer"></i>');
     $('.library').prepend('<i class="icon-library-icon"></i>');
     $('.microphone').prepend('<i class="fa fa-microphone"></i>');
     $('.bookmark').prepend('<i class="fa fa-bookmark"></i>');
     $('.cog').prepend('<i class="fa fa-cog"></i>');
     $('.question').prepend('<i class="fa fa-question-circle"></i>');
     
     
     //mobile side menu
     $('.navbar-collapse.collapse').css('visibility','visible');
     $('.navbar-collapse.collapse').css('display','block');
     
     function handler1() {
         if(sCurLang == "he_IL"){
             var direction1 = "left";
             var margin_direction1 = "margin-left";
             var direction2 = "right";
             var margin_direction2 = "margin-right";
         }else{
             var direction1 = "right";
             var margin_direction1 = "margin-right";
             var direction2 = "left";
             var margin_direction2 = "margin-left";
         }
         
         
         $('.navbar-collapse.collapse').css(direction1,'0');
         $('.navbar-toggle').css(margin_direction1,'235px');
         $('.drop').css(direction1,'0');
         $('.archive_cont').css(direction2,'-220px');
         $('.cat_sing').css(direction2,'-235px');
         
             
            if($(window).width() < 500-17){
                 $('.site-branding').toggle();
             }
         
         $(this).one("click", handler2);
    }
    function handler2() {
         if(sCurLang == "he_IL"){
             var direction1 = "left";
             var margin_direction1 = "margin-left";
             var direction2 = "right";
             var margin_direction2 = "margin-right";
         }else{
             var direction1 = "right";
             var margin_direction1 = "margin-right";
             var direction2 = "left";
             var margin_direction2 = "margin-left";
         }
        
         $('.navbar-collapse.collapse').css(direction1,'-220px');
         $('.navbar-toggle').css(margin_direction1,'15px');
         $('.drop').css(direction1,'-220px');
         $('.archive_cont').css(direction2,'0px');
         $('.cat_sing').css(direction2,'0');
        
            if($(window).width() < 500-17){
                 $('.site-branding').toggle();
             }
        
         $(this).one("click", handler1);
    }
     
     
    $(".navbar-toggle").one("click", handler1);
     
     //
     var pageHeight = $(window).height();
     $('.drop .menu').css('height',pageHeight+61+'px');
     
     //
     profile_to_mob();
     
     //clickble divs - - - - - - - - - - - -
     $(".drop .menu li").click(function(){
     window.location=$(this).find("a").attr("href");
     return false;
     });
     
     
     $(".previous_post_link,.next_post_link").click(function(){
     window.location=$(this).find("a").attr("href");
     return false;
     });
     
     
     
     //ajax
     /*
     var page = 1;
     var loading = true;
     var $window = $(window);
     var $content = $('.product_list');
     
      $(".image_category").on('click', function() {
         $.ajax({
          type : "post",
          data : {order: "asc"},
          dataType : "html",     
          url: ourPhpVariables.ajaxurl,
          beforeSend : function(){
          },
          success    : function(data){
             
               $data = $(data);
                $data.hide();
               console.log($data);
                $content.append($data);
                 $data.fadeIn(500);
          },
          error     : function(jqXHR, textStatus, errorThrown) {
              alert(jqXHR + " :: " + textStatus + " :: " + errorThrown);
          }            
        });
     });
     */
      
     //
     
     
     //add body classes
     if($('.library-page').length > 0){
         $('body').addClass('library-page');
     }
    
     //Bootstrap Tab Collapse
     $('.nav.nav-tabs').tabCollapse();
     
     $('.category_square').click(function(){
         window.location = $(this) .find('h2 a').attr('href')
     });
     
     hero_height();
    
     
  //end of document).ready function
 });  
 
 $( window ).load( function(){
 	
    equal_heights();
     
    //fade in stuff
    $('.cat_sing ').addClass('on');
    $('.categories').addClass('on');
    $('.navbar .menu-top').addClass('on')
    $('.cat_sing ').find('#spinner').fadeOut();
    $('#spinner').fadeOut();
     
 	
     $('.selectpicker').selectpicker({
      style: 'null',
      size: false,
      showIcon:false
    });
     
    // 
    $('.selects').fadeIn('slow');
     
     //
     var achievements_height = $('.achievements_singles').height();
     $('#donut-chart svg').height(achievements_height);
     
      //
      $('.email_field_cont').append($('.fa-check-circle'));
     
     //
     $(".table_schedule_cont").mCustomScrollbar({
             axis:"x" // horizontal scrollbar
     });
     
     hero_height();
     
//end of window.load function
 });
    
 $( window ).resize(function() {
     
     profile_to_mob();
     equal_heights();
     hero_height();
     
   //end of window.resize function
 });    
    
//
$( document ).ajaxComplete(function() {
    equal_heights();
});
    
 
})(jQuery);