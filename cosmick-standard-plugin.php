<?php
	/*
	 * Plugin Name: Cosmick Standard Plugin
	 * Plugin URI: http://cosmicktechnologies.com/
	 * Description: Just a standard WordPress plugin we use to keep the sites we work on up to date on the latest and greatest. Do be warned, this is tailored for our needs and it's not meant to be used in the consumer space
	 * Version: 0.1.1
	 * Author: Cosmick Technologies
	 * Author URI: http://cosmicktechnologies.com/
	 * License: GPL2
	 */

	define('WP_DEBUG_LOG', true);
	define('WP_DEBUG_DISPLAY', false);
	if (!defined('ABSPATH')) exit;

	include('theme-options.php');

	add_action('wp_head', function () {
		switch (strToLower(get_theme_mod('site_mode'))) {
			case 'dev':
				global $post;
				if (!is_user_logged_in()) {
					die('<meta http-equiv="refresh" content="0;URL=\'' . wp_login_url() . '\'" />');
				}
				break;
			case 'prev':
				global $post;
				if (!is_user_logged_in() && get_post($post)->post_name != 'preview') {
					die('<meta http-equiv="refresh" content="0;URL=\'' . get_permalink(get_page_by_path('preview')) . '\'" />');
				}
				break;
		}
	});

	include('shortcodes.php');

	add_theme_support('title-tag');

	add_filter('upload_mimes', function ($mimes) {
		$mimes['svg'] = 'image/svg+xml';
		return $mimes;
	});

	add_action('init', function () {
		if (!is_admin()) {
			wp_deregister_script('jquery');
			wp_register_script('jquery', '/wp-includes/js/jquery/jquery.js', FALSE, NULL, TRUE);
			wp_register_script('jquery-migrate', '/wp-includes/js/jquery/jquery-migrate.min.js', array('jquery'), NULL, TRUE);
		}
	});

	add_action('wp_head', function () {
		if (is_search()) {
			echo(do_shortcode('[analytics]'));
		}
	});

	add_action('admin_menu', function () {
		if (current_theme_supports('posts-to-articles')) {
			global $menu;
			global $submenu;

			$menu[5][0] = 'Articles';
			$menu[5][6] = 'dashicons-align-right';
			$submenu['edit.php'][5][0] = 'All Articles';
		}
	});

	add_action('init', function () {
		if (current_theme_supports('posts-to-articles')) {
			global $wp_post_types;

			$labels = &$wp_post_types['post']->labels;
			$labels->name = 'Articles';
			$labels->singular_name = 'Article';
			$labels->add_new = 'Add New';
			$labels->add_new_item = 'Add Article';
			$labels->edit_item = 'Edit Article';
			$labels->new_item = 'Articles';
			$labels->view_item = 'View Article';
			$labels->search_items = 'Search Articles';
			$labels->not_found = 'No Articles found';
			$labels->not_found_in_trash = 'No Articles found in Trash';
			$labels->all_items = 'All Articles';
			$labels->menu_name = 'Articles';
			$labels->name_admin_bar = 'Article';
		}
	});

	class BS3_Walker_Nav_Menu extends Walker_Nav_Menu {
		function display_element($element, &$children_elements, $max_depth, $depth, $args, &$output) {
			$id_field = $this->db_fields['id'];

			if (isset($args[0]) && is_object($args[0])) {
				$args[0]->has_children = !empty($children_elements[$element->$id_field]);
			}

			return parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
		}

		function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
			if (is_object($args) && !empty($args->has_children)) {
				$link_after = $args->link_after;
				$args->link_after = ' <b class="caret"></b>';
			}

			parent::start_el($output, $item, $depth, $args, $id);

			if (is_object($args) && !empty($args->has_children))
				$args->link_after = $link_after;
		}

		function start_lvl(&$output, $depth = 0, $args = array()) {
			$indent = '';
			$output .= "{$indent}<ul class=\"dropdown-menu list-unstyled\">";
		}
	}

	add_filter('nav_menu_link_attributes', function ($atts, $item, $args) {
		if ($args->has_children && current_theme_supports('bootstrap')) {
			$atts['data-hover'] = 'dropdown';
			$atts['data-toggle'] = 'dropdown';
			$atts['class'] = 'dropdown-toggle';
		}

		return $atts;
	}, 10, 3);

	add_action('admin_menu', function () {
		if (current_theme_supports('remove-comments')) {
			remove_menu_page('edit-comments.php');
		}
	});

	add_action('wp_before_admin_bar_render', function () {
		if (current_theme_supports('remove-comments')) {
			global $wp_admin_bar;
			$wp_admin_bar->remove_menu('comments');
		}
	});

	add_action('init', function () {
		if (current_theme_supports('remove-comments')) {
			remove_post_type_support('post', 'comments');
			remove_post_type_support('page', 'comments');
		}
	}, 100);