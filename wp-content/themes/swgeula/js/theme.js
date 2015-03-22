(function($) {
    
//global vars
    
    
//global functions    
    
function profile_to_mob(){
    if($(window).width() < 768-17){
        $('.drop .menu').prepend($('.menu-top'));
    }else{
        $('.site-header .navbar-header').append($('.menu-top'));
    }
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
     
     //clickble li in sidebar
     $(".drop .menu li").click(function(){
     window.location=$(this).find("a").attr("href");
     return false;
     });
    
  //end of document).ready function
 });  
 
 $( window ).load( function(){
 	
 	//end of window.load function
 });
    
 $( window ).resize(function() {
     
      //
     profile_to_mob();
     
   //end of window.resize function
 });    
 
})(jQuery);