<?php
/**
 * Initialize the options before anything else. 
 */
add_action( 'admin_init', 'shopera_theme_options', 1 );

/**
 * Build the custom settings & update OptionTree.
 */
function shopera_theme_options() {
  /**
   * Get a copy of the saved settings array. 
   */
  $saved_settings = get_option( 'option_tree_settings', array() );
  
  /**
   * Custom settings array that will eventually be 
   * passes to the OptionTree Settings API Class.
   */
  $shopera_settings = array(
	'sections'        => array(
	  array(
		'id'          => 'general',
		'title'       => 'General'
	  ),
	  array(
		'id'          => 'fonts',
		'title'       => 'Fonts'
	  ),
	  array(
		'id'          => 'slider',
		'title'       => 'Slider'
	  ),
	  array(
		'id'          => 'blog',
		'title'       => 'Blog'
	  )
	),
	'settings'        => array(
		array(
			'id'           => 'website_logo',
			'label'        => __( 'Website logo', 'shopera' ),
			'desc'         => sprintf( __( 'Please upload your logo.', 'shopera' ), apply_filters( 'ot_upload_text', __( 'Send to OptionTree', 'shopera' ) ), 'FTP' ),
			'std'          => '',
			'type'         => 'upload',
			'section'      => 'general',
			'rows'         => '',
			'post_type'    => '',
			'taxonomy'     => '',
			'min_max_step' => '',
			'class'        => '',
			'condition'    => '',
			'operator'     => 'and'
		),
		array(
			'id'          => 'copyright_text',
			'label'       => __( 'Copyright', 'shopera' ),
			'desc'        => __( 'Please provide short copyright text which will be shown in footer.', 'shopera' ),
			'std'         => '',
			'type'        => 'text',
			'section'     => 'general',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => '',
			'condition'   => '',
			'operator'    => 'and'
		),
		array(
			'id'           => 'show__scroll_to_top__button',
			'label'        => __( 'Show "Scroll to Top" button', 'shopera' ),
			'desc'         => __( 'Do you want to show "Scroll to Top" button?', 'shopera' ),
			'std'          => 'false',
			'type'         => 'checkbox',
			'section'      => 'general',
			'rows'         => '',
			'post_type'    => '',
			'taxonomy'     => '',
			'min_max_step' => '',
			'class'        => '',
			'condition'    => '',
			'operator'     => 'and',
			'choices'      => array( 
				array(
					'value' => 'true',
					'label' => __( 'Show', 'shopera' ),
					'src'   => ''
				)
			)
		),
		array(
			'id'           => 'favicon',
			'label'        => __( 'Favicon', 'shopera' ),
			'desc'         => sprintf( __( 'Do you have favicon?', 'shopera' ), apply_filters( 'ot_upload_text', __( 'Send to OptionTree', 'shopera' ) ), 'FTP' ),
			'std'          => '',
			'type'         => 'upload',
			'section'      => 'general',
			'rows'         => '',
			'post_type'    => '',
			'taxonomy'     => '',
			'min_max_step' => '',
			'class'        => '',
			'condition'    => '',
			'operator'     => 'and'
		),
		array(
			'id'          => 'shopera_layout_style',
			'label'       => 'Layout',
			'desc'        => 'Choose a layout for your theme',
			'std'         => 'full',
			'type'        => 'radio-image',
			'section'     => 'general',
			'class'       => '',
			'choices'     => array(
				array(
					'value'   => 'left',
					'label'   => 'Left Sidebar',
					'src'     => OT_URL . '/assets/images/layout/left-sidebar.png'
				),
				array(
					'value'   => 'full',
					'label'   => 'Full Width (no sidebar)',
					'src'     => OT_URL . '/assets/images/layout/full-width.png'
				),
				array(
					'value'   => 'right',
					'label'   => 'Right Sidebar',
					'src'     => OT_URL . '/assets/images/layout/right-sidebar.png'
				)
			)
		),
		array(
			'id'           => 'google_font_roboto',
			'label'        => __( 'Roboto font', 'shopera' ),
			'desc'         => __( 'If there are characters in your language that are not supported by Roboto, disable this option.', 'shopera' ),
			'std'          => 'on',
			'type'         => 'on-off',
			'section'      => 'fonts',
			'rows'         => '',
			'post_type'    => '',
			'taxonomy'     => '',
			'min_max_step' => '',
			'class'        => '',
			'condition'    => '',
			'operator'     => 'and',
			'choices'      => array( 
				array(
					'value' => 'off',
					'label' => __( 'Disable', 'shopera' ),
					'src'   => ''
				)
			)
		),
		array(
			'id'           => 'google_font_roboto_slab',
			'label'        => __( 'Roboto Slab font', 'shopera' ),
			'desc'         => __( 'If there are characters in your language that are not supported by Roboto Slab, disable this option.', 'shopera' ),
			'std'          => 'on',
			'type'         => 'on-off',
			'section'      => 'fonts',
			'rows'         => '',
			'post_type'    => '',
			'taxonomy'     => '',
			'min_max_step' => '',
			'class'        => '',
			'condition'    => '',
			'operator'     => 'and',
			'choices'      => array( 
				array(
					'value' => 'off',
					'label' => __( 'Disable', 'shopera' ),
					'src'   => ''
				)
			)
		),
		array(
			'id'           => 'google_font_open_sans',
			'label'        => __( 'Open Sans font', 'shopera' ),
			'desc'         => __( 'If there are characters in your language that are not supported by Open Sans, disable this option.', 'shopera' ),
			'std'          => 'on',
			'type'         => 'on-off',
			'section'      => 'fonts',
			'rows'         => '',
			'post_type'    => '',
			'taxonomy'     => '',
			'min_max_step' => '',
			'class'        => '',
			'condition'    => '',
			'operator'     => 'and',
			'choices'      => array( 
				array(
					'value' => 'off',
					'label' => __( 'Disable', 'shopera' ),
					'src'   => ''
				)
			)
		),
		array(
			'id'           => 'google_font_satisfy',
			'label'        => __( 'Satisfy font', 'shopera' ),
			'desc'         => __( 'If there are characters in your language that are not supported by Satisfy, disable this option.', 'shopera' ),
			'std'          => 'on',
			'type'         => 'on-off',
			'section'      => 'fonts',
			'rows'         => '',
			'post_type'    => '',
			'taxonomy'     => '',
			'min_max_step' => '',
			'class'        => '',
			'condition'    => '',
			'operator'     => 'and',
			'choices'      => array( 
				array(
					'value' => 'off',
					'label' => __( 'Disable', 'shopera' ),
					'src'   => ''
				)
			)
		),
		array(
			'id'           => 'google_font_roboto_condensed',
			'label'        => __( 'Roboto Condensed font', 'shopera' ),
			'desc'         => __( 'If there are characters in your language that are not supported by Roboto Condensed, disable this option.', 'shopera' ),
			'std'          => 'on',
			'type'         => 'on-off',
			'section'      => 'fonts',
			'rows'         => '',
			'post_type'    => '',
			'taxonomy'     => '',
			'min_max_step' => '',
			'class'        => '',
			'condition'    => '',
			'operator'     => 'and',
			'choices'      => array( 
				array(
					'value' => 'off',
					'label' => __( 'Disable', 'shopera' ),
					'src'   => ''
				)
			)
		),
		array(
			'id'           => 'large_logo_font_size',
			'label'        => __( 'Large logo font size', 'shopera' ),
			'desc'         => __( 'Set the font size for main logo.', 'shopera' ),
			'std'          => '50',
			'type'         => 'numeric-slider',
			'section'      => 'fonts',
			'min_max_step' => '10,80,1'
		),
		array(
			'id'           => 'scrolled_logo_font_size',
			'label'        => __( 'Scrolled logo font size', 'shopera' ),
			'desc'         => __( 'Set the font size for main logo when the page is scrolled.', 'shopera' ),
			'std'          => '34',
			'type'         => 'numeric-slider',
			'section'      => 'fonts',
			'min_max_step' => '10,80,1'
		),
		array(
			'id'           => 'slider_main_state',
			'label'        => __( 'Slider status', 'shopera' ),
			'desc'         => __( 'Turn the front page slider on or off.', 'shopera' ),
			'std'          => 'on',
			'type'         => 'on-off',
			'section'      => 'slider',
			'rows'         => '',
			'post_type'    => '',
			'taxonomy'     => '',
			'min_max_step' => '',
			'class'        => '',
			'condition'    => '',
			'operator'     => 'and',
			'choices'      => array( 
				array(
					'value' => 'off',
					'label' => __( 'Disable', 'shopera' ),
					'src'   => ''
				)
			)
		),
		array(
			'id'          => 'slider_main_tag',
			'label'       => __( 'Slider main post tag', 'shopera' ),
			'desc'        => __( 'Please provide tag for main posts inside slider.', 'shopera' ),
			'std'         => '',
			'type'        => 'text',
			'section'     => 'slider',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => '',
			'condition'   => '',
			'operator'    => 'and'
		),
		array(
			'id'          => 'slider_side_tag',
			'label'       => __( 'Slider side post tag', 'shopera' ),
			'desc'        => __( 'Please provide tag for side posts inside slider.', 'shopera' ),
			'std'         => '',
			'type'        => 'text',
			'section'     => 'slider',
			'rows'        => '',
			'post_type'   => '',
			'taxonomy'    => '',
			'min_max_step'=> '',
			'class'       => '',
			'condition'   => '',
			'operator'    => 'and'
		),
		array(
			'id'           => 'blog_post_grid',
			'label'        => __( 'Post grid status.', 'shopera' ),
			'desc'         => __( 'Display posts in a grid.', 'shopera' ),
			'std'          => 'on',
			'type'         => 'on-off',
			'section'      => 'blog',
			'rows'         => '',
			'post_type'    => '',
			'taxonomy'     => '',
			'min_max_step' => '',
			'class'        => '',
			'condition'    => '',
			'operator'     => 'and',
			'choices'      => array( 
				array(
					'value' => 'off',
					'label' => __( 'Disable', 'shopera' ),
					'src'   => ''
				)
			)
		)
	)
  );
  
  /* settings are not the same update the DB */
  if ( $saved_settings !== $shopera_settings ) {
	update_option( 'option_tree_settings', $shopera_settings ); 
  }
  
}