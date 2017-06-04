<?php

namespace OC\PlatformBundle\Repository;

/**
 * AdvertRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AdvertRepository extends \Doctrine\ORM\EntityRepository
{
	public function myFindAll()
	{
		return $this
		->createQueryBuilder('a')
		->getQuery()
		->getResult();
	}

	public function myFind($id){
		return $this
		->createQueryBuilder('a')
		->where('a.id = :id')
		->setParameter(":id",$id)
		->getQuery()
		->getResult();
	}

	public function findByAuthorAndDate($author,$date){
		$db = $this->createQueryBuilder('a')
		->where('a.author = :author')
		->setParameter(":author",$author);

		$this->whereCurrentYear($db);

		$db->orderBy("a.date","DESC");

		return $db->getQuery()->getResult();
	}

	public function whereCurrentYear(QueryBuilder $qb){
		$qb->andWhere("a.date BETWEEN :start AND :end")
		->setParameter(":start", new \DateTime(date('Y').'-01-01'))
		->setParameter(":end", new \DateTime(date('Y').'-12-31'));
	}

	public function getAllAdvertWithApplications(){
		return $this
		->createQueryBuilder('a')
		->leftJoin('a.applications','app')
		->addSelect('app')
		->getQuery()
		->getResult();
	}

	public function getAllAdvertWithCategories(array $listCategories){
		return $this
		->createQueryBuilder('a')
		->leftJoin('a.categories','c')
		->addSelect('c')
		->where($qb->expr()->in('c.name', $listCategories))
		->getQuery()
		->getResult();
	}
}
