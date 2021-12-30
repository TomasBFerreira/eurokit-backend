<?php

namespace App\Repository;

use App\Entity\Model;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Model|null find($id, $lockMode = null, $lockVersion = null)
 * @method Model|null findOneBy(array $criteria, array $orderBy = null)
 * @method Model[]    findAll()
 * @method Model[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ModelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Model::class);
    }
    /* @return Model[] Returns an array of Model objects
    //  */
    
   public function findWithProduct(string $id): ?Model
    {
        $alias = 'm';
        $qb = $this->createQueryBuilder($alias);
        
        $query = $qb
                ->where('m.id = :id')
                ->join('m.product', 'p')
                ->getQuery();
        
        $query->setParameter('id', $id);
        $result = $query->getResult();
        
        return $result[0] ?? null;        
    }
    
    public function findAllWithProducts(): array
    {
        $alias = 'm';
        $qb = $this->createQueryBuilder($alias);
        
        $query = $qb
                ->join('m.product', 'p')
                ->getQuery();
        
        $result = $query->getResult();
        
        return $result;        
    }
    
       public function findWithManyProducts(string $id): array
    {
        $alias = 'm';
        $qb = $this->createQueryBuilder($alias);
        
        $query = $qb
                ->where('m.product = :id')
                //->from('m.properties', 'pr')
                ->getQuery();
        
        $query->setParameter('id', $id);
        $result = $query->getResult();
        
        return $result;        
    }
}
