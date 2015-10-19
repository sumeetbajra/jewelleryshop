/**
 * Theme functions file
 *
 * Contains handlers for navigation, accessibility, header sizing
 * footer widgets and Featured Content slider
 *
 */

 var shopera = {};

jQuery(document).ready(function($) {
	( function( $ ) {
		var body    = $( 'body' ),
			_window = $( window );

		$(window).scroll(function () {
			if ($(this).scrollTop() > 100) {
				$('.scroll-to-top').fadeIn();
			} else {
				$('.scroll-to-top').fadeOut();
			}
		});

		$('.scroll-to-top').click(function () {
			$('body,html').animate({
				scrollTop: 0
			}, 800);
			return false;
		});

		// Shrink header on scroll down
		if($('.site-header').length > 0) {
			var y = $(window).scrollTop();
			var padding_element = $('.slider');

			if ( padding_element.length === 0 ) {
				padding_element = $('#main');
			}

			if($(window).width() > 979) {
				masthead_height = $('.site-header').height();
				masthead_top    = $('.site-header').offset().top+$('.site-header').height()+50; 

				if( y > masthead_top ) { 
					$('.site-header').addClass('fixed'); 
					padding_element.css('padding-top', (masthead_height)+'px'); 
				}

				if( y > 150 ) {
					$('.site-header').addClass('shrink');
					$('body').addClass('sticky_header_active');
				} else {
					$('.site-header').removeClass('shrink');
					$('body').removeClass('sticky_header_active');
				}
				
				// Shrink menu on scroll
				var didScroll = false;
				$(window).scroll(function() {
					didScroll = true;
				});

				setInterval(function() {
					if ( didScroll ) {
						didScroll = false;
						y = $(window).scrollTop();

						if(y > masthead_top){ 
							$('.site-header').addClass('fixed'); 
							padding_element.css('padding-top', (masthead_height)+'px'); 
						}
						else{ 
							$('.site-header').removeClass('fixed'); 
							padding_element.css('padding-top', ''); 
						}
						if(y > 500){  
							$('.site-header').addClass('shrink'); $('body').addClass('sticky_header_active'); 
						}
						else{ 
							$('.site-header').removeClass('shrink'); $('body').removeClass('sticky_header_active'); 
						}
					}
				}, 50);
			} else {
				$('.site-header').removeClass('shrink');
				$('.site-header').removeClass('fixed');
			}

		} else {
			$('#page').addClass('static-header'); 
		}

		$('.search-form-submit').click(function() {
			if ( $(this).hasClass('active') ) {
				if ( $(this).parent().find('form .search-field').val() != '' ) {
					$(this).css('color', '#333');
					$(this).parent().find('form').submit();
				} else {
					$(this).css('color', '#e5534c');
				}
			} else {
				$(this).parent().find('form').stop().fadeIn();
			}
			$(this).addClass('active');
		})

		jQuery('.testimonial-container').jcarousel({
			wrap: "circular",
			animation: {
				duration: 0
			}
		}).jcarouselAutoscroll({
			interval: 5000,
			target: '+=1',
			autostart: true
		}).on("jcarousel:scroll", function(event, carousel) {
			jQuery("#tbtestimonial-listing").parent().hide().fadeIn(700);
		});

		if ( jQuery('.testimonial-container').length ) {
			jQuery('.testimonial-container').css({'left': '-'+jQuery('.testimonial-container').offset().left+'px', 'width': jQuery(window).width()+'px'});
			jQuery('.in-content-testimonial').css({'width': jQuery(window).width()+'px'});
		};

		if ( jQuery('.brand-carousel-container').length ) {
			jQuery('.brand-carousel-container').jcarousel({
				wrap: "circular",
				animation: {
					duration: 0
				}
			}).jcarouselAutoscroll({
				interval: 3000,
				target: '+=1',
				autostart: true
			}).on("jcarousel:scroll", function(event, carousel) {
				jQuery(".brand-carousel-container").hide().fadeIn(700);
			});
			// jQuery('.brand-carousel-container').css({'left': '-'+jQuery('.brand-carousel-container').offset().left+'px', 'width': jQuery(window).width()+'px'});
		};

		jQuery(window).resize(function() {
			if ( jQuery('.testimonial-container').length ) {
				jQuery('.testimonial-container').css({'left': '-'+jQuery('.site-content').offset().left+'px', 'width': jQuery(window).width()+'px'});
				jQuery('.in-content-testimonial').css({'width': jQuery(window).width()+'px'});
			};
		});

		// Enable menu toggle for small screens.
		( function() {
			var nav = $( '#primary-navigation' ), button, menu;
			if ( ! nav ) {
				return;
			}

			button = nav.find( '.menu-toggle' );
			if ( ! button ) {
				return;
			}

			// Hide button if menu is missing or empty.
			menu = nav.find( '.nav-menu' );
			if ( ! menu || ! menu.children().length ) {
				button.hide();
				return;
			}

			$( '.menu-toggle' ).on( 'click.shopera', function() {
				nav.toggleClass( 'toggled-on' );
			} );
		} )();

		/*
		 * Makes "skip to content" link work correctly in IE9 and Chrome for better
		 * accessibility.
		 *
		 * @link http://www.nczonline.net/blog/2013/01/15/fixing-skip-to-content-links/
		 */
		_window.on( 'hashchange.shopera', function() {
			var element = document.getElementById( location.hash.substring( 1 ) );

			if ( element ) {
				if ( ! /^(?:a|select|input|button|textarea)$/i.test( element.tagName ) ) {
					element.tabIndex = -1;
				}

				element.focus();

				// Repositions the window on jump-to-anchor to account for header height.
				window.scrollBy( 0, -80 );
			}
		} );

		$( function() {

			/*
			 * Fixed header for large screen.
			 * If the header becomes more than 48px tall, unfix the header.
			 *
			 * The callback on the scroll event is only added if there is a header
			 * image and we are not on mobile.
			 */
			if ( _window.width() > 781 ) {
				var mastheadHeight = $( '#masthead' ).height(),
					toolbarOffset, mastheadOffset;

				if ( mastheadHeight > 48 ) {
					body.removeClass( 'masthead-fixed' );
				}

				if ( body.is( '.header-image' ) ) {
					toolbarOffset  = body.is( '.admin-bar' ) ? $( '#wpadminbar' ).height() : 0;
					mastheadOffset = $( '#masthead' ).offset().top - toolbarOffset;

					_window.on( 'scroll.shopera', function() {
						if ( ( window.scrollY > mastheadOffset ) && ( mastheadHeight < 49 ) ) {
							body.addClass( 'masthead-fixed' );
						} else {
							body.removeClass( 'masthead-fixed' );
						}
					} );
				}
			}

			// Focus styles for menus.
			$( '.primary-navigation, .secondary-navigation' ).find( 'a' ).on( 'focus.shopera blur.shopera', function() {
				$( this ).parents().toggleClass( 'focus' );
			} );
		} );
	} )( jQuery );
})

