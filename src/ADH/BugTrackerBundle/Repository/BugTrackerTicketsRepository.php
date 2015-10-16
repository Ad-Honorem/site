<?php

namespace ADH\BugTrackerBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Expr\Expression;
use Doctrine\ORM\Query\Expr;
use Doctrine\Common\Collections\ExpressionBuilder;

class BugTrackerTicketsRepository extends EntityRepository {
	/**
	 * Get the ticket by id and token
	 * 
	 * @param bigint $id
	 * @param string $token
	 * @return \Doctrine\ORM\mixed
	 */
	public function findOneByIdAndToken($id, $token = null) {
		return ($this->createQueryBuilder("btt")
				->where("btt.id = :id")
				->andWhere("(btt.public = true OR btt.token = :token)")
			->getQuery()
			->setParameter("id", $id)
			->setParameter("token", $token)
			->getOneOrNullResult());
	}
}
