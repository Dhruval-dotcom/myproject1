<?php

namespace App\Repository;

use App\Entity\TableTwo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TableTwo>
 *
 * @method TableTwo|null find($id, $lockMode = null, $lockVersion = null)
 * @method TableTwo|null findOneBy(array $criteria, array $orderBy = null)
 * @method TableTwo[]    findAll()
 * @method TableTwo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TableTwoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TableTwo::class);
    }

    public function save(TableTwo $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TableTwo $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public static function createApprovedCriteria(): Criteria
    {
        return Criteria::create()
            ->andWhere(Criteria::expr()->eq('status', TableTwo::STATUS_APPROVED));
    }

    /**
     * @return TableTwo[]
     */
    public function findAllApproved(int $max = 10): array
    {
        return $this->createQueryBuilder('answer')
            ->addCriteria(self::createApprovedCriteria())
            ->setMaxResults($max)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return TableTwo[]
     */
    public function findMostPopular(string $search = null)
    {
        $queryBuilder = $this->createQueryBuilder('answer')
            ->addCriteria(self::createApprovedCriteria())
            ->orderBy('answer.votes', 'DESC')
            ->innerJoin('answer.question', 'question')
            ->addSelect('question');

        if($search){
            $queryBuilder->andWhere('answer.Description LIKE :searchTerm OR question.slug LIKE :searchTerm')
            ->setParameter('searchTerm', '%'.$search.'%');
        }

        return $queryBuilder
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return TableTwo[] Returns an array of TableTwo objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TableTwo
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
