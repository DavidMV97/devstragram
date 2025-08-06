@extends('layouts.app')

@section('titulo')
    {{ $post->titulo }}
@endsection

@section('contenido')
    <div class="container mx-auto md:flex">
        <div class="md:w-1/2">
            <img src="{{ asset('uploads') . '/' . $post->imagen }}" alt="Imagen del post {{ $post->titulo }}">
            <div class="p-3">
                <p>0 likes</p>
            </div>

            <div>
                <p class="font-bold"> {{ $post->user->username }} </p>
                <p class="text-sm text-gray-500"> {{ $post->created_at->diffForHumans() }} </p>
                <p class="mt-5"> {{ $post->descripcion }} </p>
            </div>
        </div>

        <div class="md:w-1/2 p-5">
            <div class="shadow bg-white p-5 mb-5">
                @auth
                    <p class="text-xl font-bold text-center mb-4">Agrega un nuevo comentario</p>
                    @if (session('mensaje'))
                        <div class="bg-green-500 text-white p-2 rounded-lg mb-6 text-center">
                            {{ session('mensaje') }}
                        </div>
                        
                    @endif
                    <form action="{{ route('comentarios.store', ['user' => $post->user, 'post' => $post]) }}" method="POST">
                        @csrf
                        <div class="mb-5">
                            <label for="comentario" class="mb-2 block uppercase text-gray-500 font-bold">Añade un comentario</label>
                            <textarea id="comentario" placeholder="Agrega un comentario"
                                class="border border-gray-400 p-3 w-full rounded-lg @error('name') border-red-500 @enderror" name="comentario"></textarea>
                            @error('comentario')
                                <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center"> {{ $message }} </p>
                            @enderror
                        </div>
                        <input type="submit" value="Comentar"
                            class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full p-3 text-white rounded-lg" />
                    </form>
                @endauth
                <div class="bg-white shadow mt-10 mb-5 max-h-96 overflow-y-scroll">
                    @if ($post->comentarios->count())
                        <h2 class="text-2xl font-bold text-center mb-4">Comentarios ({{ $post->comentarios->count() }})</h2>
                        @foreach ($post->comentarios as $comentario)
                            <div class="p-5 border-b border-gray-200">
                                <a href="{{ route('posts.index', ['user' => $comentario->user]) }}" class="font-bold">
                                    {{ $comentario->user->username }}
                                </a>
                                <p class="text-gray-500 text-sm">{{ $comentario->created_at->diffForHumans() }}</p>
                                <p class="mt-2">{{ $comentario->comentario }}</p>
                            </div>
                        @endforeach
                        
                    @else
                        <p class="p-10 text-center">No hay comentarios aún</p>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection
