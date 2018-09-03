<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Cellphone;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
* @Route("/api")
*/
class CellphonesController extends Controller
{
	public function getRepository()
	{
		return $this->getDoctrine()->getRepository(Cellphone::class);
	}

	/**
	* @Route("/cellphones")
	* @Method({"GET"})
    * @ApiDoc(
    *   resource=true,
    *   description="Returns a list of Cellphone",
    * )
	*/
	public function index()
	{
		$cellphones = $this->getRepository()->findAll();

    	$cellphones = $this->get('serializer')->serialize($cellphones, 'json');

    	$response = new Response($cellphones, Response::HTTP_OK);
    	$response->headers->set('Content-Type', 'application/json');

        return $response;
	}

	/**
    * @Route("/cellphones/{id}", name="cellphone_view")
    * @Method({"GET"})
    * @ApiDoc(
    *   resource=true,
    *   description="Returns a Cellphone",
    * )
    */
    public function view(int $id)
    {
    	$cellphone = $this->getRepository()->findOneBy(array('id' => $id));
    	$cellphone = $this->get('serializer')->serialize($cellphone, 'json');

    	$response = new Response($cellphone, Response::HTTP_OK);
    	$response->headers->set('Content-Type', 'application/json');

    	return $response;
    }
}

?>