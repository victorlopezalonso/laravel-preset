@extends('layouts.mail')

@section('title')
    These are your credentials to access to the admin panel:
@endsection

@section('content')

    <br><h4>url: {{env('APP_URL') . '/login'}}</h4>

    <br><h4>email: {{$user->email}}</h4>
    <br><h4>password: {{$password}}</h4>

@endsection