<?php

namespace App\Entity;

use App\Repository\OpportunityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OpportunityRepository::class)
 */
class Opportunity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $amount;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $date_due;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="opportunities")
     */
    private $assigned_to;

    /**
     * @ORM\ManyToOne(targetEntity=Account::class, inversedBy="opportunities")
     */
    private $account;

    /**
     * @ORM\ManyToOne(targetEntity=OpportunityStatus::class, inversedBy="opportunities")
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity=Lead::class, inversedBy="opportunities")
     * @ORM\JoinColumn(nullable=false)
     */
    private $lead;

    /**
     * @ORM\OneToMany(targetEntity=SalePhase::class, mappedBy="opportunity", orphanRemoval=true)
     */
    private $salesphase;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $probability;

    public function __construct()
    {
        $this->salesphase = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(?float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getDateDue(): ?\DateTimeInterface
    {
        return $this->date_due;
    }

    public function setDateDue(\DateTimeInterface $date_due): self
    {
        $this->date_due = $date_due;

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

    public function getStatus(): ?OpportunityStatus
    {
        return $this->status;
    }

    public function setStatus(?OpportunityStatus $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getLead(): ?Lead
    {
        return $this->lead;
    }

    public function setLead(?Lead $lead): self
    {
        $this->lead = $lead;

        return $this;
    }

    /**
     * @return Collection|SalePhase[]
     */
    public function getSalesphase(): Collection
    {
        return $this->salesphase;
    }

    public function addSalesphase(SalePhase $salesphase): self
    {
        if (!$this->salesphase->contains($salesphase)) {
            $this->salesphase[] = $salesphase;
            $salesphase->setOpportunity($this);
        }

        return $this;
    }

    public function removeSalesphase(SalePhase $salesphase): self
    {
        if ($this->salesphase->removeElement($salesphase)) {
            // set the owning side to null (unless already changed)
            if ($salesphase->getOpportunity() === $this) {
                $salesphase->setOpportunity(null);
            }
        }

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getProbability(): ?int
    {
        return $this->probability;
    }

    public function setProbability(?int $probability): self
    {
        $this->probability = $probability;

        return $this;
    }
}
