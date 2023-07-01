<?php

namespace App\Entity;

use App\Repository\TagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: TagRepository::class)]
class Tag
{
    use TimestampableEntity;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'tag', targetEntity: MixTag::class)]
    private Collection $mixTags;

    // #[ORM\ManyToMany(targetEntity: VinylMix::class, mappedBy: 'tags')]
    // private Collection $vinylMixes;

    public function __construct()
    {
        // $this->vinylMixes = new ArrayCollection();
        $this->mixTags = new ArrayCollection();
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

    // /**
    //  * @return Collection<int, VinylMix>
    //  */
    // public function getVinylMixes(): Collection
    // {
    //     return $this->vinylMixes;
    // }

    // public function addVinylMix(VinylMix $vinylMix): self
    // {
    //     if (!$this->vinylMixes->contains($vinylMix)) {
    //         $this->vinylMixes->add($vinylMix);
    //         $vinylMix->addTag($this);
    //     }

    //     return $this;
    // }

    // public function removeVinylMix(VinylMix $vinylMix): self
    // {
    //     if ($this->vinylMixes->removeElement($vinylMix)) {
    //         $vinylMix->removeTag($this);
    //     }

    //     return $this;
    // }

    /**
     * @return Collection<int, MixTag>
     */
    public function getMixTags(): Collection
    {
        return $this->mixTags;
    }

    public function addMixTag(MixTag $mixTag): self
    {
        if (!$this->mixTags->contains($mixTag)) {
            $this->mixTags->add($mixTag);
            $mixTag->setTag($this);
        }

        return $this;
    }

    public function removeMixTag(MixTag $mixTag): self
    {
        if ($this->mixTags->removeElement($mixTag)) {
            // set the owning side to null (unless already changed)
            if ($mixTag->getTag() === $this) {
                $mixTag->setTag(null);
            }
        }

        return $this;
    }
}
