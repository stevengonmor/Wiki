@extends('layouts.app')
@section('content')
<div class="contaimer-fluid full-screen">
    <div class="content-element col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-10">
        @can('Crear Usuarios')
        <div class="pull-right" >
            <a class="info submit-button" href="{{ route('users.create') }}"> Crear Nuevo Usuario</a>
        </div><br>
        @endcan
        @if ($message = Session::get('success'))
        <p class="info">{{ $message }}</p>
        @endif
        <form method="GET" action='{{ route('users.index')}}'>
            @csrf
            <div>
                <input class= "info submit-button" type="submit" value="Buscar">
                <input class="light-blue-input info" type="text" name="email" placeholder="Buscar un usuario (e-mail)">
            </div><br>
        </form>
        @if(!empty($msg)) 
        <p class ="text-white mb-4 ">{{ $msg }}</p>
        @endif
        <table class="content-element description table-bordered col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <tr>
                <th class="info">Nombre</th>
                <th class="info">Correo Electrónico</th>
                <th class="info">Rol</th>
                @if(Auth::user()->hasRole('Administrador'))
                <th class="info">Mantenimiento</th>
                @endif
            </tr>
            @foreach ($users as $key => $user)
            <tr>
                <td><a class="landing-text" href='{{ route('users.show',$user->id) }}'>{{ $user->name }}</a></td>
                <td class="landing-text">{{ $user->email }}</td>
                <td>
                    @if(!empty($user->getRoleNames()))
                    @foreach($user->getRoleNames() as $v)
                    <label class=" landing-text info">{{ $v }}</label>
                    @endforeach
                    @endif
                </td>
                @if((Auth::user()->hasRole('Administrador')))
                <td class>
                    @can('Editar Usuarios')
                    <a class="landing-text btn-dark" href="{{ route('users.edit',$user->id) }}">Editar</a>
                    @endcan
                    @can('Eliminar Usuarios')
                    {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'display:inline']) !!}
                    {!! Form::submit('Borrar', ['class' => 'landing-text btn-danger']) !!}
                    {!! Form::close() !!}
                    @endcan
                </td>
                @endif
            </tr>
            @endforeach
        </table>
    </div>
</div>
@endsection