<?php

namespace OC\PlatformBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;

class AdvertSkillRepository extends EntityRepository
{
	public function findOldAdverts($days){

		$currentDay = new \Datetime();
		$query = $this->createQueryBuilder('a')
        ->leftJoin('a.advert', 'b')
        ->addSelect('b')
        ->where('b.date > :days')
        ->andWhere('b.applications IS EMPTY')
	    ->setParameter('days', $currentDay->sub(new \DateInterval('P'.$days.'D')))
        ->getQuery();

	    return $query->getResult();
	  }
}