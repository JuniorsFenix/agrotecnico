<?
  require_once("../../funciones_generales.php");
  require_once("../../herramientas/FCKeditor/fckeditor.php") ;

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
  function CategoriaFormNuevo() {
  ?>
  <link href="../../css/administrador.css" rel="stylesheet" type="text/css">
  <!-- Formulario Ingreso -->
  <form method="post" action="categorias.php?accion=guardar" enctype="multipart/form-data">
    <input TYPE="hidden" id="idcategoria" name="idcategoria" value="0">
    <table width="100%">
      <tr>
        <td colspan="2" align="center" class="tituloFormulario"><b>NUEVA CATEGORIA</b></td>
      </tr>
      <tr>
        <td class="tituloNombres">Categoria:</td>
        <td class="contenidoNombres">
        <input name="nombre" type="text" id="textfield3" size="40" maxlength="45" />
        </td>
      </tr>
      <tr>
        <td colspan="2" class="tituloFormulario">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" class="nuevo">
          <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
          <a href="listar_categorias.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
        </td>
      </tr>
    </table>
  </form>
  <?
  }
###############################################################################
?>

<?
  function CategoriaGuardar( $d ) {
    
    if ( !isset($d["nombre"]) || $d["nombre"] == "" ) {
      die("Debe ingresar nombre de categoria");
    }
    
    $nConexion = Conectar();
    if ( $d["idcategoria"] == "0" ) {
      $sql = "INSERT INTO tblforo_categorias(nombre) VALUES('{$d["nombre"]}')";
      $ra = mysqli_query($nConexion,$sql);
      if(!$ra){
        die("Fallo insertando categoria del foro");
      }
    }else {
      $sql = "UPDATE tblforo_categorias SET nombre='{$d["nombre"]}' WHERE idcategoria={$d["idcategoria"]}";
      $ra = mysqli_query($nConexion,$sql);
      if(!$ra){
        die("Fallo actualizando categoria del foro");
      }
    }
    header("Location: listar_categorias.php");
    //Mensaje( "Categoria registrada", "listar_categorias.php" ) ;
  }
?>


<?
  function CategoriaFormEditar( $idCategoria ) {
    $nConexion = Conectar();
    $sql = "SELECT * FROM tblforo_categorias WHERE idcategoria={$idCategoria}";
    $ra = mysqli_query($nConexion,$sql);
    $result = mysqli_fetch_assoc($ra);
?>
<link href="../../css/administrador.css" rel="stylesheet" type="text/css">
  <!-- Formulario Ingreso -->
  <form method="post" action="categorias.php?accion=guardar" enctype="multipart/form-data">
    <input TYPE="hidden" id="idcategoria" name="idcategoria" value="<? echo $idCategoria; ?>">
    <table width="100%">
      <tr>
        <td colspan="2" align="center" class="tituloFormulario"><b>NUEVA CATEGORIA</b></td>
      </tr>
      <tr>
        <td class="tituloNombres">Categoria:</td>
        <td class="contenidoNombres">
        <input name="nombre" type="text" id="textfield3" size="40" maxlength="45" value="<?=$result["nombre"];?>" />
        </td>
      </tr>
      <tr>
        <td colspan="2" class="tituloFormulario">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" class="nuevo">
          <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
          <a href="listar_categorias.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
        </td>
      </tr>
    </table>
  </form>
<?
  }
  
  ?>
