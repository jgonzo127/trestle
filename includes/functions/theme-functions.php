<?php
/**
 * Trestle theme functions (front-end)
 *
 * Note: all admin theme functionality is located at: lib/admin/admin.php
 *
 * @since 1.0.0
 *
 * @package Trestle
 */

/*===========================================
 * Theme Setup
===========================================*/
add_action( 'after_setup_theme', 'trestle_add_theme_support' );
/**
 * Initialize Trestle defaults and theme options.
 *
 * @since    2.0.0
 */
function trestle_add_theme_support() {

	// Add HTML5 markup structure.
	add_theme_support( 'html5' );

	// Add viewport meta tag for mobile browsers.
	add_theme_support( 'genesis-responsive-viewport' );

	// Add support for footer widgets if specified in Trestle settings.
	add_theme_support( 'genesis-footer-widgets', trestle_get_option( 'footer_widgets_number' ) );

	if( ! trestle_get_option( 'disable_trestle_accessiblity' ) ) {
		//* Add Accessibility support.
		add_theme_support( 'genesis-accessibility', array( 'headings', 'drop-down-menu',  'search-form', 'skip-links', 'rems' ) );
	}

	//* Add Custom Background support.
	add_theme_support( 'custom-background' );

}

add_action( 'after_setup_theme', 'trestle_remove_genesis_css_enqueue' );
/**
 * Stop Genesis from enqueuing the child theme stylesheet in the usual way.
 *
 * @since    2.1.0
 */
function trestle_remove_genesis_css_enqueue() {

	remove_action( 'genesis_meta', 'genesis_load_stylesheet' );

}

/*===========================================
 * 3rd Party Libraries
===========================================*/

add_action( 'init', 'trestle_load_bfa' );
/**
 * Initialize the Better Font Awesome Library.
 *
 * @since  2.0.0
 */
function trestle_load_bfa() {

	// Better Font Awesome Library
	require_once trailingslashit( get_stylesheet_directory() ) . 'lib/better-font-awesome-library/better-font-awesome-library.php';

	// Set the library initialization args.
	$args = array(
			'version'             => 'latest',
			'minified'            => true,
			'remove_existing_fa'  => false,
			'load_styles'         => true,
			'load_admin_styles'   => true,
			'load_shortcode'      => true,
			'load_tinymce_plugin' => true,
	);

	// Initialize the Better Font Awesome Library.
	Better_Font_Awesome_Library::get_instance( $args );

}

/*===========================================
 * Header
===========================================*/

add_action( 'wp_enqueue_scripts', 'trestle_header_actions', 15 );
/**
 * Loads theme scripts and styles.
 *
 * @since  1.0.0
 */
function trestle_header_actions() {

	// Our main stylesheet.
	wp_enqueue_style( 'trestle', get_stylesheet_uri(), array(), TRESTLE_THEME_VERSION );

	// Google fonts.
	wp_enqueue_style( 'theme-google-fonts', '//fonts.googleapis.com/css?family=Lato:300,400,700' );

	// Theme jQuery.
	wp_enqueue_script( 'theme-jquery', get_stylesheet_directory_uri() . '/includes/js/theme-jquery.js', array( 'jquery' ), TRESTLE_THEME_VERSION, true );

	// Prepare and include some necessary variables.
	$mobile_nav_text = apply_filters( 'trestle_mobile_nav_text', __( 'Navigation', 'trestle' ) );
	wp_localize_script(
		'theme-jquery',
		'trestle_vars',
		array(
			'mobile_nav_text' => esc_attr( $mobile_nav_text ),
		)
	);

	// Get WP uploads directory.
	$upload_dir = wp_upload_dir();
	$upload_path = $upload_dir['basedir'];
	$upload_url = $upload_dir['baseurl'];

	// Custom CSS (if it exists).
	$custom_css_file = '/trestle/custom.css';
	if ( is_readable( $upload_path . $custom_css_file ) )
		wp_enqueue_style( 'trestle-custom-css', $upload_url . $custom_css_file );

	// Custom jQuery (if it exists).
	$custom_js_file = '/trestle/custom.js';
	if ( is_readable( $upload_path . $custom_js_file ) )
		wp_enqueue_script( 'trestle-custom-jquery', $upload_url . $custom_js_file, array( 'jquery' ), TRESTLE_THEME_VERSION, true );

}

