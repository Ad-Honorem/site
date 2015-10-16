<?php

namespace ADH\UserBundle\Controller;

use ADH\UserBundle\Entity\Form\ChangePassword;
use ADH\UserBundle\Entity\Form\ChangeEmail;
use ADH\UserBundle\Entity\UserToken;
use ADH\UserBundle\Form\ChangeEmailType;
use ADH\UserBundle\Form\ChangePasswordType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Security("has_role('ROLE_USER') and is_granted('IS_AUTHENTICATED_FULLY') and not is_granted('ROLE_PREVIOUS_ADMIN')")
 * @Route("/account")
 */
class AccountController extends Controller {

	/**
	 * Default account page
	 *
	 * @Route("/", name="adh_user_account")
	 * @Method({"GET"})
	 *
	 * @param Request $request 
	 * @return \ADH\UserBundle\Controller\Response
	 */
	public function defaultAction(Request $request) {
		return ($this->render("ADHUserBundle:Account:default.html.twig"));
	}

	/**
	 * Edit password
	 *
	 * @Route("/password", name="adh_user_account_password")
	 * @Method({"GET", "POST"})
	 *
	 * @param Request $request 
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function passwordAction(Request $request) {
		$changePassword = new ChangePassword();
		$form = $this->createForm(new ChangePasswordType(), $changePassword);
		
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			$user = $this->getUser();
			$userManager = $this->get("adh_user.user_manager");
			$entityManager = $this->getDoctrine()->getManager();
			
			$user->setPlaintextPassword($changePassword->getNew());
			$user = $userManager->updatePassword($user);
			
			$entityManager->persist($user);
			$entityManager->flush();
			return ($this->redirectToRoute("adh_user_account"));
		}
		return ($this->render("ADHUserBundle:Account:password.html.twig", array(
				"form" => $form->createView()
		)));
	}
	
	/**
	 * Edit email
	 *
	 * @Route("/email", name="adh_user_account_email")
	 * @Method({"GET", "POST"})
	 *
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function emailAction(Request $request) {
		$changeEmail = new ChangeEmail();
		$form = $this->createForm(new ChangeEmailType(), $changeEmail);
		
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			$this->get("adh_user.user_token_factory")->createPersistAndSend($this->getUser(), "mail_confirm", new \DateTime("+7 days"), array("email" => $changeEmail->getEmail()));
			$this->addFlash("info", "Un lien de confirmation a été envoyé à votre nouvelle adresse email.");
			return ($this->redirectToRoute("adh_user_account"));
		}
		return ($this->render("ADHUserBundle:Account:email.html.twig", array(
				"form" => $form->createView()
		)));
	}
	
	/**
	 * Email confirmation
	 * 
	 * @param Request $request
	 * @param UserToken $userToken
	 * @return \Symfony\Component\HttpFoundation\RedirectResponse
	 */
	public function emailConfirmAction(Request $request, UserToken $userToken) {
		$entityManager = $this->getDoctrine()->getManager();
		$user = $userToken->getUser();
		$context = $userToken->hasContext() ? $userToken->getContext() : null;
		
		if ($user->isEqualTo($this->getUser()) && $context !== null && array_key_exists("email", $context)) {
			$user->setEmail($context["email"]);
			
			$entityManager->persist($user);
			$entityManager->remove($userToken);
			$entityManager->flush();
			$this->addFlash("success", "Votre adresse email a bien été mise à jour.");
			return ($this->redirectToRoute("adh_user_account"));
		}
		$entityManager->remove($userToken);
		$entityManager->flush();
		
		$this->addFlash("error", "Votre demande ne peux pas être traité dans le contexte actuel et a été invalidé par mesure de sécurité. Merci d'en refaire une.");
		return ($this->redirectToRoute("adh_user_account_email"));
	}
}