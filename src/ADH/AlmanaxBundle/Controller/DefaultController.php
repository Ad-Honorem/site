<?php

namespace ADH\AlmanaxBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller {
	/**
	 * Almanax
	 *
	 * @Route("/", name="adh_almanax_default")
	 * @Method({"GET"})
	 *
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function defaultAction() {
		return ($this->render("ADHAlmanaxBundle:Default:default.html.twig"));
	}
}