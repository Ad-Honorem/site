<?php

namespace ADH\UserBundle\Controller;

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
 * @Route("/profil")
 */
class ProfilController extends Controller {

	/**
	 * User profil
	 *
	 * @Route("/", name="adh_user_profil_default")
	 * @Method({"GET"})
	 *
	 * @param Request $request 
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function defaultAction(Request $request) {
		return ($this->render("ADHUserBundle:Profil:default.html.twig"));
	}

	/**
	 * Other user profil
	 *
	 * @Route("/{pseudo}", name="adh_user_profil_view")
	 * @Method({"GET"})
	 * @ParamConverter("user", options={"mapping": {"pseudo": "pseudo"}})
	 *
	 * @param Request $request 
	 * @param User $user 
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function viewAction(Request $request, User $user) {
		return ($this->render("ADHUserBundle:Profil:view.html.twig", array(
				"user" => $user
		)));
	}

	/**
	 * User profil resume
	 *
	 * @Route("/resume", name="adh_user_profil_resume")
	 * @Method({"GET"})
	 *
	 * @param Request $request 
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function resumeAction(Request $request) {
		return ($this->render("ADHUserbundle:Profil:resume.html.twig"));
	}

	/**
	 * Edit user profil
	 *
	 * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
	 * @Route("/edit", name="adh_user_profil_edit")
	 * @Method({"GET", "POST"})
	 *
	 * @param Request $request 
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function editAction(Request $request) {
		return ($this->render("ADHUserBundle:Profil:edit.html.twig"));
	}
}
