<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MessageRepository::class)
 */
class Message
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $message;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_mess;

    /**
     * @ORM\ManyToOne(targetEntity=Administration::class, inversedBy="messages")
     */
    private $admin;

    /**
     * @ORM\ManyToOne(targetEntity=utilisateur::class, inversedBy="messages")
     */
    private $utilisateur;

    /**
     * @ORM\ManyToOne(targetEntity=conversation::class, inversedBy="messages")
     */
    private $conversation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getDateMess(): ?\DateTimeInterface
    {
        return $this->date_mess;
    }

    public function setDateMess(?\DateTimeInterface $date_mess): self
    {
        $this->date_mess = $date_mess;

        return $this;
    }

    public function getAdmin(): ?administration
    {
        return $this->admin;
    }

    public function setAdmin(?administration $admin): self
    {
        $this->admin = $admin;

        return $this;
    }

    public function getUtilisateur(): ?utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?utilisateur $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    public function getConversation(): ?conversation
    {
        return $this->conversation;
    }

    public function setConversation(?conversation $conversation): self
    {
        $this->conversation = $conversation;

        return $this;
    }
}
