<?php

namespace example\Domain;

interface UsersRepositoryInterface
{
    /**
     * @param UserId $id
     * @return User
     */
    public function get(UserId $id);

    /**
     * @param User $user
     * @return void
     */
    public function save(User $user);
}