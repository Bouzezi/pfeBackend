<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CadreINSRepository")
 */
class CadreINS
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="id",type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=15)
     * @Assert\NotBlank()
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=15)
     * @Assert\NotBlank()
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=20)
     * @Assert\NotBlank()
     */
    private $grade;

    /**
     * @ORM\Column(type="string", length=20)
     * @Assert\NotBlank()
     */
    private $fonction;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\DirectionCentrale", inversedBy="cadres")
     * @ORM\JoinColumn(nullable=false)
     */
    private $directionCentrale;

    /**
     * @ORM\OneToMany(targetEntity="Participation", mappedBy="cadre")
     */
    private $participationCadre;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Rapport", mappedBy="cadre")
     */
    private $rapports;

    public function __construct()
    {
        $this->rapports = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId()
    {
        $this->id = null;

        return $this;
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getGrade(): ?string
    {
        return $this->grade;
    }

    public function setGrade(string $grade): self
    {
        $this->grade = $grade;

        return $this;
    }

    public function getFonction(): ?string
    {
        return $this->fonction;
    }

    public function setFonction(string $fonction): self
    {
        $this->fonction = $fonction;

        return $this;
    }

    public function getDirectionCentrale(): ?DirectionCentrale
    {
        return $this->directionCentrale;
    }

    public function setDirectionCentrale(?DirectionCentrale $directionCentrale): self
    {
        $this->directionCentrale = $directionCentrale;

        return $this;
    }

    /**
     * @return Collection|Rapport[]
     */
    public function getRapports(): Collection
    {
        return $this->rapports;
    }

    public function addRapport(Rapport $rapport): self
    {
        if (!$this->rapports->contains($rapport)) {
            $this->rapports[] = $rapport;
            $rapport->setCadre($this);
        }

        return $this;
    }

    public function removeRapport(Rapport $rapport): self
    {
        if ($this->rapports->contains($rapport)) {
            $this->rapports->removeElement($rapport);
            // set the owning side to null (unless already changed)
            if ($rapport->getCadre() === $this) {
                $rapport->setCadre(null);
            }
        }

        return $this;
    }
    
}
