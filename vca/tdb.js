function hideLoader(){
	$("#loaderDiv").hide();
}

function hideLoaderRounded(){
	$("#loaderRounded").hide();
}

function ShowMasterForm(){
	$('#masterForm').show();
	$('#uploadDoc').hide();
	$('#loaderDiv').hide();
}

function HideMasterForm(){
	$('#masterForm').hide();
	$('#loaderDiv').hide();
	$('#masterAddAssetForm').hide();
}

function listSitesByCountry(cid)
{
	$.ajax({
		url: "/ajax/listSitesByCountry.php?cid=" + cid,
		context: document.body,
		success: function(data){
			$('#listSites').html(data);
			$('#listSites').show();
		}
	});	
	
	return false;
}

function listSitesByCountrySearch(countryID)
{
	$.ajax({
		url: "/ajax/listSitesByCountrySearch.php?countryID=" + countryID,
		context: document.body,
		beforeSend: function(){
		   	$("#loaderDiv").show();
		  	$('#showSiteInfo').hide();
	    },
		success: function(data){
			$('#listSites').html(data);
			$('#listSites').show();
			$("#loaderDiv").hide();
		}
	});	
	
	return false;
}

function listSitesByCountrySearchEmployee(countryID)
{
	$.ajax({
		url: "/ajax/listSitesByCountrySearchEmployee.php?countryID=" + countryID,
		context: document.body,
		beforeSend: function(){
		   	$("#loaderDiv").show();
		  	$('#showSiteInfo').hide();
	    },
		success: function(data){
			$('#listSites').html(data);
			$('#listSites').show();
			
				$.ajax({
				url: "/employee/ajax/employeeListAjaxSite.php?countryID=" + countryID,
				context: document.body,
				success: function(data){
					//alert(curPage);
				$('#employeeList1').html(data);
				$('#employeeList1').show();
				}
				});
		}
	});	
	
	return false;
}

function VendorListSitesByCountrySearch(countryID)
{
	$.ajax({
		url: "/vendor/ajax/listSitesByCountrySearch.php?countryID=" + countryID,
		context: document.body,
		beforeSend: function(){
		   	$("#loaderDiv").show();
		  	$('#showSiteInfo').hide();
	    },
	    complete: function(){
	    	$("#loaderDiv").hide();
	    },
		success: function(data){
			$('#listSites').html(data);
			$('#listSites').show();
		}
	});	
	
	return false;
}

function listSitesByBusinessUnits(businessUnitID)
{
	//alert(businessUnitID);
	$.ajax({
		url: "/ajax/listSitesByBusinessUnits.php?businessUnitID=" + businessUnitID,
		context: document.body,
		success: function(data){
			$('#listSites').html(data);
			$('#listSites').show();
		}
	});	
	
	return false;
}

function showSiteInfobyBusinessUnit(siteID)
{
	//var countryID = document.getElementById("countryID");
	//alert(countryID.value);	
	$.ajax({
		url: "/ajax/showSiteInfoByBusinessUnit.php?sid=" + siteID, 
		context: document.body,
		success: function(data){
			$('#showSiteInfo').html(data);
			$('#showSiteInfo').show();
		}
	});	
	
	return false;
}

function showSiteInfo1(units)
{
	$.ajax({
		url: "/ajax/createRack.php?units=" + units,
		context: document.body,
		success: function(data){
			$('#showRack').html(data);
		}
	});	
	
	return false;
}

function listCountryDetails(countryid, orderBy, direction) {
	
	$('#details').hide();
	$('#subDetailsMenu').hide();
	$('#subDetails').hide();
	
	if ((typeof orderBy === 'undefined' || !orderBy) || (typeof direction === 'undefined' || !direction)) {
		$.ajax({
			url: "/ajax/listSiteDetailsByCountry.php?cid=" + countryid,
			context: document.body,
			success: function(data){
				$('#listSites').html(data);
				$('#listSites').show();
			}
		});	
	}// if orderBy
	else{
		$.ajax({
			url: "/ajax/listSiteDetailsByCountry.php?cid=" + countryid +
													"&orderBy=" + orderBy +
													"&direction=" + direction,
			context: document.body,
			success: function(data){
				$('#listSites').html(data);
				$('#listSites').show();
			}
		});	
	}//else
	return false;
}

function listSitesByBusinessUnitsSearch(businessUnitID)
{
	//alert(businessUnitID);
	$.ajax({
		url: "/ajax/listSitesByBusinessUnitsSearch.php?businessUnitID=" + businessUnitID,
		context: document.body,
		beforeSend: function(){
		   	$("#loaderDiv").show();
		  	$('#showSiteInfo').hide();
	    },
		success: function(data){
			$('#listSites').html(data);
			$('#listSites').show();
			$("#loaderDiv").hide();
		}
	});	
	
	return false;
}

function VendorlistSitesByBusinessUnitsSearch(businessUnitID)
{
	//alert(businessUnitID);
	$.ajax({
		url: "/vendor/ajax/listSitesByBusinessUnitsSearch.php?businessUnitID=" + businessUnitID,
		context: document.body,
		beforeSend: function(){
		   	$("#loaderDiv").show();		  	
	    },
	    complete: function(){	    	
	    	$("#loaderDiv").hide();
	    },	    
		success: function(data){
			$('#listSites').html(data);
			$('#listSites').show();
		}
	});	
	
	return false;
}




/*
function addNew()
{
	//alert("ghjgkgj");
	var sID = document.getElementById("siteID").value;
	
	alert(sID);
	
	//window.open('http://www.tdb1.vca-tmp.com/employee/?a=company&action=new&sID='+sID+'');
	
	
	
	employeeSite(elem);
}

*/











function showSiteInfo(siteID)
{
	var countryID = document.getElementById("countryID");
	//alert(countryID.value);	
	$.ajax({
		url: "/ajax/showSiteInfo.php?sid=" + siteID +
									"&cid=" + countryID.value, 
		context: document.body,
		beforeSend: function(){
		   	$("#loaderDiv").show();
	    },
		success: function(data){
			$('#showSiteInfo').html(data);
			$('#showSiteInfo').show();
		}
	});	
	
	return false;
}

function showSiteInfobyBusinessUnit(siteID)
{
	//var countryID = document.getElementById("countryID");
	//alert(countryID.value);	
	$.ajax({
		url: "/ajax/showSiteInfoByBusinessUnit.php?sid=" + siteID, 
		context: document.body,
		success: function(data){
			$('#showSiteInfo').html(data);
			$('#showSiteInfo').show();
		}
	});	
	
	return false;
}

function selectSiteShowSiteInfo(PhaseGroupCode)
{
	var countryID = document.getElementById("countryID");
	//alert(PhaseGroupCode);	
	$.ajax({
		url: "/ajax/selectSiteShowSiteInfo.php?PhaseGroupCode=" + PhaseGroupCode, 
		context: document.body,
		beforeSend: function(){
		   	$("#loaderDiv").show();
	    },
		success: function(data){
			$('#showSiteInfo').html(data);
			$('#showSiteInfo').show();
			$("#loaderDiv").hide();
			
		}
	});	
	
	return false;
}

