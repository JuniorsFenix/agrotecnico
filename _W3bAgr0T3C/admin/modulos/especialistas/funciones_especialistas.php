<?php
  require_once("../../funciones_generales.php");
  require_once("../../herramientas/FCKeditor/fckeditor.php") ;

  ini_set("memory_limit","50M");
  ini_set("upload_max_filesize", "30M");
  ini_set("max_execution_time","180");//3 MINUTOS
  ini_set("post_max_size","30M");
  
  function especialistasConsultarProfesion() {
    $nConexion = Conectar();
    $sql = "SELECT * FROM tblconsultoria_profesiones";
    $ra = mysqli_query($nConexion,$sql);
    if ( !$ra ) {
      Mensaje("Error consultando profesiones","listar_especialistas.php");
    }
    return $ra;
  }
  
?>

<?php
  function EspecialistaFormNuevo() {
  ?>
  <link href="../../css/administrador.css" rel="stylesheet" type="text/css">
  <!-- Formulario Ingreso -->
  <form method="post" action="especialistas.php?accion=guardar" enctype="multipart/form-data">
    <input TYPE="hidden" id="idprofesional" name="idprofesional" value="0">
    <table width="100%">
      <tr>
        <td colspan="2" align="center" class="tituloFormulario"><b>NUEVO ESPECIALISTA</b></td>
      </tr>
      <tr>
        <td class="tituloNombres">Nombre:</td>
        <td class="contenidoNombres">
        <input name="nombre" type="text" id="textfield3" size="40" maxlength="45" />
        </td>
      </tr>
      <tr>
        <td class="tituloNombres">Profesión:</td>
        <td class="contenidoNombres">
        <select name="idprofesion">
          <?php $rcProfesion = especialistasConsultarProfesion();
          while ($r = mysqli_fetch_assoc($rcProfesion)):?>
            <option value="<?=$r["idprofesion"];?>"><?=$r["profesion"];?></option>
          <?php endwhile;?>
        
        </select>
        </td>
      </tr>
      <tr>
        <td class="tituloNombres">Correo:</td>
        <td class="contenidoNombres">
        <input name="correo_electronico" type="text" id="textfield3" size="40" maxlength="45" value="<?=$result["correo_electronico"];?>" />
        </td>
      </tr>
      <tr>
        <td colspan="2" class="tituloFormulario">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" class="nuevo">
          <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
          <a href="listar_especialistas.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
        </td>
      </tr>
    </table>
  </form>
  <?php
  }
###############################################################################
?>

<?php
  function EspecialistaGuardar( $d ) {
    
    if ( !isset($d["nombre"]) || $d["nombre"] == "" ) {
      Mensaje("Debe ingresar nombre de especialista","listar_especialistas.php");
    }
    
    if ( !isset($d["correo_electronico"]) || $d["correo_electronico"] == "" ) {
      Mensaje("Debe ingresar correo electronico del especialista","listar_especialistas.php");
    }
    
    $nConexion = Conectar();
    if ( $d["idprofesional"] == "0" ) {
      $sql = "update tblconsultoria_profesionales set ultima_consulta=0 where idprofesion={$d["idprofesion"]}";
      mysqli_query($nConexion,$sql);
      $sql = "INSERT INTO tblconsultoria_profesionales(nombre,correo_electronico,idprofesion)
              VALUES('{$d["nombre"]}','{$d["correo_electronico"]}',{$d["idprofesion"]})";
      $ra = mysqli_query($nConexion,$sql);
      if ( !$ra ) {
        Mensaje("Fallo insertando especialista","listar_especialistas.php");
      }
    }else {
      $sql = "UPDATE tblconsultoria_profesionales SET nombre='{$d["nombre"]}',correo_electronico='{$d["correo_electronico"]}',idprofesion={$d["idprofesion"]} WHERE idprofesional={$d["idprofesional"]}";
      $ra = mysqli_query($nConexion,$sql);
      if ( !$ra ) {
        Mensaje("Fallo actualizando especialista","listar_especialistas.php");
      }
    }
    header("Location: listar_especialistas.php");
    //Mensaje( "Categoria registrada", "listar_categorias.php" ) ;
  }
?>


<?php
  function EspecialistaFormEditar( $idProfesional ) {
    $nConexion = Conectar();
    $sql = "SELECT * FROM tblconsultoria_profesionales WHERE idprofesional={$idProfesional}";
    $ra = mysqli_query($nConexion,$sql);
    $result = mysqli_fetch_assoc($ra);
?>
<link href="../../css/administrador.css" rel="stylesheet" type="text/css">
  <!-- Formulario Ingreso -->
  <form method="post" action="especialistas.php?accion=guardar" enctype="multipart/form-data">
    <input TYPE="hidden" id="idprofesional" name="idprofesional" value="<? echo $idProfesional; ?>">
    <table width="100%">
      <tr>
        <td colspan="2" align="center" class="tituloFormulario"><b>NUEVO ESPECIALISTA</b></td>
      </tr>
      <tr>
        <td class="tituloNombres">Nombre:</td>
        <td class="contenidoNombres">
        <input name="nombre" type="text" id="textfield3" size="40" maxlength="45" value="<?=$result["nombre"];?>" />
        </td>
      </tr>
      <tr>
        <td class="tituloNombres">Profesión:</td>
        <td class="contenidoNombres">
        <select name="idprofesion">
          <?php $rcProfesion = especialistasConsultarProfesion();
          while ($r = mysqli_fetch_assoc($rcProfesion)):?>
            <option value="<?=$r["idprofesion"];?>" <?=$result["idprofesion"]==$r["idprofesion"]?"SELECTED":"";?>><?=$r["profesion"];?></option>
          <?php endwhile;?>
        
        </select>
        </td>
      </tr>
      <tr>
        <td class="tituloNombres">Correo:</td>
        <td class="contenidoNombres">
        <input name="correo_electronico" type="text" id="textfield3" size="40" maxlength="45" value="<?=$result["correo_electronico"];?>" />
        </td>
      </tr>
      <tr>
        <td colspan="2" class="tituloFormulario">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" class="nuevo">
          <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
          <a href="listar_especialistas.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
        </td>
      </tr>
    </table>
  </form>
<?php
  }
?>
