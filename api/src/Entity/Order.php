<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Enum\OrderPlateStatus;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(type: 'string', enumType: OrderPlateStatus::class)]
    private OrderPlateStatus $status;

    #[ORM\Column]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column(type: 'uuid')]
    private ?Uuid $uuid = null;

    /**
     * @var Collection<int, OrderPlate>
     */
    #[ORM\OneToMany(targetEntity: OrderPlate::class, mappedBy: 'order', cascade: ["persist"], orphanRemoval: true)]
    private Collection $orderPlates;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function __construct()
    {
        $this->orderPlates = new ArrayCollection();
        $this->uuid = Uuid::v4();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getStatus(): OrderPlateStatus
    {
        return $this->status;
    }

    public function setStatus(OrderPlateStatus $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getOrderPlates(): Collection
    {
        return $this->orderPlates;
    }

    public function addOrderPlate(OrderPlate $orderPlate): static
    {
        if (!$this->orderPlates->contains($orderPlate)) {
            $this->orderPlates->add($orderPlate);
            $orderPlate->setOrder($this);
        }

        return $this;
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

    public function getUuid(): ?Uuid
    {
        return $this->uuid;
    }

    public function setUuid(Uuid $uuid): static
    {
        $this->uuid = $uuid;

        return $this;
    }
}
