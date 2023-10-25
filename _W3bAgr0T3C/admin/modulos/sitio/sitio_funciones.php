<?php
  ###############################################################################
  # contenidos_funciones.php :  Archivo de funciones modulo contenidos
  # Desarrollo               :  Estilo y Diseño & Informaticactiva
  # Web                      :  http://www.esidi.com
  #                             http://www.informaticactiva.com
  ###############################################################################
	include("../../funciones_generales.php");
?>
<?php
  ###############################################################################
  # Nombre        : NoticiasFormNuevo
  # Descripción   : Muestra el formulario para ingreso de productos nuevos
  # Parametros    : Ninguno.
  # Desarrollado  : Estilo y Diseño & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function SitioFormNuevo()
	{
	?>
	<link href="../../css/administrador.css" rel="stylesheet" type="text/css"/>
	<!-- Formulario Ingreso de Contenidos -->
	<form method="post" action="sitio.php?Accion=Guardar" enctype="multipart/form-data">
		<input TYPE="hidden" id="txtId" name="txtId" value="*"/>
		<table width="100%">
			<tr>
				<td colspan="2" align="center" class="tituloFormulario">
                                    <b>NUEVO SITIO</b>
                                </td>
			</tr>
			<tr>
				<td class="tituloNombres">Nombre:</td>
				<td class="contenidoNombres">
                                <textarea name="txtNombre"></textarea>
                                <script>
                                    CKEDITOR.replace( 'txtNombre' );
                                </script>
                                </td>
			</tr>
            <tr>
            <td>
			<script type="text/javascript">
            var startlocation = new google.maps.LatLng(6.2655213,-75.59392350000002);
            var center = new google.maps.LatLng(6.2655213,-75.59392350000002);
            var marker;
            var map;
            var markersArray = [];
            var infowindow;
            function initialize() {
                var mapOptions = {
                  zoom: 13,
                  mapTypeId: google.maps.MapTypeId.ROADMAP,
                  center: startlocation
                };
                
                map = new google.maps.Map(document.getElementById("map"),mapOptions);       
                addMarker(startlocation);			
                geocoder = new google.maps.Geocoder();
                google.maps.event.addListener(marker, "dragend", function() {
                    var point =marker.getPosition();
                    map.panTo(point);
                    document.getElementById("txtLatitud").value = point.lat();
                    document.getElementById("txtLongitud").value = point.lng();
                });
                google.maps.event.addListener(map, 'zoom_changed', function() {	
                    removeMarker();	
                    centerpt=map.getCenter();	
                    addMarker(centerpt);
                    
                    google.maps.event.addListener(marker, "dragend", function() {
                        var pt =marker.getPosition();
                        map.panTo(pt);
                        document.getElementById("txtLatitud").value = pt.lat();
                        document.getElementById("txtLongitud").value = pt.lng();
                    });			
                });	
                google.maps.event.addListener(map, 'dragend', function() {	
                    removeMarker();	
                    centerpt=map.getCenter();	
                    addMarker(centerpt);
                    
                    google.maps.event.addListener(marker, "dragend", function() {
                        var pt =marker.getPosition();
                        map.panTo(pt);
                        document.getElementById("txtLatitud").value = pt.lat();
                        document.getElementById("txtLongitud").value = pt.lng();
                    });			
                });	
            }
            function addMarker(location) {
                //alert('https://www.iwdro.org/administrator/components/com_joomgalaxy/assets/images/bubbles/blue.png');
                var image = new google.maps.MarkerImage('https://www.iwdro.org/administrator/components/com_joomgalaxy/assets/images/bubbles/blue.png');	
                marker = new google.maps.Marker({
                    draggable:true,
                    position: location,
                    map: map,
                    icon:image
                });
                    var myhtml='';
                    google.maps.event.addListener(marker, "click", function() {
                  if (infowindow) infowindow.close();
                  infowindow = new google.maps.InfoWindow({content: myhtml});
                  infowindow.open(map, marker);
                });		
                document.getElementById("txtLatitud").value = location.lat();
                document.getElementById("txtLongitud").value = location.lng();	
                markersArray.push(marker);
            }
            function removeMarker() {
                if (markersArray) {
                    for (i=0; i < markersArray.length; i++) {
                        markersArray[i].setMap(null);
                    }
                markersArray.length = 0;
                }
            }
            function showAddress() {  	
                var address = document.getElementById("address").value;
                geocoder.geocode( { 'address': address}, function(results, status) {
                  if (status == google.maps.GeocoderStatus.OK) {
                    map.setCenter(results[0].geometry.location);
                    addMarker(results[0].geometry.location);
                    
                    google.maps.event.addListener(marker, "dragend", function() {
                        var point =marker.getPosition();
                        map.panTo(point);
                        document.getElementById("txtLatitud").value = point.lat();
                        document.getElementById("txtLongitud").value = point.lng();
                    });
                    google.maps.event.addListener(map, 'zoom_changed', function() {	
                        removeMarker();	
                        centerpt=map.getCenter();	
                        addMarker(centerpt);
                        
                        google.maps.event.addListener(marker, "dragend", function() {
                            var pt =marker.getPosition();
                            map.panTo(pt);				
                            document.getElementById("txtLatitud").value = pt.lat();
                            document.getElementById("txtLongitud").value = pt.lng();
                        });			
                    });	
                    google.maps.event.addListener(map, 'dragend', function() {	
                        removeMarker();	
                        centerpt=map.getCenter();	
                        addMarker(centerpt);
                        
                        google.maps.event.addListener(marker, "dragend", function() {
                            var pt =marker.getPosition();
                            map.panTo(pt);
                            document.getElementById("txtLatitud").value = pt.lat();
                            document.getElementById("txtLongitud").value = pt.lng();
                        });			
                    });	
                  } else {
                    alert("Geocode was not successful for the following reason: " + status);
                  }
                });
            }
            </script>
            <div id="longitudes" style="float:left; width:50%;">	
                <label class="hasTip" title="Escriba su dirección">
                    Dirección:
                </label>
                <input type="text" size="34" id="address" name="address" value=""/>
                <input type="button" onclick="showAddress(); return false" value="Locate" class="form-save-map" style="height: 30px;"/>
              <b>Coordenadas:</b>
                <label>
                    Latitud:
                </label>            
                <input type="text" size="34" name="txtLatitud" id="txtLatitud" value="6.2655213" />
                <label>
                    Longitud:
                </label>
                <input type="text" size="34" name="txtLongitud" id="txtLongitud" value="-75.59392350000002" />
            </div>
            <div id="mapa" style="float:right; width:50%; text-align:center;">
            	<div align="center" id="map" style="width: 500px; height: 450px"></div>
            </div>
			<tr>
				<td class="tituloNombres">Créditos:</td>
				<td class="contenidoNombres">
                                <textarea name="txtCreditos"></textarea>
                                <script>
                                    CKEDITOR.replace( 'txtCreditos' );            
									CKEDITOR.add
									CKEDITOR.config.contentsCss = [ '<?php echo $home; ?>/css/bootstrap.css', '<?php echo $home; ?>/css/estilos.css' ];
                                </script>
                </td>
			</tr>
			<tr>
				<td class="tituloNombres">Código verificación Google:</td>
				<td class="contenidoNombres">
                                <textarea name="txtGoogle"></textarea>
                                <script>
                                    CKEDITOR.replace( 'txtGoogle' );
                                </script>
                </td>
			</tr>
			<tr>
				<td class="tituloNombres">ID Facebook:</td>
				<td class="contenidoNombres">
                                <textarea name="txtFacebook"></textarea>
                                <script>
                                    CKEDITOR.replace( 'txtFacebook' );
                                </script>
                </td>
			</tr>
			<tr>
				<td class="tituloNombres">Descripción Editorial:</td>
				<td class="contenidoNombres">
                                <textarea name="txtEditorial"></textarea>
                                <script>
                                    CKEDITOR.replace( 'txtEditorial' );
                                </script>
                </td>
			</tr>
			<tr>
				<td class="tituloNombres">Descripción Eventos:</td>
				<td class="contenidoNombres">
                                <textarea name="txtEventos"></textarea>
                                <script>
                                    CKEDITOR.replace( 'txtEventos' );
                                </script>
                </td>
			</tr>
			<tr>
				<td class="tituloNombres">Descripción Servicios:</td>
				<td class="contenidoNombres">
                                <textarea name="txtServicios"></textarea>
                                <script>
                                    CKEDITOR.replace( 'txtServicios' );
                                </script>
                </td>
			</tr>
			<tr>
				<td class="tituloNombres">Descripción Galería:</td>
				<td class="contenidoNombres">
                                <textarea name="txtGaleria"></textarea>
                                <script>
                                    CKEDITOR.replace( 'txtGaleria' );
                                </script>
                </td>
			</tr>
			<tr>
				<td class="tituloNombres">Descripción Noticias:</td>
				<td class="contenidoNombres">
                                <textarea name="txtNoticias"></textarea>
                                <script>
                                    CKEDITOR.replace( 'txtNoticias' );
                                </script>
                </td>
			</tr>
			<tr>
				<td class="tituloNombres">Descripción Tips:</td>
				<td class="contenidoNombres">
                                <textarea name="txtTips"></textarea>
                                <script>
                                    CKEDITOR.replace( 'txtTips' );
                                </script>
                </td>
			</tr>
			<tr>
				<td class="tituloNombres">Descripción Música:</td>
				<td class="contenidoNombres">
                                <textarea name="txtMusica"></textarea>
                                <script>
                                    CKEDITOR.replace( 'txtMusica' );
                                </script>
                </td>
			</tr>
			<tr>
				<td class="tituloNombres">Descripción Escorts:</td>
				<td class="contenidoNombres">
                                <textarea name="txtproductos"></textarea>
                                <script>
                                    CKEDITOR.replace( 'txtproductos' );
                                </script>
                </td>
			</tr>
			<tr>
				<td class="tituloNombres">Descripción Videos:</td>
				<td class="contenidoNombres">
                                <textarea name="txtVideos"></textarea>
                                <script>
                                    CKEDITOR.replace( 'txtVideos' );
                                </script>
                </td>
			</tr>
			<tr>
				<td class="tituloNombres">Google Analytics:</td>
				<td class="contenidoNombres">
                                <textarea name="txtAnalytics" rows="12" cols="90"></textarea>
                </td>
			</tr>
			<tr>
				<td colspan="2" class="tituloFormulario">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="2" class="nuevo">
					<input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
					<a href="sitio_listar.php">
                                            <img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."/>
                                        </a>
				</td>
			</tr>
		</table>
	</form>
	<?php
	}
