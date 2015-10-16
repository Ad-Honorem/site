<?php

namespace ADH\UserBundle\Repository;

use Doctrine\ORM\EntityRepository;

class GroupRepository extends EntityRepository {

	/**
	 * Get all group with pagination
	 * 
	 * @param number $page
	 * @param number $size
	 * @return array
	 */
	public function findAllPaginate($page, $size) {
		return ($this->createQueryBuilder("g")
				->setFirstResult($page * $size)
				->setMaxResults($size)
			->getQuery()
			->getResult());
	}
	
	/**
	 * Count the number of group
	 * 
	 * @return number
	 */
	public function countAll() {
		return ($this->createQueryBuilder("g")
				->select("count(g.id)")
			->getQuery()
			->getSingleScalarResult());
	}
}