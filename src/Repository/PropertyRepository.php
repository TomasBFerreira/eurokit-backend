<?php

namespace App\Repository;

use App\Entity\Property;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

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

    // /**
    //  * @return Property[] Returns an array of Property objects
    //  */
    
    public function findWithModel(string $id): ?Property
    {
        $alias = 'p';
        $qb = $this->createQueryBuilder($alias);
        
        $query = $qb
                ->where('p.id = :id')
                ->join('p.model', 'm')
                ->getQuery();
        
        $query->setParameter('id', $id);
        $result = $query->getResult();
        
        return $result[0] ?? null;        
    }
    
    public function findAllWithModels(): array
    {
        $alias = 'p';
        $qb = $this->createQueryBuilder($alias);
        
        $query = $qb
                ->join('p.model', 'm')
                ->getQuery();
        
        $result = $query->getResult();
        
        return $result;        
    }
    
      public function findWithManyProducts(string $id): array
    {
        $alias = 'p';
        $qb = $this->createQueryBuilder($alias);
        
        $query = $qb
                ->where('p.model = :id')
                ->join('p.property', 'p')
                ->getQuery();
        
        $query->setParameter('id', $id);
        $result = $query->getResult();
        
        return $result;        
    }
}

