<?php

namespace App\Repository;

use App\Entity\ArticleVersion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ArticleVersion>
 */
class ArticleVersionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ArticleVersion::class);
    }

    /**
     * Get the next version number for an article
     */
    public function getNextVersionNumber(int $articleId): int
    {
        $result = $this->createQueryBuilder('av')
            ->select('MAX(av.versionNumber) as maxVersion')
            ->andWhere('av.article = :articleId')
            ->setParameter('articleId', $articleId)
            ->getQuery()
            ->getSingleScalarResult();
            
        return ($result ?? 0) + 1;
    }

    /**
     * Find versions for an article ordered by version number
     */
    public function findByArticleOrdered(int $articleId): array
    {
        return $this->createQueryBuilder('av')
            ->andWhere('av.article = :articleId')
            ->setParameter('articleId', $articleId)
            ->orderBy('av.versionNumber', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
