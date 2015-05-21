<?php
	/*
	 * Plugin Name: Cosmick Standard Plugin
	 * Plugin URI: http://cosmicktechnologies.com/
	 * Description: Just a standard WordPress plugin we use to keep the sites we work on up to date on the latest and greatest. Do be warned, this is tailored for our needs and it's not meant to be used in the consumer space
	 * Version: 1.0
	 * Author: Cosmick Technologies
	 * Author URI: http://cosmicktechnologies.com/
	 * License: GPL2
	 */

	define('MAIN_VERSION', '1.0');

	defined('ABSPATH') or die('No script kiddies please!');

	function address_shortcode($attr) {
		$params = shortcode_atts(array('value' => null), $attr);
		$params['value'] = urlEncode($params['value']);

		return "http://maps.apple.com/?daddr={$params['value']}";
	}
	add_shortcode('address', 'address_shortcode');

	function phone_shortcode($attr) {
		$params = shortcode_atts(array('value' => null), $attr);
		$params['value'] = str_replace(array('(', ')', '-', ' '), '', $params['value']);

		return "tel:{$params['value']}";
	}
	add_shortcode('phone', 'phone_shortcode');

	function email_shortcode($attr) {
		$params = shortcode_atts(array('value' => null), $attr);

		return "mailto:{$params['value']}";
	}
	add_shortcode('email', 'email_shortcode');

	function analytics_shortcode($attr) {
		$params = shortcode_atts(array('id' => null), $attr);

		return "<script type=\"text/javascript\">var _gaq=_gaq||[];_gaq.push([\"_setAccount\",\"{$params['id']}\"]),_gaq.push([\"_trackPageview\"]),function(){var t=document.createElement(\"script\");t.type=\"text/javascript\",t.async=!0,t.src=(\"https:\"==document.location.protocol?\"https://ssl\":\"http://www\")+\".google-analytics.com/ga.js\";var e=document.getElementsByTagName(\"script\")[0];e.parentNode.insertBefore(t,e)}();</script>";
	}
	add_shortcode('analytics', 'analytics_shortcode');

	function add_analytics() {
		if (is_search()) {
			echo(do_shortcode('[analytics id="' . of_get_option('analytics_id') . '"]'));
		}
	}
	add_action('wp_head', 'add_analytics');

	function logo_settings($wp_customize) {
		$wp_customize->remove_section('title_tagline');
		$wp_customize->remove_section('nav');
		$wp_customize->remove_section('static_front_page');

		$wp_customize->add_section('main', array(
			'title' => 'Main',
			'priority' => 30
		));

		$wp_customize->add_setting('address', array(
			'default' => '',
			'transport' => 'refresh'
		));

		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize, 'address', array(
				'label' => 'Address',
				'section' => 'main',
				'settings' => 'address'
			)
		));

		$wp_customize->add_setting('phone', array(
			'default' => '',
			'transport' => 'refresh'
		));

		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize, 'phone', array(
				'label' => 'Phone Number',
				'section' => 'main',
				'settings' => 'phone'
			)
		));

		$wp_customize->add_setting('email', array(
			'default' => '',
			'transport' => 'refresh'
		));

		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize, 'email', array(
				'label' => 'Email',
				'section' => 'main',
				'settings' => 'email'
			)
		));

		$wp_customize->add_setting('hours', array(
			'default' => '',
			'transport' => 'refresh'
		));

		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize, 'hours', array(
				'label' => 'Hours of Operation',
				'section' => 'main',
				'settings' => 'hours'
			)
		));

		$wp_customize->add_section('logos', array(
			'title' => 'Logo',
			'priority' => 30
		));

		$wp_customize->add_setting('logo', array(
			'default' => '',
			'transport' => 'refresh'
		));

		$wp_customize->add_control(new WP_Customize_Image_Control(
			$wp_customize, 'logo', array(
				'label' => 'Normal',
				'section' => 'logos',
				'settings' => 'logo'
			)
		));

		$wp_customize->add_setting('logo-fallback', array(
			'default' => '',
			'transport' => 'refresh'
		));

		$wp_customize->add_control(new WP_Customize_Image_Control(
			$wp_customize, 'logo-fallback', array(
				'label' => 'Normal (Fallback)',
				'section' => 'logos',
				'settings' => 'logo-fallback'
			)
		));

		$wp_customize->add_section('footer', array(
			'title' => 'Footer',
			'priority' => 30
		));

		$wp_customize->add_setting('copyright', array(
			'default' => '',
			'transport' => 'refresh'
		));

		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize, 'copyright', array(
				'label' => 'Copyright',
				'section' => 'footer',
				'settings' => 'copyright'
			)
		));

		$wp_customize->add_section('social-media', array(
			'title' => 'Social Media',
			'priority' => 30
		));

		$wp_customize->add_setting('facebook', array(
			'default' => '',
			'transport' => 'refresh'
		));

		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize, 'facebook', array(
				'label' => 'Facebook URL',
				'section' => 'social-media',
				'settings' => 'facebook'
			)
		));

		$wp_customize->add_setting('twitter', array(
			'default' => '',
			'transport' => 'refresh'
		));

		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize, 'twitter', array(
				'label' => 'Twitter URL',
				'section' => 'social-media',
				'settings' => 'twitter'
			)
		));

		$wp_customize->add_setting('google-plus', array(
			'default' => '',
			'transport' => 'refresh'
		));

		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize, 'google-plus', array(
				'label' => 'Google Plus URL',
				'section' => 'social-media',
				'settings' => 'google-plus'
			)
		));

		$wp_customize->add_setting('linkedin', array(
			'default' => '',
			'transport' => 'refresh'
		));

		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize, 'linkedin', array(
				'label' => 'LinkedIn URL',
				'section' => 'social-media',
				'settings' => 'linkedin'
			)
		));

		$wp_customize->add_setting('youtube', array(
			'default' => '',
			'transport' => 'refresh'
		));

		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize, 'youtube', array(
				'label' => 'YouTube URL',
				'section' => 'social-media',
				'settings' => 'youtube'
			)
		));

		$wp_customize->add_section('misc', array(
			'title' => 'Misc',
			'priority' => 30
		));

		$wp_customize->add_setting('analytics_id', array(
			'default' => '',
			'transport' => 'refresh'
		));

		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize, 'analytics_id', array(
				'label' => 'Google Analytics ID',
				'section' => 'misc',
				'settings' => 'analytics_id'
			)
		));
	}
	add_action('customize_register', 'logo_settings');