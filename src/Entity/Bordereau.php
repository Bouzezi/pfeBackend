<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BordereauRepository")
 */
class Bordereau
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $numero_de_rang;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbr_documents;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $date_bordereau;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $commentaires;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $date_documents;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\DossierVisite", inversedBy="bordereau")
     */
    private $dossierVisite;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroDeRang(): ?int
    {
        return $this->numero_de_rang;
    }

    public function setNumeroDeRang(?int $numero_de_rang): self
    {
        $this->numero_de_rang = $numero_de_rang;

        return $this;
    }

    public function getNbrDocuments(): ?int
    {
        return $this->nbr_documents;
    }

    public function setNbrDocuments(int $nbr_documents): self
    {
        $this->nbr_documents = $nbr_documents;

        return $this;
    }

    public function getDateBordereau(): ?string
    {
        return $this->date_bordereau;
    }

    public function setDateBordereau(string $date_bordereau): self
    {
        $this->date_bordereau = $date_bordereau;

        return $this;
    }

    public function getCommentaires(): ?string
    {
        return $this->commentaires;
    }

    public function setCommentaires(?string $commentaires): self
    {
        $this->commentaires = $commentaires;

        return $this;
    }

    public function getDateDocuments(): ?string
    {
        return $this->date_documents;
    }

    public function setDateDocuments(?string $date_documents): self
    {
        $this->date_documents = $date_documents;

        return $this;
    }

    public function getDossierVisite(): ?DossierVisite
    {
        return $this->dossierVisite;
    }

    public function setDossierVisite(DossierVisite $dossierVisite): self
    {
        $this->dossierVisite = $dossierVisite;

        return $this;
    }
}
