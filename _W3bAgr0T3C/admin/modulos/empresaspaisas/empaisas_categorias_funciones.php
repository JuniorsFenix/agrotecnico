<?
  ###############################################################################
  # empaisas_categorias_funciones.php      :  Archivo de funciones modulo Categorias de Empresas Paisas 
  # Desarrollo               :  Estilo y Dise�o
  # Web                      :  http://www.esidi.com
  ###############################################################################
?>
<? include("../../funciones_generales.php"); ?>
<?
  ###############################################################################
  # Nombre        : EmpaisasCategoriasFormNuevo
  # Descripci�n   : Muestra el formulario para ingreso de productos nuevos
  # Parametros    : Ninguno.
  # Desarrollado  : Estilo y Dise�o
  # Retorno       : Ninguno
  ###############################################################################
  function EmpaisasCategoriasFormNuevo()
  {
?>
    <!-- Formulario Ingreso de Eventos -->
    <form method="post" action="empaisas_categorias.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="">
      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>NUEVA CATEGORIA DE EMPRESAS PAISAS</b></td>
        </tr>
        <tr>
          <td class="tituloNombres">Caregoria:</td>
          <td class="contenidoNombres"><INPUT id="txtcategoria" type="text" name="txtcategoria" maxLength="150" style="WIDTH: 300px; HEIGHT: 22px"></td>
        </tr>
        <tr>
          <td colspan="2" class="tituloFormulario">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2"  class="nuevo">
            <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
            <a href="empaisas_categorias_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
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
  # Nombre        : EmpaisasCategoriasGuardar
  # Descripci�n   : Adiciona un nuevo registro o actualiza uno existente
  # Parametros    : $nId , $nombreagencia
  # Desarrollado  : Estilo y Dise�o
  # Retorno       : Ninguno
  ###############################################################################
  function EmpaisasCategoriasGuardar( $nId, $nombrecategoria )
  {
//	$IdCiudad = $_SESSION["IdCiudad"];
    $nConexion = Conectar();
    if ( $nId <= 0 ) // Nuevo Registro
    {
      mysqli_query($nConexion,"INSERT INTO tblcategempaisa (nombreagencia) VALUES ( '$nombrecategoria' )");
      mysqli_close($nConexion);
      Mensaje( "El registro ha sido almacenado correctamente.", "empaisas_categorias_listar.php" ) ;
      exit;
    }
    else // Actualizar Registro Existente
    {
        mysqli_query($nConexion, "UPDATE tblcategempaisa SET nombrecategoria = '$nombrecategoria' WHERE id_categoria = '$nId'" );
		}		
      mysqli_close( $nConexion );
      Mensaje( "El registro ha sido actualizado correctamente.", "empaisas_categorias_listar.php" ) ;
      exit;
  } // FIN: function 
  ###############################################################################
?>
<?
  ###############################################################################
  # Nombre        : EmpaisasCategoriasEliminar
  # Descripci�n   : Eliminar un registro 
  # Parametros    : $nId
  # Desarrollado  : Estilo y Dise�o
  # Retorno       : Ninguno
  ###############################################################################
  function EmpaisasCategoriasEliminar( $nId )
  {
    $nConexion = Conectar();
    mysqli_query($nConexion, "DELETE FROM tblcategempaisa WHERE id_categoria ='$nId'" );
    mysqli_close( $nConexion );
    Mensaje( "El registro ha sido eliminado correctamente.","empaisas_categorias_listar.php" );
    exit();
  } // FIN: function EmpaisasCategorias Eliminar
  ###############################################################################
?>
<?
  ###############################################################################
  # Nombre        : EmpaisasCategoriasFormEditar
  # Descripci�n   : Muestra el formulario para editar o eliminar registros
  # Parametros    : $nId = ID de registro que se debe mostrar el en formulario
  # Desarrollado  : Estilo y Dise�o
  # Retorno       : Ninguno
  ###############################################################################
  function EmpaisasCategoriasFormEditar( $nId )
  {
	include("../../vargenerales.php");
    $nConexion    = Conectar();
    $Resultado    = mysqli_query($nConexion, "SELECT * FROM tblcategempaisa  WHERE id_categoria = '$nId'" ) ;
    $Registro     = mysqli_fetch_array( $Resultado );
?>
    <!-- Formulario Edici�n / Eliminaci�n de Tipos de Propiedad -->
    <form method="post" action="empaisas_categorias.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="<? echo $nId ; ?>">
      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>EDITAR CATEGORIA DE EMPRESAS PAISAS</b></td>
        </tr>
        <tr>
          <td class="tituloNombres">Categoria:</td>
          <td class="contenidoNombres"><INPUT id="txtcategoria" type="text" name="txtcategoria" value="<? echo $Registro["nombrecategoria"]; ?>" maxLength="150" style="WIDTH: 300px; HEIGHT: 22px"></td>
        </tr>
        <tr>
          <td colspan="2" class="tituloFormulario">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2" class="nuevo">
            <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
<a href="empaisas_categorias.php?Accion=Eliminar&Id=<? echo $nId ;?>"><img src="../../image/eliminar.gif" border="0" alt="Eliminar Registro." onClick="javascript: return confirm('�Esta seguro que desea eliminar este registro?')"></a>
            <a href="empaisas_categorias_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
          </td>
        </tr>
      </table>
    </form>
<?
  mysqli_free_result( $Resultado );
  }
  ###############################################################################
?>
