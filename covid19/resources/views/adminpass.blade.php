@extends('layouts.layout')

@section('content')

<div class="card-container">
    <div class="admin-login-card">
        <h1 class="login-title">Admin Login</h1>
        
        <form action="/adminpass" method="POST">
            @csrf
            <label for="pass" class="login-label">
                Give password to access admin:
                <span style="display:none">GIVE PASSWORD TO ACCESS ADMIN</span>
            </label>
            <input type="password" name="pass" id="pass" required autocomplete="current-password">

            <input type="submit" value="GET DATABASE ACCESS" class="btn-login">

            @if(session('mssg'))
                <p class="login-error">{{ session('mssg') }}</p>
            @endif
        </form>
    </div>
</div>

@endsection
