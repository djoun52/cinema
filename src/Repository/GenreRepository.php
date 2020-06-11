<?php

namespace App\Repository;

use App\Entity\Genre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Genre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Genre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Genre[]    findAll()
 * @method Genre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GenreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Genre::class);
    }

    public function getAll()
    {
        $entityManager = $this->getEntityManager(); 
        //requete en DQL
        $querry = $entityManager->createQuery(
                'SELECT g
                    FROM app\Entity\Genre g
                    ORDER BY g.nomGenre DESC'
                );
        return $querry->execute();
    }
}
