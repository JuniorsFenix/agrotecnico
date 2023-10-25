<?
  ###############################################################################
  # productos_funciones.php  :  Archivo de funciones modulo productos / servicios
  # Desarrollo               :  Estilo y Dise�o & Informaticactiva
  # Web                      :  http://www.esidi.com
  #                             http://www.informaticactiva.com
  ###############################################################################
 include("../../funciones_generales.php");

  ###############################################################################
  # Nombre        : ServiciosFormNuevo
  # Descripci&oacute;n   : Muestra el formulario para ingreso de servicios nuevos
  # Parametros    : Ninguno.
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function ServiciosFormNuevo()
  {
		$IdCiudad = $_SESSION["IdCiudad"];
?>
    <!-- Formulario Ingreso de Servicios -->
    <form method="post" action="servicios.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="0">
      <table width="100%">
        <tr>
          <td colspan="4" align="center" class="tituloFormulario"><b>NUEVO PROGRAMA</b></td>
        </tr>
        <tr>
          <td class="tituloNombres">Categor&iacute;a:</td>
          <td class="contenidoNombres">
						<select name="cboCategorias" id="cboCategorias">
						<?
						$nConexion = Conectar();
						$ResultadoCat = mysqli_query($nConexion, "SELECT * FROM tblcategoriasservicios WHERE idciudad = $IdCiudad ORDER BY idcategoria" );
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
            ?></select>
          </td>
        </tr>
        <tr>
          <td class="tituloNombres">Tip:</td>
          <td class="contenidoNombres"><INPUT id="txtServicio" type="text" name="txtServicio" maxLength="200" style="WIDTH: 300px; HEIGHT: 22px"></td>
        </tr>
        <tr>
          <td class="tituloNombres" colspan="2">Descripci&oacute;n:</td>
          <!--<td class="contenidoNombres" colspan="5"><textarea rows="20" id="txtDetalle" name="txtDetalle" cols="80"></textarea></td>-->
        </tr>
        </table>
                <textarea name="txtDetalle"></textarea>
                <script>
                    CKEDITOR.replace( 'txtDetalle' );
                </script>
        <table width="100%">
      <tr>
        <td colspan="4" align="center" class="tituloFormulario"><b>POSICIONAMIENTO</b></td>
      </tr>
      <tr>
        <td class="tituloNombres">T&iacute;tulo:</td>
        <td class="contenidoNombres" colspan="5"><INPUT type="text" name="titulo" class="seocounter_title" maxLength="200"  style="WIDTH: 700px; HEIGHT: 22px"></td>
      </tr>
      <tr>
        <td class="tituloNombres">Descripci&oacute;n:</td>
        <td class="contenidoNombres" colspan="5">
            <textarea name="metaDescripcion" class="seocounter_meta" cols="100" rows="10"></textarea>
        </td>
      </tr>
      <tr>
        <td class="tituloNombres">Tags: Para seleccionar varios, deje presionado Ctrl y haga click en los que desee seleccionar.</td>
        <td class="contenidoAsoc">
        <?php
        $sql="select url,nombre from tbltags_palabras where tag=1 order by nombre";
        $ra = mysqli_query($nConexion,$sql);
        ?>        
        <select name="txtTags[]" multiple size="20" style="width:100%;" >
        <?php while($rax=mysqli_fetch_assoc($ra)):?>
            <option value="<?=$rax["url"];?>"><?=$rax["nombre"];?></option>
        <?php endwhile;?>
        </select>
        </td>
        <td class="tituloNombres">Palabras Clave: Para seleccionar varios, deje presionado Ctrl y haga click en los que desee seleccionar.</td>
        <td class="contenidoAsoc">
        <?php
        $sql="select idpalabra,nombre from tbltags_palabras where keyword=1 order by nombre";
        $ra = mysqli_query($nConexion,$sql);
        ?>        
        <select name="txtPalabras[]" multiple size="20" style="width:100%;" >
        <?php while($rax=mysqli_fetch_assoc($ra)):?>
            <option value="<?=$rax["nombre"];?>"><?=$rax["nombre"];?></option>
        <?php endwhile;?>
        </select>
        </td>
      </tr>
      <tr>
        <td colspan="4" align="center" class="tituloFormulario"></td>
      </tr>
        <tr>
          <td class="tituloNombres">Fuente:</td>
          <td class="contenidoNombres" colspan="5"><INPUT id="txtPrecio" type="text" name="txtPrecio"></td>
        </tr>
        <tr>
          <td class="tituloNombres">Imagen:</td>
          <td class="contenidoNombres" colspan="5"><input type="file" id="txtImagen[]" name="txtImagen[]"></td>
        </tr>
			<?
			if ( Perfil() == "3" )
			{
			?><input type="hidden" name="optPublicar" id="optPublicar" value="N"><?
			}
			else
			{
			?>
			<tr>
				<td class="tituloNombres">Publicar:</td>
				<td class="contenidoNombres" colspan="5">
					<table border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td><label><input type="radio" id="optPublicar" name="optPublicar" value="S">Si</label></td>
							<td width="10"></td>
							<td><label><input type="radio" id="optPublicar" name="optPublicar" value="N" checked>No</label></td>
						</tr>
					</table>
			  </td>
			</tr>
			<?
			}
			?>
        <tr>
          <td colspan="4" class="tituloFormulario">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="4" class="nuevo">
            <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
            <a href="servicios_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
          </td>
        </tr>
      </table>
    </form>
<?
  }
  ###############################################################################
  ###############################################################################
  # Nombre        : ServiciosGuardar
  # Descripci&oacute;n   : Adiciona un nuevo registro o actualiza uno existente
  # Parametros    : $nId (Si el Cero Nuevo Registro, de lo contrario Actualizar un Registro)
  #                 $nIdCategoria, $cProducto, $cDetalle, $nPrecio, $cImagen
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function ServiciosGuardar( $nId,$nIdCategoria,$cServicio,$cDetalle,$cTitulo,$cDescripcion,$nPrecio,$cTags,$cPalabras,$cImagen,$cEncFlash,$cPublicar )
  {
		$IdCiudad = $_SESSION["IdCiudad"];
    $nConexion = Conectar();
	setlocale(LC_ALL, 'en_US.UTF8');
    $url = slug($cServicio);
	if (!empty($cTags)){
	$tags = implode(',', $cTags);
	}
	if (!empty($cPalabras)){
	$palabras = implode(', ', $cPalabras);
	}
    if ( $nId <= 0 ) // Nuevo Registro
    {
      mysqli_query($nConexion,"INSERT INTO tblservicios ( idcategoria,servicio,url,detalle,titulo,metaDescripcion,precio,tags,palabras,imagen,jquery,publicar,idciudad ) VALUES ( '$nIdCategoria','$cServicio','$url','$cDetalle','$cTitulo','$cDescripcion','$nPrecio','$tags','$palabras','$cImagen', '$cEncFlash','$cPublicar',$IdCiudad )");
			Log_System( "SERVICIOS" , "NUEVO" , "SERVICIO: " . $cServicio );
      mysqli_close($nConexion);
      Mensaje( "El registro ha sido almacenado correctamente.", "servicios_listar.php" ) ;
      exit;
    }
    else // Actualizar Registro Existente
    {
		$cTxtSQLUpdate		= "UPDATE tblservicios SET idcategoria = '$nIdCategoria',servicio = '$cServicio',url = '$url',detalle = '$cDetalle',titulo = '$cTitulo',metaDescripcion = '$cDescripcion',precio = '$nPrecio',tags = '$tags',palabras = '$palabras',publicar = '$cPublicar'";

	  if ( $cImagen!= "" )
      {
        $cTxtSQLUpdate = $cTxtSQLUpdate . " , imagen = '$cImagen'"  ;
      }
	  
	  if ( $cEncFlash != "" )
	  {
	  	$cTxtSQLUpdate	= $cTxtSQLUpdate . " , jquery = '$cEncFlash'" ;
	  }
		
		$cTxtSQLUpdate = $cTxtSQLUpdate . " WHERE idservicio = '$nId'";
		mysqli_query($nConexion,$cTxtSQLUpdate  );
		Log_System( "SERVICIOS" , "EDITA" , "SERVICIO: " . $cServicio );
		mysqli_close( $nConexion );
		Mensaje( "El registro ha sido actualizado correctamente.", "servicios_listar.php" ) ;
		exit;
    }
  } // FIN: function UsuariosGuardar
  ###############################################################################
  ###############################################################################
  # Nombre        : ServiciosEliminar
  # Descripci&oacute;n   : Eliminar un registro 
  # Parametros    : $nId
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function ServiciosEliminar( $nId )
  {
    $nConexion = Conectar();
		$reg = mysqli_fetch_object( mysqli_query($nConexion,"SELECT servicio FROM tblservicios WHERE idservicio ='$nId'") );
    mysqli_query($nConexion, "DELETE FROM tblservicios WHERE idservicio ='$nId'" );
		Log_System( "SERVICIOS" , "ELIMINA" , "SERVICIO: " . $reg->servicio );
    mysqli_close( $nConexion );
    Mensaje( "El registro ha sido eliminado correctamente.","servicios_listar.php" );
    exit();
  } // FIN: function UsuariosGuardar
  ###############################################################################
  ###############################################################################
  # Nombre        : ServiciosFormEditar
  # Descripci&oacute;n   : Muestra el formulario para editar o eliminar registros
  # Parametros    : $nId = ID de registro que se debe mostrar el en formulario
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function ServiciosFormEditar( $nId )
  {
		$IdCiudad = $_SESSION["IdCiudad"];
		include("../../vargenerales.php");
    $nConexion    = Conectar();
    $Resultado    = mysqli_query($nConexion, "SELECT * FROM tblservicios WHERE idservicio = '$nId'" ) ;

    $Registro     = mysqli_fetch_array( $Resultado );
    $tags=explode(",",$Registro["tags"]);
    $palabras=explode(", ",$Registro["palabras"]);
?>
    <!-- Formulario Edici�n / Eliminaci�n de Servicios -->
    <form method="post" action="servicios.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="<? echo $nId ; ?>">
      <table width="100%">
        <tr>
          <td colspan="4" align="center" class="tituloFormulario"><b>EDITAR PROGRAMA</b></td>
        </tr>
        <tr>
          <td class="tituloNombres">Categor&iacute;a:</td>
          <td class="contenidoNombres">
						<select name="cboCategorias" id="cboCategorias">
						<?
            $nConexion = Conectar();
            $ResultadoCat = mysqli_query($nConexion, "SELECT * FROM tblcategoriasservicios WHERE idciudad = $IdCiudad ORDER BY idcategoria" );
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
          <td class="tituloNombres">Tip:</td>
          <td class="contenidoNombres"><INPUT id="txtServicio" type="text" name="txtServicio" value="<? echo $Registro["servicio"]; ?>" maxLength="200" style="WIDTH: 300px; HEIGHT: 22px"></td>
        </tr>
        <tr>
          <td class="tituloNombres" colspan="2">Descripci&oacute;n:</td>
          <!--<td class="contenidoNombres" colspan="5"><textarea rows="20" id="txtDetalle" name="txtDetalle" cols="80"><? //echo $Registro["detalle"]; ?></textarea></td>-->
        </tr>
        </table>
            <textarea name="txtDetalle"><? echo $Registro["detalle"];?></textarea>
            <script>
                CKEDITOR.replace( 'txtDetalle' );
            </script>
        <table width="100%">
      <tr>
        <td colspan="4" align="center" class="tituloFormulario"><b>POSICIONAMIENTO</b></td>
      </tr>
      <tr>
        <td class="tituloNombres">T&iacute;tulo:</td>
        <td class="contenidoNombres" colspan="5"><INPUT type="text" name="titulo" class="seocounter_title" value="<?php echo $Registro["titulo"]; ?>" maxLength="200" style="WIDTH: 700px; HEIGHT: 22px"></td>
      </tr>
      <tr>
        <td class="tituloNombres">Descripci&oacute;n:</td>
        <td class="contenidoNombres" colspan="5">
            <textarea name="metaDescripcion" class="seocounter_meta" cols="100" rows="10"><?php echo $Registro["metaDescripcion"]?></textarea>
        </td>
      </tr>
      <tr>
        <td class="tituloNombres">Tags: Para seleccionar varios, deje presionado Ctrl y haga click en los que desee seleccionar.</td>
        <td class="contenidoAsoc">
        <?php
        $sql="select url,nombre from tbltags_palabras where tag=1 order by nombre";
        $ra = mysqli_query($nConexion,$sql);
        ?>        
        <select name="txtTags[]" multiple size="20" style="width:100%;" >
        <?php while($rax=mysqli_fetch_assoc($ra)):?>
            <option value="<?=$rax["url"];?>" <?=in_array($rax["url"],$tags)?"selected":"";?> ><?=$rax["nombre"];?></option>
        <?php endwhile;?>
        </select>
        </td>
        <td class="tituloNombres">Palabras Clave: Para seleccionar varios, deje presionado Ctrl y haga click en los que desee seleccionar.</td>
        <td class="contenidoAsoc">
        <?php
        $sql="select idpalabra,nombre from tbltags_palabras where keyword=1 order by nombre";
        $ra = mysqli_query($nConexion,$sql);
        ?>        
        <select name="txtPalabras[]" multiple size="20" style="width:100%;" >
        <?php while($rax=mysqli_fetch_assoc($ra)):?>
            <option value="<?=$rax["nombre"];?>" <?=in_array($rax["nombre"],$palabras)?"selected":"";?> ><?=$rax["nombre"];?></option>
        <?php endwhile;?>
        </select>
        </td>
      </tr>
      <tr>
        <td colspan="4" align="center" class="tituloFormulario"></td>
      </tr>
        <tr>
          <td class="tituloNombres">Fuente:</td>
          <td class="contenidoNombres" colspan="5"><INPUT id="txtPrecio" type="text" value="<? echo $Registro["precio"]; ?>" name="txtPrecio"></td>
        </tr>
        <tr>
          <td class="tituloNombres">Imagen:</td>
          <td class="contenidoNombres" colspan="5"><input type="file" id="txtImagen[]" name="txtImagen[]"></td>
        </tr>
        <tr>
          <td class="tituloNombres">Imagen Actual:</td>
          <td>
          <?
            if ( empty($Registro["imagen"]) )
            {
              echo "No se asigno una imagen.";
            }
            else
            {
              ?><img src="<? echo $cRutaVerImgServicios . $Registro["imagen"]; ?>" width="500"><?
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
				<td class="contenidoNombres" colspan="5">
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
          <td colspan="4" class="tituloFormulario">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="4" class="nuevo">
                <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
                <?
                if ( Perfil() != "3" )
                {
                ?>
                <a href="servicios.php?Accion=Eliminar&Id=<? echo $nId ;?>">
                <img src="../../image/eliminar.gif" border="0" alt="Eliminar Registro." onClick="javascript: return confirm('�Esta seguro que desea eliminar este registro?')">
                </a>
                <?
                }
                ?>
                <a href="servicios_listar.php">
                <img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar.">
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
