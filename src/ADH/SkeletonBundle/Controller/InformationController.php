<?php

namespace ADH\SkeletonBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class InformationController extends Controller {
	/**
	 * CGU
	 *
	 * @Route("/cgu", name="adh_skeleton_cgu")
	 * @Method({"GET"})
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function actionCGU() {
		return ($this->render("ADHUserBundle:Information:cgu.html.twig"));
	}
	
	/**
	 * Policy
	 *
	 * @Route("/policy", name="adh_skeleton_policy")
	 * @Method({"GET"})
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function actionPolicy() {
		return ($this->render("ADHUserBundle:Information:policy.html.twig"));
	}
	
	/**
	 * Legal
	 *
	 * @Route("/legal", name="adh_skeleton_legal")
	 * @Method({"GET"})
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function actionLegal() {
		return ($this->render("ADHUserBundle:Information:legal.html.twig"));
	}
	
	/**
	 * Contact
	 *
	 * @Route("/contact", name="adh_skeleton_contact")
	 * @Method({"GET"})
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function actionContact() {
		return ($this->render("ADHUserBundle:Information:contact.html.twig"));
	}
}
