<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_commande = null;

    #[ORM\Column]
    private ?float $montant_total = null;


    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: LigneCommande::class, cascade: ['persist', 'remove'])]
private Collection $lignes;

public function __construct()
{
    $this->lignes = new ArrayCollection();
}




public function calculerMontantTotal(): void
{
    $total = 0;
    foreach ($this->lignes as $ligne) {
        $total += $ligne->getQuantite() * $ligne->getPrixUnitaire();
    }
    $this->setMontantTotal($total);
}




public function getLignes(): Collection
{
    return $this->lignes;
}

public function addLigne(LigneCommande $ligne): static
{
    if (!$this->lignes->contains($ligne)) {
        $this->lignes->add($ligne);
        $ligne->setCommande($this);

     }

    return $this;
}

public function removeLigne(LigneCommande $ligne): static
{
    if ($this->lignes->removeElement($ligne)) {
        // Set the owning side to null (unless already changed)
        if ($ligne->getCommande() === $this) {
            $ligne->setCommande(null);
        }
    }

    return $this;
}

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateCommande(): ?\DateTimeInterface
    {
        return $this->date_commande;
    }

    public function setDateCommande(\DateTimeInterface $date_commande): static
    {
        $this->date_commande = $date_commande;

        return $this;
    }

    public function getMontantTotal(): ?float
    {
        return $this->montant_total;
    }

    public function setMontantTotal(float $montant_total): static
    {
        $this->montant_total = $montant_total;

        return $this;
    }
}
