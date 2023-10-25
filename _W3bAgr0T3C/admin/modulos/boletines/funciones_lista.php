<?php
  require_once("../../funciones_generales.php");
  require_once("../../herramientas/FCKeditor/fckeditor.php") ;

  ini_set("memory_limit","50M");
  ini_set("upload_max_filesize", "30M");
  ini_set("max_execution_time","180");//3 MINUTOS
  ini_set("post_max_size","30M");

  
  function ListaFormNuevo() {
  ?>
  <link href="../../css/administrador.css" rel="stylesheet" type="text/css">
  <!-- Formulario Ingreso -->
  <form method="post" action="lista.php?accion=guardar" enctype="multipart/form-data">
    <input TYPE="hidden" id="lista" name="idlista" value="0">
    <table width="100%">
      <tr>
        <td colspan="2" align="center" class="tituloFormulario"><b>NUEVA LISTA</b></td>
      </tr>
      <tr>
        <td class="tituloNombres">Nombre:</td>
        <td class="contenidoNombres">
        <input name="nombre" type="text" id="textfield3" size="40" maxlength="45" />
        </td>
      </tr>
      </tr>
      <tr>
        <td colspan="2" class="tituloFormulario">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" class="nuevo">
          <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
          <a href="registrar_lista.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
        </td>
      </tr>
    </table>
  </form>
  <?
  }
###############################################################################
?>

<?php
  function ListaGuardar( $d ) {
    
    if ( !isset($d["nombre"]) || $d["nombre"] == "" ) {
      die("Debe ingresar nombre");
    }
    
    $nConexion = Conectar();
    //die("guardando".print_r($d,1));
    if ( $d["idlista"] == "0" ) {
      $sql = "INSERT INTO tblboletineslistas(nombre) VALUES('{$d["nombre"]}')";
      $ra = mysqli_query($nConexion,$sql);
      if(!$ra){
        die("Fallo insertando lista " . $sql);
      }
    }else {
      $sql = "UPDATE tblboletineslistas SET nombre='{$d["nombre"]}' WHERE idlista={$d["idlista"]}";
      $ra = mysqli_query($nConexion,$sql);
      if(!$ra){
        die("Fallo actualizando lista");
      }
    }
    
    header("Location: registrar_lista.php");
    return true;
    //Mensaje( "Categoria registrada", "listar_categorias.php" ) ;
  }
?>


<?
function ListaFormEditar( $idLista ) {
    $nConexion = Conectar();
    $sql = "SELECT * FROM tblboletineslistas WHERE idlista={$idLista}";
    $ra = mysqli_query($nConexion,$sql);
    $result = mysqli_fetch_assoc($ra);
?>
<link href="../../css/administrador.css" rel="stylesheet" type="text/css">
  <!-- Formulario Ingreso -->
  <form method="post" action="lista.php?accion=guardar" enctype="multipart/form-data">
    <input TYPE="hidden" id="idlista" name="idlista" value="<? echo $idLista; ?>">
    <table width="100%">
      <tr>
        <td colspan="2" align="center" class="tituloFormulario"><b>NUEVA LISTA</b></td>
      </tr>
      <tr>
        <td class="tituloNombres">Nombre:</td>
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
          <a href="registrar_lista.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
        </td>
      </tr>
    </table>
  </form>
<?php
}
?>
<?php
  function ListaFormImportar( $idLista ) {
    $nConexion = Conectar();
    $sql = "SELECT * FROM tblboletineslistas";
    $ra = mysqli_query($nConexion,$sql);
    if ( !$ra ) {
      die("Error cargando listas para importar");
    }
?>
<link href="../../css/administrador.css" rel="stylesheet" type="text/css">
  <!-- Formulario Ingreso -->
  <form method="post" action="lista.php?accion=importar" enctype="multipart/form-data">
    <table width="100%">
      <tr>
        <td colspan="2" align="center" class="tituloFormulario"><b>IMPORTAR CORREOS</b></td>
      </tr>
      <tr>
        <td colspan="2" ><b>Estructura archivo:   nombre,correo</b></td>
      </tr>
      <tr>
        <td class="tituloNombres">Lista:</td>
        <td class="contenidoNombres">
        
        <select name="idlista" >
          <?php while ($r = mysqli_fetch_assoc($ra)): ?>
            <option value="<?=$r["idlista"];?>"><?=$r["nombre"];?></option>
          <?php endwhile; ?>
        </select>
        </td>
      </tr>
      <tr>
        <td>
          <input type="checkbox" id="borrarlista" name="borrarlista" />
        </td>
        <td class="tituloNombres">Eliminar lista de correo existente</td>
      </tr>
      <tr>
          <td class="tituloNombres">Archivo:</td>
          <td><input type="file" id="listacorreos" name="listacorreos"></td>
      </tr>
      <tr>
        <td colspan="2" class="tituloFormulario">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" class="nuevo">
          <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
          <a href="registrar_lista.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
        </td>
      </tr>
    </table>
  </form>
<?php
return true;
}
?>