<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Blog
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(type: "string", length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $imagePath = null;

    // Define the OneToMany relationship with Review
    #[ORM\OneToMany(mappedBy: 'blog', targetEntity: Review::class, cascade: ['persist', 'remove'])]
    private Collection $reviews;

    #[ORM\Column(length: 255)]
    private ?string $publisher = null;

    public function __construct()
    {
        // Initialize the reviews collection
        $this->reviews = new ArrayCollection();
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

    /**
     * @return Collection<int, Review>
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReview(Review $review): self
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews->add($review);
            $review->setBlog($this);
        }
        return $this;
    }

    public function removeReview(Review $review): self
    {
        if ($this->reviews->removeElement($review)) {
            // Set the owning side to null (unless already changed)
            if ($review->getBlog() === $this) {
                $review->setBlog(null);
            }
        }
        return $this;
    }

    public function getAverageRating(): float
    {
        $reviews = $this->getReviews();
        if ($reviews->isEmpty()) {
            return 0;
        }

        $totalRating = array_reduce($reviews->toArray(), function ($sum, $review) {
            return $sum + $review->getRating();
        }, 0);

        return round($totalRating / count($reviews), 1); // Rounded to 1 decimal place
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

    public function setImagePath(?string $imagePath): self
    {
        $this->imagePath = $imagePath;
        return $this;
    }
    
    public function getImagePath(): ?string
    {
        return $this->imagePath;
    }
    

    public function getPublisher(): ?string
    {
        return $this->publisher;
    }

    public function setPublisher(string $publisher): static
    {
        $this->publisher = $publisher;
        return $this;
    }
}
