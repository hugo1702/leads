@extends('layouts.auth.app')
@section('content')
    <x-notification session="success" />
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <x-notification type="error" :message="$error" />
        @endforeach
    @endif
    <section>
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto lg:py-0 animate-slide-in-left">

            <div class="w-full bg-black/25 backdrop-blur-md text-sm rounded-lg shadow md:mt-0 sm:max-w-md xl:p-0">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <div class="flex flex-col items-center justify-center>">
                        <a href="#" class="flex items-center space-x-1">
                            <img src="/assets/images/logo.png" alt="Logo" class="h-8 w-8 object-contain" />
                            <span class="text-2xl font-bold text-white">Leads</span>
                        </a>
                    </div>

                    <h1 class="text-xl font-bold leading-tight tracking-tight text-white md:text-2xl ">Iniciar sesión </h1>
                    <form method="POST" action="{{ route('login.store') }}" class="space-y-4 md:space-y-6">
                        @csrf
                        <div>
                            <label for="user_name" class="block mb-2 text-sm font-medium text-white">Nombre de
                                usuario</label>
                            <input type="text" name="user_name" id="user_name"
                                class=" text-white rounded-lg block w-full p-2.5  bg-white/20 backdrop-blur-xs"
                                placeholder="usuario1234" required="">
                        </div>
                        <div>
                            <label for="password" class="block mb-2 text-sm font-medium text-white">Contraseña</label>
                            <input type="password" name="password" id="password" placeholder="••••••••"
                                class=" text-white rounded-lg block w-full p-2.5  bg-white/20 backdrop-blur-xs"
                                required="">
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="remember" aria-describedby="remember" type="checkbox"
                                        class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300"
                                        required="">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="remember" class="text-white">Recordar</label>
                                </div>
                            </div>
                            <a href="#" class="text-sm font-medium text-white hover:underline">¿Has olvidado tu
                                contraseña?</a>
                        </div>
                        <button type="submit"
                            class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Acceder</button>
                        <p class="text-sm font-light text-gray-100">
                            ¿Aún no tienes una cuenta? <a href=""
                                class="font-medium text-primary-600 hover:underline dark:text-primary-500">Regístrate.</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
