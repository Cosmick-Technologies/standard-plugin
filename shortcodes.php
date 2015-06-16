<?php
	add_shortcode('address', function ($attr) {
		$params = shortcode_atts(array('value' => null), $attr);
		$params['value'] = urlEncode($params['value']);

		return "http://maps.apple.com/?q={$params['value']}";
	});

	add_shortcode('phone', function ($attr) {
		$params = shortcode_atts(array('value' => null), $attr);
		$params['value'] = str_replace(array('(', ')', '-', ' '), '', $params['value']);

		return "tel:{$params['value']}";
	});

	add_shortcode('email', function ($attr) {
		$params = shortcode_atts(array('value' => null), $attr);

		return "mailto:{$params['value']}";
	});

	add_shortcode('analytics', function () {
		return '<script type="text/javascript">var _gaq=_gaq||[];_gaq.push(["_setAccount","' . get_theme_mod('analytics_id') . '"]),_gaq.push(["_trackPageview"]),function(){var t=document.createElement("script");t.type="text/javascript",t.async=!0,t.src=("https:"==document.location.protocol?"https://ssl":"http://www")+".google-analytics.com/ga.js";var e=document.getElementsByTagName("script")[0];e.parentNode.insertBefore(t,e)}();</script>';
	});

	add_shortcode('html_audio', function($attr) {
		register_audio_js();
		$PARAMS = shortcode_atts(array('src' => '', 'align' => 'right', 'controls' => ''), $attr, 'html_audio');

		$HTML = sprintf('<div class="text-%s block" id="audio-track">', $PARAMS['align']);
		$HTML .= sprintf('<audio src="%s" preload="metadata"></audio>', $PARAMS['src']);
		$HTML .= sprintf('<div class="controls">%s</div>', html_entity_decode($PARAMS['controls']));
		$HTML .= '</div>';

		return $HTML;
	});

	