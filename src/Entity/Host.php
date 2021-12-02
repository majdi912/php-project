<?php

namespace App\Entity;

use App\Repository\HostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Panne;
/**
 * @ORM\Entity(repositoryClass=HostRepository::class)
 */
class Host
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ip;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mac;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $location;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * @ORM\OneToMany(targetEntity=Panne::class, mappedBy="host")
     */
    private $pannes;

    public function __construct()
    {
        $this->pannes = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->ip;
    }
      
    public function getId(): ?int
    {
        return $this->id;
    }


    public function getIp(): ?string
    {
        return $this->ip;
    }

    public function setIp(string $ip): self
    {
        $this->ip = $ip;

        return $this;
    }

    public function getMac(): ?string
    {
        return $this->mac;
    }

    public function setMac(string $mac): self
    {
        $this->mac = $mac;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection|Panne[]
     */
    public function getPannes(): Collection
    {
        return $this->pannes;
    }

    public function addPanne(Panne $panne): self
    {
        if (!$this->pannes->contains($panne)) {
            $this->pannes[] = $panne;
            $panne->setHost($this);
        }

        return $this;
    }

    public function removePanne(Panne $panne): self
    {
        if ($this->pannes->removeElement($panne)) {
            // set the owning side to null (unless already changed)
            if ($panne->getHost() === $this) {
                $panne->setHost(null);
            }
        }

        return $this;
    }

    
}
