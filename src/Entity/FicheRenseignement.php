<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FicheRenseignementRepository")
 */
class FicheRenseignement
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $autre_frais;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $objectif_visite;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $relation_participant_visite;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $derniere_visite;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $date_envoie_rapport;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\DossierVisite", inversedBy="fiches")
     * @ORM\JoinColumn(nullable=false)
     */
    private $dossierVisite;

    /**
     * @ORM\Column(type="integer")
     */
    private $cadreINS;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(string $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getAutreFrais(): ?string
    {
        return $this->autre_frais;
    }

    public function setAutreFrais(string $autre_frais): self
    {
        $this->autre_frais = $autre_frais;

        return $this;
    }

    public function getObjectifVisite(): ?string
    {
        return $this->objectif_visite;
    }

    public function setObjectifVisite(string $objectif_visite): self
    {
        $this->objectif_visite = $objectif_visite;

        return $this;
    }

    public function getRelationParticipantVisite(): ?string
    {
        return $this->relation_participant_visite;
    }

    public function setRelationParticipantVisite(string $relation_participant_visite): self
    {
        $this->relation_participant_visite = $relation_participant_visite;

        return $this;
    }

    public function getDerniereVisite(): ?string
    {
        return $this->derniere_visite;
    }

    public function setDerniereVisite(?string $derniere_visite): self
    {
        $this->derniere_visite = $derniere_visite;

        return $this;
    }

    public function getDateEnvoieRapport(): ?string
    {
        return $this->date_envoie_rapport;
    }

    public function setDateEnvoieRapport(?string $date_envoie_rapport): self
    {
        $this->date_envoie_rapport = $date_envoie_rapport;

        return $this;
    }

    public function getDossierVisite(): ?DossierVisite
    {
        return $this->dossierVisite;
    }

    public function setDossierVisite(?DossierVisite $dossierVisite): self
    {
        $this->dossierVisite = $dossierVisite;

        return $this;
    }

    public function getCadreINS(): ?int
    {
        return $this->cadreINS;
    }

    public function setCadreINS(int $cadreINS): self
    {
        $this->cadreINS = $cadreINS;

        return $this;
    }
}
