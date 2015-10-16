<?php

namespace ADH\UserBundle\Service;

use Symfony\Component\ExpressionLanguage\ExpressionLanguage as BaseExpressionLanguage;

class ExpressionLanguage extends BaseExpressionLanguage {

	/**
	 * (non-PHPdoc)
	 *
	 * @see \Symfony\Component\ExpressionLanguage\ExpressionLanguage::registerFunctions()
	 */
	protected function registerFunctions() {
		parent::registerFunctions();
		
		$this->register("user_can", function ($permission) {
			return (sprintf('$groupSecurityChecker->userCan($group, %s)', $permission));
		}, function (array $variables, $permission) {
			return ($variables["groupSecurityChecker"]->userCan($variables["group"], $permission));
		});
		$this->register("user_cannot", function ($permission) {
			return (sprintf('!$groupSecurityChecker->userCan($group, %s)', $permission));
		}, function (array $variables, $permission) {
			return (!$variables["groupSecurityChecker"]->userCan($variables["group"], $permission));
		});
		
		$this->register("group_is", function ($status) {
			return (sprintf('$groupSecurityChecker->groupIs($group, %s)', $status));
		}, function (array $variables, $status) {
			return ($variables["groupSecurityChecker"]->groupIs($variables["group"], $status));
		});
		$this->register("group_is_not", function ($status) {
			return (sprintf('!$groupSecurityChecker->groupIs($group, %s)', $status));
		}, function (array $variables, $status) {
			return (!$variables["groupSecurityChecker"]->groupIs($variables["group"], $status));
		});
	}
}