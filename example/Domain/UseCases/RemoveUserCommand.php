<?php

namespace example\Domain\UseCases;

use example\Domain\UserId;

class RemoveUserCommand
{
    /**
     * @var UserId
     */
    protected $userId;

    /**
     * @param UserId $userId
     */
    public function __construct(UserId $userId)
    {
        $this->userId = $userId;
    }
    
    /**
     * @return UserId
     */
    public function getUserId()
    {
        return $this->userId;
    }
}
