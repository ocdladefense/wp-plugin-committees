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
define('OCDLA_COMMITTEES_PLUGIN_DIR', plugin_dir_path(__FILE__));

// Referencing required files

// NOT WORKING
require_once(OCDLA_COMMITTEES_PLUGIN_DIR . '/includes/committees-array.inc');
require_once(OCDLA_COMMITTEES_PLUGIN_DIR . '/includes/records.inc');
require_once(OCDLA_COMMITTEES_PLUGIN_DIR . '/includes/redirect.inc');

add_action('init', "add_committees_url");

add_filter('request', "committees_query_vars");

add_filter('template_include', "setting_committees_template");

add_filter('init', 'flush_rules');


// Helper function that determines wether a member entry should be bold based on a Role
function hasPosition($member)
{
    $roles = [
        "Chair", "Co-chair", "Board Liaison", "President",
        "Vice President", "Executive Director", "Legislative Director"
    ];
    return (in_array($member["Role"], $roles) || $member["Name"] == "Bob Thuemmel");
}

// TESTING...
//var_dump($committees);
//exit;