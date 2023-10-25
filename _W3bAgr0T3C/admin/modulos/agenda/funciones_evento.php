<?php
  require_once("../../funciones_generales.php");
  require_once("../../herramientas/FCKeditor/fckeditor.php") ;

  ini_set("memory_limit","50M");
  ini_set("upload_max_filesize", "30M");
  ini_set("max_execution_time","180");//3 MINUTOS
  ini_set("post_max_size","30M");

  function HorariosCargar() {
    $nConexion = Conectar();
    $sql = "SELECT * FROM tblreservacioneshorarios WHERE grupo=1";
    $ra = mysqli_query($nConexion,$sql);
    if ( !$ra ) {
      return null;
    }
    return $ra;
  }

  function TiendasCargar() {
    $nConexion = Conectar();
    $sql = "SELECT * FROM tblti_productos WHERE idproducto in (111,112)";
    $ra = mysqli_query($nConexion,$sql);
    if ( !$ra ) {
      return null;
    }
    //die("fallo tienda");
    return $ra;
  }
  
  function EventoFormNuevo() {
    $horarios = HorariosCargar();
    $salones = TiendasCargar();
  ?>
  <link href="../../css/administrador.css" rel="stylesheet" type="text/css">
  <!-- Formulario Ingreso -->
  <form method="post" action="evento.php?accion=guardar" enctype="multipart/form-data">
    <input TYPE="hidden" id="lista" name="idreservaciones" value="0">
    <table width="100%">
      <tr>
        <td colspan="2" align="center" class="tituloFormulario"><b>NUEVA RESERVACI�N</b></td>
      </tr>
      <tr>
        <td class="tituloNombres">Sal�n:</td>
        <td class="contenidoNombres">
        <select name="idsalon" >
          <?php while ($salon = mysqli_fetch_assoc($salones)): ?>
            <option value="<?=$salon["idproducto"];?>"><?=$salon["nombre"]?></option>
          <?php endwhile;?>
        </select>
        </td>
      </tr>
      <tr>
        <td class="tituloNombres">Fecha:</td>
        <td class="contenidoNombres">
        <input name="fecha" type="text" id="textfield3" size="15" maxlength="45" />
        </td>
      </tr>
      <tr>
        <td class="tituloNombres">Horario:</td>
        <td class="contenidoNombres">
          <select name="idhorario">
        <?php while ($horario = mysqli_fetch_assoc($horarios)): ?>
          <option value="<?=$horario["idhorario"];?>"><?=$horario["descripcion"]?></option>
        <?php endwhile;?>
        </select>
        </td>
      </tr>
      <tr>
        <td class="tituloNombres">Persona reserva:</td>
        <td class="contenidoNombres">
          <input name="persona_reserva" type="text" id="textfield3" size="15" maxlength="45" />
        </td>
      </tr>
      <tr>
        <td colspan="2" class="tituloFormulario">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" class="nuevo">
          <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
          <a href="listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
        </td>
      </tr>
    </table>
  </form>
  <?
  }
###############################################################################
?>

<?php
  function EventoGuardar( $d ) {
    
    if ( !isset($d["fecha"]) || $d["fecha"] == "" ) {
      Mensaje("Debe ingresar fecha","listar.php");
    }
    
    $nConexion = Conectar();
    //die("guardando".print_r($d,1));
    if ( $d["idreservaciones"] == "0" ) {
      $sql = "INSERT INTO tblreservaciones(idsalon,fecha,idhorario,carro,persona_reserva) VALUES({$d["idsalon"]},'{$d["fecha"]}',{$d["idhorario"]},0,'{$d["persona_reserva"]}')";
      $ra = mysqli_query($nConexion,$sql);
      if(!$ra){
        Mensaje("Fallo programando evento ","listar.php" );
      }
    }else {
      $sql = "UPDATE tblreservaciones SET idsalon={$d["idsalon"]},fecha='{$d["fecha"]}',idhorario={$d["idhorario"]},persona_reserva='{$d["persona_reserva"]}' WHERE idreservaciones={$d["idreservaciones"]}";
      $ra = mysqli_query($nConexion,$sql);
      if(!$ra){
        Mensaje("Fallo actualizando evento","listar.php");
      }
    }
    
    header("Location: listar.php");
    return true;
    //Mensaje( "Categoria registrada", "listar_categorias.php" ) ;
  }
?>

