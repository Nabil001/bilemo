<?php

namespace App\Tests\Controller;

use App\DataFixtures\Fixtures;
use App\Entity\Product;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ProductControllerTest extends WebTestCase
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

    public function testUnauthorizedGetProducts()
    {
        $this->client->request(
            'GET',
            '/products/'
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

    public function testAuthorizedGetProducts()
    {
        $this->client->request(
            'GET',
            '/products/',
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

    public function testAuthorizedGetProductsNotFound()
    {
        $this->client->request(
            'GET',
            '/products/?page=100',
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

    public function testUnauthorizedGetProduct()
    {
        $productId = $this->em->getRepository(Product::class)
            ->findAll()[0]
            ->getId();
        $this->client->request(
            'GET',
            '/products/'.$productId
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

    public function testAuthorizedGetProduct()
    {
        $productId = $this->em->getRepository(Product::class)
                ->findAll()[0]
                ->getId();
        $this->client->request(
            'GET',
            '/products/'.$productId,
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

    public function testAuthorizedGetProductNotFound()
    {
        $this->client->request(
            'GET',
            '/products/0',
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