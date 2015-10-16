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

/**
 * @Security("has_role('ROLE_USER')")
 * 
 * @Route("/group/child")
 */
class ChildController extends Controller {

	/**
	 * List children
	 *
	 * @Route("/list/{group}/{page}/{size}", name="adh_user_group_child_list", requirements={"page": "\d+", "size": "\d+"}, defaults={"page": 0, "size": 24})
	 * @Method({"GET"})
	 * 
	 * @ParamConverter("group", options={"mapping": {"group": "role"}})
	 *
	 * @param Request $request 
	 * @param Group $group 
	 * @param int $page 
	 * @param int $size 
	 */
	public function listAction(Request $request, Group $group, $page = 0, $size = 24) {
		if ($size <= 0) {
			throw new NotFoundHttpException("Size must be positive");
		}
		
		return ($this->render("ADHUserBundle:Group/Child:list.html.twig", array(
				"group" => $group,
				"page" => $page,
				"size" => $size
		)));
	}
	
	/**
	 * Create child
	 *
	 * @Security("is_fully_authenticated()")
	 * 
	 * @Route("/create/{group}", name="adh_user_group_child_create")
	 * @Method({"GET", "POST"})
	 * 
	 * @ParamConverter("group", options={"mapping": {"group": "role"}})
	 *
	 * @param Request $request
	 * @param Group $group
	 */
	public function createAction(Request $request, Group $group) {
	}
	
	/**
	 * Create child
	 *
	 * @Security("is_fully_authenticated()")
	 * 
	 * @Route("/invite/{group}", name="adh_user_group_child_invite")
	 * @Method({"GET", "POST"})
	 * 
	 * @ParamConverter("group", options={"mapping": {"group": "role"}})
	 *
	 * @param Request $request
	 * @param Group $group
	 */
	public function inviteAction(Request $request, Group $group) {
	}
	
	/**
	 * Create child
	 *
	 * @Security("is_fully_authenticated()")
	 * 
	 * @Route("/accept/{group}", name="adh_user_group_child_invite")
	 * @Method({"GET", "POST"})
	 * 
	 * @ParamConverter("group", options={"mapping": {"group": "role"}})
	 *
	 * @param Request $request
	 * @param Group $group
	 */
	public function acceptAction(Request $request, Group $group) {
	}
}
