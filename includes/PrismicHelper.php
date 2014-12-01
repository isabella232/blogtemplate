<?php
require '../vendor/autoload.php';

use Prismic\Api;
use Prismic\LinkResolver;
use Prismic\Predicates;

class BlogLinkResolver extends LinkResolver
{
    public function resolve($link)
    {
        foreach(PrismicHelper::get_api()->bookmarks() as $name => $id) {
            if ($link->getId() == $id) {
                return '/' . $name;
            }
        }
        if ($link->isBroken()) {
            return null;
        }
        if ($link->getType() == "page") {
            return "/page/" . $link->getId() . '/' . $link->getSlug();
        }
        if ($link->getType() == "author") {
            return "/author/" . $link->getId() . '/' . $link->getSlug();
        }
        return "/" . $link->getId() . '/' . $link->getSlug();
    }
}

class PrismicHelper
{

    static $linkResolver;

    private static $api = null;

    static function get_api()
    {
        if (PrismicHelper::$api == null) {
            PrismicHelper::$api = Api::get(PRISMIC_URL, ACCESS_TOKEN);
        }
        return PrismicHelper::$api;
    }

    static function get_ref()
    {
        global $app;
        $previewCookie = $app->request()->cookies[Prismic\PREVIEW_COOKIE];
        if ($previewCookie != null) {
            return $previewCookie;
        } else {
            return PrismicHelper::get_api()->master();
        }
    }

    static function form()
    {
        return PrismicHelper::get_api()->forms()->everything->ref(PrismicHelper::get_ref());
    }

    static function get_authors() {
        return PrismicHelper::form()
            ->query(Predicates::at("document.type", "author"))
            ->submit();
    }

    static function get_document($id)
    {
        $results = PrismicHelper::form()
            ->query(Predicates::at("document.id", $id))
            ->submit()
            ->getResults();
        if (count($results) > 0) {
            return $results[0];
        } else {
            return null;
        }
    }

    static function search($q, $page = 1, $pageSize = 20)
    {
        return PrismicHelper::form()
            ->query(array(Predicates::at("document.type", "post"), Predicates::fulltext("document", $q)))
            ->orderings("[my.post.date desc]")
            ->page($page)
            ->pageSize($pageSize)
            ->submit();
    }

    static function archives($date, $page = 1, $pageSize = 20)
    {
        if (!$date['month']) {
            $lowerBound = DateTime::createFromFormat('Y-m-d', $date['year'] . '-01-01');
            $upperBound = clone $lowerBound;
            $upperBound->modify('+1 year');
        } else if (!$date['day']) {
            $lowerBound = DateTime::createFromFormat('Y-m-d', $date['year'] . '-' . $date['month'] .'-01');
            $upperBound = clone $lowerBound;
            $upperBound->modify('+1 month');
        } else {
            $lowerBound = DateTime::createFromFormat('Y-m-d', $date['year'] . '-' . $date['month'] .'-' . $date['day']);
            $upperBound = clone $lowerBound;
            $upperBound->modify('+1 day');
        }
        return PrismicHelper::form()
            ->query(array(
                Predicates::at("document.type", "post"),
                Predicates::dateAfter("my.post.date", $lowerBound),
                Predicates::dateBefore("my.post.date", $upperBound)
            ))
            ->orderings("[my.post.date desc]")
            ->page($page)
            ->pageSize($pageSize)
            ->submit();
    }

    static function get_bookmarks()
    {
        $bookmarks = PrismicHelper::get_api()->bookmarks();
        $bkIds = array();
        foreach ($bookmarks as $name => $id) {
            array_push($bkIds, $id);
        }
        return PrismicHelper::form()
            ->query(Predicates::any("document.id", $bkIds))
            ->orderings("[my.page.priority desc]")
            ->submit()
            ->getResults();
    }

    static function get_posts($page, $pageSize = 20)
    {
        return PrismicHelper::form()
            ->page($page)
            ->pageSize($pageSize)
            ->query(Predicates::at("document.type", "post"))
            ->orderings("[my.post.date desc]")
            ->submit();
    }

    private static function date_link($year, $month = null, $day = null)
    {
        $url = '/archive/' . $year;
        if ($month) {
            $url .= '/' . $month;
        }
        if ($month && $day) {
            $url .= '/' . $day;
        }
        return $url;
    }

    static function get_calendar()
    {
        $calendar = array();
        $page = 1;
        do {
            $posts = PrismicHelper::get_posts($page, 100);
            foreach ($posts->getResults() as $post) {
                if (!$post->getDate("post.date")) continue;
                $date = $post->getDate("post.date")->asDateTime();
                $key = $date->format("F Y");
                if ($key != end($calendar)['label']) {
                    array_push($calendar, array(
                        'label' => $key,
                        'link' => PrismicHelper::date_link($date->format('Y'), $date->format('m'))
                    ));
                }
                $page++;
            }
        } while ($posts->getNextPage());
        return $calendar;
    }

}

PrismicHelper::$linkResolver = new BlogLinkResolver();