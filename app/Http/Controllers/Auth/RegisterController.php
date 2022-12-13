<?php

namespace App\Http\Controllers\Auth;

use App\Channels\SMSChannel;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\PhoneBook;
use App\Models\UserCountry;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use App\Services\InforuSMSService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

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
    protected $redirectTo = RouteServiceProvider::HOME;

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
            'fullname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
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
        $send = User::create([
            'fullname' => $data['fullname'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        
        if($send)
        {
            $user_id = $send->id;                        
            $user_country = new UserCountry();
            $user_country->user_id = $user_id;
            $user_country->countryname = $data['countryName'];
            $user_country->countrycode = $data['countryCode'];            
            $user_country->save();

           
            $phone_book = new PhoneBook();
            $phone_book->user_id = $user_id;
            $phone_book->phonenumber = $data['phoneNumber'];                
            $phone_book->save();           
            
            $sms_channel = new InforuSMSService();            
            $msg = "Welcome to the team";
            $send_msg = $sms_channel->sendMessage($data['phoneNumber'],$msg);

        }
        

       
    }
}
