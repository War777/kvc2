/*
* Funcionalidades para el boton aceptar
*/

$(document).ready(function(){

	//Oculamos el boton
	$('#btnAceptar').hide();

	//Definimos el evento al hacer clic para recargar la pagina
	$('#btnAceptar').click(function(){
		location.reload();
	});
	
	//Funcionalidad para cerrar el dialogo
	$('.cerrarModal').click(function(){
		
		$('#jfuModal').modal('hide');
		$('#jfuProgress').removeClass('progress-striped');
		$('#jfuProgress').removeClass('active');
		$('#jfuProgress .progress-bar').text('');
		$('#jfuProgress .progress-bar').css('width','0%');
		
		$('#jfuProgress').css('opacity','0');
		$('#jfuProgress').css('display','none');

		$('#fileContainer').css('opacity', 0);
		$('#fileContainer').css('display', 'none');
		$('#fileContainer').remove();

		$('#addButCon').html('');

		$('#addedContainer').css('opacity', 1);
		$('#addedContainer').css('display', 'inline');
		$('#retro').html('');

		$('#table').val('');
		$('#requiredFile').text('');
		$('#periodExists').val('');
		$('#post').val('');

	});
	
	//Activar el modal
	$('.activarModal').click(function(){
		
		$('#table').val($(this).attr('table'));
		$('#post').val($(this).attr('post'));
		
		$('#periodExists').val($(this).attr('periodExists'));

		$('#requiredFile').html($(this).attr('requiredFile'));
		
		$('#jfuModal').modal('show');
		$('#btnCancelar').show('fast');
		$('#btnAceptar').hide('fast');

	});
	
	//Funcionalidad del File Uploader
	$(function () {
		
		// Change this to the location of your server-side upload handler:
		var url = '../uploadedFiles/php/';
			
		var uploadButton = $('<button/>')
			.addClass('btn btn-primary btn-xs')
			// .prop('disabled', true)
			.attr('id', 'btnCargar')
			.html('<i class="glyphicon glyphicon-play"><i/>')
			.append('Cargar')
			.on(
				'click', 
				function () {
					
					var $this = $(this);
					var data = $this.data();

					$this
						.off('click')
						.html('<i class="glyphicon glyphicon-stop"><i/>')
						.append('Abortar')
						.on(
							'click', 
							function () {
								l(data);
								// $this.remove();
								data.abort();

								$('#fileContainer').css('opacity', 0);
								$('#fileContainer').css('display', 'none');

								$('#fileContainer').remove();
								$('#addedContainer').css('display', 'inline');
								$('#addedContainer').css('opacity', 1);

								$('#jfuProgress').css('opacity', 0);
								$('#jfuProgress').css('display', 'none');					//Ocultamos la barra de progreso.
								$('#jfuProgress .progress-bar').css('width','0%');
								$('#jfuProgress .progress-bar').text('');
								$('.cerrarModal').removeClass('disabled');
							}
						);
			
					data.submit().always(
						function () {
							$this.remove();
							$('#btnEliminar').remove();
						}
					);
				}
			);

		var abortButton = $('<button/>')
				.addClass('btn btn-danger btn-xs')
				.attr('id', 'btnAbort')
				.text('Cancelar')
				.on('click', function(){
					var $this = $(this);
					var data = $this.data();

					l(data);

					data.abort();
					// $this.remove();

					data.submit().always(
						function () {
							// $this.remove();
							// $('#btnAbort').remove();
						}
					);

				})

				
		$('#fileupload').fileupload({
			
			url: url,
			dataType: 'json',

			autoUpload: false,
			
			singleFileUploads: false,

			acceptFileTypes: /(\.|\/)(csv)$/i,

			maxFileSize: 40000000, // 40 MB
			// Enable image resizing, except for Android and Opera,
			// which actually support image resizing, but fail to
			// send Blob objects via XHR requests:
			disableImageResize: /Android(?!.*Chrome)|Opera/
				.test(window.navigator.userAgent),
			
			previewMaxWidth: 50,
			previewMaxHeight: 50,
			previewCrop: true

		}).on('fileuploadadd', function (e, data) {

		}).on('fileuploadprocessalways', function (e, data) {

			var index = data.index;
			var file = data.files[index];

			if(!file.error){
				
				if (index + 1 === data.files.length) {
						
					// $('.cerrarModal').addClass('disabled');

					data.context = $('<div/>')						//Creamos el Contenedor
									.appendTo('#files')
									.attr('id', 'fileContainer');

					$('#fileContainer').css('display', 'block');
					$('#fileContainer').css('opacity', 1);
							
					$('#addButCon').append(uploadButton.clone(true).data(data));
					
					var node = $('<p/>');

					node
						.append(
							$('<div/>')
								.attr('class', 'glyphicon glyphicon-file')
								.text(file.name)
								.attr('id', 'fileName')
						)							
						.addClass('text-muted');
						// .append($('<br/>')

					
							
					node.appendTo(data.context);
					
					$('#addedContainer').css('opacity', 0);
					$('#addedContainer').css('display', 'none');

					$('#jfuProgress').css('display', 'block');
					$('#jfuProgress').css('opacity', 1);	

				}

			}

		}).on('fileuploadprogressall', function (e, data) {

			setTimeout(function() {}, 100);

			var progress = parseInt(data.loaded / data.total * 100, 10);

			$('#jfuProgress .progress-bar').css(
				'width',
				progress + '%'
			);
			
			$('#jfuProgress .progress-bar').text(
				progress + '%' + ' Cargado...'
			);
			
		}).on('fileuploaddone', function (e, data) {
			
			if( $('#fileName').text() != '' &&  $('#table').val() != ''){

				var periodo = $('#periodo').text();
				periodo = periodo.trim();

				$.ajax({
					url: 'loadCsv',
					method: 'POST',
					data:{

						'table' : $('#table').val(),
						'file' : $('#fileName').text(),
						'periodExists' : $('#periodExists').val(),
						'post': $('#post').val()

					},

					beforeSend: function(){

						$('#jfuProgress .progress-bar').text(
							'¡Actualizando Modulo!'
						); 
						$('#jfuProgress').addClass('progress-striped');
						$('#jfuProgress').addClass('active');
						$.each($('.cerrarModal'), function(clave, elemento){
							$(elemento).attr('disabled', 'disabled');
						});

					},
					success: function(respuesta){
						l('success');
						l(respuesta);
						$('#retro').html(respuesta);
						
					},
					error: function(respuesta){
						l('error');
						l(respuesta);
						var mensaje = 'Error: ';
						
						mensaje = mensaje + '<br>' + respuesta.status + '->' + respuesta.responseText;

						$('#retro').html(mensaje);

					},

					complete: function(){

						$('#jfuProgress').removeClass('progress-striped');
						$('#jfuProgress').removeClass('active');
						$('#jfuProgress .progress-bar').text('¡Hecho!');
						$('#btnCancelar').hide('fast');
						$('#btnAceptar').show('fast');
						$.each($('.cerrarModal'), function(clave, elemento){$(elemento).removeAttr('disabled');});

					}
				});
				
			}else{
				alert('Error: Faltan datos auxiliares para la exportaci&oacute;n\n'+
					'Favor de contactar al Administrador de IT de KVC'
				);
			}
							
		}).on('fileuploadfail', function (e, data) {

			alert('Error');
			
			// l('abort');
			// l(data);

			// $.each(data.result.files, function (index, file) {
			// 	var error = $('<span/>').text(file.error);
			// 	$(data.context.children()[index])
			// 		.append('<br>')
			// 		.append(error);
			// });
			
		}).prop('disabled', !$.support.fileInput)
			.parent().addClass($.support.fileInput ? undefined : 'disabled');
	});
		
});
	