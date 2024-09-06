<?php

namespace App\Entity;

use App\Repository\WorkSpaceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: WorkSpaceRepository::class)]
class WorkSpace
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'workSpaces', cascade: ['remove'])]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'workSpaces', cascade: ['remove'])]
    #[Assert\NotBlank([], 'Ce champ ne doit pas être vide')]

    private ?Level $level = null;

    /**
     * @var Collection<int, Days>
     */
    #[ORM\OneToMany(targetEntity: Days::class, mappedBy: 'workspace', cascade: ['remove'])]
    #[Assert\NotBlank([], 'Ce champ ne doit pas être vide')]

    private Collection $days;

    /**
     * @var Collection<int, Matter>
     */
    #[ORM\OneToMany(targetEntity: Matter::class, mappedBy: 'workspace', cascade: ['remove'])]
    #[Assert\NotBlank([], 'Ce champ ne doit pas être vide')]

    private Collection $matters;

    /**
     * @var Collection<int, TimeTable>
     */
    #[ORM\OneToMany(targetEntity: TimeTable::class, mappedBy: 'workspace', cascade: ['remove'])]
    #[Assert\NotBlank([], 'Ce champ ne doit pas être vide')]

    private Collection $timeTables;

    public function __construct()
    {
        $this->days = new ArrayCollection();
        $this->matters = new ArrayCollection();
        $this->timeTables = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getLevel(): ?Level
    {
        return $this->level;
    }

    public function setLevel(?Level $level): static
    {
        $this->level = $level;

        return $this;
    }

    /**
     * @return Collection<int, Days>
     */
    public function getDays(): Collection
    {
        return $this->days;
    }

    public function addDay(Days $day): static
    {
        if (!$this->days->contains($day)) {
            $this->days->add($day);
            $day->setWorkspace($this);
        }

        return $this;
    }

    public function removeDay(Days $day): static
    {
        if ($this->days->removeElement($day)) {
            // set the owning side to null (unless already changed)
            if ($day->getWorkspace() === $this) {
                $day->setWorkspace(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Matter>
     */
    public function getMatters(): Collection
    {
        return $this->matters;
    }

    public function addMatter(Matter $matter): static
    {
        if (!$this->matters->contains($matter)) {
            $this->matters->add($matter);
            $matter->setWorkspace($this);
        }

        return $this;
    }

    public function removeMatter(Matter $matter): static
    {
        if ($this->matters->removeElement($matter)) {
            // set the owning side to null (unless already changed)
            if ($matter->getWorkspace() === $this) {
                $matter->setWorkspace(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TimeTable>
     */
    public function getTimeTables(): Collection
    {
        return $this->timeTables;
    }

    public function addTimeTable(TimeTable $timeTable): static
    {
        if (!$this->timeTables->contains($timeTable)) {
            $this->timeTables->add($timeTable);
            $timeTable->setWorkspace($this);
        }

        return $this;
    }

    public function removeTimeTable(TimeTable $timeTable): static
    {
        if ($this->timeTables->removeElement($timeTable)) {
            // set the owning side to null (unless already changed)
            if ($timeTable->getWorkspace() === $this) {
                $timeTable->setWorkspace(null);
            }
        }

        return $this;
    }
}