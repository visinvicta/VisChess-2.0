<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegistrationRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class RegisterController extends Controller
{
    public function create() {
        return view('register/create');
    }

    public function store(UserRegistrationRequest $request) {
        $validatedRequest = $request->validated(); 
        $user = User::create($validatedRequest);

        Auth::login($user);

        Session::flash('success', 'Your account has been created.');
        return redirect('/');
    }
}
