<? include("../../funciones_generales.php"); ?>
<?
  
  function CategoriasFormNuevo() {
    global $efectos;
    global $posiciones;
    global $direcciones;
    $IdCiudad = $_SESSION["IdCiudad"];
?>
    <!-- Formulario Ingreso de imagenes -->
    <form method="post" action="categorias.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="0">
      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>NUEVA CATEGORIA</b></td>
        </tr>

	</table>
	
	<br><br>
	<br><br>
	  
<table width="100%">
	  <tr>
	    <td class="tituloNombres">Nombre:</td>
	    <td class="contenidoNombres"><input type="text" id="nombre" name="nombre" value=""></td>
	  </tr>
	  <tr>
	    <td class="tituloNombres">Color de Fondo:</td>
	    <td class="contenidoNombres">
	      <input type="text" id="background" name="background" value="">
	    </td>
	  </tr>
	  <tr>
	    <td class="tituloNombres">Ancho:</td>
	    <td class="contenidoNombres"><input type="text" id="width" name="width" value=""></td>
	  </tr>
	  <tr>
	    <td class="tituloNombres">Alto:</td>
	    <td class="contenidoNombres"><input type="text" id="height" name="height" value=""></td>
	  </tr>
	  <!--<tr>
	    <td class="tituloNombres">Margen:</td>
	    <td class="contenidoNombres"><input type="text" id="margen" name="margen" value="10"></td>
	  </tr>
	  <tr>-->
	    <td class="tituloNombres">Velocidad:</td>
	    <td class="contenidoNombres"><input type="text" id="velocidad" name="velocidad" value="3"></td>
	  </tr>
        <tr>
          <td colspan="2" class="tituloFormulario">&nbsp;</td>
        </tr>
	</table>
	
	<table width="100%">
        <tr>
          <td colspan="2" class="nuevo">
            <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
	    <a href="categorias_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
          </td>
        </tr>
      </table>
    </form>
<?php
  }
  ###############################################################################
?>
<?php

  function CategoriasGuardar( $nId,$nombre,$background,$width,$height,$margen,$velocidad ) {
    $IdCiudad = $_SESSION["IdCiudad"];
    $nConexion = Conectar();
    if ( $nId <= 0 ) {
      $sql = "INSERT INTO tblcinta_categorias ( nombre,background,width,height,margen,velocidad) 
      			VALUES ('{$nombre}','{$background}','{$width}','{$height}','{$margen}','{$velocidad}')";
      $ra = mysqli_query($nConexion,$sql);
      if ( !$ra ) {
	Mensaje( "Error registrando nueva categoria.", "categorias_listar.php" ) ;
	exit;
      }
      mysqli_close($nConexion);
      Mensaje( "El registro ha sido almacenado correctamente.", "categorias_listar.php" ) ;
      return;
    }
    else {
    	$cTxtSQLUpdate = "UPDATE tblcinta_categorias SET nombre='{$nombre}',background='{$background}',
    						width='{$width}',height='{$height}',margen='{$margen}',velocidad='{$velocidad}' WHERE idcategoria = {$nId} ";
    	
    	$ra = mysqli_query($nConexion,$cTxtSQLUpdate  );
	if ( !$ra ) {
	  Mensaje("Error actualizando categoria {$nId}","categorias_listar.php");
	  exit;
	}
    	mysqli_close( $nConexion );
    	Mensaje( "El registro ha sido actualizado correctamente.", "categorias_listar.php" ) ;
    	return;
    }
  }
?>
<?
  function CategoriasEliminar( $nId )
  {
    $nConexion = Conectar();
    $sql = "DELETE FROM tblcinta_categorias WHERE idcategoria = $nId";
    $ra = mysqli_query($nConexion, $sql );
    if ( !$ra ) {
      Mensaje("Fallo eliminando categoria {$nId}","categorias_listar.php");
      exit;
    }
    mysqli_close( $nConexion );
    Mensaje( "El registro ha sido eliminado correctamente.","categorias_listar.php" );
    exit();
  }
?>
<?
  function CategoriasFormEditar( $nId ) {
    global $efectos;
    global $posiciones;
    global $direcciones;

    $IdCiudad = $_SESSION["IdCiudad"];
    include("../../vargenerales.php");
    $nConexion = Conectar();
    $Resultado = mysqli_query($nConexion, "SELECT * FROM tblcinta_categorias WHERE idcategoria = '$nId'" ) ;
    mysqli_close( $nConexion ) ;

    $Registro = mysqli_fetch_array( $Resultado );
?>
    <!-- Formulario Edici�n / Eliminaci�n de Servicios -->
    <form method="post" action="categorias.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="<?=$nId;?>">
      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>EDITAR CATEGORIA</b></td>
        </tr>
        
	</table>

	<table width="100%">
	  <tr>
	    <td class="tituloNombres">Nombre:</td>
	    <td class="contenidoNombres"><input type="text" id="nombre" name="nombre" value="<?=$Registro["nombre"]?>"></td>
	  </tr>
	  <tr>
	    <td class="tituloNombres">Color de Fondo:</td>
	    <td class="contenidoNombres">
	      <input type="text" id="background" name="background" value="<?=$Registro["background"]?>">
	    </td>
	  </tr>
	  <tr>
	    <td class="tituloNombres">Ancho:</td>
	    <td class="contenidoNombres"><input type="text" id="width" name="width" value="<?=$Registro["width"]?>"></td>
	  </tr>
	  <tr>
	    <td class="tituloNombres">Alto:</td>
	    <td class="contenidoNombres"><input type="text" id="height" name="height" value="<?=$Registro["height"]?>"></td>
	  </tr>
	  <!--<tr>
	    <td class="tituloNombres">Margen:</td>
	    <td class="contenidoNombres"><input type="text" id="margen" name="margen" value="<?=$Registro["margen"]?>"></td>
	  </tr>-->
	  <tr>
	    <td class="tituloNombres">Velocidad:</td>
	    <td class="contenidoNombres"><input type="text" id="velocidad" name="velocidad" value="<?=$Registro["velocidad"]?>"></td>
	  </tr>
         <tr>
          <td colspan="2" class="tituloFormulario">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2" class="nuevo">
            <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
	    <a href="categorias.php?Accion=Eliminar&Id=<?=$nId;?>"><img src="../../image/eliminar.gif" border="0" alt="Eliminar Registro." onClick="javascript: return confirm('�Esta seguro que desea eliminar este registro?')"></a>
            <a href="categorias_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
          </td>
        </tr>
      </table>
    </form>
<?
  mysqli_free_result( $Resultado );
  }
?>
