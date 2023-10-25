<?
  ###############################################################################
  # archivos_login_funciones.php :  Archivo de funciones modulo categorias
  # Desarrollo               :  Estilo y Dise�o & Informaticactiva
  # Web                      :  http://www.esidi.com
  #                             
  ###############################################################################
	include("../../funciones_generales.php");
?>
<?
  ###############################################################################
  # Nombre        : UsuaregLoginFormNuevo
  # Descripci�n   : Muestra el formulario para ingreso de categorias nuevas
  # Parametros    : Ninguno.
  # Desarrollado  : Estilo y Dise�o
  # Retorno       : Ninguno
  ###############################################################################
  function UsuaregLoginFormNuevo()
  {
?>
    <!-- Formulario Ingreso de Categorias -->
    <form action="archivos_login_usuareg.php?Accion=Guardar" method="post" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="0">
      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>NUEVO USUARIO REGISTRADO</b>
		  </td>
        </tr>
        <tr>
        		<td class="tituloNombres">Nombres:</td>
        		<td class="contenidoNombres"><input id="txtNombres" type="text" name="txtNombres" maxlength="100" style="WIDTH: 300px; HEIGHT: 22px"></td>
   		</tr>
	   <tr>
        		<td class="tituloNombres">Apellidos:</td>
        		<td class="contenidoNombres"><input id="txtApellidos" type="text" name="txtApellidos" maxlength="100" style="WIDTH: 300px; HEIGHT: 22px"></td>
   		</tr>
        <tr>
        		<td class="tituloNombres">Ciudad:</td>
        		<td class="contenidoNombres"><input id="txtCiudad" type="text" name="txtCiudad" maxlength="100" style="WIDTH: 200px; HEIGHT: 22px"></td>
   		</tr>
        <tr>
        		<td class="tituloNombres">Direccion:</td>
        		<td class="contenidoNombres"><input id="txtDireccion" type="text" name="txtDireccion" maxlength="100" style="WIDTH: 300px; HEIGHT: 22px"></td>
   		</tr>						
        <tr>
        		<td class="tituloNombres">Telefono:</td>
        		<td class="contenidoNombres"><input id="txtTel" type="text" name="txtTel" maxlength="100" style="WIDTH: 150px; HEIGHT: 22px"></td>
       	</tr>
        <tr>
        		<td class="tituloNombres">E-Mail:</td>
        		<td class="contenidoNombres"><input id="txtMail" type="text" name="txtMail" maxlength="100" style="WIDTH: 300px; HEIGHT: 22px"></td>
       	</tr>
        <tr>
        		<td class="tituloNombres">Usuario:</td>
        		<td class="contenidoNombres"><input id="txtUsername" type="text" name="txtUsername" maxlength="100" style="WIDTH: 80px; HEIGHT: 22px"></td>
       	</tr>
		<tr>
        		<td class="tituloNombres">Clave:</td>
        		<td class="contenidoNombres"><input id="txtClave" type="text" name="txtClave" maxlength="100" style="WIDTH: 80px; HEIGHT: 22px"></td>
       	</tr>
			<tr>
				<td class="tituloNombres">Permitido:</td>
				<td class="contenidoNombres">
					<table border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td><label><input type="radio" id="optPermitido" name="optPermitido" value="Si">Si</label></td>
							<td width="10"></td>
							<td><label><input type="radio" id="optPermitido" name="optPermitido" value="No" checked>No</label></td>
						</tr>
					</table>
			  </td>
			</tr>					
	  </table>
			<table width="100%">
        <tr>
          <td colspan="2" class="tituloFormulario">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2" class="nuevo">
            <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
            <a href="archivos_login_listar_usuareg.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
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
  # Nombre        : UsuaregLoginGuardar
  # Descripci�n   : Adiciona un nuevo registro o actualiza uno existente
  # Parametros    : cCategoria, nId (Si el Cero Nuevo Registro, de lo contrario Actualizar un Registro)
  # Desarrollado  : Estilo y Dise�o
  # Retorno       : Ninguno
  ###############################################################################
  function UsuaregLoginGuardar( $nId,$cNombres,$cApellidos,$cCiudad,$cDireccion,$cTel,$cMail,$cUsername,$cClave,$cPermitido )
  {
	$IdCiudad = $_SESSION["IdCiudad"];
    $nConexion = Conectar();
	$fechareg=date("Y-m-d");
	$permit=$cPermitido;
	//echo "permitido: " . $permit;
	if ($permit=="Si")
		{
  		$fechaval=date("Y-m-d");
		}
		else
		{
  		$fechaval="0000-00-00";
		}
    if ( $nId <= 0 ) // Nuevo Registro
    	{
		mysqli_query($nConexion,"INSERT INTO tbl_registroslogintur  ( nombres,apellidos,ciudad,direccion,telefono,mail,username,clave,permitido,fecharegistro,fechavalidacion,idciudad ) VALUES ('$cNombres','$cApellidos','$cCiudad','$cDireccion','$cTel','$cMail','$cUsername','$cClave','$cPermitido','$fechareg','$fechaval',$IdCiudad)");
		Log_System( "USUARIOS REGISTRADOS" , "NUEVO" , "NOMBRES: " . $cNombres . $cApellidos );
      mysqli_close($nConexion);
      Mensaje( "El registro ha sido almacenado correctamente.", "archivos_login_listar_usuareg.php" ) ;
      exit;
    }
    else // Actualizar Registro Existente
    	{
		mysqli_query($nConexion, "UPDATE tbl_registroslogintur SET nombres = '$cNombres', apellidos = '$cApellidos', ciudad = '$cCiudad' , direccion = '$cDireccion' , telefono = '$cTel' , mail = '$cMail' , username = '$cUsername' , clave = '$cClave' , permitido = '$cPermitido' , fecharegistro = '$fechareg' , fechavalidacion = '$fechaval' , idciudad = $IdCiudad WHERE idlogin = '$nId' AND ( idciudad = $IdCiudad )" );
		Log_System( "USUARIOS REGISTRADOS" , "EDITA" , "NOMBRES: " . $cNombres . $cApellidos  );
      mysqli_close( $nConexion );
      Mensaje( "El registro ha sido actualizado correctamente.", "archivos_login_listar_usuareg.php" ) ;
      exit;
    }
  } // FIN: function 
  ###############################################################################
?>
<?
  ###############################################################################
  # Nombre        : UsuaregLoginEliminar
  # Descripci�n   : Eliminar un registro 
  # Parametros    : $nId
  # Desarrollado  : Estilo y Dise�o
  # Retorno       : Ninguno
  ###############################################################################
  function UsuaregLoginEliminar( $nId )
  {
		$IdCiudad = $_SESSION["IdCiudad"];
    $nConexion = Conectar();
		$reg = mysqli_fetch_object( mysqli_query($nConexion,"SELECT * FROM tbl_registroslogintur WHERE idlogin ='$nId' AND ( idciudad = $IdCiudad )") );
    mysqli_query($nConexion, "DELETE FROM tbl_registroslogintur WHERE idlogin ='$nId' AND ( idciudad = $IdCiudad )" );
		Log_System( "USUARIOS REGISTRADOS" , "ELIMINA" , "NOMBRES: " . $reg->categoria  );
    mysqli_close( $nConexion );
    Mensaje( "El registro ha sido eliminado correctamente.","archivos_login_listar_usuareg.php" );
    exit();
  } // FIN: function UsuariosGuardar
  ###############################################################################
?>
<?
  ###############################################################################
  # Nombre        : UsuaregLoginFormEditar
  # Descripci�n   : Muestra el formulario para editar o eliminar registros
  # Parametros    : $nId = ID de registro que se debe mostrar el en formulario
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function UsuaregLoginFormEditar( $nId )
  {
		include("../../vargenerales.php");
		//$IdCiudad	= $_SESSION["IdCiudad"];
    $nConexion    = Conectar();
    $Resultado    = mysqli_query($nConexion, "SELECT * FROM tbl_registroslogintur WHERE idlogin = '$nId'" ) ;
		mysqli_close( $nConexion ) ;

    $Registro     = mysqli_fetch_array( $Resultado );

?>
    <form method="post" action="archivos_login_usuareg.php?Accion=Guardar" enctype="multipart/form-data">
<input type="hidden" id="txtId" name="txtId" value="<? echo $nId ; ?>">	  
<table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>EDITAR USUARIO REGISTRADO</b>
				</td>
        </tr>
        <tr>
          <td class="tituloNombres">Nombres:</td>
          <td class="contenidoNombres"><INPUT id="txtNombres" type="text" name="txtNombres" value="<? echo $Registro['nombres'] ;?>" maxLength="100" style="WIDTH: 300px; HEIGHT: 22px"></td>
        </tr>
	   <tr>
        		<td class="tituloNombres">Apellidos:</td>
        		<td class="contenidoNombres"><input id="txtApellidos" type="text" name="txtApellidos" maxlength="100" value="<? echo $Registro[ "apellidos" ] ;?>" style="WIDTH: 300px; HEIGHT: 22px"></td>
	</tr>
        <tr>
        		<td class="tituloNombres">Ciudad:</td>
        		<td class="contenidoNombres"><input id="txtCiudad" type="text" name="txtCiudad" value="<? echo $Registro[ "ciudad" ] ;?>" maxlength="100"  style="WIDTH: 200px; HEIGHT: 22px"></td>
   		</tr>
        <tr>
        		<td class="tituloNombres">Direccion:</td>
        		<td class="contenidoNombres"><input id="txtDireccion" type="text" name="txtDireccion" maxlength="100" value="<? echo $Registro[ "direccion" ] ;?>" style="WIDTH: 300px; HEIGHT: 22px"></td>
   		</tr>						
        <tr>
        		<td class="tituloNombres">Telefono:</td>
        		<td class="contenidoNombres"><input id="txtTel" type="text" name="txtTel" maxlength="100" value="<? echo $Registro[ "telefono" ] ;?>" style="WIDTH: 150px; HEIGHT: 22px"></td>
       	</tr>
        <tr>
        		<td class="tituloNombres">E-Mail:</td>
        		<td class="contenidoNombres"><input id="txtMail" type="text" name="txtMail" maxlength="100" value="<? echo $Registro[ "mail" ] ;?>" style="WIDTH: 300px; HEIGHT: 22px"></td>
       	</tr>
        <tr>
        		<td class="tituloNombres">Usuario:</td>
        		<td class="contenidoNombres"><input id="txtUsername" type="text" name="txtUsername" maxlength="100" value="<? echo $Registro[ "username" ] ;?>" style="WIDTH: 80px; HEIGHT: 22px"></td>
       	</tr>
		<tr>
        		<td class="tituloNombres">Clave:</td>
        		<td class="contenidoNombres"><input id="txtClave" type="text" name="txtClave" maxlength="100" value="<? echo $Registro[ "clave" ] ;?>" style="WIDTH: 80px; HEIGHT: 22px"></td>
       	</tr>
			<tr>
				<td class="tituloNombres">Permitido:</td>
				<td class="contenidoNombres">
					<table border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td><label><input type="radio" id="optPermitido" name="optPermitido" value="Si" <? if ( $Registro["permitido"] == "Si" ) echo "checked" ?>>Si</label></td>
							<td width="10"></td>
							<td><label><input type="radio" id="optPermitido" name="optPermitido" value="No" <? if ( $Registro["permitido"] == "No" ) echo "checked" ?>>No</label></td>
						</tr>
					</table>
			  </td>
			</tr>		
<tr>
          <td colspan="3" class="tituloFormulario">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="3"  class="nuevo">
            <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
            <?
				if ( Perfil() != "3" )
				{
                	?><a href="archivos_login_usuareg.php?Accion=Eliminar&Id=<? echo $nId ;?>"><img src="../../image/eliminar.gif" border="0" alt="Eliminar Registro." onClick="javascript: return confirm('�Esta seguro que desea eliminar este registro?')"></a><?
				}
            ?>
            <a href="archivos_login_listar_usuareg.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
          </td>
        </tr>
      </table>
    </form>
<?
  mysqli_free_result( $Resultado );
  }
  ###############################################################################
?>
