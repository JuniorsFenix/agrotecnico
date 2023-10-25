<? include("../../funciones_generales.php"); ?>
<?

  $targets = array(
    "_self",
    "_blank"
  );

  
  function CabezotesFormNuevo() {
  	global $targets;
    $IdCiudad = $_SESSION["IdCiudad"];
    
    $nConexion = Conectar();
    $Resultado = mysqli_query($nConexion, "SELECT * FROM tblcinta_categorias" ) ;
    mysqli_close( $nConexion ) ;
 
    
?>
    <!-- Formulario Ingreso de imagenes -->
    <form method="post" action="cabezotes.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="0">
      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>NUEVO CABEZOTE</b></td>
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
	    <a href="cabezotes_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
          </td>
        </tr>
      </table>
    </form>
<?php
  }
  ###############################################################################
?>
<?php

  function CabezotesGuardar( $nId,$url,$target,$archivo,$idcategoria ) {
    $IdCiudad = $_SESSION["IdCiudad"];
    $nConexion = Conectar();
    if ( $nId <= 0 ) {
      $sql = "INSERT INTO tblimagenes_cinta ( url,target,archivo,idcategoria ) 
      		VALUES ('{$url}',target='{$target}','{$archivo}','{$idcategoria}')";
      $ra = mysqli_query($nConexion,$sql);
      if ( !$ra ) {
	Mensaje( "Error registrando nuevo cabezote.", "cabezotes_listar.php" ) ;
	exit;
      }
      Log_System( "CINTA_TRANSPORTADORA" , "NUEVO" , "IMAGEN: " . $archivo  );
      mysqli_close($nConexion);
      Mensaje( "El registro ha sido almacenado correctamente.", "cabezotes_listar.php" ) ;
      return;
    }
    else {
    	$cTxtSQLUpdate = "UPDATE tblimagenes_cinta SET idcategoria='{$idcategoria}',url='{$url}',target='{$target}'";

    	if ( $archivo != "*" ){
    	    $cTxtSQLUpdate = $cTxtSQLUpdate . " , archivo = '{$archivo}'"  ;
    	}
    	 
    	$cTxtSQLUpdate = $cTxtSQLUpdate . " WHERE idimagen = {$nId}";
    	$ra = mysqli_query($nConexion,$cTxtSQLUpdate  );
	if ( !$ra ) {
	  Mensaje("Error actualizando cabezote {$nId}","cabezotes_listar.php");
	  exit;
	}
    	Log_System( "CINTA_TRANSPORTADORA" , "EDITA" , "IMAGEN: " . $archivo );
    	mysqli_close( $nConexion );
    	Mensaje( "El registro ha sido actualizado correctamente.", "cabezotes_listar.php" ) ;
    	return;
    }
  }
?>
<?
  function CabezotesEliminar( $nId )
  {
    $nConexion = Conectar();
    $reg = mysqli_fetch_object( mysqli_query($nConexion,"SELECT archivo FROM tblimagenes_cinta WHERE idimagen ='$nId'") );
    $sql = "DELETE FROM tblimagenes_cinta WHERE idimagen = $nId";
    $ra = mysqli_query($nConexion, $sql );
    if ( !$ra ) {
      Mensaje("Fallo eliminando cabezote {$nId}","cabezotes_listar.php");
      exit;
    }
    Log_System( "CABEZOTESJQ" , "ELIMINA" , "IMAGEN: " . $reg->archivo  );
    mysqli_close( $nConexion );
    Mensaje( "El registro ha sido eliminado correctamente.","cabezotes_listar.php" );
    exit();
  }
?>
<?
  function CabezotesFormEditar( $nId ) {
  	global $targets;
    $IdCiudad = $_SESSION["IdCiudad"];
    include("../../vargenerales.php");
    $nConexion = Conectar();
    $Resultado = mysqli_query($nConexion, "SELECT * FROM tblimagenes_cinta WHERE idimagen = '$nId'" ) ;
    $rCategorias = mysqli_query($nConexion, "SELECT * FROM tblcinta_categorias" ) ;
    mysqli_close( $nConexion ) ;

    $Registro = mysqli_fetch_array( $Resultado );
?>
    <!-- Formulario Edici�n / Eliminaci�n de Servicios -->
    <form method="post" action="cabezotes.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="<?=$nId;?>">
      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>EDITAR CABEZOTE</b></td>
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
	      <td class="contenidoNombres"><input type="file" id="txtImagen" name="txtImagen[]"></td>
	    </tr>
        <tr>
          <td class="tituloNombres">Imagen Actual:</td>
          <td>
          <?
            if ( empty($Registro["archivo"]) )
            {
              echo "No se asigno una imagen.";
            }
            else
            {
              ?><img src="<?=$cRutaVerImgCinta.$Registro["archivo"]; ?>"><?
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
	    <a href="cabezotes.php?Accion=Eliminar&Id=<?=$nId;?>"><img src="../../image/eliminar.gif" border="0" alt="Eliminar Registro." onClick="javascript: return confirm('�Esta seguro que desea eliminar este registro?')"></a>
            <a href="cabezotes_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
          </td>
        </tr>
      </table>
    </form>
<?
  mysqli_free_result( $Resultado );
  }
?>