jQuery( document ).ajaxStop(function() {
	jQuery('.cart-contents .cart-items').click(function() {
		if ( jQuery(this).hasClass('active') ) {
			jQuery('.cart-content-list').stop().fadeOut();
		} else {
			jQuery('.cart-content-list').stop().fadeIn();
		}
		jQuery(this).toggleClass('active');
	});
});


// /*------------------------------------------------------------
//  * FUNCTION: Ajax Load Pages
//  *------------------------------------------------------------*/

// function ajaxLoadPages(){

// 	// if( shopera.ajaxEnabled === false ) { return; }


// 	var hashedLink;

// 	// Chrome Bug: triggers popstate on init page load.
// 	// Solution: define var and make it true on first popstate/push
// 	var popped = false;



// 	// Event: Link clicked
// 	jQuery('html').on('click','a',function(e) {
// 		var href = jQuery(this).attr('href');

// 		if( isExternal(href) ){
// 			return;
// 		}

// 		// assume that clicked link is hashed
// 		hashedLink = true;

// 		if (
// 			( !jQuery(this).is(".ab-item, .comment-reply-link, #cancel-comment-reply-link, .comment-edit-link, .wp-playlist-caption, .js-skip-ajax") ) &&
// 			( href.indexOf('#') == -1 ) &&
// 			( href.indexOf('wp-login.php') == -1 ) &&
// 			( href.indexOf('/wp-admin/') == -1 ) &&
// 			( href.indexOf('wp-content/uploads/') == -1 ) &&
// 			( jQuery(this).attr('target') != '_blank' )
// 		){
// 			e.preventDefault();
// 			popped = true;
// 			hashedLink = false;

// 			// change only main content and leave sidebar intact
// 			var pagination = jQuery(this).is('.page-numbers') ? true : false;
// 			push_state(href, pagination);
// 		}

// 	});



// 	// Event: Popstate - Location History Back/Forward
// 	jQuery(window).on('popstate',function(){
// 		// if hashed link, load native way
// 		// popped? don't trigger on init page load [chrome bug]
// 		if(!hashedLink && popped){
// 			ajaxLoadPage(location.href);
// 		}
// 		popped = true;
// 	});



// 	// Function: PushState and trigger ajax loader
// 	function push_state(href, pagination){
// 		history.pushState({page: href}, '', href);
// 		ajaxLoadPage(href, pagination);
// 	}



// 	// Function: Ajax Load Page
// 	function ajaxLoadPage(href, pagination) {

// 		jQuery('body').removeClass('ajax-main-content-loading-end ajax-content-wrapper-loading-end');
// 		if( shopera.xhr ){
// 			shopera.xhr.abort();
// 		}

