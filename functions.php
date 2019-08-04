<?php
/**
 * BP 20 Nineteen custom functions.
 *
 * @since 1.0.0
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Enqueues the Parent Theme's CSS.
 *
 * @since 1.0.0
 */
function bp_20_nineteen_enqueue_parent_style() {
	// Enqueue the Twenty Nineteen Theme stylesheet.
    wp_enqueue_style( 'twentynineteen', get_template_directory_uri() . '/style.css', array(), '1.4' );
}
add_action( 'wp_enqueue_scripts', 'bp_20_nineteen_enqueue_parent_style' );
