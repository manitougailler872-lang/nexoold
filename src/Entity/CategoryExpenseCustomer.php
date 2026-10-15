<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\CategoryExpenseCustomerRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: CategoryExpenseCustomerRepository::class)]
#[ORM\Table(name: 'nexo_category_expense_customer')]
class CategoryExpenseCustomer
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    private Uuid $id;

    #[ORM\Column(type: 'decimal', precision: 14, scale: 2)]
    private ?string $amount;

    #[ORM\ManyToOne(targetEntity: Devise::class)]
    #[ORM\JoinColumn(nullable: true)]
    private ?Devise $devise;

    #[ORM\ManyToOne(targetEntity: CategoryExpense::class)]
    #[ORM\JoinColumn(nullable: true)]
    private ?CategoryExpense $category;

    #[ORM\ManyToOne(targetEntity: Customer::class)]
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

    public function getDevise(): ?Devise
    {
        return $this->devise;
    }

    public function setDevise(?Devise $devise): static
    {
        $this->devise = $devise;

        return $this;
    }

    public function getCategory(): ?CategoryExpense
    {
        return $this->category;
    }

    public function setCategory(?CategoryExpense $category): static
    {
        $this->category = $category;

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

    
    public function getAmount(): ?string
    {
        return $this->amount;
    }

    public function setAmount(?string $amount): static
    {
        $this->amount = $amount;

        return $this;
    }



}
