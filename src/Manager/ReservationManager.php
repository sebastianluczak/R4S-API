<?php declare(strict_types=1);

namespace App\Manager;

use App\Entity\Reservation;
use App\Entity\User;
use App\Repository\ReservationRepository;
use Doctrine\ORM\EntityManagerInterface;

class ReservationManager
{
    private EntityManagerInterface $objectManager;
    private ReservationRepository $repository;

    public function __construct(EntityManagerInterface $objectManager, ReservationRepository $repository)
    {
        $this->objectManager = $objectManager;
        $this->repository = $repository;
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

    public function isReservationDateAccessible(Reservation $reservation): bool
    {
        $startDate = $reservation->getStartDate();
        $endDate = $reservation->getEndDate();
        $hairdresserStall = $reservation->getHairdresserStall();
        $occurences = $this->repository->findBetweenDatesForHairdresserStall($startDate, $endDate, $hairdresserStall);

        if (count($occurences)) {
            return false;
        }

        return true;
    }
}