function selectSiteShowSiteInfoEmployee(PhaseGroupCode)
{
	//var countryID = document.getElementById("countryID");
	//alert(PhaseGroupCode);	
	$.ajax({
		url: "/ajax/selectSiteShowSiteInfoEmployee.php?PhaseGroupCode=" + PhaseGroupCode, 
		context: document.body,
		beforeSend: function(){
		   	$("#loaderDiv").show();
	    },
		success: function(data){
			$('#showSiteInfo').html(data);
			$('#showSiteInfo').show();
			
			
			
		}
	});	
	
	return false;
}


function listCountryDetails(countryid, orderBy, direction) {
	
	$('#details').hide();
	$('#subDetailsMenu').hide();
	$('#subDetails').hide();
	
	if ((typeof orderBy === 'undefined' || !orderBy) || (typeof direction === 'undefined' || !direction)) {
		$.ajax({
			url: "/ajax/listSiteDetailsByCountry.php?cid=" + countryid,
			context: document.body,
                        beforeSend: function() { $("#loaderDiv").show(); },
                        complete: function() { $("#loaderDiv").hide(); },
                        success: function(data){
				$('#listSites').html(data);
				$('#listSites').show();
			}
		});	
	}// if orderBy
	else{
		$.ajax({
			url: "/ajax/listSiteDetailsByCountry.php?cid=" + countryid +
													"&orderBy=" + orderBy +
													"&direction=" + direction,
			context: document.body,
                        beforeSend: function() { $("#loaderDiv").show(); },
                        complete: function() { $("#loaderDiv").hide(); },
			success: function(data){
				$('#listSites').html(data);
				$('#listSites').show();
			}
		});	
	}//else
	return false;
}

function listSitesByBU(buid, orderBy, direction) {
	
	if ((typeof orderBy === 'undefined' || !orderBy) || (typeof direction === 'undefined' || !direction)) {
	//alert('nemam parametre');
	$.ajax({
				url: "/ajax/listSiteByBU.php?buid=" + buid,
				context: document.body,
                                beforeSend: function(){ $("#loaderDiv").show() },
                                complete: function(){ $("#loaderDiv").hide() },
				success: function(data){
					$('#listSites').html(data);
					$('#listSites').show();
				}
			});
			$('#details').hide();	
			$('#subDetailsMenu').hide();
			$('#subDetails').hide();
	}
	else{
		//alert('imam parametre');
		//alert(orderBy);
		//alert(direction);
		$.ajax({
				url: "/ajax/listSiteByBU.php?buid=" + buid + 
					"&orderBy=" + orderBy +
					"&direction=" + direction,
				context: document.body,
                                beforeSend: function(){ $("#loaderDiv").show() },
                                complete: function(){ $("#loaderDiv").hide() },
				success: function(data){
					$('#listSites').html(data);
				}
			});
			$('#details').hide();	
			$('#subDetailsMenu').hide();
			$('#subDetails').hide();
	}
	return false;
}

function showSiteDetails(sid) {	
	$('#subDetailsMenu').hide();
	$('#subDetails').hide();
	$.ajax({
		url: "/ajax/showSiteDetails.php?sid=" + sid,
		context: document.body,
                beforeSend: function(){ $("#loaderDiv").show() },
                complete: function() { $("#loaderDiv").hide() },
		success: function(data){
			$('#details').html(data);
		}
	});	
	$('#details').show();

	return false;
}

function showImages(sid,curPage,offset) {	
	$('#details').hide();
	$('#subDetails').hide();
	$.ajax({
		url: "/ajax/showImages.php?sid=" + sid +
								"&curPage=" + curPage +
								"&offset=" + offset,
		context: document.body,
		success: function(data){
			$('#subDetailsMenu').html(data);
			$('#subDetailsMenu').show();
			$('html, body').animate({ scrollTop: $('#subDetailsMenu').offset().top }, 'slow');
		}
	});	
	//$('#subDetails').show();
	
	return false;
}

function getAssetByPictureRef(pid) {	
	$('#details').hide();
	$.ajax({
		url: "/ajax/getAssetByPictureRef.php?pid=" + pid,
		context: document.body,
		success: function(data){
			$('#subDetails').html(data);
		}
	});	
	$('#subDetails').show();

	return false;
}

function getSiteDocumentList(sid, curPage, offset) {	
	
	$('#subDetails').hide();
	$('#subDetailsMenu').hide();
	$.ajax({
		url: "/ajax/getSiteDocumentList.php?sid=" + sid +
										"&curPage=" + curPage +
										"&offset=" + offset,
		context: document.body,
		success: function(data){
			$('#details').html(data);
			$('#details').show();
			$('html, body').animate({ scrollTop: $('#details').offset().top }, 'slow');
		}
	});	

	return false;
}

function getSiteContractList(sid) {	
	
	$('#subDetails').hide();
	$('#subDetailsMenu').hide();
	$.ajax({
		url: "/ajax/getSiteContractList.php?sid=" + sid,
		context: document.body,
		success: function(data){
			$('#details').html(data);
		}
	});	
	$('#details').show();

	return false;
}

function listSiteEmployee(sid, curPage, offset) {
	$('#details').hide();
	$('#subDetails').hide();
	$.ajax({
		url: "/ajax/listSiteEmployee.php?sid=" + sid +
									"&curPage=" + curPage +
									"&offset=" + offset,
		context: document.body,
		success: function(data){
			$('#subDetailsMenu').html(data);
			$('#subDetailsMenu').show();
			$('html, body').animate({ scrollTop: $('#subDetailsMenu').offset().top }, 'slow');
		}
	});	
	//$('#subDetails').show();
	
	return false;
}

function getAllSitePictures(sid) {	
	$('#details').hide();
	$('#subDetails').hide();
	$.ajax({
		url: "/search/ajax/results/showImages.php?sid=" + sid,
		context: document.body,
		success: function(data){
			$('#subDetailsMenu').html(data);
		}
	});	
	$('#subDetailsMenu').show();
	//$('#subDetails').show();
	
	return false;
}

function listSiteEmployeeDetails(sid) {	
	$('#details').hide();
	//$('#subDetails').show();
	$.ajax({
		url: "/ajax/listSiteEmployeeDetails.php?sid=" + sid,
		context: document.body,
		success: function(data){
			$('#subDetails').html(data);
			$('#subDetails').show();
		}
	});	
	$('#subDetailsMenu').show();
	
	return false;
}



function listAssetTypes()
{
	//alert(sid);
	$.ajax({
		url: "/ajax/listAssetTypes.php",
		context: document.body,
		success: function(data){
			$('#types').html(data);
		}
	});	
	
	return false;
}

function listPDFReportsByCategory(cid)
{
	//alert(cid);
	$.ajax({
		url: "/ajax/listPDFReportsByCategory.php?cid=" + cid,
		context: document.body,
		success: function(data){
			$('#listReports').html(data);
		}
	});	
	
	return false;
}

