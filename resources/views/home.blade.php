@extends('layouts.app')
@section('content')
<div class ="container-fluid full-screen row">
    <div class="content-element col-xs-12 col-sm-12 col-md-12 col-lg-8 col-xl-8">
        <div id="carousel-container">
            <div id="carousel-main" class="CentroCarousel carousel slide col-xs-12 col-sm-12 col-md-12 col-lg-9 col-xl-9" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="Imagenes carousel-item active">
                        <img src="/storage/desarrollo-web.png" class="d-block w-100" alt="1">
                    </div>
                    <div class="Imagenes carousel-item">
                        <img src="/storage/desarrollo-software.png" class="d-block w-100" alt="2">
                    </div>
                    <div class="Imagenes carousel-item">
                        <img src="/storage/ciberseguridad.png" class="d-block w-100" alt="3">
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carousel-main" role="button" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carousel-main" role="button" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </a>
            </div>
        </div>
        <br>
        <p class ="info">¿Tienes alguna pregunta o avance en tu área de trabajo? Escribe una publicación.</p>
        <div class="pull-right">
            @can('Crear Publicaciones')
            <a class="info submit-button" href="{{ route('posts.create') }}">Crear Nueva Publicación</a><br>
            @endcan
        </div><br><br>
        @if(isset($posts[0]))
        <p class ="info">Ultimas publicaciones</p>
        <div class="description col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            @foreach ($posts as $post)
            <div class="light-blue col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <a href ="{{ route('posts.show', $post->id)}}" class ="landing-text">{{ $post->tittle }}</a><br>
                <br>
                <p class = "author-date landing-text"><img alt ="Imagen" src ="/storage/{{ $post->get_user_profile_picture($post->user_id) }}" class="rounded-circle" width="40" height="40">
                    <a class = "landing-text" href = '{{ route('users.show', $post->user_id)}}'>{{ $post->get_id_name('users', $post->user_id) }}</a>, {{ $post->created_at }}</p>
            </div>
            <br>
            @endforeach
        </div>
        @else
        <p class="info">Aún no hay publicaciones.</p>
        @endif
    </div>
</div>
@endsection
