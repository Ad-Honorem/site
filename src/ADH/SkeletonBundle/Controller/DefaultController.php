<?php

namespace ADH\SkeletonBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller {

	/**
	 * Homepage
	 *
	 * @Route("/", name="homepage")
	 * @Method({"GET"})
	 *
	 * @param Request $request 
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function defaultAction(Request $request) {
		return ($this->render("ADHSkeletonBundle:Default:default.html.twig"));
	}
}
