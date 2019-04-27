$(document).ready(function() {

	$("#hideLogin").click(function(){
    $("#login").animate({height: 'hide'},"slow");
    $("#register").delay(900).animate({height: 'show'},"slow");
	});

	$("#hideRegister").click(function(){
    $("#register").animate({height: 'hide'},"slow");
    $("#login").delay(900).animate({height: 'show'},"slow");;
	});
});
