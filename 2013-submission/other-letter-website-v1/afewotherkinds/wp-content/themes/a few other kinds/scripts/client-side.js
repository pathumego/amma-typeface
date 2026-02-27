$(document).ready(function(){
	//PURE PATH TO IMAGE GENERATING PHP FILE
	var base = $(".preview img").attr("src");
	
	//GATHER IMAGE FOR FIRST TIME
	$(".preview img").attr("src",base+'?'+$("#realtime-form").serialize());
		
	//KEYUP EVENT AND NEW IMAGE GATHER
	$("#realtime-form input,textarea").stop().keyup(function(){
		$(".preview img").attr("src",base+'?'+$("#realtime-form").serialize());	
	});
		
	//GIVE URL TO USER
	$("#getResults").click(function(){
		$("#resultsUrl").val($(".preview img").attr("src"));
		$("#link").show("slow");
	});
	
});
