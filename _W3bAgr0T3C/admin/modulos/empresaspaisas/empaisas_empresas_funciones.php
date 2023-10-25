<?
  ###############################################################################
  # empaisas_empresas_funciones.php   :  Archivo de funciones modulo Empresas Paisas
  # Desarrollo               :  Estilo y Dise�o
  # Web                      :  http://www.esidi.com
  ###############################################################################
?>
<? include("../../funciones_generales.php"); ?>
<?
  ###############################################################################
  # Nombre        : EmpaisasEmpresassFormNuevo
  # Descripci�n   : Muestra el formulario para ingreso de productos nuevos
  # Parametros    : Ninguno.
  # Desarrollado  : Estilo y Dise�o
  # Retorno       : Ninguno
  ###############################################################################
  function EmpaisasEmpresasFormNuevo()
  {
?>
    <!-- Formulario Ingreso de Eventos -->
    <form method="post" action="empaisas_empresas.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="0">
      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>NUEVA EMPRESA</b></td>
        </tr>
        <tr>
          <td class="tituloNombres">Empresa:</td>
          <td class="contenidoNombres"><INPUT id="txtempaisas_nomempresa" type="text" name="txtempaisas_nomempresa" maxLength="150" style="WIDTH: 300px; HEIGHT: 22px"></td>
        </tr>
        <tr>
          <td colspan="2" class="tituloFormulario">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2"  class="nuevo">
            <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
            <a href="empaisas_empresas_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
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
  # Nombre        : ModhoDeptosGuardar
  # Descripci�n   : Adiciona un nuevo registro o actualiza uno existente
  # Parametros    : $nId , $nombredepto
  # Desarrollado  : Estilo y Dise�o
  # Retorno       : Ninguno
  ###############################################################################
  function EmpaisasEmpresassGuardar( $nId, $nombrempresa )
  {
//	$IdCiudad = $_SESSION["IdCiudad"];
    $nConexion = Conectar();
    if ( $nId <= 0 ) // Nuevo Registro
    {
      mysqli_query($nConexion,"INSERT INTO tblnombempaisa (nombempaisa) VALUES ( '$nombrempresa' )");
      mysqli_close($nConexion);
      Mensaje( "El registro ha sido almacenado correctamente.", "empaisas_empresas_listar.php" ) ;
      exit;
    }
    else // Actualizar Registro Existente
    {
        mysqli_query($nConexion, "UPDATE tblnombempaisa SET nombempaisa = '$nombrempresa' WHERE id_nombempaisa = '$nId'" );
		}		
      mysqli_close( $nConexion );
      Mensaje( "El registro ha sido actualizado correctamente.", "empaisas_empresas_listar.php" ) ;
      exit;
  } // FIN: function 
  ###############################################################################
?>
<?
  ###############################################################################
  # Nombre        : EmpaisasEmpresasEliminar
  # Descripci�n   : Eliminar un registro 
  # Parametros    : $nId
  # Desarrollado  : Estilo y Dise�o
  # Retorno       : Ninguno
  ###############################################################################
  function EmpaisasEmpresasEliminar( $nId )
  {
    $nConexion = Conectar();
    mysqli_query($nConexion, "DELETE FROM tblnombempaisa WHERE id_nombempaisa ='$nId'" );
    mysqli_close( $nConexion );
    Mensaje( "El registro ha sido eliminado correctamente.","empaisas_empresas_listar.php" );
    exit();
  } // FIN: function EmpaisasEmpresasGuardar
  ###############################################################################
?>
<?
  ###############################################################################
  # Nombre        : EmpaisasEmpresasFormEditar
  # Descripci�n   : Muestra el formulario para editar o eliminar registros
  # Parametros    : $nId = ID de registro que se debe mostrar el en formulario
  # Desarrollado  : Estilo y Dise�o
  # Retorno       : Ninguno
  ###############################################################################
  function EmpaisasEmpresasFormEditar( $nId )
  {
	include("../../vargenerales.php");
    $nConexion    = Conectar();
    $Resultado    = mysqli_query($nConexion, "SELECT * FROM tblnombempaisa WHERE id_nombempaisa = '$nId'" ) ;
    $Registro     = mysqli_fetch_array( $Resultado );
?>
    <!-- Formulario Edici�n / Eliminaci�n de Deptos Arrendamientos -->
    <form method="post" action="empaisas_empresas.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="<? echo $nId ; ?>">
      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>EDITAR EMPRESA</b></td>
        </tr>
        <tr>
          <td class="tituloNombres">Empresa:</td>
          <td class="contenidoNombres"><INPUT id="txtempaisas_nomempresa" type="text" name="txtempaisas_nomempresa" value="<? echo $Registro["nombempaisa"]; ?>" maxLength="150" style="WIDTH: 300px; HEIGHT: 22px"></td>
        </tr>
        <tr>
          <td colspan="2" class="tituloFormulario">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2" class="nuevo">
            <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
<a href="empaisas_empresas.php?Accion=Eliminar&Id=<? echo $nId ;?>"><img src="../../image/eliminar.gif" border="0" alt="Eliminar Registro." onClick="javascript: return confirm('�Esta seguro que desea eliminar este registro?')"></a>
            <a href="empaisas_empresas_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
          </td>
        </tr>
      </table>
    </form>
<?
  mysqli_free_result( $Resultado );
  }
  ###############################################################################
?>
