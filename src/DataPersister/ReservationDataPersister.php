<?php declare(strict_types=1);

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Reservation;
use App\Entity\User;
use App\Exception\ReservationNotAccessibleDateException;
use App\Manager\ReservationManager;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

final class ReservationDataPersister implements ContextAwareDataPersisterInterface
{
    private ReservationManager $reservationManager;

    private TokenStorageInterface $tokenStorage;

    public function __construct(ReservationManager $reservationManager, TokenStorageInterface $tokenStorage)
    {
        $this->reservationManager = $reservationManager;
        $this->tokenStorage = $tokenStorage;
    }

    public function supports($data, array $context = []): bool
    {
        return $data instanceof Reservation;
    }

    public function persist($data, array $context = []): Reservation
    {
        /** @var Reservation $data */
        /** @var User $user */
        if (!$this->reservationManager->isReservationDateAccessible($data)) {
            throw new ReservationNotAccessibleDateException();
        }
        $user = $this->tokenStorage->getToken()->getUser();
        $data = $this->reservationManager->assignUserToReservation($user, $data);
        $this->reservationManager->save($data);

        return $data;
    }

    public function remove($data, array $context = [])
    {
        $this->reservationManager->delete($data);
    }
}