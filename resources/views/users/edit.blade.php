@extends('layouts.app')


@section('content')
<div class="container-fluid full-screen row"> 
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-right">
                <a class="info submit-button" href="{{ route('users.show', $user->id) }}"> Back</a>
            </div>
        </div>
    </div>
    @if(!Auth::user()->hasRole('Administrador') && Auth::user()->id != $user->id)
    <div class="description">
            <p class="info">Los usuarios Autenticados y Editores solo pueden modificar su propia información.</p>
        </div>
    @else
    <div class="description content-element col-xs-12 col-sm-12 col-md-12 col-lg-10 col-xl-5">
      @if ($errors->any())
        <div class="content-element">
            <p class="info"> No se pudo editar el usuario. Corriga los siguientes errores:</p><br>
            <ul>
                @foreach ($errors->all() as $error)
                <li class="landing-text">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <form method="POST" action="{{ route('users.update',$user->id) }}"" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div>
                <i class="info icon-padding fa fa-user"></i>
                <input class="light-blue-input info" type="text" name="name" placeholder="Nombre Completo" value="{{ $user->name }}">
            </div><br>
            <div>
                <i class="offset-md-1""></i>
                <textarea class="light-blue-input info" name="about_me">{{ $user->about_me }}</textarea>
            </div><br>
            <div>
                <i class="info icon-padding fa fa-envelope"></i>
                <input class="light-blue-input info" type="text" name="email" placeholder="Correo Electronico" value="{{ $user->email }}">
            </div><br>
            <div>
                <i class="info icon-padding fa fa-key"></i>
                <input class="light-blue-input info" type="password" name="password" placeholder="Contraseña">
            </div><br>
            <div>
                <i class="offset-md-1""></i>
                <input class="light-blue-input info" type="password" name="confirm-password" placeholder="Confirme la contraseña">
            </div><br>
            @if((Auth::user()->hasRole('Administrador')))
            <div>
                <i class="info icon-padding fa fa-tasks"></i>
                {!! Form::select('roles[]', $roles ,$user->roles->pluck('name'), array('class' => 'light-blue-input info')) !!}
            </div><br>
            @endif
            <div>
                <i class="info icon-padding fa fa-camera-retro"></i>
                <input class="light-blue-input info" type="file" name="profile_picture">
                <input type="hidden" name="old_profile_picture" value="{{ $user->profile_picture }}">
            </div><br>
            <p class="text-white mb-4">La foto de perfil es opcional, puedes agregarla más tarde.</p><br>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="info submit-button">Actualizar</button>
            </div>
        </form>
    </div>
    @endif
</div>

@endsection