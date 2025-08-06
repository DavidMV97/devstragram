<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
    
    public function index () {
        return view('auth.register');
    }

    public function store(Request $request) { 
        //dd($request);

        $request->request->add(['username' => Str::slug($request->username)]);

        $validatedData = $request->validate([
            'name' => 'required|string|min:3|max:30',
            'username' => 'required|string|min:3|max:30|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password
        ]);

        // Autenticar al usuario
        // auth()->attempt([
        //     'email' => $request->email,
        //     'password' => $request->password
        // ]);

        // otra forma de autenticar
        auth()->attempt($request->only('email', 'password'));

        // Redireccionar al muro
        return redirect()->route('posts.index', auth()->user()->username);
    }
}
