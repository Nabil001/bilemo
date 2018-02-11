<?php

namespace App\Tests\Controller;

use App\DataFixtures\Fixtures;
use App\Entity\User;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class UserControllerTest extends WebTestCase
{
    private $client;

    private $token;

    private $em;

    private $purger;

    private $executor;

    public function setUp()
    {
        $this->client = self::createClient();

        $kernel = $this->client->getKernel();

        $this->em = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
        $this->purger = new ORMPurger($this->em);
        $this->executor = new ORMExecutor($this->em, $this->purger);
        $this->executor->execute([
            new Fixtures($kernel->getContainer()->get('security.password_encoder'))
        ]);

        $this->logIn();
    }

    public function logIn()
    {
        $this->client->request(
            'POST',
            '/login_check',
            [
                '_username' => 'sensiolabs',
                '_password' => 'fabpot'
            ]
        );

        $this->assertEquals(
            Response::HTTP_OK,
            $this->client->getResponse()->getStatusCode()
        );

        $this->assertTrue(
            $this->client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            )
        );

        $token = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertTrue(!empty($token['token']));

        $this->token = $token['token'];
    }

    public function testUnauthorizedGetUsers()
    {
        $this->client->request(
            'GET',
            '/users/'
        );

        $this->assertEquals(
            Response::HTTP_UNAUTHORIZED,
            $this->client->getResponse()->getStatusCode()
        );

        $this->assertTrue(
            $this->client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            )
        );
    }

    public function testAuthorizedGetUsers()
    {
        $this->client->request(
            'GET',
            '/users/',
            [],
            [],
            [
                'HTTP_AUTHORIZATION' => 'Bearer '.$this->token
            ]
        );

        $this->assertEquals(
            Response::HTTP_OK,
            $this->client->getResponse()->getStatusCode()
        );

        $this->assertTrue(
            $this->client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            )
        );
    }

    public function testAuthorizedGetUsersNotFound()
    {
        $this->client->request(
            'GET',
            '/users/?page=100',
            [],
            [],
            [
                'HTTP_AUTHORIZATION' => 'Bearer '.$this->token
            ]
        );

        $this->assertEquals(
            Response::HTTP_NOT_FOUND,
            $this->client->getResponse()->getStatusCode()
        );

        $this->assertTrue(
            $this->client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            )
        );
    }

    public function testUnauthorizedGetUser()
    {
        $userId = $this->em->getRepository(User::class)
            ->findAll()[0]
            ->getId();
        $this->client->request(
            'GET',
            '/users/'.$userId
        );

        $this->assertEquals(
            Response::HTTP_UNAUTHORIZED,
            $this->client->getResponse()->getStatusCode()
        );

        $this->assertTrue(
            $this->client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            )
        );
    }

    public function testAuthorizedGetUser()
    {
        $userId = $this->em->getRepository(User::class)
            ->createQueryBuilder('u')
            ->join('u.client', 'c')
            ->where('c.username = \'sensiolabs\'')
            ->getQuery()
            ->getResult()[0]
            ->getId();

        $this->client->request(
            'GET',
            '/users/'.$userId,
            [],
            [],
            [
                'HTTP_AUTHORIZATION' => 'Bearer '.$this->token
            ]
        );

        $this->assertEquals(
            Response::HTTP_OK,
            $this->client->getResponse()->getStatusCode()
        );

        $this->assertTrue(
            $this->client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            )
        );
    }

    public function testAuthorizedGetUserNotFound()
    {
        $this->client->request(
            'GET',
            '/users/0',
            [],
            [],
            [
                'HTTP_AUTHORIZATION' => 'Bearer '.$this->token
            ]
        );

        $this->assertEquals(
            Response::HTTP_NOT_FOUND,
            $this->client->getResponse()->getStatusCode()
        );

        $this->assertTrue(
            $this->client->getResponse()->headers->contains(
                'Content-Type',
                'application/json'
            )
        );
    }

    public function tearDown()
    {
        parent::tearDown();

        $this->em->close();
        $this->em = null;
        $this->purger = null;
        $this->executor = null;
        $this->client = null;
    }
}