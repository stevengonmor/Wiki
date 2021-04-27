@extends('layouts.app')
@section('content')
<div class="container-fluid full-screen row"> 
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Add New Post</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('posts.index') }}"> Back</a>
        </div>
    </div>
</div>
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
<form action="{{ route('posts.store') }}" method="POST">
    @csrf
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Título:</strong>
                <input type="text" name="tittle" class="form-control" placeholder="Tittle">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Texto:</strong>
                <textarea class="info light-blue" style="height:150px" name="text" placeholder="Escribe aqui..."></textarea>
            </div>
        </div>
        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <p class ="info">Categoría</p>                    
                <select class ="dropdown-text light-blue" name="category_id" id="category">
                    <option class= "info dark-blue" value="" selected disabled>Selecciona una Categoría</option>
                    <option class= "info dark-blue" value="1">Desarrollo Web</option>
                    <option class= "info dark-blue" value="2">Desarrollo de Software</option>
                    <option class= "info dark-blue" value="3">Ciberseguridad</option>
                </select>
            </div>
        </div>
        <input type="hidden" name="status_id" value="1">
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
</form
@endsection