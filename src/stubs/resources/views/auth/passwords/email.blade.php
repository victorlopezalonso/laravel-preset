@extends('layouts.nav-auth')

@section('navbar-title')Reset Password @endsection
@section('navbar-subtitle')Send me an email to <strong>reset my password</strong> @endsection

@section('content')

    <div class="section">

        <div class="container">

            <form method="POST" action="{{ route('password.email') }}">
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
                    <div class="control">
                        <button type="submit" class="button">Send Password Reset Link</button>
                    </div>
                </div>

                @if (session('status'))
                    <p class="help is-primary">{{ session('status') }}</p>
                @endif

            </form>

        </div>

    </div>

@endsection
