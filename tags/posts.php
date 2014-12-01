<?php
require 'vendor/autoload.php';

/**
 * Most of these functions accept a $document as parameter.
 * For the single page, the document can be omitted.
 *
 * get_* function will return the values, others will output them.
 *
 * The way the tags are written can lead to the same request being done several times,
 * but it's OK because the Prismic kit has a built-in cache (APC).
 */

function current_document()
{
    return State::current_document();
}

function posts() {
    if (State::current_query() != null) {
        // Search page
        return PrismicHelper::search(State::current_query(), State::current_page())->getResults();
    }
    // Index page
    return PrismicHelper::get_posts(State::current_page())->getResults();
}

function document_url($document)
{
    $doc = $document ? $document : current_document();
    return PrismicHelper::$linkResolver->resolveDocument($doc);
}

function post_title($document = null)
{
    $doc = $document ? $document : current_document();
    return $doc ? htmlentities($doc->getText($doc->getType() . ".title")) : "";
}

function link_to_post($post)
{
    return '<a href="' . document_url($post) . '">' . post_title($post) . '</a>';
}

function get_text($field, $document = null)
{
    $doc = $document ? $document : current_document();
    return htmlentities($doc->get($field)->asText(PrismicHelper::$linkResolver));
}

function get_html($field, $document = null)
{
    $doc = $document ? $document : current_document();
    return $doc->get($field)->asHtml(PrismicHelper::$linkResolver);
}

function get_date($field, $format, $document = null)
{
    $doc = $document ? $document : current_document();
    if (!$doc) return null;
    $date = $doc->getDate($field);
    if ($date != null) {
        return date_format($date->asDateTime(), $format);
    } else {
        return null;
    }
}
