<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 * @OA\Info(
 *     title="Hotel Canino Reyes API",
 *     version="0.1",
 *     @OA\Contact(
 *      name="Manuel Tapia",
 *      url="https://google.com"
 *     )
 * )
 *
 * @OA\SecurityScheme(
 *     type="oauth2",
 *     name="passport",
 *     securityScheme="passport",
 *     @OA\Flow(
 *         flow="password",
 *         tokenUrl="http://localhost:8000/oauth/token",
 *         scopes={}
 *     )
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
