@extends('layout')

@section('title')
	Almacenaje general
@stop

@section('h1')
	Almacenaje general
@stop

@section('content')

	<div class="row">
		<div class="col-md-12 text-right">

			<button type="button" class="btn btn-info btn-lg runAjaxController" controller="StorageController@runStorageCapacity">
				<i class="glyphicon glyphicon-refresh"></i>
				Actualizar
			</button>
					
		</div>
	</div>

	@if($data['warehouses'])

		@foreach($data['warehouses'] as $warehouse)
			
			<center>
				<h2>
					{{ $warehouse['ced'] }}
				</h2>
			</center>
			

			@foreach($warehouse['categories'] as $category)

				<br>

				<div class="row">

					<legend> {{ $category['cat'] }} </legend>

					<div class="col-lg-6">

						<div id="pre{{$warehouse['idCed'] . $category['idCat'] }}Chart">
							
						</div>
						
					</div>

					<div class="col-lg-6">

						<div id="post{{$warehouse['idCed'] . $category['idCat'] }}Chart">
							
						</div>
						
					</div>
				
				</div>
				

				<div class="row">
					<div class="col-md-12">

						<table class="table table-bordered table-condensed table-hover">
				
							<thead align="center" class="bg-info">
								<td> {{ $category['cat'] }} </td>
								<td>Actual</td>
								<td>Optimizada</td>
							</thead>

							<tr>
								<td>Lpns</td>
								<td class="text-center">
									{{ $category['lpnsCounter'] }}
								</td>
								<td class="text-center">
									{{ $category['lpnsCounter'] }}
								</td>
							</tr>

							<!-- <tr>
								<td>Paps para consolidacion </td>
								<td class="text-center"> -->
									<!-- {{ $category['caoticCapacity'] + $category['preConsolidationPaps'] }} -->
								<!-- </td>
								<td class="text-center"> -->
									<!-- {{ $category['caoticCapacity'] + $category['postConsolidationPaps'] }} -->
								<!-- </td>
							</tr> -->
							
							<!-- <tr>
								<td>Paps para ocupacion </td>
								<td class="text-center">
									{{ $category['caoticCapacity'] + $category['prePaps'] }}
								</td>
								<td class="text-center">
									{{ $category['caoticCapacity'] + $category['postPaps'] }}
								</td>
							</tr> -->
							
							<<!-- tr>
								<td>Capacidad de la existencia</td>
								<td class="text-center">
									{{ $category['caoticCapacity'] + $category['preCapacity'] }}
								</td>
								<td class="text-center">
									{{ $category['caoticCapacity'] + $category['postCapacity'] }}
								</td>
							</tr> -->

							<tr>
								<td>Capacidad total</td>
								<td class="text-center">
									<a href="totalCapacity/{{$warehouse['idCed']}}/{{$category['idCat']}}" target="_blank">
										{{ $category['totalCapacity'][0]['totalCapacity'] }}
									</a>
								</td>
								
								<td class="text-center">
									<a href="totalCapacity/{{$warehouse['idCed']}}/{{$category['idCat']}}" target="_blank">
										{{ $category['totalCapacity'][0]['totalCapacity'] }}
									</a>
								</td>

							</tr>
							
							<tr>	
								<td>
									Consolidacion
								</td>
								<td class="text-center">
									{{ number_format(($category['caoticCapacity'] + $category['preConsolidationPaps']) / ($category['caoticCapacity'] + $category['preCapacity']) * 100, 2)  }} %
								</td>
								<td class="text-center">
									{{ number_format(($category['caoticCapacity'] + $category['postConsolidationPaps']) / ($category['caoticCapacity'] + $category['postCapacity']) * 100, 2) }} %
								</td>
							</tr>

							<tr>	
								<td>
									Ocupacion
								</td>
								<td class="text-center">
									{{ number_format(($category['caoticCapacity'] + $category['prePaps']) / ($category['totalCapacity'][0]['totalCapacity']) * 100, 2) }} %
								</td>
								<td class="text-center">
									{{ number_format(($category['caoticCapacity'] + $category['postPaps']) / ($category['totalCapacity'][0]['totalCapacity']) * 100, 2) }} %
								</td>
							</tr>

							<tr>	
								<td>
									Ubicaciones vacias
								</td>
								<td class="text-center">
									<a href="emptyLocations/{{$warehouse['idCed']}}/{{$category['idCat']}}/1" target="_blank">
										{{ $category['preEmptyLocations'] }}
									</a>
								</td>
								<td class="text-center">
									<a href="emptyLocations/{{$warehouse['idCed']}}/{{$category['idCat']}}/0" target="_blank">
										{{ $category['postEmptyLocations'] }}
									</a>
								</td>
							</tr>
							
							<tr>	
								<td>
									Pallets a piso disponibles
								</td>
								<td class="text-center">
									{{ $category['preEmptyPaps'] }}
								</td>
								<td class="text-center">
									{{ $category['postEmptyPaps'] }}
								</td>
							</tr>

							<tr>	
								<td>
									Unidades disponibles
								</td>
								<td class="text-center">
									{{ ceil($category['preEmptyPaps'] / 28) }}
								</td>
								<td class="text-center">
									{{ ceil($category['postEmptyPaps'] / 28) }}
								</td>
							</tr>

							<tr>

								<td>
									Ubicaciones por consolidar
								</td>

								<td colspan="2" class="text-center">
									
									<a href="consolidableLocations/{{$warehouse['idCed']}}/{{$category['idCat']}}/1" target="_blank">
										Ver
									</a>

								</td>
								
								<!-- <td class="text-center">
									
									<a href="consolidableLocations/{{$warehouse['idCed']}}/{{$category['idCat']}}/0" target="_blank">
										Ver
									</a>

								</td> -->

							</tr>

							<tr>

								<td>
									Ubicaciones caoticas
								</td>

								<td class="text-center" colspan="2">
									
									<a href="caoticLocations/{{$warehouse['idCed']}}/{{$category['idCat']}}" target="_blank">
										Ver
									</a>

								</td>
								
							</tr>

							<tr>	
								<td>
									Tareas
								</td>
								<td class="text-center" colspan="2">
									
									<a href="tasks/{{$warehouse['idCed']}}/{{$category['idCat']}}" target="_blank">
										Ver
									</a>

								</td>
							</tr>

						</table>
						
					</div>

				</div>
				

			@endforeach

		@endforeach	

	@endif

