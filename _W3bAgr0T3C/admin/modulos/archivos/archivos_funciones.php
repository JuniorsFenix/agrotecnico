<?
  ###############################################################################
  # productos_funciones.php  :  Archivo de funciones modulo productos / servicios
  # Desarrollo               :  Estilo y Dise�o & Informaticactiva
  # Web                      :  http://www.esidi.com
  #                             http://www.informaticactiva.com
  ###############################################################################
	include("../../funciones_generales.php"); 
	include("../../vargenerales.php");
	include("../../herramientas/upload/SimpleImage.php");

  ###############################################################################
  # Nombre        : ProductosFormNuevo
  # Descripci�n   : Muestra el formulario para ingreso de productos nuevos
  # Parametros    : Ninguno.
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function ArchivosFormNuevo()
  {
		$IdCiudad			= $_SESSION["IdCiudad"];
?>
    <!-- Formulario Ingreso de Archivos -->
    
    <form method="post" action="archivos.php?Accion=Guardar" enctype="multipart/form-data" class="dropzone" id="dropzone">
      <input TYPE="hidden" id="txtId" name="txtId" value="0">
      <label for="cboCategorias">Categor�a:</label>
        <select name="cboCategorias" id="cboCategorias">
        <?
        $nConexion = Conectar();
        $ResultadoCat = mysqli_query($nConexion, "SELECT * FROM tblcategoriasarchivos WHERE idciudad = $IdCiudad" );
        mysqli_close($nConexion);
        $nContador = 0;
while($Registros=mysqli_fetch_object($ResultadoCat))
{
            $nContador = $nContador + 1;
            if ( $nContador == 1 )
{
                ?>
                    <option selected value="<? echo $Registros->idcategoria; ?>"><? echo $Registros->idcategoria . "&nbsp;" . $Registros->categoria ; ?></option>
                <?
            }
            else
            {
                ?>
                    <option value="<? echo $Registros->idcategoria; ?>"><? echo $Registros->idcategoria . "&nbsp;" . $Registros->categoria ; ?></option>
                <?
            }
        }
        mysqli_free_result($ResultadoCat);
        ?>
        </select><br>
          <div class="fallback">
            <input name="file" type="file" multiple />
          </div>
    </form>
    <div style="text-align:center">
        <button id="submit-all">Submit all files</button>
        <a href="archivos_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
    </div>
    <script>
	Dropzone.autoDiscover = false;

	var myDropzone = new Dropzone("#dropzone", {  
		 url: "archivos.php?Accion=Guardar",  
		 autoProcessQueue: false,
      	 uploadMultiple: true,
		 parallelUploads: 100,
		 maxFiles: 100 
	});
	
	/*myDropzone.on("sending", function(file, xhr, formData) {
		var titulo=file.previewElement.querySelector('input[name="titulo"]').value
		formData.append("titulo", titulo);
		var descripcion=file.previewElement.querySelector('textarea[name="descripcion"]').value
		formData.append("descripcion", descripcion);
		formData.append("filesize", file.size);
	});*/

	$('#submit-all').click(function(){ 
		if ($.trim($(".titulo").val()) === "") {
			alert('Debes llenar los campos de T�tulo');
			return false;
		}
		else
		 myDropzone.processQueue();
	});
	
	$(document).on("click", ".boton", function(){
		$('.boton').each(function() {  
		$.data(this, 'dialog', 
		  $(this).next('.informacion').dialog({
			autoOpen: false,
			appendTo: '#dropzone', 
			show: 'scale',
			title: 'Informaci�n',
			resizable: false,
			height: 'auto',
			width: 'auto',
			modal: true 
		  })
		);  
	  }).click(function() {  
		  $.data(this, 'dialog').dialog('open');  
		  return false;  
	  });
		/*$(".informacion").dialog({
			//autoOpen: false,
			show: 'scale',
			title: 'Informaci�n',
			resizable: false,
			height: 'auto',
			width: 'auto',
			modal: true
		}); */
	});

	</script>
<?
  }
  ###############################################################################

  ###############################################################################
  # Nombre        : ArchivosGuardar
  # Descripci�n   : Adiciona un nuevo registro o actualiza uno existente
  # Parametros    : $nId (Si el Cero Nuevo Registro, de lo contrario Actualizar un Registro)
  #                 $nIdCategoria, $cProducto, $cDetalle, $nPrecio, $cImagen
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function ArchivosGuardar( $nId,$nIdCategoria,$cTitulo,$cDetalle,$cAdjunto,$cImagen,$cPublicar )
  {
	include("../../vargenerales.php");
    $nConexion = Conectar();
		$IdCiudad			= $_SESSION["IdCiudad"];
    if ( $nId <= 0 ) // Nuevo Registro
    {
      mysqli_query($nConexion,"INSERT INTO tblarchivos ( idcategoria,titulo,detalle,archivo,publicar,idciudad ) VALUES ( '$nIdCategoria','$cTitulo','$cDetalle','$cAdjunto','$cPublicar',$IdCiudad)");
			echo mysqli_error($nConexion);
			Log_System( "ARCHIVOS" , "NUEVO" , "ARCHIVO: " . $cTitulo );
      mysqli_close($nConexion);
    }
    else // Actualizar Registro Existente
    {
			$cTxtSQLUpdate		= "UPDATE tblarchivos SET idcategoria = '$nIdCategoria',titulo = '$cTitulo',detalle = '$cDetalle', publicar = '$cPublicar' , archivo = '$cAdjunto'  WHERE idarchivo = '$nId'";
			mysqli_query($nConexion,$cTxtSQLUpdate  );
			Log_System( "ARCHIVOS" , "EDITA" , "ARCHIVO: " . $cTitulo );
			    
			if( isset( $cImagen["tmp_name"] ) && $cImagen["tmp_name"]!="" ) {
			
				$NomImagen = $nId . "_" . $cImagen["name"];
	
			  $image = new SimpleImage();
			  $image->load($cImagen["tmp_name"]);
			  $image->resizeToWidth(800);
			  $image->save($cRutaArchivos . $NomImagen);
				
				$sql="UPDATE tblarchivos SET imagen = '{$NomImagen}' WHERE idarchivo = '{$nId}'";

      $r = mysqli_query($nConexion,$sql);

      
      if(!$r){
        Mensaje( "Fallo actualizand imagen.".mysqli_error($nConexion), "archivos_listar.php" ) ;
        exit;
      }

      
      
				}
			mysqli_close( $nConexion );
			Mensaje( "El registro ha sido actualizado correctamente.", "archivos_listar.php" ) ;
			exit;
    }
  } // FIN: function 
  ###############################################################################
