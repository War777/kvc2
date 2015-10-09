@extends('layout')

@section('title')
	KVM
@stop

@section('h1')
	Storage Capacity
@stop

@section('content')
	
	<h3>General Data</h3>

	<div class="table-responsive">
		
		<table class="table table-bordered table-condensed table-hover">

			<thead align="center">
				<td>
					Total Pallets
				</td>
				<td>
					Total Capacity
				</td>
				<td>
					Storage Percentaje
				</td>
			</thead>

			<tr align="center">

				<td> {{ $data['generalData']['totalPallets'] }} </td>

				<td> {{ $data['generalData']['totalCapacity'] }} </td>
				
				<td> {{ $data['generalData']['storagePercentage'] }} %</td>

			</tr>

		</table>

	</div>

	{{ Own::arrayToTable($data['records']) }}

@stop