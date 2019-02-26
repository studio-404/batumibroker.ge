$(document).ready(	
	function() {
		var $panel = $(".panel");
		var $container = $panel.find(".container");
		var $infoSec = $panel.find(".info-section");
		
		$container.wtRotator({
			width:725,
			height:426,
			thumb_width:24,
			thumb_height:24,
			button_width:24,
			button_height:24,
			button_margin:5,
			auto_start:true,
			delay:6000,
			transition:"diag.fade",
			transition_speed:800,
			block_size:75,
			vert_size:55,
			horz_size:50,
			cpanel_align:"BR",
			timer_align:"top",
			display_thumbs:false,
			display_dbuttons:true,
			display_playbutton:true,
			display_thumbimg:false,			
			display_side_buttons:false,
			tooltip_type:"image",
			display_numbers:true,
			display_timer:false,
			mouseover_pause:false,
			cpanel_mouseover:true,
			text_mouseover:false,
			text_effect:"fade",
			text_sync:true,
			shuffle:true,
			block_delay:25,
			vstripe_delay:73,
			hstripe_delay:183
		});
	}
);