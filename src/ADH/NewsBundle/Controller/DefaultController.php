<?php

namespace ADH\NewsBundle\Controller;

use ADH\NewsBundle\Form\FilterNewsType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use ADH\NewsBundle\Entity\Form\FilterNews;

/**
 * @Route("/")
 */
class DefaultController extends Controller {

	/**
	 * page de vue d'une équipe
	 *
	 * @Route("/list/{page}", name="adh_news_default", defaults={"page": 1}, requirements={"page": "[0-9]+"})
	 * @Method({"GET", "POST"})
	 * 
	 * @param Request $request 
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function defaultNewsAction(Request $request, $page = 1) {
		$entityManager = $this->getDoctrine()->getManager();
		$filter = new FilterNews();
		$form = $this->createForm(new FilterNewsType(), $filter, array(
				"method" => "GET",
				"attr" => array(
						"id" => "filter"
				)
		));
		$tri = null;
		
		$form->handleRequest($request);
		if ($form->isValid()) {
			$tri = (($filter->hasCategory()) ? ($filter->getCategory()->getId()) : (null));
		}
		$writter = ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN'))?($this->getUser()->getId()):(false);
		$byPage = 25;
		$news = $entityManager->getRepository("ADHNewsBundle:News")->findByPage($page, $byPage, $tri, $writter);
		$c = (int)ceil(count($news) / $byPage);
		
		if ($page > $c) {
			$page = 1;
			$news = $entityManager->getRepository("ADHNewsBundle:News")->findByPage($page, $byPage, $tri, $writter);
		}
		
		if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN') == true) {
			$categ = $entityManager->getRepository("ADHNewsBundle:CategoryNews")->findBy(array(), array(
					"nom" => "ASC"
			));
			
			return ($this->render("ADHNewsBundle:Default:default.html.twig", array(
					"news" => $news,
					"categories" => $categ,
					"form" => $form->createView(),
					"pages" => $c,
					"page" => $page
			)));
		} else {
			return ($this->render("ADHNewsBundle:Default:default.html.twig", array(
					"news" => $news,
					"form" => $form->createView(),
					"pages" => $c,
					"page" => $page
			)));
		}
	}
}

