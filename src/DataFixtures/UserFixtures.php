<?php

namespace App\DataFixtures;

use App\Manager\UserManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    private UserManager $userManager;

    public function __construct(UserManager $userManager)
     {
         $this->userManager = $userManager;
     }

    public function load(ObjectManager $manager)
    {
        $this->userManager->createUser('test@example.com', 'password123');
    }
}
