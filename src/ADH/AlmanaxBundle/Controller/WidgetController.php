<?php

namespace ADH\AlmanaxBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/widget")
 */
class WidgetController extends Controller {
	/**
	 * Main widget
	 *
	 * @Route("/", name="adh_almanax_minify")
	 * @Method({"GET"})
	 *
	 * @param Request $request
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function defaultAction() {
		$today = null;
		$todayDate = new \DateTime();
		$tomorrow = null;
		$tomorrowDate = new \DateTime("+1 day");
		
		foreach ($this->getDoctrine()->getManager()->getRepository("ADHAlmanaxBundle:Almanax")->getTodayAndTomorrow() as $day) {
			if ($todayDate->format("m-d") == $day->getDate()->format("m-d") && (is_null($today) || $today->getDate()->format("Y") < $day->getDate()->format("Y"))) {
				$today = $day;
			}
			if ($tomorrowDate->format("m-d") == $day->getDate()->format("m-d") && (is_null($tomorrow) || $tomorrow->getDate()->format("Y") < $day->getDate()->format("Y"))) {
				$tomorrow = $day;
			}
		}
		
		return ($this->render("ADHAlmanaxBundle:Widget:default.html.twig", array(
				"today" => $today,
				"tomorrow" => $tomorrow
		)));
	}
}