@extends('layouts.app')

@section('content')
<div class="container-fluid full-screen row"> 
    <div class="description content-element col-xs-12 col-sm-12 col-md-12 col-lg-10 col-xl-6"> 
        <p class="tittle">Iniciar Sesión</p>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div>
                <i class="info icon-padding fa fa-envelope"></i>
                <input id = "email" class="light-blue-input info @error('email') is-invalid @enderror" type="email" name="email" placeholder = "Correo Electrónico" value="{{ old('email') }}" required autocomplete="email" autofocus><br><br>
            </div>
            <div>
                <i class="info icon-padding fa fa-key"></i>
                <input id="password" class="light-blue-input info @error('password') is-invalid @enderror" type="password" name="password" placeholder="Contraseña" required autocomplete="current-password">
            </div><br>
            @error('email')
            <span class="text-white" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            <br><br>
            @enderror
            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
            <label for="recordarme" class ="text-white">Recordarme</label><br><br>
            <input id = "recordarme" class= "info submit-button" type="submit" value="Iniciar Sesión">
        </form>
    </div>
</div>
@endsection
