@extends('layouts.mail')

@section('content')

    <h1>{{$title}}</h1>
    <p>
        {{$content}}
    </p>

    <br><h4><a href="{{$url}}">{{$link}}</a></h4>

@endsection