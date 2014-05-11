/**
 * @JqueryPlugin,  "Form Vlaidator"
 * @version 2.0
 * ---------------------------------
 * @author Aleksandar Vučenić
 */

(function ($)
{

	$.fn.formValidation = function()
	{

		getElements(this);

		/**
		 * Function _getElement - get element from form and get element rules
		 * @return Array element - retrun element rules
		 */
		function getElements(formValidate)
		{

			var inputs = formValidate.find('input, textarea, select');
			var element = new Array();
			var validation = true;
			var inputsName = new Array();


			for (var i = 0; inputs.length > i; i++) {
				var validationField = validateField($(inputs[i]).attr('name'));
				alert($(inputs[i]).attr('name') + ' | ' +validationField + ' | ' + $(inputs[i]).val());
				if(validationField == false){
					validation = validationField;
				}

			}

			return validation;
		} 



		function validateField(validateField)
		{
			var field = $('[name='+validateField+']');
			field.css('border', 'none');
			var validStatus   = true;
			var messageStatus = "";

			// Check Reqired
			if(field.prop('required') == true)
			{
				//check if empty
				if(field.val() == '')
				{
					validStatus   = false;
					messageStatus = 'Required field!';
				}
				// Check for Radio Button
					

				// Check if Email
				else if(field.attr('type') == 'email')
				{
					var pattern = /^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,4}$/;
					if(field.val().match(pattern) != field.val())
					{
						validStatus = false;
						messageStatus = 'Not valid email address!'
					}
				}
			}

			// Max and Min length
			if(validStatus == false)
			{
				field.css('border', '2px solid #F00');	
				errorMessage(messageStatus);
				
			}

			return validStatus;
		}


		function errorMessage(message)
		{
			$('#statusValidationForm').html(message);
		}


	}

}(jQuery));