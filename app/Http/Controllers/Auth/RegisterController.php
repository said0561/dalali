<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'phone' => [
                'required', 
                'string', 
                'unique:users', 
                'regex:/^255[0-9]{9}$/' // Lazima ianze na 255 na iwe na namba 12
            ],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'phone.regex' => 'Namba ya simu lazima ianze na 255 na iwe na jumla ya namba 12 (Mfano: 2557XXXXXXXX).',
            'phone.unique' => 'Namba hii tayari imesajiliwa.',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        // Tunatafuta ID ya Role ya 'broker' kutoka kwenye database
        $brokerRole = \App\Models\Role::where('name', 'broker')->first();

        return \App\Models\User::create([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'password' => \Hash::make($data['password']),
            'role_id' => $brokerRole->id, // Hapa anakuwa Dalali moja kwa moja
            'region_id' => $data['region_id'],
            'subscription_until' => now()->addDays(30), // Anapata wiki moja ya bure
        ]);
    }
}
