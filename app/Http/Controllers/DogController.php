<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDog;
use App\Http\Requests\UpdateDog;
use App\Service\DogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Log;

use App\Models\Dog;
/**
 * @description  This class is the API entry point, this handle all services
 *               related to 'dogs' like insert a new dog, index dogs or
 *               get a specific one by id, delete one dog by id and update it 
 *               as well. All requests are validated before perform some action.
 *
 * @author Ing. Manuel Tapia - @manuel_30749
 * @since  2018/12
 */
class DogController extends Controller
{
    /** @var $dogService */
    private $dogService;

    /**
     * DogController constructor.
     * @param DogService $dogService
     */
    public function __construct(DogService $dogService)
    {
        $this->dogService = $dogService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        //to paginate the results
        //$dog = Dog::paginate(9);

        Log::info('Controller - dog index endpoint has been called.');
        $response = $this->dogService->index($request->user()->id);

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
     * @param StoreDog $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreDog $request)
    {
        Log::info('Controller - dog store endpoint has been called.');
        $response = $this->dogService->store($request->all(), $request->user()->id);

        return Response::json([
            'message' => $response->getMessage(),
            'data' => $response->getData(),
            'status_code' => $response->getStatusCode(),
            'ok' => $response->getOk()
        ], $response->getStatusCode());
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param int $dog_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $dog_id)
    {
        Log::info('Controller - dog store endpoint has been called.');
        $response = $this->dogService->show($request->user()->id, $dog_id);

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
     * @param UpdateDog $request
     * @param $dog_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateDog $request, $dog_id)
    {

        Log::info('Controller - dog update endpoint has been called.');
        $response = $this->dogService->update($request->all(), $dog_id, $request->user()->id);

        return Response::json([
            'message' => $response->getMessage(),
            'data' => $response->getData(),
            'status_code' => $response->getStatusCode(),
            'ok' => $response->getOk()
        ], $response->getStatusCode());

        $dog = Dog::find($id);
        if (!$dog) {
            return Response::json(array(
                'message' => 'Could not find this (' . $id . ') puppy :(',
                'status_code' => 404,
                'ok' => false
            ), 404);
        }

        $input = $request->all();

        $validator = $this->validator_update($input);

        if ($validator->fails()) {

            return Response::json(array(
                'message' => 'Could not update this dog.',
                'errors' => $validator->errors(),
                'status_code' => 400,
                'ok' => false
            ), 400);
        }

        /*if ($input['status'] !== $dog['status']) {

            $reservation = 'App\Reservation'::where('dog_id', $id)->where('status_id', 1);                                         
            if($reservation) {
                return Response::json(array(
                    'message' => 'Could not change this dog\'s status due this dog has an active reservation.',
                    'status_code' => 500,
                    'ok' => false  
                ), 500);
            }
        }*/

        $input['updated_at'] = \Carbon\Carbon::now()->format('Y-m-d H:i:s');

        $dog->fill($input);

        if ($dog->save()) {
            return Response::json(array(
                'message' => 'This puppy has been updated successfully :)',
                'status_code' => 200,
                'ok' => true
            ), 200);
        } else {
            return Response::json(array(
                'message' => 'Could not update this dog.',
                'status_code' => 500,
                'ok' => false
            ), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Log::info('Getting in dog destroy service...');
        Log::info('Dog id to delete: '.$id);

        $dog = Dog::find($id);

        if (!$dog) {
            Log::error('Dog with id '.$id.' could not be find in DB');
            return Response::json(array(
                'message' => 'Could not find this (' . $id . ') puppy :(',
                'status_code' => 404,
                'ok' => false 
            ), 404);
        }

        if ($dog->delete()) {
            Log::warning('Dog with id: '.$id.' has been deleted.');
            return Response::json(array(
                'message' => 'This puppy has been deleted successfully :)',
                'status_code' => 200,
                'ok' => true
            ), 200);
        } else {
            Log::error('Dog with id '.$id.' could not be delete due internal error.');
            return Response::json(array(
                'message' => 'Could not delete this dog.',
                'status_code' => 500,
                'ok' => false
            ), 500);
        }
    }
}
