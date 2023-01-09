<?php

namespace App\Repository;

use App\Entity\Conseil;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Conseil>
 *
 * @method Conseil|null find($id, $lockMode = null, $lockVersion = null)
 * @method Conseil|null findOneBy(array $criteria, array $orderBy = null)
 * @method Conseil[]    findAll()
 * @method Conseil[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConseilRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Conseil::class);
    }

    public function save(Conseil $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Conseil $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findAdvice(bool $temp_alerte_sup, bool $temp_alerte_inf, bool $hum_alerte_sup, bool $hum_alerte_inf, bool $co2_alerte_sup, bool $co2_alerte_inf, bool $temp_sup_outside, bool $no_data): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.temp_alerte_sup = :temp_alerte_sup')
            ->andWhere('c.temp_alerte_inf = :temp_alerte_inf')
            ->andWhere('c.hum_alerte_sup = :hum_alerte_sup')
            ->andWhere('c.hum_alerte_sup = :hum_alerte_inf')
            ->andWhere('c.co2_alerte_sup = :co2_alerte_sup')
            ->andWhere('c.co2_alerte_inf = :co2_alerte_inf')
            ->andWhere('c.temp_sup_outside = :temp_sup_outside')
            ->andWhere('c.no_data = :no_data')
            ->setParameter('temp_alerte_sup', $temp_alerte_sup)
            ->setParameter('temp_alerte_inf', $temp_alerte_inf)
            ->setParameter('hum_alerte_sup', $hum_alerte_sup)
            ->setParameter('hum_alerte_inf', $hum_alerte_inf)
            ->setParameter('co2_alerte_sup', $co2_alerte_sup)
            ->setParameter('co2_alerte_inf', $co2_alerte_inf)
            ->setParameter('temp_sup_outside', $temp_sup_outside)
            ->setParameter('no_data', $no_data)
            ->getQuery()
            ->getResult();


    }

//    /**
//     * @return Conseil[] Returns an array of Conseil objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Conseil
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
