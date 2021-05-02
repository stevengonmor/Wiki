@extends('layouts.app')
@section('content')
<div class="container-fluid full-screen">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <a class="info submit-button" href="{{ route('users.index') }}"> Atrás</a>
            </div><br>
        </div>
    </div>
    <div class="info description all-height justify-content-center col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-8">
        @if($user)
        <form method="GET" action='{{ route('users.show', $user->id) }}'>
            @else 
            <form method="GET" action='{{ route('users.show', 1) }}'>
                @endif
                @csrf
                <div>
                    <input class= "info submit-button" type="submit" value="Buscar">
                    <input class="light-blue-input info" type="text" name="email" placeholder="Buscar un usuario (e-mail)">
                </div><br>
            </form>
            @if(!empty($msg)) 
            <p class ="text-white mb-4 ">{{ $msg }}</p>
            @else
            <div class="row">
                <div class="profile-pic-back user-profile col-xs-12 col-sm-12 col-md-12 col-lg-3 col-xl-4">
                    <div class="card-block text-center text-white">
                        <img id= "img-box" class="rounded-circle" alt ="Imagen" src="/storage/{{ $user->profile_picture }}" width="200" height="200"><br>
                        <h6 class="info">{{ $user->name }}</h6>
                    </div>
                </div>
                <div class="profile-pic-back col-xs-12 col-sm-12 col-md-12 col-lg-9 col-xl-8">
                    <div class="card-block">
                        <div class="padd-bottom col-sm-12">
                            <p class="info f-w-600">Información</p>
                            <h6 class="text-muted">{{ $user->about_me }}</h6><br>
                            <p class="info f-w-600">E-mail</p>
                            <h6 class="text-muted">{{ $user->email }}</h6>
                            <br>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                <p class="info f-w-600">Rol</p>
                                @if(!empty($user->getRoleNames()))
                                @foreach($user->getRoleNames() as $v)
                                <h6 class="text-muted">{{ $v }}</h6>
                                @endforeach
                                @endif
                                <br>
                            </div>
                            <div class="padd-bottom col-xs-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                <p class="info f-w-600">Se unió el</p>
                                <h6 class="text-muted">{{ $user->created_at }}</h6>
                            </div>
                            @if((Auth::user()->hasRole('Administrador')) || ($user->id == Auth::user()->id))
                            <div class="row">
                                @can('Editar Usuarios')
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-6">
                                    <a class="btn btn-dark col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-6" href="{{ route('users.edit',$user->id) }}">Editar</a> 
                                </div>
                                @endcan
                                @if(Auth::user()->hasRole('Administrador'))
                                @can('Eliminar Usuarios')
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-6">
                                    {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id]]) !!}
                                    {!! Form::submit('Dar de Baja', ['class' => 'btn btn-dark col-xs-12 col-sm-12 col-md-6 col-lg-4 col-xl-6']) !!}
                                    {!! Form::close() !!}
                                </div>
                                @endcan
                                @endif
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div> 
            @endif
    </div>
</div>
@endsection