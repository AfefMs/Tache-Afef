<?php
// src/Entity/Cours.php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Cours
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 250)]
    private ?string $nomC = null;

    #[ORM\Column]
    private ?int $dureeC = null;

    #[ORM\Column(length: 255)]
    private ?int $periodeC = null;

    #[ORM\Column(length: 255)]
    private ?string $descriptionC = null;

    // Ajout de la relation OneToMany vers Ressource
    #[ORM\OneToMany(mappedBy: 'cours', targetEntity: Ressource::class, cascade: ['remove'])]
    private Collection $ressources;

    public function __construct()
    {
        $this->ressources = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomC(): ?string
    {
        return $this->nomC;
    }

    public function setNomC(string $nomC): static
    {
        $this->nomC = $nomC;
        return $this;
    }

    public function getDureeC(): ?int
    {
        return $this->dureeC;
    }

    public function setDureeC(int $dureeC): static
    {
        $this->dureeC = $dureeC;
        return $this;
    }

    public function getPeriodeC(): ?int
    {
        return $this->periodeC;
    }

    public function setPeriodeC(int $periodeC): static
    {
        $this->periodeC = $periodeC;
        return $this;
    }

    public function getDescriptionC(): ?string
    {
        return $this->descriptionC;
    }

    public function setDescriptionC(string $descriptionC): static
    {
        $this->descriptionC = $descriptionC;
        return $this;
    }

    // Getter et Setter pour les ressources
    public function getRessources(): Collection
    {
        return $this->ressources;
    }

    public function addRessource(Ressource $ressource): static
    {
        if (!$this->ressources->contains($ressource)) {
            $this->ressources[] = $ressource;
            $ressource->setCours($this);
        }

        return $this;
    }

    public function removeRessource(Ressource $ressource): static
    {
        if ($this->ressources->removeElement($ressource)) {
            if ($ressource->getCours() === $this) {
                $ressource->setCours(null);
            }
        }

        return $this;
    }
}
