function stakeholderConn(connType){
	$.ajax({
		url: "/stakeholder/ajax/stakeholderConn.php?connType=" + connType,
		context: document.body,
		success: function(data){
			$('#stakeholderConn').html(data);
			$('#stakeholderConn').show();
			$('#employees').hide();
		}
	});	
}

function displayEmployee(connID, connName, connType){
	$.ajax({
		url: "/stakeholder/ajax/displayEmployee.php?connType=" + connType +
												"&connID=" + connID + 
												"&connName=" + connName,
		context: document.body,
		success: function(data){
			$('#employees').html(data);
			$('#employees').show();
		}
	});	
}
