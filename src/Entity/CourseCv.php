<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CourseCvRepository")
 */
class CourseCv
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Titre obligatoire")
     */
    private $title;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="Date obligatoire")
     */
    private $date_start;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="Date obligatoire")
     */
    private $date_end;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Assert\NotBlank(message="contenu obligatoire")
     */
    private $content;

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDateStart(): ?int
    {
        return $this->date_start;
    }

    public function setDateStart(int $date_start): self
    {
        $this->date_start = $date_start;

        return $this;
    }

    public function getDateEnd(): ?int
    {
        return $this->date_end;
    }

    public function setDateEnd(int $date_end): self
    {
        $this->date_end = $date_end;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }
}