add_action( 'wp_head', 'trestle_output_styles');
/**
 * Output the style element that contains all Customizer CSS.
 *
 * @since  2.0.0
 */
function trestle_output_styles() {

	$styles = array();
	$site_title_color                = trestle_get_option( 'site_title_color' );
	$site_description_color          = trestle_get_option( 'site_description_color' );
	$site_bg_color                   = trestle_get_option( 'site_bg_color' );
	$body_text_color                 = trestle_get_option( 'body_text_color' );
	$body_link_color                 = trestle_get_option( 'body_link_color' );
	$body_link_hover_color           = trestle_get_option( 'body_link_hover_color' );
	$entry_title_link_color          = trestle_get_option( 'entry_title_link_color' );
	$entry_title_link_hover_color    = trestle_get_option( 'entry_title_link_hover_color' );
	$header_bg_color                 = trestle_get_option( 'header_bg_color' );
	$menu_bg_color                   = trestle_get_option( 'menu_bg_color' );
	$menu_text_color                 = trestle_get_option( 'menu_text_color' );
	$menu_text_hover_color           = trestle_get_option( 'menu_text_hover_color' );
	$current_menu_item_color         = trestle_get_option( 'current_menu_item_color' );
	$sub_menu_bg_color               = trestle_get_option( 'sub_menu_bg_color' );
	$sub_menu_text_color             = trestle_get_option( 'sub_menu_text_color' );
	$sub_menu_text_hover_color       = trestle_get_option( 'sub_menu_text_hover_color' );
	$sidebar_text_color              = trestle_get_option( 'sidebar_text_color' );
	$widget_title_color              = trestle_get_option( 'widget_title_color' );
	$sidebar_link_color              = trestle_get_option( 'sidebar_link_color' );
	$sidebar_link_hover_color        = trestle_get_option( 'sidebar_link_hover_color' );
	$footer_bg_color                 = trestle_get_option( 'footer_bg_color' );
	$footer_text_color               = trestle_get_option( 'footer_text_color' );
	$footer_link_color               = trestle_get_option( 'footer_link_color' );
	$footer_link_hover_color         = trestle_get_option( 'footer_link_hover_color' );
	$footer_widgets_bg_color         = trestle_get_option( 'footer_widgets_bg_color' );
	$footer_widgets_text_color       = trestle_get_option( 'footer_widgets_text_color' );
	$footer_widgets_link_color       = trestle_get_option( 'footer_widgets_link_color' );
	$footer_widgets_link_hover_color = trestle_get_option( 'footer_widgets_link_hover_color' );
	$h1_text_color                   = trestle_get_option( 'h1_text_color' );
	$h2_text_color                   = trestle_get_option( 'h2_text_color' );
	$h3_text_color                   = trestle_get_option( 'h3_text_color' );
	$h4_text_color                   = trestle_get_option( 'h4_text_color' );
	$h5_text_color                   = trestle_get_option( 'h5_text_color' );
	$h6_text_color                   = trestle_get_option( 'h6_text_color' );
	$site_title_font_size            = trestle_get_option( 'site_title_font_size' );
	$site_description_font_size      = trestle_get_option( 'site_description_font_size' );
	$body_font_family                = trestle_get_option( 'body_font_family' );
	$h1_font_size                    = trestle_get_option( 'h1_font_size' );
	$h2_font_size                    = trestle_get_option( 'h2_font_size' );
	$h3_font_size                    = trestle_get_option( 'h3_font_size' );
	$h4_font_size                    = trestle_get_option( 'h4_font_size' );
	$h5_font_size                    = trestle_get_option( 'h5_font_size' );
	$h6_font_size                    = trestle_get_option( 'h6_font_size' );
	$h1_text_decoration              = trestle_get_option( 'h1_text_decoration' );
	$h2_text_decoration              = trestle_get_option( 'h2_text_decoration' );
	$h3_text_decoration              = trestle_get_option( 'h3_text_decoration' );
	$h4_text_decoration              = trestle_get_option( 'h4_text_decoration' );
	$h5_text_decoration              = trestle_get_option( 'h5_text_decoration' );
	$h6_text_decoration              = trestle_get_option( 'h6_text_decoration' );
	$h1_text_style                   = trestle_get_option( 'h1_text_style' );
	$h2_text_style                   = trestle_get_option( 'h2_text_style' );
	$h3_text_style                   = trestle_get_option( 'h3_text_style' );
	$h4_text_style                   = trestle_get_option( 'h4_text_style' );
	$h5_text_style                   = trestle_get_option( 'h5_text_style' );
	$h6_text_style                   = trestle_get_option( 'h6_text_style' );
	$layout                          = trestle_get_option( 'layout' );
	$google_font_code                = trestle_get_option( 'google_font_code' );

	if( ! trestle_get_option( 'disable_trestle_colors' ) ) {

		if ( ! empty( $site_title_color ) ) {
			$styles[] = '.site-title a, .site-title a:hover { color: ' . $site_title_color . '; }';
		}

		if ( ! empty( $site_description_color ) ) {
			$styles[] = '.site-description { color: ' . $site_description_color . '; }';
		}

		if ( ! empty( $site_bg_color ) ) {
			$styles[] = 'body.bubble { background-color: ' . $site_bg_color . '; }';
			$styles[] = 'body.boxed { background-color: ' . $site_bg_color . '; }';
		}

		if ( ! empty( $body_text_color ) ) {
			$styles[] = 'body { color: ' . $body_text_color . '; }';
		}

		if ( ! empty( $body_link_color ) ) {
			$styles[] = '.site-inner a { color: ' . $body_link_color . '; }';
		}

		if ( ! empty( $body_link_hover_color ) ) {
			$styles[] = '.site-inner a:hover { color: ' . $body_link_hover_color . '; }';
		}

		if ( ! empty( $entry_title_link_color ) ) {
			$styles[] = '.entry-title a { color: ' . $entry_title_link_color . '; }';
		}

		if ( ! empty( $entry_title_link_hover_color ) ) {
			$styles[] = '.entry-title a:hover { color: ' . $entry_title_link_hover_color . '; }';
		}

		if ( ! empty( $header_bg_color ) ) {
			$styles[] = '.site-header { background-color: ' . $header_bg_color . '; }';
		}

		if ( ! empty( $menu_bg_color ) ) {
			$styles[] = '.nav-primary, .nav-secondary { background-color: ' . $menu_bg_color . '; }';
		}

		if ( ! empty( $menu_text_color ) ) {
			$styles[] = '.nav-primary a, .nav-secondary a { color: ' . $menu_text_color . '; }';
		}

		if ( ! empty( $menu_text_hover_color ) ) {
			$styles[] = '.nav-primary a:hover, .nav-secondary a:hover { color: ' . $menu_text_hover_color . '; }';
		}

		if ( ! empty( $current_menu_item_color ) ) {
			$styles[] = '.nav-primary ul li.current-menu-item > a, .nav-primary ul li.current-menu-parent > a { color: ' . $current_menu_item_color . '; }';
		}

		if ( ! empty( $sub_menu_bg_color ) ) {
			$styles[] = '.nav-primary .sub-menu { background-color: ' . $sub_menu_bg_color . '; }';
		}

		if ( ! empty( $sub_menu_text_color ) ) {
			$styles[] = '.nav-primary .sub-menu a { color: ' . $sub_menu_text_color . '; }';
			$styles[] = '.nav-primary .sub-menu-toggle .sub-menu-toggle-span { background-color: ' . $sub_menu_text_color . '; }';
		}

		if ( ! empty( $sub_menu_text_hover_color ) ) {
			$styles[] = '.nav-primary .sub-menu a:hover { color: ' . $sub_menu_text_hover_color . '; }';
			$styles[] = '.nav-primary .sub-menu-toggle .sub-menu-toggle-span { background-color: ' . $sub_menu_text_hover_color . '; }';
		}

		if ( ! empty( $sidebar_text_color ) ) {
			$styles[] = '.sidebar-primary p { color: ' . $sidebar_text_color . '; }';
		}

		if ( ! empty( $widget_title_color ) ) {
			$styles[] = '.widgettitle { color: ' . $widget_title_color . '; }';
		}

		if ( ! empty( $sidebar_link_color ) ) {
			$styles[] = '.sidebar-primary a { color: ' . $sidebar_link_color . '; }';
		}

		if ( ! empty( $sidebar_link_hover_color ) ) {
			$styles[] = '.sidebar-primary a:hover { color: ' . $sidebar_link_hover_color . '; }';
		}

		if ( ! empty( $footer_bg_color ) ) {
			$styles[] = '.site-footer { background-color: ' . $footer_bg_color . '; }';
		}

		if ( ! empty( $footer_text_color ) ) {
			$styles[] = '.site-footer p { color: ' . $footer_text_color . '; }';
		}

		if ( ! empty( $footer_link_color ) ) {
			$styles[] = '.site-footer a { color: ' . $footer_link_color . '; }';
		}

		if ( ! empty( $footer_link_hover_color ) ) {
			$styles[] = '.site-footer a:hover { color: ' . $footer_link_hover_color . '; }';
		}

		if ( ! empty( $footer_widgets_bg_color ) ) {
			$styles[] = '.footer-widgets { background-color: ' . $footer_widgets_bg_color . '; }';
		}

		if ( ! empty( $footer_widgets_text_color ) ) {
			$styles[] = '.footer-widgets p { color: ' . $footer_widgets_text_color . '; }';
		}

		if ( ! empty( $footer_widgets_link_color ) ) {
			$styles[] = '.footer-widgets a { color: ' . $footer_widgets_link_color . '; }';
		}

		if ( ! empty( $footer_widgets_link_hover_color ) ) {
			$styles[] = '.footer-widgets a:hover { color: ' . $footer_widgets_link_hover_color . '; }';
		}

		if ( ! empty( $h1_text_color ) ) {
			$styles[] = 'h1 { color: ' . $h1_text_color . '; }';
		}

		if ( ! empty( $h2_text_color ) ) {
			$styles[] = 'h2 { color: ' . $h2_text_color . '; }';
		}

		if ( ! empty( $h3_text_color ) ) {
			$styles[] = 'h3 { color: ' . $h3_text_color . '; }';
		}

		if ( ! empty( $h4_text_color ) ) {
			$styles[] = 'h4 { color: ' . $h4_text_color . '; }';
		}

		if ( ! empty( $h5_text_color ) ) {
			$styles[] = 'h5 { color: ' . $h5_text_color . '; }';
		}

		if ( ! empty( $h6_text_color ) ) {
			$styles[] = 'h6 { color: ' . $h6_text_color . '; }';
		}
	}

	// Font size
	if ( ! empty( $site_title_font_size ) ) {
		$styles[] = '.site-title { font-size: ' . $site_title_font_size . '; }';
	}

	if ( ! empty( $site_description_font_size ) ) {
		$styles[] = '.site-description { font-size: ' . $site_description_font_size . '; }';
	}

	if ( ! empty( $body_font_family ) ) {
		$styles[] = 'body { font-family: "' . $body_font_family .  '", sans-serif; }';
	}

	if ( ! empty( $h1_font_size ) ) {
		$styles[] = 'h1 { font-size: ' . $h1_font_size . '; }';
	}

	if ( ! empty( $h2_font_size ) ) {
		$styles[] = 'h2 { font-size: ' . $h2_font_size . '; }';
	}

	if ( ! empty( $h3_font_size ) ) {
		$styles[] = 'h3 { font-size: ' . $h3_font_size . '; }';
	}

	if ( ! empty( $h4_font_size ) ) {
		$styles[] = 'h4 { font-size: ' . $h4_font_size . '; }';
	}

	if ( ! empty( $h5_font_size ) ) {
		$styles[] = 'h5 { font-size: ' . $h5_font_size . '; }';
	}

	if ( ! empty( $h6_font_size ) ) {
		$styles[] = 'h6 { font-size: ' . $h6_font_size . '; }';
	}

	// Text decoration
	if ( ! empty( $h1_text_decoration ) ) {
		$styles[] = 'h1 { text-decoration: ' . $h1_text_decoration . '; }';
	}

	if ( ! empty( $h2_text_decoration ) ) {
		$styles[] = 'h2 { text-decoration: ' . $h2_text_decoration . '; }';
	}

	if ( ! empty( $h3_text_decoration ) ) {
		$styles[] = 'h3 { text-decoration: ' . $h3_text_decoration . '; }';
	}

	if ( ! empty( $h4_text_decoration ) ) {
		$styles[] = 'h4 { text-decoration: ' . $h4_text_decoration . '; }';
	}

	if ( ! empty( $h5_text_decoration ) ) {
		$styles[] = 'h5 { text-decoration: ' . $h5_text_decoration . '; }';
	}

	if ( ! empty( $h6_text_decoration ) ) {
		$styles[] = 'h6 { text-decoration: ' . $h6_text_decoration . '; }';
	}

	// Text style
	if ( ! empty( $h1_text_style ) ) {
		$styles[] = 'h1 { text-transform: ' . $h1_text_style . '; }';
	}

	if ( ! empty( $h2_text_style ) ) {
		$styles[] = 'h2 { text-transform: ' . $h2_text_style . '; }';
	}

	if ( ! empty( $h3_text_style ) ) {
		$styles[] = 'h3 { text-transform: ' . $h3_text_style . '; }';
	}

	if ( ! empty( $h4_text_style ) ) {
		$styles[] = 'h4 { text-transform: ' . $h4_text_style . '; }';
	}

	if ( ! empty( $h5_text_style ) ) {
		$styles[] = 'h5 { text-transform: ' . $h5_text_style . '; }';
	}

	if ( ! empty( $h6_text_style ) ) {
		$styles[] = 'h6 { text-transform: ' . $h6_text_style . '; }';
	}

	// Google Font
	if ( ! empty( $google_font_code ) ) {
		echo $google_font_code;
	}

	printf(
	'<style type="text/css">%s</style>',
	implode( ' ', $styles )
	);

	error_log( print_r( $styles, true ) );

}

