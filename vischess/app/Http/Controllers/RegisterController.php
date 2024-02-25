<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Session;

class RegisterController extends Controller
{
    public function create() {
        return view('register/create');
    }

    public function store() {

        $requestData = request()->validate([
            'username' => ['required', 'min:3', 'max:20', Rule::unique('users', 'username')],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'min:8', 'max:20']
        ]);

        $requestData['password'] = bcrypt($requestData['password']);

        $user = User::create($requestData);

        auth()->login($user);

        Session::flash('success', 'Your account has been created.');

        return redirect('/');
    }
}
