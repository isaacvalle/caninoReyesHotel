<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\WeightHistory;
class WeightHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $weight_history = $request->all();

        $validator = $this->validator_create($request);

        if($validator->fails()) {

            return Response::json(array(
                'message' => 'Invalid weight_history format, verify.',
                'errors' => $validator->errors(),
                'status_code' => 400,
                'ok' => false
            ), 400);
        }

        if (WeightHistory::create($weight_history)) {
            return Response::json(array(
                'message' => 'Weight date inserted.',
                'status_code' => '200',
                'ok' => true
            ), 200);
        } else  {
            return Response::json(array(
                'message' => 'Could not create this weight record.',
                'status_code' => 500,
                'ok' => false
            ), 500);
        }
    }

    /**
     * Function to validate input data
     *
     * @param type $data
     * @return type
     */
    private function validator_create($data) {
        
        return Validator::make($data, [
            'date' => 'bail|required|date_format:Y-m-d',
            'weight' => 'bail|required|numeric',
            'dog_id' => 'bail|required|numeric'
        ]);
    } 

    /**
     * Display the specified resource.
     *
     * @param  \App\WeightHistory  $weightHistory
     * @return \Illuminate\Http\Response
     */
    public function show(WeightHistory $weightHistory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\WeightHistory  $weightHistory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WeightHistory $weightHistory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\WeightHistory  $weightHistory
     * @return \Illuminate\Http\Response
     */
    public function destroy(WeightHistory $weightHistory)
    {
        //
    }
}
