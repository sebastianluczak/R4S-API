<?php declare(strict_types=1);

namespace App\Manager;

use App\Entity\Reservation;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class ReservationManager
{
    private EntityManagerInterface $objectManager;

    public function __construct(EntityManagerInterface $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    public function save(Reservation $reservation, bool $flush = true): Reservation
    {
        $this->objectManager->persist($reservation);

        if ($flush) {
            $this->objectManager->flush();
        }

        return $reservation;
    }

    public function delete(Reservation $reservation): void
    {
        $this->objectManager->remove($reservation);
        $this->objectManager->flush();
    }

    public function assignUserToReservation(User $user, Reservation $reservation): Reservation
    {
        $reservation->setUser($user);

        return $reservation;
    }
}