function listAllPDFReports()
{
	//alert('cid');
	$.ajax({
		url: "/ajax/listAllPDFReports.php",
		context: document.body,
		success: function(data){
			$('#listReports').html(data);
		}
	});	
	
	return false;
}

function listAllArchivedPDFReports()
{
	//alert('cid');
	$.ajax({
		url: "/ajax/listAllArchivedPDFReports.php",
		context: document.body,
		success: function(data){
			$('#listReports').html(data);
		}
	});	
	return false;
}

function listArchivedReportsCategories(cid)
{
	//alert('cid');
	$('#listReports').html("");
	$('#listReports').hide();
	$.ajax({
		url: "/ajax/listArchivedReportsCategories.php?cid="+cid,
		context: document.body,
		success: function(data){
			$('#listCategories').html(data);
		}
	});	
	
	return false;
}

function listPDFArchivedReportsByCategory(acid,cid)
{
	//alert(acid);
	$('#listReports').html("");
	$('#listReports').hide();
	$.ajax({
		url: "/ajax/listPDFArchivedReportsByCategory.php?acid="+acid+"&cid="+cid,
		context: document.body,
		success: function(data){
			$('#listReports').html(data);
			$('#listReports').show();
		}
	});	
	
	return false;
}

function showEquipmentQuantity(eid)
{
	//alert(eid);
	$.ajax({
		url: "/ajax/showEquipmentQuantity.php?eid="+eid,
		context: document.body,
		success: function(data){
			$('#quantity').html(data);
		}
	});	
	
	return false;
}

function listEquipmentModelsByType(etid)
{
	//alert(etid);
	$.ajax({
		url: "/ajax/listEquipmentModelsByType.php?etid="+etid,
		context: document.body,
		success: function(data){
			$('#models').html(data);
		}
	});	
	
	return false;
}

function listEquipmentSerialsByModel(eid)
{
	//alert(etid);
	$.ajax({
		url: "/ajax/listEquipmentSerialsByModel.php?eid="+eid,
		context: document.body,
		success: function(data){
			$('#serials').html(data);
		}
	});	
	
	return false;
}

function showTeamMemberUsageList(tmid)
{
	//alert(etid);
	$.ajax({
		url: "/ajax/showTeamMemberUsageList.php?tmid="+tmid,
		context: document.body,
		success: function(data){
			$('#usageList').html(data);
		}
	});	
	
	return false;
}

window.highlightCells = function(tableRow) {
    for (var index = 0; index < tableRow.childNodes.length; index++) {
        var row = tableRow.childNodes[index];
        if (row.style) {
            row.style.backgroundColor = "#F2F0F7";
        }
    }
};

window.unhighlightCells = function(tableRow) {
    for (var index = 0; index < tableRow.childNodes.length; index++) {
        var row = tableRow.childNodes[index];
        if (row.style) {
            row.style.backgroundColor = "white";
        }
    }
};

function listActionListByType(tid)
{
	$('#action').hide();
	
	$.ajax({
		url: "/ajax/listActionListByType.php?tid="+tid,
		context: document.body,
		success: function(data){
			$('#actions').html(data);
			$('#actions').show();
			$('#action').hide();
		}
	});
	
	return false;
}

function listActionByTypeAndActionID(tid,aid,dis)
{
	//alert(aid);
	$('#actions').hide();
	if(dis==1){
	$.ajax({
		url: "/ajax/listActionByTypeAndActionID.php?tid="+tid +
											"&aid="+aid  +
											"&dis="+dis,
		context: document.body,
		success: function(data){
			$('#actions').html(data);
			$('#action').hide();
		}
	});	}
	
	return false;
}

function listHideActions()
{
	//alert("tid");
    $('#actions').hide();
    $('#action').show();
	
}

function changeSearchCriteria(type)
{
	//alert("changeSearchCriteria" + " " + type);
	switch(type){
		case "country":
		$.ajax({
			url: "/ajax/changeSearchCriteriaRegion.php",
			context: document.body,
			beforeSend: function(){
		   	$("#loaderDiv").show();
		  	$('#showSiteInfo').hide();
	    },
			complete: function(){
				$('#loaderDiv').hide();
				$('#listSites').hide();
				$('#countryList').hide();},
			success: function(data){
				$('#showCriteriaList').html(data);
				$('#showCriteriaList').show();
			}
		});
		//alert("country");	
		break;
		
		case "bunit":
		$.ajax({
			url: "/ajax/changeSearchCriteriaBusinessUnit.php",
			context: document.body,
			beforeSend: function(){
		   		$("#loaderDiv").show();
		  		$('#showSiteInfo').hide();
	    	},
			complete: function(){
				$('#loaderDiv').hide();
				$('#listSites').hide();
				$('#showCriteriaList').hide();
				},
			success: function(data){
				$('#countryList').html(data);
				$('#countryList').show();
			}
		});	
		//alert("bunit");	
		break;
		
		case "search":
		$.ajax({
			url: "/ajax/changeSearchCriteriaSearchBox.php",
			context: document.body,
			beforeSend: function(){
		  	 	$("#loaderDiv").show();
		  		$('#showSiteInfo').hide();
	    	},
			complete: function(){
				$('#loaderDiv').hide();
				$('#listSites').hide();
				$('#countryList').hide();},
			success: function(data){
				$('#showCriteriaList').html(data);
				$('#showCriteriaList').show();
			}
		});	
		//alert("bunit");	
		break;
	}
	
	return false;
}



function changeSearchCriteriaVendor(type)
{
	//alert("changeSearchCriteria" + " " + type);
	switch(type){
		case "country":
		$.ajax({
			url: "/vendor/ajax/changeSearchCriteriaRegion.php",
			context: document.body,
			beforeSend: function(){
		   	$("#loaderDiv").show();
		  	$('#showSiteInfo').hide();
	    },
			complete: function(){
				$('#loaderDiv').hide();
				$('#listSites').hide();
				$('#countryList').hide();},
			success: function(data){
				$('#showCriteriaList').html(data);
				$('#showCriteriaList').show();
			}
		});
		//alert("country");	
		break;
		
		case "bunit":
		$.ajax({
			url: "/vendor/ajax/changeSearchCriteriaBusinessUnit.php",
			context: document.body,
			beforeSend: function(){
		   		$("#loaderDiv").show();
		  		$('#showSiteInfo').hide();
	    	},
			complete: function(){
				$('#loaderDiv').hide();
				$('#listSites').hide();
				$('#showCriteriaList').hide();
				},
			success: function(data){
				$('#countryList').html(data);
				$('#countryList').show();
			}
		});	
		//alert("bunit");	
		break;
		
		case "search":
		$.ajax({
			url: "/vendor/ajax/changeSearchCriteriaSearchBox.php",
			context: document.body,
			beforeSend: function(){
		  	 	$("#loaderDiv").show();
		  		$('#showSiteInfo').hide();
	    	},
			complete: function(){
				$('#loaderDiv').hide();
				$('#listSites').hide();
				$('#countryList').hide();},
			success: function(data){
				$('#showCriteriaList').html(data);
				$('#showCriteriaList').show();
			}
		});	
		//alert("bunit");	
		break;
	}
	
	return false;
}






