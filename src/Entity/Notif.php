<?php

namespace App\Entity;

use App\Repository\NotifRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NotifRepository::class)
 */
class Notif
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $id_eta;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $type;

    /**
     * @ORM\Column(type="text")
     */
    private $message;

    /**
     * @ORM\Column(type="date")
     */
    private $date_diffusion;

    /**
     * @ORM\Column(type="date")
     */
    private $date_fin_diffusion;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdEta(): ?int
    {
        return $this->id_eta;
    }

    public function setIdEta(int $id_eta): self
    {
        $this->id_eta = $id_eta;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getDateDiffusion(): ?\DateTimeInterface
    {
        return $this->date_diffusion;
    }

    public function setDateDiffusion(\DateTimeInterface $date_diffusion): self
    {
        $this->date_diffusion = $date_diffusion;

        return $this;
    }

    public function getDateFinDiffusion(): ?\DateTimeInterface
    {
        return $this->date_fin_diffusion;
    }

    public function setDateFinDiffusion(\DateTimeInterface $date_fin_diffusion): self
    {
        $this->date_fin_diffusion = $date_fin_diffusion;

        return $this;
    }
}
