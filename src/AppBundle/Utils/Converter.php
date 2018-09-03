<?php

namespace AppBundle\Utils;

use AppBundle\Entity\Car;
use AppBundle\Entity\Cellphone;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class Converter
{
	public static function xmlToProduct(File $file)
	{
		if ($file == null) throw new \Exception("Error Processing Request", 1);

		$normalizers = [new ObjectNormalizer()];
		$encoders = [new XmlEncoder()];
		$serializer = new Serializer($normalizers, $encoders);

		$xml = new \DOMDocument();
		$xml->loadXML(file_get_contents($file));

		$elements = $xml->getElementsByTagName('product');
		if ($elements->length) {
			$attribute = $elements[0]->getAttribute('type');
			if ($attribute && ($attribute == "car" || $attribute == "cellphone")) {
				if ($attribute == "car") {
					return $serializer->deserialize($xml->saveXML(), Car::class, 'xml');
				} else {
					return $serializer->deserialize($xml->saveXML(), Cellphone::class, 'xml');
				}				
			} else {
				throw new \Exception("Error Processing Request", 1);
			}
		} else {
			throw new \Exception("Error Processing Request", 1);
		}

		throw new \Exception("Error Processing Request", 1);
	}
}

?>