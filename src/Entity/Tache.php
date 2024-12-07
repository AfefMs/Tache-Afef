<?php

namespace App\Entity;

use App\Repository\TacheRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TacheRepository::class)]
class Tache
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $idT = null;

    #[ORM\Column(length: 255)]
    private ?string $nomT = null;

    #[ORM\Column(length: 255)]
    private ?string $descriptionT = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateDebut = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateFin = null;

    #[ORM\Column(length: 255)]
    private ?string $statusT = null;

    #[ORM\Column(length: 255)]
    private ?string $PrjetT = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdT(): ?int
    {
        return $this->idT;
    }

    public function setIdT(int $idT): static
    {
        $this->idT = $idT;

        return $this;
    }

    public function getNomT(): ?string
    {
        return $this->nomT;
    }

    public function setNomT(string $nomT): static
    {
        $this->nomT = $nomT;

        return $this;
    }

    public function getDescriptionT(): ?string
    {
        return $this->descriptionT;
    }

    public function setDescriptionT(string $descriptionT): static
    {
        $this->descriptionT = $descriptionT;

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

    public function getStatusT(): ?string
    {
        return $this->statusT;
    }

    public function setStatusT(string $statusT): static
    {
        $this->statusT = $statusT;

        return $this;
    }

    public function getPrjetT(): ?string
    {
        return $this->PrjetT;
    }

    public function setPrjetT(string $PrjetT): static
    {
        $this->PrjetT = $PrjetT;

        return $this;
    }
}
