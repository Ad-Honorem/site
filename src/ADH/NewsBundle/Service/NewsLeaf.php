<?php

namespace ADH\NewsBundle\Service;

use ADH\SkeletonBundle\Service\NavbarLeaves\AbstractNavbarLeaf;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Translation\TranslatorInterface;

class NewsLeaf extends AbstractNavbarLeaf {

	/**
	 * @param RequestStack $request_stack
	 * @param RouterInterface $router
	 * @param TranslatorInterface $translator
	 */
	public function __construct(RequestStack $request_stack, RouterInterface $router, TranslatorInterface $translator) {
		parent::__construct($request_stack, $router, $translator, "News", "adh_news_view_default", "news");
	}
}
