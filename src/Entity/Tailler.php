<?php

namespace App\Entity;

use App\Repository\TaillerRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TaillerRepository::class)
 */
class Tailler
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $longueur;

    /**
     * @ORM\Column(type="integer")
     */
    private $hauteur;

    /**
     * @ORM\ManyToOne(targetEntity=Haie::class, inversedBy="taillers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $haie;

    /**
     * @ORM\ManyToOne(targetEntity=Devis::class, inversedBy="taillers")
     */
    private $Devis;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLongueur(): ?float
    {
        return $this->longueur;
    }

    public function setLongueur(float $longueur): self
    {
        $this->longueur = $longueur;

        return $this;
    }

    public function getHauteur(): ?float
    {
        return $this->hauteur;
    }

    public function setHauteur(float $hauteur): self
    {
        $this->hauteur = $hauteur;

        return $this;
    }

    public function getHaie(): ?Haie
    {
        return $this->haie;
    }

    public function setHaie(?Haie $haie): self
    {
        $this->haie = $haie;

        return $this;
    }

    public function getDevis(): ?Devis
    {
        return $this->Devis;
    }

    public function setDevis(?Devis $Devis): self
    {
        $this->Devis = $Devis;

        return $this;
    }
}
