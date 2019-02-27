<?php

namespace App\Http\Controllers;

use App\Models\SizeCategory;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;

class SizeCategoryController extends Controller
{
  /**
   * @param Request $request
   * @return SizeCategory[]|\Illuminate\Database\Eloquent\Collection
   */
    public function index(Request $request)
    {
      Log::info('Controller - getting zise-categories.');
      return SizeCategory::all('id', 'name');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SizeCategory  $sizeCategory
     * @return \Illuminate\Http\Response
     */
    public function show(SizeCategory $sizeCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SizeCategory  $sizeCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(SizeCategory $sizeCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SizeCategory  $sizeCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SizeCategory $sizeCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SizeCategory  $sizeCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(SizeCategory $sizeCategory)
    {
        //
    }
}
