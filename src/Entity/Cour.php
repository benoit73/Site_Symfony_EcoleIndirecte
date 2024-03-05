<?php

namespace App\Entity;

use App\Repository\CourRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CourRepository::class)]
class Cour
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $duree = null;

    #[ORM\Column]
    private ?int $jour = null;

    #[ORM\Column]
    private ?int $semaine = null;

    #[ORM\Column]
    private ?int $debut = null;

    #[ORM\Column]
    private ?int $annee = null;

    #[ORM\OneToMany(targetEntity: Absence::class, mappedBy: 'cour', orphanRemoval: true)]
    private Collection $absences;

    #[ORM\ManyToOne(inversedBy: 'cour')]
    #[ORM\JoinColumn(nullable: false)]
    private ?EnseignantMatiereClasse $enseignantMatiereClasse = null;


    public function __construct()
    {
        $this->absences = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(int $duree): static
    {
        $this->duree = $duree;

        return $this;
    }

    public function getJour(): ?int
    {
        return $this->jour;
    }

    public function setJour(int $jour): static
    {
        $this->jour = $jour;

        return $this;
    }

    public function getSemaine(): ?int
    {
        return $this->semaine;
    }

    public function setSemaine(int $semaine): static
    {
        $this->semaine = $semaine;

        return $this;
    }

    public function getDebut(): ?int
    {
        return $this->debut;
    }

    public function setDebut(int $debut): static
    {
        $this->debut = $debut;

        return $this;
    }

    public function getAnnee(): ?int
    {
        return $this->annee;
    }

    public function setAnnee(int $annee): static
    {
        $this->annee = $annee;

        return $this;
    }

    /**
     * @return Collection<int, Absence>
     */
    public function getAbsences(): Collection
    {
        return $this->absences;
    }

    public function addAbsence(Absence $absence): static
    {
        if (!$this->absences->contains($absence)) {
            $this->absences->add($absence);
            $absence->setCour($this);
        }

        return $this;
    }

    public function removeAbsence(Absence $absence): static
    {
        if ($this->absences->removeElement($absence)) {
            // set the owning side to null (unless already changed)
            if ($absence->getCour() === $this) {
                $absence->setCour(null);
            }
        }

        return $this;
    }

    public function getEnseignantMatiereClasse(): ?EnseignantMatiereClasse
    {
        return $this->enseignantMatiereClasse;
    }

    public function setEnseignantMatiereClasse(?EnseignantMatiereClasse $enseignantMatiereClasse): static
    {
        $this->enseignantMatiereClasse = $enseignantMatiereClasse;

        return $this;
    }

}
