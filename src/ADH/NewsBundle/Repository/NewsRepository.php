<?php

namespace ADH\NewsBundle\Repository;

use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\ORM\EntityRepository;

class NewsRepository extends EntityRepository {

	public function findByPage($page, $byPage = 3, $category = null, $writter = false) {
		$qb = $this->createQueryBuilder("n");
		
		if($writter == false) {
			$qb
				->andWhere("n.etat = 3")
				->addOrderBy("n.publicationdate", "DESC");
		} else {
			$qb
				->andWhere("n.etat = 3 or n.etat = 2 or n.etat = 1 or ((n.etat = 0 or n.etat = 4) and n.auteur =:writter)")
				->setParameter(":writter", $writter)
				->addOrderBy("n.creationdate", "DESC");
		}
		if ($category != null) {
			$qb
				->andWhere("n.category = :category")
				->setParameter(":category", $category);
		}
		
		$qb
			->setFirstResult(($page - 1) * $byPage)
			->setMaxResults($byPage);
		return (new Paginator($qb->getQuery()));
	}
}

