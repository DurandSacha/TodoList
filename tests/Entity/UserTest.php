<?php

namespace App\Tests\Entity;

use App\Entity\Task;
use App\Entity\User;
use App\Tests\BaseTest;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserTest extends TestCase
{
    private $user;

    public function setUp()
    {
        $user = $this->user = new User();
    }


    public function testUsername()
    {
        $this->user->setUsername('hello');
        $this->assertEquals('hello', $this->user->getUsername());
    }

    public function testRole()
    {
        $role = ['ROLE_USER'];
        $this->user->setRoles($role);
        $this->assertEquals($role, $this->user->getRoles());
    }

    public function testId()
    {
        $this->user->setId(1);
        $this->assertEquals(1, $this->user->getId());
    }

    /*
    public function testTask()
    {
        // test addTask // getTasks // removeTask
        $user = new User();

        $task = new Task();
        $task2 = new Task();

        $tasks = [$task,$task2];

        $this->user->addTask($tasks);
        dd($this->user->getTasks());
        $this->assertEquals($task, $this->user->getTasks());
    }
    */


    public function testEmail()
    {
        $this->user->setEmail('hello@gmail.com');
        $this->assertEquals('hello@gmail.com', $this->user->getEmail());
    }
}