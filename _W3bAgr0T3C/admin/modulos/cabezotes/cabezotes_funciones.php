<?php include("../../funciones_generales.php");


  ini_set("memory_limit","128M");
  ini_set("upload_max_filesize", "50M");
  ini_set("max_execution_time","240");//3 MINUTOS
  ini_set("post_max_size","50M");
  ini_set("max_input_time","240");

  $targets = array(
    "_self",
    "_blank"
  );

  $efectos = array(
  		"cube" => "CUBE",
  		"cubeRandom" => "CUBE RANDOM", 
  		"cubeStop" => "CUBE STOP",
  		"cubeHide" => "CUBE HIDE",
  		"cubeSize" => "CUBE SIZE",
  		"block" => "BLOCK",
  		"horizontal" => "HORIZONTAL",
  		"showBars" => "SHOW BARS",
  		"showBarsRandom" => "SHOW BARS RANDOM",
  		"tube" => "TUBE",
  		"fade" => "FADE",
  		"fadeFour" => "FADE FOUR",
  		"paralell" => "PARALELL",
  		"blind" => "BLIND",
  		"blindHeight" => "BLIND HEIGHT",
  		"blindWidth" => "BLIND WIDTH",
  		"directionTop" => "DIRECTION TOP",
  		"directionBottom" => "DIRECTION BOTTOM",
  		"directionRight" => "DIRECTION RIGHT",
  		"directionLeft" => "DIRECTION LEFT",
  		"cubeSpread" => "CUBE SPREAD",
  		"cubeJelly" => "CUBE JELLY",
  		"glassCube" => "GLASS CUBE",
  		"glassBlock" => "GLASS BLOCK",
  		"circles" => "CIRCLES",
  		"circlesInside" => "CIRCLES INSIDE",
  		"cubeShow" => "CUBE SHOW",
  		"upBars" => "UP BARS",
  		"downBars" => "DOWN BARS",
  		"random" => "RANDOM",
  		"randomSmart" => "RANDOM SMART",
  		"cubeStopRandom" => "CUBE STOP RANDOM"
		); 

  
  function CabezotesFormNuevo($idcategoria) {
  	global $targets;
  	global $efectos;
    $IdCiudad = $_SESSION["IdCiudad"];
    
    $nConexion = Conectar();
    $Resultado = mysqli_query($nConexion, "SELECT * FROM tblcabezotes_categorias" ) ;
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
	      <td colspan="2" class="tituloNombres">Descripci�n:</td>
	      <!--<td class="contenidoNombres"><textarea rows="20" id="txtDetalle" name="txtDetalle" cols="80"></textarea></td>-->
	    </tr>
	  </table>
	  <?php
	    /*$oFCKeditor = new FCKeditor("descripcion") ;
	    $oFCKeditor->BasePath = '../../herramientas/FCKeditor/';
	    $oFCKeditor->Create() ;
	    $oFCKeditor->Width  = '80%' ;
	    $oFCKeditor->Height = '150' ;*/
	  ?>
        <textarea name="descripcion"></textarea>
        <script>
            CKEDITOR.replace( 'descripcion' );
        </script>
	  <table width="100%">
	    <tr>
	      <td class="tituloNombres">Categoria:</td>
	      <td class="contenidoNombres">
		<select name="idcategoria" >
		  <?php while ($r = mysqli_fetch_array( $Resultado )):?>
		  <option value="<?=$r["idcategoria"];?>" <?=($r["idcategoria"]==$idcategoria?"selected":"");?>><?=$r["nombre"];?></option>
		  <?php endwhile;?>
		</select>
	      
	      </td>
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
	      <td class="tituloNombres">Video:</td>
	      <td class="contenidoNombres"><input type="file" name="video"></td>
	    </tr>
        <tr>
          <td colspan="2" class="tituloFormulario">&nbsp;</td>
        </tr>
	</table>
	
	<table width="100%">
        <tr>
          <td colspan="2" class="nuevo">
            <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
	    <a href="cabezotes_listar.php?idcategoria=1"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
          </td>
        </tr>
      </table>
    </form>
<?php
  }
  ###############################################################################

  function CabezotesGuardar( $nId,$descripcion,$idcategoria,$efecto,$url,$target,$archivo,$video ) {
    $IdCiudad = $_SESSION["IdCiudad"];
    $nConexion = Conectar();
    if ( $nId <= 0 ) {
      $sql = "INSERT INTO tblcabezotes ( descripcion,idcategoria,efecto,url,target,archivo,video ) 
      		VALUES ('{$descripcion}','{$idcategoria}','{$efecto}','{$url}',target='{$target}','{$archivo}','{$video}')";
      $ra = mysqli_query($nConexion,$sql);
      if ( !$ra ) {
	Mensaje( "Error registrando nuevo cabezote.".mysqli_error($nConexion), "cabezotes_listar.php" ) ;
	exit;
      }
      Log_System( "CABEZOTESJQ" , "NUEVO" , "IMAGEN: " . $archivo  );
      mysqli_close($nConexion);
      Mensaje( "El registro ha sido almacenado correctamente.", "cabezotes_listar.php?idcategoria=$idcategoria" ) ;
      return;
    }
    else {
    	$cTxtSQLUpdate = "UPDATE tblcabezotes SET descripcion='{$descripcion}',idcategoria='{$idcategoria}',efecto='{$efecto}',url='{$url}',target='{$target}'";

    	if ( $archivo != "" ){
    	    $cTxtSQLUpdate = $cTxtSQLUpdate . ", archivo = '{$archivo}'"  ;
    	}
    	if ( $video != "" ){
    	    $cTxtSQLUpdate = $cTxtSQLUpdate . ", video = '{$video}'"  ;
    	}
    	 
    	$cTxtSQLUpdate = $cTxtSQLUpdate . " WHERE idcabezote = {$nId}";
    	$ra = mysqli_query($nConexion,$cTxtSQLUpdate  );
	if ( !$ra ) {
	  Mensaje("Error actualizando cabezote {$nId}","cabezotes_listar.php?idcategoria=$idcategoria");
	  exit;
	}
    	Log_System( "CABEZOTESJQ" , "EDITA" , "IMAGEN: " . $archivo );
    	mysqli_close( $nConexion );
    	Mensaje( "El registro ha sido actualizado correctamente.", "cabezotes_listar.php?idcategoria=$idcategoria" ) ;
    	return;
    }
  }
