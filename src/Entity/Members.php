<?php

namespace App\Entity;

use App\Repository\MembersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MembersRepository::class)]
class Members
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $name_member = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $img_member = null;

    /**
     * @var Collection<int, Teams>
     */
    #[ORM\ManyToMany(targetEntity: Teams::class, inversedBy: 'members')]
    private Collection $teams;

    public function __construct()
    {
        $this->teams = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getNameMember(): ?string
    {
        return $this->name_member;
    }

    public function setNameMember(string $name_member): static
    {
        $this->name_member = $name_member;

        return $this;
    }

    public function getImgMember(): ?string
    {
        return $this->img_member;
    }

    public function setImgMember(?string $img_member): static
    {
        $this->img_member = $img_member;

        return $this;
    }

    /**
     * @return Collection<int, Teams>
     */
    public function getTeams(): Collection
    {
        return $this->teams;
    }

    public function addTeam(Teams $team): static
    {
        if (!$this->teams->contains($team)) {
            $this->teams->add($team);
        }

        return $this;
    }

    public function removeTeam(Teams $team): static
    {
        $this->teams->removeElement($team);

        return $this;
    }
}
