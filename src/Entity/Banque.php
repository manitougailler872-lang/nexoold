<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Country;
use App\Repository\BanqueRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: BanqueRepository::class)]
#[ORM\Table(name: 'nexo_banque')]
class Banque
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    private Uuid $id;

    #[ORM\Column(type: 'string', length: 191, nullable:true)]
    private string $label;

    #[ORM\Column(type: 'string', length: 50, nullable:true)]
    private ?string $countryIso;

    #[ORM\Column(type: 'string', length: 20, nullable:true)]
    private ?string $codeBanque;

    #[ORM\Column(type: 'string', length: 20, nullable:true)]
    private ?string $codeSwift;

    #[ORM\Column(type: 'string', length: 255, nullable:true)]
    private ?string $logo;

    #[ORM\Column(type: 'boolean', nullable:true)]
    private ?bool $active = true;

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

    public function getCountryIso(): ?string
    {
        return $this->countryIso;
    }

    public function setCountryIso(?string $countryIso): static
    {
        $this->countryIso = $countryIso;

        return $this;
    }


    public function getCodeBanque(): ?string
    {
        return $this->codeBanque;
    }

    public function setCodeBanque(?string $codeBanque): static
    {
        $this->codeBanque = $codeBanque;

        return $this;
    }

    public function getCodeSwift(): ?string
    {
        return $this->codeSwift;
    }

    public function setCodeSwift(?string $codeSwift): static
    {
        $this->codeSwift = $codeSwift;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(?string $logo): static
    {
        $this->logo = $logo;

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(?bool $active): static
    {
        $this->active = $active;

        return $this;
    }
}
