<?php

namespace App\Entity;

use App\Repository\IntershipRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=IntershipRepository::class)
 */
class Intership
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Student::class, inversedBy="interships")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idStudent;

    /**
     * @ORM\ManyToOne(targetEntity=Compagny::class, inversedBy="interships")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idCompany;

    /**
     * @ORM\Column(type="date")
     */
    private $startDate;

    /**
     * @ORM\Column(type="date")
     */
    private $endDate;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdStudent(): ?Student
    {
        return $this->idStudent;
    }

    public function setIdStudent(?Student $idStudent): self
    {
        $this->idStudent = $idStudent;

        return $this;
    }

    public function getIdCompany(): ?Compagny
    {
        return $this->idCompany;
    }

    public function setIdCompany(?Compagny $idCompany): self
    {
        $this->idCompany = $idCompany;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $sartDate): self
    {
        $this->startDate = $sartDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }
}
