<?php

use Prismic\Document;

class Post
{
    public $document;
    private $author;

    public function __construct(Document $doc)
    {
        $this->document = $doc;
    }

    public function getTitle()
    {
        return $this->document->getText("post.title");
    }

    public function getBody()
    {
        return $this->document->getStructuredText("post.body")->asHtml();
    }

    function getExcerpt()
    {
        if ($this->document->getStructuredText('post.shortlede')) {
            return $this->document->getStructuredText('post.shortlede')->asHtml(PrismicHelper::$linkResolver);
        }
        // Plain text to avoid open tag at the end
        $body = $this->document->getStructuredText('post.body');
        if (strlen($body->asText()) > 300) {
            return substr($body->asText(), 0, 300) . "...";
        } else {
            return $body->asText();
        }
    }

    public function getPermalink()
    {
        return PrismicHelper::$linkResolver->resolveDocument($this->document);
    }

    public function getDate()
    {
        $date = $this->document->getDate("post.date");
        return $date ? $date->asDateTime() : null;
    }

    public function getAuthor()
    {
        $authorLink = $this->document->getLink("post.author");
        if (!$authorLink) return null;
        return Author::fromId($authorLink->getId());
    }

    public function getCategories()
    {
        return PrismicHelper::document_categories($this->document);
    }

    public static function fromId($docId)
    {
        $doc = PrismicHelper::get_document($docId);
        if (!$doc || $doc->getType() != "post") return null;
        return new Post($doc);
    }

}