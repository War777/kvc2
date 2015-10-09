/*
* Funciones Javascript propias de la aplicacion
*/

//Esperamos a que el documento este listo
$(document).ready(function(){

	/*
	* Funcion para manejar la barra de estado
	*/

	function loadingState(loading, responseText){

		if(loading == true){

			//Limpiamos el mensaje y ocultamos el contenedor de retro
			$('#loadingRetroContainer').html('');
			$('#loadingRetroContainer').hide('fast');

			//Mostramos la barra de carga
			$('#loadingBarContainer').show('fast');

			//Mostramos el modal
			$('#modalLoadingState').modal('show');

		} else {

			//Ocultamos la barra de carga
			$('#loadingBarContainer').hide('fast');

			//Mostramos el contenedor de retro
			$('#loadingRetroContainer').html(responseText);
			$('#loadingRetroContainer').show('fast');

			//Ajustamos el fondo del modal
			$('#modalLoadingState').modal('adjustBackdrop');
		}

	}

	/*
	* ==================
	*/

	/*
	* Funcionalidad para mostrar u ocultar el menu lateral
	* 'layout.blade.php'
	*/
	$("#side-toggler").click(function(e) {
	    e.preventDefault();
	    $("#wrapper").toggleClass("toggled");
	});

	/*
	* Menejador para la creacion de las areas dentro de la edicion del layout
	* 'editLayout.blade.php'
	*/
	$('#createArea').click(function(){

    	createArea();

    });

	/*
	* Menejador para la obtencion de los datos relacionados a las areas en el layout
	* 'editLayout.blade.php'
	*/
	$('#getAxises').click(function(){

    	getAxises();

    });


	//Funcion para agregar las subareas en la edicion del layout
	$('#subAreasNumber').keyup(function(e){
    	if(e.keyCode >= 48 && e.keyCode <= 57){

    	} else {
    		var value = String($(this).val());
    		var length = value.length;
    		$(this).val(value.substring(0, length-1));
    		
    	}

    });

    $('.runAjaxController').click(function(){

    	var controller = $(this).attr('controller');

    	if(controller != ''){

	    	$.ajax({

	    		url: 'runAjaxController',
	    		method: 'POST',
	    		dataType: 'json',
	    		data: {
	    			'controller' : controller
	    		}, 

	    		beforeSend: function(){

	    			loadingState(true, '');

	    		}, 

	    		success: function(response){

	    			loadingState(false, response.responseText);
	    			l(response);


	    		}, 

	    		error: function(response){
	    			loadingState(false, response.responseText);
	    		}, 

	    		complete: function(response){

	    			// loadingState(false, response.responseText);
	    			// l(response);

	    		}

	    	});

    	} else {

    		alert('No se ha definido el controlador para esta accion');

    	}

    	
    });

    $('.ajaxForm').submit(function(e){

    	e.preventDefault();

		var form = $(this);

    	var controller = $(form).attr('controller');
		
		var datas = new Object();

		datas.controller = controller;

		var inputs = new Object();

		$(form).find(':input').each(function(index, input){
			
			if($(input).attr('name') && $(input).val()){
				
				inputs[$(input).attr('name')] = $(input).val();

			}

		});

		datas.inputs = inputs;

		$.ajax({
		
			'url': 'ajaxForm',
			'method': 'POST',
			'data': {
				'data' : datas
			},

			beforeSend: function(){
				
				$('#loadingRetroContainer').html('');
				$('#modalLoadingState').modal('show');

			}, 

			success: function(response){
				$('#loadingRetroContainer').html(response);
	    		$('#modalLoadingState').modal('adjustBackdrop');
			},

			error: function(response){
			},

			complete: function(){
			}
		});		
    	
    });


    $('.ajaxDictionaryForm').submit(function(e){

    	e.preventDefault();

		var form = $(this);

		var table = $(form).attr('table');

    	var controller = $(form).attr('controller');
		
		var data = new Object();

		data.table = table;

		data.controller = controller;

		var records = new Array();

		//Recorremos las filas dentro del cuerpo de la tabla que contiene la forma
		$(form).find('tbody > tr').each(function(index, row){

			var record = new Object();

			//Recorremos todos los inputs dentro de la fila
			$(row).find(':input').each(function(index, input){

				if($(input).attr('name') && $(input).val()){
			
					record[$(input).attr('name')] = $(input).val();

				}

			});

			records.push(record);

		});

		data.records = records;

		l(data);

		$.ajax({
		
			'url': 'ajaxDictionaryForm',
			'method': 'POST',
			'data': {
				'data' : data
			},

			beforeSend: function(){
				
				$('#loadingRetroContainer').html('');
				$('#modalLoadingState').modal('show');

			}, 

			success: function(response){
				$('#loadingRetroContainer').html(response);
	    		$('#modalLoadingState').modal('adjustBackdrop');
			},

			error: function(response){
			},

			complete: function(){
			}
		});		
    	
    });


    $('body').delegate('.numeric', 'keypress', function(evento){
			
		var texto = $(this).val();
		var longitud = texto.length;

		var key = window.Event ? evento.which : eevento.keyCode

		if(key == 46){
			var existePunto = false;
			for(var i = 0; i < longitud; i++){
				if(texto.charAt(i) == '.'){
					existePunto = true;
				}
			}

			if(existePunto == true){
				return false;
			}

		} else if(key == 45){

			if(longitud > 0){
				return false;
			}


		} else{

			return (key >= 48 && key <= 57)

		}
		
	});

});


