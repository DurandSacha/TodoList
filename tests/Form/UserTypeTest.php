<?php

namespace App\Tests\Controller;

use App\Tests\BaseTest;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserTypeTest extends BaseTest
{
    public function testUserEditActionWithAdminRoles(){
        $client = $this->login('sacha','000000') ;
        $client->request('GET', '/users/5/edit');
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

    public function testFormEditUser(){
        $client = $this->login('sacha','000000') ;
        $crawler = $client->request('GET', '/users/5/edit');

        $form = $crawler->selectButton('Modifier')->form();
        $form['user[username]'] = 'sacha';
        $form['user[password][first]'] = '000000';
        $form['user[password][second]'] = '000000';
        $form['user[email]'] = 'UserTestEdit@gmail.com';
        $form['user[Roles]'] = 'ROLE_USER';
        $client->submit($form);

        $client->followRedirect();
        $this->assertTrue($client->getResponse()->isSuccessful());

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testFormEditUserPOST(){
        $client = $this->login('sacha','000000') ;
        $crawler = $client->request('POST', '/users/5/edit');

        $form = $crawler->selectButton('Modifier')->form();
        $form['user[username]'] = 'sacha';
        $form['user[password][first]'] = '000000';
        $form['user[password][second]'] = '000000';
        $form['user[email]'] = 'UserTestEdit@gmail.com';
        $form['user[Roles]'] = 'ROLE_USER';
        $client->submit($form);

        $client->followRedirect();
        $this->assertTrue($client->getResponse()->isSuccessful());

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

}