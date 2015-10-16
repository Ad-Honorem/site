<?php

namespace ADH\SkeletonBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class NavbarController extends Controller {
	public function defaultAction() {
		return ($this->render("ADHSkeletonBundle:Navbar:default.html.twig", array(
				"leaves" => $this->get("adh_skeleton.navbar")->getLeaves()
		)));
	}
}
