<?php

namespace SON\Http\Controllers\Api;

use Illuminate\Http\Request;
use SON\Http\Controllers\Controller;
use SON\Http\Requests\UserRequest;
use SON\Repositories\UserRepository;

class UsersController extends Controller
{
    /**
     * @var mixed
     */
    private $repository;

    /**
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param UserRequest $request
     */
    public function store(UserRequest $request)
    {
        $user = $this->repository->create($request->all());

        return response()->json($user, 201);
    }
}
