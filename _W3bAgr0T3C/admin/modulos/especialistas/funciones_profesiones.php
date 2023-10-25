<?php
  require_once("../../funciones_generales.php");
  require_once("../../herramientas/FCKeditor/fckeditor.php") ;

  ini_set("memory_limit","50M");
  ini_set("upload_max_filesize", "30M");
  ini_set("max_execution_time","180");//3 MINUTOS
  ini_set("post_max_size","30M");
?>

<?php
  function ProfesionFormNuevo() {
  ?>
  <link href="../../css/administrador.css" rel="stylesheet" type="text/css">
  <!-- Formulario Ingreso -->
  <form method="post" action="profesiones.php?accion=guardar" enctype="multipart/form-data">
    <input TYPE="hidden" id="idprofesion" name="idprofesion" value="0">
    <table width="100%">
      <tr>
        <td colspan="2" align="center" class="tituloFormulario"><b>NUEVA PROFESI�N</b></td>
      </tr>
      <tr>
        <td class="tituloNombres">Profesi�n:</td>
        <td class="contenidoNombres">
        <input name="profesion" type="text" id="textfield3" size="40" maxlength="45" />
        </td>
      </tr>
      <tr>
        <td colspan="2" class="tituloFormulario">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" class="nuevo">
          <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
          <a href="listar_profesiones.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
        </td>
      </tr>
    </table>
  </form>
  <?php
  }
###############################################################################
?>

<?php
  function ProfesionGuardar( $d ) {
    
    if ( !isset($d["profesion"]) || $d["profesion"] == "" ) {
      Mensaje("Debe ingresar nombre de profesi�n","listar_profesiones.php");
    }
    
    $nConexion = Conectar();
    if ( $d["idprofesion"] == "0" ) {
      $sql = "INSERT INTO tblconsultoria_profesiones(profesion) VALUES('{$d["profesion"]}')";
      $ra = mysqli_query($nConexion,$sql);
      if ( !$ra ) {
        Mensaje("Fallo insertando profesi�n","listar_profesiones.php");
      }
    }else {
      $sql = "UPDATE tblconsultoria_profesiones SET profesion='{$d["profesion"]}' WHERE idprofesion={$d["idprofesion"]}";
      $ra = mysqli_query($nConexion,$sql);
      if ( !$ra ) {
        Mensaje("Fallo actualizando profesi�n","listar_profesiones.php");
      }
    }
    header("Location: listar_profesiones.php");
    //Mensaje( "Categoria registrada", "listar_categorias.php" ) ;
  }
?>


<?php
  function ProfesionFormEditar( $idProfesion ) {
    $nConexion = Conectar();
    $sql = "SELECT * FROM tblconsultoria_profesiones WHERE idprofesion={$idProfesion}";
    $ra = mysqli_query($nConexion,$sql);
    $result = mysqli_fetch_assoc($ra);
?>
<link href="../../css/administrador.css" rel="stylesheet" type="text/css">
  <!-- Formulario Ingreso -->
  <form method="post" action="profesiones.php?accion=guardar" enctype="multipart/form-data">
    <input TYPE="hidden" id="idprofesion" name="idprofesion" value="<? echo $idProfesion; ?>">
    <table width="100%">
      <tr>
        <td colspan="2" align="center" class="tituloFormulario"><b>NUEVA PROFESI�N</b></td>
      </tr>
      <tr>
        <td class="tituloNombres">Profesi�n:</td>
        <td class="contenidoNombres">
        <input name="profesion" type="text" id="textfield3" size="40" maxlength="45" value="<?=$result["profesion"];?>" />
        </td>
      </tr>
      <tr>
        <td colspan="2" class="tituloFormulario">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" class="nuevo">
          <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
          <a href="listar_profesiones.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
        </td>
      </tr>
    </table>
  </form>
<?php
  }
?>
