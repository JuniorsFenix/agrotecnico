<?
  ###############################################################################
  # archivos_usuareg_funciones.php  :  Archivo de funciones modulo productos / servicios
  # Desarrollo               :  Estilo y Dise�o
  # Web                      :  http://www.esidi.com
  #   
  ###############################################################################
?>
<? include("../../funciones_generales.php"); ?>
<?
  ###############################################################################
  # Nombre        : ArchivosUsuaregFormNuevo
  # Descripci�n   : Muestra el formulario para ingreso de productos nuevos
  # Parametros    : Ninguno.
  # Desarrollado  : Estilo y Dise�o
  # Retorno       : Ninguno
  ###############################################################################
  function ArchivosUsuaregFormNuevo()
  {
		$IdCiudad			= $_SESSION["IdCiudad"];
?>
		<script>
		<!--
		function land(ref, target)
		{
		lowtarget=target.toLowerCase();
		if (lowtarget=="_self") {window.location=loc;}
		else {if (lowtarget=="_top") {top.location=loc;}
		else {if (lowtarget=="_blank") {window.open(loc);}
		else {if (lowtarget=="_parent") {parent.location=loc;}
		else {parent.frames[target].location=loc;};
		}}}
		}
		function jump(menu)
		{
		ref=menu.cboIdlogin.options[menu.cboIdlogin.selectedIndex].value;
		splitc=ref.lastIndexOf("*");
		target="";
		if (splitc!=-1)
		{loc=ref.substring(0,splitc);
		target=ref.substring(splitc+1,1000);}
		else {loc=ref; target="_self";};
		if (ref != "") {land(loc,target);}
		}
		//-->
		</script>
    <!-- Formulario Ingreso de Archivos -->
    <form method="post" action="archivos_usuareg.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="0">
      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>NUEVO ARCHIVO USUARIO REGISTRADO</b></td>
        </tr>
        <tr>
          <td width="27%" class="tituloNombres">Usuario:</td>
          <td width="73%" class="contenidoNombres">
            <select name="cboIdlogin" id="cboIdlogin">
            <?
            $nConexion = Conectar();
            $ResultadoCat = mysqli_query($nConexion, "SELECT * FROM tbl_registroslogintur WHERE idciudad = $IdCiudad AND permitido = 'Si'" );
            mysqli_close($nConexion);
            $nContador = 0;
            while($Registros=mysqli_fetch_object($ResultadoCat))
            {
			$nContador = $nContador + 1;
			if ( $nContador == 1 )
              {
				?>
					<option selected value="<? echo $Registros->idlogin; ?>"><? echo $Registros->idlogin . "&nbsp;" . $Registros->nombres . "&nbsp;" . $Registros->apellidos; ?></option>
				<?
				}
				else
				{
				?>
					<option value="<? echo $Registros->idlogin; ?>"><? echo $Registros->idlogin . "&nbsp;" . $Registros->nombres . "&nbsp;" . $Registros->apellidos ; ?></option>
				<?
				}
			}
            mysqli_free_result($ResultadoCat);
            ?></select>
          </td>
        </tr>

	  </table>
			<table width="100%">
        <tr>
          <td width="27%" class="tituloNombres">Adjuntar Archivo:</td>
          <td width="73%" class="contenidoNombres"><input type="file" id="txtAdjunto[]" name="txtAdjunto[]"></td>
          <td colspan="2" class="tituloFormulario">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2" class="nuevo">
            <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
            <a href="archivos_usuareg_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
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
  # Nombre        : ArchivosUsuaregGuardar
  # Descripci�n   : Adiciona un nuevo registro o actualiza uno existente
  # Parametros    : $nId (Si el Cero Nuevo Registro, de lo contrario Actualizar un Registro)
  #                 $nIdCategoria, $cProducto, $cDetalle, $nPrecio, $cImagen
  # Desarrollado  : Estilo y Dise�o
  # Retorno       : Ninguno
  ###############################################################################
  function ArchivosGuardar( $nId,$nIdlogin,$cAdjunto )
  {
    $nConexion = Conectar();
	$fecha=date("Y-m-d");
	
	$ResultadoCreado = mysqli_query($nConexion, "SELECT * FROM tbl_registroslogintur WHERE idlogin = $nIdlogin"  );
	//mysqli_close($nConexion);
	$RegistrosCreado=mysqli_fetch_object($ResultadoCreado);
	$cCreadopor = $RegistrosCreado->nombres . "&nbsp;" . $RegistrosCreado->apellidos ;
	
		$IdCiudad			= $_SESSION["IdCiudad"];
    if ( $nId <= 0 ) // Nuevo Registro
    {
      mysqli_query($nConexion,"INSERT INTO tbl_fotostur2 ( idfotos,idlogin,fecha,foto1,creadopor ) VALUES ( '$nId','$nIdlogin','$fecha','$cAdjunto','$cCreadopor')");
			echo mysqli_error($nConexion);
			Log_System( "ARCHIVOSUSUAREG" , "NUEVO" , "ARCHIVOUSUAREG: " . $cCreadopor );
      mysqli_close($nConexion);
      Mensaje( "El registro ha sido almacenado correctamente.", "archivos_usuareg_listar.php" ) ;
      exit;
    }
    else // Actualizar Registro Existente
    {
			$cTxtSQLUpdate = "UPDATE tbl_fotostur2 SET idlogin = '$nIdlogin',fecha = '$cfecha', foto1 = '$cAdjunto'  WHERE idfotos = '$nId'";
			mysqli_query($nConexion,$cTxtSQLUpdate  );
			Log_System( "ARCHIVOSUSUAREG" , "EDITA" , "ARCHIVOUSUAREG: " . $cCreadopor );
			mysqli_close( $nConexion );
			Mensaje( "El registro ha sido actualizado correctamente.", "archivos_usuareg_listar.php" ) ;
			exit;
    }
  } // FIN: function 
  ###############################################################################
?>
<?
  ###############################################################################
  # Nombre        : ArchivosUsuaregEliminar
  # Descripci�n   : Eliminar un registro 
  # Parametros    : $nId
  # Desarrollado  : Estilo y Dise�o
  # Retorno       : Ninguno
  ###############################################################################
  function ArchivosUsuaregEliminar( $nId )
  {
    $nConexion = Conectar();
	$reg = mysqli_fetch_object( mysqli_query($nConexion,"SELECT * FROM tbl_registroslogintur WHERE idlogin ='$nId'") );
    mysqli_query($nConexion, "DELETE FROM tbl_fotostur2 WHERE idfotos = '$nId'" );
	Log_System( "ARCHIVOSUSUAREG" , "ELIMINA" , "ARCHIVOUSUAREG: " . $reg->nombres . "&nbsp;" . $Reg->apellidos );
    mysqli_close( $nConexion );
    Mensaje( "El registro ha sido eliminado correctamente.","archivos_usuareg_listar.php" );
    exit();
  } // FIN: function UsuariosGuardar
  ###############################################################################
?>
<?
  ###############################################################################
  # Nombre        : ArchivosUsuaregFormEditar
  # Descripci�n   : Muestra el formulario para editar o eliminar registros
  # Parametros    : $nId = ID de registro que se debe mostrar el en formulario
  # Desarrollado  : Estilo y Dise�o
  # Retorno       : Ninguno
  ###############################################################################
  function ArchivosUsuaregFormEditar( $nId )
  {
		$IdCiudad = $_SESSION["IdCiudad"];
		include("../../vargenerales.php");
    $nConexion    = Conectar();
    $Resultado    = mysqli_query($nConexion, "SELECT * FROM tbl_fotostur2 WHERE idfotos = '$nId'" ) ;
    mysqli_close( $nConexion ) ;

    $Registro     = mysqli_fetch_array( $Resultado );
?>
    <!-- Formulario Edici�n / Eliminaci�n de Productos -->
    <form method="post" action="archivos_usuareg.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="<? echo $nId ; ?>">
      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>EDITAR ARCHIVO USUARIO REGISTRADO</b></td>
        </tr>
        <tr>
          <td width="27%" class="tituloNombres">Usuario:</td>
          <td width="73%" class="contenidoNombres">
            <select name="cboIdlogin" id="cboIdlogin">
            <?
            $nConexion = Conectar();
            $ResultadoCat = mysqli_query($nConexion, "SELECT * FROM tbl_registroslogintur WHERE idciudad = $IdCiudad AND permitido = 'Si' ORDER BY idlogin" );
            mysqli_close($nConexion);
            while($Registros=mysqli_fetch_object($ResultadoCat))
            {
			if ( $Registro["idlogin"] == $Registros->idlogin )
              {
				?>
					<option selected value="<? echo $Registros->idlogin; ?>"><? echo $Registros->idlogin . "&nbsp;" . $Registros->nombres . "&nbsp;" . $Registros->apellidos ; ?></option>
				<?
				}
				else
				{
				?>
					<option value="<? echo $Registros->idlogin; ?>"><? echo $Registros->idlogin . "&nbsp;" . $Registros->nombres . "&nbsp;" . $Registros->apellidos ; ?></option>
				<?
				}
			}
            mysqli_free_result($ResultadoCat);
            ?></select>
          </td>
        </tr>
	  </table>
			<table width="100%">
        <tr>
          <td width="27%" class="tituloNombres">Archivo:</td>
          <td width="73%" class="contenidoNombres"><input type="file" id="txtAdjunto[]" name="txtAdjunto[]"></td>
        </tr>
        <tr>
          <td class="tituloNombres">Archivo Adjunto Actual:</td>
          <td>
          <?
            if ( empty($Registro["foto1"]) )
            {
              echo "No se asigno un archivo adjunto.";
            }
            else
			
				$cadena = $Registro["foto1"]; 
				$extension = substr($cadena,-4);//Esto devuelve extension del archivo ej ".swf"
				//echo $extension;
				if ($extension==".swf"){
				?><img src="<? echo $cRutaVerImgFotostur;?>flash.jpg"><?
				}
				
				else
				{
				?><img src="<? echo $cRutaVerImgFotostur . $Registro["foto1"]; ?>"><?
				}					
          ?>
		  
          </td>

          <td colspan="2" class="tituloFormulario">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2" class="nuevo">
            <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
						<?
						if ( Perfil() != "3" )
						{
						?><a href="archivos_usuareg.php?Accion=Eliminar&Id=<? echo $nId ;?>"><img src="../../image/eliminar.gif" border="0" alt="Eliminar Registro." onClick="javascript: return confirm('�Esta seguro que desea eliminar este registro?')"></a><?
						}
						?>
            <a href="archivos_usuareg_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
          </td>
        </tr>
      </table>
    </form>
<?
  mysqli_free_result( $Resultado );
  }
  ###############################################################################
?>