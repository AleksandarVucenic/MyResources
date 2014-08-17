
/** SECTION - RISK CLASIFICATION  
 * ========================================================================================
 **/
// Add Form
function addRiskClassificatoin()
{

    $('#riskSaveForm').show();
    $('#riskUpdateForm').hide();
    showIt('#riskClassificationFormDiv');
    clearForm('#riskClassificationForm');
    updateSlider($('#riskValueForm').val(), '#riskValueOutput');
}

// Edit form & Fill data
function editRiskClassificatoin(riskID)
{
    //alert(riskID);
    $('#riskSaveForm').hide();
    $('#riskUpdateForm').show();
    $.ajax({
        url: "/managetpc/risk/ajax/definition/riskClassificationLogic.php?action=edit&riskID=" + riskID,
        context: document.body,
        type: 'POST',
        beforeSend: function() {
        },
        complete: function() {
        },
        success: function(data) {
            //JSON.stringify			
            fillFormJSON('#riskClassificationForm', JSON.parse(data));
            showIt('#riskClassificationFormDiv');
            updateSlider(JSON.parse(data).riskValueForm, '#riskValueOutput');
        },
    });
}

// Delete 
function deleteRiskClasification(riskID)
{
    $.ajax({
        url: "/managetpc/risk/ajax/definition/riskClassificationLogic.php?action=delete&riskID=" + riskID,
        success: function(data) {
            $('body').append(data);
        }
    });
}

// Get Table
function getRiskClassificationTable(container)
{
    $.ajax({
        url: "/managetpc/risk/ajax/definition/riskClassificationViewTable.php",
        context: document.body,
        beforeSend: function() {
        },
        success: function(data) {
            $(container).html(data);
        }
    });
}

/** SECTION - RISK TYPE  
 * ========================================================================================
 **/
function addRiskType()
{
    $('#riskTypeSaveForm').show();
    $('#riskTypeUpdateForm').hide();
    showIt('#riskTypeFormDiv');
    clearForm('#riskTypeForm');
    updateSlider($('#riskTypeNormalRatioForm').val(), '#riskNormalRatioOutput');
}

function editRiskType(riskTypeID)
{

    $('#riskTypeSaveForm').hide();
    $('#riskTypeUpdateForm').show();
    $.ajax({
        url: "/managetpc/risk/ajax/definition/riskTypeLogic.php?action=edit&riskTypeID=" + riskTypeID,
        context: document.body,
        type: 'POST',
        beforeSend: function() {
        },
        complete: function() { /*alert(JSON.stringify(data));*/
        },
        success: function(data) {
            //alert(JSON.stringify(data));			
            fillFormJSON('#riskTypeForm', JSON.parse(data));
            showIt('#riskTypeFormDiv');
            updateSlider(JSON.parse(data).riskTypeNormalRatioForm, '#riskNormalRatioOutput');
        },
    });
}

// Delete 
function deleteRiskType(riskTypeID)
{
    $.ajax({
        url: "/managetpc/risk/ajax/definition/riskLikelihoodLogic.php?action=delete&riskTypeID=" + riskTypeID,
        success: function(data) {
            $('body').append(data);
        }
    });
}

function getRiskTypeTable(container)
{
    $.ajax({
        url: "/managetpc/risk/ajax/definition/riskTypeViewTable.php",
        context: document.body,
        beforeSend: function() {
        },
        success: function(data) {
            //alert(JSON.stringify(data));
            $(container).html(data);
        }
    });
}


/** SECTION - LIKELIHOOD
 * ========================================================================================
 **/
function addRiskLikelihood()
{

    $('#riskLikelihoodSaveForm').show();
    $('#riskLikelihoodUpdateForm').hide();
    showIt('#riskLikelihoodFormDiv');
    clearForm('#riskLikelihoodForm');
    updateSlider($('#riskLikelihoodPercenteForm').val(), '#riskLikelihoodPercenteOutput');
}

