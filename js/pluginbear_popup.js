jQuery(function(){
	setTimeout(function(){
		jQuery("#pluginbear-popup-panel").css("margin-left","-"+(jQuery("#pluginbear-popup-panel").width()/2)+"px");
		jQuery(window).resize(function(){ jQuery("#pluginbear-popup-panel").css("margin-left","-"+(jQuery("#pluginbear-popup-panel").width()/2)+"px"); });
		jQuery("#pluginbear-popup-container, #pluginbear-popup-panel").fadeIn(300);
		jQuery("#pluginbear-popup-close a").click(function(){  
			jQuery("#pluginbear-popup-container, #pluginbear-popup-panel").fadeOut(300);  
		});
	},delay);
});