<?php

namespace example\Domain\UseCases;

use DeSmart\EventSourcing\EventStoreInterface;
use example\Domain\UsersRepositoryInterface;

class RemoveUserCommandHandler
{
    /**
     * @var UsersRepositoryInterface
     */
    protected $usersRepository;

    /**
     * @param UsersRepositoryInterface $usersRepository
     */
    public function __construct(UsersRepositoryInterface $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    /**
     * @param RemoveUserCommand $command
     * @return void
     */
    public function handle(RemoveUserCommand $command)
    {
        $user = $this->usersRepository->get($command->getUserId());
        $user->remove();

        $this->usersRepository->save($user);
    }
}