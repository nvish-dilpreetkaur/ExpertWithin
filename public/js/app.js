
    var swiper = new Swiper('.swiper-container', {
        slidesPerView: 3,
        spaceBetween: 10,
        pagination: {
          el: '.swiper-pagination',
          clickable: true,
          type: 'fraction',
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
          },
      });

        if($(".fixme"). length > 0){ 
            var fixmeTop = $('.fixme').offset().top - 70;
         }
        $(window).scroll(function() {
        var currentScroll = $(window).scrollTop();
        if (currentScroll >= fixmeTop) {
        $('.fixme').css({
            position: 'fixed',
            top: '4rem',
            'width':'18.75rem'
        });
        } else {
        $('.fixme').css({
            position: 'static',
            width:'100%'
        });
        }
    });

    if($(".fixme-rite-sec"). length > 0){ 
     var fixmeTopRightSec = $('.fixme-rite-sec').offset().top - 90;
    }

    $(window).scroll(function() {
    var currentScrollRite = $(window).scrollTop();
    if (currentScrollRite >= fixmeTopRightSec) {
    $('.fixme-rite-sec').css({
        position: 'fixed',
        top: '4rem',
        width:'17rem'
        // 'max-width':'21rem'
    });
    } else {
    $('.fixme-rite-sec').css({
        position: 'static',
        width:'100%'
    });
    }
});


$(document).on('keyup change','.frminput', function() {
	var attr_name =$(this).attr('name');
	var val = $(this).val();
	if(val != '') {
		$('#'+attr_name+'-error').html('');
		$('#'+attr_name+'-error').css('display','none');
	}
});

$(document).on('change','#focus_area', function() {
	$('#focus_area-error').html('');
	$('#focus_area-error').css('display','none');
});


/* allow only decimals on a Input element*/
$(document).on("keypress",".inp-num", function(e){		
	if ((e.which < 48 || e.which > 57) && e.which != 8 && e.which != 0) {
		e.preventDefault();
	}
});

$('.nonzero').keyup(function(e){ 
	if (this.value.length == 1 && e.which == 48 ){
	   $(this).val('');
       return false;
   }
});

/* allow only numbers and commas on a Input element*/
$(document).on("keypress",".inp-numcomma", function(e){		
	 if ((e.which < 48 || e.which > 57) && e.which != 8 && e.which != 0) {
		e.preventDefault();
	}

});



/* restrict hyphens and spaces*/
$(document).on("keypress",".nohyphen", function(e){
	
		var name = $(this).val();
        var dname_without_space = name.replace(/ /g, "");
		var name_without_special_char = dname_without_space.replace(/[^a-zA-Z 0-9]+/g, "");
		$(this).val(name_without_special_char);

});

//FOR DATE FORM - ON CREATE - OPPORTUNITY
var date = new Date();
var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());


var optComponent = {
format: 'mm/dd',
container: '#create-oppor-dates',
orientation: 'auto',
todayHighlight: true,
autoclose: true
};


// COMPONENT
 if($("#startDate"). length > 0){ 
	$( '#startDate' ).datepicker( optComponent );
 }
 if($("#endDate"). length > 0){ 
	$( '#endDate' ).datepicker( optComponent );
 }
 if($("#applyBefore"). length > 0){ 
	$( '#applyBefore' ).datepicker( optComponent );
 }

// ===================================
//  'setDate', today 
if( $("#startDate"). length > 0 ){ 
	$( '#startDate' ).datepicker().on('changeDate', function(e) {
	  $("#start_date_frmt").html(e.format("D, M dd, yyyy"));
	  $('input#start_date').val(e.format("yyyy-mm-dd 00:00:00"));
	});
}
if( $("#endDate"). length > 0 ){ 
	$( '#endDate' ).datepicker().on('changeDate', function(e) {
	  $("#end_date_frmt").html(e.format("D, M dd, yyyy"));
	  $('input#end_date').val(e.format("yyyy-mm-dd 00:00:00"));
	});
}
if( $("#applyBefore"). length > 0 ){ 
	$( '#applyBefore' ).datepicker().on('changeDate', function(e) {
	  $("#apply_before_frmt").html(e.format("D, M dd, yyyy"));
	  $('input#apply_before').val(e.format("yyyy-mm-dd 00:00:00"));
	});
}

////

//========AVATAR UPLOAD============

function readURL(input) {
  if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
          $('#imagePreview').css('background-image', 'url('+e.target.result +')');
          $('#imagePreview').hide();
          $('#imagePreview').fadeIn(650);
      }
      reader.readAsDataURL(input.files[0]);
      $('.pro_img').removeClass('fas fa-user-circle fa-9x');
  }
}
$("#imageUpload").change(function() {
  readURL(this);
});

