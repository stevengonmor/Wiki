@extends('layouts.app')
@section('content')
<div class="container-fluid full-screen row"> 
    <div class="pull-right">
        <a class="info submit-button" href="{{ route('roles.index') }}"> Back</a>
    </div>
    <div class="description col-xs-12 col-sm-12 col-md-12 col-lg-10 col-xl-5">
        @if ($errors->any())
        <div class="content-element">
            <p class="info"> No se pudo editar el rol. Corriga los siguientes errores:</p><br>
            <ul>
                @foreach ($errors->all() as $error)
                <li class="landing-text">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        {!! Form::model($role, ['method' => 'PATCH','route' => ['roles.update', $role->id]]) !!}
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Name:</strong>
                    {!! Form::text('name', null, array('value' => '{{$role->name}}','placeholder' => 'Name','class' => 'light-blue-input info')) !!}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Permission:</strong>
                    <br/>
                    @foreach($permission as $value)
                    <label class="info">{{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, array('class' => 'name')) }}
                        {{ $value->name }}</label>
                    <br/>
                    @endforeach
                    <br>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="info submit-button">Submit</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection