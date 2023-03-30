<?php

namespace App\Repository;

use App\Entity\Desks;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Desks>
 *
 * @method Desks|null find($id, $lockMode = null, $lockVersion = null)
 * @method Desks|null findOneBy(array $criteria, array $orderBy = null)
 * @method Desks[]    findAll()
 * @method Desks[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DesksRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Desks::class);
    }

    public function save(Desks $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Desks $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getDeskWithFilter(array $data)
    {
        return $this->createQueryBuilder('d')
            ->select('d')
            ->where('d.city = :city')
            ->andWhere('d.numberPlaces >= :numberPlaces')
            ->andWhere('d.statusDesks = :statusDesk')
            ->setParameter('city', $data["city"])
            ->setParameter('numberPlaces', $data["nbPlaces"])
            ->setParameter('statusDesk', $data["statusDesk"])
            ->orderBy('d.price', 'ASC')
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return Desks[] Returns an array of Desks objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Desks
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
