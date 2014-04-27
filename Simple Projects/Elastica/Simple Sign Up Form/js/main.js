/**
 * -----------------------------------------------------------
 * Test for appling for job, "Junior Web Developer."
 * JS (JavaScript) for "Sign Up Landing Page Form"
 * -----------------------------------------------------------
 * @author: Aleksandar Vučenić;
 * -----------------------------------------------------------
 */


$( document ).ready(function() {
  	$('button[class~="button-submit-form"]').on('click',function(){
	
		$.fn.formValidator();

	});

	$('input').on('click', function(){
		var remove_items = $(this).parents('.form-group').children('.error-message-container').remove();
  	});

});
