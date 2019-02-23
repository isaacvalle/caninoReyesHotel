<?php

namespace App\Service;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

use App\Repositories\ReservationRepository;

use App\Helpers\ReservationValidator;
use App\Helpers\DogValidator;

use App\Models\Dog;
use App\Models\Room;
use App\Models\Reservation;
use App\Models\Service;
use App\Models\Response;

/**
 * @description  This class provide all services to the controller, this
 *               layer call to Validators and Repositories.
 *
 * @author Ing. Manuel Tapia <@manuel30749@gmail.com>
 * @since  2019/02
 */
class ReservationService
{
    /** @var ReservationValidator */
    private $reservationValidator;

    /** @var ReservationRepository */
    private $reservationRepository;

    /** @var DogValidator */
    private $dogValidator;

    /** @var UserService */
    private $userService;

    /**
     * ReservationService constructor.
     * @param ReservationValidator $reservationValidator
     * @param ReservationRepository $reservationRepository
     * @param DogValidator $dogValidator
     * @param UserService $userService
     */
    public function __construct(
        ReservationValidator $reservationValidator,
        ReservationRepository $reservationRepository,
        DogValidator $dogValidator,
        UserService $userService
    ) {
        $this->reservationValidator = $reservationValidator;
        $this->reservationRepository = $reservationRepository;
        $this->dogValidator = $dogValidator;
        $this->userService = $userService;
    }

    /**
     * Service to show all reservations related to a user, in case user has admin role
     * show all reservations.
     *
     * @param $user_id
     * @return Response
     */
    public function index($user_id)
    {
        $user = $this->userService->get_by_id($user_id)->getData();
        $response = new Response();

        $reservations = null;
        if ($user->hasRole('admin')) {
            $reservations = Reservation::with('dog:id,name')->
                                         with('service:id,name')->get();
        } else {
            $reservations = Reservation::with('dog:id,name')->
                                         with('service:id,name')->
                                         where('user_id', '=', $user_id)->get();
        }

        $response->setMessage('Reservations gotten.');
        $response->setStatusCode(200);
        $response->setData($reservations->toArray());
        $response->setOk(true);

        if(count($reservations) == 0) {
            $response->setMessage('This user do not have any reservation.');
            $response->setStatusCode(200);
            $response->setOk(true);
        }

        return $response;
    }

    /**
     * Service to create a new reservation, after validate data input in Request class
     * Controller pass the Request to this tie, here are applied some business rules.
     *
     * @param array $reservation
     * @param int $user_id
     * @return \App\Models\Response $response
     */
    public function create(array $reservation, $user_id)
    {
        $continue = true;
        $response = $this->reservationValidator->create($reservation, $user_id);
        if($response->getOk()) {
            foreach ($reservation['services'] as $service) {
                if ($continue) {
                    Log::info('Service: ' . $service['name']);
                    switch ($service['name']) {
                        case Config::get('hcrConfig.services.hotel'):

                            Log::info('Hotel service - starts validation...');
                            $response = $this->make_reservation($reservation, $service['name'], $user_id);
                            $continue = $response->getOk();
                            break;

                        case Config::get('hcrConfig.services.shower'):
                        case Config::get('hcrConfig.services.roundHomeService'):
                        case Config::get('hcrConfig.services.simpleHomeService'):

                            Log::info('Home service - starts');
                            $response = $this->make_reservation($reservation, $service['name'], $user_id);
                            $continue = $response->getOk();
                            break;
                    }
                }
            }
        } else {
            Log::error('Something went wrong while validating the reservation.');
        }

        return $response;

    }

    /**
     * Service to show specific reservation, if the user which is requesting it
     * has admin role show any reservation, otherwise if user does not has admin role
     * only will show the reservation if it belongs to that user.
     *
     * @param $user_id
     * @param $reservation_id
     * @return Response
     */
    public function show($user_id, $reservation_id)
    {
        $user = $this->userService->get_by_id($user_id)->getData();

        $response = new Response();

        if ($user->hasRole('admin')) {
            $reservation = Reservation::find($reservation_id);
            if($reservation) {
                $response->setMessage('Reservation gotten.');
                $response->setData($reservation->toArray());
                $response->setStatusCode(200);
                $response->setOk(true);
            } else {
                $response->setMessage('This reservation does not exits.');
                $response->setStatusCode(404);
                $response->setOk(true);
            }
        } else {
            $reservation = Reservation::find($reservation_id);
            if ($reservation) {
                if ($reservation->user_id == $user_id) {
                    $response->setMessage('Reservation gotten.');
                    $response->setData($reservation->toArray());
                    $response->setStatusCode(200);
                    $response->setOk(true);
                } else {
                    $response->setMessage('This reservation does not belongs to this user.');
                    $response->setStatusCode(200);
                    $response->setOk(true);
                }
            } else {
                $response->setMessage('This reservation does not exits.');
                $response->setStatusCode(404);
                $response->setOk(true);
            }
        }
        return $response;
    }

