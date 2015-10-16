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

class MailController extends Controller {

	/**
	 * Register mail action
	 *
	 * @param Request $request 
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function registerAction(Request $request, User $user, $token) {
		$email = strtr(base64_encode($user->getEmail()), array(
				"/" => ".",
				"+" => "-",
				"=" => "_"
		));
		
		return ($this->render("ADHUserBundle:Mail:register.html.twig", array(
				"user" => $user,
				"email" => $email,
				"token" => $token
		)));
	}
}