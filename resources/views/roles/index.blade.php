@extends('layouts.app')
@section('content')
<div class="contaimer-fluid full-screen">
    <div class="content-element col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-10">
        @if(!Auth::user()->hasRole('Administrador'))
        <div class="description">
            <p class="info">Este ususario no tiene permisos para el mantenimiento de roles</p>
        </div>
        @else
        @if ($message = Session::get('success'))
        <div class="landin-text">
            <p>{{ $message }}</p>
        </div>
        @endif
        <table class="content-element description table-bordered col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-4">
            <tr>
                <th class="info">Nombre</th>
                <th class="info">Mantenimiento</th>
            </tr>
            @foreach ($roles as $key => $role)
            <tr>
                <td><a class="landing-text" href='{{ route('roles.show',$role->id) }}'>{{ $role->name }}</a></td>
                <td>
                    @can('role-edit')
                    <a class="landing-text btn-dark" href="{{ route('roles.edit',$role->id) }}">Editar</a>
                    @endcan
                    @can('role-delete')
                    {!! Form::open(['method' => 'DELETE','route' => ['roles.destroy', $role->id],'style'=>'display:inline']) !!}
                    {!! Form::submit('Borrar', ['class' => 'landing-text btn-danger']) !!}
                    {!! Form::close() !!}
                    @endcan
                </td>
            </tr>
            @endforeach
        </table>
        {!! $roles->render() !!}
        @endif
    </div>
</div>
@endsection