?>
<?
  function CabezotesEliminar( $nId )
  {
    $nConexion = Conectar();
    $reg = mysqli_fetch_object( mysqli_query($nConexion,"SELECT archivo FROM tblcabezotes WHERE idcabezote ='$nId'") );
    $sql = "DELETE FROM tblcabezotes WHERE idcabezote = $nId";
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
  	global $efectos;
    $IdCiudad = $_SESSION["IdCiudad"];
    include("../../vargenerales.php");
    $nConexion = Conectar();
    $Resultado = mysqli_query($nConexion, "SELECT * FROM tblcabezotes WHERE idcabezote = '$nId'" ) ;
    $rCategorias = mysqli_query($nConexion, "SELECT * FROM tblcabezotes_categorias" ) ;
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
        <tr>
          <td colspan="2" class="tituloNombres">Descripci�n:</td>
          <!--<td class="contenidoNombres"><textarea rows="20" id="txtDetalle" name="txtDetalle" cols="80"><? //echo $Registro["descripcion"]; ?></textarea></td>-->
        </tr>
	</table>
	<?
	/*$oFCKeditor = new FCKeditor('descripcion') ;
	$oFCKeditor->BasePath = '../../herramientas/FCKeditor/';
	$oFCKeditor->Value = $Registro["descripcion"];
	$oFCKeditor->Create() ;
	$oFCKeditor->Width  = '100%' ;
	$oFCKeditor->Height = '400' ;*/
	?>
        <textarea name="descripcion"><? echo $Registro["descripcion"]?></textarea>
        <script>
            CKEDITOR.replace( 'descripcion' );
        </script>
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
            <td class="tituloNombres">Efecto:</td>
            <td class="contenidoNombres">
              <select name="effect">
            <?php foreach ( $efectos as $k => $v ):?>
            <option value="<?=$k?>" <?=($Registro["efecto"]==$k?"selected":"");?>><?=$v;?></option>
            <?php endforeach;?>
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
	      <td class="contenidoNombres"><input type="file" id="txtImagen" name="txtImagen"></td>
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
              ?><img style="max-width:100%;" src="<?=$cRutaVerCabezotesjq.$Registro["archivo"]; ?>"><?
            }
          ?>
          </td>
        </tr>
	    <tr>
	      <td class="tituloNombres">Video:</td>
	      <td class="contenidoNombres"><input type="file" name="video"></td>
	    </tr>
        <tr>
          <td class="tituloNombres">Video Actual:</td>
          <td>
          <?
            if ( empty($Registro["video"]) )
            {
              echo "No se asigno un video.";
            }
            else
            {
			  ?><a href="<?php echo $cRutaVerCabezotesjq.$Registro["video"]; ?>"><?php echo $Registro["video"]; ?></a><?
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
            <a href="cabezotes_listar.php?idcategoria=<?=$Registro["idcategoria"];?>"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
          </td>
        </tr>
      </table>
    </form>
<?
  mysqli_free_result( $Resultado );
  }
?>
