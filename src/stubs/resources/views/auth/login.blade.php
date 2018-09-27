@extends('layouts.nav-auth')

@section('navbar-title')Login @endsection
@section('navbar-subtitle')Enter your <strong>credentials</strong> @endsection

@section('content')

    <div class="section">

        <div class="container">

            <form method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}

                <div class="field">
                    <label class="label">Email</label>
                    <div class="control has-icons-left has-icons-right">
                        <input id="email" name="email" class="input" type="email" placeholder="your email"
                               value="{{ old('email') }}" required
                               autofocus>
                        <span class="icon is-small is-left">
                          <i class="fas fa-envelope"></i>
                        </span>
                    </div>

                    @if ($errors->has('email') || $errors->has('password'))
                        <p class="help is-danger">{{ $errors->first('email') }}</p>
                    @endif

                </div>

                <div class="field">
                    <label class="label">Password</label>
                    <div class="control has-icons-left has-icons-right">
                        <input id="password" name="password" class="input" type="password" placeholder="your password"
                               required>
                        <span class="icon is-small is-left">
                          <i class="fas fa-key"></i>
                        </span>
                    </div>
                    @if ($errors->has('password'))
                        <p class="help is-danger">{{ $errors->first('password') }}</p>
                    @endif

                </div>

                <div class="field">
                    <label class="checkbox">
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                    </label>
                </div>

                <div class="field">
                    <div class="control">
                        <button type="submit" class="button">Submit</button>
                    </div>
                </div>

                <div class="field">
                    <a href="{{ route('password.request') }}">
                        Forgot Your Password?
                    </a>
                </div>

            </form>

        </div>

    </div>

@endsection
