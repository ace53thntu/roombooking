$(document).ready(function() {
	
	// Expand Panel
	$("#open").click(function(){
		$("div#panel").slideDown("normal");
	
	});	
	
	// Collapse Panel
	$("#close").click(function(){
		$("div#panel").slideUp("normal");	
	});		
	
	// Switch buttons from "Log In | Register" to "Close Panel" on click
	$("#toggle a").click(function () {
		$("#toggle a").toggle();
	});		
		
});