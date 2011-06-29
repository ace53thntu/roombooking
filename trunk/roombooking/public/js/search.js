$().ready(function(){
	$baseUrl = $("#baseUrl").val();
	$("#SearchForm #city_part").live("change", function() {
		$.ajax({
  		  url: $baseUrl + '/search/fetchhotelajax',
  		  type: 'post',
  		  dataType: 'json',
  		  async: true,
  		  data: ({'city_part' : $("#city_part").val(), 'room_id' : $("#room_id").val()}),
  		  success: function(data) {
			var $formId = "SearchForm";
			$("form[id='"+$formId+"']").find("#hotel_id").empty().append(data.hotels);
			$("form[id='"+$formId+"']").find("#room_id").empty().append(data.rooms);
			$("form[id='"+$formId+"']").find("#hotel_id-label,#hotel_id-element").show();
			$("form[id='"+$formId+"']").find("#room_id-label,#room_id-element").show();
  		  }});
	});
	
	$("#SearchForm #hotel_id").live("change", function() {
		$.ajax({
  		  url: $baseUrl + '/search/fetchroomajax',
  		  type: 'post',
  		  dataType: 'json',
  		  async: true,
  		  data: ({'city_part' : $("#city_part").val(), 'room_id' : $("#room_id").val()}),
  		  success: function(data) {
			var $formId = "SearchForm";
			$("form[id='"+$formId+"']").find("#room_id").empty().append(data.rooms);
			$("form[id='"+$formId+"']").find("#room_id-label,#room_id-element").show();
  		  }});
	});
});