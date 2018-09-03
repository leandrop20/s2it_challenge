<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CellphonesControllerTest extends WebTestCase
{
	private $client;
	private $token;

	public function setUp()
	{
		$this->client = static::createClient();
	}

	private function login()
	{
		$crawler = $this->client->request(
			'POST',
			'/api/login',
			array(),
			array(),
			array('CONTENT_TYPE' => 'application/json'),
			'{"username":"usertest", "password":123123}');

		$this->assertTrue($this->client->getResponse()->isSuccessful());
		$this->assertEquals(200, $this->client->getResponse()->getStatusCode());

		$data = json_decode($this->client->getResponse()->getContent(), true);
		$this->token = $data['token'];
	}

	public function testIndex()
	{
		if ($this->token == null) $this->login();

        $crawler = $this->client->request(
        	'GET', 
        	'/api/cellphones',
        	array(),
        	array(),
        	array('HTTP_AUTHORIZATION' => 'Bearer ' . $this->token)
        	);

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
	}

	public function testView()
	{
		if ($this->token == null) $this->login();

		$crawler = $this->client->request(
        	'GET', 
        	'/api/cellphones/1000',
        	array(),
        	array(),
        	array('HTTP_AUTHORIZATION' => 'Bearer ' . $this->token)
        	);

        $this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
	}

}

?>