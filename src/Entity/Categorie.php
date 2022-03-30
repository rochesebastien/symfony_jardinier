<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategorieRepository::class)
 */
class Categorie
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
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity=Haie::class, mappedBy="categorie")
     */
    private $haies;

    public function __construct()
    {
        $this->haies = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->libelle;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection|Haie[]
     */
    public function getHaies(): Collection
    {
        return $this->haies;
    }

    public function addHaie(Haie $haie): self
    {
        if (!$this->haies->contains($haie)) {
            $this->haies[] = $haie;
            $haie->setCategorie($this);
        }

        return $this;
    }

    public function removeHaie(Haie $haie): self
    {
        if ($this->haies->removeElement($haie)) {
            // set the owning side to null (unless already changed)
            if ($haie->getCategorie() === $this) {
                $haie->setCategorie(null);
            }
        }

        return $this;
    }
}
