<?php
/**
 * Created by PhpStorm.
 * User: jmtapiag
 * Date: 07/02/2019
 * Time: 05:38 PM
 */

namespace App\Repositories;

use App\Models\Response;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class UserRepository
{
    private $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    /**
     * Repository to get a user by id
     *
     * @param $user_id
     * @return Response
     */
    public function get_by_id($user_id) {

        try {
            $user = User::find($user_id);
            if ($user){
               $this->response->setOk(true);
               $this->response->setData($user);
            } else {
                $this->response->setOk(false);
                $this->response->setMessage('Can not get this user.');
                $this->response->setStatusCode(404);
            }
        } catch (\Exception $e) {
            Log::error('Something went wrong while trying to get user. Details: '.$e);
            $this->response->setOk(false);
            $this->response->setMessage('An exception was thrown while trying to get a user by id.');
            $this->response->setStatusCode(500);
        }

        return $this->response;
    }
}