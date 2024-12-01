<?php

namespace App\Repository;

<<<<<<<< HEAD:src/Repository/LogementRepository.php
use App\Entity\Logement;
========
use App\Entity\Trajets;
>>>>>>>> 078208df31fa91b0fcde3cdba26950be8b44e7a4:src/Repository/TrajetsRepository.php
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**

 * @extends ServiceEntityRepository<Logement>
 */
class LogementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Logement::class);
    }

//    /**
//     * @return Logement[] Returns an array of Logement objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('l.id', 'ASC')

 * @extends ServiceEntityRepository<Trajets>
 */
class TrajetsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Trajets::class);
    }

//    /**
//     * @return Trajets[] Returns an array of Trajets objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
>>>>>>>> 078208df31fa91b0fcde3cdba26950be8b44e7a4:src/Repository/TrajetsRepository.php
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

<<<<<<<< HEAD:src/Repository/LogementRepository.php
//    public function findOneBySomeField($value): ?Logement
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
========
//    public function findOneBySomeField($value): ?Trajets
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
>>>>>>>> 078208df31fa91b0fcde3cdba26950be8b44e7a4:src/Repository/TrajetsRepository.php
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
