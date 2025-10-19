<?php
namespace App\Repository;
use App\Entity\Location;
use App\Entity\Measurement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
/**
 * @extends ServiceEntityRepository<Measurement>
 */
class MeasurementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Measurement::class);
    }
    public function findByLocation(Location $location)
    {
        $qb = $this->createQueryBuilder('m')->select('m');
        $qb->where('m.location = :location')
            ->setParameter('location', $location)
            ->andWhere('m.date > :now')
            ->setParameter('now', date('Y-m-d'));

        $query = $qb->getQuery();
        $result = $query->getResult();
        return $result;
    }
}
