<?php

namespace ADH\UserBundle\Controller\Group;

use ADH\UserBundle\Entity\Form\SearchGroupUserPermission;
use ADH\UserBundle\Entity\Group;
use ADH\UserBundle\Entity\GroupUserPermission;
use ADH\UserBundle\Form\SearchGroupUserPermissionType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @Security("has_role('ROLE_USER')")
 * 
 * @Route("/group")
 */
class DefaultController extends Controller {
	/**
	 * Default action
	 * 
	 * @Route("/{page}/{size}", name="adh_user_group", requirements={"page": "\d+", "size": "\d+"}, defaults={"page": 0, "size": 24})
	 * @Method({"GET"})
	 * 
	 * @param Request $request
	 * @param number $page
	 * @param number $size
	 */
	public function defaultAction(Request $request, $page = 0, $size = 24) {
		if ($size <= 0) {
			throw new NotFoundHttpException("Size must be positive");
		}
		$repository = $this->getDoctrine()->getManager()->getRepository("ADHUserBundle:Group");
		
		return ($this->render("ADHUserBundle:Group/Default:default.html.twig", array(
				"total" => $repository->countAll(),
				"groups" => $repository->findAllPaginate($page, $size),
				"page" => $page,
				"size" => $size
		)));
	}
	
	/**
	 * View a group
	 * 
	 * @Route("/view/{group}", name="adh_user_group_default_view")
	 * @Method({"GET"})
	 * 
	 * @ParamConverter("group", options={"mapping": {"group": "role"}})
	 * 
	 * @param Request $request
	 * @param Group $group
	 * @param number $size
	 */
	public function viewAction(Request $request, Group $group) {
		return ($this->render("ADHUserBundle:Group/Default:view.html.twig", array(
				"group" => $group
		)));
	}
}