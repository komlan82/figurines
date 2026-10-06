<?php

namespace App\Repository;

use App\Entity\Figurine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Figurine>
 */
class FigurineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Figurine::class);
    }

    /**
     * Toutes les figurines (les plus récentes d'abord) avec leur auteur
     * chargé dans la même requête SQL (évite le problème N+1).
     *
     * @return Figurine[]
     */
    public function findAllWithUser(): array
    {
        return $this->createQueryBuilder('f')
            ->addSelect('u')
            ->join('f.user', 'u')
            ->orderBy('f.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
