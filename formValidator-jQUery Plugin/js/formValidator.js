/**
 * @JqueryPlugin,  "Form Vlaidator"
 * @version 1.0
 * ---------------------------------
 * @author Aleksandar Vučenić
 */


(function ($){


	$.fn.formValidator = function()
	{
		
		_getElements();

		/* Fet Form Function */
		function _getForm(form)
		{
			if(form == null)
			{
				return $(event.target).closest('form');//.parent("form");
			}
			else
			{
				return $(event.target).closest('form');
				//return form;
			}
		}

		/**
		 * Function _getElement - get element from form and get element rules
		 * @return Array element - retrun element rules
		 */
		function _getElements()
		{
			var inputs = _getForm().find('input, textarea');
			var element = new Array();
			var validation = true;
			for(var i = 0; inputs.length  >= i; i++) 
			{
				
				
				if($(inputs[i]).attr('data-validation'))
				{
					
					element[$(inputs[i]).attr('name')] = $(inputs[i]).attr('data-validation');
					_removeErrorMessage($(inputs[i]));
					
					var validations = _rulesElements($(inputs[i]), element[$(inputs[i]).attr('name')]);
					
					if(validations==false)
					{
						validation = validations;
					}
				}
				
			}
			if(validation == true)
			{
				_submitForm(_getForm());
			}
		}

		function _rulesElements(name, rules_list)
		{
			
			var rules = new Array();
			rules = rules_list.split(',');
			validation = true;
			for (var i = 0; rules_list.length >= i; i++) {

				/* REQIRED Rules */
				if(rules[i] == 'required')
				{
					//alert(name.val());
					if(name.attr('type') == 'checkbox')
					{
						if(name.is(":checked") == false)
						{
							name.parent('.form-group').append(_errorMessage('Field must be checked!'));
							validation = false;
							break;
						}
					}
					else if(name.val() == '')
					{
						parent = name.parents('.form-group');
						parent.append(_errorMessage('Field cant be empty!'));
						parent.children('.error-message-container').css('display', 'none');
						parent.children('.error-message-container').fadeIn('slow');
						validation = false;
						break;
					}
					
				}

				/* Check The Email */
				else if(rules[i] == 'email')
				{

					var pattern = /^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/;
					if(name.val().match(pattern) != name.val())
					{
						validation = false;
						parent = name.parents('.form-group');
						parent.append(_errorMessage('Not valid email address!'));
						parent.children('.error-message-container').css('display', 'none');
						parent.children('.error-message-container').fadeIn('slow');
						break;
					}
					
				}
				
				//parent.children('.error-message-content').css('background','#000');

			}
			return validation;
		}

		/* Reaction on submiting form */
		function _submitForm(form)
		{
			// Submit form via ajax or however
			// $(form).submit();
			var message = '<div id="mac-container-conetent"><div class="thankyou-container"><div class="thakyou-content"><h2>Thank you!</h2> </div></div></div>'
			$('#mac-container-conetent').remove();
            $('#mac-container').append(message);
		}

		function _removeErrorMessage(element)
		{
			$(element).parents('.form-group').children('.error-message-container').remove();
			//var remove_items = $(this).parents('.form-group').children('.error-message-container').remove();
		}

		function _errorMessage(message)
		{
			return '<div class=error-message-container><div class=error-message-content> '+ message +' </div></div>';
		}

	}

}( jQuery ));
		
