<?php

namespace App\Entity;

use App\Repository\ProjetRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjetRepository::class)]
class Projet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $idP = null;

    #[ORM\Column(length: 255)]
    private ?string $nomP = null;

    #[ORM\Column(length: 255)]
    private ?string $descriptionP = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateDebut = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateFin = null;

    #[ORM\Column(length: 255)]
    private ?string $statuts = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdP(): ?int
    {
        return $this->idP;
    }

    public function setIdP(int $idP): static
    {
        $this->idP = $idP;

        return $this;
    }

    public function getNomP(): ?string
    {
        return $this->nomP;
    }

    public function setNomP(string $nomP): static
    {
        $this->nomP = $nomP;

        return $this;
    }

    public function getDescriptionP(): ?string
    {
        return $this->descriptionP;
    }

    public function setDescriptionP(string $descriptionP): static
    {
        $this->descriptionP = $descriptionP;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): static
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): static
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getStatuts(): ?string
    {
        return $this->statuts;
    }

    public function setStatuts(string $statuts): static
    {
        $this->statuts = $statuts;

        return $this;
    }
}
