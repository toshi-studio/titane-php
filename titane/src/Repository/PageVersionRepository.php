<?php

namespace App\Repository;

use App\Entity\PageVersion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PageVersion>
 */
class PageVersionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PageVersion::class);
    }

    /**
     * Get the next version number for a page
     */
    public function getNextVersionNumber(int $pageId): int
    {
        $result = $this->createQueryBuilder('pv')
            ->select('MAX(pv.versionNumber) as maxVersion')
            ->andWhere('pv.page = :pageId')
            ->setParameter('pageId', $pageId)
            ->getQuery()
            ->getSingleScalarResult();
            
        return ($result ?? 0) + 1;
    }

    /**
     * Find versions for a page ordered by version number
     */
    public function findByPageOrdered(int $pageId): array
    {
        return $this->createQueryBuilder('pv')
            ->andWhere('pv.page = :pageId')
            ->setParameter('pageId', $pageId)
            ->orderBy('pv.versionNumber', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
