<?php

namespace App\Entity;

use App\Repository\DevisRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DevisRepository::class)
 */
class Devis
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="float")
     */
    private $prix;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="devis")
     */
    private $Utilisateur;

    /**
     * @ORM\OneToMany(targetEntity=Tailler::class, mappedBy="Devis")
     */
    private $taillers;

    public function __construct()
    {
        $this->taillers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getUtilisateur(): ?User
    {
        return $this->Utilisateur;
    }

    public function setUtilisateur(?User $Utilisateur): self
    {
        $this->Utilisateur = $Utilisateur;

        return $this;
    }

    /**
     * @return Collection|Tailler[]
     */
    public function getTaillers(): Collection
    {
        return $this->taillers;
    }

    public function addTailler(Tailler $tailler): self
    {
        if (!$this->taillers->contains($tailler)) {
            $this->taillers[] = $tailler;
            $tailler->setDevis($this);
        }

        return $this;
    }

    public function removeTailler(Tailler $tailler): self
    {
        if ($this->taillers->removeElement($tailler)) {
            // set the owning side to null (unless already changed)
            if ($tailler->getDevis() === $this) {
                $tailler->setDevis(null);
            }
        }

        return $this;
    }
}
