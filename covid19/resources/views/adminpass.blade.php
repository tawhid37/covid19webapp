@extends('layouts.layout')

@section('content')

				<form action="/adminpass" method="POST">
				  @csrf
				 <b><label for="pass">GIVE PASSWORD TO ACCESS ADMIN:</label></b>   <input type="PASSWORD" name="pass" id="pass" required> <br>

				 <b><p>{{session('mssg')}}</p></b>

				 <input type="submit" value="GET DATABASE ACESS"> 
				</form>
				<style type="text/css">
									.footer {
   position: fixed;
}

				</style>


@endsection


