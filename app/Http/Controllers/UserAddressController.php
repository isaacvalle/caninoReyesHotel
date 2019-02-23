<?php

namespace App\Http\Controllers;

use App\Models\Municipality;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;

class UserAddressController extends Controller
{
    /**
     * @param Request $request
     * @return Municipality[]|\Illuminate\Database\Eloquent\Collection
     */
    public function index(Request $request)
    {
        Log::info('Controller - getting municipalities.');

        return Municipality::all('id','name');

    }
}
