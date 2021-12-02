<?php

namespace App\Entity;

use App\Repository\PanneRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PanneRepository::class)
 */
class Panne
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $date_panne;

    /**
     * @ORM\Column(type="date",nullable=true)
     */
    private $date_reparation;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity=Host::class, inversedBy="pannes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $host;

    /**
     * @ORM\ManyToOne(targetEntity=Technicien::class, inversedBy="pannes")
     */
    private $technicien;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $description;





    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatePanne(): ?\DateTimeInterface
    {
        return $this->date_panne;
    }

    public function setDatePanne(\DateTimeInterface $date_panne): self
    {
        $this->date_panne = $date_panne;

        return $this;
    }

    public function getDateReparation(): ?\DateTimeInterface
    {
        return $this->date_reparation;
    }

    public function setDateReparation(\DateTimeInterface $date_reparation): self
    {
        $this->date_reparation = $date_reparation;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getHost(): ?Host
    {
        return $this->host;
    }

    public function setHost(?Host $host): self
    {
        $this->host = $host;

        return $this;
    }

    public function getTechnicien(): ?Technicien
    {
        return $this->technicien;
    }

    public function setTechnicien(?Technicien $technicien): self
    {
        $this->technicien = $technicien;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

   


  
}
