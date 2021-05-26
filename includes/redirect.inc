<?php

function add_committees_url()
{
    //may not be able to use compound paths as parameters to add_rewrite_endpoint
    add_rewrite_rule('^contact-committee/?', 'index.php?contact-committee=contact-committee', 'top');
    // TODOs: can add more, example => add_rewrite_rule( '^contact-committee/?', 'index.php?contact-committee=contact-committee', 'top' );
    add_rewrite_endpoint('contact-committee', EP_PERMALINK);
}

function committees_query_vars($vars)
{
    if ($vars['name'] == 'contact-committee') {
        $vars['contact-committee'] = true;
    }

    //var_dump($vars); exit;

    return $vars;
}

function setting_committees_template($template)
{
    if (get_query_var('contact-committee')) {
        //var_dump(get_query_var('contact-committee')); exit;

        return locate_template('contact-committee.php', false);
        exit;
    }

    return $template;
}

function flush_rules()
{
    global $wp_rewrite;
    $wp_rewrite->flush_rules();
}