?>
<?
  ###############################################################################
  # Nombre        : ArchivosEliminar
  # Descripci�n   : Eliminar un registro 
  # Parametros    : $nId
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function ArchivosEliminar( $nId )
  {
    $nConexion = Conectar();
		$reg = mysqli_fetch_object( mysqli_query($nConexion,"SELECT titulo FROM tblarchivos WHERE idarchivo ='$nId'") );
    mysqli_query($nConexion, "DELETE FROM tblarchivos WHERE idarchivo ='$nId'" );
		Log_System( "ARCHIVOS" , "ELIMINA" , "ARCHIVO: " . $reg->titulo );
    mysqli_close( $nConexion );
    Mensaje( "El registro ha sido eliminado correctamente.","archivos_listar.php" );
    exit();
  } // FIN: function UsuariosGuardar
  ###############################################################################
?>
<?
  ###############################################################################
  # Nombre        : ProductosFormEditar
  # Descripci�n   : Muestra el formulario para editar o eliminar registros
  # Parametros    : $nId = ID de registro que se debe mostrar el en formulario
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function ArchivosFormEditar( $nId )
  {
		$IdCiudad			= $_SESSION["IdCiudad"];
		include("../../vargenerales.php");
    $nConexion    = Conectar();
    $Resultado    = mysqli_query($nConexion, "SELECT * FROM tblarchivos WHERE idarchivo = '$nId'" ) ;
    mysqli_close( $nConexion ) ;

    $Registro     = mysqli_fetch_array( $Resultado );
?>
    <!-- Formulario Edici�n / Eliminaci�n de Productos -->
    <form method="post" action="archivos.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="<?php echo $nId ; ?>">
      <input TYPE="hidden" id="archivo" name="archivo" value="<?php echo $Registro["archivo"] ; ?>">
      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>EDITAR ARCHIVOS</b></td>
        </tr>
        <tr>
          <td class="tituloNombres">Categor�a:</td>
          <td class="contenidoNombres">
						<select name="cboCategorias" id="cboCategorias">
						<?
            $nConexion = Conectar();
            $ResultadoCat = mysqli_query($nConexion, "SELECT * FROM tblcategoriasarchivos WHERE idciudad = $IdCiudad ORDER BY idcategoria" );
            mysqli_close($nConexion);
            while($Registros=mysqli_fetch_object($ResultadoCat))
            {
							if ( $Registro["idcategoria"] == $Registros->idcategoria )
              {
								?>
									<option selected value="<? echo $Registros->idcategoria; ?>"><? echo $Registros->idcategoria . "&nbsp;" . $Registros->categoria ; ?></option>
								<?
							}
							else
							{
								?>
									<option value="<? echo $Registros->idcategoria; ?>"><? echo $Registros->idcategoria . "&nbsp;" . $Registros->categoria ; ?></option>
								<?
							}
						}
            mysqli_free_result($ResultadoCat);
            ?></select>
          </td>
        </tr>
        <tr>
          <td class="tituloNombres">Titulo:</td>
          <td class="contenidoNombres"><INPUT id="titulo" type="text" name="titulo[]" value="<? echo $Registro["titulo"]; ?>" maxLength="200" style="WIDTH: 300px; HEIGHT: 22px"></td>
        </tr>
        <tr>
          <td class="tituloNombres" colspan="2">Descripci�n:</td>
          <!--<td class="contenidoNombres"><textarea rows="20" id="txtDetalle" name="txtDetalle" cols="80"><? //echo $Registro["detalle"]; ?></textarea></td>-->
        </tr>
			</table>
                    <textarea name="descripcion[]"><? echo $Registro["detalle"]?></textarea>
                    <script>
                        CKEDITOR.replace( 'descripcion[]' );
                    </script>
			<table width="100%">
        <tr>
          <td class="tituloNombres">Archivo:</td>
          <td class="contenidoNombres"><input type="file" id="file" name="file[]"></td>
        </tr>
        <tr>
          <td class="tituloNombres">Archivo Adjunto Actual:</td>
          <td>
          <?php
            if ( empty($Registro["archivo"]) )
            {
              echo "No se asigno un archivo adjunto.";
            }
            else
            {
						?><a href="<?php echo $cRutaVerArchivos . $Registro["archivo"]; ?>"><?php echo $Registro["archivo"]; ?></a><?
						
            }
          ?>
          </td>
        </tr>
        <tr>
	      <td class="tituloNombres">Imagen:</td>
	      <td class="contenidoNombres"><input type="file" id="imagen" name="imagen"></td>
	    </tr>
        <tr>
          <td class="tituloNombres">Imagen Actual:</td>
          <td>
          <?php
            if ( empty($Registro["imagen"]) )
            {
              echo "No se asigno una imagen.";
            }
            else
            {
              ?><img src="<?php echo $cRutaVerArchivos.$Registro["imagen"]; ?>"><?
            }
          ?>
          </td>
        </tr>

			<?
			if ( Perfil() == "3" )
			{
			?><input type="hidden" name="optPublicar" id="optPublicar" value="<? echo $Registro["publicar"] ?>"><?
			}
			else
			{
			?>
			<tr>
				<td class="tituloNombres">Publicar:</td>
				<td class="contenidoNombres">
					<table border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td><label><input type="radio" id="optPublicar" name="optPublicar" value="S" <? if ( $Registro["publicar"] == "S" ) echo "checked" ?>>Si</label></td>
							<td width="10"></td>
							<td><label><input type="radio" id="optPublicar" name="optPublicar" value="N" <? if ( $Registro["publicar"] == "N" ) echo "checked" ?>>No</label></td>
						</tr>
					</table>
			  </td>
			</tr>
			<?
			}
			?>
        <tr>
          <td colspan="2" class="tituloFormulario">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2" class="nuevo">
            <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
						<?
						if ( Perfil() != "3" )
						{
						?><a href="archivos.php?Accion=Eliminar&Id=<? echo $nId ;?>"><img src="../../image/eliminar.gif" border="0" alt="Eliminar Registro." onClick="javascript: return confirm('�Esta seguro que desea eliminar este registro?')"></a><?
						}
						?>
            <a href="archivos_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
          </td>
        </tr>
      </table>
    </form>
<?
  mysqli_free_result( $Resultado );
  }
  ###############################################################################
?>