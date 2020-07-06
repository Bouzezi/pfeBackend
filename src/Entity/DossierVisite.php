<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DossierVisiteRepository")
 */
class DossierVisite
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="id",type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     * @Assert\NotBlank()
     */
    private $date_arrive_invitation;

    /**
     * @ORM\Column(type="string", length=10)
     * @Assert\NotBlank()
     */
    private $date_debut;

    /**
     * @ORM\Column(type="string", length=10)
     *  @Assert\NotBlank()
     */
    private $date_fin;

    /**
     * @ORM\Column(type="string", length=10)
     * @Assert\NotBlank()
     */
    private $date_limite_reponce;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $sujet;

    /**
     * @ORM\Column(type="string", length=9)
     * @Assert\Choice({"mission", "formation"})
     */
    private $type_visite;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Positive
     */
    private $nbrParticipant_INS;

    /**
     * @ORM\Column(type="integer")
     * @Assert\PositiveOrZero
     */
    private $nbrParticipant_SP;

    /**
     * @ORM\Column(type="boolean")
     */
    private $frais_transport;

    /**
     * @ORM\Column(type="boolean")
     */
    private $frais_residence;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\Choice({"en-cours", "annuler", "finaliser"})
     */
    private $statut;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank()
     */
    private $nature;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $langues;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PaysDestination", inversedBy="dossiers")
     * @ORM\JoinColumn(nullable=true)
     */
    private $paysDestination;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\OrganismeEtranger", inversedBy="dossiers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $organismeEtranger;

    /**
     * @ORM\OneToMany(targetEntity="Participation", mappedBy="dossier")
     */
    private $participationDossier;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank()
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank()
     */
    private $direction;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $programme;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Note", mappedBy="dossierVisite", cascade={"remove"})
     */
    private $note;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\FicheRenseignement", mappedBy="dossierVisite")
     */
    private $fiches;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Bordereau", mappedBy="dossierVisite", cascade={"remove"})
     */
    private $bordereau;

    /**
     * @ORM\Column(type="string", length=10)
     * @Assert\NotBlank()
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     * @Assert\NotBlank()
     */
    private $date_envoi_documents;

    public function __construct()
    {
        $this->fiches = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateArriveInvitation(): ?string
    {
        return $this->date_arrive_invitation;
    }

    public function setDateArriveInvitation(string $date_arrive_invitation): self
    {
        $this->date_arrive_invitation = $date_arrive_invitation;

        return $this;
    }

    public function getDateDebut(): ?string
    {
        return $this->date_debut;
    }

    public function setDateDebut(string $date_debut): self
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    public function getDateFin(): ?string
    {
        return $this->date_fin;
    }

    public function setDateFin(string $date_fin): self
    {
        $this->date_fin = $date_fin;

        return $this;
    }

    public function getDateLimiteReponce(): ?string
    {
        return $this->date_limite_reponce;
    }

    public function setDateLimiteReponce(string $date_limite_reponce): self
    {
        $this->date_limite_reponce = $date_limite_reponce;

        return $this;
    }

    public function getSujet(): ?string
    {
        return $this->sujet;
    }

    public function setSujet(string $sujet): self
    {
        $this->sujet = $sujet;

        return $this;
    }

    public function getTypeVisite(): ?string
    {
        return $this->type_visite;
    }

    public function setTypeVisite(string $type_visite): self
    {
        $this->type_visite = $type_visite;

        return $this;
    }

    public function getNbrParticipantINS(): ?int
    {
        return $this->nbrParticipant_INS;
    }

    public function setNbrParticipantINS(int $nbrParticipant_INS): self
    {
        $this->nbrParticipant_INS = $nbrParticipant_INS;

        return $this;
    }

    public function getNbrParticipantSP(): ?int
    {
        return $this->nbrParticipant_SP;
    }

    public function setNbrParticipantSP(int $nbrParticipant_SP): self
    {
        $this->nbrParticipant_SP = $nbrParticipant_SP;

        return $this;
    }

    public function getFraisTransport(): ?bool
    {
        return $this->frais_transport;
    }

    public function setFraisTransport(bool $frais_transport): self
    {
        $this->frais_transport = $frais_transport;

        return $this;
    }

    public function getFraisResidence(): ?bool
    {
        return $this->frais_residence;
    }

    public function setFraisResidence(bool $frais_residence): self
    {
        $this->frais_residence = $frais_residence;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getNature(): ?string
    {
        return $this->nature;
    }

    public function setNature(string $nature): self
    {
        $this->nature = $nature;

        return $this;
    }

    public function getLangues(): ?string
    {
        return $this->langues;
    }

    public function setLangues(string $langues): self
    {
        $this->langues = $langues;

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

    public function getOrganismeEtranger(): ?OrganismeEtranger
    {
        return $this->organismeEtranger;
    }

    public function setOrganismeEtranger(?OrganismeEtranger $organismeEtranger): self
    {
        $this->organismeEtranger = $organismeEtranger;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getDirection(): ?string
    {
        return $this->direction;
    }

    public function setDirection(string $direction): self
    {
        $this->direction = $direction;

        return $this;
    }

    public function getProgramme(): ?string
    {
        return $this->programme;
    }

    public function setProgramme(string $programme): self
    {
        $this->programme = $programme;

        return $this;
    }

    public function getNote(): ?Note
    {
        return $this->note;
    }

    public function setNote(Note $note): self
    {
        $this->note = $note;

        return $this;
    }

    /**
     * @return Collection|FicheRenseignement[]
     */
    public function getFiches(): Collection
    {
        return $this->fiches;
    }

    public function addFich(FicheRenseignement $fich): self
    {
        if (!$this->fiches->contains($fich)) {
            $this->fiches[] = $fich;
            $fich->setDossierVisite($this);
        }

        return $this;
    }

    public function removeFich(FicheRenseignement $fich): self
    {
        if ($this->fiches->contains($fich)) {
            $this->fiches->removeElement($fich);
            // set the owning side to null (unless already changed)
            if ($fich->getDossierVisite() === $this) {
                $fich->setDossierVisite(null);
            }
        }

        return $this;
    }

    public function getBordereau(): ?Bordereau
    {
        return $this->bordereau;
    }

    public function setBordereau(Bordereau $bordereau): self
    {
        $this->bordereau = $bordereau;

        // set the owning side of the relation if necessary
        if ($bordereau->getDossierVisite() !== $this) {
            $bordereau->setDossierVisite($this);
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

    public function getDateEnvoiDocuments(): ?string
    {
        return $this->date_envoi_documents;
    }

    public function setDateEnvoiDocuments(?string $date_envoi_documents): self
    {
        $this->date_envoi_documents = $date_envoi_documents;

        return $this;
    }
  

}
