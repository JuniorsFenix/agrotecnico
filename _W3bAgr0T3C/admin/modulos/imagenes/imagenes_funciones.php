<?
  ###############################################################################
  # productos_funciones.php  :  Archivo de funciones modulo productos / servicios
  # Desarrollo               :  Estilo y Dise�o & Informaticactiva
  # Web                      :  http://www.esidi.com
  #                             http://www.informaticactiva.com
  ###############################################################################
?>
<? include("../../funciones_generales.php"); ?>
<?
  ###############################################################################
  # Nombre        : ImagenesFormNuevo
  # Descripci�n   : Muestra el formulario para ingreso de servicios nuevos
  # Parametros    : Ninguno.
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
function ImagenesFormNuevo() {
  $IdCiudad = $_SESSION["IdCiudad"];
?>
    <!-- Formulario Ingreso de imagenes -->
    <form method="post" action="imagenes.php?Accion=GuardarVarias" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="0">
      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>NUEVA IMAGEN</b></td>
        </tr>
        <tr>
          <td class="tituloNombres">Categor�a:</td>
          <td class="contenidoNombres">
	    <select name="cboCategorias" id="cboCategorias">
	    <?php
            $nConexion = Conectar();
            $ResultadoCat = mysqli_query($nConexion, "SELECT * FROM tblcategoriasimagenes WHERE idciudad = $IdCiudad ORDER BY idcategoria" );
            mysqli_close($nConexion);
	    $nContador = 0;
            while($Registros=mysqli_fetch_object($ResultadoCat)) {
	      $nContador = $nContador + 1;
	      if ( $nContador == 1 ) {
	      ?>
	      <option selected value="<? echo $Registros->idcategoria; ?>"><? echo $Registros->idcategoria . "&nbsp;" . $Registros->categoria ; ?></option>
	      <?php
	      }
	      else {
	      ?>
		<option value="<? echo $Registros->idcategoria; ?>"><? echo $Registros->idcategoria . "&nbsp;" . $Registros->categoria ; ?></option>
	      <?php
	      }
	    }
            mysqli_free_result($ResultadoCat);
            ?></select>
          </td>
        </tr>
	</table>
	
	<br><br>
	<?php for( $i = 0;$i < 10; $i++ ) :?>
	<br><br>
	  <table >
	    <tr>
	      <td>
		<table>
		  <tr>
		    <td class="contenidoNombres">Descripci�n:<br><textarea rows="6" id="txtDetalle<?=$i;?>" name="txtDetalle<?=$i;?>" cols="80"></textarea></td>
		  </tr>
		</table>
	      </td>
	      <td>
		<table>
		  <tr>
		    <td class="contenidoNombres">Imagen:<br><input type="file" id="txtImagen<?=$i;?>" name="txtImagen<?=$i;?>"></td>
		  </tr>
		</table>
	      </td>
	      <td>
		<table>
		  <?php
		    if ( Perfil() == "3" ) {
		    ?><input type="hidden" name="optPublicar<?=$i;?>" id="optPublicar" value="N"><?
		    }
		    else {
		    ?>
		  <tr>
		  <td class="contenidoNombres">
		    <table border="0" cellpadding="0" cellspacing="0">
		      <tr>
			<td>Publicar:<br>
			<input type="radio" id="optPublicar" name="optPublicar<?=$i;?>" value="S" checked>Si&nbsp;&nbsp;&nbsp;
			<input type="radio" id="optPublicar" name="optPublicar<?=$i;?>" value="N">No
		      </tr>
		    </table>
		  </td>
		  </tr>
		  <?php
		  }
		  ?>
		</table>
	      </td>
	    </tr>
	    
	  </table>
	  
	  
	<?php endfor;?>
	
	<table width="100%">
        <tr>
          <td colspan="2" class="nuevo">
            <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
            <a href="imagenes.php?action=Guardar"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
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
  # Nombre        : ImagenesGuardar
  # Descripci�n   : Adiciona un nuevo registro o actualiza uno existente
  # Parametros    : $nId (Si el Cero Nuevo Registro, de lo contrario Actualizar un Registro)
  #                 $nIdCategoria, $cProducto, $cDetalle, $nPrecio, $cImagen
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function ImagenesGuardar( $nId,$nIdCategoria,$cDetalle,$cImagen,$cPublicar,$multiple=false ) {
    $IdCiudad = $_SESSION["IdCiudad"];
    $nConexion = Conectar();
    if ( $nId <= 0 ) {
      mysqli_query($nConexion,"INSERT INTO tblimagenes ( idcategoria,descripcion,imagen,publicar,idciudad ) VALUES ( '$nIdCategoria','$cDetalle','$cImagen','$cPublicar',$IdCiudad )");
			Log_System( "IMAGENES" , "NUEVO" , "IMAGEN: " . $cImagen  );
      mysqli_close($nConexion);
      if(!$multiple){
        Mensaje( "El registro ha sido almacenado correctamente.", "imagenes_listar.php" ) ;
      }
      return;
    }
    else // Actualizar Registro Existente
    {
    	$cTxtSQLUpdate		= "UPDATE tblimagenes SET idcategoria = '$nIdCategoria',descripcion = '$cDetalle',publicar='$cPublicar'";

    	if ( $cImagen!= "*" ){
    		$cTxtSQLUpdate = $cTxtSQLUpdate . " , imagen = '$cImagen'"  ;
    	}
    	 
    	$cTxtSQLUpdate = $cTxtSQLUpdate . " WHERE idimagen = '$nId'";
    	mysqli_query($nConexion,$cTxtSQLUpdate  );
    	Log_System( "IMAGENES" , "EDITA" , "IMAGEN: " . $cImagen  );
    	mysqli_close( $nConexion );

    	if(!$multiple){
    		Mensaje( "El registro ha sido actualizado correctamente.", "imagenes_listar.php" ) ;
    	}
    	return;

    }
  } // FIN: function UsuariosGuardar
  ###############################################################################
?>
<?
  ###############################################################################
  # Nombre        : ImagenesEliminar
  # Descripci�n   : Eliminar un registro 
  # Parametros    : $nId
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function ImagenesEliminar( $nId )
  {
    $nConexion = Conectar();
		$reg = mysqli_fetch_object( mysqli_query($nConexion,"SELECT imagen FROM tblimagenes WHERE idimagen ='$nId'") );
    mysqli_query($nConexion, "DELETE FROM tblimagenes WHERE idimagen ='$nId'" );
		Log_System( "IMAGENES" , "ELIMINA" , "IMAGEN: " . $reg->imagen  );
    mysqli_close( $nConexion );
    Mensaje( "El registro ha sido eliminado correctamente.","imagenes_listar.php" );
    exit();
  } // FIN: function UsuariosGuardar
  ###############################################################################
?>
<?
  ###############################################################################
  # Nombre        : ImagenesFormEditar
  # Descripci�n   : Muestra el formulario para editar o eliminar registros
  # Parametros    : $nId = ID de registro que se debe mostrar el en formulario
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function ImagenesFormEditar( $nId )
  {
		$IdCiudad = $_SESSION["IdCiudad"];
		include("../../vargenerales.php");
    $nConexion    = Conectar();
    $Resultado    = mysqli_query($nConexion, "SELECT * FROM tblimagenes WHERE idimagen = '$nId'" ) ;
    mysqli_close( $nConexion ) ;

    $Registro     = mysqli_fetch_array( $Resultado );
?>
    <!-- Formulario Edici�n / Eliminaci�n de Servicios -->
    <form method="post" action="imagenes.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="<? echo $nId ; ?>">
      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>EDITAR IMAGEN</b></td>
        </tr>
        <tr>
          <td class="tituloNombres">Categor�a:</td>
          <td class="contenidoNombres">
						<select name="cboCategorias" id="cboCategorias">
						<?
            $nConexion = Conectar();
            $ResultadoCat = mysqli_query($nConexion, "SELECT * FROM tblcategoriasimagenes WHERE idciudad = $IdCiudad ORDER BY idcategoria" );
            mysqli_close($nConexion);
            while($Registros=mysqli_fetch_object($ResultadoCat)) {
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
          <td colspan="2" class="tituloNombres">Descripci�n:</td>
          <!--<td class="contenidoNombres"><textarea rows="20" id="txtDetalle" name="txtDetalle" cols="80"><? //echo $Registro["descripcion"]; ?></textarea></td>-->
        </tr>
	</table>
    <textarea name="txtDetalle"><? echo $Registro["descripcion"]?></textarea>
    <script>	
        CKEDITOR.replace( 'txtDetalle' );
    </script>
	<table width="100%">
        <tr>
          <td class="tituloNombres">Imagen:</td>
          <td class="contenidoNombres"><input type="file" id="txtImagen" name="txtImagen"></td>
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
              ?><img src="<? echo $cRutaVerImgGaleria . $Registro["imagen"]; ?>"><?
            }
          ?>
          </td>
        </tr>
	  <?
	  if ( Perfil() == "3" ) {
	  ?><input type="hidden" name="optPublicar" id="optPublicar" value="<? echo $Registro["publicar"] ?>"><?
	  }
	  else {
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
	      ?><a href="imagenes.php?Accion=Eliminar&Id=<? echo $nId ;?>"><img src="../../image/eliminar.gif" border="0" alt="Eliminar Registro." onClick="javascript: return confirm('�Esta seguro que desea eliminar este registro?')"></a><?
	      }
	      ?>
            <a href="imagenes_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
          </td>
        </tr>
      </table>
    </form>
<?
  mysqli_free_result( $Resultado );
  }
  ###############################################################################
?>
