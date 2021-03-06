<?php
	function register_sidebar_easy($NAME) {
		$SLUG = preg_replace('/\s/', '-', strToLower($NAME));

		register_sidebar(array(
			'name' => UcWords(strToLower($NAME)),
			'id' => $SLUG,
			'before_widget' => '<div class="widget">',
			'after_widget' => '</div>',
			'before_title' => '<h3>',
			'after_title' => '</h3>'
		));
	}

	function register_post_type_easy($SLUG, $ICON, $PARAMS) {
		$SLUG = preg_replace('/\s/', '', strToLower($SLUG));

		if (!in_array('untouched', $PARAMS)) {
			$PARAMS['label'][0] = UcWords(strToLower($PARAMS['label'][0]));
			$PARAMS['label'][1] = UcWords(strToLower($PARAMS['label'][1]));
		}

		register_post_type($SLUG, array(
			'labels' => array(
				'name' => $PARAMS['label'][1],
				'singular_name' => $PARAMS['label'][0],
				'add_new_item' => sprintf('Add New %s', $PARAMS['label'][0]),
				'edit_item' => sprintf('Edit %s', $PARAMS['label'][0]),
				'new_item' => sprintf('New %s', $PARAMS['label'][0]),
				'view_item' => sprintf('View %s', $PARAMS['label'][0]),
				'search_items' => sprintf('Search %s', $PARAMS['label'][1]),
				'not_found' => sprintf('No %s Found', $PARAMS['label'][1]),
				'not_found_in_trash' => sprintf('No %s found in Trash', $PARAMS['label'][1]),
				'menu_name' => (isset($PARAMS['label'][2])) ? $PARAMS['label'][2] : UcWords($SLUG)
			),
			'hierarchical' => (in_array('hierarchical', $PARAMS)) ? true : false,
			'supports' => (in_array('thumbnail', $PARAMS)) ? array('title', 'editor', 'revisions', 'thumbnail') : array('title', 'editor', 'revisions'),
			'public' => (in_array('public', $PARAMS)) ? true : false,
			'show_ui' => true,
			'show_in_menu' => (isset($PARAMS['location'])) ? $PARAMS['location'] : true,
			'menu_position' => 20,
			'menu_icon' => $ICON,
			'show_in_nav_menus' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => (in_array('exclude_from_search', $PARAMS)) ? true : false,
			'has_archive' => (in_array('archive', $PARAMS)) ? true : false,
			'query_var' => true,
			'can_export' => true,
			'rewrite' => (is_array($PARAMS['rewrite']) || $PARAMS['rewrite'] == false) ? $PARAMS['rewrite'] : true,
			'capability_type' => 'post'
		));
	}

	add_filter('post_type_link', function($post_link, $id = 0, $leavename) {
		if (strpos('%post_id%', $post_link) === 'FALSE') {
			return $post_link;
		}

		$post = &get_post($id);
		if (is_wp_error($post)) {
			return $post_link;
		}
		return str_replace('%post_id%', $post->ID, $post_link);
	}, 1, 3);

	function register_taxonomy_easy($SLUG, $POST_TYPE, $PARAMS) {
		$SLUG = preg_replace('/\s/', '', strToLower($SLUG));

		if (!in_array('untouched', $PARAMS)) {
			$PARAMS['label'][0] = UcWords(strToLower($PARAMS['label'][0]));
			$PARAMS['label'][1] = UcWords(strToLower($PARAMS['label'][1]));
		}

		register_taxonomy($SLUG, $POST_TYPE, array(
			'labels' => array(
				'name' => $PARAMS['label'][1],
				'singular_name' => $PARAMS['label'][0],
				'add_new_item' => sprintf('Add New %s', $PARAMS['label'][0]),
				'edit_item' => sprintf('Edit %s', $PARAMS['label'][0]),
				'new_item' => sprintf('New %s', $PARAMS['label'][0]),
				'view_item' => sprintf('View %s', $PARAMS['label'][1]),
				'search_items' => sprintf('Search %s', $PARAMS['label'][1]),
				'not_found' => sprintf('No %s Found', $PARAMS['label'][1]),
				'not_found_in_trash' => sprintf('No %s found in Trash', $PARAMS['label'][1]),
				'menu_name' => (isset($PARAMS['label'][2])) ? $PARAMS['label'][2] : UcWords($SLUG)
			),
			'hierarchical' => (in_array('hierarchical', $PARAMS)) ? true : false,
			'query_var' => $SLUG,
			'rewrite' => (in_array('rewrite', $PARAMS)) ? true : false,
			'public' => (in_array('public', $PARAMS)) ? true : false,
			'show_ui' => true,
			'show_admin_column' => true,
			'show_in_quick_edit' => true
		));
	}

	function register_tags_easy($SLUG, $POST_TYPE) {
		global $wp_rewrite;

		register_taxonomy($SLUG, $POST_TYPE, array(
			'hierarchical' => false,
			'query_var' => $SLUG,
			'rewrite' => array(
				'hierarchical' => false,
				'slug' => get_option('tag_base') ? get_option('tag_base') : 'tag',
				'with_front' => !get_option('tag_base') || $wp_rewrite->using_index_permalinks(),
				'ep_mask' => EP_TAGS,
			),
			'public' => true,
			'show_ui' => true,
			'show_admin_column' => true
		));
	}

	function register_audio_js() {
		add_action('wp_footer', function() {
?>
<script>
jQuery(function($) {
  $('.block#audio-track').each(function(index) {
    var audio = $(this).find('audio');

    audio.attr('id', 'audio-' + index);
    audio.prop('volume', 0.8);
  });

  $(document).on('click', '.block#audio-track [play]', function(e) {
    e.preventDefault();

    $(this).parents('.block#audio-track').first().find('[play-swap]').trigger('click');
  });

  $(document).on('click', '.block#audio-track [play-swap]', function(e) {
    e.preventDefault();

	_gaq.push(['_trackEvent', 'Audio', 'clicked']);

    var parent = $(this).parents('.block#audio-track').first();

    $(this).addClass('hide');
    parent.find('audio').trigger('play');
    parent.find('[pause-swap]').removeClass('hide');
    parent.find('[stop]').removeClass('hide');
  });

  $(document).on('click', '.block#audio-track [pause-swap]', function(e) {
    e.preventDefault();

    var parent = $(this).parents('.block#audio-track').first();

    $(this).addClass('hide');
    parent.find('audio').trigger('pause');
    parent.find('[play-swap]').removeClass('hide');
  });

  $(document).on('click', '.block#audio-track [stop]', function(e) {
    e.preventDefault();

    var parent = $(this).parents('.block#audio-track').first();

    parent.find('[pause-swap],[pause]').trigger('click');
    parent.find('audio').prop('currentTime', 0);
  });
});
</script>
<?php
		}, 100);
	}