add_filter( 'genesis_pre_load_favicon', 'trestle_do_custom_favicon' );
/**
 * Output custom favicon if specified in the theme options.
 *
 * @since   1.0.0
 *
 * @param   string  $favicon_url  Default favicon URL.
 *
 * @return  string  Custom favicon URL (if specified), or the default URL.
 */
function trestle_do_custom_favicon( $favicon_url ) {

	$trestle_favicon_url = trestle_get_option( 'favicon_url' );
	return $trestle_favicon_url ? $trestle_favicon_url : $favicon_url;
}

/*===========================================
 * Body Classes
===========================================*/

add_filter( 'body_class', 'trestle_body_classes' );
/**
 * Adds custom classes to the <body> element for styling purposes.
 *
 * @since 1.0.0
 *
 * @param array $classes Body classes.
 * @return array 		 Updated body classes.
 */
function trestle_body_classes( $classes ) {

	// Add 'no-jquery' class to be removed by jQuery if enabled.
	$classes[] = 'no-jquery';

	// Add 'bubble' class.
	if ( 'bubble' == trestle_get_option( 'layout' ) )
		$classes[] = 'bubble';

	// Add 'boxed' class.
	if ( 'boxed' == trestle_get_option( 'layout' ) )
		$classes[] = 'boxed';

	// Add link icon classes.
	if ( trestle_get_option( 'external_link_icons' ) ) {
		$classes[] = 'external-link-icons';
	}
	if ( trestle_get_option( 'email_link_icons' ) ) {
		$classes[] = 'email-link-icons';
	}
	if ( trestle_get_option( 'pdf_link_icons' ) ) {
		$classes[] = 'pdf-link-icons';
	}
	if ( trestle_get_option( 'doc_link_icons' ) ) {
		$classes[] = 'doc-link-icons';
	}

	// Logo position
	if ( trestle_get_option( 'logo_position' ) ) {
		$classes[] = trestle_get_option( 'logo_position' );
	}

	// Add menu style class.
	$nav_primary_location = esc_attr( trestle_get_option( 'nav_primary_location' ) );
	if ( $nav_primary_location ) {
		$classes[] = 'nav-primary-location-' . $nav_primary_location;
	}

	// Add mobile menu toggle class.
	$mobile_nav_toggle = esc_attr( trestle_get_option( 'mobile_nav_toggle' ) );
	if ( 'big-button' == $mobile_nav_toggle ) {
		$classes[] = 'big-button-nav-toggle';
	} elseif ( 'small-icon' == $mobile_nav_toggle ) {
		$classes[] = 'small-icon-nav-toggle';
	}

	// Add footer widget number class.
	$footer_widgets_number = esc_attr( trestle_get_option( 'footer_widgets_number' ) );
	if ( $footer_widgets_number ) {
		$classes[] = 'footer-widgets-number-' . $footer_widgets_number;
	}

	// Add logo class.
	if ( trestle_get_option( 'logo_id' ) || trestle_get_option( 'logo_id_mobile' ) ) {
		$classes[] = 'has-logo';
	}

	// Add fullscreen search class.
	if ( trestle_get_option( 'fullscreen_search' ) ) {
		$classes[] = 'fullscreen-search';
	}

	return $classes;

}


