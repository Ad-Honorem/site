<?php

namespace ADH\AlmanaxBundle\Repository;

use Doctrine\ORM\EntityRepository;
use ADH\AlmanaxBundle\Entity\Almanax;

class AlmanaxRepository extends EntityRepository {
	/**
	 * 
	 * @param \DateTime $date
	 * @return \ADH\AlmanaxBundle\Entity\Almanax
	 */
	public function getDay(\DateTime $date) {
		return ($this->createQueryBuilder("a")
				->where("a.date LIKE :date")
				->orderBy("a.date", "ASC")
			->setParameter(":date", $date->format("%-m-d"))
		->getQuery()
			->getOneOrNullResult());
	}
	
	/**
	 * 
	 * @return array:\ADH\AlmanaxBundle\Entity\Almanax
	 */
	public function getTodayAndTomorrow() {
		return ($this->createQueryBuilder("a")
				->where("a.date LIKE :date")
				->orwhere("a.date LIKE :tomorrow")
				->orderBy("a.date", "ASC")
			->setParameter(":date", (new \DateTime())->format("%-m-d"))
			->setParameter(":tomorrow", (new \DateTime("+1 day"))->format("%-m-d"))
		->getQuery()
			->execute());
	}
	
	/**
	 * 
	 * @param \DateTime $date
	 * @return array:\ADH\AlmanaxBundle\Entity\Almanax
	 */
	public function getMonth(\DateTime $date = null, $reset = true) {
		$date = $date ?: new \DateTime();
		$month = $date->format("m");
		
		return ($this->createQueryBuilder("a")
				->where("a.date LIKE :date")
				->orderBy("a.date", "ASC")
			->setParameter(":date", "%-" . $month . "-%")
		->getQuery()
			->execute());
	}
}