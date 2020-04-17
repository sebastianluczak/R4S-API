<?php declare(strict_types=1);

namespace App\Validator\Constraint;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ReservationStartDate extends Constraint
{
    public $message = 'Reservation start date cannot be greater than end date.';

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}