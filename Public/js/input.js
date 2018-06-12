$(function()
{
	$(window).scroll(function()
	{
		var header_H = $(".header").height();
		if ( $(this).scrollTop() > header_H) 
		{
			$(".nav").css({"position":"fixed", "top":"0"});
		}else
		{
			$(".nav").css({"position":""});
		}
	});
});