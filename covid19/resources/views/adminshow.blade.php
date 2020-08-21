@extends('layouts.layout')

@section('content')

				<div class="my_text_new">

                    COVID-19 Self-Assessment System Users Data </div>
				<table style ='border: 1px solid black;'>
                                  <tr>
                                    <th>ID</th>
                                    <th>NAME</th>
                                    <th>Age</th>
                                    <th>Sex</th>
                                    <th>Temperature</th>
                                    <th>Assessment Score</th>
                                    <th>COVID-19 Result</th>
                                    <th>Data Given</th>
                                  </tr>
                                  
				@foreach($covid as $c)
                  <div>
                  				 <tr>
									<td>{{ $c->id }}</td>
                                    <td>{{ $c->Name }}</td>
                                    <td>{{ $c->Age }}</td>
                                    <td>{{ $c->SEX }}</td>
                                    <td>{{ $c->Temperature }}</td>
                                    <td>{{ $c->Score }}</td>
                                    <td>{{ $c->Result }}</td>
                                    <td>{{ $c->created_at }}</td>
                                  </tr>
                                
                  </div>
                @endforeach
                </table>
				<a href="/logout">LOGOUT</a>

@endsection


