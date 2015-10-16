<?php

namespace ADH\NewsBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/widget")
 */
class WidgetController extends Controller {
	/**
	 * Default widget
	 * 
	 * @Route("/", name="adh_news_widget")
	 * @Route("/default/{page}/{size}", name="adh_news_widget_default_pagination")
	 * @Method({"GET"})
	 * 
	 * @param Request $request
	 * @param number $page
	 * @param number $size
	 */
	public function defaultAction(Request $request, $page = 1, $size = 3) {
		return ($this->render("ADHNewsBundle:Widget:default.html.twig", array(
				"news" => $this->getDoctrine()->getRepository("ADHNewsBundle:News")->findByPage($page, $size),
				"page" => $page,
				"size" => $size
		)));
	}
}
