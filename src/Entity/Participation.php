<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ParticipationRepository")
 */
class Participation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

     /**
     * @ORM\ManyToOne(targetEntity="DossierVisite",inversedBy="participationDossier")
     */
    private $dossier;

    /**
     * @ORM\ManyToOne(targetEntity="CadreINS",inversedBy="participationCadre")
     */
    private $cadre;

    /**
     * @ORM\Column(type="string", length=11)
     */
    private $annee;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDossier(): ?DossierVisite
    {
        return $this->dossier;
    }

    public function setDossier(DossierVisite $dossier): self
    {
        $this->dossier = $dossier;

        return $this;
    }

    public function getCadre(): ?CadreINS
    {
        return $this->cadre;
    }

    public function setCadre(?CadreINS $cadre): self
    {
        $this->cadre = $cadre;

        return $this;
    }

    public function getAnnee(): ?string
    {
        return $this->annee;
    }

    public function setAnnee(string $annee): self
    {
        $this->annee = $annee;

        return $this;
    }
}
