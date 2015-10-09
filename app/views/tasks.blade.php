@extends('layout')

@section('title')
	Tareas
@stop

@section('h1')
	Tareas
@stop

@section('content')
	
	<div class="row">

		<div class="col-lg-6">

			<legend>
				Tareas que liberan carriles
			</legend>

			@if(count($data['toRecords']) > 0)

				<table class="table table-hover table-bordered table-condensed">
					<thead class="bg-info" align="center">
						<td>Ubicacion origen</td>
						<td>Ubicacion destino</td>
						<td>Lpns por mover</td>
					</thead>

					@foreach($data['toRecords'] as $record)
						
						<tr align="center">
							<td>'{{ $record['idLoc'] }} </td>
							<td>'{{ $record['idToLoc'] }} </td>
							<td> {{ $record['lpn'] }} </td>
						</tr>

					@endforeach

				</table>
			
			@else
				
				<center>

					<p class="bg-danger">
						Sin tareas que liberen carriles
					</p>

				</center>

			@endif

		</div>

		<div class="col-lg-6">

			<legend>
				Tareas que mejoran la consolidacion
			</legend>

			@if(count($data['fromRecords']) > 0)

				<table class="table table-hover table-bordered table-condensed">
					<thead class="bg-info" align="center">
						<td>Ubicacion destino</td>
						<td>Ubicacion origen</td>
						<td>Lpns por mover</td>
					</thead>

					@foreach($data['fromRecords'] as $record)
						
						<tr align="center">
							<td>'{{ $record['idLoc'] }} </td>
							<td>'{{ $record['idFroLoc'] }} </td>
							<td> {{ $record['lpn'] }} </td>
						</tr>

					@endforeach

				</table>
			
			@else
				
				<center>

					<p class="bg-danger">
						Sin tareas que liberen carriles
					</p>

				</center>

			@endif

		</div>

			
		
	</div>



@stop