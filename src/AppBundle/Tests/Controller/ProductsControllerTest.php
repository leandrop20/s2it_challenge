<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ProductsControllerTest extends WebTestCase
{
	public function testNew()
	{
		$file = new UploadedFile(
			'../src/AppBundle/Tests/UploadedFiles/testFormatProductCarOk.xml',
			'testFormatProductCarOk.xml',
			'text/xml');

		$client = static::createClient();

		$client->request(
			'POST',
			'/',
			array(),
			array('product' => array('file' => $file))
		);

		$client->followRedirect();

		$this->assertTrue($client->getResponse()->isSuccessful());
		$this->assertEquals(200, $client->getResponse()->getStatusCode());
	}
}

?>