function loadCountryListByRegion(regionID){
	
	$.ajax({
			url: "/ajax/loadCountryListByRegion.php?regionID=" + regionID,
			context: document.body,
			complete: function(){
				$('#loaderDiv').hide();
				$('#listSites').hide();},
			success: function(data){
				$('#countryList1').html(data);
			}
		});
}
function ListCountriesByRegion(regionID, x, orderBy, direction){
	
	
	if ((typeof orderBy === 'undefined' || !orderBy) || (typeof direction === 'undefined' || !direction)) {
		
		$.ajax({
				url: "/ajax/listCountriesByRegion.php?regionID=" + regionID +
														"&x=" + x,
				context: document.body,
				success: function(data){
					$('#countryList').html(data);
				}
			});
		if(x == 1){
			$.ajax({
				url: "/ajax/listSiteDetailsByCountry.php?regionID=" + regionID,
				context: document.body,
				success: function(data){
					$('#listSites').html(data);
				}
			});	
		}// if x =1
	}//if undefined
	else{
		
		$.ajax({
				url: "/ajax/listCountriesByRegion.php?regionID=" + regionID +
														"&x=" + x +
														"&orderBy=" + orderBy +
														"&direction=" + direction,
				context: document.body,
				success: function(data){
					$('#countryList').html(data);
				}
			});
			if(x == 1){
				$.ajax({
					url: "/ajax/listSiteDetailsByCountry.php?regionID=" + regionID +
																"&orderBy=" + orderBy +
																"&direction=" + direction,
					context: document.body,
					success: function(data){
						$('#listSites').html(data);
					}
				});
			}// if x =1
	}//else
	
}

function ListCountriesByRegionSearch(regionID){
	
		$.ajax({
				url: "/ajax/ListCountriesByRegionSearch.php?regionID=" + regionID,
				context: document.body,
				success: function(data){
					$('#countryList').html(data);
					$('#countryList').show();
					$('#listSites').hide();
					$('#showSiteInfo').hide();
				}
			});
}

function ListCountriesByRegionSearchEmployee(regionID){
	//alert("region id----:"+regionID);
	if(regionID=="")
	{
		regionID=1000;
	}
	//alert("region id:"+regionID);
		$.ajax({
				url: "/ajax/ListCountriesByRegionSearchEmployee.php?regionID=" + regionID,
				context: document.body,
				success: function(data){
					$('#countryList').html(data);
					$('#countryList').show();
					$('#listSites').hide();
					$('#showSiteInfo').hide();
					
					
					$.ajax({
						url: "/employee/ajax/employeeListAjaxSite.php?regionID=" + regionID ,
						context: document.body,
						success: function(data){
							//alert(curPage);
						$('#employeeList1').html(data);
						$('#employeeList1').show();
						}
					});
					
					
					
				}
			});
}

function ListCountriesByRegionSearchVendor(regionID){
	//alert(regionID);
		$.ajax({
			url: "/vendor/ajax/ListCountriesByRegionSearch.php?regionID=" + regionID,
			context: document.body,
			beforeSend: function(){
			   	$("#loaderDiv").show();			  	
		    },
		    complete: function(){
		    	$("#loaderDiv").hide();
		    },
			success: function(data){
				$('#countryList').html(data);
				$('#countryList').show();
				$('#listSites').hide();
				$('#showSiteInfo').hide();
			}
		});
}


function VendorContractShowList(offset, regionID, countryID, siteID, buID){
	if(regionID == '0'){
		regionID = '-1'; // kad se izabere All Regions da ucita sve Contract-e
	}
	//alert(offset);		
	$.ajax({
		url: "/vendor/ajax/ShowListOfContract.php?offset=" + offset + "&regionID=" + regionID + "&countryID=" + countryID + "&siteID=" + siteID + "&businessUnitID=" + buID,
		context: document.body,
		beforeSend: function(){
		   	$("#loaderDiv").show();			  	
	    },
	    complete: function(){
	    	$("#loaderDiv").hide();
	    },
		success: function(data){
			$('#viewList').html(data);
			$('#viewList').show();			
		}
	});
}
function EmployeeShowList(offset, regionID, countryID, siteID, buID){
	if(regionID == '0'){
		regionID = '-1'; // kad se izabere All Regions da ucita sve Contract-e
	}
			
	$.ajax({
		url: "/employee/ajax/ShowListOfEmployee.php?offset=" + offset + "&regionID=" + regionID + "&countryID=" + countryID + "&siteID=" + siteID + "&businessUnitID=" + buID,
		context: document.body,
		beforeSend: function(){
		   	$("#loaderDiv").show();			  	
	    },
	    complete: function(){
	    	$("#loaderDiv").hide();
	    },
		success: function(data){
			$('#viewList').html(data);
			$('#viewList').show();			
		}
	});
}






function EmployeeShowList(curPage,offset, regionID, countryID, siteID, buID)
{
	
	//alert(curPage);
	//alert(offset);
	//if(regionID == '0'){
	//	regionID = '-1'; // kad se izabere All Regions da ucita sve Employee-e
	//}
		
	
	
	$.ajax({
				url: "/employee/ajax/employeeListAjax.php?curPage=" + curPage +
															"&offset=" + offset,
				context: document.body,
				success: function(data){
					alert(curPage);
				$('#employeeList1').html(data);
				$('#employeeList1').show();
				}
			});		
	
	
	
	
	
	/*
	
	if(regionID == '0'){
		regionID = '-1'; // kad se izabere All Regions da ucita sve Contract-e
	}
			
	$.ajax({
		url: "/vendor/ajax/ShowListOfEmployee.php?offset=" + offset + "&regionID=" + regionID + "&countryID=" + countryID + "&siteID=" + siteID + "&businessUnitID=" + buID,
		context: document.body,
		beforeSend: function(){
		   	$("#loaderDiv").show();			  	
	    },
	    complete: function(){
	    	$("#loaderDiv").hide();
	    },
		success: function(data){
			$('#viewList').html(data);
			$('#viewList').show();			
		}
	});
	*/
}





function GoToPageVendor(regionID, countryID, siteID, buID){
	var offset = $("#pageNumberVendor").val();
	
	VendorContractShowList(offset, regionID, countryID, siteID, buID);
}

/*function SearchBySiteName(q){
	 //alert(q);
	  $.ajax({
		url: "/ajax/SearchBySiteNameCalc.php?q=" + q,
		context: document.body,
		success: function(data){
			$('#countryList').html(data);
		}							   
	});
	 $.ajax({
		url: "/ajax/SearchBySiteName.php?q=" + q,
		context: document.body,
		success: function(data){
			$('#listSites').html(data);
			$('#listSites').show();
			$('#countryList').show();
		}							   
	});
}*/
function SearchForEmployeeNew(q){
	
	//alert(q);
	//document.getElementById('lab1').innerHTML="&nbsp;";
	$.ajax({
		url: "/ajax/employee/estSearch/SearchForEmployeeNew.php?q=" + q,
		context: document.body,
		success: function(data){
			$('#employeeListNew').html(data);
			$('#employeeListNew').show();
		}
	});	
	
	return false;
}

