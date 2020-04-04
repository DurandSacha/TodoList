<?php

namespace App\Tests\Controller;

use App\Tests\BaseTest;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends BaseTest
{
    public function testIndex()
    {
        $client = static::createClient();

        $client->request('GET', '/login');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    // valid if user/admin connect ( 200 )
    public function testIndexWithConnect()
    {
        $client = $this->login('sacha','000000');
        $client->request('GET', '/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
