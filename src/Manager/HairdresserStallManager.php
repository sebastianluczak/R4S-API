<?php declare(strict_types=1);

namespace App\Manager;

use App\Entity\HairdresserStall;
use Doctrine\ORM\EntityManagerInterface;

class HairdresserStallManager
{
    private EntityManagerInterface $objectManager;

    public function __construct(EntityManagerInterface $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    public function save(HairdresserStall $hairdresserStall, bool $flush = true): HairdresserStall
    {
        $this->objectManager->persist($hairdresserStall);

        if ($flush) {
            $this->objectManager->flush();
        }

        return $hairdresserStall;
    }

    public function createWithName(string $name): HairdresserStall
    {
        $hairdresserStall = new HairdresserStall();
        $hairdresserStall->setName($name);

        return $this->save($hairdresserStall);
    }
}