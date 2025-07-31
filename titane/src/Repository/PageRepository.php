<?php

namespace App\Repository;

use App\Entity\Page;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Page>
 */
class PageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Page::class);
    }

    /**
     * Find published pages for a project
     */
    public function findPublishedByProject(int $projectId): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.project = :projectId')
            ->andWhere('p.status = :status')
            ->andWhere('p.isDeleted = :deleted')
            ->setParameter('projectId', $projectId)
            ->setParameter('status', 'published')
            ->setParameter('deleted', false)
            ->orderBy('p.publishedAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Find page by project and slug
     */
    public function findOneByProjectAndSlug(int $projectId, string $slug): ?Page
    {
        return $this->findOneBy([
            'project' => $projectId,
            'slug' => $slug,
            'isDeleted' => false
        ]);
    }

    /**
     * Find pages in trash
     */
    public function findDeletedByProject(int $projectId): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.project = :projectId')
            ->andWhere('p.isDeleted = :deleted')
            ->setParameter('projectId', $projectId)
            ->setParameter('deleted', true)
            ->orderBy('p.deletedAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Find published pages for a project using project UID for API access
     * 
     * This method enables API endpoints to retrieve published pages
     * using the project's external UID identifier.
     * 
     * @param string $projectUid The project's unique identifier (UUID format)
     * 
     * @return Page[] Array of published pages ordered by publication date (newest first)
     */
    public function findPublishedByProjectUid(string $projectUid): array
    {
        return $this->createQueryBuilder('p')
            ->innerJoin('p.project', 'proj')
            ->andWhere('proj.uid = :projectUid')
            ->andWhere('p.status = :status')
            ->andWhere('p.isDeleted = :deleted')
            ->setParameter('projectUid', $projectUid)
            ->setParameter('status', 'published')
            ->setParameter('deleted', false)
            ->orderBy('p.publishedAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Find page by project UID and slug for API access
     * 
     * This is the primary method for API page retrieval, using external identifiers
     * that are safe to expose in URLs and API responses.
     * 
     * @param string $projectUid The project's unique identifier (UUID format)
     * @param string $slug The page's URL-friendly identifier
     * 
     * @return Page|null The page if found and not deleted, null otherwise
     */
    public function findOneByProjectUidAndSlug(string $projectUid, string $slug): ?Page
    {
        return $this->createQueryBuilder('p')
            ->innerJoin('p.project', 'proj')
            ->andWhere('proj.uid = :projectUid')
            ->andWhere('p.slug = :slug')
            ->andWhere('p.isDeleted = :deleted')
            ->setParameter('projectUid', $projectUid)
            ->setParameter('slug', $slug)
            ->setParameter('deleted', false)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
