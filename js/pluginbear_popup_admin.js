jQuery(function(){
	jQuery("#content_type").on("change",function(){
		jQuery(".popup_cont").hide();
		jQuery("."+jQuery(":selected",this).val()+"_cont").fadeIn();
	});
	
	jQuery("#background").ColorPicker({
		onBeforeShow: function () {
			jQuery(this).ColorPickerSetColor(this.value);
		},
		onShow: function (colpkr) {
			jQuery(colpkr).fadeIn(500);
			return false;
		},
		onHide: function (colpkr) {
			jQuery(colpkr).fadeOut(500);
			return false;
		},
		onChange: function (hsb, hex, rgb, colpkr) {
			jQuery("#background").val('#'+hex);
			jQuery("#pluginbear-preview-popup-container").css('background','#'+hex);
			jQuery("#pluginbear-preview-popup-close a").css('color','#'+hex);
		}
	});
	
	jQuery("#foreground").ColorPicker({
		onBeforeShow: function () {
			jQuery(this).ColorPickerSetColor(this.value);
		},
		onShow: function (colpkr) {
			jQuery(colpkr).fadeIn(500);
			return false;
		},
		onHide: function (colpkr) {
			jQuery(colpkr).fadeOut(500);
			return false;
		},
		onChange: function (hsb, hex, rgb, colpkr) {
			jQuery("#foreground").val('#'+hex);
			jQuery("#pluginbear-preview-popup-panel").css('background','#'+hex);
		}
	});
	
	jQuery("#background_slider").slider({
		value:jQuery("#opacity").val(),
		min:0,
		max:1,
		step:0.05,
		slide: function( event, ui ) {
			jQuery("#opacity").val(ui.value);
			jQuery("#pluginbear-preview-popup-container").css('opacity',ui.value);
		}
	});
	
	jQuery("#radius_slider").slider({
		value:jQuery("#border_radius").val(),
		min:0,
		max:100,
		step:1,
		slide: function( event, ui ) {
			jQuery("#border_radius").val(ui.value);
			jQuery("#pluginbear-preview-popup-panel").css('border-radius',ui.value+"px");
		}
	});
	
	jQuery("#like_text").live("keyup",function(){
		jQuery("#like_text_preview,#like_text_snippet").text(jQuery(this).val());
	});
	
	jQuery("#custom_url").live("keyup",function(){
		jQuery("#custom_url_preview").text(jQuery(this).val());
	});
	
	function hexToR(h) {return parseInt((cutHex(h)).substring(0,2),16)}
	function hexToG(h) {return parseInt((cutHex(h)).substring(2,4),16)}
	function hexToB(h) {return parseInt((cutHex(h)).substring(4,6),16)}
	function cutHex(h) {return (h.charAt(0)=="#") ? h.substring(1,7):h}
});