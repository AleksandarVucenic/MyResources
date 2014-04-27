/**
 * -----------------------------------------------------------
 * Test for appling for job, "Junior Web Developer."
 * JS (JavaScript) for "Sign Up Landing Page Form"
 * -----------------------------------------------------------
 * @author: Aleksandar Vučenić; 
 * -----------------------------------------------------------
 */

/* Remove youtube container */
function removeYTXcontainer(){ $('.youtube-container').remove(); }

$( document ).ready(function() {
	
	/* Scroll Effects */
	$(window).stellar({
    	horizontalScrolling: false,
    	verticalOffset: 0,
		horizontalOffset: 0
	});


	/* YoutubeVideo.addParameters(paramenters);Video Button */
	$('.you-intro-iphone').on('click', function(event){
		
		event.preventDefault();
		var parent = $(this).parents('#head-wrapper');
		parent.children('.youtube-container').remove();
		
		var parametars = {
			autohide:1,
			autoplay:1,
			controls:0,
			showinfo:0,
			rel:     0,
			wmode:  'transparent',
			modestbranding: 1,
		};

		YVideo.addParametars(parametars);
		YVideo.addVideo('NoVW62mwSQQ').renderVideo();

	});

	// Form Validator
  	$('button[class~="button-submit-form"]').on('click',function(){
		$('#youtube-exit').remove()
		$.fn.formValidator();

	});

  	// Remove error messages
	$('input').on('click', function(){
		var remove_items = $(this).parents('.form-group').children('.error-message-container').fadeOut();
  	});

});
