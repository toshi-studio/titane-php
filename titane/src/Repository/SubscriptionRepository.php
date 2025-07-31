<?php

namespace App\Repository;

use App\Entity\Subscription;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Subscription>
 */
class SubscriptionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Subscription::class);
    }

    /**
     * Find subscriptions by form slug
     */
    public function findByFormSlug(string $formSlug): array
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.formSlug = :formSlug')
            ->setParameter('formSlug', $formSlug)
            ->orderBy('s.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Count subscriptions by form
     */
    public function countByForm(int $formId): int
    {
        return $this->createQueryBuilder('s')
            ->select('COUNT(s.id)')
            ->andWhere('s.form = :formId')
            ->setParameter('formId', $formId)
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * Find subscriptions by project UID and form slug for API access
     * 
     * This method enables API endpoints to retrieve form submissions
     * using external identifiers for both project and form.
     * 
     * @param string $projectUid The project's unique identifier (UUID format)
     * @param string $formSlug The form's URL-friendly identifier
     * 
     * @return Subscription[] Array of subscriptions ordered by submission date (newest first)
     */
    public function findByProjectUidAndFormSlug(string $projectUid, string $formSlug): array
    {
        return $this->createQueryBuilder('s')
            ->innerJoin('s.form', 'f')
            ->innerJoin('f.project', 'proj')
            ->andWhere('proj.uid = :projectUid')
            ->andWhere('s.formSlug = :formSlug')
            ->setParameter('projectUid', $projectUid)
            ->setParameter('formSlug', $formSlug)
            ->orderBy('s.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
