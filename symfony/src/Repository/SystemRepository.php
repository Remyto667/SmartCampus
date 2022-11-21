<?php

namespace App\Repository;

use App\Entity\System;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<System>
 *
 * @method System|null find($id, $lockMode = null, $lockVersion = null)
 * @method System|null findOneBy(array $criteria, array $orderBy = null)
 * @method System[]    findAll()
 * @method System[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SystemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, System::class);
    }

    public function save(System $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(System $entity, bool $flush = false)
    {
        //$query = $this->getEntityManager()->createQuery(

         //   );

        //$result = $query->getArrayResult();

        $conn = $this->getEntityManager()->getConnection();

        $sql = 'SELECT sys.id
            FROM system sys
            WHERE sys.id not in ( SELECT sen.systems_id
                                FROM sensor sen
                                GROUP BY sen.systems_id)';

        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery();
        $result = $resultSet->fetchAllAssociative();
        $ok = 0;
        foreach($result as $row)
        {
            if($entity->getId() == $row['id']) {
                $this->getEntityManager()->remove($entity);
                if ($flush) {
                    $this->getEntityManager()->flush();
                }
                $ok = 1;
            }
        }
        return $ok;

    }



//    /**
//     * @return System[] Returns an array of System objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?System
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
