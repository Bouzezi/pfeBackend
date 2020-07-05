<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VilleDestinationRepository")
 */
class VilleDestination
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
    private $libelle_ville;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PaysDestination", inversedBy="villes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $paysDestination;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleVille(): ?string
    {
        return $this->libelle_ville;
    }

    public function setLibelleVille(string $libelle_ville): self
    {
        $this->libelle_ville = $libelle_ville;

        return $this;
    }

    public function getPaysDestination(): ?PaysDestination
    {
        return $this->paysDestination;
    }

    public function setPaysDestination(?PaysDestination $paysDestination): self
    {
        $this->paysDestination = $paysDestination;

        return $this;
    }
}
