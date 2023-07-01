<?php

namespace App\Entity;

use App\Repository\MixTagRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MixTagRepository::class)]
class MixTag
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'mixTags')]
    #[ORM\JoinColumn(nullable: false)]
    private ?VinylMix $mix = null;

    #[ORM\ManyToOne(inversedBy: 'mixTags')]
    private ?Tag $tag = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $taggedAt = null;

    public function __construct()
    {
        $this->taggedAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMix(): ?VinylMix
    {
        return $this->mix;
    }

    public function setMix(?VinylMix $mix): self
    {
        $this->mix = $mix;

        return $this;
    }

    public function getTag(): ?Tag
    {
        return $this->tag;
    }

    public function setTag(?Tag $tag): self
    {
        $this->tag = $tag;

        return $this;
    }

    public function getTaggedAt(): ?\DateTimeImmutable
    {
        return $this->taggedAt;
    }

    public function setTaggedAt(\DateTimeImmutable $taggedAt): self
    {
        $this->taggedAt = $taggedAt;

        return $this;
    }
}
