<?php

namespace App\Entity;

use App\Repository\PanierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PanierRepository::class)]
class Panier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(targetEntity: self::class,inversedBy:'panier', cascade: ['persist', 'remove'])]
    private ?self $panier = null;

    #[ORM\OneToOne(mappedBy:'panier', cascade: ['persist', 'remove'])]
    private ?User $User = null;

    /**
     * @var Collection<int, Inserer>
     */
    #[ORM\OneToMany(targetEntity: Inserer::class, mappedBy: 'panier')]
    private Collection $inserers;

    #[ORM\OneToOne(mappedBy: 'panier', cascade: ['persist', 'remove'])]
    private ?User $user = null;

    public function __construct()
    {
        $this->inserers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPanier(): ?self
    {
        return $this->panier;
    }

    public function setPanier(?self $panier): static
    {
        $this->panier = $panier;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
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
            $inserer->setPanier($this);
        }

        return $this;
    }

    public function removeInserer(Inserer $inserer): static
    {
        if ($this->inserers->removeElement($inserer)) {
            // set the owning side to null (unless already changed)
            if ($inserer->getPanier() === $this) {
                $inserer->setPanier(null);
            }
        }

        return $this;
    }

    public function setUser(?User $user): static
    {
        // unset the owning side of the relation if necessary
        if ($user === null && $this->user !== null) {
            $this->user->setPanier(null);
        }

        // set the owning side of the relation if necessary
        if ($user !== null && $user->getPanier() !== $this) {
            $user->setPanier($this);
        }

        $this->user = $user;

        return $this;
    }

}