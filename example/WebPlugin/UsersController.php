<?php

namespace example\WebPlugin;

use DeSmart\CommandBus\Contracts\CommandBus;
use example\Domain\UseCases\CreateUserCommand;
use example\Domain\UseCases\RemoveUserCommand;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class UsersController extends Controller
{
    /**
     * @var CommandBus
     */
    protected $commandBus;

    /**
     * @param CommandBus $commandBus
     */
    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function createUserAction(Request $request)
    {
        $command = new CreateUserCommand($request->get('id'), $request->get('name'));
        $this->commandBus->handle($command);

        return new Response('', 201, ['Content-Type' => 'application/vnd.api+json']);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function removeUserAction(Request $request)
    {
        $command = new RemoveUserCommand($request->get('id'));
        $this->commandBus->handle($command);

        return new Response('', 204, ['Content-Type' => 'application/vnd.api+json']);
    }
}