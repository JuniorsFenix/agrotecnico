<? include("../../funciones_generales.php"); ?>
<?

  $targets = array(
    "_self",
    "_blank"
  );

  
  function CabezotesFormNuevo() {
  	global $targets;
 
    
?>
    <!-- Formulario Ingreso de imagenes -->
    <form method="post" action="marcas.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="0">
      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>NUEVA MARCA</b></td>
        </tr>

	</table>
	
	<br><br>
	<br><br>
	  <table width="100%">

	    <tr>
	      <td class="tituloNombres">Nombre:</td>
	      <td class="contenidoNombres"><input type="text" id="nombre" name="nombre"></td>
	    </tr>
	    <tr>
	      <td class="tituloNombres">URL:</td>
	      <td class="contenidoNombres"><input type="text" id="url" name="url"></td>
	    </tr>
	    <tr>
	      <td class="tituloNombres">Target:</td>
	      <td class="contenidoNombres">
        	<select name="target" >
          		<?php foreach ( $targets as $r):?>
          		<option value="<?=$r;?>"><?=$r;?></option>
          		<?php endforeach;?>
        	</select>
          </td>
	    </tr>
	    <tr>
	      <td class="tituloNombres">Imagen:</td>
	      <td class="contenidoNombres"><input type="file" id="txtImagen" name="txtImagen"></td>
	    </tr>
        <tr>
          <td colspan="2" class="tituloFormulario">&nbsp;</td>
        </tr>
	</table>
	
	<table width="100%">
        <tr>
          <td colspan="2" class="nuevo">
            <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
	    <a href="marcas_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
          </td>
        </tr>
      </table>
    </form>
<?php
  }
  ###############################################################################
?>
<?php

  function CabezotesGuardar( $nId,$nombre,$url,$imagen ) {
    $IdCiudad = $_SESSION["IdCiudad"];
    $nConexion = Conectar();
    if ( $nId <= 0 ) {
      $sql = "INSERT INTO tblti_marcas ( nombre,url,imagen ) 
      		VALUES ('{$nombre}','{$url}','{$imagen}')";
      $ra = mysqli_query($nConexion,$sql);
      if ( !$ra ) {
	Mensaje( "Error registrando nuevo cabezote.", "marcas_listar.php" ) ;
	exit;
      }
      Log_System( "MARCAS" , "NUEVO" , "IMAGEN: " . $imagen  );
      mysqli_close($nConexion);
      Mensaje( "El registro ha sido almacenado correctamente.", "marcas_listar.php" ) ;
      return;
    }
    else {
    	$cTxtSQLUpdate = "UPDATE tblti_marcas SET nombre='{$nombre}',url='{$url}'";

    	if ( !empty($imagen) ){
    	    $cTxtSQLUpdate = $cTxtSQLUpdate . " , imagen = '{$imagen}'"  ;
    	}
    	 
    	$cTxtSQLUpdate = $cTxtSQLUpdate . " WHERE idmarca = {$nId}";
    	$ra = mysqli_query($nConexion,$cTxtSQLUpdate  );
	if ( !$ra ) {
	  Mensaje("Error actualizando cabezote {$nId}","marcas_listar.php");
	  exit;
	}
    	Log_System( "MARCAS" , "EDITA" , "IMAGEN: " . $imagen );
    	mysqli_close( $nConexion );
    	Mensaje( "El registro ha sido actualizado correctamente.", "marcas_listar.php" ) ;
    	return;
    }
  }
?>
<?
  function CabezotesEliminar( $nId )
  {
    $nConexion = Conectar();
    $reg = mysqli_fetch_object( mysqli_query($nConexion,"SELECT imagen FROM tblti_marcas WHERE idmarca ='$nId'") );
    $sql = "DELETE FROM tblti_marcas WHERE idmarca = $nId";
    $ra = mysqli_query($nConexion, $sql );
    if ( !$ra ) {
      Mensaje("Fallo eliminando marca {$nId}","marcas_listar.php");
      exit;
    }
    Log_System( "CABEZOTESJQ" , "ELIMINA" , "IMAGEN: " . $reg->imagen  );
    mysqli_close( $nConexion );
    Mensaje( "El registro ha sido eliminado correctamente.","marcas_listar.php" );
    exit();
  }
?>
<?
  function CabezotesFormEditar( $nId ) {
  	global $targets;
    $IdCiudad = $_SESSION["IdCiudad"];
    include("../../vargenerales.php");
    $nConexion = Conectar();
    $Resultado = mysqli_query($nConexion, "SELECT * FROM tblti_marcas WHERE idmarca = '$nId'" ) ;
    mysqli_close( $nConexion ) ;

    $Registro = mysqli_fetch_array( $Resultado );
?>
    <!-- Formulario Edici�n / Eliminaci�n de Servicios -->
    <form method="post" action="marcas.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="<?=$nId;?>">
      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>EDITAR MARCA</b></td>
        </tr>
	</table>
	<table width="100%">
	  <tr>
	      <td class="tituloNombres">Nombre:</td>
	      <td class="contenidoNombres"><input type="text" id="nombre" name="nombre" value="<?=$Registro["nombre"]?>">
	      </td>
	    </tr>

	  	<tr>
	    	<td class="tituloNombres">URL:</td>
	    	<td class="contenidoNombres"><input type="text" id="url" name="url" value="<?=$Registro["url"]?>"></td>
	  	</tr>
		<tr>
	      <td class="tituloNombres">Target:</td>
	      <td class="contenidoNombres">
        	<select name="target" >
          		<?php foreach ( $targets as $r):?>
          		<option value="<?=$r;?>" <?=($Registro["target"]==$r?"selected":"");?>><?=$r;?></option>
          		<?php endforeach;?>
        	</select>
          </td>
	    </tr>

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
              ?><img src="<?=$cRutaVerImagenMarcas.$Registro["imagen"]; ?>"><?
            }
          ?>
          </td>
        </tr>
        <tr>
          <td colspan="2" class="tituloFormulario">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2" class="nuevo">
            <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
	    <a href="marcas.php?Accion=Eliminar&Id=<?=$nId;?>"><img src="../../image/eliminar.gif" border="0" alt="Eliminar Registro." onClick="javascript: return confirm('�Esta seguro que desea eliminar este registro?')"></a>
            <a href="marcas_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
          </td>
        </tr>
      </table>
    </form>
<?
  mysqli_free_result( $Resultado );
  }
?>