function SearchVendor(){
	 
	 var siteName = $("#SearchBySiteName").val();
	 var contractName = $("#SearchByContractName").val();
	 
	 //alert("SiteName: " + siteName + " - " + "ContractName: " + contractName); return false;
	 	 
	  $.ajax({
		url: "/vendor/ajax/ShowListOfContract.php?searchContractName=" + contractName + "&searchSiteName=" + siteName,
		context: document.body,
		beforeSend: function(){
		   	$("#loaderDiv").show();			  	
	    },
	    complete: function(){
	    	$("#loaderDiv").hide();
	    },
		success: function(data){
			$('#viewList').html(data);
		}							   
	});
	 
}

function showElements(){
	setTimeout(function() {
  			$('#countryList').show();
			$('#listSites').show();
			$('#showSiteInfo').show();
			}, 3000);
}

function hideElements(){
  			$('#countryList').hide();
			$('#listSites').hide();
			$('#showSiteInfo').hide();	
}

function ListCountriesByRegion2(regionID, x, orderBy, direction){
	
	$('#details').hide();
	$('#subDetailsMenu').hide();
	$('#subDetails').hide();
	
	if ((typeof orderBy === 'undefined' || !orderBy) || (typeof direction === 'undefined' || !direction)) {
		
		$.ajax({
				url: "/ajax/listCountriesByRegion2.php?regionID=" + regionID +
														"&x=" + x,
				context: document.body,
                                beforeSend: function(){ $("#loaderDiv").show(); },
                                
				success: function(data){
					$('#countryList').html(data);
					$('#countryList').show();
                                        
                                        if(x == 1){
                                                $.ajax({
                                                        url: "/ajax/listSiteDetailsByCountry.php?regionID=" + regionID,
                                                        context: document.body,
                                                        complete: function(){ $("#loaderDiv").hide(); },
                                                        success: function(data){
                                                                $('#listSites').html(data);
                                                                $('#listSites').show();
                                                        }
                                                });	
                                        }else { $("#loaderDiv").hide(); }// if x =1
                                        
				}
			});
		
	}//if undefined
	else{
		
		$.ajax({
				url: "/ajax/listCountriesByRegion2.php?regionID=" + regionID +
														"&x=" + x +
														"&orderBy=" + orderBy +
														"&direction=" + direction,
				context: document.body,
                                beforeSend: function(){ $("#loaderDiv").show(); },
                                complete: function(){ $("#loaderDiv").hide(); },
				success: function(data){
					$('#countryList').html(data);
					$('#countryList').show();
                                        
                                    if(x == 1){
                                            $.ajax({
                                                    url: "/ajax/listSiteDetailsByCountry.php?regionID=" + regionID +
                                                                                                                                            "&orderBy=" + orderBy +
                                                                                                                                            "&direction=" + direction,
                                                    context: document.body,
                                                    success: function(data){
                                                            $('#listSites').html(data);
                                                            $('#listSites').show();
                                                    }
                                            });
                                    }else { $("#loaderDiv").hide(); }
				}
			});
			// if x =1
	}//else
	
}

////////////////////////////PROJECT PHASES////////////////////////////////

function displayDescription(did)
{
	$.ajax({
		url: "/ajax/tpc/displayDescription.php?did=" + did,
		context: document.body,
		success: function(data){
			$('#description').html(data);
		}
	});	
	
	return false;
}

function openDescription(id){
	//alert(id);
	switch(id){
		case "1":
			if($('#rfi').attr("checked")){
	    	displayDescription(1);
		    }
		    else{
		    	$('#description').empty();
		    }
		break;
		case "2":
			if($('#miniDD').attr("checked")){
		    	displayDescription(2);
		    }
		    else{
		    	$('#description').empty();
		    }
		break;
		case "3":
			if($('#rfp').attr("checked")){
		    	displayDescription(3);
		    }
		    else{
		    	$('#description').empty();
		    }
		break;
		case "4":
			if($('#maxiDD').attr("checked")){
		    	displayDescription(4);
		    }
		    else{
		    	$('#description').empty();
		    }
		break;
		case "5":
			if($('#sa').attr("checked")){
		    	$('#description').empty();
		    }
		break;
		case "6":
			if($('#ss').attr("checked")){
		    	$('#description').empty();
		    }
		break;
		case "7":
			if($('#rd').attr("checked")){
		    	$('#description').empty();
		    }
		break;
		case "8":
			if($('#ro').attr("checked")){
		    	$('#description').empty();
		    }
		break;
	}
}

function displayEstimatedNumber(id){
	//alert(id);
	$.ajax({
		url: "/ajax/tpc/displayEstimatedNumber.php?id=" + id,
		context: document.body,
		success: function(data){
			$('#estimatedNumber').html(data);
			$('#estimatedNumber').show();
		}
	});	
	
	return false;
}

function displayEstUpload(id, phaseID){
	//alert(phaseID);
	$.ajax({
		url: "/ajax/tpc/displayEstUpload.php?id=" + id +
											"&phaseID=" + phaseID,	
		context: document.body,
		success: function(data){
			$('#estUpload').html(data);
			$('#estUpload').show();
		}
	});	
	
	return false;
}

