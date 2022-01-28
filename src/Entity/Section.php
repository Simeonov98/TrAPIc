<?php

namespace App\Entity;

use App\Repository\SectionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SectionRepository::class)
 */
class Section
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
    private $lat_start;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lon_start;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lat_end;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lon_end;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $radius;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLatStart(): ?string
    {
        return $this->lat_start;
    }

    public function setLatStart(string $lat_start): self
    {
        $this->lat_start = $lat_start;

        return $this;
    }

    public function getLonStart(): ?string
    {
        return $this->lon_start;
    }

    public function setLonStart(string $lon_start): self
    {
        $this->lon_start = $lon_start;

        return $this;
    }

    public function getLatEnd(): ?string
    {
        return $this->lat_end;
    }

    public function setLatEnd(string $lat_end): self
    {
        $this->lat_end = $lat_end;

        return $this;
    }

    public function getLonEnd(): ?string
    {
        return $this->lon_end;
    }

    public function setLonEnd(string $lon_end): self
    {
        $this->lon_end = $lon_end;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getRadius(): ?string
    {
        return $this->radius;
    }

    public function setRadius(string $radius): self
    {
        $this->radius = $radius;

        return $this;
    }
}