/*===========================================
 * Header
===========================================*/

add_filter( 'genesis_seo_title', 'trestle_do_logos', 10, 3 );
/**
 * Output logos.
 *
 * @since 1.0.0
 */
function trestle_do_logos( $title, $inside, $wrap ) {

	$logo_id = trestle_get_option( 'logo_id' );
	$logo_id_mobile = trestle_get_option( 'logo_id_mobile' );
	$logo_html = '';

	// Regular logo.
	if ( $logo_id ) {

		// Default logo classes.
		$classes = array(
			'logo',
			'logo-full'
		);

		// If no mobile logo is specified, make regular logo act as mobile logo too.
		if( ! $logo_id_mobile ) {
			$classes[] = 'show';
		}

		// Prepare the classes.
		$logo_attr = array(
			'class'	=> implode( $classes, ' ' ),
		);

		// Build the <img> tag.
		$logo_html .= wp_get_attachment_image( $logo_id, 'full', false, $logo_attr );

	}

	// Mobile logo.
	if ( $logo_id_mobile ) {

		// Default mobile logo class.
		$classes = array(
			'logo',
			'logo-mobile'
		);

		// If no regular logo is specified, make mobile logo act as regular logo too.
		if( ! $logo_id )
			$classes[] = 'show';

		// Prepare the classes.
		$logo_attr = array(
			'class'	=> implode( $classes, ' ' ),
		);

		// Build the <img> tag.
		$logo_html .= wp_get_attachment_image( $logo_id_mobile, 'full', false, $logo_attr );

	}

	if ( $logo_html ) {
		$inside .= sprintf( '<a href="%s" title="%s" class="logos">%s</a>',
			trailingslashit( home_url() ),
			esc_attr( get_bloginfo( 'name' ) ),
			$logo_html
		);
	}

	// Build the title.
	$title  = genesis_html5() ? sprintf( "<{$wrap} %s>", genesis_attr( 'site-title' ) ) : sprintf( '<%s id="title">%s</%s>', $wrap, $inside, $wrap );
	$title .= genesis_html5() ? "{$inside}</{$wrap}>" : '';

	// Echo (filtered).
	return $title;

}


