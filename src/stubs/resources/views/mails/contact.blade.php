@extends('layouts.mail')

@section('content')

    <h1>{{$title}}</h1>
    <p>
        {{$content}}
    </p>

    <p>
        {{ $userMessage }}
    </p>


@endsection