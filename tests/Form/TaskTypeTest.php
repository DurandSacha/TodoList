<?php

namespace App\Tests\Controller;

use App\Entity\Task;
use App\Tests\BaseTest;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskTypeTest extends BaseTest
{

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        self::ensureKernelShutdown();

    }

    private function searchTasks()
    {
        $result = $this->entityManager
            ->getRepository(Task::class)
            ->findOneBy(array('isDone' => 0));

        $this->entityManager->close();
        return $result;
    }

    public function testFormEditTask(){
    $client = $this->login('sacha','000000') ;
    $crawler = $client->request('POST', '/tasks/'.$this->searchTasks()->getId().'/edit');

    $form = $crawler->selectButton('Modifier')->form();
    $form['task[title]'] = 'TaskEdit';
    $form['task[content]'] = 'testContent';
    $client->submit($form);

    $client->followRedirect();
    $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testFormCreateTask(){
        $client = $this->login('Louis','000000') ;
        $crawler = $client->request('GET', '/tasks/create');

        $form = $crawler->selectButton('Ajouter')->form();
        $form['task[title]'] = 'Task';
        $form['task[content]'] = 'testContent';
        $client->submit($form);

        $client->followRedirect();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}