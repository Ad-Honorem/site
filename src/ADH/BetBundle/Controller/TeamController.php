<?php

namespace ADH\BetBundle\Controller;

use ADH\BetBundle\Entity\Equipe;
use ADH\BetBundle\Repository\EquipeRepository;
use ADH\BetBundle\Form\ajouterEquipeType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/equipe")
 */
class TeamController extends Controller {

    /**
     * formulaire d'ajout d'une équipe
     *
     * @Security("has_role('ROLE_ADMIN')")
     * @Route("/add", name="adh_bet_team_add")
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addTeamAction(Request $request) {
        $equipe = new Equipe();
        $form = $this->createForm(new ajouterEquipeType(), $equipe);

        if ($request->isMethod("POST")) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($equipe);
                $em->flush();
            }
            return ($this->redirect($this->generateUrl("adh_bet_match")));
        }
        return ($this->render("ADHBetBundle:Team:ajouterEquipe.html.twig", array(
                    "form" => $form->createView()
        )));
    }

    /**
     * page de vue d'une équipe
     *
     * @Route("/{equipe}", name="adh_bet_team_view")
     * @Method({"GET"})
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function viewTeamAction(Equipe $equipe) {
        $matchs = $this->getDoctrine()->getManager()->getRepository("ADHBetBundle:Match")->findByTeam($equipe);
        $tab = array();
        $tab["essais"] = 0;
        $tab["essaisadv"] = 0;
        $tab["transformations"] = 0;
        $tab["transformationsadv"] = 0;
        $tab["penalites"] = 0;
        $tab["penalitesadv"] = 0;
        $tab["drops"] = 0;
        $tab["dropsadv"] = 0;
        $tab["bonusO"] = 0;
        $tab["bonusOadv"] = 0;
        $tab["bonusD"] = 0;
        $tab["bonusDadv"] = 0;
        $tab["points"] = 0;
        $tab["gagne"] = 0;
        $tab["perdu"] = 0;
        $tab["nul"] = 0;
        $tab["mis"] = 0;
        $tab["pris"] = 0;
        $tab["diff"] = 0;

        foreach ($matchs as $m) {
            if ($equipe == $m->getEquipeA()) {
                $tab["essais"] += $m->getEssaiA();
                $tab["transformations"] += $m->getTransA();
                $tab["penalites"] += $m->getPenA();
                $tab["drops"] += $m->getDropA();
                $tab["essaisadv"] += $m->getEssaiB();
                $tab["transformationsadv"] += $m->getTransB();
                $tab["penalitesadv"] += $m->getPenB();
                $tab["dropsadv"] += $m->getDropB();
                $tab["mis"] += $m->getEssaiA() * 5 + $m->getTransA() * 2 + $m->getPenA() * 3 + $m->getDropA() * 3;
                $tab["pris"] += $m->getEssaiB() * 5 + $m->getTransB() * 2 + $m->getPenB() * 3 + $m->getDropB() * 3;
                $tab["gagne"] += (($m->getScoreA() > $m->getScoreB()) ? (1) : (0 ) );
                $tab["perdu"] += (($m->getScoreA() < $m->getScoreB()) ? (1) : (0));
                $tab["nul"] += (($m->getScoreA() == $m->getScoreB() && $m->getLaDate() < new \DateTime) ? (1) : (0));
                $tab["diff"] = $tab["mis"] - $tab["pris"];
                $tab["bonusO"] += (($m->getEssaiA() > 3) ? (1) : (0 ) );
                $tab["bonusOadv"] += (($m->getEssaiB() > 3) ? (1) : (0 ) );
                $tab["bonusDadv"] += ((($m->getScoreB() - $m->getScoreA()) > - 7 && ($m->getScoreB() - $m->getScoreA()) < 0 ) ? (1) : ( 0));
                $tab["bonusD"] += ((($m->getScoreA() - $m->getScoreB()) > - 7 && ($m->getScoreA() - $m->getScoreB()) < 0 ) ? (1) : ( 0));
                $tab["points"] = 4 * $tab["gagne"] + 2 * $tab["nul"] + $tab["bonusO"] + $tab["bonusD"];
            } else {
                $tab["essais"] += $m->getEssaiB();
                $tab["transformations"] += $m->getTransB();
                $tab["penalites"] += $m->getPenB();
                $tab["drops"] += $m->getDropB();
                $tab["essaisadv"] += $m->getEssaiA();
                $tab["transformationsadv"] += $m->getTransA();
                $tab["penalitesadv"] += $m->getPenA();
                $tab["dropsadv"] += $m->getDropA();
                $tab["mis"] += $m->getEssaiB() * 5 + $m->getTransB() * 2 + $m->getPenB() * 3 + $m->getDropB() * 3;
                $tab["pris"] += $m->getEssaiA() * 5 + $m->getTransA() * 2 + $m->getPenA() * 3 + $m->getDropA() * 3;
                $tab["gagne"] += (($m->getScoreA() < $m->getScoreB()) ? (1) : (0 ) );
                $tab["perdu"] += (($m->getScoreA() > $m->getScoreB()) ? (1) : (0));
                $tab["nul"] += (($m->getScoreA() == $m->getScoreB() && $m->getLaDate() < new \DateTime) ? (1) : (0));
                $tab["diff"] = $tab["mis"] - $tab["pris"];
                $tab["bonusO"] += (($m->getEssaiB() > 3) ? (1) : (0 ) );
                $tab["bonusD"] += ((($m->getScoreB() - $m->getScoreA()) > - 7 && ($m->getScoreA() - $m->getScoreB()) < 0 ) ? (1) : ( 0));
                $tab["bonusOadv"] += (($m->getEssaiA() > 3) ? (1) : (0 ) );
                $tab["bonusDadv"] += ((($m->getScoreA() - $m->getScoreB()) > - 7 && ($m->getScoreA() - $m->getScoreB()) < 0 ) ? (1) : ( 0));
                $tab["points"] = 4 * $tab["gagne"] + 2 * $tab["nul"] + $tab["bonusO"] + $tab["bonusD"];
            }
        }

        return ($this->render("ADHBetBundle:Team:view.html.twig", array(
                    "equipe" => $equipe,
                    "data" => $tab,
                    "matchs" => $matchs
        )));
    }
    
    /**
     * page de vue des équipes
     *
     * @Route("/", name="adh_bet_team_all")
     * @Method({"GET"})
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function allTeamAction(Request $request) {
        $equipes = $this->getDoctrine()->getManager()->getRepository("ADHBetBundle:Equipe")->findBy(array(),array("nom" => "ASC"));
       
        return ($this->render("ADHBetBundle:Team:all.html.twig", array(
                    "equipes" => $equipes
        )));
    }

}
