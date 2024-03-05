<?php

namespace App\Entity;

use App\Repository\ClasseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClasseRepository::class)]
class Classe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_classe = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $niveau = null;

    #[ORM\OneToMany(targetEntity: Cour::class, mappedBy: 'classe', orphanRemoval: true)]
    private Collection $cours;

    #[ORM\OneToMany(targetEntity: Eleve::class, mappedBy: 'classe')]
    private Collection $eleves;

    #[ORM\OneToMany(targetEntity: EnseignantMatiereClasse::class, mappedBy: 'Classe', orphanRemoval: true)]
    private Collection $enseignantMatiereClasses;

    #[ORM\Column(nullable: true)]
    private ?int $nb_eleves = null;

    public function __construct()
    {
        $this->cours = new ArrayCollection();
        $this->eleves = new ArrayCollection();
        $this->enseignantMatiereClasses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomClasse(): ?string
    {
        return $this->nom_classe;
    }

    public function setNomClasse(string $nom_classe): static
    {
        $this->nom_classe = $nom_classe;

        return $this;
    }

    public function getNiveau(): ?string
    {
        return $this->niveau;
    }

    public function setNiveau(?string $niveau): static
    {
        $this->niveau = $niveau;

        return $this;
    }

    /**
     * @return Collection<int, Eleve>
     */
    public function getEleves(): Collection
    {
        return $this->eleves;
    }

    public function addElefe(Eleve $elefe): static
    {
        if (!$this->eleves->contains($elefe)) {
            $this->eleves->add($elefe);
            $elefe->setClasse($this);
        }

        return $this;
    }

    public function removeElefe(Eleve $elefe): static
    {
        if ($this->eleves->removeElement($elefe)) {
            // set the owning side to null (unless already changed)
            if ($elefe->getClasse() === $this) {
                $elefe->setClasse(null);
            }
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
            $enseignantMatiereClass->setClasse($this);
        }

        return $this;
    }

    public function removeEnseignantMatiereClass(EnseignantMatiereClasse $enseignantMatiereClass): static
    {
        if ($this->enseignantMatiereClasses->removeElement($enseignantMatiereClass)) {
            // set the owning side to null (unless already changed)
            if ($enseignantMatiereClass->getClasse() === $this) {
                $enseignantMatiereClass->setClasse(null);
            }
        }

        return $this;
    }

    public function getNbEleves(): ?int
    {
        return $this->nb_eleves;
    }

    public function setNbEleves(?int $nb_eleves): static
    {
        $this->nb_eleves = $nb_eleves;

        return $this;
    }
}
