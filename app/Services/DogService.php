<?php
/**
 * Created by PhpStorm.
 * User: jmtapiag
 * Date: 05/02/2019
 * Time: 11:37 AM
 */

namespace App\Service;

use App\Models\Response;
use App\Repositories\DogRepository;
use Illuminate\Support\Facades\Log;

class DogService
{
    /** @var UserService */
    private $userService;

    /** @var DogRepository */
    private $dogRepository;

    /**
     * DogService constructor.
     * @param UserService $userService
     * @param DogRepository $dogRepository
     */
    public function __construct(UserService $userService, DogRepository $dogRepository)
    {
        $this->userService = $userService;
        $this->dogRepository = $dogRepository;
    }

    /**
     * Service which index dogs related to user logged in. If admin get all dogs.
     *
     * @param $user_id
     * @return \App\Models\Response
     */
    public function index($user_id)
    {
        Log::info('Service - indexing dogs...');

        $user = $this->userService->get_by_id($user_id)->getData();

        $response = null;
        if ($user->hasRole('admin')){
            $response = $this->dogRepository->index(null);
        } else {
            $response = $this->dogRepository->index($user_id);
        }

        $dogs = null;
        if($response->getOk()) {
            $dogs = $response->getData();
        } else {
            return $response;
        }

        $response->setMessage('Dogs gotten.');
        $response->setStatusCode(200);
        $response->setData($dogs->toArray());
        $response->setOk(true);

        if(count($dogs) == 0) {
            Log::info('Service - this user does not have any dog.');
            $response->setMessage('This user does not have any dog register.');
            $response->setStatusCode(200);
            $response->setData($dogs->toArray());
            $response->setOk(true);
        }

        return $response;
    }

    /**
     * Service to store dogs.
     *
     * @param array $dog
     * @param $user_id
     * @return \App\Models\Response|mixed
     */
    public function store(array $dog, $user_id)
    {
        Log::info('Service - creating dog...');

        $user = $this->userService->get_by_id($user_id)->getData();

        //this validate if user user who is requesting has admin role
        //if false get the session user and put it on the request, otherwise
        //user has admin role, check if the user_id (in the request) exists.
        if (!$user->hasRole('admin')) {
            $dog['user_id'] = $user_id;
        } else {
            $response = $this->userService->exists($dog['user_id']);
            if(!$response->getOk()) {
                return $response;
            }
        }

        $dog['status'] = true;

        $response = $this->dogRepository->store($dog);

        return $response;
    }

    public function show($user_id, $dog_id)
    {
        Log::info('Service - getting dog details...');
        Log::debug('with data, user_id: '.$user_id.', dog_id: '.$dog_id);

        $response = new Response();

        $user = $this->userService->get_by_id($user_id)->getData();
        $dog = $this->dogRepository->show($dog_id);
        if ($user->hasRole('admin')) {
            return $dog;
        } else {
            if ($dog->getData()->user_id == $user_id) {
                return $dog;
            } else {
                Log::error('Service - This dog does not belongs to this user.');
                $response->setMessage('This dog does not belongs to this user.');
                $response->setStatusCode(200);
                $response->setOk(true);
            }
        }

        return $response;
    }

    public function destroy()
    {

    }

    public function update()
    {

    }

}