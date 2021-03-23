<?php

namespace App\Entity;

use App\Repository\FacturationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FacturationRepository::class)
 */
class Facturation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateD;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateF;

    /**
     * @ORM\Column(type="integer")
     */
    private $valeur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $etat;

    /**
     * @ORM\ManyToOne(targetEntity=client::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $ide;

    /**
     * @ORM\OneToOne(targetEntity=Vehicule::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $idv;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateD(): ?\DateTimeInterface
    {
        return $this->dateD;
    }

    public function setDateD(\DateTimeInterface $dateD): self
    {
        $this->dateD = $dateD;

        return $this;
    }

    public function getDateF(): ?\DateTimeInterface
    {
        return $this->dateF;
    }

    public function setDateF(\DateTimeInterface $dateF): self
    {
        $this->dateF = $dateF;

        return $this;
    }

    public function getValeur(): ?int
    {
        return $this->valeur;
    }

    public function setValeur(int $valeur): self
    {
        $this->valeur = $valeur;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getIde(): ?client
    {
        return $this->ide;
    }

    public function setIde(?client $ide): self
    {
        $this->ide = $ide;

        return $this;
    }

    public function getIdv(): ?vehicule
    {
        return $this->idv;
    }

    public function setIdv(vehicule $idv): self
    {
        $this->idv = $idv;

        return $this;
    }
}
