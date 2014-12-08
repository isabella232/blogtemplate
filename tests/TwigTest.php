<?php

class TwigTests extends LocalWebTestCase
{

    public function testHome()
    {
        $this->client->get('/');
        $this->assertEquals(200, $this->client->response->status());

        $html = str_get_dom($this->client->response->body());
        $this->assertEquals(1, count($html('footer.blog-footer')));
        $this->assertEquals(1, count($html('div.blog-post')));

        // The menubar is correct
        $this->assertEquals('active', $html('li.blog-nav-item a', 0)->class);
        $this->assertTrue(strpos($html('li.blog-nav-item', 1)->class, 'dropdown') !== FALSE);
        $this->assertEquals('external', $html('li.blog-nav-item a', 3)->class);
    }

    public function testPermalink()
    {
        $this->client->get('/2014/11/27/VHeiWScAACYA7RUF/my-first-blog');
        $this->assertEquals(200, $this->client->response->status());

        $html = str_get_dom($this->client->response->body());
        $this->assertEquals(1, count($html('footer.blog-footer')));
        $this->assertEquals(1, count($html('div.blog-header')));
    }

    public function testArchive()
    {
        $this->client->get('/2014/11');
        $this->assertEquals(200, $this->client->response->status());

        $html = str_get_dom($this->client->response->body());
        $this->assertEquals(1, count($html('footer.blog-footer')));
        $this->assertEquals(1, count($html('div.blog-post')));
        $this->assertEquals("Archives for November 2014", $html('div.container h2', 0)->getPlainText());
    }

    public function testSearch()
    {
        $this->client->get('/search', array('q' => 'sample'));
        $this->assertEquals(200, $this->client->response->status());

        $html = str_get_dom($this->client->response->body());
        $this->assertEquals(1, count($html('footer.blog-footer')));
        $this->assertEquals(1, count($html('div.blog-post')));
    }

    public function testSearchNoResult()
    {
        $this->client->get('/search', array('q' => 'asdfasdfkjheiudwed'));
        $this->assertEquals(200, $this->client->response->status());

        $html = str_get_dom($this->client->response->body());
        $this->assertEquals(1, count($html('footer.blog-footer')));
        $this->assertEquals(0, count($html('div.blog-post')));
    }

    public function testAuthor()
    {
        $this->client->get('/author/VHiMRicAACcAHSaw/erwan-loisant');
        $this->assertEquals(200, $this->client->response->status());

        $html = str_get_dom($this->client->response->body());
        $this->assertEquals(1, count($html('footer.blog-footer')));
        $this->assertEquals(1, count($html('div.blog-post')));
    }

}