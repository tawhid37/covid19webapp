@extends('layouts.layout')

@section('content')

	<div class="admin-header-bar my_text_new">
		COVID-19 Self-Assessment System Users Data
	</div>

	<div class="admin-main-container">
		<h1 class="admin-page-title">Admin - Users Data</h1>
		<div class="admin-records-count">
			Showing {{ $covid->firstItem() ?? 0 }}–{{ $covid->lastItem() ?? 0 }} of {{ $covid->total() }} records
		</div>

		<div style="overflow-x:auto; margin: 16px 0;">
			<table class="admin-table" aria-label="Submitted COVID-19 self-assessments">
				<thead>
				<tr>
					<th scope="col">ID</th>
					<th scope="col">NAME</th>
					<th scope="col">Age</th>
					<th scope="col">Sex</th>
					<th scope="col">Temperature</th>
					<th scope="col">Assessment Score</th>
					<th scope="col">COVID-19 Result</th>
					<th scope="col">Data Given</th>
				</tr>
				</thead>
				<tbody>
				@foreach($covid as $c)
					<tr>
						<td>{{ $c->id }}</td>
						<td>{{ $c->Name }}</td>
						<td>{{ $c->Age }}</td>
						<td>{{ $c->SEX }}</td>
						<td>{{ $c->Temperature }}</td>
						<td>{{ $c->Score }}</td>
						<td class="{{ strtolower($c->Result) == 'positive' ? 'status-positive' : 'status-negative' }}">
							{{ $c->Result }}
						</td>
						<td>{{ $c->created_at }}</td>
					</tr>
				@endforeach
				</tbody>
			</table>
		</div>

		<div class="pagination">
			{{ $covid->links() }}
		</div>

		<div style="margin-top: 24px; display: flex; gap: 12px; flex-wrap: wrap;">
			<form action="{{ route('adminshow.export') }}" method="GET" style="display:inline;">
				<button type="submit">EXPORT CSV</button>
			</form>
			<form action="{{ route('logout') }}" method="POST" style="display:inline;">
				@csrf
				<button type="submit">LOGOUT</button>
			</form>
		</div>
	</div>

@endsection