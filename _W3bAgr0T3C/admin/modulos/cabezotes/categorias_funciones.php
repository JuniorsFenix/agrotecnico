<?php include("../../funciones_generales.php"); 
  
  function CategoriasFormNuevo() {
    $IdCiudad = $_SESSION["IdCiudad"];
?>
    <!-- Formulario Ingreso de imagenes -->
    <form method="post" action="categorias.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="false">
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
	    <td class="tituloNombres">Textura:</td>
	    <td class="contenidoNombres">
	      <select name="textura" class="textura">
	      	<option value="pattern_1">Textura 1</option>
	      	<option value="pattern_2">Textura 2</option>
	      	<option value="pattern_3">Textura 3</option>
	      	<option value="pattern_4">Textura 4</option>
	      	<option value="pattern_5">Textura 5</option>
	      	<option value="pattern_6">Textura 6</option>
	      	<option value="pattern_7">Textura 7</option>
	      	<option value="pattern_8">Textura 8</option>
	      	<option value="pattern_9">Textura 9</option>
	      	<option value="pattern_10">Textura 10</option>
	      </select>
          <div id="pattern"></div>
            <script>
			$(document).ready(function($){
				$('.textura').change(function(){
					$('#pattern').attr('class', this.value);
				});
			});
			function outputUpdate(vol) {
			document.querySelector('#opacidad').innerHTML = vol;
			}
            </script>
          </td>
	  </tr>
	  <tr>
	    <td class="tituloNombres">Opacidad:</td>
	    <td class="contenidoNombres"><input type="range" min="0" max="1" value=".6" id="opacidad" name="opacidad" step=".05" oninput="outputUpdate(value)">
<output for="fader" id="opacidad">0.6</output></td>
	  </tr>
        <tr>
          <td colspan="2" class="tituloFormulario">&nbsp;</td>
        </tr>
	</table>
	
	<table width="100%">
        <tr>
          <td colspan="2" class="nuevo">
            <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
	    <a href="categorias_listar.php"><img src="../../image/cancelar.gif" border="false" alt="Cancelar y Regresar."></a>
          </td>
        </tr>
      </table>
    </form>
<?php
  }


  function CategoriasGuardar( $nId,$nombre,$opacidad,$textura ) {
    $IdCiudad = $_SESSION["IdCiudad"];
    $nConexion = Conectar();
	mysqli_set_charset($nConexion,'utf8');
    if ( $nId <= 0 ) {
      $sql = "INSERT INTO tblcabezotes_categorias ( nombre,opacidad,textura) 
      			VALUES ('{$nombre}','{$opacidad}','{$textura}')";
      $ra = mysqli_query($nConexion,$sql);
      if ( !$ra ) {
		  die(mysqli_error($nConexion));
	Mensaje( "Error registrando nueva categoria.", "categorias_listar.php" ) ;
	exit;
      }
      mysqli_close($nConexion);
      Mensaje( "El registro ha sido almacenado correctamente.", "categorias_listar.php" ) ;
      return;
    }
    else {
    	$cTxtSQLUpdate = "UPDATE tblcabezotes_categorias SET nombre='{$nombre}',opacidad='{$opacidad}',textura='{$textura}' WHERE idcategoria = {$nId} ";
    	
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

  function CategoriasEliminar( $nId )
  {
    $nConexion = Conectar();
	mysqli_set_charset($nConexion,'utf8');
    $sql = "DELETE FROM tblcabezotes_categorias WHERE idcategoria = $nId";
    $ra = mysqli_query($nConexion, $sql );
    if ( !$ra ) {
      Mensaje("Fallo eliminando categoria {$nId}","categorias_listar.php");
      exit;
    }
    mysqli_close( $nConexion );
    Mensaje( "El registro ha sido eliminado correctamente.","categorias_listar.php" );
    exit();
  }

  function CategoriasFormEditar( $nId ) {
    global $efectos;
    global $posiciones;
    global $direcciones;

    $IdCiudad = $_SESSION["IdCiudad"];
    include("../../vargenerales.php");
    $nConexion = Conectar();
	mysqli_set_charset($nConexion,'utf8');
    $Resultado = mysqli_query($nConexion, "SELECT * FROM tblcabezotes_categorias WHERE idcategoria = '$nId'" ) ;
    mysqli_close( $nConexion ) ;

    $Registro = mysqli_fetch_array( $Resultado );
?>
    <!-- Formulario Edición / Eliminación de Servicios -->
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
	    <td class="tituloNombres">Textura:</td>
	    <td class="contenidoNombres">
	      <select name="textura" class="textura">
	      	<option value="pattern_1" <?=(("pattern_1"==$Registro["textura"])?"selected":"");?>>Textura 1</option>
	      	<option value="pattern_2" <?=(("pattern_2"==$Registro["textura"])?"selected":"");?>>Textura 2</option>
	      	<option value="pattern_3" <?=(("pattern_3"==$Registro["textura"])?"selected":"");?>>Textura 3</option>
	      	<option value="pattern_4" <?=(("pattern_4"==$Registro["textura"])?"selected":"");?>>Textura 4</option>
	      	<option value="pattern_5" <?=(("pattern_5"==$Registro["textura"])?"selected":"");?>>Textura 5</option>
	      	<option value="pattern_6" <?=(("pattern_6"==$Registro["textura"])?"selected":"");?>>Textura 6</option>
	      	<option value="pattern_7" <?=(("pattern_7"==$Registro["textura"])?"selected":"");?>>Textura 7</option>
	      	<option value="pattern_8" <?=(("pattern_8"==$Registro["textura"])?"selected":"");?>>Textura 8</option>
	      	<option value="pattern_9" <?=(("pattern_9"==$Registro["textura"])?"selected":"");?>>Textura 9</option>
	      	<option value="pattern_10" <?=(("pattern_10"==$Registro["textura"])?"selected":"");?>>Textura 10</option>
	      </select>
          <div id="pattern" class="<?php echo $Registro["textura"];?>"></div>
            <script>
			$(document).ready(function($){
				$('.textura').change(function(){
					$('#pattern').attr('class', this.value);
				});
			});
			function outputUpdate(vol) {
			document.querySelector('#opacidad').innerHTML = vol;
			}
            </script>
          </td>
	  </tr>
	  <tr>
	    <td class="tituloNombres">Opacidad:</td>
	    <td class="contenidoNombres"><input type="range" min="0" max="1" value="<?=$Registro["opacidad"]?>" name="opacidad" step=".05" oninput="outputUpdate(value)">
<output for="fader" id="opacidad"><?=$Registro["opacidad"]?></output></td>
	  </tr>
        <tr>
          <td colspan="2" class="tituloFormulario">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2" class="nuevo">
            <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
	    <a href="categorias.php?Accion=Eliminar&Id=<?=$nId;?>"><img src="../../image/eliminar.gif" border="false" alt="Eliminar Registro." onClick="javascript: return confirm('¿Esta seguro que desea eliminar este registro?')"></a>
            <a href="categorias_listar.php"><img src="../../image/cancelar.gif" border="false" alt="Cancelar y Regresar."></a>
          </td>
        </tr>
      </table>
    </form>
<?
  mysqli_free_result( $Resultado );
  }
?>
