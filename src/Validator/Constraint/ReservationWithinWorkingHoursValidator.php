<?php declare(strict_types=1);

namespace App\Validator\Constraint;

use App\Entity\Reservation;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ReservationWithinWorkingHoursValidator extends ConstraintValidator
{
    private \DateTime $workingHoursStart;

    private \DateTime $workingHoursEnd;

    public function __construct(string $workingHoursStart, string $workingHoursEnd)
    {
        $this->workingHoursStart = new \DateTime($workingHoursStart);
        $this->workingHoursEnd = new \DateTime($workingHoursEnd);
    }

    public function validate($reservation, Constraint $constraint)
    {
        if ($reservation instanceof Reservation) {
            // I'm aware that this method will work only for 24H time
            if ((int)$this->workingHoursStart->format('Hi') > (int)$reservation->getStartDate()->format('Hi')) {
                $this->context->buildViolation($constraint->message)
                    ->atPath('startDate')
                    ->addViolation();
            }

            if ((int)$this->workingHoursEnd->format('Hi') <= (int)$reservation->getEndDate()->format('Hi')) {
                $this->context->buildViolation($constraint->message)
                    ->atPath('endDate')
                    ->addViolation();
            }
        } else {
            throw new \LogicException('Wrong validation context.');
        }
    }
}