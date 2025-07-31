<?php

namespace App\Repository;

use App\Entity\Media;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Media>
 */
class MediaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Media::class);
    }

    /**
     * Find media by project and file type
     */
    public function findByProjectAndType(int $projectId, string $fileType): array
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.project = :projectId')
            ->andWhere('m.fileType = :fileType')
            ->setParameter('projectId', $projectId)
            ->setParameter('fileType', $fileType)
            ->orderBy('m.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Find media by tag
     */
    public function findByTag(int $tagId): array
    {
        return $this->createQueryBuilder('m')
            ->innerJoin('m.tags', 't')
            ->andWhere('t.id = :tagId')
            ->setParameter('tagId', $tagId)
            ->orderBy('m.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Find media by project UID and file type for API access
     * 
     * This method enables API endpoints to retrieve media files filtered by type
     * using the project's external UID identifier.
     * 
     * @param string $projectUid The project's unique identifier (UUID format)
     * @param string $fileType The file extension to filter by (jpg, png, pdf, etc.)
     * 
     * @return Media[] Array of media files ordered by creation date (newest first)
     */
    public function findByProjectUidAndType(string $projectUid, string $fileType): array
    {
        return $this->createQueryBuilder('m')
            ->innerJoin('m.project', 'proj')
            ->andWhere('proj.uid = :projectUid')
            ->andWhere('m.fileType = :fileType')
            ->setParameter('projectUid', $projectUid)
            ->setParameter('fileType', $fileType)
            ->orderBy('m.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Find media by project UID and tag slug for API access
     * 
     * This method allows API endpoints to retrieve media files by tag
     * using external identifiers for both project and tag.
     * 
     * @param string $projectUid The project's unique identifier (UUID format)  
     * @param string $tagSlug The tag's URL-friendly identifier
     * 
     * @return Media[] Array of tagged media files ordered by creation date (newest first)
     */
    public function findByProjectUidAndTagSlug(string $projectUid, string $tagSlug): array
    {
        return $this->createQueryBuilder('m')
            ->innerJoin('m.project', 'proj')
            ->innerJoin('m.tags', 't')
            ->andWhere('proj.uid = :projectUid')
            ->andWhere('t.slug = :tagSlug')
            ->setParameter('projectUid', $projectUid)
            ->setParameter('tagSlug', $tagSlug)
            ->orderBy('m.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Find all media for a project using project UID for API access
     * 
     * This method enables API endpoints to retrieve all media files
     * for a project using the external UID identifier.
     * 
     * @param string $projectUid The project's unique identifier (UUID format)
     * 
     * @return Media[] Array of media files ordered by creation date (newest first)
     */
    public function findByProjectUid(string $projectUid): array
    {
        return $this->createQueryBuilder('m')
            ->innerJoin('m.project', 'proj')
            ->andWhere('proj.uid = :projectUid')
            ->setParameter('projectUid', $projectUid)
            ->orderBy('m.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
