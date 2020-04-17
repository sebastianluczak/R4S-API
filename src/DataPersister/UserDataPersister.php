<?php declare(strict_types=1);

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\User;
use App\Manager\UserManager;

final class UserDataPersister implements ContextAwareDataPersisterInterface
{
    private UserManager $userManager;

    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }

    public function supports($data, array $context = []): bool
    {
        return $data instanceof User;
    }

    public function persist($data, array $context = [])
    {
        /** @var User $data */
        $plainPassword = $data->getPassword();
        $encodedPassword = $this->userManager->encodePlainPassword($data, $plainPassword);
        $data->setPassword($encodedPassword);
        $this->userManager->save($data);

        return $data;
    }

    public function remove($data, array $context = [])
    {
        $this->userManager->delete($data);
    }
}