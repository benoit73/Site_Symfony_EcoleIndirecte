<?php

namespace App\Entity;

use App\Repository\EnseignantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EnseignantRepository::class)]
class Enseignant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom_enseignant = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom_enseignant = null;

    #[ORM\ManyToMany(targetEntity: Matiere::class, inversedBy: 'enseignants')]
    private Collection $matiere;

    #[ORM\OneToMany(targetEntity: EnseignantMatiereClasse::class, mappedBy: 'Enseignant', orphanRemoval: true)]
    private Collection $enseignantMatiereClasses;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    public function __construct()
    {
        $this->matiere = new ArrayCollection();
        $this->enseignantMatiereClasses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomEnseignant(): ?string
    {
        return $this->nom_enseignant;
    }

    public function setNomEnseignant(string $nom_enseignant): static
    {
        $this->nom_enseignant = $nom_enseignant;

        return $this;
    }

    public function getPrenomEnseignant(): ?string
    {
        return $this->prenom_enseignant;
    }

    public function setPrenomEnseignant(string $prenom_enseignant): static
    {
        $this->prenom_enseignant = $prenom_enseignant;

        return $this;
    }

    /**
     * @return Collection<int, matiere>
     */
    public function getMatiere(): Collection
    {
        return $this->matiere;
    }

    public function addMatiere(Matiere $matiere): static
    {
        if (!$this->matiere->contains($matiere)) {
            $this->matiere->add($matiere);
        }

        return $this;
    }

    public function removeMatiere(Matiere $matiere): static
    {
        $this->matiere->removeElement($matiere);

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
            $enseignantMatiereClass->setEnseignant($this);
        }

        return $this;
    }

    public function removeEnseignantMatiereClass(EnseignantMatiereClasse $enseignantMatiereClass): static
    {
        if ($this->enseignantMatiereClasses->removeElement($enseignantMatiereClass)) {
            // set the owning side to null (unless already changed)
            if ($enseignantMatiereClass->getEnseignant() === $this) {
                $enseignantMatiereClass->setEnseignant(null);
            }
        }

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }
}