/*===========================================
 * Navigation
===========================================*/

add_action( 'wp_loaded', 'trestle_nav_primary_location' );
/**
 * Move primary navigation into the header if need be.
 *
 * This is hooked on wp_loaded instead of init because for some reason init
 * won't fire on the customizer preview.
 *
 * @since  1.2.0
 */
function trestle_nav_primary_location() {

	if ( 'header' == trestle_get_option( 'nav_primary_location' ) ) {
		remove_action( 'genesis_after_header', 'genesis_do_nav' );
		add_action( 'genesis_header', 'genesis_do_nav', 12 );
	}

}

add_filter( 'wp_nav_menu_items', 'trestle_custom_nav_extras', 10, 2 );
/**
 * Add custom nav extras.
 *
 * @since 1.0.0
 *
 * @param  string   $nav_items <li> list of menu items.
 * @param  stdClass $menu_args Arguments for the menu.
 * @return string   <li> list of menu items with custom navigation extras <li> appended.
 */
function trestle_custom_nav_extras( $nav_items, stdClass $menu_args ) {

	if ( 'primary' == $menu_args->theme_location && trestle_get_option( 'search_in_nav' ) ) {
		return $nav_items . '<li class="right custom">' . get_search_form( false ) . '</li>';
	}

	return $nav_items;
}

