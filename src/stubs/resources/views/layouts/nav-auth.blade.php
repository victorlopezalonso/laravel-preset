@extends('layouts.admin')

@section('navbar')
    <section class="hero is-primary is-small">
        <div class="hero-body">
            <p class="title">
                <a href="{{ url('/') }}"><span class="icon"><i class="fas fa-home fa-sm"></i></span></a>
                &nbsp;@yield('navbar-title')
            </p>
            <p class="subtitle">@yield('navbar-subtitle')</p>
        </div>
    </section>
@endsection

