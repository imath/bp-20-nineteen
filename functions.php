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
 * @since 1.1.0 Adds a new inline style to the BP Companion stylesheet.
 */
function bp_20_nineteen_enqueue_parent_style() {
	// Enqueue the Twenty Nineteen Theme stylesheet.
	wp_enqueue_style( 'twentynineteen', get_template_directory_uri() . '/style.css', array(), '1.4' );

	// Add an inline style for the Group Members Management UI.
	wp_add_inline_style( 'bp-twentynineteen', '
		/* Group Members Interface*/
		div#group-manage-members-ui .subnav-filters {
			background: none;
			list-style: none;
			margin: 15px 0 0;
			padding: 0;
		}

		div#group-manage-members-ui .subnav-filters:before {
			content: " ";
			display: table;
		}

		div#group-manage-members-ui .subnav-filters .last {
			float: right;
			margin-top: 0;
			width: auto;
		}

		div#group-manage-members-ui [for="group-members-role-filter"] {
			display: inline;
		}

		div#group-manage-members-ui .bp-list {
			box-sizing: border-box;
			border-top: 1px solid #eaeaea;
			clear: both;
			list-style: none;
			margin: 20px 0;
			padding: 0.5em 0;
			width: 100%;
		}

		div#group-manage-members-ui table td, div#group-manage-members-ui table th {
			padding: 0.5em;
			border: 1px solid #eaeaea;
			word-break: break-all;
		}

		div#group-manage-members-ui .avatar {
			display: block;
			height: calc(2.25 * 1rem);
			min-height: inherit;
			width: calc(2.25 * 1rem);
			margin-top: 5px;
		}

		#group-manage-members-ui #group-members-pagination button:last-child {
			margin-right: 2em;
			border-radius: 0;
			line-height: 1.5;
			padding: 3px 10px;
			font-size: 100%;
		}

		#group-manage-members-ui #group-members-pagination button:last-child .dashicons {
			 font-size: 100%;
			 line-height: 1.5;
		}

		#buddypress #group-manage-members-ui input#manage-members-search {
			float: left;
			line-height: 1.5;
			padding: 3px 10px;
			width: 80%;
		}

		#group-manage-members-ui .bp-dir-search-form {
			content: " ";
			display: table;
		}

		#group-manage-members-ui #group-members-search-form button[type="submit"] {
			float: right;
			font-size: inherit;
			font-weight: 400;
			line-height: 1.45;
			text-align: center;
			text-transform: none;
			border-radius: 0;
			width: 20%;
			border-left: none;
			margin-left: -1px;
		}

		#group-manage-members-ui #group-members-search-form button .dashicons {
			font-size: 100%;
			line-height: 1.45;
		}

		#group-manage-members-ui .group-member-actions.row-actions,
		#group-manage-members-ui .group-member-edit {
			word-break: initial;
			font-size: 80%;
		}

		#group-manage-members-ui .group-member-edit {
			margin-top: -20px
		}
	' );
}
add_action( 'wp_enqueue_scripts', 'bp_20_nineteen_enqueue_parent_style' );

/**
 * Enqueue the JS powering the new group members management interface built into the BP Nouveau Template Pack.
 *
 * @since 1.1.0
 */
function bp_20_nineteen_group_manage_members_enqueue_script() {
	if ( ! function_exists( 'bp_rest_api_is_available' ) ) {
		return;
	}

	if ( bp_rest_api_is_available() && bp_is_group_admin_page() && bp_is_group_admin_screen( 'manage-members' ) ) {
		wp_enqueue_script( 'bp-group-manage-members' );
		wp_localize_script(
			'bp-group-manage-members',
			'bpGroupManageMembersSettings',
			bp_groups_get_group_manage_members_script_data( bp_get_current_group_id() )
		);
	}
}
add_action( 'bp_enqueue_scripts', 'bp_20_nineteen_group_manage_members_enqueue_script' );

/**
 * Remove the search form Legacy adds to search for group members as it's now included into the group
 * members new interface.
 *
 * @since 1.1.0
 */
function bp_20_nineteen_remove_legacy_group_manage_members_add_search_form() {
	if ( ! function_exists( 'bp_rest_api_is_available' ) ) {
		return;
	}

	remove_action( 'bp_before_group_admin_form', 'bp_legacy_theme_group_manage_members_add_search' );
}
add_action( 'bp_theme_compat_actions', 'bp_20_nineteen_remove_legacy_group_manage_members_add_search_form' );
