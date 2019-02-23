<?php

namespace App\Helpers;

use App\Repositories\ReservationRepository;
use App\Service\UserService;
use Illuminate\Support\Facades\Log;

use App\Models\Room;
use App\Models\Dog;
use App\Models\Reservation;
use App\Models\Response;

/**
 * @description  This class perform business validations as result
 *               return an object with response @see Response
 *
 * @author Ing. Manuel Tapia - @manuel_30749
 * @since  2019/02
 */
class ReservationValidator
{
    /** @var UserService  */
    private $userService;

    /** @var Response  */
    private $response;

    /** @var UserValidator  */
    private $userValidator;

    /** @var DogValidator  */
    private $dogValidator;

    /** @var ReservationRepository */
    private $reservationRepository;

    /**
     * ReservationValidator constructor.
     *
     * @param UserService $userService
     * @param UserValidator $userValidator
     * @param DogValidator $dogValidator
     * @param Response $response
     * @param ReservationRepository $reservationRepository
     */
    public function __construct (
        UserService $userService,
        UserValidator $userValidator,
        DogValidator $dogValidator,
        Response $response,
        ReservationRepository $reservationRepository
    ) {
        $this->userService = $userService;
        $this->response = $response;
        $this->userValidator = $userValidator;
        $this->dogValidator = $dogValidator;
        $this->reservationRepository = $reservationRepository;
    }

    /**
     * This function verify if there are rooms available, this only to reservation
     * which needs a room, for example: hotel, daycare
     *
     * @param  $start_date
     * @param  $end_date
     * @param  $room_category
     * @return \App\Models\Response $response
     */
    public function check_availability( $start_date, $end_date, $room_category ) {

        Log::info('Checking room availability...');

        $rooms = null;
        $reserved_rooms = null;
        try {
            //Count the number of rooms available of given category
            //the room must be active (status = 1)
            $rooms = Room::where('category_id', $room_category)->
                           where('status', 1)->get()->
                           count();

            //Use '<' if you want accept reservation whose end in the same day
            //when the room is leave and other reservation is coming in the same day
            //Use '<=' if you don't want accept reservation which end in the same day other
            //reservation starts.
            $reserved_rooms = Reservation::where('start_date', '<', $end_date)->
                                           where('end_date', '>=', $start_date)->
                                           with('room:id,category_id')->get()->
                                           where('room.category_id', '=', $room_category)->
                                           count();

            Log::info('Rooms available by category given: ' . $rooms);
            Log::info('Rooms of specific category reserved between given date: ' . $reserved_rooms);
        } catch (\Exception $e) {
            Log::error('Something went wrong while checking availability. Details: '.$e);
            $this->response->setOk(false);
            $this->response->setMessage($e);
            return $this->response;
        }

        //If rooms available are grater than rooms reserved it means there still room to
        //take the reservation
        if ($rooms > $reserved_rooms) {
            $this->response->setOk(true);
        } else {
            $this->response->setOk(false);
            $this->response->setMessage('Could not create this reservation. Details: There are not rooms available.');
            $this->response->setStatusCode(200);
        }

        return $this->response;
    }

    /**
     * Service to create a new reservation, after validate data input in Request class
     * Controller pass the Request to this tier, here are applied some business rules.
     *
     * @param array $reservation
     * @param int $user_id
     * @return \App\Models\Response $response
     */
    public function create( array $reservation, $user_id )
    {
        $dog_id = $reservation['dog_id'];
        $dog = null;

        $this->response = $this->dogValidator->exists($dog_id);
        if ($this->response->getOk()) {
            $dog = Dog::with('size:id,name')->find($dog_id);
            Log::info('Dog size: '.$dog->size->id);
        } else {
            Log::error('Dog does not exists!');
            return $this->response;
        }

        if ($this->check_availability( $reservation['start_date'],
                                       $reservation['end_date'],
                                       $dog->size->id)->getOk() ) {
            Log::info('There still rooms available :)');
            $this->response = $this->userValidator->exists($user_id);
            if ($this->response->getOk()) {
                Log::info('User exits :)');
                $user = $this->userService->get_by_id($user_id)->getData();
                if ($user->hasRole('admin')) {
                    Log::info('This user has admin role!');
                    $this->response->setOk(true);
                } elseif($user->hasRole('user')) {
                    if (DogValidator::dog_belongs_user($user_id, $dog_id)) {
                        Log::info('This dog belong to this user :)');
                        $this->response->setOk(true);
                    } else {
                        $this->response->setOk(false);
                        $this->response->setMessage('Could not create this reservation. Details: This puppy does not belongs to this user.');
                        $this->response->setStatusCode(400);
                    }
                } elseif ($user->hasRole('guest')) {
                    Log::info('This user is guest!');
                    $this->response->setOk(true);
                }
            } else {
                Log::error("User does not exist!");
            }
        } else {
            Log::info('There are not rooms available :(');
        }

        return $this->response;
    }

    /**
     * Validations to update a reservation
     *
     * @param $reservation_id
     * @param $user_id
     * @return Response
     */
    public function update($reservation_id, $user_id)
    {
        $user = $this->userService->get_by_id($user_id);
        if (! $user->getOk()) {
            Log::error('User logged in does not exits.');
            return $user;
        }

        $reservation_exits = $this->exits($reservation_id);
        if (! $reservation_exits->getOk()){
            Log::error('Reservation to update does not exits.');
            return $reservation_exits;
        }
        Log::info('Reservation to update exits.');

        if ($user->getData()->hasRole('admin')) {
            Log::info('User logged in has admin role.');
            $this->response->setOk(true);
        } elseif($user->getData()->hasRole('user')) {
            Log::info('User logged in has user role.');
            $reservation_to_update = $this->reservationRepository->get_by_id($reservation_id)->getData();
            if ($reservation_to_update->user_id == $user_id) {
                $this->response->setOk(true);
            } else {
                $this->response->setOk(false);
                $this->response->setMessage('Can not update this reservation because does not belongs to this user.');
                $this->response->setStatusCode(200);
            }
        } else {
            Log::info('User has guest role.');
            $this->response->setOk(false);
            //TODO user guest can update reservations
        }

        return $this->response;
    }

    /**
     * Service to destroy a reservation, only user with admin role can perform this task.
     *
     * @param $reservation_id
     * @param $user_id
     * @return Response
     */
    public function destroy($reservation_id, $user_id)
    {
        $user = $this->userService->get_by_id($user_id);
        if (! $user->getOk()) {
            Log::error('User logged in does not exits.');
            return $user;
        }

        $reservation_exits = $this->exits($reservation_id);
        if (! $reservation_exits->getOk()){
            Log::error('Reservation to delete does not exits.');
            return $reservation_exits;
        }
        Log::info('Reservation to delete exits.');

        if ($user->getData()->hasRole('admin')) {
            Log::info('User logged in has admin role.');
            $this->response->setOk(true);
        } else {
            $this->response->setOk(false);
            $this->response->setMessage('Reservation can not be deleted, only admin can perform this task.');
            $this->response->setStatusCode(401);
        }

        return $this->response;
    }

    /**
     * If reservation exits return true else false
     *
     * @param $reservation_id
     * @return Response
     */
    public function exits($reservation_id)
    {
        return $this->reservationRepository->exits($reservation_id);
    }
}