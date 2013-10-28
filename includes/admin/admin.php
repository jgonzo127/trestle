<?php
/*===========================================
 * Genesis Custom Theme Settings
 *
 * Modified from: http://www.billerickson.net/genesis-theme-options/
===========================================*/
 
/**
 * Register Defaults
 *
 * @param array $defaults
 * @return array modified defaults
 *
 */
 
function trestle_custom_defaults( $defaults ) {
 
	$defaults['auto_nav'] = '0';
	$defaults['include_home_link'] = '1';
	$defaults['footer_text'] = sprintf( '[footer_copyright before="%s "] &#x000B7; [footer_childtheme_link before="" after=" %s"] [footer_genesis_link url="http://www.studiopress.com/" before=""] &#x000B7; [footer_wordpress_link] &#x000B7; [footer_loginout]', __( 'Copyright', 'trestle' ), __( 'on', 'trestle' ) );
 
	return $defaults;
}
add_filter( 'genesis_theme_settings_defaults', 'trestle_custom_defaults' );
 
 
/**
 * Sanitization
 */
 
function trestle_register_social_sanitization_filters() {
	genesis_add_option_filter( 
		'no_html', 
		GENESIS_SETTINGS_FIELD,
		array(
			'auto_nav',
			'include_home_link',
		)
	);

	genesis_add_option_filter( 
		'safe_html', 
		GENESIS_SETTINGS_FIELD,
		array(
			'footer_text',
		)
	);
}
add_action( 'genesis_settings_sanitizer_init', 'trestle_register_social_sanitization_filters' );
 
 
/**
 * Register Metabox
 *
 * @param string $_genesis_theme_settings_pagehook
 */
 
function trestle_register_settings_box( $_genesis_theme_settings_pagehook ) {

	global $_genesis_admin_settings;

	// Remove default Genesis nav metabox
    remove_meta_box('genesis-theme-settings-nav', $_genesis_admin_settings->pagehook, 'main');

    // Call our own custom nav metabox which combines our own settings with Genesis'
	add_meta_box('mm-navigation-settings', __( 'Navigation', 'trestle' ), 'trestle_navigation_settings_box', $_genesis_theme_settings_pagehook, 'main', 'high');
	
}
add_action('genesis_theme_settings_metaboxes', 'trestle_register_settings_box');

/**
 * Create Navigation Metabox
 */
 
function trestle_navigation_settings_box() {
	?>
	<h4><?php _e( 'Primary Navigation Options', 'trestle' ) ?></h4>
	<p>
		<input type="checkbox" id="<?php echo GENESIS_SETTINGS_FIELD; ?>[auto_nav]" name="<?php echo GENESIS_SETTINGS_FIELD; ?>[auto_nav]" value="1" <?php checked( esc_attr( genesis_get_option('auto_nav') ), 1); ?> /> <label for="<?php echo GENESIS_SETTINGS_FIELD; ?>[auto_nav]"><?php _e(' Automatically generate nav menu (replaces custom/manual menu with auto-generated menu)', 'trestle' ); ?></label><br />
		<input type="checkbox" id="<?php echo GENESIS_SETTINGS_FIELD; ?>[include_home_link]" name="<?php echo GENESIS_SETTINGS_FIELD; ?>[include_home_link]" value="1" <?php checked( esc_attr( genesis_get_option('include_home_link') ), 1); ?> /> <label for="<?php echo GENESIS_SETTINGS_FIELD; ?>[include_home_link]"><?php _e( 'Include Home Link', 'trestle' ); ?></label>
	</p>
	<?php

	$genesis_settings_object = new Genesis_Admin_Settings;
	$genesis_settings_object->nav_box();
}

/**
 * Create Footer Metabox
 */
 
function trestle_footer_settings_box() {
	?>
	<p>
		<label for="<?php echo GENESIS_SETTINGS_FIELD; ?>[footer_text]">Custom footer text</label><br />
		<input type="text" class="widefat" id="<?php echo GENESIS_SETTINGS_FIELD; ?>[footer_text]" name="<?php echo GENESIS_SETTINGS_FIELD; ?>[footer_text]" value="<?php echo genesis_get_option( 'footer_text' ); ?>" />
	</p>
	<?php
}