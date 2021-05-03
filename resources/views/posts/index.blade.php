@extends('layouts.app')
@section('content')
<div class="container-fluid full-screen row"> 
    <div class="pull-right">
        @can('Crear Publicaciones')
        <a class="info submit-button" href="{{ route('posts.create') }}"> Crear Nueva Publicación</a><br>
        @endcan
    </div>
    <div class="content-element col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-10">
        @if ($message = Session::get('success'))
        <p class="info">{{ $message }}</p>
        @endif
        <p class="info" >Filtrar por Tipo/Categoría</p><br>
        @if($one_user)
        <form action="{{ route('user_posts') }}" method="POST">
            @else
            <form action="{{ route('posts.index') }}" method="GET">
                @endif
                @csrf
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">                  
                        <select class ="dropdown-text light-blue-input col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-5" name="type_id">
                            <option class= "info dark-blue" value="" selected disabled>Tipo</option>
                            <option class= "info dark-blue" value="">Todos</option>
                            @foreach($types as $value)
                            <option class= "info dark-blue" value="{{$value->id}}">{{$value->name}}</option>
                            @endforeach
                        </select>
                    </div><br>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">                  
                        <select class ="dropdown-text light-blue-input col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-5" name="category_id">
                            <option class= "info dark-blue" value="" selected disabled>Categoría</option>
                            <option class= "info dark-blue" value="0">Todos</option>
                            @foreach($categories as $value)
                            <option class= "info dark-blue" value="{{$value->id}}">{{$value->name}}</option>
                            @endforeach
                        </select>
                    </div><br>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                    <button type="submit" class="info submit-button">Filtrar</button>
                </div>
            </form>
            @if(!empty($msg)) 
            <p class ="info mb-4 ">{{ $msg }}</p>
            @else
            <div class="content-element row col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">   
                @if(isset($posts[0]))
                <div class="description">
                    @foreach($posts as $post)
                    <a href ="{{ route('posts.show', $post->id ) }}" class ="info">{{ $post->tittle }}</a><br><br> 
                    <p class ="blog-text light-blue">{{ substr($post->text, 0, 215) . "..."}}</p><br> 
                    <h4 class = "author-date blog-text"><img alt ="Imagen" src ="/storage/{{ $post->get_user_profile_picture($post->user_id) }}" class="rounded-circle" width="40" height="40">
                        <a class = "blog-text" href = '{{ route('users.show',$post->user_id) }}'>{{ $post->get_id_name('users', $post->user_id) }}</a>, {{$post->created_at}}</h4>
                    @if((!Auth::user()->hasRole('Autenticado')) || ($post->user_id == Auth::user()->id))
                    @can('Editar Publicaciones')
                    <a class="landing-text btn-dark" href="{{ route('posts.edit',$post->id) }}">Editar</a>
                    @endcan
                    @can('Eliminar Publicaciones')
                    {!! Form::open(['method' => 'DELETE','route' => ['posts.destroy', $post->id],'style'=>'display:inline']) !!}
                    {!! Form::submit('Borrar', ['class' => 'landing-text btn-danger']) !!}
                    {!! Form::close() !!}
                    @endcan
                    @endif
                    <br><br>
                    @endforeach
                </div>
                @else
                <p class="info">Aún no hay publicaciones.</p>
                @endif
            </div>
            @endif
    </div>
</div>
@endsection