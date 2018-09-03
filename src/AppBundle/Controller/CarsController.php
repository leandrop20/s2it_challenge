<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Car;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
* @Route("/api")
*/
class CarsController extends Controller
{
	public function getRepository()
	{
		return $this->getDoctrine()->getRepository(Car::class);
	}

	/**
	* @Route("/cars")
	* @Method({"GET"})
    * @ApiDoc(
    *   resource=true,
    *   description="Returns a list of Car",
    * )
	*/
	public function index()
	{
		$cars = $this->getRepository()->findAll();

    	$cars = $this->get('serializer')->serialize($cars, 'json');

    	$response = new Response($cars, Response::HTTP_OK);
    	$response->headers->set('Content-Type', 'application/json');

        return $response;
	}

	/**
    * @Route("/cars/{id}", name="car_view")
    * @Method({"GET"})
    * @ApiDoc(
    *   resource=true,
    *   description="Returns a Car",
    * )
    */
    public function view(int $id)
    {
    	$car = $this->getRepository()->findOneBy(array('id' => $id));
    	$car = $this->get('serializer')->serialize($car, 'json');

    	$response = new Response($car, Response::HTTP_OK);
    	$response->headers->set('Content-Type', 'application/json');

    	return $response;
    }
}

?>