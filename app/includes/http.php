<?php

function theme_dir($app)
{
    return __DIR__ . '/../themes/' . $app->config('theme');
}

function render($app, $page)
{
    global $wp_query;
    $wp_query = new WP_Query();
    // Optional helpers that theme developers can provide
    try {
        include_once(theme_dir($app) . '/functions.php');
    } catch(Exception $ex) {}
    require theme_dir($app) . '/' . $page . '.php';
}

function render_single($app, $post, $page)
{
    global $wp_query, $loop;
    $loop = new Loop();
    $loop->setPosts(array($post));
    $wp_query = new WP_Query();
    // Optional helpers that theme developers can provide
    try {
        include_once(theme_dir($app) . '/functions.php');
    } catch(Exception $ex) {}
    require theme_dir($app) . '/' . $page . '.php';
}

function render_response($app, $response, $page)
{
    global $wp_query, $loop;
    $loop = new Loop();
    $loop->setResponse($response);
    $wp_query = new WP_Query();
    // Optional helpers that theme developers can provide
    try {
        include_once(theme_dir($app) . '/functions.php');
    } catch(Exception $ex) {}
    require theme_dir($app) . '/' . $page . '.php';
}

function current_page($app)
{
    $pageQuery = $app->request()->params('page');
    return $pageQuery == null ? '1' : $pageQuery;
}

function not_found($app)
{
    $app->response->setStatus(404);
    render($app, '404');
}

function check_page_path1($path, $prismic)
{
    $uid = end($path);
    $correctAddress = $prismic->page_path($uid);
    if($path == $correctAddress) {
      return $uid;
    }
}

function redirect_path($path, $prismic)
{
    $npath = $prismic->refresh_path($path);
    if($npath != null)
    {
        $npath_uid = end($npath);
        $newCorrectAddress = $prismic->page_path($npath_uid);
        if($npath == $newCorrectAddress)
        {
            return '/'.implode('/',$newCorrectAddress);

        }
        if($npath != $newCorrectAddress)
        {
            // 404
            return null;
        }
    }

    return null;
}

function check_page_path($path, $prismic, $app)
{
    $page_uid = check_page_path1($path, $prismic);

    if($page_uid == null)
    {
        $redirect_url = redirect_path($path, $prismic);
        if($redirect_url != null)
        {
            $app->response->redirect($redirect_url);
        }
        if($redirect_url == null)
        {
            not_found($app);
        }
    }

    return $page_uid;

}
