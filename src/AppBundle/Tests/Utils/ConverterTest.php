<?php

namespace AppBundle\Tests\Utils;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\Utils\Converter;
use AppBundle\Entity\Car;
use AppBundle\Entity\Cellphone;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;

class ConverterTest extends WebTestCase
{
	private $converter;

	public function __construct()
	{
		$this->converter = new Converter();

		parent::__construct();
	}

	public function testFormatWithoutTagProduct()
	{
		$testFormatWithoutTagProduct = new File(
			'../src/AppBundle/Tests/UploadedFiles/testFormatWithoutTagProduct.xml');

		try {
			$this->converter->xmlToProduct($testFormatWithoutTagProduct);
		} catch (\Exception $e) {
			$this->assertEquals($e->getMessage(), 'Error Processing Request');
		}
	}

	public function testFormatWithoutAttributeTypeCar()
	{
		$testFormatWithoutAttributeTypeCar = new File(
			'../src/AppBundle/Tests/UploadedFiles/testFormatWithoutAttributeTypeCar.xml');

		try {
			$this->converter->xmlToProduct($testFormatWithoutAttributeTypeCar);
		} catch (\Exception $e) {
			$this->assertEquals($e->getMessage(), 'Error Processing Request');
		}
	}

	public function testFormatWithoutAttributeTypeCellphone()
	{
		$testFormatWithoutAttributeTypeCellphone = new File(
			'../src/AppBundle/Tests/UploadedFiles/testFormatWithoutAttributeTypeCellphone.xml');

		try {
			$this->converter->xmlToProduct($testFormatWithoutAttributeTypeCellphone);
		} catch (\Exception $e) {
			$this->assertEquals($e->getMessage(), 'Error Processing Request');
		}
	}

	public function testFormatProductCarOk()
	{
		$testFormatProductCarOk = new File(
			'../src/AppBundle/Tests/UploadedFiles/testFormatProductCarOk.xml');

		$this->assertInstanceOf(Car::class,
			$this->converter->xmlToProduct($testFormatProductCarOk));
	}

	public function testFormatProductCellphoneOk()
	{
		$testFormatProductCellphoneOk = new File(
			'../src/AppBundle/Tests/UploadedFiles/testFormatProductCellphoneOk.xml');

		$this->assertInstanceOf(Cellphone::class,
			$this->converter->xmlToProduct($testFormatProductCellphoneOk));
	}
}

?>