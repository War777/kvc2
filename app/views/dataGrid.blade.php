@extends('layout')

@section('title')

	Data Grid

@stop

@section('h1')
	Data grid
@stop

@section('content')
	
	<div 
		class="dinamicGrid"
		title="Data" 
		query="select * from sto_mac limit 100;"
		table="sto_mac"
	>
		
	</div>

@stop