/*
* Funcion para crear una area dentro del layout del almacen
*/
function createArea(){

	var table = $('<table>').addClass('area'); 						//Creamos una tabla con la clase 'area'

	var align = $('#align option:selected').val();					//Obtenemos la orientacion

	if(align != ''){												//Verificamos que este seleccionada una orientacion

		var areaName = $('#areaName').val();						//Obtenemos el nombre del area

		var subAreasNumber = parseInt($('#subAreasNumber').val());	//Obtenemos el numero de subareas que contendra

		var locationsPerSubArea = parseInt($('#locationsPerSubArea').val()); //Obtenemos el numero de carriles

		if(align == 'h'){ 											//Rutina para areas con alineacion Horizontal

			for(var i = 1; i <= subAreasNumber; i++){

				var row = $('<tr/>');

				for(var j = 1; j <= locationsPerSubArea; j++){

					var location = j;

					if(j < 10){

						location = '0' + j;

					}

					var column = $('<td/>').attr({
						id: areaName + '' + i + '-' + location
					})
					.addClass('location');

					$(column).appendTo(row);

				}

				$(row).appendTo(table);

			}

		} else if(align == 'v'){ 									//Rutina para areas con alineacion Horizontal

			for(var j = 1; j <= locationsPerSubArea; j++){

				var row = $('<tr/>');
				
				var location = j;

				if(j < 10){

					location = '0' + j;

				}

				for(var k = 1; k <= subAreasNumber; k++){

					var column = $('<td/>').attr({
						id: areaName + '' + k + '-' + location
					})
					.addClass('location');

					$(column).appendTo(row);

				}

				$(row).appendTo(table);

			}

			$(row).appendTo(table);

		} 

		//Asignamos las propiedades a la tabla que representa el area
		$(table).attr({
			id: areaName,
			subAreas: subAreasNumber,
			lanes: locationsPerSubArea, 
			orientation: align
		});

		$(table).appendTo('#layout');	//La adherimos al contenedor del layout

		//Definimos que el area sera deslizable solo dentro del layout
		$(table).draggable({
			containment: 'parent',
    		scroll: false
    	});

		//Definimos la animacion del redimensionado
    	$(table).resizable({
    		animate: true
    	});

    	//Designamos el area a la esquina superior izquierda del layout como default
    	$(table).css({
    		position: 'absolute',
    		top: 70,
    		left: 70
    	});

	} else {	

		alert('Seleccione una orientacion'); //Si no hay una orientacion asignada mandamos el mensaje a pantalla

	}

}

function getAxises(){

	var areas = $('.layout > .area');

	$(areas).each(function(){
		
		var name = $(this).attr('id');
		var subAreas = $(this).attr('subAreas');
		var lanes = $(this).attr('lanes');
		var orientation = $(this).attr('orientation');

		var top = $(this).css('top');
		var left = $(this).css('left');
		var width = $(this).css('width');
		var height = $(this).css('height');

		var row = '';

		row += '<tr align="center">';
			
			row += '<td>' + name + '</td>';
			row += '<td>' + subAreas + '</td>';
			row += '<td>' + lanes + '</td>';
			row += '<td>' + orientation + '</td>';
			row += '<td>' + top + '</td>';
			row += '<td>' + left + '</td>';
			row += '<td>' + width + '</td>';
			row += '<td>' + height + '</td>';

		row += '</tr>';

		$('#tableAreas').append(row);

	});

}


/*
* Funcion para mandar a consola cualquier objeto/variable
*/
function l(object){
	console.log(object);
}

/*
* Funcion que valida elementos de tipo INPUT TEXT 
* Verifica que solo contengan numero con o sin punto decimal
* para agregar esta funcionalidad basta con agregar la clase 'numero' al input
*/
$('body').delegate('.number', 'keypress', function(evento){
		
	var texto = $(this).val();
	var longitud = texto.length;

	var key = window.Event ? evento.which : eevento.keyCode

	if(key == 46){
		var existePunto = false;
		for(var i = 0; i < longitud; i++){
			if(texto.charAt(i) == '.'){
				existePunto = true;
			}
		}

		if(existePunto == true){
			return false;
		}

	}else{
		return (key >= 48 && key <= 57)
	}
	
});