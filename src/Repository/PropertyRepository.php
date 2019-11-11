<?php

namespace App\Repository;

use App\Entity\Property;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use App\Entity\PropertySearch;

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


    public function findAllVisibleQuery(PropertySearch $search)
    {
        $query = $this->findVisibleQuery();

        if ($search->getMaxPrice()) {
            $query = $query
          ->andWhere('p.price <= :maxprice')
          ->setParameter('maxprice', $search->getMaxPrice());
        }
        if ($search->getMinSurface()) {
            $query = $query
          ->andWhere('p.surface >= :minsurface')
          ->setParameter('minsurface', $search->getMinSurface());
        }
        if ($search->getOptions()->count() > 0) {
            $k = 0;
            foreach ($search->getOptions() as $option) {
                $k++;
                $query = $query
            ->andWhere(":option$k MEMBER OF p.options")
            ->setParameter("option$k", $option);
            }
        }

        return $query->getQuery();
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
