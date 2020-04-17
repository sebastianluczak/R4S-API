<?php declare(strict_types=1);

namespace App\Validator\Constraint;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ReservationSlotRange extends Constraint
{
    public $message = 'Reservation dates can only be a multiple of half an hour.';

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}