<?php

namespace App\Entity;

use App\Repository\MedecinRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: MedecinRepository::class)]
class Medecin
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $nom = null;

    #[ORM\Column(type: 'date')]
    private ?\DateTimeInterface $dateNaissance = null;

    #[ORM\ManyToOne(targetEntity: Hopital::class, inversedBy: 'medecins')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Hopital $hopital = null;

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

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(\DateTimeInterface $dateNaissance): self
    {
        $this->dateNaissance = $dateNaissance;
        return $this;
    }

    public function getHopital(): ?Hopital
    {
        return $this->hopital;
    }

    public function setHopital(?Hopital $hopital): self
    {
        $this->hopital = $hopital;
        return $this;
    }

    public function removeHopital(Hopital $hopital): self
    {
        if ($this->hopitaux->removeElement($hopital)) {
            // set the owning side to null (unless already changed)
            if ($hopital->getMedecin() === $this) {
                $hopital->setMedecin(null);
            }
        }

        return $this;
    }
}
