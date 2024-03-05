<?php

namespace App\Repository;

use App\Entity\EnseignantMatiereClasse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EnseignantMatiereClasse>
 *
 * @method EnseignantMatiereClasse|null find($id, $lockMode = null, $lockVersion = null)
 * @method EnseignantMatiereClasse|null findOneBy(array $criteria, array $orderBy = null)
 * @method EnseignantMatiereClasse[]    findAll()
 * @method EnseignantMatiereClasse[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EnseignantMatiereClasseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EnseignantMatiereClasse::class);
    }

//    /**
//     * @return EnseignantMatiereClasse[] Returns an array of EnseignantMatiereClasse objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?EnseignantMatiereClasse
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
