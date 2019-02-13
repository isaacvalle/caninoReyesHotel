<?php
/**
 * Created by PhpStorm.
 * User: jmtapiag
 * Date: 06/02/2019
 * Time: 05:59 PM
 */

namespace App\Helpers;

use App\Models\Dog;
use App\Models\User;
use App\Models\Response;
use Illuminate\Support\Facades\Log;

class DogValidator
{
    /** @var Response */
    private $response;

    /**
     * DogValidator constructor.
     *
     * @param Response $response
     */
    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    /**
     * This function verify if the dog in the request exists.
     *
     *
     * @param $dog_id
     * @return \App\Models\Response $response
     */
    public function exists( $dog_id ) {

        Log::info('Validating if id: '.$dog_id.' dog exists.');

        if (Dog::find( $dog_id )) {
            $this->response->setOk(true);
        } else {
            $this->response->setOk(false);
            $this->response->setMessage('Could not create this reservation. Details: Dog received does not exists.');
            $this->response->setStatusCode(404);
        }

        return $this->response;
    }

    /**
     * This function verify if the dog in the request belongs to the user.
     *
     * @param  $user_id
     * @param  $dog_id
     * @return bool
     */
    public static function dog_belongs_user( $user_id, $dog_id ) {

        Log::info('Validating if id: '.$dog_id.' dog belongs to id: '.$user_id.' user.');

        $user_dogs = User::find($user_id);

        return $user_dogs->dogs->contains($dog_id) ? true : false;
    }

    /**
     * Get the dog size id.
     *
     * @param $dog_id
     * @return int
     */
    public function get_size_id( $dog_id ) {
        Log::info('Getting the id size from dog id: '.$dog_id);

        $dog = Dog::with('size:id,name')->find($dog_id);

        return !$dog ? $dog->size->id : null;
    }
}