<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    public function __construct()
    {
//        $this->middleware('guest');
    }

    public function register()
    {
        if (auth()->user()) {
            return redirect(url('/panel/account'));
        }

        return view('auth.register');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:4', 'confirmed'],
        ]);
    }

    protected function registerStore(Request $data)
    {
        $user = User::create([
            'mobile' => $data['mobile'],
            'password' => Hash::make($data['password']),
        ]);

        Auth::login($user);

        return redirect(url('/panel/account'));
    }

    public function registerValidation(Request $request)
    {
        $rules = [
            'mobile' => ['required', 'unique:users,mobile', 'size:11'],
            'password' => ['required', 'string', 'min:4', 'confirmed'],
        ];

        $customMessages = [
            'mobile.required' => 'شماره همراه الزامی است.',
            'mobile.size' => 'شماره همراه را بطور صحیح وارد کنید.',
            'password.required' => 'کلمه عبور تحویل گیرنده الزامی است.',
        ];

        $this->validate($request, $rules, $customMessages);


        return response()->json(['key' => 'value'], 200);
    }
}
