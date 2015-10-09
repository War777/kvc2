@extends('layout')

@section('title')
	Edit Layout
@stop

@section('h1')
	Edit Layout
@stop

@section('content')

	<div class="row">

		<div class="col-sm-2">
			
			<h3>
				<i class="glyphicon glyphicon-plus"></i>
				Add Area
			</h3>

			<hr>

			<div class="input-group-sm">
				
				<input type="text" id="areaName" class="form-control" placeholder="Area" value="A">

				<input type="text" id="subAreasNumber" class="form-control" placeholder="Sub areas" value="2">

				<input type="text" id="locationsPerSubArea" class="form-control number" placeholder="Carriles por sub area" value="26">

				<select name="" id="align">
					<option value="">Alineacion...</option>
					<option value="h">Horizontal</option>
					<option value="v" selected="selected">Vertical</option>
				</select>
				
				<br><br>

				<div id="subAreas">
					
				</div>

				<button type="button" id="createArea" class="btn btn-primary btn-xs">
					Create Area
				</button>

				<button type="button" id="getAxises" class="btn btn-primary btn-xs">
					Get Axises
				</button>

			</div>
			
		</div>

		<div class="col-sm-10">
			
			<h3>
				<i class="glyphicon glyphicon-th"></i>
				Areas
			</h3>

			<hr>

			<table id="tableAreas" class="table table-condensed table-bordered table-striped table-hover">
				
				<thead align="center">
					
					<td>Area</td>
					<td>Sub areas</td>
					<td>Carriles</td>
					<td>Orientacion</td>
					<td>Top</td>
					<td>Left</td>
					<td>Width</td>
					<td>Height</td>

				</thead>

			</table>

		</div>

	</div>

	<div class="row">

		<div class="col-sm-12" style="">

			<h3>Layout</h3>

			<div id="layout" class="layout">

			</div>

		</div>
	
	</div>


@stop