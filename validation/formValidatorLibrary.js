/**
 * @library,  "Form Vlaidator"
 * @version 2.0
 * ---------------------------------
 * @author Aleksandar Vučenić
 */

var formValidatorObject = {
	// Initialize Vars 
	_checkBoxName: null,
	_radioButtonName: null,
	_form: null,
	_container: null,

	// Methods
	validateForm : function(form,container) {
		this._form            = document.getElementById(form);
		this._radioButtonName = [];
		//this._container = getElementByClass(container);

		var validate = true; 
		var form     = this._form;
		var elements = this._getElements(form);
		this._cleanUpElements(elements);
		var validate = this._processElements(elements);
		
		return validate;
	},

	_getElements : function(form) {
		var elementsContainer = [];

		/* Get Form Types Elements */
		elementsContainer['input']    = form.getElementsByTagName("input");    // Get Inputs
		elementsContainer['select']   = form.getElementsByTagName("select");   // Get Selects
		elementsContainer['textarea'] = form.getElementsByTagName("textarea"); // Get Textareas
		

		return elementsContainer;
	},

	_cleanUpElements : function(elements) {
		for(var key in elements) {
			for(var i = 0; elements[key].length > i; i++) {  
				elements[key][i].style.background = "#fff";
			}
		}
	},

	_processElements : function(elements) {
		var validation = true;
		for(var key in elements) { 
			for(var i = 0; elements[key].length > i; i++) {
				var elementEntity = elements[key][i];
				
				if(elementEntity.getAttribute('type') != "submit" || elementEntity.getAttribute('type') != "reset") {
					if(typeof this._radioButtonName[elementEntity.getAttribute('name')] == 'undefined'){
						if(this._determinateElementValidation(elementEntity) == false) { 
							validation = false;
							elementEntity.style.background = "#ccc"; 
						}
					} 
				}
			}
		}
		return validation; 
	},

	_determinateElementValidation : function(element) {
		var validate = true;
		if(element.getAttribute('min') || element.getAttribute('max')) {
			if(this.validateMinMaxChar(element) == false){ validate = false; }
		}

		if(element.getAttribute('type') == "email" || element.getAttribute('data-validation-email') == 'true') {
			if(this.validateEmail(element) == false) { validate = false }
		}

		if(element.getAttribute('data-validation-match')){
			if(this.validateFieldMatch(element) == false) { validate = false; }
		}
		// CHECK Regular Expresions Validation
		if(element.getAttribute('data-validation-regularex')) {
			if(this.validateRegularExpresion(element) == false) { validate = false; }
		}
		// REQUIRED FIELDS
		if(element.getAttribute("required")) {
			if(this.validateRequired(element) == false){ validate = false; }
		}


		return validate; 
	},

	/**
     * VALIDATE CHECK BOX OR RADIO BUTTON ELEMENT (Check if checked, for radio does eny cecked with same name tag value)
	 **/
	validateRadioCheckboxRequired : function(element) {
		var validate = false;

		if(element.getAttribute('type') == "checkbox"){
			if(element.checked) {
				validate = true;
			}
		} else {
			var elementName   = element.getAttribute('name');
			var radioElements = document.getElementsByName('radiobutton');
			for(var i = 0; radioElements.length > i; i++) {
				if(radioElements[i].checked) {
					validate = true;
				}
			}
			this._radioButtonName[elementName] = true;

		}
		return validate;
	},

	validateEmail : function(element) {
		var pattern      = /^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,4}$/;
		var elementValue = element.value;
		var validate     = true;
		if(elementValue.match(pattern) != elementValue)
		{
			validate = false; 
		}
		return validate;
	},

	validateRequired : function(element) {
		var validate = false;
		var elementValue = element.value;

		if(element.tagName == "INPUT" && (element.getAttribute("type") == "radio" || element.getAttribute("type") == "checkbox")){				
			validate = this.validateRadioCheckboxRequired(element);	 
		} else {
			if(elementValue != "") { validate = true; } 
		}
		return validate;	

	},

	validateRegularExpresion : function(element) {
		var validate     = true;
		var pattern      = new RegExp(element.getAttribute('data-validation-regularex'));
		var elementValue = element.value;

		if(pattern.test(elementValue) != true) { validate = false; }
		return validate;
	},

	validateFieldMatch : function (element) {
		var validate = true;
		if(this._separateFieldsValid(element) == false) {
			validate = false;
		}
		return validate;
		
	},

	validateMinMaxChar : function (element) {
		var validate      = true;
		var elementLength = element.value.length;
		if(element.getAttribute("max")) {
			if(elementLength-1 >= element.getAttribute("max")) { validate = false; } 
		}
		if(element.getAttribute("min")){ 
			if(elementLength+1 <= element.getAttribute("min")) { validate = false; }
		}
		return validate;
	},

	_separateFieldsValid : function(elements) {
		var elementsStr   = elements.getAttribute('data-validation-match');
		var validate      = true;
		var splitFields   = [];
		var elementsValue = elements.value;

		splitFields = elementsStr.split('|');
		
		for(var i = 0; splitFields.length > i; i++) {
			var fieldsRules = []; 
			if(splitFields[i].indexOf(':') > -1) {
				fieldsRules = splitFields[i].split(':');
				var fieldValue = document.getElementById(fieldsRules[1]).value;
				alert(elementsValue +"-"+fieldValue);
				if(fieldsRules[0] == 'equal'){ if (elementsValue != fieldValue) { validate = false; alert(validate + "-"+fieldsRules[0]);} }
				if(fieldsRules[0] == 'more'){ if (elementsValue <=  fieldValue) { validate = false; alert(validate + "-"+fieldsRules[0]);} }
				if(fieldsRules[0] == 'less'){ if (elementsValue >=  fieldValue) { validate = false; } }	
			}			
		}
		
		return validate;
	}
}
