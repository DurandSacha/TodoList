<?php

namespace App\Tests\Controller;

use App\Tests\baseTest;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends baseTest
{
    public function testGetLoginPage(){
        $client = $this->login('sacha','000000') ;
        $client->request('GET', '/login');
        $this->assertResponseIsSuccessful();
    }

    public function testLogoutCheckRedirect(){
        $client = $this->login('sacha','000000') ;
        $client->request('GET', '/logout');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }
}