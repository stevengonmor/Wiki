@extends('layouts.app')
@section('content')
<div class="container-fluid full-screen row"> 
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-right">
                <a class="info submit-button" href="{{ route('posts.show', $post->id) }}">Atrás</a>
            </div>
        </div>
    </div>
    @if(Auth::user()->hasRole('Autenticado') && Auth::user()->id != $post->user_id)
    <div class="description">
        <p class="info">Los usuarios Autenticados solo pueden modificar sus propias publicaciones.</p>
    </div>
    @else
    <div class="description content-element col-xs-12 col-sm-12 col-md-12 col-lg-10 col-xl-8">
        @if ($errors->any())
        <div class="content-element">
            <p class="info"> No se pudo editar la publicación. Corriga los siguientes errores:</p><br>
            <ul>
                @foreach ($errors->all() as $error)
                <li class="landing-text">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <form method="POST" action="{{ route('posts.update',$post->id) }}"" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="text" name="tittle" class="light-blue-input info" placeholder="Título" value="{{ $post->tittle }}"><br><br>
            <textarea class="light-blue-input info" name="text" placeholder="Escribe aqui...">{{ $post->text }}</textarea><br><br>
            <input class="light-blue-input info" type = "hidden" name="old_text" value = "{{ $post->text }}">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">                  
                    <select class ="dropdown-text light-blue-input" name="type_id">
                        <option class= "info dark-blue" value="" selected disabled>Selecciona el tipo</option>
                        @foreach($types as $value)
                        @if($value->id == $post->type_id)
                        <option class= "info dark-blue" value="{{$value->id}}" selected>{{$value->name}}</option>
                        @else
                        <option class= "info dark-blue" value="{{$value->id}}">{{$value->name}}</option>
                        @endif
                        @endforeach
                    </select>
                </div><br>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">                  
                    <select class ="dropdown-text light-blue-input" name="category_id">
                        <option class= "info dark-blue" value="" selected disabled>Selecciona una Categoría</option>
                        @foreach($categories as $value)
                        @if($value->id == $post->category_id)
                        <option class= "info dark-blue" value="{{$value->id}}" selected>{{$value->name}}</option>
                        @else
                        <option class= "info dark-blue" value="{{$value->id}}">{{$value->name}}</option>
                        @endif
                        @endforeach
                    </select>
                </div><br>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">                  
                    <select class ="dropdown-text light-blue-input" name="status_id">
                        <option class= "info dark-blue" value="" selected disabled>Selecciona una Categoría</option>
                        @foreach($statuses as $value)
                        @if($value->id == $post->status_id)
                        <option class= "info dark-blue" value="{{$value->id}}" selected>{{$value->name}}</option>
                        @else
                        <option class= "info dark-blue" value="{{$value->id}}">{{$value->name}}</option>
                        @endif
                        @endforeach
                    </select>
                </div><br>
            </div>
            <input class="light-blue-input info" type="file" name="picture">
            <input type="hidden" name="old_picture" value="{{ $post->picture }}"><br><br>
            <p class="text-white mb-4">La foto de perfil es opcional, puedes agregarla más tarde.</p><br>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="info submit-button">Actualizar</button>
            </div>
        </form>
    </div> 
    @endif
</div>
@endsection