    /**
     * Service to update a reservation
     *
     * @param array $reservation
     * @param $reservation_id
     * @param $user_id
     * @return Response
     */
    public function update(array $reservation, $reservation_id, $user_id)
    {
        Log::info('Begin reservation update.');

        Log::debug('with arguments, reservation id: '. $reservation_id .', user id: '.$user_id);

        $response = $this->reservationValidator->update($reservation_id, $user_id);
        if($response->getOk()) {
            $response = $this->reservationRepository->update($reservation_id, $reservation);
        }

        return $response;
    }

    /**
     * Service to delete a reservation.
     *
     * @param $reservation_id
     * @param $user_id
     * @return Response
     */
    public function destroy($reservation_id, $user_id)
    {
        Log::info('Service - Begin destroy reservation.');

        Log::debug('with arguments, reservation id: '. $reservation_id .', user id: '.$user_id);

        $response = $this->reservationValidator->destroy($reservation_id, $user_id);

        if ($response->getOk()) {
            $response = $this->reservationRepository->destroy($reservation_id);
        }

        return $response;
    }

    /**
     * This function assign a new room to the request reservation, to do this
     * check what is the dog_size, after that get all rooms which has the same
     * category, later, find reservation which use rooms with this category,
     * to finish look for that rooms which aren't in the reserved and take the first.
     *
     * @param  array $reservation
     * @param  String $room_category
     * @return array $reservation
     */
    private function assign_room($reservation, $room_category)
    {
        Log::info('Getting a room...');
        $end_date = $reservation['end_date'];
        $start_date = $reservation['start_date'];

        $rooms_by_category = Room::where('category_id', $room_category)->
                                   where('status', 1)->get();

        Log::info('Rooms for this category: '.$rooms_by_category);

        $reserved_rooms = Reservation::where('start_date', '<', $end_date)->
                                       where('end_date', '>=', $start_date)->
                                       where('room_id', '!=', null)->
                                       with('room:id,category_id')->get()->
                                       where('room.category_id', '=', $room_category);

        Log::info('Rooms reserved for this category: '.$reserved_rooms);

        $rooms_id[] = null;
        for ($i = 0; $i < $reserved_rooms->count(); $i++) {
            $rooms_id[$i] = $reserved_rooms[$i]->room_id;
        }
        $room = $rooms_by_category->whereNotIn('id', $rooms_id)->first();
        $reservation['room_id'] = $room->id;

        return $reservation;
    }

    /**
     * Function set service.
     *
     * @param  array $reservation
     * @param  String $service
     * @param  String $dog_size
     * @param  String $locality
     * @return array $reservation
     */
    private function set_service($reservation, $service, $dog_size, $locality) {

        $service_id = null;
        if ($service == Config::get('hcrConfig.services.roundHomeService') || $service == Config::get('hcrConfig.services.simpleHomeService')) {
            $service_id = Service::where('name', '=', $service.'-'.$locality)->get();
            Log::info('Service id to: '.$service.'-'.$locality.' is: '.$service_id[0]->id);
            $reservation['service_id'] = $service_id[0]->id;
            return $reservation;
        }
        if ($service == Config::get('hcrConfig.services.shower')) {
            $service_id = Service::where('name', '=', $service)->get();
            Log::info('Service id to: '.$service.' is: '.$service_id[0]->id);
            $reservation['service_id'] = $service_id[0]->id;
            return $reservation;
        }

        $service_id = Service::where('name', '=', $service.'-'.$dog_size)->get();
        Log::info('Service id to '.$service.'-'.$dog_size.' is: '.$service_id[0]->id);
        $reservation['service_id'] = $service_id[0]->id;

        return $reservation;
    }

    /**
     * After some validations this function create the reservation.
     *
     * @param array $reservation
     * @param String $service
     * @param int $user_id
     * @return \App\Models\Response $response
     */
    private function make_reservation($reservation, $service, $user_id)
    {
        $dog = Dog::with('size:id,name')->find($reservation['dog_id']);

        $user_locality = null;

        $user = $this->userService->get_by_id($user_id)->getData();
        $reservation['user_id'] = $user->hasRole('admin') ? $dog->user_id : $user_id;

        if ($service == Config::get('hcrConfig.services.hotel') || $service == Config::get('hcrConfig.services.daycare')) {
            $reservation = $this->assign_room($reservation, $dog->size->id);
            Log::info('Room assigned: '.$reservation['room_id']);

        } elseif ($service == Config::get('hcrConfig.services.roundHomeService') || $service == Config::get('hcrConfig.services.simpleHomeService')) {
            $user_locality = $user->hasRole('admin') ? $this->userService->get_locality($dog->user_id) :
                                                       $this->userService->get_locality($user_id);
        }

        $reservation = $this->set_service($reservation, $service, $dog->size->name, $user_locality);
        $reservation['status_id'] = 1;

        return $this->reservationRepository->create($reservation);
    }
}