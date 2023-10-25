<?
  ###############################################################################
  # Desarrollo               :  Estilo y Dise�o
  # Web                      :  http://www.esidi.com
  ###############################################################################
?>
<? include("../../funciones_generales.php"); ?>
<?
  ###############################################################################
  # Descripci�n   : Muestra el formulario para ingreso de registros nuevos
  # Parametros    : Ninguno.
  # Retorno       : Ninguno
  ###############################################################################
  function BloquesFormNuevo($idBoletin,$cBoletin)
  {
?>
    <!-- Formulario Ingreso -->
    <form method="post" action="bloques.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="0">
			<input type="hidden" id="idboletin" name="idboletin" value="<?=$idBoletin;?>">
			<input type="hidden" id="boletin" name="boletin" value="<?=$cBoletin;?>">
			<input TYPE="hidden" id="txtOrden" name="txtOrden" value="0">
      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>NUEVO BLOQUE - BOLETIN: <?=$cBoletin;?></b></td>
        </tr>
        <tr>
          <td class="tituloNombres">Titulo:</td>
          <td class="contenidoNombres"><INPUT id="txtTitulo" type="text" name="txtTitulo" maxLength="100" style="WIDTH: 300px; HEIGHT: 22px"></td>
        </tr>        <tr>          <td class="tituloNombres">Orientacion:</td>          <td class="contenidoNombres">          <SELECT NAME="orientacion">          <OPTION VALUE="CENTRADO" >CENTRADO</OPTION>          <OPTION VALUE="IZQUIERDA" >IZQUIERDA</OPTION>          <OPTION VALUE="DERECHA" >DERECHA</OPTION>          </SELECT>          </td>        </tr>
        <tr>
          <td colspan="2" class="tituloNombres">Bloque</td>
        </tr>
			</table>
					<?
						/*$oFCKeditor = new FCKeditor('txtBloque') ;
						$oFCKeditor->BasePath = '../../herramientas/FCKeditor/';
						$oFCKeditor->Create() ;
						$oFCKeditor->Width  = '100%' ;
						$oFCKeditor->Height = '400' ;*/
					?>
                    <textarea name="txtBloque"></textarea>
                    <script>
                        CKEDITOR.replace( 'txtBloque' );
                    </script>
			<table width="100%">
        <tr>
          <td colspan="2" class="tituloFormulario">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2"  class="nuevo">
            <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
            <a href="bloques_listar.php?idboletin=<?=$idBoletin;?>&boletin=<?=$cBoletin;?>"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
          </td>
        </tr>
      </table>
    </form>
<?
  }
  ###############################################################################
?>
<?
  ###############################################################################
  # Nombre        : BloquesGuardar
  ###############################################################################
  function BloquesGuardar( $nId,$IdBoletin,$Titulo,$Orden,$Bloque,$NomBoletin ,$orientacion='CENTRADO')
  {
    $nConexion = Conectar();
    if ( $nId <= 0 ) // Nuevo Registro
    {
			// Calculo Orden Mayor y Sumo UNO
			$rs_Orden =  mysqli_query($nConexion,"SELECT MAX(orden)+1 AS nuevo_orden FROM tblboletines_blo WHERE idboletin = $IdBoletin");
			$Reg_Orden = mysqli_fetch_object($rs_Orden);
			if ( $Reg_Orden->nuevo_orden == null )
			{
				$nOrden = 1;
			}
			else
			{
				$nOrden = $Reg_Orden->nuevo_orden;
			}
			mysqli_free_result($rs_Orden);
      mysqli_query($nConexion,"INSERT INTO tblboletines_blo ( idboletin,titulo,orden,bloque,orientacion ) VALUES ( $IdBoletin,'$Titulo','$nOrden','$Bloque','{$orientacion}' )");
      mysqli_close($nConexion);
      Mensaje( "El registro ha sido almacenado correctamente.", "bloques_listar.php?idboletin=".$IdBoletin."&boletin=".$NomBoletin ) ;
      exit;
    }
    else // Actualizar Registro Existente
    {                         $sql = "UPDATE tblboletines_blo SET orientacion='{$orientacion}', titulo = '$Titulo',orden=$Orden,bloque='{$Bloque}' WHERE idbloque = '$nId'";
			@ $ra = mysqli_query($nConexion,$sql );            if(!$ra){                Mensaje( "Fallo actualizando ".mysqli_error($nConexion), "bloques_listar.php?idboletin=".$IdBoletin."&boletin=".$NomBoletin ) ;                echo $sql;                exit;            }
			Log_System( "BOLETINES" , "EDITA" , "TITULO: " . $cTitulo );
      mysqli_close( $nConexion );
      Mensaje( "El registro ha sido actualizado correctamente.", "bloques_listar.php?idboletin=".$IdBoletin."&boletin=".$NomBoletin ) ;
      exit;
		}
  } // FIN: function 
  ###############################################################################
?>
<?
  ###############################################################################
  # Nombre        : NoticiasEliminar
  # Descripci�n   : Eliminar un registro 
  # Parametros    : $nId
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function BoletinesEliminar( $nId )
  {
    $nConexion = Conectar();
		$reg = mysqli_fetch_object( mysqli_query($nConexion,"SELECT titulo FROM tblboletines WHERE idboletin ='$nId'") );
    mysqli_query($nConexion, "DELETE FROM tblboletines WHERE idboletin ='$nId'" );
		mysqli_query($nConexion, "DELETE FROM tblboletines_blo WHERE idboletin ='$nId'" );
		Log_System( "BOLETINES" , "ELIMINA" , "TITULO: " . $reg->titulo  );
    mysqli_close( $nConexion );
    Mensaje( "El registro ha sido eliminado correctamente.","boletines_listar.php" );
    exit();
  } // FIN: function UsuariosGuardar
  ###############################################################################
