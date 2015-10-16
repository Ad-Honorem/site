<?php

namespace ADH\BetBundle\Repository;

use ADH\BetBundle\Entity\Match;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use ADH\BetBundle\Entity\Equipe;

class MatchRepository extends EntityRepository {

	public function aVenir($type, $min, $max) {
		$qb = $this->createQueryBuilder('m')
                        ->andWhere("m.ladate > :today")
                        ->setParameter(':today', new \DateTime())
                        ->addOrderBy("m.ladate", "ASC");
                if($max != -1){
                    $qb->setMaxResults(5);
                }
		return ($qb->getQuery()->getResult());
	}

	public function passes($type, $min, $max) {
		$qb = $this->createQueryBuilder('m')->andWhere("m.ladate < :today")->setParameter(':today', new \DateTime())->addOrderBy("m.ladate", "DESC");
                if($type == "poule"){
                    $qb->andWhere("m.type = 'poule'");
                }
                if($max != -1){
                    $qb->setMaxResults(5);
                }
		return ($qb->getQuery()->getResult());
	}
        
        public function findByTeam(Equipe $equipe){
            $qb = $this->createQueryBuilder('m')->andWhere("m.equipeA = :a or m.equipeB =:a")->setParameter(':a', $equipe)->addOrderBy("m.ladate", "DESC");
            return ($qb->getQuery()->getResult());
        }
        
}