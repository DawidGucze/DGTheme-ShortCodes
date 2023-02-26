// COLORS PICKER
jQuery(document).ready(function() {
	
	"use strict";

	if( typeof jQuery.wp === 'object' && typeof jQuery.wp.wpColorPicker === 'function' ) {
		jQuery( '#dgts_color' ).wpColorPicker();
	} else {
		jQuery( '#colorpicker' ).farbtastic( '#dgts_color' );
	}

});