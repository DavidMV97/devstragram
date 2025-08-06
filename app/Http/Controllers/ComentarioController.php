<?php

namespace App\Http\Controllers;
use App\Models\Comentario;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class ComentarioController extends Controller
{
    public function store(Request $request, User $user, Post $post) {
        $validatedData = $request->validate([
            'comentario' => 'required|max:255'
        ]);

        // Almacena el comentario en la base de datos
        Comentario::create([
            'user_id' => auth()->user()->id,
            'post_id' => $post->id,
            'comentario' => $request->comentario
        ]);

        // Redirige al usuario a la página del post
        return back()->with('mensaje', 'Comentario publicado correctamente');

    }
}