?>
<?
  ###############################################################################
  # Nombre        : BoletinesFormEditar
  ###############################################################################
  function BloquesFormEditar( $nId )
  {
	include("../../vargenerales.php");
    $nConexion    = Conectar();
    $Resultado    = mysqli_query($nConexion, "SELECT * FROM tblboletines_blo WHERE idbloque = '$nId'" ) ;
    mysqli_close( $nConexion ) ;

    $Registro     = mysqli_fetch_array( $Resultado );
?>
    <!-- Formulario Edici�n / Eliminaci�n de Noticias -->
    <form method="post" action="bloques.php?Accion=Guardar" enctype="multipart/form-data">      <input TYPE="hidden" id="txtId" name="txtId" value="<?=$Registro["idbloque"];?>">            <input type="hidden" id="idboletin" name="idboletin" value="<?=$Registro["idboletin"];?>">            <input type="hidden" id="boletin" name="boletin" value="">      <table width="100%">        <tr>          <td colspan="2" align="center" class="tituloFormulario"><b>NUEVO BLOQUE - BOLETIN: <?=$Registro["idboletin"];?></b></td>        </tr>        <tr>          <td class="tituloNombres">Titulo:</td>          <td class="contenidoNombres"><INPUT id="txtTitulo" type="text" name="txtTitulo" value="<?=$Registro["titulo"];?>" maxLength="100" style="WIDTH: 300px; HEIGHT: 22px"></td>        </tr>        <tr>          <td class="tituloNombres">Orden:</td>          <td class="contenidoNombres"><INPUT id="txtOrden" type="text" name="txtOrden" value="<?=$Registro["orden"];?>" maxLength="100" style="WIDTH: 300px; HEIGHT: 22px"></td>        </tr>                <tr>          <td class="tituloNombres">Orientacion:</td>          <td class="contenidoNombres">          <SELECT NAME="orientacion">          <OPTION VALUE="CENTRADO" <?=$Registro["orientacion"]=="CENTRADO"?"selected":"";?> >CENTRADO</OPTION>          <OPTION VALUE="IZQUIERDA" <?=$Registro["orientacion"]=="IZQUIERDA"?"selected":"";?> >IZQUIERDA</OPTION>          <OPTION VALUE="DERECHA" <?=$Registro["origentacion"]=="DERECHA"?"selected":"";?> >DERECHA</OPTION>          </SELECT>          </td>        </tr>                        <tr>          <td colspan="2" class="tituloNombres">Bloque</td>        </tr>            </table>                    
	<?                        
	/*$oFCKeditor = new FCKeditor('txtBloque') ;                        
	$oFCKeditor->BasePath = '../../herramientas/FCKeditor/';                                                
	$oFCKeditor->Width  = '100%' ;                        
	$oFCKeditor->Height = '400' ;                        
	$oFCKeditor->Value = $Registro["bloque"];                                                
	$oFCKeditor->Create() ; */                   
	?>     
    <textarea name="txtBloque"><? echo $Registro["bloque"]?></textarea>
    <script>
        CKEDITOR.replace( 'txtBloque' );
    </script>       
    <table width="100%">        <tr>          <td colspan="2" class="tituloFormulario">&nbsp;</td>        </tr>        <tr>          <td colspan="2"  class="nuevo">            <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">            <a href="bloques_listar.php?idboletin=<?=$Registro["idboletin"];?>"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>          </td>        </tr>      </table>
    </form>
<?
  mysqli_free_result( $Resultado );
  }
  ###############################################################################
	//BloquesMover( $_GET["Donde"] , $_GET["nIdMenu"] , $_GET["nOrdenActual"] );
	function BloquesMover( $cDonde, $nIdBloque, $nOrdenActual , $IdBoletin )
	{
		$nConexion    = Conectar();
		
		if ( $cDonde == "Abajo" )
		{
			$NuevoOrden = $nOrdenActual + 1;
			$rs 				= mysqli_query($nConexion, "SELECT * FROM tblboletines_blo WHERE orden > $nOrdenActual AND idboletin = $IdBoletin ORDER BY orden LIMIT 1"  );
			$Reg_rs			= mysqli_fetch_object( $rs );
			mysqli_free_result( $rs );
			$nId				= $Reg_rs->idbloque;
			mysqli_query($nConexion, "UPDATE tblboletines_blo SET orden = $nOrdenActual WHERE idbloque = $nId"  );
			mysqli_query($nConexion, "UPDATE tblboletines_blo SET orden = $NuevoOrden WHERE idbloque = $nIdBloque"  );
		}
		
		if ( $cDonde == "Arriba" )
		{
			$NuevoOrden = $nOrdenActual - 1;
			$rs 				= mysqli_query($nConexion, "SELECT * FROM tblboletines_blo WHERE orden < $nOrdenActual AND idboletin = $IdBoletin ORDER BY orden DESC LIMIT 1"  );
			$Reg_rs			= mysqli_fetch_object( $rs );
			mysqli_free_result( $rs );
			$nId				= $Reg_rs->idbloque;
			mysqli_query($nConexion, "UPDATE tblboletines_blo SET orden = $nOrdenActual WHERE idbloque = $nId"  );
			mysqli_query($nConexion, "UPDATE tblboletines_blo SET orden = $NuevoOrden WHERE idbloque = $nIdBloque"  );
		}
		mysqli_close( $nConexion );
	}


?>
