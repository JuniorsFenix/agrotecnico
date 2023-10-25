<?
  ###############################################################################
  # contenidos_funciones.php :  Archivo de funciones modulo
  # Desarrollo               :  Estilo y Dise�o - http://www.esidi.com
  # Web                      :  http://www.informaticactiva.com - Oscar Arley Yepes Aristizabal
  ###############################################################################
  require_once("../../funciones_generales.php");
  require_once 'funciones_pedidos.php';

  ini_set("memory_limit","50M");
  ini_set("upload_max_filesize", "30M");
  ini_set("max_execution_time","180");//3 MINUTOS
  ini_set("post_max_size","30M");
?>


<?
  ###############################################################################
  # Descripci�n   : Adiciona un nuevo registro o actualiza uno existente a la DB
  # Parametros    : $nId (Si el Cero Nuevo Registro, de lo contrario Actualizar un Registro)
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function PedidosGuardar( $d )
  {

    $nConexion = Conectar();



    $sql="update tblti_carro set estado='{$d["estado"]}'
    where carro = {$d["IdPedido"]}";


    $r = mysqli_query($nConexion,$sql);

    if(!$r){
      Mensaje( "Fallo actualizando registro.".mysqli_error($nConexion), "listar_pedidos.php" ) ;
      exit;
    }

    mysqli_close( $nConexion );
    Mensaje( "El registro ha sido actualizado correctamente.", "listar_pedidos.php" ) ;
    exit;

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
  function PedidosEliminar( $idPedido )
  {
    $nConexion = Conectar();
    mysqli_query($nConexion, "DELETE FROM tblti_carro WHERE carro = $idPedido " );

    Log_System( "TIENDA" , "ELIMINA" , "PEDIDO: " . $idPedido  );
    mysqli_close( $nConexion );
    Mensaje( "El registro ha sido eliminado correctamente.","listar_pedidos.php" );
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
  function PedidosFormEditar( $idPedido )
  {
    include("../../vargenerales.php");
    $nConexion    = Conectar();
    $Resultado    = mysqli_query($nConexion, "SELECT * FROM tblti_carro where carro = $idPedido" ) ;
    $Registro     = mysqli_fetch_array( $Resultado );
    ?>

    <!-- Formulario Edici�n / Eliminaci�n de Contenidos -->
    <form method="post" action="pedidos.php?Accion=Guardar" enctype="multipart/form-data">
      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>EDITAR PEDIDO</b></td>
        </tr>
        <tr>
          <td class="tituloNombres">Pedido:</td>
          <td class="contenidoNombres">
            <INPUT id="IdPedido" type="text" name="IdPedido" value="<? echo $Registro["carro"]; ?>" maxLength="200" style="width:200px; " readonly>
          </td>
        </tr>
        <tr>
          <td class="tituloNombres">NOmbre:</td>
          <td class="contenidoNombres">
            <INPUT id="nombre" type="text" name="nombre" value="<? echo $Registro["nombre"]; ?>" maxLength="200" style="width:200px; " readonly>
          </td>
        </tr>
        <tr>
          <td class="tituloNombres">Direccion:</td>
          <td class="contenidoNombres">
            <INPUT id="direccion" type="text" name="direccion" value="<? echo $Registro["direccion"]; ?>" maxLength="200" style="width:200px; " readonly>
          </td>
        </tr>
        <tr>
          <td class="tituloNombres">Telefono:</td>
          <td class="contenidoNombres">
            <INPUT id="telefono" type="text" name="telefono" value="<? echo $Registro["telefono"]; ?>" maxLength="200" style="width:200px; " readonly>
          </td>
        </tr>
        <tr>
          <td class="tituloNombres">Ciudad:</td>
          <td class="contenidoNombres">
            <INPUT id="ciudad" type="text" name="ciudad" value="<? echo $Registro["ciudad"]; ?>" maxLength="200" style="width:200px; " readonly>
          </td>
        </tr>

        <tr>
          <td class="tituloNombres">Estado:</td>
          <td class="contenidoNombres">
            <select name="estado">
            <?php foreach( array('CARRO','PENDIENTE','PAGADO','DESPACHADO') as $r):?>
              <option value="<?=$r;?>"  <?=$Registro["estado"] == $r?"selected":"";?> ><?=$r;?></option>
            <?php endforeach;?>
            </select>
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
            ?><a href="pedidos.php?Accion=Eliminar&Id=<? echo $idPedido; ?>"><img src="../../image/eliminar.gif" border="0" alt="Eliminar Registro." onClick="javascript: return confirm('�Esta seguro que desea eliminar este registro?')"></a><?
            }
            ?>
            <a href="listar_pedidos.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
          </td>
        </tr>
      </table>
    </form>
    <?
    mysqli_free_result( $Resultado );
  }
  ###############################################################################
  ?>
