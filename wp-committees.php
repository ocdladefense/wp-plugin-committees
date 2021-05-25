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

// Setting a CONSTANT for the plugin dir path
define('MY_PLUGIN_DIR', plugin_dir_path(__FILE__));

// Referencing required files
require_once(MY_PLUGIN_DIR . '/includes/committees-array.inc');
require_once(MY_PLUGIN_DIR . '/includes/records.inc');
require_once(ABSPATH . 'wp-content/plugins/wp-salesforce/wp-salesforce.php');

// If this file is accessed directly, abort.
defined('ABSPATH') or die('You shall not pass!');

$committees = get_committees_array();

// TESTING...
//var_dump($committees);
//exit;