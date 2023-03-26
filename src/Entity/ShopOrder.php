<?php

namespace App\Entity;

use App\Repository\ShopOrderRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ShopOrderRepository::class)]
class ShopOrder
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $sessionId = null;

    #[ORM\Column]
    private ?int $status = null;

    #[ORM\Column(length: 255)]
    private ?string $userName = null;

    #[ORM\Column(length: 255)]
    private ?string $userEmail = null;

    #[ORM\Column(length: 255)]
    private ?string $userPhone = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSessionId(): ?string
    {
        return $this->sessionId;
    }

    public function setSessionId(string $sessionId): self
    {
        $this->sessionId = $sessionId;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getUserName(): ?string
    {
        return $this->userName;
    }

    public function setUserName(string $userName): self
    {
        $this->userName = $userName;

        return $this;
    }

    public function getUserEmail(): ?string
    {
        return $this->userEmail;
    }

    public function setUserEmail(string $userEmail): self
    {
        $this->userEmail = $userEmail;

        return $this;
    }

    public function getUserPhone(): ?string
    {
        return $this->userPhone;
    }

    public function setUserPhone(string $userPhone): self
    {
        $this->userPhone = $userPhone;

        return $this;
    }
}
