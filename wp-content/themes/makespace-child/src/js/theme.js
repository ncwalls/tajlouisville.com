(function($){

	var homeHeroSlider = function() {
		$('.hero-slider').slick({
			arrows: false,
			// prevArrow: '<button class="slick-arrow slick-prev" aria-label="Previous" type="button"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20.93 70"><polygon points="20.77 70 8.15 35.01 20.93 0 13.02 0 0 35 13.02 70 20.77 70"/></svg></button>',
			// nextArrow: '<button class="slick-arrow slick-next" aria-label="Next" type="button"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20.93 70"><polygon points=".16 0 12.78 34.99 0 70 7.91 70 20.93 35 7.91 0 .16 0"/></svg></button>',
			dots: false,
			fade: true,
			speed: 2000,
			autoplay: true,
			autoplaySpeed: 4000,
			pauseOnHover: false
		});
	};

	var heroVideo = function() {

		$('[data-action="hero-popup-play"]').on('click', function(e) {
			e.preventDefault();

			var heroVideoModal = document.getElementById('hero-video-modal');
			var heroVideoModalObj = $('#hero-video-modal');

			$.magnificPopup.open({
				mainClass: 'hero-popup',
				items: {
					src: '#hero-video-modal-container',
					type: 'inline',
				},
				callbacks: {
					open: function() {
						if(heroVideoModalObj.length){
							heroVideoModal.play();
						}
					},
					close: function() {
						if(heroVideoModalObj.length){
							heroVideoModal.pause();
							heroVideoModal.currentTime = 0;
						}
					},
				}
			}, 0);
			
		});
		
		$('[data-action="hero-popup-embed"]').magnificPopup({
			type: 'iframe',
			// mainClass: 'hero-popup'
		});

	};


	var scrollAnim = function(){

		///** convert to use intersectionObserver **///

		var win = $(window);

		var items = $('.scroll-animate-item');

		var itemScrollCheck = function(){

			var winHeight = win.innerHeight();
			var winTop = win.scrollTop();
			var scrollTriggerPos = (winHeight * .8) + winTop;

			items.each(function(i, el){

				var item = $(el);
				var itemTop = item.offset().top;

				if(itemTop <= scrollTriggerPos){
					item.addClass('vis');
				}
				else{
					item.removeClass('vis');
				}

			});

		};

		itemScrollCheck();
		optimizedScroll.add(itemScrollCheck);
	};


	var scrollToAnchor = function(){

		if( location.hash ){
			// window.scrollTo(0,0);

			$( 'body' ).removeClass( 'nav-open' );
			
			var locationHashObj = $(location.hash);
			
			if(locationHashObj.length > 0){
				//$('body').removeClass('nav-open');
				// $('body,html').animate({
				// 	scrollTop: locationHashObj.offset().top - 150
				// }, 500);

				var waitTime = 501;

				if(!$('body').hasClass('scrolled')){
					waitTime = 501;
					$('body').addClass('scrolled');
				}

				setTimeout(function(){
					var anchorPosition = locationHashObj.offset().top;
					var finalPosition = anchorPosition - $('.site-header').outerHeight() - 20;
					$("html, body").animate({scrollTop: finalPosition}, 1000);


				}, waitTime);
			}
		}

		$('.scroll-to-anchor a, a[href^="#"]').on('click', function(e){

			if($(this).hasClass('no-scroll')){
				return;
			}
			else if(this.hash){
				
				var hashTarget = $(this.hash);

				if( hashTarget.length ){
					e.preventDefault();
					var waitTime = 0;
					
					if(!$('body').hasClass('scrolled')){
						waitTime = 501;
						$('body').addClass('scrolled');
					}

					setTimeout(function(){
						var anchorPosition = hashTarget.offset().top;
						var finalPosition = anchorPosition - $('.site-header').outerHeight() - 20;
						$("html, body").animate({scrollTop: finalPosition}, 1000);

						$( 'body' ).removeClass( 'nav-open' );

					}, waitTime);
				}
			}
		});
	};

	var blockGallery = function() {
		$('.wp-block-gallery').magnificPopup({
			delegate: 'a',
			type: 'image',
			gallery: {
				enabled: true
			}
		})
	};


	$(document).ready(function(){
		homeHeroSlider();
		heroVideo();
		scrollAnim();
		scrollToAnchor();
		blockGallery();
	});

    window.addEventListener('load', function() {
        var videoContainer = $('.hero-video-container');
        videoContainer.addClass('vis');
    }, false);

})(jQuery);

/* Lazy load bg images https://web.dev/lazy-loading-images/ */
// document.addEventListener("DOMContentLoaded", function() {
//   var lazyBackgrounds = [].slice.call(document.querySelectorAll(".lazy-background"));

//   if ("IntersectionObserver" in window) {
//     let lazyBackgroundObserver = new IntersectionObserver(function(entries, observer) {
//       entries.forEach(function(entry) {
//         if (entry.isIntersecting) {
//           entry.target.classList.add("visible");
//           lazyBackgroundObserver.unobserve(entry.target);
//         }
//       });
//     });

//     lazyBackgrounds.forEach(function(lazyBackground) {
//       lazyBackgroundObserver.observe(lazyBackground);
//     });
//   }
// });