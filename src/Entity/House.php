<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\HouseRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=HouseRepository::class)
 */
class House
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

    /**
     * @ORM\Column(type="float")
     */
    private float $price = 0;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?\DateTimeImmutable $dateFrom = null;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?\DateTimeImmutable $dateTo = null;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $isVisible = false;

    private User $owner;

    private array $reviews = [];

    /**
     * @ORM\OneToOne(targetEntity=Review::class, mappedBy="house", cascade={"persist", "remove"})
     */
    private $review;

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

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    /**
     * @return \DateTimeImmutable|null
     */
    public function getDateFrom(): ?\DateTimeImmutable
    {
        return $this->dateFrom;
    }

    /**
     * @param \DateTimeImmutable $dateFrom
     */
    public function setDateFrom(\DateTimeImmutable $dateFrom): void
    {
        $this->dateFrom = $dateFrom;
    }

    /**
     * @return \DateTimeImmutable|null
     */
    public function getDateTo(): ?\DateTimeImmutable
    {
        return $this->dateTo;
    }

    /**
     * @param \DateTimeImmutable $dateTo
     */
    public function setDateTo(\DateTimeImmutable $dateTo): void
    {
        $this->dateTo = $dateTo;
    }

    /**
     * @return bool
     */
    public function isVisible(): bool
    {
        return $this->isVisible;
    }

    /**
     * @param bool $isVisible
     */
    public function setIsVisible(bool $isVisible): void
    {
        $this->isVisible = $isVisible;
    }

    public function getReview(): ?Review
    {
        return $this->review;
    }

    public function setReview(?Review $review): self
    {
        $this->review = $review;

        // set (or unset) the owning side of the relation if necessary
        $newHouse = null === $review ? null : $this;
        if ($review->getHouse() !== $newHouse) {
            $review->setHouse($newHouse);
        }

        return $this;
    }
}
