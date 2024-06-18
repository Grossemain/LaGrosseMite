<?php

namespace App\Entity;

use App\Repository\TeamsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TeamsRepository::class)]
class Teams
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name_team = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $img_team = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    /**
     * @var Collection<int, Members>
     */
    #[ORM\ManyToMany(targetEntity: Members::class, mappedBy: 'teams')]
    private Collection $members;

    public function __construct()
    {
        $this->members = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameTeam(): ?string
    {
        return $this->name_team;
    }

    public function setNameTeam(string $name_team): static
    {
        $this->name_team = $name_team;

        return $this;
    }

    public function getImgTeam(): ?string
    {
        return $this->img_team;
    }

    public function setImgTeam(?string $img_team): static
    {
        $this->img_team = $img_team;

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
     * @return Collection<int, Members>
     */
    public function getMembers(): Collection
    {
        return $this->members;
    }

    public function addMember(Members $member): static
    {
        if (!$this->members->contains($member)) {
            $this->members->add($member);
            $member->addTeam($this);
        }

        return $this;
    }

    public function removeMember(Members $member): static
    {
        if ($this->members->removeElement($member)) {
            $member->removeTeam($this);
        }

        return $this;
    }
}
