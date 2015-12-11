<!DOCTYPE html>
<html lang="en">
<head>
	
	<meta charset="UTF-8">
	
	<meta name="viewport" content="initial-scale=1, maximum-scale=1">

	<link rel="shortcut icon" href="i/kelLog.png">
	
	<title>
		@yield('title', 'KVM')
	</title>

	{{ HTML::style('c/bootstrap.css'); }}
	{{ HTML::style('c/bootstrap-theme.css'); }} 
	{{ HTML::style('c/mainStyles.css'); }} 
	{{ HTML::style('c/jquery.fileupload-ui.css'); }} 
	{{ HTML::style('c/simple-sideBar.css'); }} 
	{{ HTML::style('c/fuelux3.css'); }} 


</head>
<body>

	{{-- Inicio del modal para el estado de carga --}}

	<div class="modal fade" id="modalLoadingState" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
		
		<div class="modal-dialog" role="document">
			
			<div class="modal-content">
				
				<div class="modal-header">

					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					
					<h4 class="modal-title" id="myModalLabel">Estado actual</h4>
					
				</div>
				
				<div class="modal-body">
					
					<div id="loadingBarContainer" class="row">
						
						<div class="col-sm-12">

							<div class="progress">
								<div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
									<span class="">Actualizando</span>
								</div>
							</div>

						</div>

					</div>

					<div class="row">
						
						<div id="loadingRetroContainer" class="col-sm-12">
							
							{{-- Contenedor de retro alimentacion del controlador ajax --}}

						</div>

					</div>				

					<div class="row">

						<div class="col-sm-12 text-right">

							<!-- <button type="button" class="btn btn-primary" id="update">Save changes</button> -->

							<button id="acceptModal" type="button" class="btn btn-success" data-dismiss="modal">
								<i class="glyphicon glyphicon-ok"></i>
								Aceptar
							</button>
							
						</div>
						
					</div>


				</div>

			</div>

		</div>

	</div>

	{{-- Fin del modal para el estado de carga --}}

	<nav class="navbar navbar-inverse navbar-fixed-top">
		
		<div class="container">
			
			<!-- Brand and toggle get grouped for better mobile display -->
		    <div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a id="side-toggler" class="navbar-brand" href="#">KVM</a>
		    </div>

		    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

		    	<div class="nav navbar-nav">

			    	<!-- <li>
			    		<a href="#">
			    			Seccion 1
			    		</a>
			    	</li>

			    	<li class="dropdown">

						<a href="#" data-toggle="dropdown"> 

							<b class="glyphicon glyphicon-asterisk"></b>Seccion 2 <small>Small</small>

							<span class="caret"></span>

						</a>

						<ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
							<li class="dropdown-submenu">
								<a tabindex="-1" href="#">Level 1</a>
								<ul class="dropdown-menu">
									<li><a href="#">Sub Level 11 </a></li>
									<li><a href="#">Sub Level 12 </a></li>
								</ul>
							</li>
						</ul>

					</li> -->

		    	</div>

		    	<ul class="nav navbar-nav navbar-right">
		    		
		    		<!-- <li class="dropdown">
		    			<a href="#" class="screen">
		    				Start
		    			</a>
		    		</li> -->

					<li class="dropdown">
			    		<a href="#" class="dropdown-toggle" data-toggle="dropdown">
			    			{{ Auth::user()->user}}
			    			<span class="caret"></span>
			    		</a>
			    		<ul class="dropdown-menu">
			    			<li>
			    				<a href="profile">Perfil</a>
			    			</li>
			    			<li>
			    				<a href="logout">Cerrar sesi&oacute;n</a>
			    			</li>
			    		</ul>
			    	</li>

			    </ul>

		    </div>

		</div>

	</nav>

	<div class="screen"></div>

	<div class="" id="wrapper">

		<div id="sidebar-wrapper" class="bg">

			<ul id="sidebar-nav" class="sidebar-nav">

                <!-- <li class="sidebar-brand">
                    
                    <a href="#">
                        Brand Title
                    </a>

                </li> -->
                <li>

                    <!--  <a 
                        data-toggle="collapse" 
                        data-parent="#sidebar-nav"
                        href="#collapseOne"
                        aria-expanded="false"
                        aria-controls="collapseOne"
                    >
                        Dashboard
                    </a>
                    
                    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">

                            <li>
                                <a href="">Algo</a>
                            </li>
                    </div> -->
                    <!-- <a data-toggle="collapse" data-parent="#menu-bar" aria-expanded="true" href="#collapseOne">
                        Item 1
                    </a>

                    <ul id="collapseOne" class="panel-collapse collapse">
                        <li><a href="#">Action</a></li>
                        <li><a href="#">Another action</a></li>
                        <li><a href="#">Something else here</a></li>
                    </ul>
 -->
                </li>

                <!-- <li>
                    <a href="#">Item 2</a>
                </li>
                <li>
                    <a href="#">Item 3</a>
                </li>
                <li>
                    <a href="#">Item 4</a>
                </li>

                <li>
                    <a href="generalStorage">Dashboard</a>
                </li>
                 -->

                <li>
                    <a href="home">Inicio</a>
                </li>

                <li>
                	<a data-toggle="collapse" data-parent="#menu-bar" aria-expanded="true" href="#dictinoaries">
                        Diccionarios
                    </a>

                    <ul id="dictinoaries" class="panel-collapse collapse">
                    	<li><a href="areas">Areas</a></li>
                        <li><a href="locations">Ubicaciones</a></li>
                        <li><a href="stowages"> Estibas y Estandares </a></li>
                        <li><a href="categories"> Categorias </a></li>
                        <li><a href="virtualAreas">Areas virtuales</a></li>
                        <li><a href="virtualLocations"> Ubicaciones virtuales </a></li>
                    </ul>

                </li>

                <li>
                	<a data-toggle="collapse" data-parent="#menu-bar" aria-expanded="true" href="#repositories">
                        Repositorios
                    </a>

                    <ul id="repositories" class="panel-collapse collapse">
                    	<li><a href="stock">Existencias en almacenes</a></li>
                        <li><a href="stockMp">Existencias en MP</a></li>
                    </ul>

                </li>

                <li>
                	<a data-toggle="collapse" data-parent="#menu-bar" aria-expanded="true" href="#settings">
                        Ajustes
                    </a>

                    <ul id="settings" class="panel-collapse collapse">
                    	<li><a href="emailRanges">Rangos de email</a></li>
                    </ul>

                </li>

                <li>
                    <a href="queries">Consultas</a>
                </li>

                <li>
                	
                	<a data-toggle="collapse" data-parent="#menu-bar" aria-expanded="true" href="#utilities">
                        Utilidades
                    </a>

                    <ul id="utilities" class="panel-collapse collapse">
                    	<li><a href="missingLocations">Ubicaciones faltantes</a></li>
                    	<li><a href="caoticStowages">Revision de estibas</a></li>
                    	<li><a href="customQueries"> Queries personalizados </a></li>
                    </ul>

                </li>

                <!-- <li>
                    <a href="editLayout">Edit Layout</a>
                </li>

                <li>
                    <a href="dataGrid">Data grid</a>
                </li> -->

                <!-- <li>
                    <a href="warehouses">Warehouses</a>
                </li> -->

                <!-- <li>
                    <a href="areas">Areas</a>
                </li>

                <li>
                    <a href="areaCategories">Area categories</a>
                </li> -->

            </ul>

		</div>
		
		<div id="page-content-wrapper" class="">
			
			<div class="container">

				<h1>
					@yield('h1')
				</h1>

				@yield('content')

			</div>

		</div>
	</div>

	{{--Inicio del JFU --}}

	<div class="modal fade" id="jfuModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
		

		<input type="hidden" id="table" value="" />
        <input type="hidden" id="periodExists" value="" />
        <input type="hidden" id="post" value="" />

		<div class="modal-dialog">
		    
		    <div class="modal-content">
	        
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel">Actualizar Base de Datos</h4>  
				</div>

				<div class="modal-body">
	            
		            <span><b>Archivo Solicitado:</b> </span><span id="requiredFile"></span>

	                <div id="pbCargaArchivo">
	                    
	                    <div id="files" class="files" style="margin-bottom:5px;"></div>

	                    <div id="jfuProgress" class="progress jfuProgress progress-striped active">
	                        <div class="progress-bar"></div>
	                    </div>
	                    
	                    <!--Retro del DBX-->
	                    <div class="row">
	                    	<div class="col-lg-12" id="retro"></div>
	                    </div>
	                    <!--Fin Retro del DBX-->
	                    
					</div>            
					<!--Fin jfu-->

					<div class="row">
						
						<div class="col-xs-12 text-right">

							<div id="addButCon" style="display:inline;"></div>
							
							<div id="addedContainer" style="display:inline;">
		                        <span class="btn btn-primary btn-xs fileinput-button">
		                            <i class="glyphicon glyphicon-plus"></i>
		                            <span>Agregar</span>
		                            <!-- The file input field used as target for the file upload widget -->
		                            <input id="fileupload" type="file" name="files[]" accept=".csv" class="btn">
		                        </span>
		                    </div> 

							<button type="button" class="btn btn-danger btn-xs cerrarModal" id="btnCancelar">
				            	<i id="boton" class="glyphicon glyphicon-remove"></i>
				                Cancelar
							</button>
				            <button type="button" class="btn btn-success btn-xs" id="btnAceptar">
				            	<i class="glyphicon glyphicon-ok"></i>
				            	Aceptar
				            </button>

						</div>

					</div>
	                
	            </div>

		    </div>

	  	</div>
	  	
	</div>

	{{--Fin del JFU --}}

</body>

</html>

{{ HTML::script('j/jquery-2.1.1.js'); }}
{{ HTML::script('j/jquery-ui.js'); }}

{{ HTML::script('j/bootstrap.js'); }}
{{ HTML::script('j/mainFunctions.js'); }}

{{ HTML::script('j/fuelux.js'); }}
{{ HTML::script('j/customDataGrid.js'); }}

{{ HTML::script('j/canvas-to-blob.min.js'); }}
{{ HTML::script('j/load-image.min.js'); }}
{{ HTML::script('j/jquery.ui.widget.js'); }}
{{ HTML::script('j/jquery.iframe-transport.js'); }}
{{ HTML::script('j/jquery.fileupload.js'); }}
{{ HTML::script('j/jquery.fileupload-process.js'); }}
{{ HTML::script('j/jquery.fileupload-image.js'); }}
{{ HTML::script('j/jquery.fileupload-video.js'); }}
{{ HTML::script('j/jquery.fileupload-validate.js'); }}
{{ HTML::script('j/jFileUploader.js'); }}

@yield('localScript')
