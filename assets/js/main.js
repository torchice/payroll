/*-----------------------------------------------------------------------------------*/
/* 		Mian Js Start
/*-----------------------------------------------------------------------------------*/
$(document).ready(function($) {
    "use strict"
    /*-----------------------------------------------------------------------------------*/
    /*		STICKY NAVIGATION
    /*-----------------------------------------------------------------------------------*/
    $(".sticky").sticky({topSpacing:0});

    /*-----------------------------------------------------------------------------------*/
    /* 	LOADER
    /*-----------------------------------------------------------------------------------*/
    $("#loader").delay(500).fadeOut("slow");

    /*-----------------------------------------------------------------------------------*/
    /*  FULL SCREEN
    /*-----------------------------------------------------------------------------------*/
    $('.full-screen').superslides({});

    /*-----------------------------------------------------------------------------------*/
    /*    Parallax
    /*-----------------------------------------------------------------------------------*/
    jQuery.stellar({
        horizontalScrolling: false,
        scrollProperty: 'scroll',
        positionProperty: 'position',
    });
    /*----- cart-plus-minus-button -----*/
    $(".pizza-add-sub").append('<div class="plus qty-pizza">+</div><div class="mines qty-pizza">-</div>');
    $(".qty-pizza").on("click", function() {
        var $button = $(this);
        var oldValue = $button.parent().find("input").val();
        if ($button.text() == "+") {
         	var newVal = parseFloat(oldValue) + 1;
        } else {
            // Don't allow decrementing below zero
        	if (oldValue > 0) {
        		var newVal = parseFloat(oldValue) - 1;
        	} else {
        		newVal = 0;
        	}
        }
        $button.parent().find("input").val(newVal);
    });

    /*-----------------------------------------------------------------------------------*/
    /* 		Parallax
    /*-----------------------------------------------------------------------------------*/
    $('.images-slider').flexslider({
        animation: "fade",
        controlNav: "thumbnails"
    });

    /*-----------------------------------------------------------------------------------*/
    /* 	GALLERY SLIDER
    /*-----------------------------------------------------------------------------------*/
    $('.block-slide').owlCarousel({
        loop:true,
        margin:30,
        nav:true,
    	navText: ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
        responsive:{
            0:{
                items:1
            },
            600:{
                items:2
            },
            1000:{
                items:4
            }
        }
    });

    /*-----------------------------------------------------------------------------------*/
    /* 	SLIDER REVOLUTION
    /*-----------------------------------------------------------------------------------*/
    jQuery('.tp-banner').show().revolution({
    	dottedOverlay:"none",
    	delay:10000,
    	startwidth:1170,
    	startheight:820,
    	navigationType:"",
    	navigationArrows:"solo",
    	navigationStyle:"preview4",
    	parallax:"mouse",
    	parallaxBgFreeze:"on",
    	parallaxLevels:[7,4,3,2,5,4,3,2,1,0],
    	keyboardNavigation:"on",
    	shadow:0,
    	fullWidth:"on",
    	fullScreen:"off",
    	shuffle:"off",
    	autoHeight:"off",
    	forceFullWidth:"on",
    	fullScreenOffsetContainer:""
    });

    /*-----------------------------------------------------------------------------------*/
    /* 	TESTIMONIAL SLIDER
    /*-----------------------------------------------------------------------------------*/
    $(".single-slide").owlCarousel({
        items : 1,
    	autoplay:true,
    	loop:true,
    	autoplayTimeout:5000,
    	autoplayHoverPause:true,
    	singleItem	: true,
        navigation : true,
    	navText: ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
    	pagination : true,
    	animateOut: 'fadeOut'
    });
    $('.item-slide').owlCarousel({
        loop:true,
        margin:30,
        nav:false,
    	navText: ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
        responsive:{
            0:{
                items:1
            },
            400:{
                items:2
            },
    		900:{
                items:3
            },
            1200:{
                items:4
            }
        }
    });

    /*-----------------------------------------------------------------------------------
        Animated progress bars
    /*-----------------------------------------------------------------------------------*/
    $('.progress-bars').waypoint(function() {
        $('.progress').each(function(){
            $(this).find('.progress-bar').animate({
                width:$(this).attr('data-percent')
            },100);
        });},
    	{
            offset: '100%',
            triggerOnce: true
        }
    );

    /*-----------------------------------------------------------------------------------*/
    /* 		Active Menu Item on Page Scroll
    /*-----------------------------------------------------------------------------------*/
    // $(window).scroll(function(event) {
    //     Scroll();
    // });
    // $('.scroll a').on('click',function() {
    //     $('html, body').animate({scrollTop: $(this.hash).offset().top -0}, 1000);
    //     return false;
    // });
    // // User define function
    // function Scroll() {
    //     var contentTop      =   [];
    //     var contentBottom   =   [];
    //     var winTop          =   $(window).scrollTop();
    //     var rangeTop        =   5;
    //     var rangeBottom     =   1000;
    //     $('nav').find('.scroll a').each(function(){
    //         contentTop.push( $( $(this).attr('href') ).offset().top);
    //     	contentBottom.push( $( $(this).attr('href') ).offset().top + $( $(this).attr('href') ).height() );
    //     })
    //     $.each( contentTop, function(i){
    //         if ( winTop > contentTop[i] - rangeTop ){
    //             $('nav li.scroll')
    //     	   .removeClass('active')
    //     	   .eq(i).addClass('active');
    //         }
    //     })
    // };
});

/*-----------------------------------------------------------------------------------*/
/*    CONTACT FORM
/*-----------------------------------------------------------------------------------*/
// function checkmail(input){
//   var pattern1=/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
//   	if(pattern1.test(input)){ return true; }else{ return false; }}
//     function proceed(){
//     	var name = document.getElementById("name");
// 		var email = document.getElementById("email");
// 		var company = document.getElementById("company");
// 		var web = document.getElementById("website");
// 		var msg = document.getElementById("message");
// 		var errors = "";
// 		if(name.value == ""){
// 		name.className = 'error';
// 	  	  return false;}
// 		  else if(email.value == ""){
// 		  email.className = 'error';
// 		  return false;}
// 		    else if(checkmail(email.value)==false){
// 		        alert('Please provide a valid email address.');
// 		        return false;}
// 		    else if(company.value == ""){
// 		        company.className = 'error';
// 		        return false;}
// 		   else if(web.value == ""){
// 		        web.className = 'error';
// 		        return false;}
// 		   else if(msg.value == ""){
// 		        msg.className = 'error';
// 		        return false;}
// 		   else
// 		  {
// 	$.ajax({
// 		type: "POST",
// 		url: "php/submit.php",
// 		data: $("#contact_form").serialize(),
// 		success: function(msg){
// 		//alert(msg);
// 		if(msg){
// 			$('#contact_form').fadeOut(1000);
// 			$('#contact_message').fadeIn(1000);
// 				document.getElementById("contact_message");
// 			 return true;
// 		}}
// 	});
// }};