<?php

namespace App\Tests\Controller;

use App\Tests\baseTest;
use App\Form\TaskType;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Form\Test\TypeTestCase;

class TaskControllerTest extends baseTest
{
    public function testTasks(){
        $client = $this->login('sacha','000000') ;
        $client->request('GET', '/tasks');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testTaskfinished(){
        $client = $this->login('sacha','000000') ;
        $client->request('GET', '/tasks/finished');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }


    public function testTaskCreate(){
        $client = $this->login('sacha','000000') ;
        $client->request('GET', '/tasks/create');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }


    public function testTaskToggle(){
        // task 2
        $client = $this->login('sacha','000000') ;
        $client->request('GET', '/tasks/6/toggle');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }

    public function testTaskTogglePOST(){
        // task 2
        $client = $this->login('sacha','000000') ;
        $client->request('POST', '/tasks/6/toggle');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }


    public function testTaskEdit(){
        $client = $this->login('sacha','000000') ;
        $client->request('GET', '/tasks/1/edit');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }



    public function testTaskDelete(){
        $client = $this->login('louis','000000') ;
        $client->request('GET', '/tasks/9/delete');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }

    public function testTaskDeletePOST(){
        $client = $this->login('louis','000000') ;
        $client->request('POST', '/tasks/9/delete');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }



}