add_action( 'wp_footer', 'trestle_output_full_screen_search' );
/**
* Outputs the HTML markup for our Full Screen Search
* CSS hides this by default, and Javascript displays it when the user
* interacts with any WordPress search field
*
* @since 2.2.1
*/
function trestle_output_full_screen_search() {

	if ( trestle_get_option( 'fullscreen_search' ) ) {
		?>
		<div id="full-screen-search">
			<button type="button" class="close" id="full-screen-search-close">X</button>
			<form role="search" method="get" action="<?php echo home_url( '/' ); ?>" id="full-screen-search-form">
				<div id="full-screen-search-container">
					<input type="text" name="s" placeholder="<?php _e( 'Search' ); ?>" id="full-screen-search-input" />
				</div>
			</form>
		</div>
		<?php
	}

}

/*===========================================
 * Posts & Pages
===========================================*/

add_filter( 'post_class', 'trestle_post_classes' );
/**
 * Add extra classes to posts in certain situations.
 *
 * @since  2.2.0
 *
 * @param array $classes Post classes.
 * @return array 		 Updated post classes.
 */
function trestle_post_classes( $classes ) {

	// If post doesn't have a featured image.
	if ( ! has_post_thumbnail() ) {
		$classes[] = 'no-featured-image';
	}

	return $classes;

}