function editRiskLikelihood(riskLikelihoodID)
{

    $('#riskLikelihoodSaveForm').hide();
    $('#riskLikelihoodUpdateForm').show();
    $.ajax({
        url: "/managetpc/risk/ajax/definition/riskLikelihoodLogic.php?action=edit&riskLikelihoodID=" + riskLikelihoodID,
        context: document.body,
        type: 'POST',
        beforeSend: function() {
        },
        complete: function(data) { /*alert(JSON.stringify(data)); */
        },
        success: function(data) {
            //alert(JSON.stringify(data));			
            fillFormJSON('#riskLikelihoodForm', JSON.parse(data));
            showIt('#riskLikelihoodFormDiv');
            updateSlider(JSON.parse(data).riskLikelihoodPercenteForm, '#riskLikelihoodPercenteOutput');
        },
    });
}

// Delete 
function deleteRiskLikelihood(riskLikelihoodID)
{
    $.ajax({
        url: "/managetpc/risk/ajax/definition/riskLikelihoodLogic.php?action=delete&riskLikelihoodID=" + riskLikelihoodID,
        success: function(data) {
            $('body').append(data);
        }
    });
}

function getRiskLikelihoodTable(container)
{
    $.ajax({
        url: "/managetpc/risk/ajax/definition/riskLikelihoodViewTable.php",
        context: document.body,
        beforeSend: function() {
        },
        success: function(data) {
            //alert(JSON.stringify(data));
            $(container).html(data);

        }
    });
}



/* GLOBALS */

function viewReports(reportsType)
{
    $('.message-risk-report').remove()
    if (reportsType != "")
    {
        $.ajax({
            url: "/managetpc/risk/ajax/reports/" + reportsType + "Reports.php",
            context: document.body,
            beforeSend: function() {
            },
            complete: function(data) {
                //alert(JSON.stringify(data));
                
            },
            success: function(data) { 
                //alert(JSON.stringify(JSON.parse(data).debug));
                //$('body').append(JSON.stringify(JSON.parse(data).debug));
                //else{
                $('#graph-wrapper').show();
                $('#graph-lines').html(showGraph(data)); 
                //}
                if(JSON.stringify(JSON.parse(data).dataGraph) === "null"){
                    //$('#graph-wrapper').hide();
                    
                    showOverlayMessage(' No data for :' + reportsType, 'info','#risk-report');
                    
                }
                $('#reset-graph-line').attr('onclick', 'viewReports("' + reportsType + '")');

                
                //alert(JSON.stringify(JSON.parse(data).dataGraph.servers.color));
            }
        });
    }
}

function showTypes(data) 
{
    var dataType = data;
    //alert(JSON.stringify(data));
    $(".graph-info").html("");
    
    $.each(data, function(dataInd, dataVal){
        //alert(data[dataInd].color);
        //alert(dataInd, dataVal);
    });
    
    $.each(data, function(index,value){
         //alert(data[index].color);
        $(".graph-info").append(
            '<a onclick="showBy(value)" class="legend-item" style="border-bottom-color: '+value+'; background: ;">'+ index +'</a>'
        );
        
    });
}


function updateSlider(valueSlider, container)
{
    //document.querySelector(container).value = valueSlider + "%";
    //alert(valueSlider); alert(container);
    if(container != null && container !== undefined){
        //if(valueSlider != null && valueSlider !== "undefined") { valueSlider = 0; }
        //document.querySelector(container).value = valueSlider + "%";
        $(container).html( valueSlider + "%");
        //$(container).val(valueSlider);
        //alert(valueSlider);
        //$(container).slider('refresh');
    }
}

function getAjaxSliderColor(url, element, value)
{
    if (value == "") {
        value = 0;
    }
    if (element == "") {
        element = "#outputRisk";
    }
    if (url == "") {
        url = "/managetpc/risk/ajax/getRiskClassificationColor.php?sliderValue=" + value;
    }

    $.ajax({
        url: url,
        success: function(data) {
            $('#outputRisk').removeAttr('style');
            //alert(data);
            $(element).css({
                background: data,
                color: '#000'
            });
        },
    });
}


