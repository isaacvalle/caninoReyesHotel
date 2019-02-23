<?php
/**
 * Created by PhpStorm.
 * User: jmtapiag
 * Date: 05/02/2019
 * Time: 12:49 PM
 */

namespace App\Service;

use App\Helpers\UserValidator;
use App\Models\Response;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Log;

use App\Models\UserAddress;
use App\Models\Municipality;

class UserService
{
    private $userRepository;
    private $userValidator;

    public function __construct(UserRepository $userRepository, UserValidator $userValidator)
    {
        $this->userRepository = $userRepository;
        $this->userValidator = $userValidator;
    }

    /**
     * Return a user by given id
     *
     * @param $user_id
     * @return mixed
     */
    public function get_by_id($user_id) {

        return $this->userRepository->get_by_id($user_id);
    }

    /**
     * Return true or false if user exits
     *
     * @param $user_id
     * @return mixed
     */
    public function exists($user_id) {

        return $this->userValidator->exists($user_id);
    }

    /**
     * Function which helps to get the user's locality.
     *
     *
     * @param  int $user_id
     * @return String
     */
    public function get_locality( $user_id ) {

        $user_data = UserAddress::with('address:id,municipality_id')->
                                  where('user_id', '=', $user_id)->
                                  get();

        $municipality_id = null;
        foreach($user_data as $data) {
            $municipality_id = $data['address']->municipality_id;
        }
        Log::info("User municipality (id): " . $municipality_id);
        $municipality = null;
        if ($municipality_id != null) {
            $municipality = Municipality::find($municipality_id);
            Log::info("User municipality: " . $municipality->name);
            $municipality = strtolower(substr(trim($municipality->name), 0, 3));
            Log::info("Municipality returned: " . $municipality);
            return $municipality;
        }
        return $municipality;
    }

    /**
     * Function which register a user, this function validate if user who is requesting has
     * admin role.
     *
     * @param array $request
     * @param $user_id
     * @return Response
     */
    public function register(array $request, $user_id)
    {
        Log::info('Service - Starting validations to create new user.');
        $validator = $this->userValidator->create($user_id);

        if ($validator->getOk()) {
            return $this->userRepository->create($request);
        } else {
            return $validator;
        }
    }
}