@extends('layouts.mail')

@section('content')

    <h1>{{$title}}</h1>
    <p>
        {{$content}}
    </p>

    <p>
        <a href="{{{$url}}}">Pulsa en el siguiente enlace{{$url}}</a>
    </p>
@endsection