function editRiskMigration(externalID, typeID, siteID, formID)
{
    //alert(itemID+'-'+typeID);
    
    siteID = JSON.stringify(siteID);
    /*$.each(siteID, function(index, value){
        alert(index +" - "+ value);
    });*/
    //alert(siteID);
    
    if(formID == "" || formID == null || formID == undefined) { formID = "#riskMigration"; }
    
    var formData = $(formID).serializeArray();
    var validate  = $(formID).formValidator();
    //alert(formID);
    $.ajax({
        url: '/managetpc/risk/ajax/migrationRisk/updateMigrationRisk.php?externalID=' + externalID + '&typeID=' + typeID + '&siteID=' + siteID,
        type: 'POST',
        data: formData,
        beforeSend: function(){ $('#loaderDiv').show(); },
        complete: function(data,status){ if(status == 'error'){ $('#loaderDiv').hide(); } },
        success: function(data){
            showRiskMigration(externalID, typeID);
            hideIt('#riskUpdateButton, #riskCancelButton');
            showIt('#riskEditButton');
            disableIt('#riskMigration', true);
            $('#loaderDiv').hide();
        },
    });
    //submitAjaxForm('/managetpc/risk/ajax/migrationRisk/updateMigrationRisk.php?externalID=' + externalID + '&typeID=' + typeID + '&siteID=' + siteID, '#riskMigration', '', true, '', false);
    
}


function showRiskMigration(itemID, typeID, containerSufix)
{
    //salert(itemID + " Testing R- " + containerSufix );
    var output = "#outputRisk" + (containerSufix || "");
    if (containerSufix == undefined) {
        containerSufix = " ";
    }
    //alert(itemID +"-" +typeID);
    $.ajax({
        url: '/managetpc/risk/ajax/migrationRisk/showMigrationRisk.php',
        type: 'POST',
        data: {'itemID': itemID, 'typeID': typeID},
        complete: function(data) { /*$('body').append( JSON.stringify(data)); fillFormJSON('#riskMigration', JSON.parse(data)); */
            //alert(JSON.stringify(data)); 
        
        },
        success: function(data) {
            //alert(JSON.stringify( JSON.parse(data).migrationValue));
            fillFormJSON('#riskMigration', JSON.parse(data), containerSufix);
            updateSlider(JSON.parse(data).migrationValue,output);
            setTimeout(getAjaxSliderColor('/managetpc/risk/ajax/getRiskClassificationColor.php?sliderValue=' + JSON.parse(data).migrationValue, output), 300);
        },
    });
}



function setMigIcon(setTo, migValues, migType) {
    // Initialize Main Variables
    var migTypeName = " Automatic ";
    var autoRisk    = migValues['auto'];
    var manualRisk  = migValues['manual'];
    var migValue    = 0;
    
    if(autoRisk == 0 || autoRisk == null || autoRisk == "undefined") { autoRisk = 0; }
    if(manualRisk == 0 || manualRisk == null || manualRisk == "undefined") { manualRisk = 0; }
    
    
    migValue = autoRisk;
    if( migType == 2 ) { migValue = manualRisk; migTypeName = " Manual "; }
    
    var message = " Active Type: " + migTypeName + " - Manual Risk: " + manualRisk + " % , Auto Risk: " + autoRisk + " %";
    
    // Set title
    $(setTo).attr('title', message);
    getAjaxSliderColor('', setTo, migValue);
}

function showStakeholderRiskMigrtion(employeeID){
    //alert(employeeID);
    $.ajax({
        url: '/managetpc/risk/helpers/showStakeholderMigration.php',
        data: {'employeeID':employeeID},
        success: function(data){
            //alert(data);
            $('body').append(data);
        }
    });
}

function migrationTypeSelect(migrationType)
{
	
	//var migrationTypeC = $('#migrationType');
	var migrationRange = $('#migration');
	var migrateRiskHide = $('#migrationHide').val();
	
	if(migrationType == 1)
	{
		
		$('.migrationRiskManual').hide();
		$('.migrationRiskAuto').show();
		$('#migrationComment').removeAttr('required');
	} else if(migrationType == 2) {
		$('#migrationComment').attr('required','required');
		$('.migrationRiskManual').show();
		$('.migrationRiskAuto').hide();
	}
	
	
	/*if(migrationType == 1)
	{
		migrationRange.val(migrateRiskHide);
		outputUpdate(migrateRiskHide);
		migrationRange.attr('disabled','disabled');
		
		
	} else if(migrationType == 2) {
		migrationRange.removeAttr('disabled');
	}*/
	
	
	
}