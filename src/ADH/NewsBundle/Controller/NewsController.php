<?php

namespace ADH\NewsBundle\Controller;

use ADH\NewsBundle\Entity\News;
use ADH\NewsBundle\Form\DeleteNewsType;
use ADH\NewsBundle\Form\NewsType;
use ADH\NewsBundle\Form\EtatNewsType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/")
 */
class NewsController extends Controller {

	/**
	 * page d'ajout d'une news
	 *
	 * @Security("has_role('ROLE_ADMIN')")
	 * @Route("/add", name="adh_news_add")
	 * @Method({"GET","POST"})
	 *
	 * @param Request $request 
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function addNewsAction(Request $request) {
		$news = new News();
		$form = $this->createForm(new NewsType(), $news);

		if ($request->isMethod("POST")) {
			$form->handleRequest($request);
			if ($form->isValid()) {
				$em = $this->getDoctrine()->getManager();
				
				$news->setAuteur($this->getUser());
				$em->persist($news);
				$em->flush();
				$this->addFlash("success", "Votre news a bien été ajoutée.");
				return ($this->redirect($this->generateUrl("adh_news_view_default")));
			}
		}

		return ($this->render("ADHNewsBundle:News:add.html.twig", array(
				"form" => $form->createView()
		)));
	}

	/**
	 * page d'édition d'une News
	 * 
	 * @Security("has_role('ROLE_ADMIN')")
	 * @Route("/edit/{news}", name="adh_news_edit")
	 * @Method({"GET","POST"})
	 *
	 * @param Request $request 
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function editNewsAction(Request $request, News $news) {
		$form = $this->createForm(new NewsType(), $news);

		if ($request->isMethod("POST")) {
			$form->handleRequest($request);
			if ($form->isValid()) {
				$em = $this->getDoctrine()->getManager();
				
				$news->setEditeur($this->getUser());
				$news->setEditiondate(new \DateTime);
				$em->flush();
				$this->addFlash("success", "Votre news a bien été éditée.");
				return ($this->redirect($this->generateUrl("adh_news_view_default")));
			}
		}

		return ($this->render("ADHNewsBundle:News:edit.html.twig", array(
				"form" => $form->createView()
		)));
	}

	/**
	 * page de changement d'état d'une News
	 *
	 * @Security("has_role('ROLE_ADMIN')")
	 * @Route("/etat/{news}", name="adh_news_etat")
	 * @Method({"GET","POST"})
	 *
	 * @param Request $request 
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function etatNewsAction(Request $request, News $news) {
		if (!($news->getEtat() == 0 && ($news->getAuteur() != $this->getUser()))) {
			$form = $this->createForm(new EtatNewsType($this->getUser()), $news);
			
			if ($request->isMethod("POST")) {
				$form->handleRequest($request);
				if ($form->isValid()) {
					switch ($news->getEtat()) {
						case 4:
							break;
						case 3:
							$news->setPublicationdate(new \DateTime());
						default:
							$news->setMotifRefus(null);
							break;
					}
					$this->getDoctrine()->getManager()->flush();
					$this->addFlash("success", "L'état de la news a bien été mis à jour.");
					return ($this->redirect($this->generateUrl("adh_news_view_default")));
				}
			}
			return ($this->render("ADHNewsBundle:News:etat.html.twig", array(
					"form" => $form->createView(),
					"news" => $news
			)));
		}
		$this->addFlash("danger", "Cette news n'est pas encore prête a être publiée.");
		return ($this->redirect($this->generateUrl("adh_news_view_default")));
	}

	/**
	 * page de vue d'une News
	 *
	 * @Route("/view/{news}", name="adh_news_view")
	 * @Method({"GET"})
	 *
	 * @param Request $request 
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function viewNewsAction(Request $request, News $news) {
		return ($this->render("ADHNewsBundle:News:view.html.twig", array(
				"news" => $news
		)));
	}

	/**
	 * supprimer une news
	 *
	 * @Security("has_role('ROLE_ADMIN')")
	 * @Route("/delete/{news}", name="adh_news_delete")
	 * @Method({"GET", "POST"})
	 *
	 * @param Request $request 
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function deleteAction(Request $request, News $news) {
		$form = $this->createForm(new DeleteNewsType(), $news);

		if ($request->isMethod("POST")) {
			$form->handleRequest($request);
			if ($form->isValid()) {
				$em = $this->getDoctrine()->getManager();
				
				$em->remove($news);
				$em->flush();
				$this->addFlash("success", "Votre news a bien été supprimée.");
				return ($this->redirect($this->generateUrl("adh_news_view_default")));
			}
		}

		return ($this->render("ADHNewsBundle:News:delete.html.twig", array(
				"form" => $form->createView(),
				"news" => $news
		)));
	}

}
