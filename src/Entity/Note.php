<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NoteRepository")
 */
class Note
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $piece_jointe;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\DossierVisite",inversedBy="note")
     */
    private $dossierVisite;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $date;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPieceJointe(): ?string
    {
        return $this->piece_jointe;
    }

    public function setPieceJointe(string $piece_jointe): self
    {
        $this->piece_jointe = $piece_jointe;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDossierVisite(): ?DossierVisite
    {
        return $this->dossierVisite;
    }

    public function setDossierVisite(DossierVisite $dossierVisite): self
    {
        $this->dossierVisite = $dossierVisite;

        // set the owning side of the relation if necessary
        if ($dossierVisite->getNote() !== $this) {
            $dossierVisite->setNote($this);
        }

        return $this;
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

}
