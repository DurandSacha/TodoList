<?php

namespace App\Tests\Controller;

use App\Tests\baseTest;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

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

    /*


    public function testTaskCreate(){
        $client = $this->login('sacha','000000') ;
        $client->request('GET', '/tasks/create');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }


    public function testTaskToggle(){
        $client = $this->login('sacha','000000') ;
        $client->request('GET', '/tasks/{id}/toggle');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }

    public function testTaskEdit(){
        $client = $this->login('sacha','000000') ;
        $client->request('GET', '/tasks/{id}/edit');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }

    public function testTaskDelete(){
        $client = $this->login('sacha','000000') ;
        $client->request('GET', '/tasks/{id}/delete');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }
    */
}



/* with form
 *
 *
 *
 * public function testFormCreateActionTask(){
        $client = $this->login('sacha','000000') ;
        $crawler = $client->request('GET', '/tasks/create');

        $form = $crawler->selectButton('Ajouter')->form();
        $form['task[title]'] = 'Task';
        $form['task[content]'] = 'Symfony rocks!';
        $crawler = $client->submit($form);

        $client->followRedirect();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

 */