@stop

@section('localScript')
	
	<script src="j/highcharts.js"></script>

	<script src="j/exporting.js"></script>

	<script>


		$(document).ready(function(){
			
			var warehouses = <?= json_encode($data['warehouses']); ?>;

			l(warehouses);


			$.each(warehouses, function(wIndex, warehouse){

				$.each(warehouse.categories, function(cIndex, category){

					var preChartContainer = '#pre' + warehouse.idCed + category.idCat + 'Chart';
					var postChartContainer = '#post' + warehouse.idCed + category.idCat + 'Chart';

					var preOcupancy = parseInt(category.prePaps) + parseInt(category.caoticCapacity);
					var preDeadSpace = (parseInt(category.caoticCapacity) + parseInt(category.preCapacity)) - preOcupancy;
					var preAvailableSpace = parseInt(category.totalCapacity[0].totalCapacity) - (preOcupancy);

					var postOcupancy = parseInt(category.postPaps) + parseInt(category.caoticCapacity);
					var postDeadSpace = (parseInt(category.caoticCapacity) + parseInt(category.postCapacity)) - postOcupancy;
					var postAvailableSpace = parseInt(category.totalCapacity[0].totalCapacity) - (postOcupancy);

					

					var preDataValues = [

						{
							name : 'Ocupacion',
							y : preOcupancy,
							color: '#66CCFF'
						},

						{
							name : 'Disponible',
							y : preAvailableSpace,
							color: '#33CC33'
						}

					];

					var postDataValues = [

						{
							name : 'Ocupacion',
							y : postOcupancy,
							color: '#66CCFF'
						},

						{
							name : 'Disponible',
							y : postAvailableSpace,
							color: '#33CC33'
						}

					];

					$(preChartContainer).highcharts({
				        chart: {
				            plotBackgroundColor: null,
				            plotBorderWidth: null,
				            plotShadow: false,
				            type: 'pie',
				        },
				        title: {
				            text: 'Actual',
				            floating: true,
				            align: 'left'
				        },
				        tooltip: {
				            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
				        },
				        plotOptions: {
				            pie: {
				                allowPointSelect: true,
				                cursor: 'pointer',
				                dataLabels: {
				                    enabled: true,
				                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
				                    style: {
				                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
				                    }
				                }
				            }
				        },
				        series: [{
				            name: "Brands",
				            colorByPoint: true,
				            data: preDataValues
				        }]
				    });

					$(postChartContainer).highcharts({
				        chart: {
				            plotBackgroundColor: null,
				            plotBorderWidth: null,
				            plotShadow: false,
				            type: 'pie',
				        },
				        title: {
				            text: 'Optimizada',
				            floating: true,
				            align: 'left'
				        },
				        tooltip: {
				            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
				        },
				        plotOptions: {
				            pie: {
				                allowPointSelect: true,
				                cursor: 'pointer',
				                dataLabels: {
				                    enabled: true,
				                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
				                    style: {
				                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
				                    }
				                }
				            }
				        },
				        series: [{
				            name: "Brands",
				            colorByPoint: true,
				            data: postDataValues
				        }]
				    });

				});

			});

		});
	</script>
	
@stop