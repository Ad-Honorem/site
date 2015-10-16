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
 * @Route("/group/request")
 */
class RequestController extends Controller{
	/**
	 * View request
	 * 
	 * @Route("/view/{group}/{size}", name="adh_user_group_request_view", requirements={"size": "\d+"}, defaults={"size": 7}))
	 * @Method({"GET"})
	 * 
	 * @ParamConverter("group", options={"mapping": {"group": "role"}})
	 * 
	 * @param Request $request
	 * @param Group $group
	 * @param number $size
	 */
	public function viewAction(Request $request, Group $group, $size = 7) {
		if ($size <= 0) {
			throw new NotFoundHttpException("Size must be positive");
		}
		
		return ($this->render("ADHUserBundle:Group/Request:view.html.twig", array(
				"group" => $group,
				"size" => $size
		)));
	}
	
	/**
	 * Hierarchy received
	 * 
	 * @Route("/hierarchy/received/{group}/{page}/{size}", name="adh_user_group_request_hierarchyreceived", requirements={"page": "\d+", "size": "\d+"}, defaults={"page": 0, "size": 24}))
	 * @Method({"GET"})
	 * 
	 * @ParamConverter("group", options={"mapping": {"group": "role"}})
	 * 
	 * @param Request $request
	 * @param Group $group
	 * @param number $page
	 * @param number $size
	 */
	public function hierarchyReceivedAction(Request $request, Group $group, $page = 0, $size = 24) {
		if ($size <= 0) {
			throw new NotFoundHttpException("Size must be positive");
		}
		
		$entityManager = $this->getDoctrine()->getManager();
		$repository = $entityManager->getRepository("ADHUserBundle:GroupHierarchyRequest");
		
		return ($this->render("ADHUserBundle:Group/Request:hierarchyreceived.html.twig", array(
				"requests" => $repository->findAllPaginateFor($group, $page, $size)
		)));
	}
	
	/**
	 * Hierarchy sent
	 *
	 * @Route("/hierarchy/sent/{group}/{page}/{size}", name="adh_user_group_request_hierarchysent", requirements={"page": "\d+", "size": "\d+"}, defaults={"page": 0, "size": 24}))
	 * @Method({"GET"})
	 * 
	 * @ParamConverter("group", options={"mapping": {"group": "role"}})
	 *
	 * @param Request $request
	 * @param Group $group
	 * @param number $page
	 * @param number $size
	 */
	public function hierarchySentAction(Request $request, Group $group, $page = 0, $size = 24) {
		if ($size <= 0) {
			throw new NotFoundHttpException("Size must be positive");
		}
		
		$entityManager = $this->getDoctrine()->getManager();
		$repository = $entityManager->getRepository("ADHUserBundle:GroupHierarchyRequest");
		
		return ($this->render("ADHUserBundle:Group/Request:hierarchysent.html.twig", array(
				"requests" => $repository->findAllPaginateFrom($group, $page, $size)
		)));
	}
}