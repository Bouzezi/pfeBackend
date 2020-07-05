<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProgrammeCooperationRepository")
 */
class ProgrammeCooperation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(name="id", type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle_prog;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleProg(): ?string
    {
        return $this->libelle_prog;
    }

    public function setLibelleProg(string $libelle_prog): self
    {
        $this->libelle_prog = $libelle_prog;

        return $this;
    }
}
