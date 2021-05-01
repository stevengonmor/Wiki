@extends('layouts.app')
@section('content')
<div class="container-fluid full-screen"> 
    <div class="content-element col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-10">                   
        <div class="description col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <p class ="info">{{ $post->tittle }}</p>  
            <p class ="blog-text light-blue text-justify col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">{{ $post->text }}</p><br>
            @if($post->picture)
            <img id= "img-box"  alt ="Imagen" src ="/storage/{{ $post->picture }}"><br>
            @endif
            <h4 class = "author-date blog-text"><img alt ="Imagen" src ="/storage/{{ $post->get_user_profile_picture($post->user_id) }}" class="rounded-circle" width="40" height="40">
                <a class = "blog-text" href = '{{ route('users.show',$post->user_id) }}'>{{ $post->get_user_name($post->user_id) }}</a>, {{ $post->created_at }}</h4><br>
            @if((!Auth::user()->hasRole('Autenticado')) || ($post->user_id == Auth::user()->id))
            @can('post-edit')
            <a class="landing-text btn-dark" href="{{ route('posts.edit',$post->id) }}">Editar</a>
            {!! Form::open(['method' => 'DELETE','route' => ['posts.destroy', $post->id],'style'=>'display:inline']) !!}
            {!! Form::submit('Borrar', ['class' => 'landing-text btn-danger']) !!}
            {!! Form::close() !!}
            @endcan
            @endif
        </div>
        <div class ="content-element row">
            <div class="content-element col-x s-12 col-sm-12 col-md-8 col-lg-8 col-xl-8"> 
                <br><br>
                <p class="info">Comentarios</p> 
                <div class="description comments-height col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">  
                    @foreach($comments as $comment)
                    <div class="light-blue comment blog-text mt-4 text-justify col-xs-12 col-sm-12 col-md-8 col-lg-12 col-xl-12"> 
                        <h4><img alt ="Imagen" src ="/storage/{{ $comment->get_user_profile_picture($comment->user_id) }}"" class="rounded-circle" width="40" height="40">
                            <a class = "blog-text" href = '{{ route('users.show',$comment->user_id) }}'>{{ $comment->get_user_name($comment->user_id) }}</a>, {{ $comment->created_at }}</h4><br>
                        <p class="text-justify">{{ $comment->text }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="content-element col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4"> 
                <br><br>
                <p class="info">Deja tu Comentario</p>  
                <div class="description col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <form method="GET" action='{{ route('posts.show', $post->id) }}'>
                        <p class ="info">Comentario</p>                    
                        <textarea class= "big-input info light-blue arsh" name="text" placeholder="Comentario"></textarea>
                        <input type = "hidden" name = "user_id" value = "{{ Auth::user()->id }}">
                        <input type = "hidden" name = "post_id" value = "{{ $post->id }}">
                        <br> <br> 
                        <input class= "submit-button info" type="submit" value="Enviar">
                    </form> 
                </div>
            </div>
        </div>
    </div>
</div> 
@endsection