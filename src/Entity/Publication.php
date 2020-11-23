<?php

namespace App\Entity;

use App\Repository\PublicationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PublicationRepository::class)
 */
class Publication
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_pub;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $contenu_pub;

    /**
     * @ORM\Column(type="string", length=1, nullable=true)
     */
    private $statut;

    /**
     * @ORM\OneToMany(targetEntity=Commentaire::class, mappedBy="publication")
     */
    private $commentaires;

    /**
     * @ORM\ManyToOne(targetEntity=utilisateur::class, inversedBy="publications")
     */
    private $utilisateur;

    /**
     * @ORM\ManyToOne(targetEntity=administration::class, inversedBy="publications")
     */
    private $admin;

    /**
     * @ORM\OneToMany(targetEntity=Mutimedia::class, mappedBy="publication")
     */
    private $mutimedia;

    public function __construct()
    {
        $this->commentaires = new ArrayCollection();
        $this->mutimedia = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatePub(): ?\DateTimeInterface
    {
        return $this->date_pub;
    }

    public function setDatePub(?\DateTimeInterface $date_pub): self
    {
        $this->date_pub = $date_pub;

        return $this;
    }

    public function getContenuPub(): ?string
    {
        return $this->contenu_pub;
    }

    public function setContenuPub(?string $contenu_pub): self
    {
        $this->contenu_pub = $contenu_pub;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(?string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * @return Collection|Commentaire[]
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires[] = $commentaire;
            $commentaire->setPublication($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getPublication() === $this) {
                $commentaire->setPublication(null);
            }
        }

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

    public function getAdmin(): ?administration
    {
        return $this->admin;
    }

    public function setAdmin(?administration $admin): self
    {
        $this->admin = $admin;

        return $this;
    }

    /**
     * @return Collection|Mutimedia[]
     */
    public function getMutimedia(): Collection
    {
        return $this->mutimedia;
    }

    public function addMutimedia(Mutimedia $mutimedia): self
    {
        if (!$this->mutimedia->contains($mutimedia)) {
            $this->mutimedia[] = $mutimedia;
            $mutimedia->setPublication($this);
        }

        return $this;
    }

    public function removeMutimedia(Mutimedia $mutimedia): self
    {
        if ($this->mutimedia->removeElement($mutimedia)) {
            // set the owning side to null (unless already changed)
            if ($mutimedia->getPublication() === $this) {
                $mutimedia->setPublication(null);
            }
        }

        return $this;
    }
}
