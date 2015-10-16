<?php

namespace ADH\UserBundle\Controller;

use ADH\UserBundle\Entity\UserToken;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/token")
 */
class TokenController extends Controller {
	/**
	 * Check a token
	 * 
	 * @Route("/check/{user}/{type}/{token}", name="adh_user_token_check")
	 * @Method({"GET", "POST"})
	 * 
	 * @ParamConverter("userToken", options={"repository_method": "findOne", "mapping": {"user": "user", "type": "type", "token": "token"}, "map_method_signature": true})
	 * 
	 * @param Request $request
	 * @param UserToken $token
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function checkAction(Request $request, UserToken $userToken = null) {
		if (!is_null($userToken)) {
			$response = $this->forward($userToken->getType()->getAction(), array(
					"userToken" => $userToken
			));
			if ($response instanceof RedirectResponse) {
				$entityManager = $this->getDoctrine()->getManager();
				
				$entityManager->remove($userToken);
				$entityManager->flush();
			}
			return ($response);
		}
		return ($this->render("ADHUserBundle:Token:error.html.twig"));
	}
	
	/**
	 * Invalidate a token
	 * 
	 * @Route("/invalidate/{user}/{type}/{token}", name="adh_user_token_invalidate")
	 * @Method({"GET"})
	 * 
	 * @ParamConverter("userToken", options={"repository_method": "findOne", "mapping": {"user": "user", "type": "type", "token": "token"}, "map_method_signature": true})
	 *
	 * @param Request $request
	 * @param UserToken $token
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function invalidateAction(Request $request, UserToken $userToken = null) {
		if (!is_null($userToken)) {
			$entityManager = $this->getDoctrine()->getManager();
			
			$entityManager->remove($userToken);
			$entityManager->flush();
			
			$this->addFlash("success", "Votre lien a bien été invalidé.");
			return ($this->redirectToRoute("homepage"));
		}
		return ($this->render("ADHUserBundle:Token:error.html.twig"));
	}
}