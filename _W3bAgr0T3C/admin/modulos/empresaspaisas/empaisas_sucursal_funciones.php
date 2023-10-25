<?
  ###############################################################################
  # empaisas_sucursal_funciones.php   	:  Archivo de funciones modulo Eventos
  # Desarrollo               		:  Estilo y Dise�o
  # Web                      		:  http://www.esidi.com
  ###############################################################################
?>
<? include("../../funciones_generales.php"); ?>
<?
  ###############################################################################
  # Nombre        : EmpaisasSucursalFormNuevo
  # Descripci�n   : Muestra el formulario para ingreso de productos nuevos
  # Parametros    : Ninguno.
  # Desarrollado  : Estilo y Dise�o
  # Retorno       : Ninguno
  ###############################################################################
  function EmpaisasSucursalFormNuevo()
  {
?>
    <!-- Formulario Ingreso de Municipios para Arrendamientos -->
    <form method="post" action="empaisas_sucursal.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="0">
      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>NUEVA SUCURSAL EMPRESAS PAISAS</b></td>
        </tr>
        <tr>
          <td class="tituloNombres">Empresa:</td>
          <td class="contenidoNombres"><select name="id_nombempaisa" id="id_nombempaisa">
            <?
            $nConexion = Conectar();
            $ResultadoCat = mysqli_query($nConexion, "SELECT * FROM tblnombempaisa ORDER BY id_nombempaisa" );
            mysqli_close($nConexion);
						$nContador = 0;
            while($Registros=mysqli_fetch_object($ResultadoCat))
            {
							$nContador = $nContador + 1;
							if ( $nContador == 1 )
              {
								?>
            <option selected value="<? echo $Registros->id_nombempaisa; ?>"><? echo $Registros->id_nombempaisa . "&nbsp;" . $Registros->nombempaisa ; ?></option>
            <?
							}
							else
							{
								?>
            <option value="<? echo $Registros->id_nombempaisa; ?>"><? echo $Registros->id_nombempaisa . "&nbsp;" . $Registros->nombempaisa ; ?></option>
            <?
							}
						}
            mysqli_free_result($ResultadoCat);
            ?>
          </select></td>
        </tr>
        <tr>
		  <td class="tituloNombres">Sucursal :</td>
          <td class="contenidoNombres"><INPUT id="txtnombresucempaisa" type="text" name="txtnombresucempaisa" maxLength="100" style="WIDTH: 300px; HEIGHT: 22px"></td>
        </tr>
        <tr>
          <td colspan="2" class="tituloFormulario">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2"  class="nuevo">
            <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
            <a href="empaisas_sucursal_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
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
  # Nombre        : EmpaisasSucursalGuardar
  # Descripci�n   : Adiciona un nuevo registro o actualiza uno existente
  # Parametros    : $nId , $nombredepto
  # Desarrollado  : Estilo y Dise�o
  # Retorno       : Ninguno
  ###############################################################################
  function EmpaisasSucursalGuardar( $nId, $id_nombempaisa, $nombresucursal )
  {
//	$IdCiudad = $_SESSION["IdCiudad"];
    $nConexion = Conectar();
    if ( $nId <= 0 ) // Nuevo Registro
    {
      mysqli_query($nConexion,"INSERT INTO tblsucempaisa (id_nombempaisa, nombresucempaisa) VALUES ( '$id_nombempaisa', '$nombresucursal' )");
      mysqli_close($nConexion);
      Mensaje( "El registro ha sido almacenado correctamente.", "empaisas_sucursal_listar.php" ) ;
      exit;
    }
    else // Actualizar Registro Existente
    {
        mysqli_query($nConexion, "UPDATE tblsucempaisa SET id_nombempaisa = '$id_nombempaisa', nombresucempaisa = '$nombresucursal' WHERE id_sucempaisa = '$nId'" );
		}		
      mysqli_close( $nConexion );
      Mensaje( "El registro ha sido actualizado correctamente.", "empaisas_sucursal_listar.php" ) ;
      exit;
  } // FIN: function 
  ###############################################################################
?>
<?
  ###############################################################################
  # Nombre        : EmpaisasSucursalEliminar
  # Descripci�n   : Eliminar un registro 
  # Parametros    : $nId
  # Desarrollado  : Estilo y Dise�o
  # Retorno       : Ninguno
  ###############################################################################
  function EmpaisasSucursalEliminar( $nId )
  {
    $nConexion = Conectar();
    mysqli_query($nConexion, "DELETE FROM tblsucempaisa WHERE id_sucempaisa ='$nId'" );
    mysqli_close( $nConexion );
    Mensaje( "El registro ha sido eliminado correctamente.","empaisas_sucursal_listar.php" );
    exit();
  } // FIN: function EmpaisasSucursalGuardar
  ###############################################################################
?>
<?
  ###############################################################################
  # Nombre        : EmpaisasSucursalFormEditar
  # Descripci�n   : Muestra el formulario para editar o eliminar registros
  # Parametros    : $nId = ID de registro que se debe mostrar el en formulario
  # Desarrollado  : Estilo y Dise�o
  # Retorno       : Ninguno
  ###############################################################################
  function EmpaisasSucursalFormEditar( $nId )
  {
	include("../../vargenerales.php");
    $nConexion    = Conectar();
    $Resultado    = mysqli_query($nConexion, "SELECT * FROM tblsucempaisa WHERE id_sucempaisa = '$nId'" ) ;
    $Registro     = mysqli_fetch_array( $Resultado );
?>
    <!-- Formulario Edici�n / Eliminaci�n de Municipios Arrendamientos -->
    <form method="post" action="empaisas_sucursal.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="<? echo $nId ; ?>">
      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>EDITAR SUCURSAL EMPRESAS PAISAS</b></td>
        </tr>
        <tr>
          <td class="tituloNombres">Empresa:</td>
          <td class="contenidoNombres"><select name="id_nombempaisa" id="id_nombempaisa">
            <?
            $nConexion = Conectar();
            $ResultadoCat = mysqli_query($nConexion, "SELECT * FROM tblnombempaisa order by id_nombempaisa" );
            mysqli_close($nConexion);
            while($Registros=mysqli_fetch_object($ResultadoCat))
            {
							if ( $Registro["id_nombempaisa"] == $Registros->id_nombempaisa )
              {
								?>
            <option selected value="<? echo $Registros->id_nombempaisa; ?>"><? echo $Registros->id_nombempaisa . "&nbsp;" . $Registros->nombempaisa ; ?></option>
            <?
							}
							else
							{
								?>
            <option value="<? echo $Registros->id_nombempaisa; ?>"><? echo $Registros->id_nombempaisa . "&nbsp;" . $Registros->nombempaisa ; ?></option>
            <?
							}
						}
            mysqli_free_result($ResultadoCat);
            ?>
          </select></td>
        </tr>
        <tr>
          <td class="tituloNombres">Sucursal :</td>
          <td class="contenidoNombres"><INPUT id="txtnombresucempaisa" type="text" name="txtnombresucempaisa" value="<? echo $Registro["nombresucempaisa"]; ?>" maxLength="100" style="WIDTH: 300px; HEIGHT: 22px"></td>
        </tr>
        </tr>
        <tr>
          <td colspan="2" class="tituloFormulario">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2" class="nuevo">
            <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
<a href="empaisas_sucursal.php?Accion=Eliminar&Id=<? echo $nId ;?>"><img src="../../image/eliminar.gif" border="0" alt="Eliminar Registro." onClick="javascript: return confirm('�Esta seguro que desea eliminar este registro?')"></a>
            <a href="empaisas_sucursal_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
          </td>
        </tr>
      </table>
    </form>
<?
  mysqli_free_result( $Resultado );
  }
  ###############################################################################
?>
