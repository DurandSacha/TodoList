<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BaseTest extends WebTestCase
{
    public function testLoginSucces(){
        $client = $this->login('sacha','000000') ;
        $client->request('GET', '/login');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function login($user,$pass) {
        return static::createClient([], [
            'PHP_AUTH_USER' => $user,
            'PHP_AUTH_PW' => $pass,
        ]);
    }
}