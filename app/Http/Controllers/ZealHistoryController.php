<?php

namespace App\Http\Controllers;

use App\Models\ZealHistory;
use Illuminate\Http\Request;

class ZealHistoryController extends Controller
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
        $zeal_history = $request->all();

        $validator = $this->validator_create($request);

        if($validator->fails()) {

            return Response::json(array(
                'message' => 'Invalid zeal_history format, verify.',
                'errors' => $validator->errors(),
                'status_code' => 400,
                'ok' => false
            ), 400);
        }

        if (ZealHistory::create($zeal_history)) {
            return Response::json(array(
                'message' => 'Zeal date inserted.',
                'status_code' => '200',
                'ok' => true
            ), 200);
        } else  {
            return Response::json(array(
                'message' => 'Could not create this zeal record.',
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
            'observations' => 'bail|required|string|min:10|max:255',
            'dog_id' => 'bail|required|numeric'
        ]);
    } 

    /**
     * Display the specified resource.
     *
     * @param  \App\ZealHistory  $zealHistory
     * @return \Illuminate\Http\Response
     */
    public function show(ZealHistory $zealHistory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ZealHistory  $zealHistory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ZealHistory $zealHistory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ZealHistory  $zealHistory
     * @return \Illuminate\Http\Response
     */
    public function destroy(ZealHistory $zealHistory)
    {
        //
    }
}
