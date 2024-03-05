<?php

namespace App\Entity;

use App\Repository\MatiereRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MatiereRepository::class)]
class Matiere
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_matiere = null;

    #[ORM\ManyToMany(targetEntity: Enseignant::class, mappedBy: 'matiere')]
    private Collection $enseignants;

    #[ORM\OneToMany(targetEntity: EnseignantMatiereClasse::class, mappedBy: 'Matiere', orphanRemoval: true)]
    private Collection $enseignantMatiereClasses;

    #[ORM\Column(nullable: true)]
    private ?int $nbEnseignants = null;

    public function __construct()
    {
        $this->enseignants = new ArrayCollection();
        $this->enseignantMatiereClasses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomMatiere(): ?string
    {
        return $this->nom_matiere;
    }

    public function setNomMatiere(string $nom_matiere): static
    {
        $this->nom_matiere = $nom_matiere;

        return $this;
    }

    /**
     * @return Collection<int, Enseignant>
     */
    public function getEnseignants(): Collection
    {
        return $this->enseignants;
    }

    public function addEnseignant(Enseignant $enseignant): static
    {
        if (!$this->enseignants->contains($enseignant)) {
            $this->enseignants->add($enseignant);
            $enseignant->addMatiere($this);
        }

        return $this;
    }

    public function removeEnseignant(Enseignant $enseignant): static
    {
        if ($this->enseignants->removeElement($enseignant)) {
            $enseignant->removeMatiere($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, EnseignantMatiereClasse>
     */
    public function getEnseignantMatiereClasses(): Collection
    {
        return $this->enseignantMatiereClasses;
    }

    public function addEnseignantMatiereClass(EnseignantMatiereClasse $enseignantMatiereClass): static
    {
        if (!$this->enseignantMatiereClasses->contains($enseignantMatiereClass)) {
            $this->enseignantMatiereClasses->add($enseignantMatiereClass);
            $enseignantMatiereClass->setMatiere($this);
        }

        return $this;
    }

    public function removeEnseignantMatiereClass(EnseignantMatiereClasse $enseignantMatiereClass): static
    {
        if ($this->enseignantMatiereClasses->removeElement($enseignantMatiereClass)) {
            // set the owning side to null (unless already changed)
            if ($enseignantMatiereClass->getMatiere() === $this) {
                $enseignantMatiereClass->setMatiere(null);
            }
        }

        return $this;
    }

    public function getNbEnseignants(): ?int
    {
        return $this->nbEnseignants;
    }

    public function setNbEnseignants(?int $nbEnseignants): static
    {
        $this->nbEnseignants = $nbEnseignants;

        return $this;
    }

}
