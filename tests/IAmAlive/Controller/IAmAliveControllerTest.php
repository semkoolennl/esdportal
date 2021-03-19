<?php


namespace App\Tests\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class IAmAliveControllerTest extends WebTestCase
{
    /** @test */
    public function itReturnA200StatusCode()
    {
        $client = static::createClient();

        $client->request('GET', '/i-am-alive');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}