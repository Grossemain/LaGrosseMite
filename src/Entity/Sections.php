<?php

namespace App\Entity;

use App\Repository\SectionsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SectionsRepository::class)]
class Sections
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nameSection = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $img_section = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameSection(): ?string
    {
        return $this->nameSection;
    }

    public function setNameSection(string $nameSection): static
    {
        $this->nameSection = $nameSection;

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

    public function getImgSection(): ?string
    {
        return $this->img_section;
    }

    public function setImgSection(?string $img_section): static
    {
        $this->img_section = $img_section;

        return $this;
    }
}
