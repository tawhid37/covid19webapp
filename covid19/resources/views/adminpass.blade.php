@extends('layouts.layout')

@section('content')

<div class="content">
	<form action="/adminpass" method="POST">
		@csrf
		<h1>Admin Login</h1>
		<b><label for="pass">GIVE PASSWORD TO ACCESS ADMIN:</label></b>
		<input type="password" name="pass" id="pass" required autocomplete="current-password">

		<input type="submit" value="GET DATABASE ACESS">

		@if(session('mssg'))
			<p style="color: #dc3545; font-weight: 600; margin-top: 16px;">{{ session('mssg') }}</p>
		@endif
	</form>
</div>

@endsection
