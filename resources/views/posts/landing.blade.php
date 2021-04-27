@extends('layouts.app')
@section('content')
<div class="container-fluid full-screen row"> 
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Posts</h2>
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
    <p class ="text-white mb-4"> @Este usuario no tiene blogs</p>
    @else
    <tr>
        <th>No</th>
        <th>Name</th>
        <th>Details</th>
    </tr>
    @foreach ($posts as $post)
    <tr>
        <td>{{ ++$i }}</td>
        <td><a href="{{ route('posts.show',$post->id) }}">{{ $post->tittle }}</a></td>
        <td>{{ $post->text }}</td>
    </tr>
    @endforeach
    @endif          
</table>
</div>
@endsection