<?php

namespace App\Entity;

use App\Repository\TableTwoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TableTwoRepository::class)]
class TableTwo
{
    public const STATUS_NEEDS_APPROVAL = 'needs approval';
    public const STATUS_SPAM = 'spam';
    public const STATUS_APPROVED = 'approved';


    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $Description = null;

    #[ORM\ManyToOne(inversedBy: 'tableTwos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?VinylMix $question = null;

    #[ORM\Column]
    private ?int $votes = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(length: 15)]
    private ?string $status = self::STATUS_NEEDS_APPROVAL;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getQuestion(): ?VinylMix
    {
        return $this->question;
    }

    public function getQuestionText(): String 
    {
        if(!$this->getQuestion()){
            return '';
        }
        return (string) $this->getQuestion()->getSlug();
    }

    public function setQuestion(?VinylMix $question): self
    {
        $this->question = $question;

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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        if(!in_array($status, [self::STATUS_APPROVED, self::STATUS_SPAM, self::STATUS_NEEDS_APPROVAL])) {
            throw new \InvalidArgumentException(sprintf('Invalid status %s', $status));
        }

        $this->status = $status;

        return $this;
    }

    public function isApproved(): bool
    {
        return $this->status === self::STATUS_APPROVED;
    }
}
