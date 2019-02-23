<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReservation;
use App\Http\Requests\UpdateReservation;
use App\Service\ReservationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Log;

/**
 * @description  This class is the API entry point, this handle all events
 *               related to 'reservations' like create a new one, index reservations or
 *               get a specific one by id, update a reservation. This tier send the request
 *               to Service tier and it response with an Response object @see \App\Models\Response
 *               so in this tier are convert to a JSON format.
 *
 * @author Ing. Manuel Tapia <@manuel_30749@gmail.com>
 * @since  2019/01
 */
class ReservationController extends Controller
{
    /** @var ReservationService */
    private $reservationService;

    /**
     * ReservationController constructor.
     * @param ReservationService $reservationService
     */
    public function __construct(ReservationService $reservationService)
    {
        $this->reservationService = $reservationService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Get(
     *     path="api/reservations",
     *     summary="Get reservation from user",
     *     @OA\Response(
     *         response=405,
     *         description="Invalid input"
     *     )
     * )
     *
     */
    public function index(Request $request)
    {
        Log::info('Controller - reservation index endpoint has been called.');
        $response = $this->reservationService->index($request->user()->id);

        return Response::json([
            'message' => $response->getMessage(),
            'data' => $response->getData(),
            'status_code' => $response->getStatusCode(),
            'ok' => $response->getOk()
        ], $response->getStatusCode());
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreReservation $request
     * @return \Illuminate\Http\JsonResponse
     *
     *
     * @OA\Post(
     *     path="api/reservations",
     *     summary="Add a new reservation to the hotel",
     *     @OA\Response(
     *         response=405,
     *         description="Invalid input"
     *     )
     * )
     */
    public function store(StoreReservation $request)
    {
        Log::info('Controller - reservation store endpoint has been called.');
        $response = $this->reservationService->create($request->all(), $request->user()->id);

        return Response::json([
            'message' => $response->getMessage(),
            'data' => $response->getData(),
            'status_code' => $response->getStatusCode(),
            'ok' => $response->getOk()
        ], $response->getStatusCode());

    }

    /**
     *
     * Display the specified resource.
     *
     * @param  int  $reservation_id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @OA\Get(
     *     path="/api/reservations/{reservation_id}",
     *     summary="Get specific reservation",
     *     security={
     *      {"passport": {}},
     *     },
     *     @OA\Parameter(
     *          name="reservation_id",
     *          in="path",
     *          description="ID of Reservation to return",
     *          required=true,
     *          example=1,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Reservation"),
     *     )
     * )
     *
     *
     */
    public function show(Request $request, $reservation_id)
    {
        Log::info('Controller - reservation show endpoint has been called.');
        $response = $this->reservationService->show($request->user()->id, $reservation_id);

        return Response::json([
            'message' => $response->getMessage(),
            'data' => $response->getData(),
            'status_code' => $response->getStatusCode(),
            'ok' => $response->getOk()
        ], $response->getStatusCode());

    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateReservation $request
     * @param $reservation_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateReservation $request, $reservation_id)
    {
        Log::info('Controller - reservation update endpoint has been called.');
        $response = $this->reservationService->update($request->all(), $reservation_id, $request->user()->id);

        return Response::json([
            'message' => $response->getMessage(),
            'data' => $response->getData(),
            'status_code' => $response->getStatusCode(),
            'ok' => $response->getOk()
        ], $response->getStatusCode());

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param  int  $reservation_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $reservation_id)
    {
        Log::info('Controller - reservation destroy endpoint has been called.');
        $response = $this->reservationService->destroy($reservation_id, $request->user()->id);

        return Response::json([
            'message' => $response->getMessage(),
            'data' => $response->getData(),
            'status_code' => $response->getStatusCode(),
            'ok' => $response->getOk()
        ], $response->getStatusCode());
    }
}
