<?php

namespace ADH\UserBundle\Controller\Group;

use ADH\UserBundle\Entity\Annotation\GroupSecurity;
use ADH\UserBundle\Entity\Form\DelegateBaseRight;
use ADH\UserBundle\Entity\Group;
use ADH\UserBundle\Entity\GroupUserPermission;
use ADH\UserBundle\Form\DelegateBaseRightType;
use ADH\UserBundle\Form\DelegateSpecialRightType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Security("has_role('ROLE_USER') and is_fully_authenticated()")
 * @Route("/group/delegate")
 */
class DelegateController extends Controller {

	/**
	 * Delegate base right
	 *
	 * @GroupSecurity("user_can('delegate')", group="group", strict_expression=true)
	 *
	 * @Route("/{role}/{pseudo}", name="adh_user_group_delegate")
	 * @Method({"GET", "POST"})
	 * @ParamConverter("group", options={
	 * 	"mapping":{
	 * 		"role": "role"
	 * 	}
	 * })
	 * @ParamConverter("permission", options={
	 * 	"repository_method": "findOneByGroupAndUser",
	 * 	"mapping":{
	 * 		"role": "group",
	 * 		"pseudo": "user"
	 * 	},
	 * 	"map_method_signature": true
	 * })
	 *
	 * @param Request $request 
	 * @param Group $group 
	 */
	public function defaultAction(Request $request, Group $group, GroupUserPermission $permission) {
		$delegateBaseRight = new DelegateBaseRight($permission);
		$form = $this->createForm(new DelegateBaseRightType($this->get("adh_user.group_security_checker")->getUserPermission($group)), $delegateBaseRight);
		
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			$entityManager = $this->getDoctrine()->getManager();
			
			$permission->setAddMemberRight($delegateBaseRight->hasAddMemberRight());
			$permission->setRemoveMemberRight($delegateBaseRight->hasRemoveMemberRight());
			$permission->setChangeStatusRight($delegateBaseRight->hasChangeStatusRight());
			$entityManager->flush();
			
			return ($this->redirectToRoute("adh_user_group_member_list", array(
					"role" => $permission->getGroup()->getShortRole()
			)));
		}
		return ($this->render("ADHUserBundle:Group/Delegate:default.html.twig", array(
				"form" => $form->createView()
		)));
	}

	/**
	 * Delegate special right
	 *
	 * @GroupSecurity("user_can('special')", group="group", strict_expression=true)
	 *
	 * @Route("/advanced/{role}/{pseudo}", name="adh_user_group_delegate_advanced")
	 * @Method({"GET", "POST"})
	 * @ParamConverter("group", options={
	 * 	"mapping":{
	 * 		"role": "role"
	 * 	}
	 * })
	 * @ParamConverter("permission", options={
	 * 	"repository_method": "findOneByGroupAndUser",
	 * 	"mapping":{
	 * 		"role": "group",
	 * 		"pseudo": "user"
	 * 	},
	 * 	"map_method_signature": true
	 * })
	 *
	 * @param Request $request 
	 * @param Group $group 
	 */
	public function advancedAction(Request $request, Group $group, GroupUserPermission $permission) {
		$form = $this->createForm(new DelegateSpecialRightType(), $permission);
		
		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			$this->getDoctrine()->getManager()->flush();
			return ($this->redirectToRoute("adh_user_group_member_list", array(
					"role" => $permission->getGroup()->getShortRole()
			)));
		}
		return ($this->render("ADHUserBundle:Group/Delegate:advanced.html.twig", array(
				"form" => $form->createView()
		)));
	}
}