add_filter( 'wp_revisions_to_keep', 'trestle_update_revisions_number', 10, 2 );
/**
 * Sets the number of post revisions.
 *
 * @since  1.0.0
 *
 * @param  int $num Default number of post revisions.
 * @return int      Number of post revisions specified in Trestle admin panel.
 */
function trestle_update_revisions_number( $num ) {

	$trestle_revisions_number = esc_attr( trestle_get_option( 'revisions_number' ) );

	if ( isset( $trestle_revisions_number ) ) {
		return $trestle_revisions_number;
	}

	return $num;
}

add_filter( 'genesis_get_image_default_args', 'trestle_featured_image_fallback' );
/**
 * Unset Genesis default featured image fallback of 'first-attached'.
 *
 * This function prevents Genesis' default behavior of displaying
 * the 'first-attached' image as a post's featured image (in archive)
 * views, even when the post has no current featured image.
 *
 * @since 1.0.0
 *
 * @param array $args Default Genesis image args.
 * @return array Updated image args.
 */
function trestle_featured_image_fallback( $args ) {

	$args['fallback'] = false;

	return $args;
}


/*===========================================
 * General Actions & Filters
===========================================*/

add_filter( 'excerpt_more', 'trestle_read_more_link' );
add_filter( 'get_the_content_more_link', 'trestle_read_more_link' );
add_filter( 'the_content_more_link', 'trestle_read_more_link' );
/**
 * Displays custom Trestle "read more" text in place of WordPress default.
 *
 * @since 1.0.0
 *
 * @param string $default_text Default "read more" text.
 * @return string (Updated) "read more" text.
 */
function trestle_read_more_link( $default_text ) {

	// Get Trestle custom "read more" link text.
	$custom_text = esc_attr( trestle_get_option( 'read_more_text' ) );

	if ( $custom_text ) {
		return '&hellip;&nbsp;<a class="more-link" title="' . $custom_text . '" href="' . get_permalink() . '">' . $custom_text . '</a>';
	} else {
		return $default_text;
	}
}


/*===========================================
 * Helper Functions
===========================================*/

/**
 * Check if image has specified image size.
 *
 * @since 2.2.0
 *
 * @param int $image_id ID of image to check.
 * @param string $image_size Slug of image size to check for.
 *
 * @return true|false Whether or not the image has the specified size generated.
 */
function trestle_image_has_size( $image_id, $image_size = null ) {

	global $_wp_additional_image_sizes;

	// Return with error if no image_size is specified.
	if ( ! $image_size ) {
		return new WP_Error( 'no_image_size_specified', __( 'Please specify an image size.', 'trestle' ) );
	}

	// Get the attributes for the specified image size.
	$image_size_atts = $_wp_additional_image_sizes[ $image_size ];

	// Get data for specified image ID and size.
	$img_data = wp_get_attachment_image_src( $image_id, $image_size );

	// Check if the dimensions match.
	if ( $img_data[1] == $image_size_atts['width'] && $img_data[2] == $image_size_atts['height'] ) {
		return true;
	}

	return false;

}

/**
 * Check if post is, or is a child of, a target post.
 *
 * @since 1.0.0
 *
 * @param string $post_id   Post ID to check.
 * @param string $target_id Target post ID to check against.
 *
 * @return true|false
 */
function trestle_is_current_or_descendant_post( $post_id = '', $target_id = '' ) {

	// If the current post is the target post, return true.
	if ( $post_id == $target_id ) {
		return true;
	}

	// If the current post is a descendant of the target post.
	if ( in_array( $target_id, get_post_ancestors( $post_id ) ) ) {
		return true;
	}

	return false;

}