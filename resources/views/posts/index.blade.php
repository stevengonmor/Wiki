@extends('layouts.app')
@section('content')

<div class="container-fluid full-screen row"> 
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Posts</h2>
        </div>
        <div class="pull-right">
            @can('post-create')
            <a class="btn btn-success" href="{{ route('posts.create') }}"> Create New Post</a>
            @endcan
        </div>
    </div>
</div>
@if ($message = Session::get('success'))
<div class="alert alert-success">
    <p>{{ $message }}</p>
</div>
@endif
<table class="table table-bordered">
    @if(!$posts[0])
    <p class ="text-white mb-4"> {{__('No hay publicaciones')}}</p>
    @else
    <tr>
        <th>No</th>
        <th>Name</th>
        <th>Details</th>
        <th width="280px">Action</th>
    </tr>
    @foreach ($posts as $post)
    <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $post->tittle }}</td>
        <td>{{ $post->text }}</td>
        <td>
            <form action="{{ route('posts.destroy',$post->id) }}" method="POST">
                <a class="btn btn-info" href="{{ route('posts.show',$post->id) }}">Show</a>
                @if((!Auth::user()->hasRole('Autenticado')) || ($post->user_id == Auth::user()->id))
                @can('post-edit')
                <a class="btn btn-primary" href="{{ route('posts.edit',$post->id) }}">Edit</a>
                @endcan
                @csrf
                @method('DELETE')
                @can('post-delete')
                <button type="submit" class="btn btn-danger">Delete</button>
                @endcan
                @endif
            </form>
        </td>
    </tr>
    @endforeach
    @endif          
</table>
@endsection