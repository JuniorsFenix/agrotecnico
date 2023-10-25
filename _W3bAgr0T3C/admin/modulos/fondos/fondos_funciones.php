<? include("../../funciones_generales.php"); ?>
<?


  
  function FondosFormNuevo() {
    $IdCiudad = $_SESSION["IdCiudad"];
    
    $nConexion = Conectar();
    $Resultado = mysqli_query($nConexion, "SELECT * FROM tblfondos_categorias" ) ;
    mysqli_close( $nConexion ) ;
 
    
?>
    <!-- Formulario Ingreso de imagenes -->
    <form method="post" action="fondos.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="0">
      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>NUEVO FONDO</b></td>
        </tr>

	</table>
	
	<br><br>
	<br><br>
	  <table width="100%">
	    <tr>
	      <td class="tituloNombres">Categoria:</td>
	      <td class="contenidoNombres">
		<select name="idcategoria" >
		  <?php while ($r = mysqli_fetch_array( $Resultado )):?>
		  <option value="<?=$r["idcategoria"];?>"><?=$r["nombre"];?></option>
		  <?php endwhile;?>
		</select>
	      
	      </td>
	    </tr>
	    <tr>
	      <td class="tituloNombres">Imagen:</td>
	      <td class="contenidoNombres"><input type="file" id="txtImagen" name="txtImagen[]"></td>
	    </tr>
        <tr>
          <td colspan="2" class="tituloFormulario">&nbsp;</td>
        </tr>
	</table>
	
	<table width="100%">
        <tr>
          <td colspan="2" class="nuevo">
            <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
	    <a href="fondos_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
          </td>
        </tr>
      </table>
    </form>
<?php
  }
  ###############################################################################
?>
<?php

  function FondosGuardar( $nId,$archivo,$idcategoria ) {
    $IdCiudad = $_SESSION["IdCiudad"];
    $nConexion = Conectar();
    if ( $nId <= 0 ) {
      $sql = "INSERT INTO tblimagenes_fondo ( imagen,idcategoria ) 
      		VALUES ('{$archivo}','{$idcategoria}')";
      $ra = mysqli_query($nConexion,$sql);
      if ( !$ra ) {
	Mensaje( "Error registrando nuevo fondo.", "fondos_listar.php" ) ;
	exit;
      }
      Log_System( "FONDOS" , "NUEVO" , "IMAGEN: " . $archivo  );
      mysqli_close($nConexion);
      Mensaje( "El registro ha sido almacenado correctamente.", "fondos_listar.php" ) ;
      return;
    }
    else {
    	$cTxtSQLUpdate = "UPDATE tblimagenes_fondo SET idcategoria='{$idcategoria}'";

    	if ( $archivo != "*" ){
    	    $cTxtSQLUpdate = $cTxtSQLUpdate . " , imagen = '{$archivo}'"  ;
    	}
    	 
    	$cTxtSQLUpdate = $cTxtSQLUpdate . " WHERE idimagen = {$nId}";
    	$ra = mysqli_query($nConexion,$cTxtSQLUpdate  );
	if ( !$ra ) {
	  Mensaje("Error actualizando fondo {$nId}","fondos_listar.php");
	  exit;
	}
    	Log_System( "FONDOS" , "EDITA" , "IMAGEN: " . $archivo );
    	mysqli_close( $nConexion );
    	Mensaje( "El registro ha sido actualizado correctamente.", "fondos_listar.php" ) ;
    	return;
    }
  }
?>
<?
  function FondosEliminar( $nId )
  {
    $nConexion = Conectar();
    $reg = mysqli_fetch_object( mysqli_query($nConexion,"SELECT imagen FROM tblimagenes_fondo WHERE idimagen ='$nId'") );
    $sql = "DELETE FROM tblimagenes_fondo WHERE idimagen = $nId";
    $ra = mysqli_query($nConexion, $sql );
    if ( !$ra ) {
      Mensaje("Fallo eliminando fondo {$nId}","fondos_listar.php");
      exit;
    }
    Log_System( "FONDOS" , "ELIMINA" , "IMAGEN: " . $reg->imagen  );
    mysqli_close( $nConexion );
    Mensaje( "El registro ha sido eliminado correctamente.","fondos_listar.php" );
    exit();
  }
?>
<?
  function FondosFormEditar( $nId ) {
  	global $targets;
    $IdCiudad = $_SESSION["IdCiudad"];
    include("../../vargenerales.php");
    $nConexion = Conectar();
    $Resultado = mysqli_query($nConexion, "SELECT * FROM tblimagenes_fondo WHERE idimagen = '$nId'" ) ;
    $rCategorias = mysqli_query($nConexion, "SELECT * FROM tblfondos_categorias" ) ;
    mysqli_close( $nConexion ) ;

    $Registro = mysqli_fetch_array( $Resultado );
?>
    <!-- Formulario Edici�n / Eliminaci�n de Servicios -->
    <form method="post" action="fondos.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="<?=$nId;?>">
      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>EDITAR FONDO</b></td>
        </tr>
	</table>
	<table width="100%">
	  <tr>
	      <td class="tituloNombres">Categoria:</td>
	      <td class="contenidoNombres">
		<select name="idcategoria" >
		  <?php while ($r = mysqli_fetch_array( $rCategorias )):?>
		  <option value="<?=$r["idcategoria"];?>" <?=($r["idcategoria"]==$Registro["idcategoria"]?"selected":"");?>><?=$r["nombre"];?></option>
		  <?php endwhile;?>
		</select>
	      
	      </td>
	    </tr>
          <tr>
	      <td class="tituloNombres">Imagen:</td>
	      <td class="contenidoNombres"><input type="file" id="txtImagen" name="txtImagen[]"></td>
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
              ?><img src="<?=$cRutaVerImgFondos.$Registro["imagen"]; ?>"><?
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
	    <a href="fondos.php?Accion=Eliminar&Id=<?=$nId;?>"><img src="../../image/eliminar.gif" border="0" alt="Eliminar Registro." onClick="javascript: return confirm('�Esta seguro que desea eliminar este registro?')"></a>
            <a href="fondos_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
          </td>
        </tr>
      </table>
    </form>
<?
  mysqli_free_result( $Resultado );
  }
?>
