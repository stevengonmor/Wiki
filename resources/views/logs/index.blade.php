@extends('layouts.app')
@section('content')
<div class="contaimer-fluid full-screen">
    <div class="content-element col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-10">
        @if ($message = Session::get('success'))
        <div class="landin-text">
            <p>{{ $message }}</p>
        </div>
        @endif
        @if(!empty($logs[0]))
        <table class="content-element description table-bordered col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <tr>
                <th class="info">Fecha</th>
                <th class="info">Usuario</th>
                <th class="info">Tipo</th>
                <th class="info">Acción</th>
                <th class="info">Publicación</th>
                <th class="info">Descripción</th>
            </tr>
            @foreach ($logs as $key => $log)
            <tr>
                <td class="landing-text">{{ $log->created_at }}</td>
                <td><a class="landing-text" href='{{ route('users.show',$log->user_id) }}'>{{ $log->user_id }}</a></td>
                <td class="landing-text">{{ $log->content_type }}</td>
                <td class="landing-text">{{ $log->action }}</td>
                <td><a class="landing-text" href='{{ route('posts.show',$log->content_id) }}'>{{ $log->content_id }}</a></td>
                <td class="landing-text">{{ $log->description }}</td>
            </tr>
            @endforeach
        </table>
        @else
        <p class="info">Aún no hay eventos.</p>
        @endif
    </div>
</div>
@endsection