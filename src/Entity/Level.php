<?php

namespace App\Entity;

use App\Repository\LevelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LevelRepository::class)]
class Level
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, WorkSpace>
     */
    #[ORM\OneToMany(targetEntity: WorkSpace::class, mappedBy: 'level')]
    private Collection $workSpaces;

    public function __construct()
    {
        $this->workSpaces = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, WorkSpace>
     */
    public function getWorkSpaces(): Collection
    {
        return $this->workSpaces;
    }

    public function addWorkSpace(WorkSpace $workSpace): static
    {
        if (!$this->workSpaces->contains($workSpace)) {
            $this->workSpaces->add($workSpace);
            $workSpace->setLevel($this);
        }

        return $this;
    }

    public function removeWorkSpace(WorkSpace $workSpace): static
    {
        if ($this->workSpaces->removeElement($workSpace)) {
            // set the owning side to null (unless already changed)
            if ($workSpace->getLevel() === $this) {
                $workSpace->setLevel(null);
            }
        }

        return $this;
    }
}
