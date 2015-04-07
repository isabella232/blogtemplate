<?php

function home()
{
    global $WPGLOBAL;
    $prismic = $WPGLOBAL['prismic'];
    return $prismic->home();
}

function page_link($page, $attrs = array())
{
    global $WPGLOBAL;
    $app = $WPGLOBAL['app'];
    $classes = array();
    $active = $app->request()->getPath() == $page['url'];
    if ($active) array_push($classes, 'active');
    if ($page['external'] == true) array_push($classes, 'external');
    return '<a href="' . $page['url'] . '" class="' . join(' ', $classes) . '">' . $page['label'] . '</a>';
}

function slice_content($slice, $linkResolver)
{
    global $WPGLOBAL;
    $app = $WPGLOBAL['app'];
    $sliceFile  = theme_dir($app)
                . '/slices/'
                . $slice->getSliceType();
    $sliceLabelFile = $sliceFile . "-" . $slice->getLabel() . '.php';
    $sliceFile = $sliceFile . '.php';
    if (file_exists($sliceLabelFile)) {
        include($sliceLabelFile);
    } else if (file_exists($sliceFile)) {
        include($sliceLabelFile);
    } else {
        echo $slice->asHtml($linkResolver);
    }
}

function page_content()
{
    global $WPGLOBAL, $loop;
    $prismic = $WPGLOBAL['prismic'];
    $doc = $loop->current_post();
    if (!$doc) return null;
    $body = $doc->getSliceZone($doc->getType() . '.body');
    if ($body) {
        foreach ($body->getSlices() as $slice) {
            slice_content($slice, $prismic->linkResolver);
        }
    }
}

function get_pages()
{
    $home = home();
    if (array_key_exists('children', $home)) {
        return $home['children'];
    } else {
        return array();
    }
}

function is_page_template($template = null)
{
    // TODO
    return false;
}