<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGuestUser;
use App\Service\UserService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;

/**
 * @description  Class to handle al request related user, this can only be used by admin.
 *               This tier send the request to Service tier and it response with an Response
 *               object @see \App\Models\Response so in this tier are convert to a JSON format.
 *
 * @author Ing. Manuel Tapia <@manuel_30749@gmail.com>
 * @since  2019/01
 */
class UserController extends Controller
{
    /** @var UserService */
    private $userService;

    /**
     * UserController constructor.
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Function which expose endpoint to create a User, only for admin users.
     *
     * @param StoreGuestUser $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(StoreGuestUser $request)
    {
        Log::info('Controller - Guest Register has benn called.');
        $response = $this->userService->register($request->all(), $request->user()->id);

        return Response::json([
            'message' => $response->getMessage(),
            'data' => $response->getData(),
            'status_code' => $response->getStatusCode(),
            'ok' => $response->getOk()
        ], $response->getStatusCode());
    }
}