//========AVATAR UPLOAD END============//


    $(document).ready(function(){
        $(".header-search-box").click(function(){
            $(".search-slide-down-container").addClass("visible");
            $(".main-content-container").addClass("invisible");
            $(".container-fluid").removeClass("for-container-fluid");
            $("body").addClass("for-scroll-function");
        });
        $(".search-close-button").click(function(){
            $(".search-slide-down-container").removeClass("visible");
            $(".main-content-container").removeClass("invisible");
            $(".container-fluid").addClass("for-container-fluid");
            $("body").removeClass("for-scroll-function");
        });

        
        // Slides
        var currentSlide, previousSlide, nextSlide;
        // Slides animation properties
        var opacity, left, scale; 
        // Check if the slide animation is happening (BUG fix)
        var inTransition = false;
        // Bootstrap design
       //$('body').bootstrapMaterialDesign();
        /** Click functions **/
        // Previous button
        $('#prev-button').click(function(e) { 
           if (inTransition) { return; }
          
           // Current & previous step
           var current = $('.step-progress-bar').find('.current');
           var prev = current.prev();
           // Refresh current step
           if(current && prev && prev.length > 0) {
             current.removeClass('current'); 
             prev.removeClass('success');
             prev.addClass('current'); 
             
             // Show prev slide
             prevSlideFn();
           }
        });
        // Next button
        $('#next-button, .for-step-bar__titles ul li, .for-step-bar__titles ul li a').click(function(e) {
          if (inTransition) { return; }
          
          var current = $('.step-progress-bar').find('.current');
          var next = current.next(); 
          
          // Current to success
          current.removeClass('current');
          // Timeout giving time to the animation to render
          setTimeout(function() { current.addClass('success'); }, 0);
          
          // Disabled to current 
          if(next && next.length > 0) {
            next.addClass('current'); 
            // Show next slide
            nextSlideFn();    
          }
        });
        
        function nextSlideFn() {  
           inTransition = true;
           currentSlide = $('.current-slide');
           nextSlide = currentSlide.next(); 
          
           nextSlide.show(); 
           currentSlide.animate({opacity: 0}, {
             step: function(now, mix) {
               scale = 1 - (1 - now) * 0.2;
               left = (now * 100) + '%'; 
               opacity = 1 - now;
               currentSlide.css({
                 '-webkit-transform': 'scale(' + scale + ')',
                 '-ms-transform': 'scale(' + scale + ')',
                 'transform': 'scale(' + scale + ')'
               }); 
               nextSlide.css({
                 '-webkit-transform': 'translateX(' + left + ')', 
                 '-ms-transform': 'translateX(' + left + ')', 
                 'transform': 'translateX(' + left + ')', 
                 'opacity': opacity});
             },
             duration: 250,
             complete: function() { 
               currentSlide.hide();
               currentSlide.removeClass('current-slide'); 
               nextSlide.addClass('current-slide'); 
               nextSlide.css({'position': 'relative'});
               inTransition = false;
             },
             easing: 'linear' 
           });
        }
        
        function prevSlideFn() {
           inTransition = true;
           currentSlide = $('.current-slide');
           previousSlide = currentSlide.prev(); 
          
           previousSlide.show(); 
           currentSlide.css({'position': 'absolute'});
           currentSlide.animate({opacity: 0}, {
             step: function(now, mix) {
               scale = 0.8 + (1 - now) * 0.2; 
               left = ((1 - now) * 50) + '%';
               opacity = 1 - now;
               currentSlide.css({
                 '-webkit-transform': 'translateX(' + left + ')',
                 '-ms-transform': 'translateX(' + left + ')',
                 'transform': 'translateX(' + left + ')'
               });
               previousSlide.css({
                 '-webkit-transform': 'scale(' + scale + ')', 
                 '-ms-transform': 'scale(' + scale + ')', 
                 'transform': 'scale(' + scale + ')', 
                 'opacity': opacity
               });
             },
             duration: 250,
             complete: function() { 
               currentSlide.hide();
               currentSlide.removeClass('current-slide');
               previousSlide.addClass('current-slide'); 
               previousSlide.css({'position': 'relative'});
               inTransition = false;
             },
             easing: 'linear'
           });
        }

        //MinusPlus - COins For Create - Opportunity Form

        $('.minus').click(function () {
            var $input = $(this).parent().find('input');
            var count = parseInt($input.val()) - 1;
            count = count < 1 ? 1 : count;
            $input.val(count);
            $input.change();
            return false;
        });
        $('.plus').click(function () {
            var $input = $(this).parent().find('input');
            $input.val(parseInt($input.val()) + 1);
            $input.change();
            return false;
        });

//FOR SELECT2 DROP-DOWN

            $('.nav-link.menuIcon').click(function(){
                $(this).find('#nav-icon').toggleClass('open');
                var getWidth = $(".rightNav").innerWidth();
                if($(this).find('#nav-icon').hasClass('open')){
                    $(".rightNav").css('right','0' , 200);
                }else{
                    $(".rightNav").removeAttr("style" , 200);
                }
            });

            $( ".dropDownLink" ).each(function(index) {
                $(this).on("click", function(){
                    $(this).next('.dropDownListWrap').slideToggle();
                });
            });


            $('.multiple-pills-dropdown').select2();


//FOR CREATE OPPORTUNITY CARDS (CARD NUMBER 3) TABS
		 

            $("#tile-1 .nav-tabs a").click(function() {
						var position = $(this).parent().position();
						var width = $(this).parent().width();
						$("#tile-1 .slider").css({"left":+ position.left,"width":'34%'});
					});
					var actWidth = $("#tile-1 .nav-tabs").find(".active").parent("li").width();
					var actPosition = $("#tile-1 .nav-tabs .active").position();
					if($("#tile-1 .slider"). length > 0){ 
					 $("#tile-1 .slider").css({"left":+ actPosition.left,"width": actWidth});
                    }
                    


//FOR DROPDOWN TOGGLE

                $('.dropdown-for__user-infor-card').click(function(event){
                    event.stopPropagation();
                    $( ".dropdown-for__user-infor-card--view" ).toggle();
                });
                $(".dropdown-for__user-infor-card--view").on("click", function (event) {
                    event.stopPropagation();
                });


			});//Document Ready ClOSED
	

        $(document).on("click", function () {
            $(".dropdown-for__user-infor-card--view").hide();
        });
