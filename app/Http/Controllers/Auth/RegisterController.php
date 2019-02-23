<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator($data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'mother_last_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:15'],
            'mobile' => ['required', 'string', 'max:15'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'picture' => ['url'],
        ]);
    }


    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Model\User
     */
    protected function create($data)
    {
        $validator = $this->validator($data);

        if ($validator->fails()) {
            return Response::json(array(
                'message' => 'Could not create new user.',
                'errors' => $validator->errors(),
                'status_code' => 400,
                'ok' => false
            ), 400);
        }

        $data = User::create([
            'name' => $data['name'],
            'last_name' => $data['last_name'],
            'mother_last_name' => $data['mother_last_name'],
            'phone' => $data['phone'],
            'mobile' => $data['mobile'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'picture' => $data['picture']
        ]);

        //$data->assignRole($data['role']);

        return $data;

        /*if ($data) {
            //return Response::json([
            //    'message' => 'The resource has been created successfully.',
            //    'status_code' => 200,
            //    'ok' => true
            //], 200);
            
         } else {
            return Response::json(array(
                'message' => 'Could not create new user.',
                'status_code' => 500,
                'ok' => false
            ), 500);
         }*/
    }

    /**
     * Log in a user.
     *
     * @param  Request  $request
     * @param  User  $user
     * @return json
     */
    /*protected function registered(Request $request, User $user) {
        $user->generateToken();

        return response()->json(['data' => $user->toArray()], 201);
    }*/
}
