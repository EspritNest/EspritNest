<?php

namespace App\Repository;

use App\Entity\Discussions;
use App\Entity\Utilisateur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Discussions>
 *
 * @method Discussions|null find($id, $lockMode = null, $lockVersion = null)
 * @method Discussions|null findOneBy(array $criteria, array $orderBy = null)
 * @method Discussions[]    findAll()
 * @method Discussions[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DiscussionsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Discussions::class);
    }

    /**
     * @return Discussions[] Returns an array of Discussions objects
     */
    public function findByParticipant(Utilisateur $user): array
    {
        return $this->createQueryBuilder('d')
            ->where('d.participant1 = :user')
            ->orWhere('d.participant2 = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    }
}
