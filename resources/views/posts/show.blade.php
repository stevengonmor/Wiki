@extends('layouts.app')
@section('content')
<div class="container-fluid full-screen"> 
    <div class="content-element col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-10">   
        <div class = "row description content-element">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <p class ="type-category-status blog-text">{{ $post->get_id_name('types', $post->type_id) }} - {{ $post->get_id_name('statuses', $post->status_id) }}</p>
                <p class ="info">{{ $post->tittle }}</p>  
                <p class ="blog-text light-blue text-justify col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">{{ $post->text }}</p><br>
                @if($post->picture)
                <img id= "img-box"  alt ="Imagen" src ="/storage/{{ $post->picture }}"><br>
                @endif
                <br><br>
                @if((!Auth::user()->hasRole('Autenticado')) || ($post->user_id == Auth::user()->id))
                @can('Editar Publicaciones')
                @endcan
                @can('Eliminar Publicaciones')
                <a class="landing-text btn-dark" href="{{ route('posts.edit',$post->id) }}">Editar</a>
                {!! Form::open(['method' => 'DELETE','route' => ['posts.destroy', $post->id],'style'=>'display:inline']) !!}
                {!! Form::submit('Borrar', ['class' => 'landing-text btn-danger']) !!}
                {!! Form::close() !!}
                @endcan
                @endif
            </div>
            <div class = "col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-6">
                <p class ="blog-text type-category-status"> {{ $post->get_id_name('categories', $post->category_id) }}</p>
            </div>
            <div class = "col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-6">
                <h4 class = "blog-text text-justify author-date blog-text"><img alt ="Imagen" src ="/storage/{{ $post->get_user_profile_picture($post->user_id) }}" class="rounded-circle" width="40" height="40">
                    <a class = "blog-text" href = '{{ route('users.show',$post->user_id) }}'>{{ $post->get_id_name('users', $post->user_id) }}</a>, {{ $post->created_at }}</h4><br>
            </div>
        </div>
        <div class ="content-element row">
            <div class="content-element col-x s-12 col-sm-12 col-md-8 col-lg-8 col-xl-8"> 
                <br><br>
                @if($post->type_id ==1)
                <p class="info">Comentarios</p> 
                @else
                <p class="info">Respuestas</p> 
                @endif
                @if(isset($comments[0]))
                <div class="description col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">  
                    @foreach($comments as $comment)
                    <div class="light-blue comment blog-text mt-4 text-justify col-xs-12 col-sm-12 col-md-8 col-lg-12 col-xl-12"> 
                        <h4><img alt ="Imagen" src ="/storage/{{ $comment->get_user_profile_picture($comment->user_id) }}"" class="rounded-circle" width="40" height="40">
                            <a class = "blog-text" href = '{{ route('users.show',$comment->user_id) }}'>{{ $comment->get_user_name($comment->user_id) }}</a>, {{ $comment->created_at }}</h4><br>
                        <p class="text-justify">{{ $comment->text }}</p>
                    </div>
                    @endforeach
                </div>
                @else
                <@if($post->type_id ==1)
                <p class="info">Aún no hay comentarios.</p> 
                @else
                <p class="info">Aún no hay respuestas.</p> 
                @endif
                @endif
            </div>
            <div class="content-element col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4"> 
                <br><br>
                @if($post->type_id ==2 && $post->status_id == 3)
                <p class="info">Esta pregunta está concluida, ya no se puede responder.</p>  
                @else
                @if($post->type_id ==1)
                <p class="info">Deja tu comentario</p> 
                @else
                <p class="info">Deja tu respuesta</p> 
                @endif
                <div class="description col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <form method="GET" action='{{ route('posts.show', $post->id) }}'>  
                        @if($post->type_id ==1)
                        <textarea class= "big-input info light-blue arsh" name="text" placeholder="Comentario"></textarea>
                        @else
                        <textarea class= "big-input info light-blue arsh" name="text" placeholder="Respuesta"></textarea>
                        @endif
                        <input type = "hidden" name = "user_id" value = "{{ Auth::user()->id }}">
                        <input type = "hidden" name = "post_id" value = "{{ $post->id }}">
                        <br> <br> 
                        <input class= "submit-button info" type="submit" value="Enviar">
                    </form> 
                </div>
                @endif
            </div>
        </div>
    </div>
</div> 
@endsection