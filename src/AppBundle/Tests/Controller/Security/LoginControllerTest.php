<?php

namespace AppBundle\Tests\Controller\Security;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginControllerTest extends WebTestCase
{
    public function testLogin()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/login');
    }

    public function testLogincheck()
    {
        $client = static::createClient();

        //$crawler = $client->request('GET', '/loginCheck');
    }

    public function testLogout()
    {
        $client = static::createClient();

        //$crawler = $client->request('GET', '/logout');
    }

}
