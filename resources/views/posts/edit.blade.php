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
    <div class="description content-element col-xs-12 col-sm-12 col-md-12 col-lg-10 col-xl-8">
        @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <form method="POST" action="{{ route('posts.update',$post->id) }}"" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="text" name="tittle" class="light-blue-input info" placeholder="Título" value="{{ $post->tittle }}"><br><br>
            <textarea class="light-blue-input info" name="text" placeholder="Escribe aqui...">{{ $post->text }}</textarea><br><br>
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
                        <option class= "info dark-blue" value="{{$value->id}}" selected>{{$value->name}}</option>
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
</div>
@endsection