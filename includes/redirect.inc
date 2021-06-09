<?php

function add_committees_url()
{
    //may not be able to use compound paths as parameters to add_rewrite_endpoint
    add_rewrite_rule('^contact-committee-2/?', 'index.php?contact-committee-2=contact-committee-2', 'top');
    // TODOs: can add more, example => add_rewrite_rule( '^contact-committee/?', 'index.php?contact-committee=contact-committee', 'top' );
    add_rewrite_endpoint('contact-committee-2', EP_PERMALINK);
}

function committees_query_vars($vars)
{
    if (isset($vars['name']) && $vars['name'] == 'contact-committee-2') {
        $vars['contact-committee-2'] = true;
    }

    //var_dump($vars); exit;

    return $vars;
}

function setting_committees_template($template)
{
    if (get_query_var('contact-committee-2')) {
        //var_dump(get_query_var('contact-committee')); exit;

        return locate_template('contact-committee.php', false);
        exit;
    }

    return $template;
}

function wp_committees_flush_rules()
{
    global $wp_rewrite;
    $wp_rewrite->flush_rules();
}