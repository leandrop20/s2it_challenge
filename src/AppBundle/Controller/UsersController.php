<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
* @Route("/api")
*/
class UsersController extends Controller
{
	/**
	* @Route("/users/new", name="users_new")
	* @Method({"POST"})
	* @ApiDoc(
    *   resource=true,
    *   description="Register a new user",
    * )
	*/
	public function new(Request $request)
	{
		$response = new Response();
		$normalizers = array(new ObjectNormalizer());
		$encoders = array(new JsonEncoder());
		$serializer = new Serializer($normalizers, $encoders);

		$user = $serializer->deserialize(
			$request->getContent(), User::class, 'json'
		);

		$encoder = $this->container->get('security.password_encoder');
		$passwordHash = $encoder->encodePassword(
				$user, $user->getPassword()
			);
		$user->setPassword($passwordHash);
		$user->setActive(1);
		$user->setCreated(new \DateTime());

		$errors = $this->get('validator')->validate($user);

		if (count($errors) == 0) {
    		$em = $this->getDoctrine()->getManager();

    		$em->persist($user);
    		$em->flush();

    		$response->setContent($serializer->serialize($user, 'json'));
    		$response->setStatusCode(Response::HTTP_CREATED);
    	} else {
    		$response->setContent($errors);
    		$response->setStatusCode(Response::HTTP_BAD_REQUEST);
    	}

		$response->headers->set('Content-Type', 'application/json');
		return $response;
	}

	/**
	* @Route("/login", name="users_login")
	* @Method({"POST"})
	* @ApiDoc(
    *   resource=true,
    *   description="Get a token",
    * )
	*/
	public function login(Request $request)
	{
		$data = json_decode($request->getContent());

		if (!(json_last_error() === JSON_ERROR_NONE)) {
			return new JsonResponse(['error' => 'Required JSON!'], 
				Response::HTTP_BAD_REQUEST);
		}

		if (!property_exists($data, 'username') || !property_exists($data, 'password')
			|| empty($data->username) || empty($data->password)) {
			return new JsonResponse(['error' => 'username and password is required!'], 
				Response::HTTP_BAD_REQUEST);
		}

		$user = $this->getDoctrine()->getRepository(User::class)
			->findOneByUsername($data->username);

		if (!$user) {
			return new JsonResponse(['error' => 'User Not Found'], 
				Response::HTTP_NOT_FOUND);
		}

		$isValid = $this->get('security.password_encoder')
			->isPasswordValid($user, $data->password);

		if (!$isValid) {
			return new JsonResponse(['error' => 'User Not Found'], 
				Response::HTTP_BAD_REQUEST);
		}
		
		$token = $this->getToken($user);
		
		return new JsonResponse(['token' => $token],
			Response::HTTP_OK);
	}

	public function getToken(User $user)
	{
		return $this->container->get('lexik_jwt_authentication.encoder')
			->encode([
				'username' => $user->getUsername(),
				'exp' => $this->getTokenExpiryDateTime()
			]);
	}

	public function getTokenExpiryDateTime()
	{
		$tokenTtl = $this->container->getParameter('lexik_jwt_authentication.token_ttl');
		$now = new \DateTime();
		$now->add(new \DateInterval('PT'.$tokenTtl.'S'));

		return $now->format('U');
	}

}

?>