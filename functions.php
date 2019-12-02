<?php

add_theme_support( 'post-thumbnails' );

function dndonline_bloginfo_array() {
	$fields = array('name', 'description', 'wpurl', 'url', 'admin_email', 'charset', 'version', 'html_type', 'text_direction', 'language');
	$data = array();
	foreach($fields as $field) {
		$data[$field] = get_bloginfo($field);
	}
	return $data;
}

function dndonline_add_theme_scripts() {

	global $wp_scripts;
	global $wp_styles;

	wp_enqueue_style(
		'dndonline-fontawesome',
		get_template_directory_uri().'/fontawesome/css/all.min.css'
	);

	wp_register_script(
		'dndonline_mainjs',
		get_template_directory_uri().'/build/main.js',
		array(),
		'1.0',
		true
	);

	wp_localize_script('dndonline_mainjs', 'wpapi', array(
		'root' => esc_url_raw( rest_url() ),
		'apiURL' => esc_url_raw( get_site_url().'/api/' ),
		'nonce' => wp_create_nonce('wp_rest'),
		'bloginfo' => dndonline_bloginfo_array(),
	));

	wp_enqueue_script('dndonline_mainjs');

} add_action('wp_enqueue_scripts', 'dndonline_add_theme_scripts', 100);

function dndonline_remove_default_scripts () {

	global $wp_styles;
	global $wp_scripts;

	$styles_to_keep = array(
		"wp-admin",
		"admin-bar",
		"dashicons",
		"open-sans",
		'sa-fontawesome'
	);
	$scripts_to_keep = array();

	foreach ($wp_styles->registered as $handle => $data) {
		if ( in_array($handle, $styles_to_keep) ) continue;
		wp_deregister_style($handle);
		wp_dequeue_style($handle);
	}

	foreach ($wp_scripts->registered as $handle => $data) {
		if ( in_array($handle, $scripts_to_keep) ) continue;
		wp_deregister_script($handle);
		wp_dequeue_script($handle);
	}

} add_action('wp_enqueue_scripts', 'dndonline_remove_default_scripts', 99);