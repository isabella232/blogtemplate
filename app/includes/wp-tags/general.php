<?php

/**
 * The way the tags are written can lead to the same request being done several times,
 * but it's OK because the Prismic kit has a built-in cache (APC).
 */

// General tags

function get_bloginfo($show = 'name')
{
    global $app;
    switch ($show) {
        case 'atom_url':
        case 'rdf_url':
        case 'rss_url':
        case 'rss2_url': return '/feed';
        case 'description': return $app->config('site.description');
        case 'wpurl':
        case 'url': return $app->request()->getUrl();
        case 'admin_email': return ADMIN_EMAIL;
        case 'charset': return 'UTF-8';
        case 'language': return 'en-US';
        case 'name': return $app->config('site.title');
        default: return '';
    }
}

function bloginfo($show = 'name')
{
    echo get_bloginfo($show);
}

function site_title()
{
    global $WPGLOBAL;
    $app = $WPGLOBAL['app'];
    return $app->config('site.title');
}

function home_url($path = '', $scheme = null)
{
    global $WPGLOBAL;
    $app = $WPGLOBAL['app'];
    return $app->request()->getUrl() . $path;
}

function wp_title()
{
    echo site_title();
}

function get_template_directory_uri()
{
    global $WPGLOBAL;
    $theme = $WPGLOBAL['theme'];
    return $theme->directory_url();
}

function get_template_directory()
{
    global $WPGLOBAL;
    $theme = $WPGLOBAL['theme'];
    return $theme->directory();
}

function site_description()
{
    global $WPGLOBAL;
    $app = $WPGLOBAL['app'];
    return $app->config('site.description');
}

function the_feed_link($anchor)
{
    return '<a href="/feed">' . $anchor . '</a>';
}

function home_link($label, $attrs = array())
{
    global $WPGLOBAL;
    $app = $WPGLOBAL['app'];
    if($app->request->getUrl() == "/") {
        $attrs['class'] = isset($attrs['class']) ? ($attrs['class'] . ' active') : 'active';
    }
    return _make_link('/', $label, $attrs);
}

function get_sidebar()
{
    global $WPGLOBAL;
    $theme = $WPGLOBAL['theme'];
    $theme->render('sidebar');
}

function is_active_sidebar()
{
    return true;
}

function get_header()
{
    global $WPGLOBAL;
    $theme = $WPGLOBAL['theme'];
    $theme->render('header');
}

function get_footer()
{
    global $WPGLOBAL;
    $theme = $WPGLOBAL['theme'];
    $theme->render('footer');
}

function get_search_query()
{
    global $WPGLOBAL;
    $state = $WPGLOBAL['state'];
    return htmlentities($state->current_query());
}

function get_search_form($echo = true)
{
    $html = '<form method = "get" action = "search" >
                <input type = "text" placeholder = "Search..." name = "q" >
            </form >';
    if ($echo) {
        echo $html;
    } else {
        return $html;
    }
}

function get_calendar() {
    global $WPGLOBAL;
    $prismic = $WPGLOBAL['prismic'];
    return $prismic->get_calendar();
}

function get_template_part($slug, $name = null)
{
    global $WPGLOBAL;
    $theme = $WPGLOBAL['theme'];
    if ($name) {
        $theme->render($slug . '-' . $name);
    } else {
        $theme->render($slug);
    }
}

function is_search()
{
    global $WPGLOBAL;
    $state = $WPGLOBAL['state'];
    return $state->current_query() != null;
}

function is_single()
{
    global $WPGLOBAL;
    $state = $WPGLOBAL['state'];
    return $state->current_document() && $state->current_document()->getType() == "post";
}

function is_singular()
{
    global $WPGLOBAL;
    $state = $WPGLOBAL['state'];
    return $state->current_document() != null;
}

// Helpers (shouldn't be used in templates)

function _make_link($url, $label, $attrs)
{
    $attrs['href'] = $url;
    $result = '<a ';
    foreach($attrs as $k => $v) {
        $result .= ($k . '="' . $v . '" ');
    }
    $result .= ('>' . $label . '</a>');
    return $result;
}
