<?php

namespace ADH\UserBundle\Repository;

use Doctrine\ORM\EntityRepository;
use ADH\UserBundle\Entity\Group;

class GroupHierarchyRequestRepository extends EntityRepository {

	/**
	 * Get all group with pagination
	 * 
	 * @param number $page
	 * @param number $size
	 * @return array
	 */
	public function findAllPaginateFor(Group $group, $page, $size) {
		return ($this->createQueryBuilder("ghr")
				->where("(ghr.parent = :group AND ghr.parent_agreement IS NULL AND ghr.parent_denied IS NULL)")
				->orWhere("(ghr.child = :group AND ghr.child_agreement IS NULL AND ghr.child_denied IS NULL)")
				->setFirstResult($page * $size)
				->setMaxResults($size)
			->getQuery()
			->setParameter("group", $group)
			->getResult());
	}
	
	/**
	 * Get all group with pagination
	 *
	 * @param number $page
	 * @param number $size
	 * @return array
	 */
	public function findAllPaginateFrom(Group $group, $page, $size) {
		return ($this->createQueryBuilder("ghr")
				->where("(ghr.parent = :group AND ghr.parent_agreement IS NOT NULL AND ghr.child_agreement IS NULL)")
				->orWhere("(ghr.child = :group AND ghr.child_agreement IS NOT NULL AND ghr.parent_agreement IS NULL)")
				->setFirstResult($page * $size)
				->setMaxResults($size)
			->getQuery()
			->setParameter("group", $group)
			->getResult());
	}
}