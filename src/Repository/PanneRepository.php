<?php

namespace App\Repository;

use App\Entity\Panne;
use App\Entity\Host;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception\RetryableException;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;
use PhpParser\Node\Stmt\Return_;
use Doctrine\DBAL\DriverManager;

/**
 * @method Panne|null find($id, $lockMode = null, $lockVersion = null)
 * @method Panne|null findOneBy(array $criteria, array $orderBy = null)
 * @method Panne[]    findAll()
 * @method Panne[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PanneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Panne::class);
    }
    
    public function findByHost($type)
    {
        $entityManager = $this->getEntityManager();
        
        $query = $entityManager->createQuery(
            'SELECT p
            FROM App\Entity\Panne p
            WHERE p.type => :
            ORDER BY p.id ASC'
            )->setParameter('type', $type);
        return $query->getResult();
        // returns an array of Product objects
        /*$conn = $this->getEntityManager()->getConnection();
        $sql = '
        select * from panne
        where panne.host_id=62
        ';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['host_id' => $host]);
        return $stmt;*/

    }
    

    /*
    public function findOneBySomeField($value): ?Panne
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function myFindByHosts($host)
    {
        $qb = $this->createQueryBuilder('panne')
           ->innerJoin ('panne.host','t')
           ->where('t.ip = :tip')
           ->setParameter('ip', $host)->getQuery()->getResult();
         /*
        $query = $qb->getQuery();
        $results = $query->getResult();
        return $results;*/
    }
}
