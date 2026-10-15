<?php

declare(strict_types=1);

namespace App\Entity;

use App\Enum\FlashEnum;
use App\Repository\MessageRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: MessageRepository::class)]
#[ORM\Table(name: 'nexo_flashy')]
class Flashy
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    private Uuid $id;

    #[ORM\Column(enumType: FlashEnum::class)]
    private FlashEnum $alertType;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $message;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $title;

    #[ORM\OneToOne(
        mappedBy: 'flashy',
        targetEntity: Customer::class,
        cascade: ['persist', 'remove']
    )]
    private ?Customer $customer;
    
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $description;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private ?bool $showo;

    public function __construct()
    {
        $this->id = Uuid::v7();
    }

    
    public function getMessage(): ?string { return $this->message; }
    public function setMessage(string $v): self { $this->message = $v; return $this; }

    public function getTitle(): ?string { return $this->title; }
    public function setTitle(string $v): self { $this->title = $v; return $this; }

    public function getAlertType(): ?FlashEnum { return $this->alertType; }
    public function setAlertType(FlashEnum $v): self { $this->alertType = $v; return $this; }

    public function getShow(): ?bool { return $this->showo; }
    public function setShow(?bool $v): self { $this->showo = $v; return $this; }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): static
    {
        $this->customer = $customer;

        if ($customer !== null && $customer->getUser() !== $this) {
            $customer->setFlashy($this);
        }

        return $this;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }
}
