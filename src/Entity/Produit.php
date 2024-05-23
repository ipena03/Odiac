<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 10)]
    private ?string $taille = null;

    #[ORM\Column(length: 255)]
    private ?string $quantite = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateEnvoi = null;

    #[ORM\Column]
    private ?float $prix = null;


    #[ORM\Column]
    private ?string $description = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'aimer')]
    private Collection $users;

    /**
     * @var Collection<int, Inserer>
     */
    #[ORM\OneToMany(targetEntity: Inserer::class, mappedBy: 'produit')]
    private Collection $inserers;

    public function __construct()
    {
        $this->aimers = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->inserers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getTaille(): ?string
    {
        return $this->taille;
    }

    public function setTaille(string $taille): static
    {
        $this->taille = $taille;

        return $this;
    }

    public function getQuantite(): ?string
    {
        return $this->quantite;
    }

    public function setQuantite(string $quantite): static
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getDateEnvoi(): ?\DateTimeInterface
    {
        return $this->dateEnvoi;
    }

    public function setDateEnvoi(\DateTimeInterface $dateEnvoi): static
    {
        $this->dateEnvoi = $dateEnvoi;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addAimer($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            $user->removeAimer($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Inserer>
     */
    public function getInserers(): Collection
    {
        return $this->inserers;
    }

    public function addInserer(Inserer $inserer): static
    {
        if (!$this->inserers->contains($inserer)) {
            $this->inserers->add($inserer);
            $inserer->setProduit($this);
        }

        return $this;
    }

    public function removeInserer(Inserer $inserer): static
    {
        if ($this->inserers->removeElement($inserer)) {
            // set the owning side to null (unless already changed)
            if ($inserer->getProduit() === $this) {
                $inserer->setProduit(null);
            }
        }

        return $this;
    }
}
