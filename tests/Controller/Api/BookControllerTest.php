<?php

namespace App\Test\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class PostControllerTest extends WebTestCase{
    
    public function testCreateBookInvalidData()
    {
        $client = static::createClient();
        $client->request('POST', '/api/books', [], [], ['CONTENT_TYPE' => 'application/json'],'{"title":""}');
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $client->getResponse()->getStatusCode());
    }

    public function testCreateBookEmptyData()
    {
        $client = static::createClient();
        $client->request('POST', '/api/books', [], [], ['CONTENT_TYPE' => 'application/json'],'');
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $client->getResponse()->getStatusCode());
    }

    public function testSuccess()
    {
        $client = static::createClient();
        $client->request('POST', '/api/books', [], [], ['CONTENT_TYPE' => 'application/json'],'{"title":"El imperio final"}');
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }
}