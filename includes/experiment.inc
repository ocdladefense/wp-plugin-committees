<?php

//Adding a template to the 'Page Attributes' dropdown and including our custom template
add_filter('theme_page_templates', 'add_page_template');
add_filter('template_include', 'include_page_template', 99);


function add_page_template($templates)
{
    $templates[MY_PLUGIN_DIR . 'templates/test-list.tpl.php'] = __('Template from plugin', 'text-domain');
    return $templates;
}

function include_page_template($template)
{
    $newTemplate = MY_PLUGIN_DIR . '/templates/test-list.tpl.php';

    if (file_exists($newTemplate)) {
        return $newTemplate;
    }

    return $template;
}