###############################################################################
?>
<?php
	###############################################################################
	# Nombre        : ContenidosGuardar
	# Descripción   : Adiciona un nuevo registro o actualiza uno existente
	# Parametros    : $nId (Si el Cero Nuevo Registro, de lo contrario Actualizar un Registro)
	#                 $nIdCategoria, $cProducto, $cDetalle, $nPrecio, $cImagen
	# Desarrollado  : Estilo y Diseño & Informaticactiva
	# Retorno       : Ninguno
	###############################################################################
	function SitioGuardar( $nId,$cNombre,$cLatitud,$cLongitud,$cCreditos,$cGoogle,$cFacebook,$cEditorial,$cEventos,$cServicios, $cGaleria,$cNoticias,$cTips,$cMusica,$cproductos,$cVideos,$cAnalytics )
	{
		$IdCiudad = $_SESSION["IdCiudad"];
		$nConexion = Conectar();
                $cNombre = str_replace("\n", "", $cNombre);
                $cNombre = str_replace("\r", "", $cNombre);
				$cAnalytics = mysqli_real_escape_string($nConexion,$cAnalytics);
		if ( $nId == "*" ) // Nuevo Registro
		{
			//Verifico que no exista otro sitio ya registrado
			$Resultado = mysqli_query($nConexion, "SELECT * FROM tblsitio" );
			if ( mysqli_num_rows($Resultado) != 0 )
			{
				mysqli_free_result($Resultado);
				mysqli_close($nConexion);
				Error( "Ya existe un sitio registrado." );
			}
			else
			{
				mysqli_free_result($Resultado);
				mysqli_query($nConexion,"INSERT INTO tblsitio ( nombre,latitud,longitud,creditos,google,idfacebook,editorial,eventos,servicios,galeria,noticias,tips,musica,productos,videos,analytics ) VALUES ( '$cNombre','$cLatitud','$cLongitud','$cCreditos','$cGoogle','$cFacebook','$cEditorial','$cEventos','$cServicios','$cGaleria','$cNoticias','$cTips','$cMusica','$cproductos','$cVideos','$cAnalytics' )");
				Log_System( "SITIO" , "NUEVO" , "NOMBRE: " . $cNombre );
				mysqli_close($nConexion);
                                Mensaje( "El registro ha sido almacenado correctamente.", "sitio_listar.php" ) ;
				exit;
			}
		}
		else // Actualizar Registro Existente
		{
                        mysqli_query($nConexion, "UPDATE tblsitio SET nombre = replace('{$cNombre}','\n',''), latitud = '{$cLatitud}',longitud = '{$cLongitud}', creditos = '{$cCreditos}', google = '{$cGoogle}', idfacebook = '{$cFacebook}', editorial = '{$cEditorial}', eventos = '{$cEventos}', servicios = '{$cServicios}', galeria = '{$cGaleria}', noticias = '{$cNoticias}', tips = '{$cTips}', musica = '{$cMusica}', productos = '{$cproductos}', videos = '{$cVideos}', analytics = '$cAnalytics'" );
                        Log_System( "SITIO" , "EDITA" , "NOMBRE: " . $cNombre );
			mysqli_close( $nConexion );
			Mensaje( "El registro ha sido actualizado correctamente.", "sitio_listar.php" ) ;
			exit;
		}
	} // FIN: function 
	###############################################################################
