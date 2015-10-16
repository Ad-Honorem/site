<?php

namespace ADH\UserBundle\Controller\Group;

use ADH\UserBundle\Entity\Annotation\GroupSecurity;
use ADH\UserBundle\Entity\Form\SearchUser;
use ADH\UserBundle\Entity\Group;
use ADH\UserBundle\Entity\GroupUserPermission;
use ADH\UserBundle\Form\SearchUserType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use ADH\UserBundle\Entity\Form\SearchGroupUserPermission;
use ADH\UserBundle\Form\SearchGroupUserPermissionType;

/**
 * @Security("has_role('ROLE_USER')")
 * 
 * @Route("/group/member")
 */
class MemberController extends Controller {
	
	/**
	 * List member of a group
	 *
	 * @Route("/list/{group}/{page}/{size}", name="adh_user_group_member_list", requirements={"page": "\d+", "size": "\d+"}, defaults={"page": 0, "size": 24})
	 * @Method({"GET", "POST"})
	 *
	 * @ParamConverter("group", options={"mapping": {"group": "role"}})
	 *
	 * @param Request $request
	 * @param Group $group
	 */
	public function listAction(Request $request, Group $group, $page = 0, $size = 24) {
		if ($size <= 0) {
			throw new NotFoundHttpException("Size must be positive");
		}
		return ($this->render("ADHUserBundle:Group/Member:list.html.twig", array(
				"group" => $group,
				"page" => $page,
				"size" => $size
		)));
	}
	
	/**
	 * Add member to group
	 *
	 * @Security("is_fully_authenticated()")
	 * @GroupSecurity("group_is('joinable') and user_can('add member')", group="group")
	 * 
	 * @Route("/add/{group}", name="adh_user_group_member_add")
	 * @Method({"GET", "POST"})
	 * 
	 * @ParamConverter("group", options={"mapping": {"group": "role"}})
	 *
	 * @param Request $request
	 * @param Group $group
	 */
	public function addAction(Request $request, Group $group) {
		$searchUser = new SearchUser();
		$form = $this->createForm(new SearchUserType(), $searchUser);
		
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			$entityManager = $this->getDoctrine()->getManager();
			$groupUserPermission = new GroupUserPermission();
			
			$groupUserPermission->setGroup($group);
			$groupUserPermission->setUser($searchUser->getUser());
			$entityManager->persist($groupUserPermission);
			$entityManager->flush();
			
			return ($this->redirectToRoute("adh_user_group_member_list", array(
					"group" => $group->getShortRole(),
					"size" => (($request->isXmlHttpRequest()) ? (4) : (24))
			)));
		}
		return ($this->render("ADHUserBundle:Group/Member:add.html.twig", array(
				"form" => $form->createView(),
				"group" => $group
		)));
	}
	
	/**
	 * Add member to group
	 * 
	 * @Security("is_fully_authenticated()")
	 * @GroupSecurity("group_is('leavable') and user_can('remove member')", group="group")
	 * 
	 * @Route("/remove/{group}", name="adh_user_group_member_remove")
	 * @Method({"GET", "POST"})
	 * 
	 * @ParamConverter("group", options={"mapping": {"group": "role"}})
	 *
	 * @param Request $request
	 * @param Group $group
	 */
	public function removeAction(Request $request, Group $group) {
		$searchGroupUserPermission = new SearchGroupUserPermission();
		$form = $this->createForm(new SearchGroupUserPermissionType($group), $searchGroupUserPermission);
		
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid() && $searchGroupUserPermission->isConfirmed()) {
			$entityManager = $this->getDoctrine()->getManager();
			
			$entityManager->remove($searchGroupUserPermission->getGroupUserPermission());
			$entityManager->flush();
			return ($this->redirectToRoute("adh_user_group_member_list", array(
					"group" => $group->getShortRole(),
					"size" => (($request->isXmlHttpRequest()) ? (4) : (24))
			)));
		}
		return ($this->render("ADHUserBundle:Group/Member:remove.html.twig", array(
				"form" => $form->createView(),
				"group" => $group
		)));
	}
}