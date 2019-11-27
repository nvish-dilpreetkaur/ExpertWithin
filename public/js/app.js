
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
            top: '5rem',
            'width':'21.7rem'
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
        top: '5rem',
        width:'22.1rem'
        // 'max-width':'21rem'
    });
    } else {
    $('.fixme-rite-sec').css({
        position: 'static',
        width:'100%'
    });
    }
});

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
    });


 