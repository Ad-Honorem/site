<?php

namespace ADH\BetBundle\Controller;

use ADH\BetBundle\Entity\Match;
use ADH\BetBundle\Entity\Pari;
use ADH\BetBundle\Form\parierType;
use ADH\BetBundle\Form\validerPariType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use ADH\BetBundle\Form\classementType;

class DefaultController extends Controller {

    /**
     * page de classement
     *
     * @Route("/classement", name="adh_bet_default_classement")
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function classementAction(Request $request) {
        $form = $this->createForm(new classementType());
        $matchs = $this->getDoctrine()->getManager()->getRepository("ADHBetBundle:Match")->passes("poule", -1,-1);
        $equipes = $this->getDoctrine()->getManager()->getRepository("ADHBetBundle:Equipe")->findAll();
        $tri = 0;
        $tab = array();
        if ($request->isMethod("POST")) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $tri = $form->getData()["tri"];
            }
        }
        foreach ($equipes as $e) {
            $tab[$e->getNom()]["essais"] = 0;
            $tab[$e->getNom()]["transformations"] = 0;
            $tab[$e->getNom()]["penalites"] = 0;
            $tab[$e->getNom()]["drops"] = 0;
            $tab[$e->getNom()]["bonusO"] = 0;
            $tab[$e->getNom()]["bonusD"] = 0;
            $tab[$e->getNom()]["points"] = 0;
            $tab[$e->getNom()]["gagne"] = 0;
            $tab[$e->getNom()]["perdu"] = 0;
            $tab[$e->getNom()]["nul"] = 0;
            $tab[$e->getNom()]["mis"] = 0;
            $tab[$e->getNom()]["pris"] = 0;
            $tab[$e->getNom()]["diff"] = 0;
            $tab[$e->getNom()]["poule"] = $e->getPoule();
            $tab[$e->getNom()]["id"] = $e->getId();
            $tab[$e->getNom()]["drapeau"] = $e->getDrapeau();
        }
        foreach ($tab as $t => $k) {
            foreach ($matchs as $m) {
                if ($t == $m->getEquipeA()->getNom()) {
                    $tab[$t]["essais"] += $m->getEssaiA();
                    $tab[$t]["transformations"] += $m->getTransA();
                    $tab[$t]["penalites"] += $m->getPenA();
                    $tab[$t]["drops"] += $m->getDropA();
                    $tab[$t]["mis"] += $m->getEssaiA() * 5 + $m->getTransA() * 2 + $m->getPenA() * 3 + $m->getDropA() * 3;
                    $tab[$t]["pris"] += $m->getEssaiB() * 5 + $m->getTransB() * 2 + $m->getPenB() * 3 + $m->getDropB() * 3;
                    $tab[$t]["gagne"] += (($m->getScoreA() > $m->getScoreB()) ? (1) : (0 ) );
                    $tab[$t]["perdu"] += (($m->getScoreA() < $m->getScoreB()) ? (1) : (0));
                    $tab[$t]["nul"] += (($m->getScoreA() == $m->getScoreB()) ? (1) : (0));
                    $tab[$t]["diff"] = $tab[$t]["mis"] - $tab[$t]["pris"];
                    $tab[$t]["bonusO"] += (($m->getEssaiA() > 3) ? (1) : (0 ) );
                    $tab [$t]["bonusD"] += ((($m->getScoreA() - $m->getScoreB()) > - 7 && ($m->getScoreA() - $m->getScoreB()) < 0 ) ? (1) : ( 0));
                    $tab[$t]["points"] += (($m->getScoreA() > $m->getScoreB()) ? (4) : (($m->getScoreA() == $m->getScoreB()) ? (2) : (0))) + (($m->getEssaiA() > 3) ? (1) : (0)) + ((($m->getScoreA() - $m->getScoreB()) > - 7 && ($m->getScoreA() - $m->getScoreB()) < 0 ) ? (1) : (0));
                }
                if ($t == $m->getEquipeB()->getNom()) {
                    $tab[$t]["essais"] += $m->getEssaiB();
                    $tab[$t]["transformations"] += $m->getTransB();
                    $tab[$t]["penalites"] += $m->getPenB();
                    $tab[$t]["drops"] += $m->getDropB();
                    $tab[$t]["mis"] += $m->getEssaiB() * 5 + $m->getTransB() * 2 + $m->getPenB() * 3 + $m->getDropB() * 3;
                    $tab[$t]["pris"] += $m->getEssaiA() * 5 + $m->getTransA() * 2 + $m->getPenA() * 3 + $m->getDropA() * 3;
                    $tab[$t]["gagne"] += (($m->getScoreA() < $m->getScoreB()) ? (1) : (0 ) );
                    $tab[$t]["perdu"] += (($m->getScoreA() > $m->getScoreB()) ? (1) : (0));
                    $tab[$t]["nul"] += (($m->getScoreA() == $m->getScoreB()) ? (1) : (0));
                    $tab[$t]["diff"] = $tab[$t]["mis"] - $tab[$t]["pris"];
                    $tab[$t]["bonusO"] += (($m->getEssaiB() > 3) ? (1) : (0 ) );
                    $tab [$t]["bonusD"] += ((($m->getScoreB() - $m->getScoreA()) > - 7 && ($m->getScoreB() - $m->getScoreA()) < 0 ) ? (1) : ( 0));
                    $tab[$t]["points"] += (($m->getScoreB() > $m->getScoreA()) ? (4) : (($m->getScoreB() == $m->getScoreA()) ? (2) : (0))) + (($m->getEssaiB() > 3) ? (1) : (0)) + ((($m->getScoreB() - $m->getScoreA()) > - 7 && ($m->getScoreB() - $m->getScoreA()) < 0 ) ? (1) : (0));
                }
            }
        }
        $res = array();
        if ($tri == 0) {
            $again = true;
            while ($again == true && sizeof($tab) > 0) {
                $again = false;
                $max = -1;
                $qui = null;
                $n = null;
                foreach ($tab as $t => $k) {
                    if ($tab[$t]["points"] > $max) {
                        $max = $tab[$t]["points"];
                        $qui = $tab[$t];
                        $n = $t;
                        $again = true;
                    }
                }
                $res[$n] = $qui;
                unset($tab[$n]);
            }
        } else if ($tri == 1) {
            $again = true;
            while ($again == true && sizeof($tab) > 0) {
                $again = false;
                $max = -1000;
                $qui = null;
                $n = null;
                foreach ($tab as $t => $k) {
                    if ($tab[$t]["diff"] > $max) {
                        $max = $tab[$t]["diff"];
                        $qui = $tab[$t];
                        $n = $t;
                        $again = true;
                    }
                }
                $res[$n] = $qui;
                unset($tab[$n]);
            }
        }
        else if ($tri == 2) {
            $again = true;
            while ($again == true && sizeof($tab) > 0) {
                $again = false;
                $max = -1;
                $qui = null;
                $n = null;
                foreach ($tab as $t => $k) {
                    if ($tab[$t]["pris"] > $max) {
                        $max = $tab[$t]["pris"];
                        $qui = $tab[$t];
                        $n = $t;
                        $again = true;
                    }
                }
                $res[$n] = $qui;
                unset($tab[$n]);
            }
        } 
        else if ($tri == 3) {
            $again = true;
            while ($again == true && sizeof($tab) > 0) {
                $again = false;
                $max = -1;
                $qui = null;
                $n = null;
                foreach ($tab as $t => $k) {
                    if ($tab[$t]["mis"] > $max) {
                        $max = $tab[$t]["mis"];
                        $qui = $tab[$t];
                        $n = $t;
                        $again = true;
                    }
                }
                $res[$n] = $qui;
                unset($tab[$n]);
            }
        }else if ($tri == 4) {
            $again = true;
            while ($again == true && sizeof($tab) > 0) {
                $again = false;
                $max = -1;
                $qui = null;
                $n = null;
                foreach ($tab as $t => $k) {
                    if ($tab[$t]["essais"] > $max) {
                        $max = $tab[$t]["essais"];
                        $qui = $tab[$t];
                        $n = $t;
                        $again = true;
                    }
                }
                $res[$n] = $qui;
                unset($tab[$n]);
            }
        }else if ($tri == 5) {
            $again = true;
            while ($again == true && sizeof($tab) > 0) {
                $again = false;
                $max = -1;
                $qui = null;
                $n = null;
                foreach ($tab as $t => $k) {
                    if ($tab[$t]["transformations"] > $max) {
                        $max = $tab[$t]["transformations"];
                        $qui = $tab[$t];
                        $n = $t;
                        $again = true;
                    }
                }
                $res[$n] = $qui;
                unset($tab[$n]);
            }
        }else if ($tri == 6) {
            $again = true;
            while ($again == true && sizeof($tab) > 0) {
                $again = false;
                $max = -1;
                $qui = null;
                $n = null;
                foreach ($tab as $t => $k) {
                    if ($tab[$t]["penalites"] > $max) {
                        $max = $tab[$t]["penalites"];
                        $qui = $tab[$t];
                        $n = $t;
                        $again = true;
                    }
                }
                $res[$n] = $qui;
                unset($tab[$n]);
            }
        }else if ($tri == 7) {
            $again = true;
            while ($again == true && sizeof($tab) > 0) {
                $again = false;
                $max = -1;
                $qui = null;
                $n = null;
                foreach ($tab as $t => $k) {
                    if ($tab[$t]["drops"] > $max) {
                        $max = $tab[$t]["drops"];
                        $qui = $tab[$t];
                        $n = $t;
                        $again = true;
                    }
                }
                $res[$n] = $qui;
                unset($tab[$n]);
            }
        }else if ($tri == 8) {
            $again = true;
            while ($again == true && sizeof($tab) > 0) {
                $again = false;
                $max = -1;
                $qui = null;
                $n = null;
                foreach ($tab as $t => $k) {
                    if ($tab[$t]["bonusO"] > $max) {
                        $max = $tab[$t]["bonusO"];
                        $qui = $tab[$t];
                        $n = $t;
                        $again = true;
                    }
                }
                $res[$n] = $qui;
                unset($tab[$n]);
            }
        }else if ($tri == 9) {
            $again = true;
            while ($again == true && sizeof($tab) > 0) {
                $again = false;
                $max = -1;
                $qui = null;
                $n = null;
                foreach ($tab as $t => $k) {
                    if ($tab[$t]["bonusD"] > $max) {
                        $max = $tab[$t]["bonusD"];
                        $qui = $tab[$t];
                        $n = $t;
                        $again = true;
                    }
                }
                $res[$n] = $qui;
                unset($tab[$n]);
            }
        }
        return ($this->render("ADHBetBundle:Default:classement.html.twig", array("tab" => $res, "form" => $form->createView())));
    }

    /**
     * faire un pari
     *
     * @Route("/add/{match}", name="adh_bet_default_add")
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Request $request, Match $match) {
        $paris = $this->getDoctrine()->getManager()->getRepository("ADHBetBundle:Pari")->findByMatch($match);
        $pari = new Pari();
        $pari->setMatch($match);
        $form = $this->createForm(new parierType(), $pari);

        if ($request->isMethod("POST")) {
            $form->handleRequest($request);
            if ($form->isValid() && $pari->getLadate() < $match->getLadate() && $pari->getMontant() > 1999 && $pari->getMontant() < 1000001) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($pari);
                $em->flush();
            }
            return ($this->redirect($this->generateUrl("adh_bet_match_view", array(
                                "match" => $match->getId()
            ))));
        }
        return ($this->render("ADHBetBundle:Default:parier.html.twig", array(
                    "form" => $form->createView(),
                    "m" => $match,
                    "paris" => $paris
        )));
    }

    /**
     * valider un pari
     *
     * @Security("has_role('ROLE_ADMIN')")
     * @Route("/valider/{pari}", name="adh_bet_default_validate")
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function validerAction(Request $request, Pari $pari) {
        $form = $this->createForm(new validerPariType(), $pari);
        $today = new \Datetime();
        if ($request->isMethod("POST")) {
            $form->handleRequest($request);
            if ($form->isValid() && $today < $pari->getmatch()->getLadate()) {
                $pari->setValidationdate($today);
                $pari->setEtat(1);
                $em = $this->getDoctrine()->getManager();
                $em->persist($pari);
                $em->flush();
            }
            return ($this->redirect($this->generateUrl("adh_bet_match_view", array(
                                "match" => $pari->getmatch()->getId()
            ))));
        }
        return ($this->render("ADHBetBundle:Default:validerPari.html.twig", array(
                    "form" => $form->createView(),
                    "p" => $pari
        )));
    }

    /**
     * supprimer un pari
     *
     * @Security("has_role('ROLE_ADMIN')")
     * @Route("/supprimer/{pari}", name="adh_bet_default_delete")
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function supprimerAction(Request $request, Pari $pari) {
        $form = $this->createForm(new validerPariType(), $pari);
        $match = $pari->getMatch()->getId();
        if ($request->isMethod("POST")) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($pari);
                $em->flush();
            }
            return ($this->redirect($this->generateUrl("adh_bet_match_view", array(
                                "match" => $match
            ))));
        }
        return ($this->render("ADHBetBundle:Default:supprimerPari.html.twig", array(
                    "form" => $form->createView(),
                    "p" => $pari
        )));
    }

}
