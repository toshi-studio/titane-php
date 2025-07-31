<?php

namespace App\Entity;

use App\Repository\UserProjectRoleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * UserProjectRole entity representing user roles within specific projects
 */
#[ORM\Entity(repositoryClass: UserProjectRoleRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_USER_PROJECT', columns: ['user_id', 'project_id'])]
#[ORM\HasLifecycleCallbacks]
class UserProjectRole
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::BIGINT, options: ['unsigned' => true])]
    private ?string $id = null;

    #[ORM\ManyToOne(inversedBy: 'projectRoles')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'userRoles')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Project $project = null;

    #[ORM\Column(length: 20)]
    private ?string $role = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\PrePersist]
    public function setCreatedAtValue(): void
    {
        $this->createdAt = new \DateTime();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;
        return $this;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): static
    {
        $this->project = $project;
        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    /**
     * Sets the user's role within the project with validation
     * 
     * This method enforces the three-tier role system defined in the security model:
     * - super_admin: Full system access across all projects
     * - admin: Can manage assigned projects and invite co-admins
     * - co_admin: Limited to content management within invited projects
     * 
     * @param string $role The role to assign (super_admin, admin, or co_admin)
     * 
     * @return static This instance for method chaining
     * 
     * @throws \InvalidArgumentException If the provided role is not one of the valid options
     */
    public function setRole(string $role): static
    {
        if (!in_array($role, ['super_admin', 'admin', 'co_admin'])) {
            throw new \InvalidArgumentException('Invalid role: ' . $role);
        }
        
        $this->role = $role;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;
        return $this;
    }
}