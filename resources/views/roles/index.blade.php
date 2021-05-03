@extends('layouts.app')
@section('content')
<div class="contaimer-fluid full-screen">
    <div class="content-element col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-10">
        <div class="pull-right">
            @can('Crear Roles')
            <a class="info submit-button" href="{{ route('roles.create') }}"> Crear un Nuevo Rol</a><br>
            @endcan
        </div>
        @if ($message = Session::get('success'))
        <p class="info">{{ $message }}</p>
        @endif
        <br>
        <table class="content-element description table-bordered col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-4">
            <tr>
                <th class="info">Nombre</th>
                <th class="info">Mantenimiento</th>
            </tr>
            @foreach ($roles as $key => $role)
            <tr>
                <td><a class="landing-text" href='{{ route('roles.show',$role->id) }}'>{{ $role->name }}</a></td>
                <td>
                    @can('Editar Roles')
                    <a class="landing-text btn-dark" href="{{ route('roles.edit',$role->id) }}">Editar</a>
                    @endcan
                    @can('Eliminar Roles')
                    {!! Form::open(['method' => 'DELETE','route' => ['roles.destroy', $role->id],'style'=>'display:inline']) !!}
                    {!! Form::submit('Borrar', ['class' => 'landing-text btn-danger']) !!}
                    {!! Form::close() !!}
                    @endcan
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</div>
@endsection