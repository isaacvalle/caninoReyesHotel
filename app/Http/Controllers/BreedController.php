<?php

namespace App\Http\Controllers;

use App\Models\Breed;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;

class BreedController extends Controller
{
  /**
   * @param Request $request
   * @return Breed[]|\Illuminate\Database\Eloquent\Collection
   */
    public function index(Request $request)
    {
      Log::info('Controller - getting breeds.');
      return Breed::all('id', 'name');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Breed  $breed
     * @return \Illuminate\Http\Response
     */
    public function show(Breed $breed)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Breed  $breed
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Breed $breed)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Breed  $breed
     * @return \Illuminate\Http\Response
     */
    public function destroy(Breed $breed)
    {
        //
    }
}
