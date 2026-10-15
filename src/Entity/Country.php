<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\CountryRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: CountryRepository::class)]
#[ORM\Table(name: 'nexo_country')]
class Country
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    private Uuid $id;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private ?string $label;

    #[ORM\Column(type: 'string', length: 2, nullable: true)]
    private ?string $codeIso2;

    #[ORM\Column(type: 'string', length: 3, nullable: true)]
    private ?string $codeIso3;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $countryCode;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private ?string $language;

    #[ORM\Column(type: 'string', length: 5, nullable: true)]
    private ?string $currencyIso;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $timeZone;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private ?string $continent;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $flag;

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

    public function getCodeIso2(): ?string
    {
        return $this->codeIso2;
    }

    public function setCodeIso2(?string $codeIso2): static
    {
        $this->codeIso2 = $codeIso2;

        return $this;
    }

    public function getCodeIso3(): ?string
    {
        return $this->codeIso3;
    }

    public function setCodeIso3(?string $codeIso3): static
    {
        $this->codeIso3 = $codeIso3;

        return $this;
    }

    public function getCountryCode(): ?string
    {
        return $this->countryCode;
    }

    public function setCountryCode(?string $countryCode): static
    {
        $this->countryCode = $countryCode;

        return $this;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function setLanguage(?string $language): static
    {
        $this->language = $language;

        return $this;
    }

    public function getCurrencyIso(): ?string
    {
        return $this->currencyIso;
    }

    public function setCurrencyIso(?string $currencyIso): static
    {
        $this->currencyIso = $currencyIso;

        return $this;
    }

    public function getTimeZone(): ?string
    {
        return $this->timeZone;
    }

    public function setTimeZone(?string $timeZone): static
    {
        $this->timeZone = $timeZone;

        return $this;
    }

    public function getContinent(): ?string
    {
        return $this->continent;
    }

    public function setContinent(?string $continent): static
    {
        $this->continent = $continent;

        return $this;
    }

    public function getFlag(): ?string
    {
        return $this->flag;
    }

    public function setFlag(?string $flag): static
    {
        $this->flag = $flag;

        return $this;
    }
}
