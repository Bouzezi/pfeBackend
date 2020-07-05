<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PaysDestinationRepository")
 */
class PaysDestination
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $libelle_pays;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\DossierVisite", mappedBy="paysDestination")
     */
    private $dossiers;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\VilleDestination", mappedBy="paysDestination")
     */
    private $villes;

    public function __construct()
    {
        $this->dossiers = new ArrayCollection();
        $this->villes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function setId(int $id): ?self
    {
        $this->id = $id;

        return $this;
    }
    public function getLibellePays(): ?string
    {
        return $this->libelle_pays;
    }

    public function setLibellePays(string $libelle_pays): self
    {
        $this->libelle_pays = $libelle_pays;

        return $this;
    }

    /**
     * @return Collection|DossierVisite[]
     */
    public function getDossiers(): Collection
    {
        return $this->dossiers;
    }

    public function addDossier(DossierVisite $dossier): self
    {
        if (!$this->dossiers->contains($dossier)) {
            $this->dossiers[] = $dossier;
            $dossier->setPaysDestination($this);
        }

        return $this;
    }

    public function removeDossier(DossierVisite $dossier): self
    {
        if ($this->dossiers->contains($dossier)) {
            $this->dossiers->removeElement($dossier);
            // set the owning side to null (unless already changed)
            if ($dossier->getPaysDestination() === $this) {
                $dossier->setPaysDestination(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|VilleDestination[]
     */
    public function getVilles(): Collection
    {
        return $this->villes;
    }

    public function addVille(VilleDestination $ville): self
    {
        if (!$this->villes->contains($ville)) {
            $this->villes[] = $ville;
            $ville->setPaysDestination($this);
        }

        return $this;
    }

    public function removeVille(VilleDestination $ville): self
    {
        if ($this->villes->contains($ville)) {
            $this->villes->removeElement($ville);
            // set the owning side to null (unless already changed)
            if ($ville->getPaysDestination() === $this) {
                $ville->setPaysDestination(null);
            }
        }

        return $this;
    }
}
