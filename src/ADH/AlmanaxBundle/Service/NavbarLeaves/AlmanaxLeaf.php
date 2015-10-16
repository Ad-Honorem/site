<?php

namespace ADH\AlmanaxBundle\Service\NavbarLeaves;

use ADH\SkeletonBundle\Service\NavbarLeaves\AbstractNavbarLeaf;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Translation\TranslatorInterface;

class AlmanaxLeaf extends AbstractNavbarLeaf {
	/**
	 *
	 * @param RequestStack $request_stack
	 * @param RouterInterface $router
	 * @param TranslatorInterface $translator
	 */
	public function __construct(RequestStack $request_stack, RouterInterface $router, TranslatorInterface $translator) {
		parent::__construct($request_stack, $router, $translator, "Almanax", "adh_almanax_default", "almanax");
	}
}