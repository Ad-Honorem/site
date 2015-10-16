<?php

namespace ADH\UserBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;

class GroupUserPermissionRepository extends EntityRepository {
	/**
	 * Get the user by username or email
	 * 
	 * @param string $identifier the identifier
	 */
	public function findOneByGroupAndUser($group, $user) {
		return ($this->createQueryBuilder("gup")
			->innerJoin("ADHUserBundle:Group", "g", Join::WITH, "g.id = gup.group")
			->innerJoin("ADHUserBundle:User", "u", Join::WITH, "u.id = gup.user")
				->where("g.role = :group")
				->andWhere("u.pseudo = :user")
			->setMaxResults(1)
		->getQuery()
			->setParameters(array(
					"group" => $group,
					"user" => $user
			))
		->getOneOrNullResult());
	}
}