<?php

namespace App\Entity;

use App\Repository\TableTwoRepository;
use App\Repository\VinylMixRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation\Slug;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: VinylMixRepository::class)]
class VinylMix
{
    use TimestampableEntity;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $trackCount = null;

    #[ORM\Column(length: 255)]
    private ?string $genre = null;

    #[ORM\Column]
    private int $votes = 0;

    #[ORM\Column(length: 100, unique: true)]
    #[Slug(fields: ['title'])]
    private ?string $slug = null;

    #[ORM\OneToMany(mappedBy: 'question', targetEntity: TableTwo::class, fetch: 'EXTRA_LAZY')]
    #[ORM\OrderBy(['createdAt'=> 'DESC'])]    
    private Collection $tableTwos;

    #[ORM\OneToMany(mappedBy: 'mix', targetEntity: MixTag::class)]
    private Collection $mixTags;

    // #[ORM\ManyToMany(targetEntity: Tag::class, inversedBy: 'vinylMixes')]
    // private Collection $tags;

    public function __construct()
    {
        $this->tableTwos = new ArrayCollection();
        // $this->tags = new ArrayCollection();
        $this->mixTags = new ArrayCollection();
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getTrackCount(): ?int
    {
        return $this->trackCount;
    }

    public function setTrackCount(int $trackCount): self
    {
        $this->trackCount = $trackCount;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }


    public function getVotes(): ?int
    {
        return $this->votes;
    }

    public function setVotes(int $votes): self
    {
        $this->votes = $votes;

        return $this;
    }
    public function downvote(){
        $this->votes--;
    }
    public function upvote(){
        $this->votes++;
    }
    public function getVotesString(): string
    {
        $prefix = ($this->votes === 0) ? '' : (($this->votes >= 0) ? '+' : '-');
        return sprintf('%s %d', $prefix, abs($this->votes));
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection<int, TableTwo>
     */
    public function getTableTwos(): Collection
    {
        return $this->tableTwos;
    }

    public function getApprovedAns(): Collection
    {
       
        return $this->tableTwos->matching(TableTwoRepository::createApprovedCriteria());
        
        // return $this->tableTwos->filter(function(TableTwo $tableTwo){
        //     return $tableTwo->isApproved();
        // });
    }

    public function addTableTwo(TableTwo $tableTwo): self
    {
        if (!$this->tableTwos->contains($tableTwo)) {
            $this->tableTwos->add($tableTwo);
            $tableTwo->setQuestion($this);
        }

        return $this;
    }

    public function removeTableTwo(TableTwo $tableTwo): self
    {
        if ($this->tableTwos->removeElement($tableTwo)) {
            // set the owning side to null (unless already changed)
            if ($tableTwo->getQuestion() === $this) {
                $tableTwo->setQuestion(null);
            }
        }

        return $this;
    }

    // /**
    //  * @return Collection<int, Tag>
    //  */
    // public function getTags(): Collection
    // {
    //     return $this->tags;
    // }

    // public function addTag(Tag $tag): self
    // {
    //     if (!$this->tags->contains($tag)) {
    //         $this->tags->add($tag);
    //     }

    //     return $this;
    // }

    // public function removeTag(Tag $tag): self
    // {
    //     $this->tags->removeElement($tag);

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
            $mixTag->setMix($this);
        }

        return $this;
    }

    public function removeMixTag(MixTag $mixTag): self
    {
        if ($this->mixTags->removeElement($mixTag)) {
            // set the owning side to null (unless already changed)
            if ($mixTag->getMix() === $this) {
                $mixTag->setMix(null);
            }
        }

        return $this;
    }
}
