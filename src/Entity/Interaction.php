<?php

namespace App\Entity;

use App\Repository\InteractionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InteractionRepository::class)
 */
class Interaction
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $created_date;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date_due;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="interactions")
     */
    private $assigned_to;

    /**
     * @ORM\ManyToOne(targetEntity=Account::class, inversedBy="interactions")
     */
    private $account;

    /**
     * @ORM\ManyToOne(targetEntity=InteractionStatus::class, inversedBy="interactions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity=InteractionType::class, inversedBy="interactions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity=Contact::class, inversedBy="interactions")
     */
    private $contact;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedDate(): ?\DateTimeInterface
    {
        return $this->created_date;
    }

    public function setCreatedDate(?\DateTimeInterface $created_date): self
    {
        $this->created_date = $created_date;

        return $this;
    }

    public function getDateDue(): ?\DateTimeInterface
    {
        return $this->date_due;
    }

    public function setDateDue(?\DateTimeInterface $date_due): self
    {
        $this->date_due = $date_due;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getAssignedTo(): ?User
    {
        return $this->assigned_to;
    }

    public function setAssignedTo(?User $assigned_to): self
    {
        $this->assigned_to = $assigned_to;

        return $this;
    }

    public function getAccount(): ?Account
    {
        return $this->account;
    }

    public function setAccount(?Account $account): self
    {
        $this->account = $account;

        return $this;
    }

    public function getStatus(): ?InteractionStatus
    {
        return $this->status;
    }

    public function setStatus(?InteractionStatus $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getType(): ?InteractionType
    {
        return $this->type;
    }

    public function setType(?InteractionType $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getContact(): ?Contact
    {
        return $this->contact;
    }

    public function setContact(?Contact $contact): self
    {
        $this->contact = $contact;

        return $this;
    }
}
