@extends('layout')

@section('title')
	Revision de estibas
@stop

@section('h1')
	Revision de estibas
@stop

@section('content')
	
	@if($caoticStowages)

		<table class="table table-condensed table-bordered table-hover">

			<thead class="bg-info">
				<td>Sku</td>
				<td>Estiba</td>
			</thead>
			
			@foreach($caoticStowages as $caoticStowage)

				<tr>
					<td> {{ $caoticStowage['sku'] }} </td>
					<td> {{ $caoticStowage['estIba'] }} </td>
				</tr>

			@endforeach

		</table>

	@endif
	
@stop

@section('localScript')

@stop