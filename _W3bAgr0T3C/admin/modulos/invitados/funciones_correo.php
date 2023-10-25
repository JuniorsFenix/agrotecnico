<?php
  require_once("../../funciones_generales.php");
  require_once("../../herramientas/FCKeditor/fckeditor.php") ;

  ini_set("memory_limit","50M");
  ini_set("upload_max_filesize", "30M");
  ini_set("max_execution_time","180");//3 MINUTOS
  ini_set("post_max_size","30M");

  function cargarBoletinesListaCorreo() {
    $nConexion = Conectar();
    $sql="SELECT * FROM tblboletineslistas ORDER BY idlista";
    $ra = mysqli_query($nConexion,$sql);
    
    if(!$ra){
        Mensaje("Fallo consultando listas de correo","registrar_correo.php");
    }
    return $ra;
  }
  
  function CorreoFormNuevo($IdLista) {
    //die($IdLista);
  ?>
  <link href="../../css/administrador.css" rel="stylesheet" type="text/css">
  <!-- Formulario Ingreso -->
  <form method="post" action="correo.php?accion=guardar<?=isset($IdLista)?"&idlista={$IdLista}":"";?>" enctype="multipart/form-data">
    <input TYPE="hidden" id="idcorreo" name="idcorreo" value="0">
    <table width="100%">
      <tr>
        <td colspan="2" align="center" class="tituloFormulario"><b>NUEVO CORREO</b></td>
      </tr>
      <tr>
        <td class="tituloNombres">Correo:</td>
        <td class="contenidoNombres">
        <input name="correo" type="text" id="textfield3" size="40" maxlength="45" />
        </td>
      </tr>
      <tr>
        <td class="tituloNombres">Nombre:</td>
        <td class="contenidoNombres">
        <input name="nombre" type="text" id="textfield3" size="40" maxlength="45" />
        </td>
      </tr>
      <tr>
        <td class="tituloNombres">Lista:</td>
        <td class="contenidoNombres">
        <select name="idlista" id="select2">
          <?php
          $rsBoletinesListas = cargarBoletinesListaCorreo();
          if ( $rsBoletinesListas ) {
            while($r = mysqli_fetch_assoc($rsBoletinesListas)):?> 
              <option value="<?=$r["idlista"];?>" ><?=$r["nombre"];?></option>
            <?php endwhile;
          }?>
        </select>
        </td>
      </tr>
      <tr>
        <td colspan="2" class="tituloFormulario">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" class="nuevo">
          <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
          <a href="registrar_correo.php<?=isset($IdLista)?"?idlista={$IdLista}":"";?>"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
        </td>
      </tr>
    </table>
  </form>
  <?
  }
###############################################################################
?>

<?php
  function CorreoGuardar( $d,$IdLista ) {
    //die("Id list ".$IdLista);
    if ( !isset($d["correo"]) || $d["correo"] == "" ) {
      Mensaje("Debe ingresar correo","registrar_correo.php");
    }
    
    if ( !isset($d["nombre"]) || $d["nombre"] == "" ) {
      Mensaje("Debe ingresar nombre","registrar_correo.php");
    }
    
    $nConexion = Conectar();
    //die("guardando".print_r($d,1));
    if ( $d["idcorreo"] == "0" ) {
      $sql = "INSERT INTO tblboletinescorreos(correo,nombre,idlista) VALUES('{$d["correo"]}','{$d["nombre"]}',{$d["idlista"]})";
      $ra = mysqli_query($nConexion,$sql);
      if(!$ra){
        Mensaje("Fallo insertando correo" . $sql,"registrar_correo.php");
      }
    }else {
      $sql = "UPDATE tblboletinescorreos SET correo='{$d["correo"]}',nombre='{$d["nombre"]}',idlista={$d["idlista"]} WHERE correo='{$d["idcorreo"]}'";
      $ra = mysqli_query($nConexion,$sql);
      if ( !$ra ) {
        Mensaje("Fallo actualizando correo","registrar_correo.php");
      }
    }
    
    header("Location: registrar_correo.php".(isset($IdLista)?"?idlista={$IdLista}":""));
    return true;
    //Mensaje( "Categoria registrada", "listar_categorias.php" ) ;
  }
?>


<?php
function CorreoFormEditar( $correo,$IdLista ) {
    //die($IdLista);
    $nConexion = Conectar();
    $sql = "SELECT * FROM tblboletinescorreos WHERE correo='{$correo}'";
    $ra = mysqli_query($nConexion,$sql);
    $result = mysqli_fetch_assoc($ra);
?>
<link href="../../css/administrador.css" rel="stylesheet" type="text/css">
  <!-- Formulario Ingreso -->
  <form method="post" action="correo.php?accion=guardar<?=isset($IdLista)?"&idlista={$IdLista}":"";?>" enctype="multipart/form-data">
    <input TYPE="hidden" id="idcorreo" name="idcorreo" value="<?=$correo; ?>">
    <table width="100%">
      <tr>
        <td colspan="2" align="center" class="tituloFormulario"><b>Editar Correo</b></td>
      </tr>
      <tr>
        <td class="tituloNombres">Correo:</td>
        <td class="contenidoNombres">
        <input name="correo" type="text" id="textfield3" size="40" maxlength="45" value="<?=$result["correo"];?>" />
        </td>
      </tr>
      <tr>
        <td class="tituloNombres">Nombre:</td>
        <td class="contenidoNombres">
        <input name="nombre" type="text" id="textfield3" size="40" maxlength="45" value="<?=$result["nombre"];?>" />
        </td>
      </tr>
      <tr>
        <td class="tituloNombres">Lista:</td>
        <td class="contenidoNombres">
        <select name="idlista" id="select2">
          <?php
          $rsBoletinesListas = cargarBoletinesListaCorreo();
          if ( $rsBoletinesListas ) {
            while($r = mysqli_fetch_assoc($rsBoletinesListas)):?> 
              <option value="<?=$r["idlista"];?>" <?=$result["idlista"]==$r["idlista"]?"SELECTED":"";?>><?=$r["nombre"];?></option>
            <?php endwhile;
          }?>
        </select>
        </td>
      </tr>
      <tr>
        <td colspan="2" class="tituloFormulario">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" class="nuevo">
          <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
          <a href="registrar_correo.php<?=isset($IdLista)?"?idlista={$IdLista}":"";?>"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
        </td>
      </tr>
    </table>
  </form>
<?
  }
  
  ?>
