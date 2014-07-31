


					function validateEmail(email) { 
						var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
						return re.test(email);
					}
					function checkURL(value) {
						var urlregex = new RegExp("^(http:\/\/www.|https:\/\/www.|ftp:\/\/www.|www.){1}([0-9A-Za-z]+\.)");
						if (urlregex.test(value)) {
							return (true);
						}
						return (false);
					}
//Menu
function mainmenu(){
	$("ul.menu ul ").css({display: "none"}); // Opera Fix
	$("ul.menu li").hover(function(){
		$(this).find('ul:first').css({visibility: "visible",display: "none"}).show(200);
	},function(){
		$(this).find('ul:first').css({visibility: "hidden"});
	});
}

jQuery(document).ready(function($){


					$('ul.menu li a').click(function(){
						var txtasb=$(this).text();
						if(txtasb==' Log In '){
							showlogin($(this));
							return false;
						}
					})
					$('input.url').blur(function(){
						if(!checkURL($(this).val())){
							alert('Url Website harus valid');
							$(this).val('');
							$(this).focus();
						}
					})
					$('input.email').blur(function(){
						if(!validateEmail($(this).val())){
							alert('email harus valid');
							$(this).val('');
							$(this).focus();
						}
					})
					
					$('input.kodePos,input.isNumber').keyup(function(){
						if(isNaN($(this).val())){
							alert('harus angka');
							$(this).val('');
							$(this).focus();
						}
					});

				
	mainmenu();		
	
	$("ul.menu li:has(ul)").each(function(){
		$(this).addClass("hasSubmenu");
	});		
	
	/*Expand Toggle*/
	$('.expand-box').hide();
	$('a.expand').click(function() {
		if($(this).hasClass("control-open")){
			$(this).removeClass("control-open");
		}else{
			$(this).addClass("control-open");
		}	
	$('.expand-box').toggle(400);
		return false;
	});
	
	
	//Tooltip
	if($(".tooltip-bottom").length){
		$(".tooltip-bottom").each(function(){
			$(this).tipTip({maxWidth: "auto"});
		});
	}

	if($(".tooltip-top").length){		
		$(".tooltip-top").each(function(){
			$(this).tipTip({maxWidth: "auto",defaultPosition: "top"});
		});
	}
	if($(".tooltip-left").length){
		$(".tooltip-left").each(function(){
			$(this).tipTip({maxWidth: "auto",defaultPosition: "left"});
		});
	}
	
	if($(".tooltip-right").length){
		$(".tooltip-right").each(function(){
			$(this).tipTip({maxWidth: "auto",defaultPosition: "right"});	
		});
	}
	
	
	
	//Gallery page isotope	
	var $container = $('.portfolio-container');
	if($container.length){
		$($container).find("> div").each(function(){
			$(this).addClass("column all-sort");
		});
		
		$container.isotope({
			filter: '*',
			animationOptions: { duration: 750, easing: 'linear', queue: false  }
		});
		
		if($("div#sorting-container").length){
			$("div#sorting-container a").click(function(){
				$("div#sorting-container a").removeClass("active_sort");
				var selector = $(this).attr('data-filter');
				$(this).addClass("active_sort");
				$container.isotope({ filter: selector, animationOptions: { duration: 750, easing: 'linear',  queue: false }});
				return false;
			});		
		}
	}
	
	if($("div.portfolio-container").length) {
		$(window).smartresize(function(){
	  		applyIso();
		});
	}
	
	function applyIso(){
		$("div.portfolio-container").css({overflow:'hidden'}).isotope({itemSelector : '.isotope-item'});
	};
	
		
	/*Testimonial Carousel*/
	if($(".testimonial-carousel").length){
		$('ul.testimonial-carousel').jcarousel({ scroll: 1 });
	}
	
	/*Portfolio Carousel*/
	if($(".portfolio-carousel").length){
		$('ul.portfolio-carousel').jcarousel({ scroll: 1 });
	}
	
	/*Clients Carousel*/
	if($(".clients-carousel").length){
		$('ul.clients-carousel').jcarousel({ scroll: 1 });
	}
	
	/**
	 * Tabs Shortcodes
	 */
	if($('ul.tabs-frame').length > 0) $('ul.tabs-frame').tabs('> .tabs-frame-content');
	
	if($('.tabs-vertical-frame').length > 0){
		$('.tabs-vertical-frame').tabs('> .tabs-vertical-frame-content');
		
		$('.tabs-vertical-frame').each(function(){
			$(this).find("li:first").addClass('first').addClass('current');
			$(this).find("li:last").addClass('last');
		});

		$('.tabs-vertical-frame li').click(function(){ 
			$(this).parent().children().removeClass('current');
			$(this).addClass('current');
		});
	}
	/*Tabs Shortcode Ends*/
	
	
	/* 
	 * Toggle shortcode
	 */
	$('.toggle').toggle(function(){
		$(this).addClass('active');
	}, function () {
		$(this).removeClass('active');
	});

	$('.toggle').click(function(){
		$(this).next('.toggle-content').slideToggle();
	});
	
	$('.toggle-frame-set').each(function(i) {
		var $this = $(this),
		    $toggle = $this.find('.toggle-accordion');
		
		$toggle.click(function(){
			if( $(this).next().is(':hidden') ) {
				$this.find('.toggle-accordion').removeClass('active').next().slideUp();
				$(this).toggleClass('active').next().slideDown();
			}
			return false;
		});
	});
	/* Toggle Shortcode end*/
	
		/* Tiny Nav */		
	$("#top-menu ul.menu").tinyNav({
	  active: 'current_page_item' // String: Set the "active" class
	});


	
});

$(document).ready(function() {
	$('div.login-window').click(function() {
		
                //Getting the variable's value from a link 
		var loginBox = $(this).attr('href');

		//Fade in the Popup
		$(loginBox).fadeIn(300);
		
		//Set the center alignment padding + border see css style
		var popMargTop = ($(loginBox).height() + 24) / 2; 
		var popMargLeft = ($(loginBox).width() + 24) / 2; 
		
		$(loginBox).css({ 
			'margin-top' : -popMargTop,
			'margin-left' : -popMargLeft
		});
		
		// Add the mask to body
		$('body').append('<div id="mask"></div>');
		$('#mask').fadeIn(300);
		
		return false;
	});
	
	// When clicking on the button close or the mask layer the popup closed
	$('a.close, #mask').live('click', function() { 
	  $('#mask , .login-popup').fadeOut(300 , function() {
		$('#mask').remove();  
	}); 
	return false;
	});
});

$.fn.scrollintoview = function(options){
	//setting default value jika parameter tidak dilewatkan
	var    defaults = {
	speed:'1100'
	},
	settings = $.extend({}, defaults, options);
	var element = this;  //"this" adalah DOM object
	
	$('html, body').animate({
		scrollTop: $(element).offset().top
	}, parseInt(settings.speed));
	return false;
};



