<?php

namespace App\Tests\Entity;

use App\Entity\Task;
use App\Tests\BaseTest;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskTest extends TestCase
{
    private $task;

    public function setUp()
    {
        $this->task = new Task();
    }

    public function testTitle()
    {
        $this->task->setTitle('Fixtures');
        $this->assertEquals('Fixtures', $this->task->getTitle());
    }

    public function testContent()
    {
        $this->task->setContent('Fixtures content');
        $this->assertEquals('Fixtures content', $this->task->getContent());
    }

    public function testCreatedAt()
    {
        $date = new \Datetime();
        $this->task->setCreatedAt($date);
        $this->assertEquals($date, $this->task->getCreatedAt());
    }
}