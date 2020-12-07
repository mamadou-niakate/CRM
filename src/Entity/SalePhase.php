<?php

namespace App\Entity;

use App\Repository\SalePhaseRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SalePhaseRepository::class)
 */
class SalePhase
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $phase;

    /**
     * @ORM\ManyToOne(targetEntity=Opportunity::class, inversedBy="salesphase")
     * @ORM\JoinColumn(nullable=false)
     */
    private $opportunity;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPhase(): ?string
    {
        return $this->phase;
    }

    public function setPhase(string $phase): self
    {
        $this->phase = $phase;

        return $this;
    }

    public function getOpportunity(): ?Opportunity
    {
        return $this->opportunity;
    }

    public function setOpportunity(?Opportunity $opportunity): self
    {
        $this->opportunity = $opportunity;

        return $this;
    }
}
