<?php

namespace ADH\UserBundle\Service\NavbarLeaves;

use ADH\SkeletonBundle\Service\NavbarLeaves\AbstractNavbarLeaf;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Translation\TranslatorInterface;

class LogoutLeaf extends AbstractNavbarLeaf {
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
		parent::__construct($request_stack, $router, $translator, "Se déconnecter", "adh_user_login_logout", "logout");

		$this->autorization_checker = $autorization_checker;
	}

	/**
	 * (non-PHPdoc)
	 * @see \ADH\SkeletonBundle\Service\NavbarLeeves\AbstractNavbarLeef::isDisplayable()
	 */
	public function isDisplayable() {
		return ($this->autorization_checker->isGranted("ROLE_USER") && !$this->autorization_checker->isGranted("ROLE_PREVIOUS_ADMIN"));
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \ADH\SkeletonBundle\Service\NavbarLeaves\AbstractNavbarLeaf::isCurrent()
	 */
	public function isCurrent() {
		return (false);
	}
}
