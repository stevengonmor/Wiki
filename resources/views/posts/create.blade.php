@extends('layouts.app')
@section('content')
<div class="container-fluid full-screen row"> 
    <div class="pull-right">
        <a class="info submit-button" href="{{ route('posts.index') }}"> Back</a>
    </div>
    <div class="description content-element col-xs-12 col-sm-12 col-md-12 col-lg-10 col-xl-8">
        @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="text" name="tittle" class="light-blue-input info" placeholder="Título"><br><br>
            <textarea class="light-blue-input info" name="text" placeholder="Escribe aqui..."></textarea><br><br>
            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">                  
                    <select class ="dropdown-text light-blue-input" name="category_id" id="category">
                        <option class= "info dark-blue" value="" selected disabled>Selecciona una Categoría</option>
                        @foreach($categories as $value)
                        <option class= "info dark-blue" value="{{$value->id}}">{{$value->name}}</option>
                        @endforeach
                    </select>
                </div><br>
            </div>
            <div>
                <input class="light-blue-input info" type="file" name="picture">
            </div><br>
            <p class="text-white mb-4">La foto es opcional, puedes agregarla más tarde.</p><br>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="info submit-button">Crear</button>
            </div>
        </form>
    </div>
</div>
@endsection