function saveDescription2(){
	var startDate = document.getElementById('startDate');
	var endDate = document.getElementById('endDate');
	var estValueID = document.getElementById('estValueID');
	var estNumber = document.getElementById('estNumber');
	var estNumberP = document.getElementById('estNumberP');
	var estNumberS = document.getElementById('estNumberS');
	var estNumberR = document.getElementById('estNumberR');
	var estNumberPBX = document.getElementById('estNumberPBX');
	var estNumberF = document.getElementById('estNumberF');
	var estNumberW = document.getElementById('estNumberW');
	var estNumberVT = document.getElementById('estNumberVT');
	var estNumberC = document.getElementById('estNumberC');
	var estNumberSLA = document.getElementById('estNumberSLA');
	var estNumberVen = document.getElementById('estNumberVen');
	var projectPhaseID = document.getElementById('projectPhaseID');
	
	if(estValueID.value != 12 && estValueID.value != 11 && estValueID.value != 4){
	
	$.ajax({
		url: "/ajax/tpc/saveDescription.php?startDate=" + startDate.value +
										   "&endDate=" + endDate.value +
										   "&estValueID=" + estValueID.value +
										   "&estNumber=" + estNumber.value +
										   "&projectPhaseID=" + projectPhaseID.value,
		success: function(data)
		{
			//$('#a').html(data);
			//document.getElementById('startDate').value="";
			//document.getElementById('endDate').value="";
			document.getElementById('estValueID').value="";
			document.getElementById('estNumber').value="";
			$('#estimatedNumber').hide();
			document.getElementById('message').innerHTML = "Successfully Saved.";
		}
	});	
	}else if(estValueID.value == 12){
		$.ajax({
		url: "/ajax/tpc/saveDescription.php?startDate=" + startDate.value +
										   "&endDate=" + endDate.value +
										   "&estValueID=" + estValueID.value +
										   "&estNumberP=" + estNumberP.value +
										   "&estNumberS=" + estNumberS.value +
										   "&estNumberR=" + estNumberR.value +
										   "&estNumberPBX=" + estNumberPBX.value +
										   "&estNumberF=" + estNumberF.value +
										   "&estNumberW=" + estNumberW.value +
										   "&projectPhaseID=" + projectPhaseID.value,
		success: function(data)
		{
			//$('#a').html(data);
			//document.getElementById('startDate').value="";
			//document.getElementById('endDate').value="";
			document.getElementById('estValueID').value="";
			document.getElementById('estNumberP').value="";
			document.getElementById('estNumberS').value="";
			document.getElementById('estNumberR').value="";
			document.getElementById('estNumberPBX').value="";
			document.getElementById('estNumberF').value="";
			document.getElementById('estNumberW').value="";
			$('#estimatedNumber').hide();
			document.getElementById('message').innerHTML = "Successfully Saved.";
		}
	});	
	}else if(estValueID.value == 11){
		$.ajax({
		url: "/ajax/tpc/saveDescription.php?startDate=" + startDate.value +
										   "&endDate=" + endDate.value +
										   "&estValueID=" + estValueID.value +
										   "&estNumberVT=" + estNumberVT.value +
										   "&estNumberC=" + estNumberC.value +
										   "&projectPhaseID=" + projectPhaseID.value,
		success: function(data)
		{
			//$('#a').html(data);
			//document.getElementById('startDate').value="";
			//document.getElementById('endDate').value="";
			document.getElementById('estValueID').value="";
			document.getElementById('estNumberVT').value="";
			document.getElementById('estNumberC').value="";
			$('#estimatedNumber').hide();
			document.getElementById('message').innerHTML = "Successfully Saved.";
		}
	});	
	}else if(estValueID.value == 4){
		$.ajax({
		url: "/ajax/tpc/saveDescription.php?startDate=" + startDate.value +
										   "&endDate=" + endDate.value +
										   "&estValueID=" + estValueID.value +
										   "&estNumberSLA=" + estNumberSLA.value +
										   "&estNumberVen=" + estNumberVen.value +
										   "&projectPhaseID=" + projectPhaseID.value,
		success: function(data)
		{
			//$('#a').html(data);
			//document.getElementById('startDate').value="";
			//document.getElementById('endDate').value="";
			document.getElementById('estValueID').value="";
			document.getElementById('estNumberSLA').value="";
			document.getElementById('estNumberVen').value="";
			$('#estimatedNumber').hide();
			document.getElementById('message').innerHTML = "Successfully Saved.";
		}
	});	
	}
}

function showEstValuesForm(phid)
{
	$.ajax({
		url: "/ajax/tpc/showEstValuesForm.php?phid=" + phid,
		context: document.body,
		success: function(data){
			document.getElementById('message').innerHTML = "";
			$('#estValuesForm').html(data);
		}
	});	
	
	return false;
}

function showEstUpload(phid)
{
	$.ajax({
		url: "/ajax/tpc/showEstUpload.php?phid=" + phid,
		context: document.body,
		success: function(data){
			document.getElementById('message').innerHTML = "";
			$('#estValuesForm').html(data);
		}
	});	
	
	return false;
}

function check(estValueID,phaseID,x)
{
	//alert(estValueID);
	//alert(phaseID);
    //alert(x);
	$.ajax({
		url: "/ajax/tpc/check.php?estValueID=" + estValueID +
									"&phaseID=" + phaseID +
									"&x=" + x ,
		context: document.body,
		success: function(data){
			$('#message').html(data);
		}
	});	
	return false;
}
function makeBlankSearchSLA() { document.search.keyword1.value =""; }

function FocusSiteDetails(){
	$('html, body').animate({ scrollTop: $('#details').offset().top }, 'slow');
}

function CancelSiteSelect(siteID){
	$.ajax({
		url: "/ajax/cancelSelectSite.php?siteID=" + siteID ,
		success: function(data){
			$('#test').html(data);
		}
	});		
}

function SetSessionSiteID(siteID){
	//alert(siteID);
	$.ajax({
		url: "/ajax/SetSessionSiteID.php?siteID=" + siteID ,
		success: function(data){
			
		}
	});		
}

function DisplayActionForm(){
	//alert("ss");
	$.ajax({
		url: "/re-Design/ajax/DisplayNewActionForm.php" ,
		success: function(data){
			$('#actionForm').html(data);
			$('#actionForm').show();
		}
	});		
}

function HideNewActionForm()
{
	$('#actionForm').hide();
}

function SaveNewAction(){
	var typeID=document.getElementById('issueTypeID-1').value;
	var name=document.getElementById('name').value;
	var issueDescription=document.getElementById('issueDescription').value;
	var actionDescription=document.getElementById('actionDescription').value;
	$.ajax({
		url: "/re-Design/ajax/SaveNewAction.php?typeID=" + typeID +
												"&name=" + name +
												"&issueDescription=" + issueDescription +
												"&actionDescription=" + actionDescription ,
		success: function(){
			
			document.getElementById('issueTypeID-1').value="";
			document.getElementById('name').value="";
			document.getElementById('issueDescription').value="";
			document.getElementById('actionDescription').value="";
			var id=document.getElementById('issueTypeID').value;
			listActionListByType(id,1);
		}
	});		
}

function updateUserParameteres(userID, userMode, userPhase){
	if (typeof userMode === 'undefined' || !userMode)  { var userMode = 1; }
	if (typeof userPhase === 'undefined' || !userPhase)  { var userPhase = 1; }
	
	$.ajax({
		url: "/ajax/updateUserParameteres.php?userID=" + userID +
												"&userMode=" + userMode +
												"&userPhase=" + userPhase,
		success: function(data){
			$('#updateUserParameteres').html(data);
			$('#updateUserParameteres').show();
		}
	});
		
}

window.highlightCellsGreen = function(tableRow) {
    for (var index = 0; index < tableRow.childNodes.length; index++) {
        var row = tableRow.childNodes[index];
        if (row.style) {
            row.style.backgroundColor = "#dddddd";
        }
    }
};

window.unhighlightCellsGreen = function(tableRow) {
    for (var index = 0; index < tableRow.childNodes.length; index++) {
        var row = tableRow.childNodes[index];
        if (row.style) {
            row.style.backgroundColor = "#E8FFE8";
        }
    }
};



// Get Search Site By Name - For Site Selection
function SearchSiteByName()
{
	
	var searchSite = document.getElementById('SearchBySiteName').value;
	
	$.ajax({
		url: "/ajax/listSitesSelection.php?searchSiteName=" + searchSite,
		context: document.body,
		beforeSend: function(){
		   	$("#loaderDiv").show();
		  	$('#showSiteInfo').hide();
	    },
	    complete:function(){
	    	$('#loaderDiv').hide();
	    },
		success: function(data){
			$('#listSites').html(data);
			$('#listSites').show();
		}
	});	
	
	return false;
}



