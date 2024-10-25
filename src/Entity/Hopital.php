<?php

namespace App\Entity;

use App\Repository\HopitalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HopitalRepository::class)]
class Hopital
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $nom = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $dateFabrication = null;

    #[ORM\OneToMany(mappedBy: 'hopital', targetEntity: Medecin::class)]
    private Collection $medecins;

    public function __construct()
    {
        $this->medecins = new ArrayCollection();
    }

    // Getters and Setters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }

    public function getDateFabrication(): ?\DateTimeInterface
    {
        return $this->dateFabrication;
    }

    public function setDateFabrication(\DateTimeInterface $dateFabrication): self
    {
        $this->dateFabrication = $dateFabrication;
        return $this;
    }

    public function getMedecins(): Collection
    {
        return $this->medecins;
    }

    public function addMedecin(Medecin $medecin): self
    {
        if (!$this->medecins->contains($medecin)) {
            $this->medecins[] = $medecin;
            $medecin->setHopital($this);
        }

        return $this;
    }

    public function removeMedecin(Medecin $medecin): self
    {
        if ($this->medecins->removeElement($medecin)) {
            if ($medecin->getHopital() === $this) {
                $medecin->setHopital(null);
            }
        }

        return $this;
    }
}
