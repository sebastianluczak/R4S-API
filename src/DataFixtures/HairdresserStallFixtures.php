<?php

namespace App\DataFixtures;

use App\Entity\HairdresserStall;
use App\Manager\HairdresserStallManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class HairdresserStallFixtures extends Fixture
{
    private HairdresserStallManager $hairdresserStallManager;

    public function __construct(HairdresserStallManager $hairdresserStallManager)
    {
        $this->hairdresserStallManager = $hairdresserStallManager;
    }

    public function load(ObjectManager $manager)
    {
        $this->hairdresserStallManager->createWithName('HD1');
        $this->hairdresserStallManager->createWithName('HD2');
    }
}