function loadCountryList()
{
	/*alert('testst');*/
	$.ajax({
		
			url: "/ajax/listCompanies.php",
			beforeSend: function(){ 
				$('#loaderDiv').show(); 
			},
			context: document.body,
			complete: function(){
				$('#loaderDiv').hide();
			},
			success: function(data){
				$('#companyList').html(data);
			}
		});
}

// List companies in Select List
function loadCompanyList()
{
	$.ajax({
		
		url: "/ajax/listCompanies.php",
		beforeSend: function(){ 
			$('#loaderDiv').show(); 
		},
		context: document.body,
		complete: function(){
			$('#loaderDiv').hide();
		},
		success: function(data){
			$('#companyList').html(data);
		}
	});
}
// Remove file
function removeIt(removeElement) 
{
	$(removeElement).remove();
}

function hideIt(hideElement)
{
	$(hideElement).hide();
}

function showIt(showElement) 
{
	$(showElement).show();
}

/**  
 * SUBMIT AJAX FORM  - Function
 * ========================================================================================================================
 * @param {formUrl}    = "Url to PHP Script with you want to work or get data";
 * @param {formIndant} = "Name of form which you want to Validate, Submit...";
 * @param {container}  = "Container you Want (if @param {overlay} true) to remowe After request been competed";
 * @param {overlay}    = "If overlay enabled will remove @param {container}"
 * @param {triger}     = "JavaScript Function you which you want to excute";
 * @param {validate}   = "if you dont want to validate form set FALSE if you want to form be validate set TRUE" IMPORTANT: Default = true 
 * ========================================================================================================================
 **/
function submitAjaxForm(formURL, formIndent, container, overlay, trigger, validate)
{
	
	var formData = $(formIndent).serializeArray();
	
	var formMethod = $(formIndent).attr('method');
	
	if(formMethod == 'get') { formMethod = 'GET'; }else{ formMethod = 'POST'; }
	
        if(container == "" || container == false || container == undefined){ container = false }
        if(overlay == "" || overlay == false || overlay == undefined) { overlay = false; }
        
	if (window[trigger] && (typeof window[trigger] == "function")) { window[trigger](); }

	if (trigger && (typeof trigger == "function")) { trigger(); }
	
	//validate form
	var formValid = $(formIndent).formValidator();
	
	if(validate == false) { formValid = true; }
	
	if(formValid == true){ 
	
		$.ajax({
			url: formURL,
			type: formMethod,
			data: formData,
			beforeSend:function(){ $('#loaderDiv').show(); },
			complete: function(data, status) { },
			success: function(data) { 
				//alert(JSON.stringify(data));
				if(overlay == true){
                                    $(container).remove();
                                    $('body').append(data);
				}else{
                                    $(container).html(data);
				}
				$('#loaderDiv').hide();
			},
                        error: function(){
                            //alert(status);
                            if(status == "error") {

                                var message = "Something is wrong contact support!";
                                if(container != false){

                                    if(overlay == false) {
                                        $(container).html(data);
                                        showOverlayMessage(message, 'info', container);
                                    } else {
                                        $(container).append(data);
                                        showOverlayMessage(message, 'info', true);
                                    }

                                } else {
                                    return message;
                                } 
                            }
                        }
		});
	}
	
	return false;
}
var ajaxResult = null;
function getDataFromAjax(url,sendData,typePost,container,overlay){
    ajaxResult = null;
    //alert(JSON.stringify(sendData));
    if(container == "" || container == false || container == undefined){ container = false }
    if(overlay == "" || overlay == false || overlay == undefined) { overlay = false; }
    //var dataReturn = null;
    var dataReturn = $.ajax({
        url: url,
        data: sendData,
        type: typePost,
        async: false, 
        error: function(data,status){ 
            ajaxResult = false;
            if(status == "error") {
                
                var message = "Something is wrong contact support!";
                if(container != false){
                    
                    if(overlay == false) {
                        $(container).html(data);
                        showOverlayMessage(message, 'info', container);
                    } else {
                        $(container).append(data);
                        showOverlayMessage(message, 'info', true);
                    }
                
                } else {
                    return message;
                }
            } 
        },
        success: function (data,status){
            if(status != 'error'){
                if(container != false){
                    if(overlay == false) {
                        $(container).html(data);
                    } else {
                        $(container).append(data);
                    }

                } else {
                    ///dataReturn = data;
                    //window.localStorage.setItem("dataReturn",data);
                    //dataReturn = window.localStorage.getItem("dataReturn"); 

                }
            }else{
                return "";
            }
        }
    }).responseText;
    //alert(ajaxResult);
    if(ajaxResult == false){ return false;}
    return dataReturn;
}



/**
 * UNIVERSAL AJAX PAGINATION
 * ============================================================================================================================================
 * @param urlPag           - URL to File you want to call
 * @param curPage          - courent page in requests 
 * @param offset           - offset for  litmit in database
 * @param query            - get request in a showing file, get data form $_GET put hire  (ex. $getAll = "&getAll" if set $_GET['all'])
 * @param forOrder         - get order Coloumn for database record Orders
 * @param orderType        - get param for data order (ASC & DESC)
 * @param container        - element id or class where you want to put new data default is #viewList 
 * @param orderTypeDisable - (TRUE AND FALSE - !STRING) to disable ASC & DSC 
 * 		in pagination and enable if is used for order
 * @param trigger          - start some function if you want, put function name
 * ============================================================================================================================================
 * HOW TO USE
 * -----------------------------------------------------------------------------------------------------------------------------------------------
 * This function parametars will be mostly incuded with PHP function @param ajaxPagination() and parametars from this function will be inluded in 
 * @param ajaxPagination() javascript function.
 * -----------------------------------------------------------------------------------------------------------------------------------------------
 * NOTICE: You will not use this function in code this function is mostly used in @LOCATED /ROOT/include/pagination.php file
 * ------------------------------------------------------------------------------------------------------------------------------------------------
 * PHP @param ajaxPagination() is @LOCATED in /ROOT/include/_function.php
 * ================================================================================================================================================
 **/
function ajaxPagination(urlPag ,curPage , offset, query, forOrder, orderType, container,  orderTypeDisable, trigger)
{
	
	if(container == "")          { container ='#viewList'; }
	if(trigger != "")             { trigger = null; }
	if(orderTypeDisable == true) { orderTypeDisable = true; } else { orderTypeDisable = false; }
	
	$.ajax({
		url: urlPag+"?curPage=" + curPage +
					"&offset=" + offset+
					"&" +query+
					"&orderType=" + orderType +
					"&forOrder=" + forOrder +
					"&orderTypeDisable=" + orderTypeDisable,
		context: document.body,	
		beforeSend: function()
		{
			$('#loaderDiv').show();		
		},
		complete: function()
		{
				
		},
		success: function(data)
		{
			$(container).html(data);
			$(container).show();
			$('#loaderDiv').hide();
		}	
	});
}