// 		var timeStarted = 0;

// 		if( pagination ){
// 			// Classic pagination

// 			jQuery('body').addClass('ajax-main-content-loading-start');
// 			jQuery('body').removeClass('touchscreen-header-open'); // close header on touch devices

// 			timeStarted = new Date().getTime();

// 			shopera.xhr = jQuery.ajax({
// 				type: "GET",
// 				url: href,
// 				success: function(data, response, xhr){

// 					// Check if css animation had time to finish
// 					// before new page load animation starts
// 					var now = new Date().getTime();
// 					var timeDiff = now - timeStarted;
// 					if( timeDiff < 1000 ) {
// 						setTimeout( ajaxLoadPageCallback, (1000-timeDiff) );
// 					}else{
// 						ajaxLoadPageCallback();
// 					}

// 					function ajaxLoadPageCallback(){
// 						var $data = jQuery(data);

// 						// Update Page Title in browser window
// 						var pageTitle = $data.filter('title').text();
// 						document.title = pageTitle;

// 						jQuery('#main-content').html( $data.find('.main-content__inside') );

// 						scrollPageToTop();

// 						jQuery('#main-content').waitForImages(function(){
// 							jQuery('body').addClass('ajax-main-content-loading-end');
// 							jQuery('body').removeClass('ajax-main-content-loading-start');
// 							jQuery(document).trigger('shopera:ajaxPageLoad');
// 						});

// 						ajaxPushGoogleAnalytics(href);
// 					}
// 				},

// 				error: function(){
// 					jQuery('body').addClass('ajax-main-content-loading-end');
// 					jQuery('body').removeClass('ajax-main-content-loading-start');
// 				}
// 			});

// 		} else {
// 			// Page Navigation

// 			jQuery('body').addClass('ajax-content-wrapper-loading-start');
// 			jQuery('body').removeClass('touchscreen-header-open'); // close header on touch devices

// 			timeStarted = new Date().getTime();

// 			scrollPageToTop();

// 			shopera.xhr = jQuery.ajax({
// 				type: "GET",
// 				url: href,
// 				success: function(data, response, xhr){

// 					// Check if css animation had time to finish
// 					// before new page load animation starts
// 					var now = new Date().getTime();
// 					var timeDiff = now - timeStarted;
// 					if( timeDiff < 1000 ) {
// 						setTimeout( ajaxLoadPageCallback, (1000-timeDiff) );
// 					}else{
// 						ajaxLoadPageCallback();
// 					}

// 					function ajaxLoadPageCallback(){
// 						var $data = jQuery(data);

// 						// Update Page Title in browser window
// 						var pageTitle = $data.filter('title').text();
// 						document.title = pageTitle;

// 						jQuery('.site-main').html( $data.find('.main-content') );

// 						// jQuery('.site-main').waitForImages(function(){
// 						// 	jQuery('body').addClass('ajax-content-wrapper-loading-end');
// 						// 	jQuery('body').removeClass('ajax-content-wrapper-loading-start');
// 						// 	jQuery(document).trigger('shopera:ajaxPageLoad');
// 						// });
			
// 						jQuery('body').addClass('ajax-content-wrapper-loading-end');
// 						jQuery('body').removeClass('ajax-content-wrapper-loading-start');

// 					//	ajaxPushGoogleAnalytics(href);
// 					}
// 				},

// 				error: function(){
// 					jQuery('body').addClass('ajax-content-wrapper-loading-end');
// 					jQuery('body').removeClass('ajax-content-wrapper-loading-start');
// 				}
// 			});

// 		}
// 	}



// 	// Function: RegExp: Check if url external
// 	function isExternal(url) {
// 		var match = url.match(/^([^:\/?#]+:)?(?:\/\/([^\/?#]*))?([^?#]+)?(\?[^#]*)?(#.*)?/);
// 		if (typeof match[1] === "string" && match[1].length > 0 && match[1].toLowerCase() !== location.protocol) return true;
// 		if (typeof match[2] === "string" && match[2].length > 0 && match[2].replace(new RegExp(":("+{"http:":80,"https:":443}[location.protocol]+")?$"), "") !== location.host) return true;
// 		return false;
// 	}

// }
// jQuery(document).ready( ajaxLoadPages );

// /*------------------------------------------------------------
//  * FUNCTION: Scroll Page Back to Top
//  * Used for ajax navigation scroll position reset
//  *------------------------------------------------------------*/

// function scrollPageToTop(){
// 	// Height hack for mobile/tablet
// 	jQuery('body').css('height', 'auto');
// 	jQuery("html, body").animate({ scrollTop: 0 }, "slow");

// 	// if( shopera.device != 'desktop' ){
// 		// jQuery('body').scrollTop(0);
// 	// }else{
// 	// 	jQuery('.content-wrapper').scrollTop(0);
// 	// }

// 	jQuery('body').css('height', '');
// }
