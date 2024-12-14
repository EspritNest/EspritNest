<?php

namespace App\Repository;

use App\Entity\AnnoncesColocation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AnnoncesColocation>
 */
class AnnoncesColocationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AnnoncesColocation::class);
    }

//    /**
//     * @return AnnoncesColocation[] Returns an array of AnnoncesColocation objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?AnnoncesColocation
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    /**
     * Find an AnnoncesColocation by its ID.
     *
     * @param int $id
     * @return AnnoncesColocation|null
     */
    public function findById(int $id): ?AnnoncesColocation
    {
        return $this->find($id);
    }
    public function searchByTitle(string $title): array
{
    return $this->createQueryBuilder('a')
        ->andWhere('a.titre LIKE :title')
        ->setParameter('title', '%' . $title . '%')
        ->getQuery()
        ->getResult();
}

    
    

public function searchByPrice(float $minPrice, float $maxPrice): array
{
    return $this->createQueryBuilder('a')
        ->andWhere('a.prix BETWEEN :minPrice AND :maxPrice')
        ->setParameter('minPrice', $minPrice)
        ->setParameter('maxPrice', $maxPrice)
        ->getQuery()
        ->getResult();
}

public function searchByRoomCount(int $minRooms): array
{
    return $this->createQueryBuilder('a')
        ->andWhere('a.nombreChambres >= :minRooms')
        ->setParameter('minRooms', $minRooms)
        ->getQuery()
        ->getResult();
}


public function searchByOwner(string $ownerName): array
{
    return $this->createQueryBuilder('a')
        ->join('a.proprietaire', 'u') // Assurez-vous que la relation avec l'entité Utilisateur est correcte
        ->andWhere('u.nom LIKE :ownerName')
        ->setParameter('ownerName', '%' . $ownerName . '%')
        ->getQuery()
        ->getResult();
}

public function searchByMultipleFields(string $query): array
{
    return $this->createQueryBuilder('a')
        ->leftJoin('a.proprietaire', 'u') // Jointure avec le propriétaire
        ->andWhere('a.titre LIKE :query OR a.description LIKE :query OR u.nom LIKE :query')
        ->setParameter('query', '%' . $query . '%')
        ->getQuery()
        ->getResult();
}



        /**
     * Find all games sorted by date.
     *
     * @return array The sorted array of games
     */
    public function findAllSortedByDate(string $order = 'ASC'): array
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.date_pub', $order)
            ->getQuery()
            ->getResult();
    }
    
    public function findAllSortedByPrice(string $order = 'ASC'): array
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.prix', $order)
            ->getQuery()
            ->getResult();
    }

    public function searchByTitleDescriptionOrPrice(?string $query, ?float $price): array
{
    $qb = $this->createQueryBuilder('a');

    // Ajout des conditions dynamiques
    if (!empty($query)) {
        $qb->andWhere('a.titre LIKE :query OR a.description LIKE :query')
           ->setParameter('query', '%' . $query . '%');
    }

    if (!empty($price)) {
        $qb->andWhere('a.prix = :price')
           ->setParameter('price', $price);
    }

    return $qb->getQuery()->getResult();
}
public function findByTitleOrDescription(string $searchQuery): array
{
    return $this->createQueryBuilder('a')
        ->where('a.titre LIKE :query')
        ->orWhere('a.description LIKE :query')
        ->setParameter('query', '%' . $searchQuery . '%')
        ->getQuery()
        ->getResult();
}


}