function ajaxGoTo(urlPag, maxPage, limit, query, forOrder, orderType, container,orderTypeDisable, trigger)
{
	//alert(urlPag);
	var curPage = parseInt($("#pageNumber").val());
	
	if(!isNaN(curPage)){
		
		if(+curPage >= +maxPage){
			curPage = maxPage;
		}else if(curPage < 1){
			curPage = 1;
		}
	}else{ 
		curPage = 1; 
	}
	
	var offset = (curPage * limit)-limit;
	ajaxPagination(urlPag ,curPage , offset, query, forOrder, orderType, container,  orderTypeDisable, trigger);
	
}

/**
 * Message box overlay container
 * ===============================================================================================
 * @param message  - Message text to show in contetn box
 * @param type     - Types of message to control CSS: (warning, message, information, fatal...)
 * ===============================================================================================
 **/
function showOverlayMessage(message, type, overlay){
	
	var typeInd      = "message";
	var overlayInd   = "true";
	var container    = "overlay";
        var putContainer = "body";
	$('.message-overlay').remove();
	
	if(typeInd != ""){
		typeInd = type;
	}
	
	if(overlay == true || overlay == "" || overlay == undefined){
            container = "overlay";
            overlay="overlay";
	}else{
            container = overlay;
            putContainer = overlay;
        }
        
        
        
        //alert(overlay);
	//alert(message);
	var messageInd = '<div id="message-overlay" class="message-'+container+' '+typeInd+'-color" onclick="this.remove()"><div class="message-container"><div class="message-icon '+typeInd+'"></div><div class="message-content">'+message+'</div></div>';
	setTimeout(function(){ $('.message-overlay').remove(); },5000);
	
	if(overlay == true || overlay == "" || overlay == undefined || overlay == "overlay"){
            $('body').append(messageInd);
        } else {
            $(putContainer).html(messageInd);
        }
       
	
}

/**
 * Clear Fields --- reset fields values
 * ==========================================================================
 * @param fields  (array OR one field) - Can be one field and can be array
 * ==========================================================================
 */
function ClearFields(fields)
{
	if(fields instanceof Array)
	{
		for(var i=0; i < fields.length; i++){
			$(fields[i]).val("");
		}
	}else{
		$(fields).val("");
	}
}

/**
 * UNIVERSAL Fill List
 * =========================================================================== 
 * @param container (string) - Element to add color  
 * @param list      (string) - Name of the list (for casees:)
 * @param condition (string) - Name of condition (for casess:) to colorise 
 * (does element have it)
 * @param class     (string) - 
 * ===========================================================================
 * HOW TO USE
 * ---------------------------------------------------------------------------
 * ===========================================================================
 **/
function fillList(container, list, condition,classe)
{
	$.ajax({
		
		url: "/include/fillColorConditionList.php",
		context: document.body,
		type: "POST",
		data: {'container':container, 'list':list, 'condition':condition },
		beforeSend: function(){
			
		},
		complete: function(data){
			//$('body').append(JSON.stringify(data));
		},
		success: function(data){
			//alert(JSON.stringify(data));
			var regionID = JSON.parse(data);

			
			$(jQuery.parseJSON(JSON.stringify(regionID))).each(function() {  
	        	$(container+ " option").filter('[value="'+this+'"]').addClass(classe) ;
			});
			
		}
		
	});
	
}

function disableIt(element, status)
{
	var inputs = $(element).find('input, textarea, select');
	for (var i = 0; inputs.length > i; i++) {
		var attrType = $(inputs[i]).attr('type');
				
		if(attrType != 'submit') {
			if(attrType != 'button') {
				if(status == true){ $(inputs[i]).attr('disabled','disabeled'); }
				if(status == false){ $(inputs[i]).removeAttr('disabled'); }
			}
		}
	}
}

function getGeoLocationByCords(lat,lng,container, action)
{
	
	alert(lat);

	var map;
	 
	  var mapOptions = {
	    zoom: 8,
	    center: new google.maps.LatLng(lat, lng)
	  };
	  map = new google.maps.Map(document.getElementById('maps'),
	      mapOptions);
	
	
	//google.maps.event.addDomListener(window, 'load', initialize);
	

	
	
	/*var geocoder = new google.maps.Geocoder();
	
	geocoder.geocode( { 'address': address}, function(results, status) {
	
	  if (status == google.maps.GeocoderStatus.OK) {
	    var latitude = results[0].geometry.location.lat();
	    var longitude = results[0].geometry.location.lng();
	    alert(longitude);
	
	
	    var latlng = new google.maps.LatLng(latitude, longitude);
	    var myOptions = {
	      zoom: 16,
	      center: latlng,
	      mapTypeId: google.maps.MapTypeId.ROADMAP
	    }
	    map = new google.maps.Map(document.getElementById("map"), myOptions);
	
	    var markerOptions = {
	    position: new google.maps.LatLng(latitude, longitude)
	};
	var marker = new google.maps.Marker(markerOptions);
	marker.setMap(map);
	  }
	});*/ 
}

function fillFormJSON(formIndent,dataJSON,sufix)
{
	if(sufix == "undefined") { sufix = ''; }
	
        var formIDS = (formIndent || "") + (sufix || "");
        $(formIDS + ' input[type=radio]', formIDS + 'input[type=checkbox]').removeAttr('checked'); 
	$.each(dataJSON, function(index, value){
            
            var res = (index || "") + (sufix || "");
            var formID = (formIndent || "") + (sufix || "");
            
            if(value instanceof Object){
                $.each(value, function(attrName, attrVal){
                    //alert(attrVal + ' - ' +attrName);
                    if(attrVal == 'remove'){
                        
                        $(formID + " " + '#' + res).removeAttr(attrName);
                    }else{
                        $(formID + " " + '#' + res).attr(attrName, attrVal);
                    }
                });
            } else { 
		
                // FOR radio and checked button
                if($('input[name='+index+'][value='+value+']') && 
                    $('input[name='+index+']').attr('type') == 'radio' ||
                    $('input[name='+index+']').attr('type') == 'checkbox'
                )
                {  
                    $(formID + ' input[name='+index+'][value='+value+']').attr('checked','checked');
                }
                if($(formID + " " +  '#'+ res).attr('type') || $(formID + " " +  '#'+ res).is('select')){
                    $(formID + " " +  '#'+ res).val(value);
                }else{
                    $(formID + " " +  '#'+ res).html(value);
                }
            }
	});
	
}

function clearForm(formName) 
{
	var inputs = $(formName).find('input, textarea, select');	
	
        var element    = new Array();
	var validation = true;
	var inputsName = new Array();
	
	for (var i = 0; inputs.length > i; i++) {
		var attrType = $(inputs[i]).attr('type');
		
		if(attrType != 'submit' && attrType != 'button' && attrType != '' && attrType != 'radio' && attrType != 'checkbox') {
                    $(inputs[i]).val('');
		}
                
                if(attrType == 'radio' || attrType == 'checkbox'){
                    $(inputs[i]).removeAttr('checked');
                }
		
		// Range
		if(attrType == "range") { $(inputs[i]).val(0); }
	}
	$('*[form-erase]').html('');
	
}

function displayCloudMessage(text){
	$('#cloudDiv').show();
	$('#cloudDiv').html(text);	
	$('#cloudDiv').delay(5000).fadeOut(300);
}
