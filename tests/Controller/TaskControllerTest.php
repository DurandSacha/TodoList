<?php

namespace App\Tests\Controller;

use App\Entity\Task;
use App\Entity\User;
use App\Tests\baseTest;
use App\Form\TaskType;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Form\Test\TypeTestCase;

class TaskControllerTest extends baseTest
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

    private function searchTasksDone()
    {
        $result = $this->entityManager
            ->getRepository(Task::class)
            ->findOneBy(array('isDone' => 1));

        $this->entityManager->close();
        return $result;
    }


    public function testTaskDeleteWithUserROLE(){
        $client = $this->login('Louis','000000') ;

        $user = $this->entityManager
            ->getRepository(User::class)
            ->findOneBy(array('username' => 'Louis'));

        $task = $this->entityManager
            ->getRepository(Task::class)
            ->findOneBy(array('User' => $user));

        $this->entityManager->close();

        // delete their task and anonymous TASK ( ADMIN )
        $client->request('GET', '/tasks/'.$task->getId().'/delete');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());

    }


    public function testTaskDeleteWithUserAdmin(){
        $client = $this->login('sacha','000000') ;

        //$user = $this->entityManager
            //->getRepository(User::class)
            //->findOneBy(array('username' => 'Louis'));

        $task = $this->entityManager
            ->getRepository(Task::class)
            ->findOneBy(array('User' => null));

        $this->entityManager->close();

        // delete their task and anonymous TASK ( ADMIN )
        $client->request('GET', '/tasks/'.$task->getId().'/delete');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());


    }




    public function testTaskToggle(){

        $client = $this->login('sacha','000000') ;
        $client->request('GET', '/tasks/'.$this->searchTasks()->getId().'/toggle');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }

    public function testTaskToggleDone(){
        // task 2

        $client = $this->login('sacha','000000') ;
        $client->request('GET', '/tasks/'.$this->searchTasksDone()->getId().'/toggle');
        $client->request('GET', '/tasks/'.$this->searchTasksDone()->getId().'/toggle');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }

    public function testTaskTogglePOST(){
        // task 2
        $client = $this->login('sacha','000000') ;
        $client->request('POST', '/tasks/'.$this->searchTasks()->getId().'/toggle');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }


    public function testTaskEdit(){
        $client = $this->login('sacha','000000') ;
        $client->request('GET', '/tasks/'.$this->searchTasks()->getId().'/edit');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }



    public function testTaskDelete(){
        $client = $this->login('louis','000000') ;
        $client->request('GET', '/tasks/'.$this->searchTasks()->getId().'/delete');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }

    public function testTaskDeletePOST(){
        $client = $this->login('louis','000000') ;
        $client->request('POST', '/tasks/'.$this->searchTasks()->getId().'/delete');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }

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



}
