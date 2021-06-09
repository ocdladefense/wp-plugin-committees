<?php

function add_committees_url() {

    add_rewrite_rule('^contact-committees-2/?', 'index.php?contact-committees-2=contact-committees-2', 'top');
    add_rewrite_endpoint('contact-committees-2', EP_PERMALINK);
}

function committees_query_vars($vars) {

    if (isset($vars['name']) && $vars['name'] == 'contact-committees-2') {

        $vars['contact-committees-2'] = true;
    }

    return $vars;
}

function setting_committees_template($template) {

    if (get_query_var('contact-committees-2')) {

        return locate_template('contact-committee.php', false);
    }

    return $template;
}

function wp_committees_flush_rules() {
    
    global $wp_rewrite;
    $wp_rewrite->flush_rules();
}