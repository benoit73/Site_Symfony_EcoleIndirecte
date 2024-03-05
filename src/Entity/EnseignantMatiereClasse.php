<?php

namespace App\Entity;

use App\Repository\EnseignantMatiereClasseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EnseignantMatiereClasseRepository::class)]
class EnseignantMatiereClasse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'enseignantMatiereClasses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?enseignant $Enseignant = null;

    #[ORM\ManyToOne(inversedBy: 'enseignantMatiereClasses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?matiere $Matiere = null;

    #[ORM\ManyToOne(inversedBy: 'enseignantMatiereClasses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?classe $Classe = null;

    #[ORM\OneToMany(targetEntity: cour::class, mappedBy: 'enseignantMatiereClasse', orphanRemoval: true)]
    private Collection $cour;

    #[ORM\OneToMany(targetEntity: Cour::class, mappedBy: 'enseignant_matiere_classe', orphanRemoval: true)]
    private Collection $cours;

    public function __construct()
    {
        $this->cour = new ArrayCollection();
        $this->cours = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEnseignant(): ?enseignant
    {
        return $this->Enseignant;
    }

    public function setEnseignant(?enseignant $Enseignant): static
    {
        $this->Enseignant = $Enseignant;

        return $this;
    }

    public function getMatiere(): ?matiere
    {
        return $this->Matiere;
    }

    public function setMatiere(?matiere $Matiere): static
    {
        $this->Matiere = $Matiere;

        return $this;
    }

    public function getClasse(): ?classe
    {
        return $this->Classe;
    }

    public function setClasse(?classe $Classe): static
    {
        $this->Classe = $Classe;

        return $this;
    }

    /**
     * @return Collection<int, cour>
     */
    public function getCour(): Collection
    {
        return $this->cour;
    }

    public function addCour(cour $cour): static
    {
        if (!$this->cour->contains($cour)) {
            $this->cour->add($cour);
            $cour->setEnseignantMatiereClasse($this);
        }

        return $this;
    }

    public function removeCour(cour $cour): static
    {
        if ($this->cour->removeElement($cour)) {
            // set the owning side to null (unless already changed)
            if ($cour->getEnseignantMatiereClasse() === $this) {
                $cour->setEnseignantMatiereClasse(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Cour>
     */
    public function getCours(): Collection
    {
        return $this->cours;
    }
}
