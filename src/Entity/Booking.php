<?php

namespace App\Entity;

use App\Repository\BookingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BookingRepository::class)
 */
class Booking
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $start;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $end;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $place;

    /**
     * @ORM\OneToMany(targetEntity=Spectator::class, mappedBy="booking")
     */
    private $spectators;

    public function __construct()
    {
        $this->spectators = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStart(): ?\DateTimeInterface
    {
        return $this->start;
    }

    public function getStartFormat($format = 'd/m/Y à H:i')
    {
        return $this->start->format($format).' '.'nombre de places restantes:'.' '.$this->place;
    }

    public function setStart(?\DateTimeInterface $start): self
    {
        $this->start = $start;

        return $this;
    }

    public function getEnd(): ?\DateTimeInterface
    {
        return $this->end;
    }

    public function setEnd(?\DateTimeInterface $end): self
    {
        $this->end = $end;

        return $this;
    }

    public function getPlace(): ?int
    {
        return $this->place;
    }

    public function setPlace(?int $place): self
    {
        $this->place = $place;

        return $this;
    }

    /**
     * @return Collection|Spectator[]
     */
    public function getSpectators(): Collection
    {
        return $this->spectators;
    }

    public function addSpectator(Spectator $spectator): self
    {
        if (!$this->spectators->contains($spectator)) {
            $this->spectators[] = $spectator;
            $spectator->setBooking($this);
        }

        return $this;
    }

    public function removeSpectator(Spectator $spectator): self
    {
        if ($this->spectators->contains($spectator)) {
            $this->spectators->removeElement($spectator);
            // set the owning side to null (unless already changed)
            if ($spectator->getBooking() === $this) {
                $spectator->setBooking(null);
            }
        }

        return $this;
    }
}
