@extends('layouts.app')
@section('content')
<div class="contaimer-fluid full-screen">
    <div class="content-element col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-10">
        @if ($message = Session::get('success'))
        <div class="landin-text">
            <p class="info">{{ $message }}</p>
        </div>
        @endif
        <table class="content-element description table-bordered col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-6">
            <tr>
                <th class="info">Rol</th>
                <th class="info">Permisos</th>
                <th class="info">Mantenimiento</th>
            </tr>
            <tr>
                <td class="landing-text">{{ $role->name }}</td>
                <td>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            @if(!empty($rolePermissions))
                            @foreach($rolePermissions as $v)
                            <label class="landing-text">{{ $v->name }}</label><br>
                            @endforeach
                            @endif
                        </div>
                    </div>   
                </td>
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
        </table>
    </div>
</div>
@endsection