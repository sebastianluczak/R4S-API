<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Validator\Constraint\ReservationSlotRange;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\Constraint\ReservationStartDate;
use App\Validator\Constraint\ReservationWithinWorkingHours;

/**
 * @ApiResource(
 *     collectionOperations={"get","post"},
 *     itemOperations={"get"},
 *     normalizationContext={"groups"={"read"}},
 *     denormalizationContext={"groups"={"write"}}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\ReservationRepository")
 * @ReservationStartDate
 * @ReservationWithinWorkingHours
 * @ReservationSlotRange
 */
class Reservation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     *
     * @Groups({"read"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\HairdresserStall", inversedBy="reservations")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank
     *
     * @Groups({"read", "write"})
     */
    private $hairdresserStall;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="reservations")
     * @ORM\JoinColumn(nullable=false)
     *
     * @Groups({"read"})
     */
    private $user;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\Type("\DateTimeInterface")
     *
     * @Groups({"read", "write"})
     */
    private $startDate;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\Type("\DateTimeInterface")
     *
     * @Groups({"read", "write"})
     */
    private $endDate;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHairdresserStall(): ?HairdresserStall
    {
        return $this->hairdresserStall;
    }

    public function setHairdresserStall(?HairdresserStall $hairdresserStall): self
    {
        $this->hairdresserStall = $hairdresserStall;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }
}
