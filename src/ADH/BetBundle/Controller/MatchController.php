<?php

namespace ADH\BetBundle\Controller;

use ADH\BetBundle\Entity\Match;
use ADH\BetBundle\Form\ajouterMatchType;
use ADH\BetBundle\Form\scoreType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/match")
 */
class MatchController extends Controller {

	/**
	 * Homepage
	 *
	 * @Route("/", name="adh_bet_match")
	 * @Method({"GET"})
	 *
	 * @param Request $request 
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function defaultAction(Request $request) {
		$matchRepository = $this->getDoctrine()->getManager()->getRepository("ADHBetBundle:Match");
		$aVenir = $matchRepository->aVenir("all", -1, 5);
		$passes = $matchRepository->passes("all", -1, 5);
		
		return ($this->render("ADHBetBundle:Match:default.html.twig", array(
				"aVenir" => $aVenir,
				"passes" => $passes
		)));
	}

	/**
	 * vue d'un match
	 *
	 * @Route("/view/{match}", name="adh_bet_match_view")
	 * @Method({"GET"})
	 *
	 * @param Request $request 
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function viewMatchAction(Match $match) {
		$paris = $this->getDoctrine()->getManager()->getRepository("ADHBetBundle:Pari")->findByMatch($match);
		$tot = 0;
		$tot1 = 0;
		$tot2 = 0;
		$tot3 = 0;
		
		foreach ($paris as $p) {
			$tot += $p->getMontant();
			if ($p->getResultat() == 1) {
				$tot1 += $p->getMontant();
			}
			if ($p->getResultat() == 2) {
				$tot2 += $p->getMontant();
			}
			if ($p->getResultat() == 3) {
				$tot3 += $p->getMontant();
			}
		}
		return ($this->render("ADHBetBundle:Match:leMatch.html.twig", array(
				"m" => $match,
				"paris" => $paris,
				"tot" => $tot,
				"tot1" => $tot1,
				"tot2" => $tot2,
				"tot3" => $tot3
		)));
	}

	/**
	 * formulaire d'ajout d'un match
	 *
	 * @Security("has_role('ROLE_ADMIN')")
	 * @Route("/add", name="adh_bet_match_add")
	 * @Method({"GET", "POST"})
	 *
	 * @param Request $request 
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function addMatchAction(Request $request) {
		$match = new Match();
		$form = $this->createForm(new ajouterMatchType(), $match);
		
		if ($request->isMethod("POST")) {
			$form->handleRequest($request);
			if ($form->isValid()) {
				$em = $this->getDoctrine()->getManager();
				$em->persist($match);
				$em->flush();
			}
			return ($this->redirect($this->generateUrl("adh_bet_match")));
		}
		return ($this->render("ADHBetBundle:Match:ajouterMatch.html.twig", array(
				"form" => $form->createView()
		)));
	}

	/**
	 * saisir le score
	 *
	 * @Security("has_role('ROLE_ADMIN')")
	 * @Route("/edit/{match}", name="adh_bet_match_edit")
	 * @Method({"GET", "POST"})
	 *
	 * @param Request $request 
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function editAction(Request $request, Match $match) {
		$form = $this->createForm(new scoreType(), $match);
		
		if ($request->isMethod("POST")) {
			$form->handleRequest($request);
			if ($form->isValid()) {
				$em = $this->getDoctrine()->getManager();
				$em->persist($match);
				$em->flush();
			}
			return ($this->redirect($this->generateUrl("adh_bet_match_view", array(
					"match" => $match->getId()
			))));
		}
		return ($this->render("ADHBetBundle:Match:score.html.twig", array(
				"form" => $form->createView(),
				"m" => $match
		)));
	}
}