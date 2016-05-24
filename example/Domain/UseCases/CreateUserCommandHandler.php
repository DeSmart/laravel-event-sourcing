<?php

namespace example\Domain\UseCases;

use example\Domain\User;
use example\Domain\UsersRepositoryInterface;

class CreateUserCommandHandler
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
     * @param CreateUserCommand $command
     * @return void
     */
    public function handle(CreateUserCommand $command)
    {
        $user = User::create($command->getUserId(), $command->getName());

        $this->usersRepository->save($user);
    }
}
