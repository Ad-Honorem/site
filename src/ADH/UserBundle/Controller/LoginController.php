<?php

namespace ADH\UserBundle\Controller;

use ADH\UserBundle\Entity\Form\ForgetRequestPassword;
use ADH\UserBundle\Entity\Form\ForgetRetrievePassword;
use ADH\UserBundle\Entity\Form\UserLogin;
use ADH\UserBundle\Entity\User;
use ADH\UserBundle\Form\ForgetRequestPasswordType;
use ADH\UserBundle\Form\ForgetRetrievePasswordType;
use ADH\UserBundle\Form\LoginType;
use ADH\UserBundle\Form\RegisterType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use ADH\UserBundle\Entity\UserToken;

class LoginController extends Controller {

	/**
	 * Login page
	 *
	 * @Route("/login", name="adh_user_login")
	 * @Method({"GET"})
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function defaultAction(Request $request) {
		$user = $this->getUser();
		$reauth = !is_null($user);
		$authenticationUtils = $this->get("security.authentication_utils");
		
		$userLogin = new UserLogin();
		$userLogin->setUsername(($reauth) ? ($user->getUsername()) : ($authenticationUtils->getLastUsername()));
		$form = $this->createForm(new LoginType(array(
				"reauth" => $reauth
		)), $userLogin);
		
		if (!is_null($error = $authenticationUtils->getLastAuthenticationError())) {
			$form->addError(new FormError($error->getMessage()));
		}
		return ($this->render("ADHUserBundle:Login:default.html.twig", array(
				"reauth" => $reauth,
				"form" => $form->createView()
		)));
	}

	/**
	 * Register action
	 *
	 * @Route("/register", name="adh_user_login_register")
	 * @Method({"GET", "POST"})
	 *
	 * @param Request $request 
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function registerAction(Request $request) {
		$user = new User();
		$form = $this->createForm(new RegisterType(), $user);
		
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			$entityManager = $this->getDoctrine()->getManager();
			$userRepository = $entityManager->getRepository("ADHUserBundle:User");
			$userAlreadyUsed = $userRepository->isUserAlreadyExist($user->getUsername(), $user->getEmail());
			
			if ($userAlreadyUsed == User::NOT_ALREADY_USED) {
				$this->get("adh_user.user_manager")->registerUser($user);
				return ($this->redirectToRoute("homepage"));
			}
			if ($userAlreadyUsed & User::USERNAME_ALREADY_USED) {
				$form->get("username")->addError(new FormError("username already used"));
			}
			if ($userAlreadyUsed & User::EMAIL_ALREADY_USED) {
				$form->get("email")->addError(new FormError("email already used"));
			}
		}
		return ($this->render("ADHUserBundle:Login:register.html.twig", array(
				"form" => $form->createView()
		)));
	}
	
	/**
	 * Register confirm
	 * 
	 * @param Request $request
	 * @param UserToken $userToken
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse
	 */
	public function registerConfirmAction(Request $request, UserToken $userToken) {
		$entityManager = $this->getDoctrine()->getManager();
		$user = $userToken->getUser();
		$user->validate();
		
		$entityManager->persist($user);
		$entityManager->flush();
		
		$this->addFlash("success", "Votre inscription a bien été validée.");
		return ($this->redirectToRoute("homepage"));
	}

	/**
	 * Forget password
	 *
	 * @Route("/forget/request", name="adh_user_login_forgetrequest")
	 * @Method({"GET", "POST"})
	 *
	 * @param Request $request 
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function forgetRequestAction(Request $request) {
		$forgetPassword = new ForgetRequestPassword();
		$form = $this->createForm(new ForgetRequestPasswordType(), $forgetPassword);
		
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			$entityManager = $this->getDoctrine()->getManager();
			
			$user = $entityManager->getRepository("ADHUserBundle:User")->findOneByEmail($forgetPassword->getEmail());
			if (!is_null($user)) {
				$this->get("adh_user.user_token_factory")->createPersistAndSend($user, "retrieve_password");
				$this->addFlash("success", "Un email a été envoyé à l'adresse spécifiée.");
				return ($this->redirectToRoute("homepage"));
			}
			$form->get("email")->addError(new FormError("Aucun compte n'est associé à ce mail"));
		}
		return ($this->render("ADHUserBundle:Login:forgetRequest.html.twig", array(
				"form" => $form->createView()
		)));
	}

	/**
	 * Forget retrieve
	 * 
	 * @param Request $request
	 * @param UserToken $token
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
	 */
	public function forgetRetrieveAction(Request $request, UserToken $userToken) {
		$retrievePassword = new ForgetRetrievePassword();
		$form = $this->createForm(new ForgetRetrievePasswordType(), $retrievePassword);
		
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			$entityManager = $this->getDoctrine()->getManager();
			$userManager = $this->get("adh_user.user_manager");
			$user = $userToken->getUser();
			
			$user->setPlaintextPassword($retrievePassword->getPassword());
			$user = $userManager->updatePassword($user);
			
			$entityManager->persist($user);
			$entityManager->flush();
			
			$this->addFlash("success", "Le mot de passe de votre compte a bien été réinitialisé");
			return ($this->redirectToRoute("adh_user_login"));
		}
		return ($this->render("ADHUserBundle:Login:forgetRetrieve.html.twig", array(
				"form" => $form->createView(),
				"token" => $userToken
		)));
	}

	/**
	 * Check login page
	 *
	 * @Route("/check", name="adh_user_login_check")
	 * @Method({"POST"})
	 *
	 * @throws NotImplementedException
	 */
	public function checkAction() {
		// this action will not be executed, as the route is handled by the Security system
		throw new \LogicException("This action (adh_user_login_check) should not be called.");
	}

	/**
	 * Logout page
	 *
	 * @Route("/logout", name="adh_user_login_logout")
	 * @Method({"GET"})
	 *
	 * @throws \LogicException
	 */
	public function logoutAction() {
		// this action will not be executed, as the route is handled by the Security system
		throw new \LogicException("This action (adh_user_login_logout) should not be called.");
	}
}
