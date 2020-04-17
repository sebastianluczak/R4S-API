<?php declare(strict_types=1);

namespace App\Validator\Constraint;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ReservationWithinWorkingHours extends Constraint
{
    public $message = 'Reservation must be within business hours.';

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}