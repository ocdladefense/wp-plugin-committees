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

define('OCDLA_MEMBERSHIP_DIRECTORY_DOMAIN', 'https://members.ocdla.org');


// Referencing required files

// NOT WORKING
require_once(OCDLA_COMMITTEES_PLUGIN_DIR . '/includes/committees-array.inc');
require_once(OCDLA_COMMITTEES_PLUGIN_DIR . '/includes/records.inc');
require_once(OCDLA_COMMITTEES_PLUGIN_DIR . '/includes/redirect.inc');

add_action('init', "add_committees_url");

add_filter('request', "committees_query_vars");

add_filter('template_include', "setting_committees_template");

add_filter('init', 'wp_committees_flush_rules');


// Helper function that determines wether a member entry should be bold based on a Role


// What should this function be called?
function hasPosition($member) {

    static $roles;

    if(null == $roles){

        $api = load_api();

        $result = $api->query("SELECT Role__c FROM Relationship__c WHERE Role__c != 'Member' GROUP BY Role__c");

        $roles = $result->getRecords();
    
    }

    return (in_array($member["Role"], $roles));
}

function isMember($role){

    return substr($role, -4) != "mber";
}

function getCommitteeLink($committeeName) {

    $links = array(
        "Amicus Curiae" => array(
            "url" => "/wp-content/uploads/2020/08/Amicus-Committee-Guidelines.pdf",
            "text" => "Amicus Curiae Guidelines"
        ),
        "Capital Defenders" => array(
            "url" => "/shop-membr-capdef.shtml",
            "text" => "Go to the Capital Defenders page"
        ),
        "Education" => array(
            "url" => "/contact-committee-education.shtml",
            "text" => "Go to the Education Committee page."
        ),
        "Honored Members Steering Committee" => array(
            "url" => "/about-honored/",
            "text" => "View honored members."
        ),
        "Juvenile Law" => array(
            "url" => "/contact-committee-juvenile/",
            "text" => "Go to the Juvenile Law Committee page."
        ),
        "Legislative" => array(
            "url" => "/news-legis/",
            "text" => "Go to the Legislative Advocacy page for full committee list."
        ),
        "Oregon Legal Investigators Committee" => array(
            "url" => "/contact-committee-oregon-legal-investigators-committee/",
            "text" => "Go to the Oregon Legal Investigators Committee page."
        ),
        "Public Defense Reform Task Force" => array(
            "url" => "/public-defense-reform-task-force/",
            "text" => "Go to the Public Defense Reform Task Force page."
        ),
        "Pay Parity Advisory Committee" => array(
            "url" => "/contact-committee-pay-parity-advisory/",
            "text" => "Go to the Pay Parity Advisory Committee page."
        ),
        "Strike Force Committee Members" => array(
            "url" => "/ocdla-strike-force/",
            "text" => "Go to the Strike Force Committee page."
        )
    );

    return $links[$committeeName];
}