@extends('layouts.admin')

@section('content')

    <nav-bar></nav-bar>
    <loading></loading>
    <modal></modal>

    <div class="section" style="overflow: auto;">
        <router-view></router-view>
    </div>
@endsection
