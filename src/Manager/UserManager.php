<?php declare(strict_types=1);

namespace App\Manager;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserManager
{
    private EntityManagerInterface $objectManager;
    private UserPasswordEncoderInterface $passwordEncoder;

    public function __construct(EntityManagerInterface $objectManager, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->objectManager = $objectManager;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function save(User $user, bool $flush = true): User
    {
        $this->objectManager->persist($user);

        if ($flush) {
            $this->objectManager->flush();
        }

        return $user;
    }

    public function delete(User $user): void
    {
        $this->objectManager->remove($user);
        $this->objectManager->flush();
    }

    public function createUser(string $email, string $password): User
    {
        $user = new User();
        $user->setEmail($email);
        $user->setPassword($this->passwordEncoder->encodePassword($user, $password));
        $this->save($user);

        return $user;
    }

    public function encodePlainPassword(User $user, string $plainPassword): string
    {
        return $this->passwordEncoder->encodePassword($user, $plainPassword);
    }
}