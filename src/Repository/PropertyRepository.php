<?php

namespace App\Repository;

use App\Entity\Property;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Property|null find($id, $lockMode = null, $lockVersion = null)
 * @method Property|null findOneBy(array $criteria, array $orderBy = null)
 * @method Property[]    findAll()
 * @method Property[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Property::class);
    }
    
    /**
    * @return Property[] Returns an array of Property objects
    */
    public function findAllVisible(): array
    {
        return $this->findVisibleQuery()
                ->getQuery()
                ->getResult();
    }
    
    /**
    * @return Property[] Returns an array of Last Property objects
    */
    public function findLatest(): array
    {
        return $this->findVisibleQuery()
                ->setMaxResults(4)
                ->getQuery()
                ->getResult();
    }
    

    private function findVisibleQuery()
    {
        return $this->createQueryBuilder('p')
                ->where('p.sold = false');
    }
    
    
}
