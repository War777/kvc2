@extends('layout')

@section('title')
	Queries personalizados
@stop

@section('h1')
	Queries personalizados
@stop

@section('content')

	@if(isset($data['test']))

		@if($data['test'] == 0)
			
			<div class="alert alert-danger alert-dismissible" role="alert">
				
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				
				{{ $data['message']; }} 

			</div>
		
		@elseif($data['test'] == 1)

			<div class="alert alert-success alert-dismissible" role="alert">
				
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				
				{{ $data['message']; }} 

			</div>

		@endif

	@endif


	<legend>
	
		Crear query

	</legend>

	<div class="row">
		
		<div class="col-md-12">
			
			<form action="customQueries" method="post" id="queryForm">
				
				Descripci&oacute;n

				<input type="text" name="description" class="form-control" required="required">

				<br>
				
				Query

				<textarea class="form-control" name="query" rows="10" required="required">
					
				</textarea>
				
				<br>

				<button type="submit" id="addQuery" class="btn btn-info pull-right">
					<i class="glyphicon glyphicon-plus"></i>
				</button>

			</form>

		</div>

	</div>


	@if(count($data['records']) > 0)

		<br>

		<table class="table table-condensed table-hover table-striped table-bordered">
			
			<thead align="center" class="bg-info">
				<td>Descripci&oacute;n</td>
				<td>Eliminar</td>
			</thead>

			@foreach($data['records'] as $record)

				<tr>
					<td>
						{{ $record['des'] }}
					</td>

					<td align="center">
						<button type="button" id="{{ $record['id'] }}" class="btn btn-xs btn-primary btn-info">
							<i class="glyphicon glyphicon-download"></i>
						</button>
					</td>

				</tr>

			@endforeach
		
		</table>

		<br>

	@else
		
		<br>

		<center>
			
			<h3>
				
				Sin queries dados de alta

			</h3>

		</center>

	@endif

@stop

@section('localScript')
	
@stop