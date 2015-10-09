/*
*===========================================================
* Rutina para la creacion de Data Grids de Manera Sencilla
* 
* Las dependencias para el Plugin son
* 
* ../c/bootstrap.css
* ../c/fuelux3.css
* 
* ../j/jquery.js
* ../j/bootstrap.js
* ../j/funciones.js
* 
* Para agregar un Data Grid es necesacion insertar un elemtno HTML con las siguientes propiedades
* 
* <div 
* 	 title = "Titulo del Data Grid"
* 	 class = "dinamicGrid" 					//La clase debe ser definica tal cual como esta aqui
* 	query = "string en formato query para la consulta a la base de datos"
* >
* </div>
* 
* Y eeeeeeeeeeeeeeeeeeeeeeeeeeeeeeso es todo :)
* 
*===========================================================
*/


//Verificamos que el documento este completamente cargado
$(document).ready(function(){

	//Definimos el cuerpo del DataGrid
	var repeaterHtml = '<div class="fuelux fueluxContainer" style="opacity:1;">'
							 	+ '<div '
							 	+ '	class="repeater" '
							 	+ '	id="myRepeater" '
							 	// + '	data-staticheight="true" '
							 	// + '	style="position:relative; height: 100%; width: 100%;"'
							 	+ '	query="select * from "'
								+ '>'
								+ '	<div class="fuelux repeater-header">'
								+ '		<div class="repeater-header-left">'
								+ '			<span class="fuelux repeater-title">Vista</span>'
								+ '			<div class="repeater-search">'
								+ '				<div style="height:6px;"></div>'
								+ '				<div class="search input-group input-group-sm">'
								+ '					<input type="search" class="form-control" placeholder="Buscar"/>'
								+ '					<span class="input-group-btn">'
								+ '					  <button class="btn btn-default btn-xs" type="button">'
								+ '						  <span class="glyphicon glyphicon-search"></span>'
								+ '						  <span class="sr-only">Search</span>'
								+ '					  </button>'
								+ '					</span>'
								+ '				</div>'
								+ '			</div>'
									

								+ '			<div class="btn-group selectlist repeater-filters" data-resize="auto">'
												
								+ '				<!-- <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">'
								+ '					<span class="selected-label">&nbsp;</span>'
								+ '					<span class="caret"></span>'
								+ '					<span class="sr-only">Toggle Filters</span>'
								+ '				</button> -->'

								+ '				<ul class="dropdown-menu pull-right" role="menu">'
								+ '					<li data-value="all" data-selected="true"><a href="#">all</a></li>'
								+ '					<li data-value="draft"><a href="#">draft</a></li>'
								+ '					<li data-value="archived"><a href="#">archived</a></li>'
								+ '					<li data-value="active"><a href="#">active</a></li>'
								+ '				</ul>'

								+ '				<input class="hidden hidden-field" name="filterSelection" readonly="readonly" aria-hidden="true" type="text"/>'

								+ '			</div>'

								+ '		</div>'
								+ '		<div class="repeater-header-right">'
								
								+ '			<button type="button" class="updateRepeater btn btn-xs btn-default">Update</button>'
								+ ''
								+ ''
								+ ''
								+ ''

								+ '			<!-- <div class="btn-group repeater-views" data-toggle="buttons">'
								+ '				<label class="btn btn-default active">'
								+ '					<input name="repeaterViews" type="radio" value="list"><span class="glyphicon glyphicon-list"></span>'
								+ '				</label>'
								+ '				<label class="btn btn-default">'
								+ '					<input name="repeaterViews" type="radio" value="thumbnail"><span class="glyphicon glyphicon-th"></span>'
								+ '				</label>'
								+ '			</div> -->'
								+ '		</div>'
								+ '	</div>'
								+ '	<div class="repeater-viewport">'
								+ '		<div class="repeater-canvas"></div>'
								+ '		<div class="loader repeater-loader"></div>'

									+'		<br><br>'
									+		'<center class="centerProgressBar" style="opacity:1;">'
									+'			<div class="progress progress-striped active" style="max-width:200px;">'
									+'				<div class="progress-bar"   aria-valuenow="100" style="width:100%;">'
									+'					Cargando...'
									+'				</div>'
									+'			</div>'
									+'		</center>'

								+ '	</div>'
								+ '	<div class="repeater-footer">'
								+ '		<div class="repeater-footer-left">'
								+ '			<div class="repeater-itemization">'
								+ '				<span><span class="repeater-start"></span> - <span class="repeater-end"></span> de <span class="repeater-count"></span></span>'
								+ '				<div class="btn-group selectlist dropup" data-resize="auto">'
								+ '					<button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">'
								+ '						<span class="selected-label">&nbsp;</span>'
								+ '						<span class="caret"></span>'
								+ '						<span class="sr-only">Toggle Dropdown</span>'
								+ '					</button>'
								+ '					<ul class="dropdown-menu" role="menu">'
								+ '						<li data-value="10"><a href="#">10</a></li>'
								+ '						<li data-value="20" data-selected="true"><a href="#">20</a></li>'
								+ '						<li data-value="30"><a href="#">30</a></li>'
								+ '					</ul>'
								+ '					<input class="hidden hidden-field" name="itemsPerPage" readonly="readonly" aria-hidden="true" type="text"/>'
								+ '				</div>'
								+ '				<span>Filas por Página</span>'
								+ '			</div>'
								+ '		</div>'
								+ '		<div class="repeater-footer-right">'
								+ '			<div class="repeater-pagination">'
								+ '				<button type="button" class="btn btn-default btn-xs btn-sm repeater-prev">'
								+ '					<span class="glyphicon glyphicon-chevron-left"></span>'
								+ '					<span class="sr-only">Previous Page</span>'
								+ '				</button>'
								+ '				<label class="page-label" id="myPageLabel">Página</label>'
								+ '				<div class="repeater-primaryPaging active">'
								+ '					<div class="input-group input-group-sm input-append dropdown combobox dropup">'
								+ '						<input type="text" class="form-control" aria-labelledby="myPageLabel">'
								+ '						<div class="input-group-btn">'
								+ '							<button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">'
								+ '								<span class="caret"></span>'
								+ '								<span class="sr-only">Toggle Dropdown</span>'
								+ '							</button>'
								+ '							<ul class="dropdown-menu dropdown-menu-right"></ul>'
								+ '						</div>'
								+ '					</div>'
								+ '				</div>'
								+ '				<input type="text" class="form-control repeater-secondaryPaging" aria-labelledby="myPageLabel">'
								+ '				<span>of <span class="repeater-pages"></span></span>'
								+ '				<button type="button" class="btn btn-default  btn-xs repeater-next">'
								+ '					<span class="glyphicon glyphicon-chevron-right"></span>'
								+ '					<span class="sr-only">Next Page</span>'
								+ '				</button>'
								+ '			</div>'
								+ '		</div>'
							+ '		</div>'
						+ '		</div>'
					+ '		</div>';

	/*
	* Tomamos todos los contenedores con la clase .dinamicGrid 
	* para inicializar los Data Grid con las respectivas propiedades
	*/

	//Activamos las barras de carga y los titulos en cada repeater
	$('.dinamicGrid').each(function(){
		$(this).html('<h3>' + $(this).attr('title') + '</h3>');
		$(this).append(repeaterHtml);
		// $(this).append(loadingStateHtml);
	});

	//Mandamos construimos el repeater
	$('.dinamicGrid').each(function(){

		createRepeater(this);

	});


	$('body').delegate('.updateRepeater', 'click', function(event) {

		$('.dinamicGrid').each(function(){

			$(this).find('.repeater').repeater('destroy');
			$(this).append(repeaterHtml);
			createRepeater(this);

		});

	});

	// $('.updateRepeater').click(function(){
		
	// 	//Inicializamos cada DataGrid
	// 	$('.dinamicGrid').each(function(){

	// 		$(this).find('.repeater').repeater('destroy');
	// 		$(this).append(repeaterHtml);
	// 		createRepeater(this);

	// 	});

	// });

	/*
	* Funcion para crear un repeater dado el elemento contenedor con el html
	*/
	function createRepeater(gridContainer){

		var gridQuery = $(gridContainer).attr('query'); //Obtenemos el Query

		//Lanzamos la llamada Ajax
		$.ajax({
			url: '../getGridData.php',								//Este script procesa el query
			async: true,
			method: 'POST',
			dataType: 'json',
			data: {
				query: gridQuery
			},
			beforeSend: function(){loadingState(true)},
			error: function(response){alert(response.responseText.replace('<br>', '\n'));},
			success: function(response){
				
				if(response.respuesta){
					a(response.respuesta);
				}

				var columns = getGridColumns(response.columns);			//Transformamos las columnas en objetos para el Grid
				var itemns = response.items;							//Los registros ya tienen formato para ser agregados

				function customDataSource(options, callback) {
	
					var pageIndex = options.pageIndex;
					var pageSize = options.pageSize;

					var data = itemns;

					// sort by
					data = _.sortBy(data, function(item) {
						return item[options.sortProperty];
					});

					// sort direction
					if (options.sortDirection === 'desc') {
						data = data.reverse();
					}

					// search
					if (options.search && options.search.length > 0) {
						var searchedData = [];
						var searchTerm = options.search.toLowerCase();

						_.each(data, function(item) {
							var values = _.values(item);
							var found = _.find(values, function(val) {

								if(val.toString().toLowerCase().indexOf(searchTerm) > -1) {
									searchedData.push(item);
									return true;
								}
							});
						});

						data = searchedData;
					}

					var totalItems = data.length;
					var totalPages = Math.ceil(totalItems / pageSize);
					var startIndex = (pageIndex * pageSize) + 1;
					var endIndex = (startIndex + pageSize) - 1;
					if(endIndex > data.length) {
						endIndex = data.length;
					}

					data = data.slice(startIndex-1, endIndex);

					var dataSource = {
						page: pageIndex,
						pages: totalPages,
						count: totalItems,
						start: startIndex,
						end: endIndex,
						columns: columns,
						items: data
					};

					callback(dataSource);
				}

				/*
				* Una vez recibida la respuesta del servidor de base de datos 
				* ocultamos la barra de carga, mostramos el DataGrid y eliminamos la barra de carga
				*/
				
				var dataGrid = $(gridContainer)
												.find('.repeater')
												.repeater({
													list_selectable: false,
													list_noItemsHTML: 'Sin datos para esta consulta',
													dataSource: customDataSource
												});
			},

			complete: function(response){loadingState(false)}

		})
	}

	//Rutina para transformar un arreglo de String en Objetos para el Grid
	function getGridColumns(columns){

		var gridColumns = [];

		$.each(columns, function(indice, stringColumna){
			
			gridColumns.push(
				{
					label: stringColumna,
					property: stringColumna,
					sortable: true
				}
			);

		});
		
		return gridColumns;	
		
	}

});