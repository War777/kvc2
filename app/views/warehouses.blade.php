@extends('layout')

@section('tile')

	Add warehouse

@stop

@section('h1')
	
	Warehouses

@stop

@section('content')
	
	{{ Own::arrayToModelForm($formData); }}

@stop
