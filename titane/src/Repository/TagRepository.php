<?php

namespace App\Repository;

use App\Entity\Tag;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Tag>
 */
class TagRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tag::class);
    }

    /**
     * Find root tags (no parent) for a project
     */
    public function findRootTagsByProject(int $projectId): array
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.project = :projectId')
            ->andWhere('t.parent IS NULL')
            ->setParameter('projectId', $projectId)
            ->orderBy('t.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Find tag by slug and project
     */
    public function findOneByProjectAndSlug(int $projectId, string $slug): ?Tag
    {
        return $this->findOneBy([
            'project' => $projectId,
            'slug' => $slug
        ]);
    }

    /**
     * Find root tags (no parent) for a project using project UID for API access
     * 
     * This method enables API endpoints to retrieve top-level tags
     * using the project's external UID identifier.
     * 
     * @param string $projectUid The project's unique identifier (UUID format)
     * 
     * @return Tag[] Array of root tags ordered by name
     */
    public function findRootTagsByProjectUid(string $projectUid): array
    {
        return $this->createQueryBuilder('t')
            ->innerJoin('t.project', 'proj')
            ->andWhere('proj.uid = :projectUid')
            ->andWhere('t.parent IS NULL')
            ->setParameter('projectUid', $projectUid)
            ->orderBy('t.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Find tag by project UID and slug for API access
     * 
     * This method allows API endpoints to retrieve specific tags
     * using external identifiers for both project and tag.
     * 
     * @param string $projectUid The project's unique identifier (UUID format)
     * @param string $slug The tag's URL-friendly identifier
     * 
     * @return Tag|null The tag if found, null otherwise
     */
    public function findOneByProjectUidAndSlug(string $projectUid, string $slug): ?Tag
    {
        return $this->createQueryBuilder('t')
            ->innerJoin('t.project', 'proj')
            ->andWhere('proj.uid = :projectUid')
            ->andWhere('t.slug = :slug')
            ->setParameter('projectUid', $projectUid)
            ->setParameter('slug', $slug)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
