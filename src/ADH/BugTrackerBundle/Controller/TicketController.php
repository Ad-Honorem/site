<?php

namespace ADH\BugTrackerBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use ADH\BugTrackerBundle\Form\ReportType;
use ADH\BugTrackerBundle\Entity\BugTrackerTicket;
use Symfony\Component\Security\Core\User\UserInterface;
use ADH\UserBundle\Entity\User;
use ADH\BugTrackerBundle\Entity\BugTrackerState;

/**
 * @Route("/tickets")
 */
class TicketController extends Controller {
	/**
	 * List tickets
	 *
	 * @Route("/list/{page}/{size}", name="adh_bugtracker_ticket_list", defaults={"page": 0, "size": 30}, requirements={"page": "[0-9]+", "size": "[0-9]+"})
	 * @Method({"GET"})
	 *
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function listAction(Request $request, $page = 0, $size = 30) {
		return ($this->render("ADHBugTrackerBundle:Tickets:list.html.twig"));
	}
	
	/**
	 * View a ticket
	 *
	 * @Route("/view/{id}/{token}", name="adh_bugtracker_ticket_view", defaults={"token": null})
	 * @Method({"GET"})
	 * 
	 * @ParamConverter("ticket", class="ADHBugTrackerBundle:BugTrackerTicket", options={
	 * 	"repository_method" = "findOneByIdAndToken",
	 * 	"mapping": {
	 * 		"id": "id",
	 * 		"token": "token"
	 * 	},
	 * 	"map_method_signature" = true
	 * })
	 *
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function viewAction(Request $request, BugTrackerTicket $ticket) {
		return ($this->render("ADHBugTrackerBundle:Tickets:view.html.twig", array(
				"ticket" => $ticket
		)));
	}
	
	/**
	 * Report
	 *
	 * @Route("/report", name="adh_bugtracker_ticket_report")
	 * @Method({"GET", "POST"})
	 *
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function reportAction(Request $request) {
		$ticket = new BugTrackerTicket();
		$form = $this->createForm(new ReportType(), $ticket);
		
		if ($request->isMethod("POST")) {
			$form->handleRequest($request);
			if ($form->isValid()) {
				$reporter = $this->getUser();
				$entityManager = $this->getDoctrine()->getManager();
				
				if ($reporter instanceof User) {
					$ticket->setReporter($reporter);
				}
				$ticket->setState($entityManager->getRepository("ADHBugTrackerBundle:BugTrackerState")->findOneByState(BugTrackerState::DEFAULT_STATE));
				$entityManager->persist($ticket);
				$entityManager->flush();
				$this->addFlash("success", "Votre bug a bien été enregistré. Merci pour votre report.");
				return ($this->redirectToRoute("adh_bugtracker_ticket_view", array(
						"id" => $ticket->getId(),
						"token" => $ticket->getToken()
				)));
			}
		}
		return ($this->render("ADHBugTrackerBundle:Tickets:report.html.twig", array(
				"form" => $form->createView()
		)));
	}
}
