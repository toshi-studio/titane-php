<?php

namespace App\Repository;

use App\Entity\Form;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Form>
 */
class FormRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Form::class);
    }

    /**
     * Find form by project and slug
     */
    public function findOneByProjectAndSlug(int $projectId, string $slug): ?Form
    {
        return $this->findOneBy([
            'project' => $projectId,
            'slug' => $slug
        ]);
    }

    /**
     * Find forms by project
     */
    public function findByProject(int $projectId): array
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.project = :projectId')
            ->setParameter('projectId', $projectId)
            ->orderBy('f.internalName', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Find form by project UID and slug for API access
     * 
     * This is the primary method for API form retrieval, enabling external systems
     * to access form definitions and render them using external identifiers.
     * 
     * @param string $projectUid The project's unique identifier (UUID format)
     * @param string $slug The form's URL-friendly identifier
     * 
     * @return Form|null The form if found, null otherwise
     */
    public function findOneByProjectUidAndSlug(string $projectUid, string $slug): ?Form
    {
        return $this->createQueryBuilder('f')
            ->innerJoin('f.project', 'proj')
            ->andWhere('proj.uid = :projectUid')
            ->andWhere('f.slug = :slug')
            ->setParameter('projectUid', $projectUid)
            ->setParameter('slug', $slug)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Find forms by project UID for API access
     * 
     * This method allows API endpoints to retrieve all forms for a project
     * using the project's external UID identifier.
     * 
     * @param string $projectUid The project's unique identifier (UUID format)
     * 
     * @return Form[] Array of forms ordered by internal name
     */
    public function findByProjectUid(string $projectUid): array
    {
        return $this->createQueryBuilder('f')
            ->innerJoin('f.project', 'proj')
            ->andWhere('proj.uid = :projectUid')
            ->setParameter('projectUid', $projectUid)
            ->orderBy('f.internalName', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
