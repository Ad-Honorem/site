<?php

namespace ADH\UserBundle\Service\NavbarLeaves;

use ADH\SkeletonBundle\Service\NavbarLeaves\AbstractNavbarLeaf;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Translation\TranslatorInterface;

class AccountLeaf extends AbstractNavbarLeaf {
	/**
	 * Authorization Checker
	 *
	 * @var AuthorizationCheckerInterface
	 */
	private $autorization_checker;
	
	/**
	 *
	 * @param AuthorizationCheckerInterface $autorization_checker
	 * @param RequestStack $request_stack
	 * @param RouterInterface $router
	 * @param TranslatorInterface $translator
	 */
	public function __construct(AuthorizationCheckerInterface $autorization_checker, RequestStack $request_stack, RouterInterface $router, TranslatorInterface $translator) {
		parent::__construct($request_stack, $router, $translator, "Mon compte", "adh_user_user_account", "account");
	
		$this->autorization_checker = $autorization_checker;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \ADH\SkeletonBundle\Service\NavbarLeeves\AbstractNavbarLeef::isDisplayable()
	 */
	public function isDisplayable() {
		return ($this->autorization_checker->isGranted("ROLE_USER") && !$this->autorization_checker->isGranted("ROLE_PREVIOUS_ADMIN"));
	}
}