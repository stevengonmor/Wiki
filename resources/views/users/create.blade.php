@extends('layouts.app')
@section('content')
<div class="container-fluid full-screen row"> 
    <div class="pull-right">
        <a class="info submit-button" href="{{ route('users.index') }}"> Back</a>
    </div>
    <div class="description content-element col-xs-12 col-sm-12 col-md-12 col-lg-10 col-xl-8">
         @if ($errors->any())
        <div class="content-element">
            <p class="info"> No se pudo crear el usuario. Corriga los siguientes errores:</p><br>
            <ul>
                @foreach ($errors->all() as $error)
                <li class="landing-text">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <form method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="">
                <i class="info icon-padding fa fa-user"></i>
                <input class="light-blue-input info" type="text" name="name" placeholder="Nombre Completo">
            </div><br>
            <div class="">
                <i class="info icon-padding fa fa-envelope"></i>
                <input class="light-blue-input info" type="text" name="email" placeholder="Correo Electronico">
            </div><br>
            <div class="">
                <i class="info icon-padding fa fa-key"></i>
                <input class="light-blue-input info" type="password" name="password" placeholder="Contraseña">
            </div><br>
            <div class="">
                <i class="offset-md-1""></i>
                <input class="light-blue-input info" type="password" name="confirm-password" placeholder="Confirme la contraseña">
            </div><br>
            <div class="">
                <i class="info icon-padding fa fa-tasks"></i>
                {!! Form::select('roles[]', $roles,[], array('class' => 'light-blue-input info')) !!}
            </div><br>
            <div class="">
                <i class="info icon-padding fa fa-camera-retro"></i>
                <input class="light-blue-input info" type="file" name="profile_picture">
            </div><br>
            <p class="text-white mb-4">La foto de perfil es opcional, puedes agregarla más tarde.</p><br>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="info submit-button">Crear</button>
            </div>
        </form>
    </div>
</div> 
@endsection