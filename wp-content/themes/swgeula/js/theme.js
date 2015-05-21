var filterBoxes;
var addToMyLessons;
var removeFromMyLessons;
var hideCat;
var setSchedule;

function goToLogin() {
  window.location.href=gbLocal?'/geula/my-account/sign-in/':'/my-account/sign-in/';
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

setSchedule = function(timestamp,catid) {
  if (catid==-1) catid = getNextCatToSchedule();

  $.ajax({
          type : "post",
          data : {
              'action': 'set_schedule',
              'cat_id': catid,     
              'time_stamp': timestamp,                           
          },          
          url: ajaxurl,          
          success    : function(data){                                        
              //console.log("in success");
              console.log(data);              
              $('#dp1').hide();                                                         
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
        $('.drop .menu').prepend($('.menu-top'));
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
    
 
 $(document).ready(function(){
     
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
         $('.navbar-collapse.collapse').css('left','0');
         $('.navbar-toggle').css('margin-left','235px');
         $('.drop').css('left','0');
         $('.archive_cont').css('right','-220px');
         $('.cat_sing').css('right','-235px');
         
             
            if($(window).width() < 500-17){
                 $('.site-branding').toggle();
             }
         
         $(this).one("click", handler2);
    }
    function handler2() {
         $('.navbar-collapse.collapse').css('left','-220px');
         $('.navbar-toggle').css('margin-left','15px');
         $('.drop').css('left','-220px');
         $('.archive_cont').css('right','0px');
         $('.cat_sing').css('right','0');
        
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
     
//end of window.load function
 });
    
 $( window ).resize(function() {
     
     profile_to_mob();
     equal_heights();
     
   //end of window.resize function
 });    
 
})(jQuery);