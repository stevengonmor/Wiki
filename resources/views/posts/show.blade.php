@extends('layouts.app')
@section('content')
<div class="container-fluid full-screen row"> 
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2> Show Post</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('posts.index') }}"> Back</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Titulo:</strong>
                {{ $post->tittle }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Texto:</strong>
                {{ $post->text }}
            </div>
        </div>
        @if((!Auth::user()->hasRole('Autenticado')) || ($post->user_id == Auth::user()->id))
        @can('post-edit')
        <a class="btn btn-primary" href="{{ route('posts.edit',$post->id) }}">Edit</a>
        @endcan
        @endif
    </div>
</div> 
@endsection