?>
<?php
	###############################################################################
	# Nombre        : ContenidosEliminar
	# Descripción   : Eliminar un registro 
	# Parametros    : $nId
	# Desarrollado  : Estilo y Diseño & Informaticactiva
	# Retorno       : Ninguno
	###############################################################################
	function SitioEliminar( $nId )
	{
		exit();
	} // FIN: function 
	###############################################################################
?>
<?php
	###############################################################################
	# Nombre        : ContenidosFormEditar
	# Descripción   : Muestra el formulario para editar o eliminar registros
	# Parametros    : $nId = ID de registro que se debe mostrar el en formulario
	# Desarrollado  : Estilo y Diseño & Informaticactiva
	# Retorno       : Ninguno
	###############################################################################
	function SitioFormEditar( )
	{
		include("../../vargenerales.php");
		$IdCiudad = $_SESSION["IdCiudad"];
		$nConexion    = Conectar();
		$Resultado    = mysqli_query($nConexion,"SELECT * FROM tblsitio" ) ;
		mysqli_close( $nConexion ) ;
		$Registro     = mysqli_fetch_array( $Resultado );
		?>
		<!-- Formulario Edición / Eliminación de Contenidos -->
		<form method="post" action="sitio.php?Accion=Guardar" enctype="multipart/form-data">
			<input TYPE="hidden" id="txtId" name="txtId" value="<?php echo $Registro["nombre"] ; ?>">
			<table width="100%">
				<tr>
					<td colspan="2" align="center" class="tituloFormulario"><b>EDITAR SITIO</b></td>
				</tr>
				<tr>
					<td class="tituloNombres">Nombre:</td>
					<td class="contenidoNombres">
                                <textarea name="txtNombre"><?php echo $Registro["nombre"];?></textarea>
                                <script>
                                    CKEDITOR.replace( 'txtNombre' );
                                </script>
                                        </td>
				</tr>
                <tr>
                <td>
				<script type="text/javascript">
                  //Declare the variable that will store the geocode object
                  var geocoder;
                  var map;
                  function initialize() {
                    geocoder = new google.maps.Geocoder();
                    var sLatitud = document.getElementById("txtLatitud").value;
                    var sLongitud = document.getElementById("txtLongitud").value;
                    var latlng = new google.maps.LatLng(sLatitud, sLongitud);
                    var myOptions = {
                      zoom: 15,
                      center: latlng,
                      mapTypeId: google.maps.MapTypeId.ROADMAP
                    };
                    map = new google.maps.Map(document.getElementById("map_canvas"),
                        myOptions);
                            var marker = new google.maps.Marker({
                                map: map, 
                                position: latlng
                            });
                  }
                  
                  function codeAddress() {
                    var sAddress = document.getElementById("direccion").value;
                    geocoder.geocode( { 'address': sAddress}, function(results, status) {
                        if (status == google.maps.GeocoderStatus.OK) {
                            map.setCenter(results[0].geometry.location);
                            var marker = new google.maps.Marker({
                                map: map, 
                                position: results[0].geometry.location
                            });
							var point =marker.getPosition();
							map.panTo(point);
							document.getElementById("txtLatitud").value = point.lat();
							document.getElementById("txtLongitud").value = point.lng();
                        } else {
                            alert("No se encontraron las coordenadas por la siguiente razón: " + status);
                        }
                      });
                  }
                </script>
        <!--Create a text box input for the user to enter the street address-->
        Direccion:<br /> <input type="text" id="direccion" style=" width:200px" title="buscar coordenadas"/><br />
        <!--Create a button input for the user to click to geocode the address-->
        <input type="button" onclick="codeAddress()" id="inputButtonGeocode" style="width:150px" title="Buscar Coordenadas" value="Buscar Coordenadas" /><br />
              <b>Coordenadas:</b><br />
                <label>
                    Latitud:
                </label><br />            
                <input type="text" size="34" name="txtLatitud" id="txtLatitud" value="<?php echo $Registro["latitud"];?>" /><br />
                <label>
                    Longitud:
                </label><br />
                <input type="text" size="34" name="txtLongitud" id="txtLongitud" value="<?php echo $Registro["longitud"];?>" /></td>
                <td>
        <div id="map_canvas" style="width:450px; height:400px; margin:auto"></div>
                </td>
                </tr>
			<tr>
				<td class="tituloNombres">Créditos:</td>
				<td class="contenidoNombres">
                                <textarea name="txtCreditos"><?php echo $Registro["creditos"];?></textarea>
                                <script>
                                    CKEDITOR.replace( 'txtCreditos' );									
                                </script>
                </td>
			</tr>
			<tr>
				<td class="tituloNombres">Código verificación Google:</td>
				<td class="contenidoNombres">
                                <textarea name="txtGoogle"><?php echo $Registro["google"];?></textarea>
                                <script>
                                    CKEDITOR.replace( 'txtGoogle' );
                                </script>
                </td>
			</tr>
			<tr>
				<td class="tituloNombres">ID Facebook:</td>
				<td class="contenidoNombres">
                                <textarea name="txtFacebook"><?php echo $Registro["idfacebook"];?></textarea>
                                <script>
                                    CKEDITOR.replace( 'txtFacebook' );
                                </script>
                </td>
			</tr>
			<tr>
				<td class="tituloNombres">Google Analytics:</td>
				<td class="contenidoNombres">
                	<textarea name="txtAnalytics" rows="12" cols="90"><?php echo $Registro["analytics"];?></textarea>
                </td>
			</tr>
				<tr>
					<td colspan="2" class="tituloFormulario">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="2" class="nuevo">
						<input type="image" src="../../image/guardar.gif" alt="Guardar Registro."/>
						<a href="sitio_listar.php">
                                                    <img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."/>
                                                </a>
					</td>
				</tr>
			</table>
		</form>
		<?
		mysqli_free_result( $Resultado );
	}
	###############################################################################
	?>