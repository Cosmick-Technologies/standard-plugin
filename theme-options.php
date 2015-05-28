<?php
	add_action('customize_register', function ($wp_customize) {
		$wp_customize->remove_section('title_tagline');
		$wp_customize->remove_section('nav');
		$wp_customize->remove_section('static_front_page');
	}, 20);

	add_action('customize_register', function ($wp_customize) {
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

		$wp_customize->add_setting('site_mode', array(
			'default' => 'prod',
			'transport' => 'refresh'
		));

		$wp_customize->add_control(new WP_Customize_Control(
			$wp_customize, 'site_mode', array(
				'label' => 'Site Mode',
				'section' => 'misc',
				'settings' => 'site_mode',
				'type' => 'radio',
				'choices' => array(
					'prod' => 'Production',
					'dev' => 'Development',
					'prev' => 'Client Preview'
				)
			)
		));

		$wp_customize->add_setting('enabled_pages', array(
			'default' => '',
			'transport' => 'refresh'
		));
	});

	add_action('customize_register', function ($wp_customize) {
		if (strToLower(get_theme_mod('site_mode')) == 'prev') {
			$wp_customize->add_control(new WP_Customize_Control(
				$wp_customize, 'enabled_pages', array(
					'label' => 'Enabled Pages',
					'section' => 'misc',
					'settings' => 'enabled_pages',
					'type' => 'numbers'
				)
			));
		}
	}, 20);

	add_action('customize_register', function ($wp_customize) {
		class Customize_Number_Control extends WP_Customize_Control {
			public $type = 'numbers';

			public function render_content()
			{
				?>
				<label>
					<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
					<input type="number" size="2" step="2" min="0" value="<?php echo esc_attr(  $this->value() ); ?>" />
				</label>
				<?php
			}
		}
	});