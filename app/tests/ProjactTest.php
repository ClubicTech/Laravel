<?php

use Illuminate\Http\Response;

class ProjactTest extends TestCase {

    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testChangeNewsTest() {
        $crawler = $this->call('POST', 'api.test1/news/change/5', array("title" => "rrrrrrrrrrrrrr"));
        $this->assertEquals('[{"success":false,"message":"You send not corekt information!!"}]', $crawler->getContent());
        //$this->assertTrue($this->client->getResponse()->isOk());
    }

    public function testCreateNewsTest() {
        $news = array(
            'title' => '$title',
            'rubric_id' => '$rubric_id',
            'author' => '$author',
            'description' => '$description',
        );

        $crawler = $this->call('POST', 'api.test1/news/create', $news);
        $this->assertEquals('[{"success":false,"message":"You send not corekt information!!"}]', $crawler->getContent());
    }

    public function testTagSearchNewsTest() {
        $crawler = $this->client->request('GET', 'api.test1/news/tag/search/tag');

        $this->assertTrue($this->client->getResponse()->isOk());
    }

    public function testSearchNewsTest() {
        $crawler = $this->client->request('GET', 'api.test1/news/search/sometitle');
        $this->assertTrue($this->client->getResponse()->isOk());
    }

    public function testGetetAllNews() {
        $crawler = $this->client->request('GET', 'api.test1/news');
        $this->assertTrue($this->client->getResponse()->isOk());
    }

    public function testDeleteNewsTest() {
        $crawler = $this->call('DELETE', 'api.test1/news/delete/30');
        $this->assertEquals('[{"success":false,"message":"This news not found!"}]', $crawler->getContent());
        //$this->assertTrue($this->client->getResponse()->isOk());
    }

    public function testGetOneNews() {

        $crawler1 = $this->call('GET', 'api.test1/news/6');
        $this->assertEquals('[{"id":"6","title":"Some news for Football__4","rubric_id":"7","author":"M.Vovk","description":"Some news for Football__4"}]', $crawler1->getContent());
        //$this->assertTrue($this->client->getResponse()->isOk());
    }

}
