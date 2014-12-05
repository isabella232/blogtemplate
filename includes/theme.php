<?php

class Theme {

    private static $twig;

    public static function twig() {
        if (!Theme::$twig) {
            Twig_Autoloader::register();

            $loader = new Twig_Loader_Filesystem(Theme::directory());
            Theme::$twig = new Twig_Environment($loader, array(
                // 'cache' => '/path/to/compilation_cache',
            ));
        }
        return Theme::$twig;
    }

    public static function directory() {
        return 'themes/' . PI_THEME;
    }

    public static function directory_url() {
        return '/' . Theme::directory();
    }

    public static function render($name, $parameters = array()) {
        if (Theme::isWP()) {
            include Theme::directory() . '/' . $name . '.php';
        } else {
            echo Theme::twig()->render($name . '.html.twig', array_merge(array(
                "site_title" => SITE_TITLE,
                "home" => NavMenuItem::home(),
                "posts" => State::current_posts()
            ), $parameters));
        }
    }

    private static function isWP() {
        return file_exists('themes/' . PI_THEME . '/index.php');
    }

}

