<?php

namespace App\Tests\Controller;

use App\Tests\baseTest;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends baseTest
{


    public function testAdminListUser(){
        $client = $this->login('sacha','000000') ;
        $client->request('GET', '/users');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testUserCreateTaskWithAdminRoles(){
        $client = $this->login('sacha','000000') ;
        $client->request('GET', '/users/create');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testUserCreateTaskPOST(){
        $client = $this->login('sacha','000000') ;
        $client->request('POST', '/users/create');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    /*
    public function testUserAddTaskAnsRemoveTask(){
        $client = $this->login('sacha','000000') ;
        $client->request('POST', '/users/create');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }*/
}