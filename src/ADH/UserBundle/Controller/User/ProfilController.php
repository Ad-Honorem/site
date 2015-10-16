<?php

namespace ADH\UserBundle\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use ADH\UserBundle\Entity\User;

/**
 * User profil controller
 *
 * @Security("has_role('ROLE_USER')")
 * 
 * @Route("/user/profil")
 */
class ProfilController extends Controller {

	/**
	 * User profil
	 *
	 * @Route("/{pseudo}", name="adh_user_user_profil", defaults={"pseudo": null})
	 * @Method({"GET"})
	 * 
	 * @ParamConverter("user", options={"mapping": {"pseudo": "pseudo"}})
	 *
	 * @param Request $request 
	 * @param User $user 
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function defaultAction(Request $request, User $user = null) {
		if (is_null($user)) {
			if (!is_null($pseudo = $request->attributes->get("pseudo", null))) {
				return ($this->render("ADHUserBundle:User/Profil:notfound.html.twig", array(
						"pseudo" => $pseudo
				)));
			}
			$user = $this->getUser();
		}
		return ($this->render("ADHUserBundle:User/Profil:default.html.twig", array(
				"user" => $user,
				"me" => $user->isEqualTo($this->getUser())
		)));
	}

	/**
	 * User profil resume
	 *
	 * @Route("/resume", name="adh_user_user_profil_resume")
	 * @Method({"GET"})
	 *
	 * @param Request $request 
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function resumeAction(Request $request) {
		return ($this->render("ADHUserbundle:User/Profil:resume.html.twig"));
	}

	/**
	 * Edit user profil
	 *
	 * @Security("is_fully_authenticated()")
	 * 
	 * @Route("/edit", name="adh_user_user_profil_edit")
	 * @Method({"GET", "POST"})
	 *
	 * @param Request $request 
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function editAction(Request $request) {
		return ($this->render("ADHUserBundle:User/Profil:edit.html.twig"));
	}
}
