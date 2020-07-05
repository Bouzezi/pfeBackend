<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass="App\Repository\DirectionCentraleRepository")
 */
class DirectionCentrale
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=10)
     * @Assert\NotBlank()
     */
    private $libelle_direction;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CadreINS", mappedBy="directionCentrale")
     */
    private $cadres;

    public function __construct()
    {
        $this->cadres = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleDirection(): ?string
    {
        return $this->libelle_direction;
    }

    public function setLibelleDirection(string $libelle_direction): self
    {
        $this->libelle_direction = $libelle_direction;

        return $this;
    }

    /**
     * @return Collection|CadreINS[]
     */
    public function getCadres(): Collection
    {
        return $this->cadres;
    }

    public function addCadre(CadreINS $cadre): self
    {
        if (!$this->cadres->contains($cadre)) {
            $this->cadres[] = $cadre;
            $cadre->setDirectionCentrale($this);
        }

        return $this;
    }

    public function removeCadre(CadreINS $cadre): self
    {
        if ($this->cadres->contains($cadre)) {
            $this->cadres->removeElement($cadre);
            // set the owning side to null (unless already changed)
            if ($cadre->getDirectionCentrale() === $this) {
                $cadre->setDirectionCentrale(null);
            }
        }

        return $this;
    }
}
