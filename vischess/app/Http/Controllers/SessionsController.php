<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SessionsController extends Controller
{
    public function destroy() {
        auth()->logout();

        return redirect('/');
    }

    public function store() {

        $requestData = request()->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if (auth()->attempt($requestData)) {
            return redirect('/')->with('success', 'Welcome back.');
        };

        return back()
        ->withInput()
        ->withErrors(['email' => 'Your provided credentials could not be verified.']);

    }   

    public function create() {
        return view('/sessions/create');
    }
}
