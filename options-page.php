<?php

/*
Plugin Name: Custom Options Page
Plugin URI: https://github.com/leymannx/wordpress-options-page.git
Description: This WordPress plugin creates an options page under "Settings" where info can be entered and stored for later output somewhere else. Multi-language support enabled.
Version: 1.0
Author: Norman Kämper-Leymann
Author URI: http://berlin-coding.de
Text Domain: options-page
Domain Path: /lang
*/

/**
 * Adds a custom settings page.
 */
function wporg_custom_admin_menu() {

	$text_domain = 'options-page';

	add_options_page(
		$page_title = __( 'Custom Options', $text_domain ),
		$menu_title = __( 'Custom Options', $text_domain ),
		$capability = 'manage_options',
		$menu_slug = 'custom-options',
		$function = 'custom_options_page'

	);
}

add_action( 'admin_menu', 'wporg_custom_admin_menu' );

/**
 * Page callback.
 */
function custom_options_page() {

	?>
	<div class='wrap'>
		<h1>Theme Panel</h1>
		<form method='post' action='options.php'>
			<?php
			settings_fields( 'section' );
			do_settings_sections( 'theme-options' );
			submit_button();
			?>
		</form>
	</div>
	<?php
}

/**
 * Adds section, fields and registers settings.
 */
function display_theme_panel_fields() {

	$text_domain = 'options-page';

	// Add section.
	add_settings_section( $id = 'my_section', $title = __( 'My Settings', $text_domain ), $callback = NULL, $page = 'theme-options' );

	// Add fields to section.
	add_settings_field( $id = 'twitter_url', $title = __( 'Twitter Profile Url', $text_domain ), $callback = 'display_twitter_element', $page = 'theme-options', $section = 'my_section' );
	add_settings_field( $id = 'facebook_url', $title = __( 'Facebook Profile Url', $text_domain ), $callback = 'display_facebook_element', $page = 'theme-options', $section = 'my_section' );
	add_settings_field( $id = 'theme_layout', $title = __( 'Do you want the layout to be responsive?', $text_domain ), $callback = 'display_layout_element', $page = 'theme-options', $section = 'my_section' );

	// Register settings.
	register_setting( 'section', 'twitter_url' );
	register_setting( 'section', 'facebook_url' );
	register_setting( 'section', 'theme_layout' );
}

add_action( 'admin_init', 'display_theme_panel_fields' );

/**
 * Field callback.
 */
function display_twitter_element() {

	?>
	<input type="text" name="twitter_url" id="twitter_url" value="<?php echo get_option( 'twitter_url' ); ?>"/>
	<?php
}

/**
 * Field callback.
 */
function display_facebook_element() {

	/*	?>
		<input type='text' name='facebook_url' id='facebook_url' value='<?php echo get_option( 'facebook_url' ); ?>'/>
		<?php
	*/
	wp_editor( $content = get_option( 'facebook_url' ), $editor_id = 'meD_stylee', $settings = array(
		'textarea_name' => 'facebook_url',
		'media_buttons' => FALSE,
		'textarea_rows' => 5,

	) );
}

/**
 * Field callback.
 */
function display_layout_element() {

	?>
	<input type="checkbox" name="theme_layout" value="1" <?php checked( 1, get_option( 'theme_layout' ), TRUE ); ?> />
	<?php
}
