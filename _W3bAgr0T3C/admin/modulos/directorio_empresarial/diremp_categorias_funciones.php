<?
  ###############################################################################
  # diremp_categorias_funciones.php      :  Archivo de funciones modulo Categorias de Directorio Empresarial
  # Desarrollo               :  Estilo y Dise�o
  # Web                      :  http://www.esidi.com
  ###############################################################################
?>
<? include("../../funciones_generales.php"); ?>
<?
  ###############################################################################
  # Nombre        : dirempCategoriasFormNuevo
  # Descripci�n   : Muestra el formulario para ingreso de categorias nuevas
  # Parametros    : Ninguno.
  # Desarrollado  : Estilo y Dise�o
  # Retorno       : Ninguno
  ###############################################################################
  function dirempCategoriasFormNuevo()
  {
?>
    <!-- Formulario Ingreso de Eventos -->
    <form method="post" action="diremp_categorias.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="">
      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario">
              <b>NUEVA CATEGORIA DE DIRECTORIO EMPRESARIAL</b>
          </td>
        </tr>
        <tr>
          <td class="tituloNombres">
              Categoria:
          </td>
          <td class="contenidoNombres">
              <INPUT id="txtcategoria" type="text" name="txtnombre" maxLength="150" style="WIDTH: 300px; HEIGHT: 22px">
          </td>
        </tr>
        <tr>
          <td colspan="2" class="tituloFormulario">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2"  class="nuevo">
            <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
            <a href="diremp_categorias_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
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
  # Nombre        : dirempCategoriasGuardar
  # Descripci�n   : Adiciona un nuevo registro o actualiza uno existente
  # Parametros    : $nId , $nombreagencia
  # Desarrollado  : Estilo y Dise�o
  # Retorno       : Ninguno
  ###############################################################################
  function dirempCategoriasGuardar( $nId, $nombrecategoria )
  {
//	$IdCiudad = $_SESSION["IdCiudad"];
    $nConexion = Conectar();
    if ( $nId <= 0 ) // Nuevo Registro
    {
      mysqli_query($nConexion,"INSERT INTO tbldiremp_categorias (nombre) VALUES ( '$nombrecategoria' )");
      mysqli_close($nConexion);
      Mensaje( "El registro ha sido almacenado correctamente.", "diremp_categorias_listar.php" ) ;
      exit;
    }
    else // Actualizar Registro Existente
    {
        mysqli_query($nConexion, "UPDATE tbldiremp_categorias SET nombre = '$nombrecategoria' WHERE codigo_categoria = '$nId'" );
		}		
      mysqli_close( $nConexion );
      Mensaje( "El registro ha sido actualizado correctamente.", "diremp_categorias_listar.php" ) ;
      exit;
  } // FIN: function 
  ###############################################################################
?>
<?
  ###############################################################################
  # Nombre        : dirempCategoriasEliminar
  # Descripci�n   : Eliminar un registro 
  # Parametros    : $nId
  # Desarrollado  : Estilo y Dise�o
  # Retorno       : Ninguno
  ###############################################################################
  function dirempCategoriasEliminar( $nId )
  {
    $nConexion = Conectar();
    mysqli_query($nConexion, "DELETE FROM tbldiremp_categorias WHERE codigo_categoria ='$nId'" );
    mysqli_close( $nConexion );
    Mensaje( "El registro ha sido eliminado correctamente.","diremp_categorias_listar.php" );
    exit();
  } // FIN: function dirempCategorias Eliminar
  ###############################################################################
?>
<?
  ###############################################################################
  # Nombre        : dirempCategoriasFormEditar
  # Descripci�n   : Muestra el formulario para editar o eliminar registros
  # Parametros    : $nId = ID de registro que se debe mostrar el en formulario
  # Desarrollado  : Estilo y Dise�o
  # Retorno       : Ninguno
  ###############################################################################
  function dirempCategoriasFormEditar( $nId )
  {
	include("../../vargenerales.php");
    $nConexion    = Conectar();
    $Resultado    = mysqli_query($nConexion, "SELECT * FROM tbldiremp_categorias  WHERE codigo_categoria = '$nId'" ) ;
    $Registro     = mysqli_fetch_array( $Resultado );
?>
    <!-- Formulario Edici�n / Eliminaci�n de Tipos de Propiedad -->
    <form method="post" action="diremp_categorias.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="<? echo $nId ; ?>">
      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario">
              <b>EDITAR CATEGORIA DE DIRECTORIO EMPRESARIAL</b>
          </td>
        </tr>
        <tr>
          <td class="tituloNombres">Categoria:</td>
          <td class="contenidoNombres">
              <INPUT id="txtcategoria" type="text" name="txtnombre" value="<?php echo $Registro["nombre"];?>" maxLength="150" style="WIDTH: 300px; HEIGHT: 22px">
          </td>
        </tr>
        <tr>
          <td colspan="2" class="tituloFormulario">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2" class="nuevo">
            <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
            <a href="diremp_categorias.php?Accion=Eliminar&Id=<?php echo $nId;?>">
                <img src="../../image/eliminar.gif" border="0" alt="Eliminar Registro." onClick="javascript: return confirm('�Esta seguro que desea eliminar este registro?')">
            </a>
            <a href="diremp_categorias_listar.php">
                <img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar.">
            </a>
          </td>
        </tr>
      </table>
    </form>
<?
  mysqli_free_result( $Resultado );
  }
  ###############################################################################
?>
