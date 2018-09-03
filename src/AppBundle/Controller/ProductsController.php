<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use AppBundle\Form\ProductType;
use AppBundle\Utils\Converter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductsController extends Controller
{
	/**
	* @Route("/", name="products_new")
	*/
	public function new(Request $request)
	{
		$product = new Product();
		$form = $this->createForm(ProductType::class, $product);
		$form->handleRequest($request);

		if ($request->isMethod('POST')) {
			if ($form->isSubmitted() && $form->isValid()) {
				$em = $this->getDoctrine()->getManager();
				$obj = Converter::xmlToProduct($product->getFile());
				$obj->setCreated(new \DateTime());

				$em->persist($obj);
	    		$em->flush();

	    		$this->addFlash('notice', 'Product '.$obj->getId().' saved successfully!');

	    		return $this->redirectToRoute('products_new');
			} else {
				$this->addFlash('error', 'File required!');
				throw new \Exception("File required", Response::HTTP_BAD_REQUEST);
			}
		}

		return $this->render('products/new.html.twig', array(
			'form' => $form->createView()
		));
	}
}

?>