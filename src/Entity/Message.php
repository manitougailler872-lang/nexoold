<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\MessageRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: MessageRepository::class)]
#[ORM\Table(name: 'nexo_message')]
class Message
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    private Uuid $id;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $label;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $title;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $subTitle;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $description;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private ?bool $ready = false;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTime $date;

    #[ORM\ManyToOne(targetEntity: Customer::class, inversedBy: 'messages')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Customer $customer;

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): static
    {
        $this->customer = $customer;

        return $this;
    }

    public function __construct()
    {
        $this->id = Uuid::v7();
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(?string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): static
    {
        $this->title = $title;

        return $this;
    }

     public function getSubTitle(): ?string
    {
        return $this->subTitle;
    }

    public function setSubTitle(?string $subTitle): static
    {
        $this->subTitle = $subTitle;

        return $this;
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

    public function getRead(): ?bool
    {
        return $this->ready;
    }

    public function setRead(?bool $bool): static
    {
        $this->ready = $bool;

        return $this;
    }

    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    public function setDate(?\DateTime $date): static
    {
        $this->date = $date;

        return $this;
    }
}
