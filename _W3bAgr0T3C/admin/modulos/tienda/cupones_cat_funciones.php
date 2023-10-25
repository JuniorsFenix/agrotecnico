<?
  ###############################################################################
  # contenidos_funciones.php :  Archivo de funciones modulo
  # Desarrollo               :  Estilo y Dise�o - http://www.esidi.com
  # Web                      :  http://www.informaticactiva.com - Oscar Arley Yepes Aristizabal
  ###############################################################################
  require_once("../../funciones_generales.php");

  ini_set("memory_limit","50M");
  ini_set("upload_max_filesize", "30M");
  ini_set("max_execution_time","180");//3 MINUTOS
  ini_set("post_max_size","30M");
?>

<?
  ###############################################################################
  # Descripci�n   : Muestra el formulario para ingreso
  # Parametros    : Ninguno.
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function CategoriasFormNuevo()
  {
    $nConexion = Conectar();
  ?>
  <link href="../../css/administrador.css" rel="stylesheet" type="text/css">
  <!-- Formulario Ingreso -->
  <form method="post" action="cupones_categorias.php?Accion=Guardar" enctype="multipart/form-data">
    <input TYPE="hidden" id="IdCategoria" name="IdCategoria" value="0">
    <table width="100%">
      <tr>
        <td colspan="2" align="center" class="tituloFormulario"><b>NUEVA CATEGOR�A</b></td>
      </tr>
      <tr>
        <td class="tituloNombres">Nombre:</td>
        <td class="contenidoNombres"><INPUT id="txtNombre" type="text" name="txtNombre" maxLength="200" style="width:200px; "></td>
      </tr>
      <tr>
        <td class="tituloNombres">Descripcion:</td>
        <td class="contenidoNombres">
            <textarea id="txtDescripcion" name="txtDescripcion"></textarea>
            <script>
                CKEDITOR.replace( 'txtDescripcion' );
            </script>
        </td>
      </tr>
      <tr>
        <td colspan="2" class="tituloFormulario">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" class="nuevo">
          <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
          <a href="cupones_cat_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
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
  # Descripci�n   : Adiciona un nuevo registro o actualiza uno existente a la DB
  # Parametros    : $nId (Si el Cero Nuevo Registro, de lo contrario Actualizar un Registro)
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function CategoriasGuardar( $d )
  {

    $nConexion = Conectar();
    if ( $d["IdCategoria"] == "0" ) // Nuevo Registro
    {
      
      $sql="insert into tblti_categorias_cupones
      ( nombre,descripcion) values
      ('{$d["txtNombre"]}','{$d["txtDescripcion"]}')";

      @ $r = mysqli_query($nConexion,$sql);

      if(!$r){
        Mensaje( "Fallo almacenando ".mysqli_error($nConexion), "cupones_cat_listar.php" ) ;
        exit;
      }

      mysqli_close($nConexion);
      Mensaje( "El registro ha sido almacenado correctamente.", "cupones_cat_listar.php" ) ;
      exit;
    }
    else // Actualizar Registro Existente
    {
      mysqli_query($nConexion,"begin");

      $sql="select * from tblti_categorias_cupones where idcategoria = {$d["IdCategoria"]} ";
      $ra = mysqli_query($nConexion,$sql);
      $dCat = mysqli_fetch_assoc( $ra );


      $sql="update tblti_categorias_cupones set nombre='{$d["txtNombre"]}',descripcion='{$d["txtDescripcion"]}'
      where idcategoria = {$d["IdCategoria"]}";

      $r = mysqli_query($nConexion,$sql);

      if(!$r){
        mysqli_query($nConexion,"rollback");
        Mensaje( "Fallo actualizando video.".mysqli_error($nConexion), "cupones_cat_listar.php" ) ;
        exit;
      }

      mysqli_query($nConexion,"commit");

      mysqli_close( $nConexion );
      Mensaje( "El registro ha sido actualizado correctamente.", "cupones_cat_listar.php" ) ;
      exit;
    }



  } // FIN: function
  ###############################################################################
?>

<?
  ###############################################################################
  # Descripci�n   : Eliminar un registro
  # Parametros    : $nId
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function CategoriasEliminar( $idCategoria )
  {
    $nConexion = Conectar();
    mysqli_query($nConexion, "DELETE FROM tblti_categorias_cupones WHERE idcategoria = $idCategoria " );

    Log_System( "TIENDA" , "ELIMINA" , "CATEGORIA: " . $idCategoria  );
    mysqli_close( $nConexion );
    Mensaje( "El registro ha sido eliminado correctamente.","cupones_cat_listar.php" );
    exit();
  } // FIN: function
  ###############################################################################
?>

<?
  ###############################################################################
  # Nombre        : ContenidosFormEditar
  # Descripci�n   : Muestra el formulario para editar o eliminar registros
  # Parametros    : $nId = ID de registro que se debe mostrar el en formulario
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function CategoriasFormEditar( $idCategoria )
  {
    include("../../vargenerales.php");
    $nConexion    = Conectar();
    $Resultado    = mysqli_query($nConexion, "SELECT * FROM tblti_categorias_cupones where idcategoria = $idCategoria" ) ;
    $Registro     = mysqli_fetch_array( $Resultado );
    ?>

    <!-- Formulario Edici�n / Eliminaci�n de Contenidos -->
    <form method="post" action="cupones_categorias.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="IdCategoria" name="IdCategoria" value="<? echo $idCategoria ; ?>">
      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>EDITAR CATEGORIA</b></td>
        </tr>
        <tr>
          <td class="tituloNombres">Nombre:</td>
          <td class="contenidoNombres"><INPUT id="txtNombre" type="text" name="txtNombre" value="<? echo $Registro["nombre"]; ?>" maxLength="200" style="width:200px; "></td>
        </tr>
      <tr>
        <td class="tituloNombres">Descripcion:</td>
        <td class="contenidoNombres">
            <textarea id="txtDescripcion" name="txtDescripcion"><? echo $Registro["descripcion"]; ?></textarea>
            <script>
                CKEDITOR.replace( 'txtDescripcion' );
            </script>

        </td>
      </tr>
        <tr>
          <td colspan="2" class="tituloFormulario">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2" class="nuevo">
            <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
            <?
            if ( Perfil() != "3" )
            {
            ?><a href="cupones_categorias.php?Accion=Eliminar&Id=<? echo $idCategoria; ?>"><img src="../../image/eliminar.gif" border="0" alt="Eliminar Registro." onClick="javascript: return confirm('�Esta seguro que desea eliminar este registro?')"></a><?
            }
            ?>
            <a href="cupones_cat_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
          </td>
        </tr>
      </table>
    </form>
    <?
    mysqli_free_result( $Resultado );
  }
  ###############################################################################
  ?>
