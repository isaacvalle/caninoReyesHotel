<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;

use App\Reservation;
use App\User;
use App\UserAddress;
use App\Dog;
use App\Room;
use App\Service;
use App\Municipality;
/**
 * @description  This class is the API entry point, this handle all services
 *               related to 'reservations' like create a new one, index reservations or
 *               get a specific one by id, update a reservation. All requests are 
 *               validated before perform some action.
 *
 * @author Ing. Manuel Tapia - @manuel_30749
 * @since  2019/01
 */
class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $reservation = $request->all();    
        $continue = true;
        foreach ($reservation['services'] as $service){
            Log::info('Service: '.$service['name']);            
            if ($continue) {
                switch ($service['name']) {
                    case Config::get('hcrConfig.services.hotel'):
                        Log::info('Hotel service - starts validation...');
                        $request_validation = $this->request_validation_need_room($reservation);
                        if ($request_validation->fails()) {
                            return Response::json(array(
                                'message' => 'Could not create this reservation.',
                                'errors' => $request_validation->errors(),
                                'status_code' => 400,
                                'ok' => false
                            ), 400);
                        } else {
                            Log::info('Validation was successful!');
                            $validation = $this->make_reservation_validations($reservation);
                            if ($validation) {
                                $continue = $this->make_reservation($reservation, $service['name']);
                            }
                        }
                        break;
                    case Config::get('hcrConfig.services.roundHomeService'):
                    case Config::get('hcrConfig.services.simpleHomeService'):
                        Log::info('Home service - starts');
                        $continue = $this->make_reservation($reservation, $service['name']);
                        break;
                }
            }
        }
    }

    private function make_reservation_validations($reservation) {

        $dog = null;
        if ($this->check_dog_exists($reservation)) { 
            $dog = Dog::with('size:id,name')->find($reservation['dog_id']);
            Log::info('Dog size: '.$dog->size->id);
        } else {
            Log::error("User does not exists!");
            /*return Response::json(array(
                        'message' => 'Could not create this reservation. Details: Dog received does not exists.',
                        'status_code' => 404,
                        'ok' => false
                    ), 404);*/
            return false;
        }

        if ($this->check_availability($reservation['start_date'], $reservation['end_date'], $dog->size->id)) {
            Log::info('There still rooms availables :)');
            if ($this->check_user_exists($reservation)) {
                if ($this->check_dog_belongs_user($reservation)) {
                    return true;
                } else {
                    $user = User::find($reservation['user_id']);
                    if ($user->hasRole('admin')) {
                        Log::info('This user has a admin role!');
                        return true;
                    } elseif ($user->hasRole('guest')) {
                        Log::info('This user has a guest role!');
                        return true;
                    }
                    /*return Response::json(array(
                            'message' => 'Could not create this reservation. Details: This puppy does not belongs to this user.',
                            'status_code' => 400,
                            'ok' => false
                        ), 400);*/
                    return false;
                }
            } else {
                Log::error("User does not exists!");
                /*return Response::json(array(
                            'message' => 'Could not create this reservation. Details: User received does not exists.',
                            'status_code' => 404,
                            'ok' => false
                        ), 404);*/
                return false;
            }
        } else {
            Log::info('There are not rooms availables :(');
            /*return Response::json(array(
                            'message' => 'Could not create this reservation. Details: User received does not exists.',
                            'status_code' => 404,
                            'ok' => false
                        ), 404);*/
            return false;
        }
                

    }

    /**
     * Function to create a new reservation.
     *
     * @param  array $reservation
     * @param  String $service
     * @return json
     */
    private function make_reservation($reservation, $service) {

        $dog = Dog::with('size:id,name')->find($reservation['dog_id']);
        
        $user_locality = null;
        if ($service == Config::get('hcrConfig.services.hotel') || $service == Config::get('hcrConfig.services.daycare')) {
            $reservation = $this->assing_room($reservation, $dog->size->id);
            Log::info('Room assigned: '.$reservation['room_id']);
        } elseif ($service == Config::get('hcrConfig.services.roundHomeService') || $service == Config::get('hcrConfig.services.simpleHomeService')) {
            $user_locality = $this->get_user_locality($reservation['user_id']);
        }                           
        
        $reservation = $this->set_service($reservation, $service, $dog->size->name, $user_locality);

        $reservation['status_id'] = 1;
        if (Reservation::create($reservation)) {
            Log::info('Reservation done! :)');
            /*return Response::json([
                    'message' => 'The reservation has been created successfully :)',
                    'status_code' => 200,
                    'ok' => true
                ], 200);*/
            return true;
        } else {
            /*return Response::json(array(
                'message' => 'Could not create this reservation.',
                'status_code' => 500,
                'ok' => false
            ), 500);*/
            return false;
        }
    }


    /**
     * Function set a service.
     *
     * @param  array $reservation
     * @param  String $service
     * @param  String $dog_size
     * @param  String $locality
     * @return json
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
     * This function assign a new room to the request reservation, to do this
     * check what is the dog_size, after that get all rooms which has the same
     * category, later, find reservation which use rooms with this category,
     * to finish look for that rooms which aren't in the reservated and take the first.
     *
     * @param  array $reservation
     * @param  String $room_category
     * @return array
     */
    private function assing_room($reservation, $room_category) {

        Log::info('Getting a room...');
        $end_date = $reservation['end_date'];
        $start_date = $reservation['start_date'];

        $rooms_by_categroy = Room::where('category_id', $room_category)->
                                   where('status', 1)->get();

        Log::info('Rooms for this category: '.$rooms_by_categroy);

        $reserved_rooms = Reservation::where('start_date', '<', $end_date)->
                                       where('end_date', '>=', $start_date)->
                                       with('room:id,category_id')->get()->
                                       where('room.category_id', '=', $room_category);

        Log::info('Rooms reserved for this category: '.$reserved_rooms);

        $rooms_id[] = null;
        for ($i = 0; $i < $reserved_rooms->count(); $i++) {
            $rooms_id[$i] = $reserved_rooms[$i]->room_id;            
        }
        $room = $rooms_by_categroy->whereNotIn('id', $rooms_id)->first();
        $reservation['room_id'] = $room->id;

        return $reservation;     
    }

    /**
     * This function helps to get the user's locality.
     * 
     *
     * @param  int $user
     * @return String
     */
    private function get_user_locality($user) {

        $user_data = UserAddress::with('address:id,municipality_id')->where('user_id', '=', $user)->get();
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
        return null;        
    }

    /**
     * This function verify if the dog in the request exists.
     * 
     *
     * @param  array $reservation
     * @return bool
     */
    private function check_dog_exists($reservation) {

        $dog = $reservation['dog_id'];
        Log::info('Validating if id: '.$dog.' dog exists.');
        if(Dog::find($dog)) {
            Log::info('Dog exists!');
            return true;
        }
        Log::info('Dog does not exists!');

        return false;
    }

    /**
     * This function verify if the user in the request exists.
     * 
     *
     * @param  array $reservation
     * @return bool
     */
    private function check_user_exists($reservation) {

        $user = $reservation['user_id'];
        Log::info('Validating if id: '.$user.' user exists.');

        if (User::find($user)) {
            Log::info('User exists!');
            return true;
        }        
        Log::info('User not exists :(');

        return false;
    }

    /**
     * This function verify if the dog in the request belongs to the user.
     * 
     *
     * @param  array $reservation
     * @return bool
     */
    private function check_dog_belongs_user($reservation) {

        $user_dogs = User::find($reservation['user_id']);
                  
        foreach ($user_dogs->dogs as $dog){
            Log::info('Dog (id) belongs to this user: '.$dog->id); 
        }

        Log::info('Dog (id) received: '.$reservation['dog_id']);

        if ($user_dogs->dogs->contains($reservation['dog_id'])) {
            Log::info('This puppy belongs to this user.');
            return true;
        }
        Log::info('This puppy does not belongs to this user.');

        return false;       
    }

    /**
     * This function verify if there are rooms available, this only to reservation
     * which needs a room, for example: hotel, daycare
     *
     * @param  array $reservation
     * @return bool
     */
    private function check_availability($start_date, $end_date, $room_category) {

        Log::info('Checking availability...');

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

        Log::info('Rooms available by categroy given: ' . $rooms);
        Log::info('Rooms of specific category reserved between given date: ' . $reserved_rooms);

        //If rooms availables are grater than rooms reserved it means there still room to
        //take the reservation
        if ($rooms > $reserved_rooms) {
            return true;
        }

        return false;       
    }

    private function request_validation_need_room($data) {

        return Validator::make($data, [
            'user_id' => 'bail|required|numeric',
            'dog_id' => 'bail|required|numeric',
            'start_date' => 'bail|required|date_format:Y-m-d H:i',
            'end_date' => 'bail|required|date_format:Y-m-d H:i|after:start_date',
            'services' => 'bail|required|array'
        ]);
    }

    private function request_validation($data) {

        return Validator::make($data, [
            'user_id' => 'bail|required|numeric',
            'dog_id' => 'bail|required|numeric',
            'start_date' => 'bail|required|date_format:Y-m-d H:i',
            'end_date' => 'bail|required|date_format:Y-m-d H:i|after:start_date',
            'service_id' => 'bail|required|numeric',
            'status_id' => 'bail|required|numeric',
            'room_id' => 'bail|required|numeric'
        ]);
    }

    private function user_validation($data) {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
