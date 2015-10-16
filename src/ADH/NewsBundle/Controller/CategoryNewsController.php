<?php

namespace ADH\NewsBundle\Controller;

use ADH\NewsBundle\Entity\CategoryNews;
use ADH\NewsBundle\Form\CategoryNewsType;
use ADH\NewsBundle\Form\DeleteCategoryNewsType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/category")
 */
class CategoryNewsController extends Controller {

	/**
	 *
	 * page d'ajout d'une CategoryNews
	 *
	 *
	 *
	 * @Security("has_role('ROLE_ADMIN')")
	 *
	 * @Route("/add", name="adh_news_add_category")
	 *
	 * @Method({"GET","POST"})
	 *
	 *
	 *
	 * @param Request $request 
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 *
	 */
	public function addCategoryNewsAction(Request $request) {
		$category = new CategoryNews();
		$category->setAuteur($this->getUser());
		$form = $this->createForm(new CategoryNewsType(), $category);
		
		if ($request->isMethod("POST")) {
			$form->handleRequest($request);
			if ($form->isValid()) {
				$em = $this->getDoctrine()->getManager();
				$em->persist($category);
				$em->flush();
			}
			
			return ($this->redirect($this->generateUrl("adh_news_default")));
		}
		
		return ($this->render("ADHNewsBundle:Category:add.html.twig", array(
				"form" => $form->createView()
		)));
	}

	/**
	 * page d'édiion d'une CategoryNews
	 *
	 * @Security("has_role('ROLE_ADMIN')")
	 * @Route("/edit/{categorienews}", name="adh_news_category_edit")
	 * @Method({"GET","POST"})
	 *
	 * @param Request $request 
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function editCategoryNewsAction(Request $request, CategoryNews $categorienews) {
		$form = $this->createForm(new CategoryNewsType(), $categorienews);
		
		if ($request->isMethod("POST")) {
			$form->handleRequest($request);
			if ($form->isValid()) {
				$em = $this->getDoctrine()->getManager();
				$em->persist($categorienews);
				$em->flush();
			}
			
			return ($this->redirect($this->generateUrl("adh_news_default")));
		}
		
		return ($this->render("ADHNewsBundle:Category:edit.html.twig", array(
				"form" => $form->createView(),
				"categorie" => $categorienews
		)));
	}

	/**
	 * supprimer une catégorie
	 *
	 * @Security("has_role('ROLE_ADMIN')")
	 * @Route("/delete/{categorienews}", name="adh_news_category_delete")
	 * @Method({"GET", "POST"})
	 *
	 * @param Request $request 
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function deleteAction(Request $request, CategoryNews $categorienews) {
		$form = $this->createForm(new DeleteCategoryNewsType(), $categorienews);
		
		if ($request->isMethod("POST")) {
			$form->handleRequest($request);
			if ($form->isValid()) {
				$em = $this->getDoctrine()->getManager();
				$em->remove($categorienews);
				$em->flush();
			}
			
			return ($this->redirect($this->generateUrl("adh_news_default")));
		}
		
		return ($this->render("ADHNewsBundle:Category:delete.html.twig", array(
				"form" => $form->createView(),
				"categorie" => $categorienews
		)));
	}
}
