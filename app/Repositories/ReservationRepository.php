<?php

namespace App\Repositories;


use App\Models\Reservation;
use Illuminate\Support\Facades\Log;
use App\Models\Response;

/**
 * @description  This class manage all the queries related to Reservation
 *
 * @author Ing. Manuel Tapia - @manuel_30749
 * @since  2019/02
 * @package App\Repositories
 */
class ReservationRepository
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

    /**
     * Create a new reservation
     *
     * @param array $reservation
     * @return Response
     */
    public function create(array $reservation) {

        $result = null;

        try {
            $result = Reservation::create($reservation);

            if ($result) {
                $this->response->setMessage('Reservation created successfully.');
                $this->response->setData($result);
                $this->response->setOk(true);
                $this->response->setStatusCode(200);
            } else {
                $this->response->setMessage('Something went wrong while creating the reservation.');
                $this->response->setData($result);
                $this->response->setOk(false);
                $this->response->setStatusCode(500);
            }
        } catch (\Exception $e) {
            $this->response->setMessage('Something went wrong: '.$e);
            $this->response->setOk(false);
            $this->response->setStatusCode(500);
            Log::error('Reservation could not be create: ' . $e);
        }

        return $this->response;
    }

    /**
     * Repository which update a resource.
     *
     * @param $reservation_id
     * @param $reservation
     * @return Response
     */
    public function update($reservation_id, $reservation)
    {
        Log::info('Updating reservation...');
        Log::debug('data received at repository tier, reservation_id: '.$reservation_id);
        try {
            $reservation_to_update = $this->get_by_id($reservation_id)->getData();
            $result = $reservation_to_update->update($reservation);
            if ($result){
                $this->response->setMessage('Reservation has been updated successfully.');
                $this->response->setStatusCode(200);
                $this->response->setData($this->get_by_id($reservation_id)->getData()->toArray());
                $this->response->setOk(true);
            } else {
                $this->response->setMessage('Reservation has not been updated.');
                $this->response->setStatusCode(500);
                $this->response->setOk(false);
            }
        } catch(\Exception $e){
            Log::error('An exception has been thrown while trying to update the reservation. Details: '.$e);
            $this->response->setMessage('Reservation has not been updated.');
            $this->response->setStatusCode(500);
            $this->response->setOk(false);
        }

        return $this->response;
    }

    /**
     * Repository to delete reservation.
     *
     * @param $reservation_id
     * @return Response
     */
    public function destroy($reservation_id)
    {
        Log::info('Repository - Deleting reservation...');
        Log::debug('data received at repository tier, reservation_id: '.$reservation_id);

        try {
            $reservation_to_delete = $this->get_by_id($reservation_id)->getData();
            $result = $reservation_to_delete->delete();

            if ($result){
                $this->response->setMessage('Reservation has been deleted successfully.');
                $this->response->setStatusCode(200);
                $this->response->setOk(true);
            } else {
                $this->response->setMessage('Reservation has not been deleted.');
                $this->response->setStatusCode(500);
                $this->response->setOk(false);
            }
        } catch(\Exception $e){
            Log::error('An exception has been thrown while trying to delete the reservation. Details: '.$e);
            $this->response->setMessage('Reservation has not been deleted.');
            $this->response->setStatusCode(500);
            $this->response->setOk(false);
        }

        return $this->response;
    }

    /**
     * Check if reservation exits
     *
     * @param $reservation_id
     * @return Response
     */
    public function exits($reservation_id)
    {
        try {
            if (Reservation::find($reservation_id)) {
                $this->response->setOk(true);
            } else {
                $this->response->setMessage('Reservation does not exits.');
                $this->response->setOk(false);
                $this->response->setStatusCode(404);
            }
        } catch (\Exception $e) {
            Log::error('An exception was thrown while validating if reservation exits. Details: '.$e);
            $this->response->setMessage('An exception was thrown while validating if reservation exits.');
            $this->response->setOk(false);
            $this->response->setStatusCode(500);
        }

        return $this->response;
    }

    /**
     * Get a reservation by id given
     *
     * @param $reservation_id
     * @return Response
     */
    public function get_by_id($reservation_id)
    {
        try {
            $reservation = Reservation::find($reservation_id);
            if ($reservation) {
                $this->response->setOk(true);
                $this->response->setData($reservation);
            } else {
                $this->response->setMessage('Reservation does not exits.');
                $this->response->setOk(false);
                $this->response->setStatusCode(404);
            }
        } catch (\Exception $e) {
            Log::error('An exception was thrown while getting a reservation. Details: '.$e);
            $this->response->setMessage('An exception was thrown while validating if reservation exits.');
            $this->response->setOk(false);
            $this->response->setStatusCode(500);
        }

        return $this->response;
    }

}