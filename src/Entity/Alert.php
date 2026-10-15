<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\AlertRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: AlertRepository::class)]
#[ORM\Table(name: 'nexo_alert')]
class Alert
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    private Uuid $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $label;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $subTitle;

    #[ORM\Column(type: 'decimal', precision:14, scale:2, nullable: true)]
    private ?string $amount;

    #[ORM\Column(type: 'string', length:50, nullable: true)]
    private ?string $devise;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $description;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private ?bool $ready = false;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTime $date;
    
    #[ORM\ManyToOne(targetEntity: Customer::class, inversedBy: 'alerts')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Customer $customer;

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

     public function getSubTitle(): ?string
    {
        return $this->subTitle;
    }

    public function setSubTitle(?string $subTitle): static
    {
        $this->subTitle = $subTitle;

        return $this;
    }

    public function getDevise(): ?string
    {
        return $this->devise;
    }

    public function setDevise(?string $devise): static
    {
        $this->devise = $devise;

        return $this;
    }

    public function getAmount(): ?string
    {
        return $this->amount;
    }

    public function setAmount(?string $amount): static
    {
        $this->amount = $amount;

        return $this;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): static
    {
        $this->customer = $customer;

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

    public function getRead(): ?bool
    {
        return $this->ready;
    }

    public function setRead(?bool $bool): static
    {
        $this->ready = $bool;

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

}
