<?php

namespace App\Entity;

use App\Repository\CompagnyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CompagnyRepository::class)
 */
class Compagny
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
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $street;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $zipcode;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $website;

    /**
     * @ORM\OneToMany(targetEntity=Intership::class, mappedBy="idCompany")
     */
    private $interships;

    public function __construct()
    {
        $this->interships = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(string $street): self
    {
        $this->street = $street;

        return $this;
    }

    public function getZipcode(): ?string
    {
        return $this->zipcode;
    }

    public function setZipcode(string $zipcode): self
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(string $website): self
    {
        $this->website = $website;

        return $this;
    }

    /**
     * @return Collection<int, Intership>
     */
    public function getInterships(): Collection
    {
        return $this->interships;
    }

    public function addIntership(Intership $intership): self
    {
        if (!$this->interships->contains($intership)) {
            $this->interships[] = $intership;
            $intership->setIdCompany($this);
        }

        return $this;
    }

    public function removeIntership(Intership $intership): self
    {
        if ($this->interships->removeElement($intership)) {
            // set the owning side to null (unless already changed)
            if ($intership->getIdCompany() === $this) {
                $intership->setIdCompany(null);
            }
        }

        return $this;
    }
}
