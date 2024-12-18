<?php
// src/Entity/Ressource.php

namespace App\Entity;

use App\Repository\RessourceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RessourceRepository::class)]
class Ressource
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $typeR = null;

    #[ORM\Column(length: 255)]
    private ?string $nomR = null;

    #[ORM\Column(length: 255)]
    private ?string $fileR = null;

    // Nouvelle propriété pour durée de la ressource
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $dureeR = null;

    // Propriété pour stocker le nom du fichier PDF
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $pdfressource = null;

    // Relation ManyToOne vers Cours
    #[ORM\ManyToOne(targetEntity: Cours::class, inversedBy: 'ressources')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Cours $cours = null;

    // Getters et Setters

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeR(): ?string
    {
        return $this->typeR;
    }

    public function setTypeR(string $typeR): self
    {
        $this->typeR = $typeR;
        return $this;
    }

    public function getNomR(): ?string
    {
        return $this->nomR;
    }

    public function setNomR(string $nomR): self
    {
        $this->nomR = $nomR;
        return $this;
    }

    public function getFileR(): ?string
    {
        return $this->fileR;
    }

    public function setFileR(string $fileR): self
    {
        $this->fileR = $fileR;
        return $this;
    }

    // Getter et Setter pour dureeR
    public function getDureeR(): ?string
    {
        return $this->dureeR;
    }

    public function setDureeR(?string $dureeR): self
    {
        $this->dureeR = $dureeR;
        return $this;
    }

    // Getter et Setter pour pdfressource
    public function getPdfressource(): ?string
    {
        return $this->pdfressource;
    }

    public function setPdfressource(?string $pdfressource): self
    {
        $this->pdfressource = $pdfressource;
        return $this;
    }

    // Getter et Setter pour cours
    public function getCours(): ?Cours
    {
        return $this->cours;
    }

    public function setCours(?Cours $cours): self
    {
        $this->cours = $cours;
        return $this;
    }
}
