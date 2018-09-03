<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;

class Product
{
	/**
	* @Assert\NotBlank()
	* @Assert\File(mimeTypes={ "text/xml" })
	*/
	private $file;

	public function getFile()
	{
		return $this->file;
	}

	public function setFile($file)
	{
		$this->file = $file;
	}
}

?>