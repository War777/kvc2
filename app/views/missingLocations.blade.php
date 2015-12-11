@extends('layout')

@section('title')
	Ubicaciones faltantes
@stop

@section('h1')
	Ubicaciones faltantes
@stop

@section('content')

	@if(count($data['records']) > 1)
		
		<table class="table table-hover table-bordered table-condensed">
			<thead class="bg-info" align="center">
				<td>Ubicacion</td>
				<td>Area</td>
			</thead>

		@foreach($data['records'] as $record)
			
			<tr>
				
				<td> 
					@if(Own::startsWith($record['ubi'], '0') || Own::startsWith($record['ubi'], '1'))
							
						{{ "'" . $record['ubi'] }}
						
					@else

						{{ $record['ubi'] }}

					@endif
				</td>
				
				<td>
					
					@if(Own::startsWith($record['are'], '0') || Own::startsWith($record['are'], '1'))
							
						{{ "'" . $record['are'] }}
						
					@else

						{{ $record['are'] }}

					@endif

				</td>

				
			</tr>

		@endforeach

		</table>
	
	@else
		
		<center>

			<p class="bg-danger">
				Diccionario vacio
			</p>

		</center>

	@endif

@stop