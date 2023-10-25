<?php
  ###############################################################################
  # contenidos_funciones.php :  Archivo de funciones modulo
  # Desarrollo               :  Estilo y Diseño - http://www.esidi.com
  # Web                      :  http://www.informaticactiva.com - Oscar Arley Yepes Aristizabal
  ###############################################################################
  require_once("../../funciones_generales.php");
	include("../../vargenerales.php");
	include("../../herramientas/upload/SimpleImage.php");

  ini_set("memory_limit","50M");
  ini_set("upload_max_filesize", "30M");
  ini_set("max_execution_time","180");//3 MINUTOS
  ini_set("post_max_size","30M");
  

  function ProductosFormNuevo(){
    $nConexion = Conectar();
  ?>
  
  <link href="../../css/administrador.css" rel="stylesheet" type="text/css">
  <!-- Formulario Ingreso -->
  <form method="post" action="cupones.php?Accion=Guardar" enctype="multipart/form-data">
    <table width="100%">
      <tr>
        <td colspan="4" align="center" class="tituloFormulario"><b>NUEVO PRODUCTO</b></td>
      </tr>
      <tr>
        <td class="tituloNombres">Nombre: </td>
        <td class="contenidoNombres" colspan="3"><INPUT type="text" name="nombre" maxLength="200" style="width:200px;" required></td>
      </tr>
      <tr>
        <td class="tituloNombres">Cantidad: </td>
        <td class="contenidoNombres" colspan="3"><INPUT id="txtCantidad" type="number" name="txtCantidad" maxLength="200" style="width:200px; " required></td>
      </tr>
      <tr>
        <td class="tituloNombres">Descuento: </td>
        <td class="contenidoNombres" colspan="3"><INPUT id="txtEfecto" type="number" name="txtEfecto" maxLength="200" style="width:200px; "></td>
      </tr>
      <tr>
        <td class="tituloNombres">Usos: </td>
        <td class="contenidoNombres" colspan="3"><INPUT type="number" name="usos" maxLength="200" style="width:200px;" required></td>
      </tr>
      <tr>
        <td colspan="4" class="tituloFormulario">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" class="nuevo">
          <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
          <a href="cupones_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
        </td>
      </tr>
    </table>
  </form>
  <?
  }
###############################################################################

  function ProductosEliminar($nId) {
    $nConexion = Conectar();
    $reg = mysqli_fetch_object( mysqli_query($nConexion, "SELECT nombre FROM tblti_cupones WHERE id ='$nId'"));
    $sql = "DELETE FROM tblti_cupones WHERE id = $nId";
    $ra = mysqli_query($nConexion, $sql);
    if ( !$ra ) {
      Mensaje("Fallo eliminando cupón {$nId}","tallas_listar.php");
      exit;
    }
    Log_System( "CUPONES" , "ELIMINA" , "CUPÓN: " . $reg->nombre  );
    mysqli_close($nConexion);
    Mensaje( "El registro ha sido eliminado correctamente.","cupones_listar.php" );
    exit();
  }
  ###############################################################################
  # Descripción   : Adiciona un nuevo registro o actualiza uno existente a la DB
  # Parametros    : $nId (Si el Cero Nuevo Registro, de lo contrario Actualizar un Registro)
  # Desarrollado  : Estilo y Diseño & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function ProductosGuardar($d)
  {
    $nConexion = Conectar();
      for($n=1;$n<=$d["txtCantidad"];$n++){
      $sql="INSERT INTO tblti_cupones
      (nombre, efecto, activo, usos) VALUES
      ('{$d["nombre"]}', '{$d["txtEfecto"]}', 1, '{$d["usos"]}')";
  
      @ $r = mysqli_query($nConexion,$sql);
      
      $id = mysqli_insert_id($nConexion);
      $code = $id."F";
      $codelen = 8; // change as needed
      for( $i=strlen($code); $i<$codelen; $i++) {
        $code .= dechex(rand(0,15));
      }
      $sql="UPDATE tblti_cupones SET codigo='{$code}' WHERE id='{$id}'";
      mysqli_query($nConexion,$sql);
      
    }
      if(!$r){
        Mensaje( "Fallo almacenando ".mysqli_error($nConexion), "cupones_listar.php" ) ;
        exit;
      }
    
     mysqli_close($nConexion);
      Mensaje( "El registro ha sido almacenado correctamente.", "cupones_listar.php?idcategoria={$d["IdCategoria"]}" ) ;
      exit;

  } // FIN: function
  ###############################################################################
?>