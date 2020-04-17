<?php declare(strict_types=1);

namespace App\Validator\Constraint;

use App\Entity\Reservation;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ReservationStartDateValidator extends ConstraintValidator
{
    public function validate($reservation, Constraint $constraint)
    {
        if ($reservation instanceof Reservation) {
            if ($reservation->getStartDate() >= $reservation->getEndDate()) {
                $this->context->buildViolation($constraint->message)
                    ->atPath('startDate')
                    ->addViolation();
            }
        } else {
            throw new \LogicException('Wrong validation context.');
        }
    }
}