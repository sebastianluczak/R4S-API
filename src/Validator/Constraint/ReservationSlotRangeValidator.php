<?php declare(strict_types=1);

namespace App\Validator\Constraint;

use App\Entity\Reservation;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ReservationSlotRangeValidator extends ConstraintValidator
{
    public function validate($reservation, Constraint $constraint)
    {
        if ($reservation instanceof Reservation) {
            $startDateWithinSlotRange = ($reservation->getStartDate()->format('i') == "00" || $reservation->getStartDate()->format('i') == "30");
            if (!$startDateWithinSlotRange) {
                $this->context->buildViolation($constraint->message)
                    ->atPath('startDate')
                    ->addViolation();
            }

            $endDateWithingSlotRange = ($reservation->getEndDate()->format('i') == "00" || $reservation->getEndDate()->format('i') == "30");
            if (!$endDateWithingSlotRange) {
                $this->context->buildViolation($constraint->message)
                    ->atPath('endDate')
                    ->addViolation();
            }
        } else {
            throw new \LogicException('Wrong validation context.');
        }
    }
}