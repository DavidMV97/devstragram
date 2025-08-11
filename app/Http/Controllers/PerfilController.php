<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;



class PerfilController extends Controller
{
    public function index()
    {
        return view('perfil.index');
    }

    public function store(Request $request)
    {

        $username = Str::slug($request->username);
        $request->merge(['username' => $username]);

        $request->validate([
            'username' => [
                'required',
                'string',
                'min:3',
                'max:20',
                Rule::unique('users', 'username')->ignore(auth()->user()->id),
                Rule::notIn(['twitter', 'editar-perfil']),
            ],
        ]);

        if ($request->imagen) {
            $manager = new ImageManager(new Driver());

            $imagen = $request->file('imagen');

            //generar un id unico para las imagenes
            $nombreImagen = Str::uuid() . "." . $imagen->extension();

            //guardar la imagen al servidor
            $imagenServidor = $manager->read($imagen);
            //agregamos efecto a la imagen con intervention
            $imagenServidor->scale(1000, 1000);

            //agregamos la imagen a la  carpeta en public donde se guardaran las imagenes
            $imagenesPath = public_path('perfiles') . '/' . $nombreImagen;
            //Una vez procesada la imagen entonces guardamos la imagen en la carpeta que creamos
            $imagenServidor->save($imagenesPath);
        }

        // Guardar cambios
        $usuario = User::find(auth()->user()->id); 
        $usuario->username = $request->username; 
        $usuario->imagen = $nombreImagen ?? auth()-user()->imagen ?? null; 
        $usuario->save();  
        
        return redirect()->route('posts.index', $usuario->username); 
    }
}
