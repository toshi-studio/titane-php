<?php

namespace App\Entity;

use App\Repository\FormFieldRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * FormField entity for dynamic form fields
 */
#[ORM\Entity(repositoryClass: FormFieldRepository::class)]
#[ORM\HasLifecycleCallbacks]
class FormField
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::BIGINT, options: ['unsigned' => true])]
    private ?string $id = null;

    #[ORM\ManyToOne(inversedBy: 'fields')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Form $form = null;

    #[ORM\Column(length: 50)]
    private ?string $fieldId = null;

    #[ORM\Column(length: 255)]
    private ?string $label = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column(length: 20)]
    private ?string $fieldType = null;

    #[ORM\Column(type: Types::INTEGER, options: ['unsigned' => true])]
    private ?int $fieldOrder = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $containerClass = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $labelClass = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $fieldClass = null;

    #[ORM\Column(type: Types::BOOLEAN)]
    private bool $isMandatory = false;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $defaultValue = null;

    #[ORM\Column(type: Types::JSON, nullable: true)]
    private ?array $options = null;

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

    public function getForm(): ?Form
    {
        return $this->form;
    }

    public function setForm(?Form $form): static
    {
        $this->form = $form;
        return $this;
    }

    public function getFieldId(): ?string
    {
        return $this->fieldId;
    }

    public function setFieldId(string $fieldId): static
    {
        $this->fieldId = $fieldId;
        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function getFieldType(): ?string
    {
        return $this->fieldType;
    }

    /**
     * Sets the form field type with validation against supported types
     * 
     * This method enforces the supported field types defined in the form system:
     * - text: Single-line text input for general text data
     * - email: Email input with built-in validation
     * - phone: Phone number input for contact information
     * - checkbox: Multiple choice selection (allows multiple values)
     * - radio: Single choice selection (allows one value)
     * 
     * @param string $fieldType The field type (text, email, phone, checkbox, or radio)
     * 
     * @return static This instance for method chaining
     * 
     * @throws \InvalidArgumentException If the provided field type is not supported
     */
    public function setFieldType(string $fieldType): static
    {
        if (!in_array($fieldType, ['text', 'email', 'phone', 'checkbox', 'radio'])) {
            throw new \InvalidArgumentException('Invalid field type: ' . $fieldType);
        }
        
        $this->fieldType = $fieldType;
        return $this;
    }

    public function getFieldOrder(): ?int
    {
        return $this->fieldOrder;
    }

    public function setFieldOrder(int $fieldOrder): static
    {
        $this->fieldOrder = $fieldOrder;
        return $this;
    }

    public function getContainerClass(): ?string
    {
        return $this->containerClass;
    }

    public function setContainerClass(?string $containerClass): static
    {
        $this->containerClass = $containerClass;
        return $this;
    }

    public function getLabelClass(): ?string
    {
        return $this->labelClass;
    }

    public function setLabelClass(?string $labelClass): static
    {
        $this->labelClass = $labelClass;
        return $this;
    }

    public function getFieldClass(): ?string
    {
        return $this->fieldClass;
    }

    public function setFieldClass(?string $fieldClass): static
    {
        $this->fieldClass = $fieldClass;
        return $this;
    }

    public function isMandatory(): bool
    {
        return $this->isMandatory;
    }

    public function setIsMandatory(bool $isMandatory): static
    {
        $this->isMandatory = $isMandatory;
        return $this;
    }

    public function getDefaultValue(): ?string
    {
        return $this->defaultValue;
    }

    public function setDefaultValue(?string $defaultValue): static
    {
        $this->defaultValue = $defaultValue;
        return $this;
    }

    public function getOptions(): ?array
    {
        return $this->options;
    }

    public function setOptions(?array $options): static
    {
        $this->options = $options;
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
