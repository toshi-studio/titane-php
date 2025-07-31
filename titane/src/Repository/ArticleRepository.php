<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Article>
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    /**
     * Find published articles for a project
     */
    public function findPublishedByProject(int $projectId): array
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.project = :projectId')
            ->andWhere('a.status = :status')
            ->andWhere('a.isDeleted = :deleted')
            ->setParameter('projectId', $projectId)
            ->setParameter('status', 'published')
            ->setParameter('deleted', false)
            ->orderBy('a.publishedAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Find articles by tag
     */
    public function findByTag(int $tagId): array
    {
        return $this->createQueryBuilder('a')
            ->innerJoin('a.tags', 't')
            ->andWhere('t.id = :tagId')
            ->andWhere('a.status = :status')
            ->andWhere('a.isDeleted = :deleted')
            ->setParameter('tagId', $tagId)
            ->setParameter('status', 'published')
            ->setParameter('deleted', false)
            ->orderBy('a.publishedAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Find article by project and slug
     */
    public function findOneByProjectAndSlug(int $projectId, string $slug): ?Article
    {
        return $this->findOneBy([
            'project' => $projectId,
            'slug' => $slug,
            'isDeleted' => false
        ]);
    }

    /**
     * Find published articles for a project using project UID for API access
     * 
     * This method enables API endpoints to retrieve published articles
     * using the project's external UID identifier.
     * 
     * @param string $projectUid The project's unique identifier (UUID format)
     * 
     * @return Article[] Array of published articles ordered by publication date (newest first)
     */
    public function findPublishedByProjectUid(string $projectUid): array
    {
        return $this->createQueryBuilder('a')
            ->innerJoin('a.project', 'proj')
            ->andWhere('proj.uid = :projectUid')
            ->andWhere('a.status = :status')
            ->andWhere('a.isDeleted = :deleted')
            ->setParameter('projectUid', $projectUid)
            ->setParameter('status', 'published')
            ->setParameter('deleted', false)
            ->orderBy('a.publishedAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Find article by project UID and slug for API access
     * 
     * This is the primary method for API article retrieval, using external identifiers
     * that are safe to expose in URLs and API responses.
     * 
     * @param string $projectUid The project's unique identifier (UUID format)
     * @param string $slug The article's URL-friendly identifier
     * 
     * @return Article|null The article if found and not deleted, null otherwise
     */
    public function findOneByProjectUidAndSlug(string $projectUid, string $slug): ?Article
    {
        return $this->createQueryBuilder('a')
            ->innerJoin('a.project', 'proj')
            ->andWhere('proj.uid = :projectUid')
            ->andWhere('a.slug = :slug')
            ->andWhere('a.isDeleted = :deleted')
            ->setParameter('projectUid', $projectUid)
            ->setParameter('slug', $slug)
            ->setParameter('deleted', false)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Find articles by tag slug and project UID for API access
     * 
     * This method allows filtering published articles by tag using external identifiers,
     * essential for API endpoints that need to categorize content.
     * 
     * @param string $projectUid The project's unique identifier (UUID format)
     * @param string $tagSlug The tag's URL-friendly identifier
     * 
     * @return Article[] Array of published articles with the specified tag
     */
    public function findByProjectUidAndTagSlug(string $projectUid, string $tagSlug): array
    {
        return $this->createQueryBuilder('a')
            ->innerJoin('a.project', 'proj')
            ->innerJoin('a.tags', 't')
            ->andWhere('proj.uid = :projectUid')
            ->andWhere('t.slug = :tagSlug')
            ->andWhere('a.status = :status')
            ->andWhere('a.isDeleted = :deleted')
            ->setParameter('projectUid', $projectUid)
            ->setParameter('tagSlug', $tagSlug)
            ->setParameter('status', 'published')
            ->setParameter('deleted', false)
            ->orderBy('a.publishedAt', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
