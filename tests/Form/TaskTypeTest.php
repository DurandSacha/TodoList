<?php

namespace App\Tests\Controller;

use App\Tests\BaseTest;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskTypeTest extends BaseTest
{

    public function testFormEditTask(){
    $client = $this->login('sacha','000000') ;
    $crawler = $client->request('POST', '/tasks/6/edit');

    $form = $crawler->selectButton('Modifier')->form();
    $form['task[title]'] = 'TaskEdit';
    $form['task[content]'] = 'testContent';
    $client->submit($form);

    $client->followRedirect();
    $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testFormCreateTask(){
        $client = $this->login('sacha','000000') ;
        $crawler = $client->request('GET', '/tasks/create');

        $form = $crawler->selectButton('Ajouter')->form();
        $form['task[title]'] = 'Task';
        $form['task[content]'] = 'testContent';
        $client->submit($form);

        $client->followRedirect();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}