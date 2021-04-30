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
            {!! Form::select('categories[]', $categories,[], array('class' => 'light-blue-input info')) !!}
<!--            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">                  
                    <select class ="dropdown-text light-blue" name="category_id" id="category">
                        <option class= "info dark-blue" value="" selected disabled>Selecciona una Categoría</option>
                        <option class= "info dark-blue" value="1">Desarrollo Web</option>
                        <option class= "info dark-blue" value="2">Desarrollo de Software</option>
                        <option class= "info dark-blue" value="3">Ciberseguridad</option>
                    </select>
                </div>
            </div>-->
                <button type="submit" class="info submit-button">Submit</button>
        </form>
    </div>
</div>
@endsection