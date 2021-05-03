<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel 8 User Roles and Permissions Tutorial') }}</title>
        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
        <!-- Fonts -->
        <link rel="dns-prefetch" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">
        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('https://use.fontawesome.com/releases/v5.0.8/css/all.css') }}" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    </head>
    <body>
        <header>
            <div id="header-left">
                <h1 class="info col-11 col-sm-11 col-md-11 col-lg-11 col-xl-11">
                    <a href="{{ route('home') }}"> <img class="info col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1" src="/storage/logo.png" alt="Logo"></a>Experiencia Informática</h1>
            </div>
            <div id="app">
                <nav class="navbar navbar-expand-lg navbar-dark bg-transparent">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav">
                            @guest
                            @else
                            <li><a class="info" href="{{ route('home') }}">Inicio</a></li>
                            <li><a class="info" href="{{ route('posts.index') }}">Publicaciones</a></li>
                            <li><a class="info" href="{{ route('users.index') }}">Usuarios</a></li>
                            @if(Auth::user()->hasRole('Administrador'))
                            <li><a class="info" href="{{ route('roles.index') }}">Roles</a></li>
                            <li><a class="info" href="{{ route('log') }}">Historial</a></li>
                            @endif
                            <img id= "img-box" class="rounded-circle" alt ="Imagen" src="/storage/{{ Auth::user()->profile_picture }}" width="40" height="40">
                            <li class="dropdown">
                                <a id="navbarDropdown" class="info dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>
                                <div id = "width-dropdown" class="light-blue dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item info" href="{{ route('users.show', Auth::user()->id) }}">Perfil</a>
                                    <a class="dropdown-item info" href="{{ route('user_posts') }}">Mis Publicaciones</a>
                                    <a class="dropdown-item info" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                               document.getElementById('logout-form').submit();">
                                        {{ __('Salir') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                            @endguest
                        </ul>
                    </div>   
                </nav>
                <main class="py-4">
                    <div class="container-fluid">
                        @yield('content')
                    </div>
                </main>
                <footer>
                    <div id="content-element">
                        <footer class="bg-transparent text-center blog-text">
                            <div class="container-fluid p-4">
                                <section class="mb-4">
                                    <a class="btn btn-outline-light btn-floating m-1" href="https://www.facebook.com/" role="button"
                                       ><i class="fab fa-facebook-f"></i
                                        ></a>
                                    <a class="btn btn-outline-light btn-floating m-1" href="https://twitter.com/" role="button"
                                       ><i class="fab fa-twitter"></i
                                        ></a>
                                    <a class="btn btn-outline-light btn-floating m-1" href="https://www.instagram.com/" role="button"
                                       ><i class="fab fa-instagram"></i
                                        ></a>
                                    <a class="btn btn-outline-light btn-floating m-1" href="https://www.linkedin.com/" role="button"
                                       ><i class="fab fa-linkedin-in"></i
                                        ></a>
                                </section>
                                <div class="text-center p-3" style="background-color: none;">
                                    © 2021 Copyright:
                                    <p class="text-white">Steven González, Greivin Carrillo, Johnny Chacón</p>
                                </div>
                            </div>
                        </footer>
                    </div>
                </footer>
            </div>
    </body>
</html>