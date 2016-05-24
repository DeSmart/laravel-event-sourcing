<?php

namespace example\Domain\UseCases;

use example\Domain\UserId;

class CreateUserCommand
{
    /**
     * @var UserId
     */
    protected $userId;

    /**
     * @var string
     */
    protected $name;

    /**
     * @param UserId $userId
     * @param string $name
     */
    public function __construct(UserId $userId, $name)
    {
        $this->userId = $userId;
        $this->name = $name;
    }

    /**
     * @return UserId
     */
    public function getUserId()
    {
        return $this->creatorId;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
