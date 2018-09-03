<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UsersControllerTest extends WebTestCase
{
	private $client;
	private $token;

	public function setUp()
	{
		$this->client = static::createClient();
	}

	private function login()
	{
		$this->client->request(
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

	public function testLogin()
	{
		$this->client->request(
			'POST',
			'/api/login',
			array(),
			array(),
			array('CONTENT_TYPE' => 'application/json'),
			'{"username":"usertest", "password":123123}'
		);

		$this->assertTrue($this->client->getResponse()->isSuccessful());
		$this->assertEquals(200, $this->client->getResponse()->getStatusCode());
	}

	public function testNew()
	{
		if ($this->token == null) $this->login();

		$this->client->request(
			'POST',
			'/api/users/new',
			array(),
			array(),
			array(
				'CONTENT_TYPE' => 'application/json',
				'HTTP_AUTHORIZATION' => 'Bearer ' . $this->token),
        	'{
        		"name":"User Test",
        		"username":"usertest2",
        		"password":123132
        	}');

		$this->assertTrue($this->client->getResponse()->isSuccessful());
        $this->assertEquals(201, $this->client->getResponse()->getStatusCode());
	}
}

?>