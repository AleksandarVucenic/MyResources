/**
 * @JqueryPlugin,  "Form Vlaidator"
 * @version 2.0
 * ---------------------------------
 * @author Aleksandar Vučenić
 */

(function ($)
{
     
	$.fn.formValidator = function()
	{ 
		//alert('test');
		var formValid = getElements(this);
		return formValid; 
                
	};
	
		function getElements(formValidate)
		{
            
			var inputs = formValidate.find('input, textarea, select');
			var element = new Array();
			var validation = true;
			var inputsName = new Array();
			
			for (var i = 0; inputs.length > i; i++) {
				var attrType = $(inputs[i]).attr('type');
				if(!$(inputs[i]).attr('disabled')){
				    //alert();
    				if(attrType != 'submit') {
    					if(attrType != 'button') {
    						var validationField = validateField(inputs[i]);
    						if(validationField == false) {
    							validation = validationField;
    						}
    					}
    				}
    		     }
			}
			return validation;
		} 
		
		function validateField(validateField)
		{
			var field = $(validateField);
			field.css('background', 'white');
			var validStatus   = true;
			var messageStatus = "";

			// Check Reqired
			if(field.prop('required'))
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
						messageStatus = 'Not valid email address!';
					}
				}
			}

			// Max and Min length
			if(validStatus == false)
			{
				//field.remove();
				field.css('background', 'lightgray');	
				errorMessage(messageStatus);
			}

			return validStatus;
		}


		function errorMessage(message)
		{
			showOverlayMessage(message, 'warning', true);
		}


	


}(jQuery));