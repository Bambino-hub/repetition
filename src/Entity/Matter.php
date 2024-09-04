<?php

namespace App\Entity;

use App\Repository\MatterRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MatterRepository::class)]
class Matter
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank('', 'Ce champ ne doit pas être vide')]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'matters', cascade: ['persist'])]
    private ?WorkSpace $workspace = null;

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

    public function getWorkspace(): ?WorkSpace
    {
        return $this->workspace;
    }

    public function setWorkspace(?WorkSpace $workspace): static
    {
        $this->workspace = $workspace;

        return $this;
    }
}