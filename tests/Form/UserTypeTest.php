<?php

namespace App\Tests\Controller;

use App\Entity\User;
use App\Tests\BaseTest;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserTypeTest extends BaseTest
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

    private function searchUser()
    {
        $result = $this->entityManager
            ->getRepository(User::class)
            ->findOneBy(array('username' => 'Louis'));
        //dd($result);
        $this->entityManager->close();
        return $result;
    }

    private function searchAllUser()
    {
        $result = $this->entityManager
            ->getRepository(User::class)
            ->findAll();
        //dd($result);
        $this->entityManager->close();
        return $result;
    }

    public function testUserEditActionWithAdminRoles(){
        $client = $this->login('sacha','000000') ;
        $client->request('GET', '/users/'.$this->searchUser()->getId().'/edit');
        $this->assertEquals(200, $client->getResponse()->getStatusCode()); // redirect
    }

    public function testFormCreateUser(){
        $client = $this->login('sacha','000000') ;
        $crawler = $client->request('GET', '/users/create');

        $form = $crawler->selectButton('Ajouter')->form();
        $form['user[username]'] = 'UserTest';
        $form['user[password][first]'] = '000000';
        $form['user[password][second]'] = '000000';
        $form['user[email]'] = 'UserTest@gmail.com';
        $form['user[Roles]'] = 'ROLE_USER';
        $client->submit($form);
        //$this->assertTrue($client->getResponse()->isRedirection());

        //$client->followRedirect();
        $this->assertTrue($client->getResponse()->isSuccessful());

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testFormCreateUserPOST(){
        $client = $this->login('sacha','000000') ;
        $crawler = $client->request('POST', '/users/create');
        //$this->searchAllUser()->count();
        $form = $crawler->selectButton('Ajouter')->form();
        $form['user[username]'] = 'UserTest';
        $form['user[password][first]'] = '000000';
        $form['user[password][second]'] = '000000';
        $form['user[email]'] = 'UserTest@gmail.com';
        $form['user[Roles]'] = 'ROLE_USER';
        $client->submit($form);
        //$this->assertFalse($client->getResponse()->isRedirection());

        //$client->followRedirect();
        //$this->assertTrue($client->getResponse()->isSuccessful());

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testFormEditUser(){
        $client = $this->login('sacha','000000') ;
        $crawler = $client->request('GET', '/users/'.$this->searchUser()->getId().'/edit');

        $form = $crawler->selectButton('Modifier')->form();
        $form['user[username]'] = 'Louis';
        $form['user[password][first]'] = '000000';
        $form['user[password][second]'] = '000000';
        $form['user[email]'] = 'jean10@gmail.com';
        $form['user[Roles]'] = 'ROLE_USER';
        $client->submit($form);

        $this->assertFalse($client->getResponse()->isSuccessful());

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }

    public function testFormEditUserPOST(){
        $client = $this->login('sacha','000000') ;
        $crawler = $client->request('POST', '/users/'.$this->searchUser()->getId().'/edit');

        $form = $crawler->selectButton('Modifier')->form();
        $form['user[username]'] = 'Louis';
        $form['user[password][first]'] = '000000';
        $form['user[password][second]'] = '000000';
        $form['user[email]'] = 'jean10@gmail.com';
        $form['user[Roles]'] = 'ROLE_USER';
        $client->submit($form);
        $client->followRedirect();

        //$this->assertTrue($client->getResponse()->isSuccessful());

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

}