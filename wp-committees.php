<?php

/**
 * @package CommitteesPlugin
 */
/*
Plugin Name: Committees Plugin
Plugin URI: 
Description: This is a plugin that retrieves and displays information about OCDLA committees and their memebers.
Version: 1.0.0
Author: Ruslan Kalashnikov
Author URI: https://www.ocdla.org/
License: GPLv2 or later
Text Domain: wp-committes-plugin
*/

// If this file is accessed directly, abort.
defined('ABSPATH') or die('You shall not pass!');

// Setting a CONSTANT for the plugin dir path
define('MY_PLUGIN_DIR', plugin_dir_path(__FILE__));

// Referencing required files

// NOT WORKING
//require_once(MY_PLUGIN_DIR . '/includes/committees-array.inc');
//require_once(MY_PLUGIN_DIR . '/includes/records.inc');
//require_once(MY_PLUGIN_DIR . '/includes/redirect.inc');

require_once(ABSPATH . 'wp-content/plugins/wp-committees/includes/committees-array.inc');
require_once(ABSPATH . 'wp-content/plugins/wp-committees/includes/records.inc');
require_once(ABSPATH . 'wp-content/plugins/wp-committees/includes/redirect.inc');

require_once(ABSPATH . 'wp-content/plugins/wp-salesforce/wp-salesforce.php');

$committees = get_committees_array();

add_action('init', "add_committees_url");

add_filter('request', "committees_query_vars");

add_filter('template_include', "setting_committees_template");

add_filter('init', 'flush_rules');

// TESTING...
//var_dump($committees);
//exit;