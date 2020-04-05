<?php

namespace App\Tests\Entity;

use App\Entity\User;
use App\Tests\BaseTest;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserTest extends TestCase
{
    private $user;

    public function setUp()
    {
        $this->user = new User();
    }

    public function testUsername()
    {
        $this->user->setUsername('hello');
        $this->assertEquals('hello', $this->user->getUsername());
    }

    public function testRole()
    {
        $this->user->setsetRoles(['ROLE_USER']);
        $this->assertEquals(['ROLE_USER'], $this->user->getUsername());
    }

    /*
    public function testTask()
    {
        $this->user->getTasks();
        //$this->assertTrue($client->getResponse()->isSuccessful());
    }
    */

    public function testEmail()
    {
        $this->user->setEmail('hello@gmail.com');
        $this->assertEquals('hello@gmail.com', $this->user->getEmail());
    }
}