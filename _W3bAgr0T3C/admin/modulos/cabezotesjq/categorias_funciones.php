<? include("../../funciones_generales.php"); ?>
<?

  $efectos = array("" => "",
  		"wave" => "WAVE",
  		"zipper" => "ZIPPER", 
  		"curtain" => "CURTAIN"
		);
		
$posiciones = array("" => "",
		"top" => "TOP", 
		"bottom" => "BOTTOM", 
		"alternate" => "ALTERNATE", 
		"curtain" => "CURTAIN"
		);

$direcciones = array ("" => "",
		"left" => "LEFT", 
		"right" => "RIGHT", 
		"alternate" => "ALTERNATE", 
		"random" => "RANDOM", 
		"fountain" => "FOUNTAIN", 
		"fountainAlternate" => "FOUNTAIN ALTERNATE"
);
  
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
	    <td class="tituloNombres">Efecto:</td>
	    <td class="contenidoNombres">
	      <select name="effect">
		<?php foreach ( $efectos as $k => $v ):?>
		<option value="<?=$k?>"><?=$v;?></option>
		<?php endforeach;?>
	      </select>
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
	  <tr>
	    <td class="tituloNombres">Tiras:</td>
	    <td class="contenidoNombres"><input type="text" id="strips" name="strips" value="10"></td>
	  </tr>
	  <tr>
	    <td class="tituloNombres">Duracion de imagen (ms):</td>
	    <td class="contenidoNombres"><input type="text" id="delay" name="delay" value="5000"></td>
	  </tr>
	  <tr>
	    <td class="tituloNombres">Duracion de tiras (ms):</td>
	    <td class="contenidoNombres"><input type="text" id="stripDelay" name="stripDelay" value="50"></td>
	  </tr>
	  <tr>
	    <td class="tituloNombres">Opacidad del titulo:</td>
	    <td class="contenidoNombres"><input type="text" id="titleOpacity" name="titleOpacity" value="0.7"></td>
	  </tr>
	  <tr>
	    <td class="tituloNombres">Tiempo de aparicion del titulo (ms):</td>
	    <td class="contenidoNombres"><input type="text" id="titleSpeed" name="titleSpeed" value="1000"></td>
	  </tr>
	  <tr>
	    <td class="tituloNombres">Posicion:</td>
	    <td class="contenidoNombres">
	      <select name="position">
		<?php foreach ( $posiciones as $k => $v ):?>
		<option value="<?=$k?>" <?=(($k==$Registro["position"])?"selected":"");?> ><?=$v;?></option>
		<?php endforeach;?>
	      </select>
	    </td>
	  </tr>
	  <tr>
	    <td class="tituloNombres">Direccion:</td>
	    <td class="contenidoNombres">
	      <select name="direction">
		<?php foreach ( $direcciones as $k => $v ):?>
		<option value="<?=$k?>" <?=(($k==$Registro["direction"])?"selected":"");?> ><?=$v;?></option>
		<?php endforeach;?>
	      </select>
	    </td>
	  </tr>
	  <tr>
	    <td class="tituloNombres">Navegacion (Botones Prev y Next):</td>
	    <td class="contenidoNombres">
	      <select name="navegation">
	      	<option value="" <?=((""==$Registro["navegation"])?"selected":"");?>></option>
	      	<option value="0" <?=(("0"==$Registro["navegation"])?"selected":"");?> >No</option>
	      	<option value="1" <?=(("1"==$Registro["navegation"])?"selected":"");?> >Si</option>
	      </select>
	    </td>
	  </tr>
	  <tr>
	    <td class="tituloNombres">Enlaces:</td>
	    <td class="contenidoNombres">
	      <select name="links">
			<option value="" <?=((""==$Registro["links"])?"selected":"");?>></option>
	      	<option value="0" <?=(("0"==$Registro["links"])?"selected":"");?> >No</option>
	      	<option value="1" <?=(("1"==$Registro["links"])?"selected":"");?> >Si</option>
	      </select>
	    </td>
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

  function CategoriasGuardar( $nId,$nombre,$effect,$width,$height,$strips,$delay,$stripDelay,$titleOpacity,$titleSpeed,$position,$direction,$navigation,$links ) {
    $IdCiudad = $_SESSION["IdCiudad"];
    $nConexion = Conectar();
    if ( $nId <= 0 ) {
      $sql = "INSERT INTO tblcabezotesjq_categorias ( nombre,effect,width,height,strips,delay,stripDelay,titleOpacity,titleSpeed,position,direction,navigation,links) 
      			VALUES ('{$nombre}','{$effect}','{$width}','{$height}','{$strips}','{$delay}','{$stripDelay}','{$titleOpacity}','{$titleSpeed}','{$position}',
      			'{$direction}','{$navigation}','{$links}')";
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
    	$cTxtSQLUpdate = "UPDATE tblcabezotesjq_categorias SET nombre='{$nombre}',effect='{$effect}',
    						width='{$width}',height='{$height}',strips='{$strips}',delay='{$delay}',stripDelay='{$stripDelay}',
    						titleOpacity='{$titleOpacity}',titleSpeed='{$titleSpeed}',position='{$position}',direction='{$direction}',
    						navigation='{$navigation}',links='{$links}' WHERE idcategoria = {$nId} ";
    	
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
    $sql = "DELETE FROM tblcabezotesjq_categorias WHERE idcategoria = $nId";
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
    $Resultado = mysqli_query($nConexion, "SELECT * FROM tblcabezotesjq_categorias WHERE idcategoria = '$nId'" ) ;
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
	    <td class="tituloNombres">Efecto:</td>
	    <td class="contenidoNombres">
	      <select name="effect">
		<?php foreach ( $efectos as $k => $v ):?>
		<option value="<?=$k?>" <?=(($k==$Registro["effect"])?"selected":"");?> ><?=$v;?></option>
		<?php endforeach;?>
	      </select>
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
	  <tr>
	    <td class="tituloNombres">Tiras:</td>
	    <td class="contenidoNombres"><input type="text" id="strips" name="strips" value="<?=$Registro["strips"]?>"></td>
	  </tr>
	  <tr>
	    <td class="tituloNombres">Duracion de imagen (ms):</td>
	    <td class="contenidoNombres"><input type="text" id="delay" name="delay" value="<?=$Registro["delay"]?>"></td>
	  </tr>
	  <tr>
	    <td class="tituloNombres">Duracion de tiras (ms):</td>
	    <td class="contenidoNombres"><input type="text" id="stripDelay" name="stripDelay" value="<?=$Registro["stripDelay"]?>"></td>
	  </tr>
	  <tr>
	    <td class="tituloNombres">Opacidad del titulo:</td>
	    <td class="contenidoNombres"><input type="text" id="titleOpacity" name="titleOpacity" value="<?=$Registro["titleOpacity"]?>"></td>
	  </tr>
	  <tr>
	    <td class="tituloNombres">Tiempo de aparicion del titulo (ms):</td>
	    <td class="contenidoNombres"><input type="text" id="titleSpeed" name="titleSpeed" value="<?=$Registro["titleSpeed"]?>"></td>
	  </tr>
	  <tr>
	    <td class="tituloNombres">Posicion:</td>
	    <td class="contenidoNombres">
	      <select name="position">
		<?php foreach ( $posiciones as $k => $v ):?>
		<option value="<?=$k?>" <?=(($k==$Registro["position"])?"selected":"");?> ><?=$v;?></option>
		<?php endforeach;?>
	      </select>
	    </td>
	  </tr>
	  <tr>
	    <td class="tituloNombres">Direccion:</td>
	    <td class="contenidoNombres">
	      <select name="direction">
		<?php foreach ( $direcciones as $k => $v ):?>
		<option value="<?=$k?>" <?=(($k==$Registro["direction"])?"selected":"");?> ><?=$v;?></option>
		<?php endforeach;?>
	      </select>
	    </td>
	  </tr>
	  <tr>
	    <td class="tituloNombres">Navegacion (Botones Prev y Next):</td>
	    <td class="contenidoNombres">
	      <select name="navigation">
	      	<option value="" <?=((""==$Registro["navigation"])?"selected":"");?>></option>
	      	<option value="0" <?=(("0"==$Registro["navigation"])?"selected":"");?> >No</option>
	      	<option value="1" <?=(("1"==$Registro["navigation"])?"selected":"");?> >Si</option>
	      </select>
	    </td>
	  </tr>
	  <tr>
	    <td class="tituloNombres">Enlaces:</td>
	    <td class="contenidoNombres">
	      <select name="links">
			<option value="" <?=((""==$Registro["links"])?"selected":"");?>></option>
	      	<option value="0" <?=(("0"==$Registro["links"])?"selected":"");?> >No</option>
	      	<option value="1" <?=(("1"==$Registro["links"])?"selected":"");?> >Si</option>
	      </select>
	    </td>
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
