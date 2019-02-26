<?php
/**
 * Created by PhpStorm.
 * User: jmtapiag
 * Date: 19/02/2019
 * Time: 06:22 PM
 */

namespace App\Repositories;


use Illuminate\Support\Facades\Log;
use App\Models\Response;
use App\Models\Dog;

class DogRepository
{
    /** @var Response  */
    private $response;

    /**
     * ReservationRepository constructor.
     * @param Response $response
     */
    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    public function index($user_id)
    {
        try {
            if ($user_id == NULL) {
                //$dogs = Dog::with('breed:id,name')->get();
                $dogs = Dog::all();
            } else {
                //$dogs = Dog::where('user_id', '=', $user_id)->with('breed:id,name')->get();
                $dogs = Dog::where('user_id', '=', $user_id)->get();
            }

            if($dogs){
                $this->response->setOk(true);
                $this->response->setMessage('Operation success.');
                $this->response->setData($dogs);
                $this->response->setStatusCode(200);
            } else {
                $this->response->setOk(false);
                $this->response->setMessage('Operation error. Can not get dogs. Please try later.');
                $this->response->setStatusCode(500);
            }
        } catch (\Exception $e) {
            Log::error('An exception was thrown while trying to get dogs. Details: '.$e);
            $this->response->setOk(false);
            $this->response->setMessage('The service is unavailable in this moment, please try later.');
            $this->response->setStatusCode(500);
        }

        return $this->response;
    }

    public function store($dog)
    {
        try {
            $dog = Dog::create($dog);
            if ($dog){
                $this->response->setOk(true);
                $this->response->setMessage('Operation success. Dog has been created.');
                $this->response->setData($dog);
                $this->response->setStatusCode(200);
            } else {
                $this->response->setOk(false);
                $this->response->setMessage('An error has occur while saving the dog. Please try later.');
                $this->response->setStatusCode(500);
            }
        } catch(\Exception $e) {
            Log::error('An exceptions was thrown while trying to create dog. Details: '.$e);
            $this->response->setOk(false);
            $this->response->setMessage('The service is unavailable in this moment, please try later.');
            $this->response->setStatusCode(500);
        }

        return $this->response;
    }

    public function show($dog_id)
    {
        try {
            $dog = Dog::with('breed:id,name')->find($dog_id);
            Log::debug('Dog: ' . $dog);
            if ($dog){
                $this->response->setOk(true);
                $this->response->setMessage('Operation success. Dog gotten.');
                $this->response->setData($dog);
                $this->response->setStatusCode(200);
            } else {
                $this->response->setOk(false);
                $this->response->setMessage('An error has occur while getting the dog details. Please try later.');
                $this->response->setStatusCode(500);
            }
        } catch(\Exception $e) {
            Log::error('An exceptions was thrown while trying to get dog. Details: '.$e);
            $this->response->setOk(false);
            $this->response->setMessage('The service is unavailable in this moment, please try later.');
            $this->response->setStatusCode(500);
        }
        return $this->response;
    }

    public function get_by_id($dog_id)
    {
        try {
            $dog = Dog::find($dog_id);
            if ($dog) {
                $this->response->setOk(true);
                $this->response->setData($dog);
            } else {
                $this->response->setMessage('Dog does not exits.');
                $this->response->setOk(false);
                $this->response->setStatusCode(404);
            }
        } catch (\Exception $e) {
            Log::error('An exception was thrown while getting dog. Details: '.$e);
            $this->response->setMessage('An exception was thrown while getting dog.');
            $this->response->setOk(false);
            $this->response->setStatusCode(500);
        }

        return $this->response;
    }
}
