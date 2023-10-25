<?
  ###############################################################################
  # contenidos_funciones.php :  Archivo de funciones modulo
  # Desarrollo               :  Estilo y Dise�o - http://www.esidi.com
  # Web                      :  http://www.informaticactiva.com - Oscar Arley Yepes Aristizabal
  ###############################################################################
  require_once("../../funciones_generales.php");
  require_once 'funciones_productos.php';

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
  function ConfiguracionGuardar( $d )
  {

    $nConexion = Conectar();

    mysqli_query($nConexion,"begin");

    $sql="delete from tblti_config";
    $r = mysqli_query($nConexion,$sql);

    $sql="insert into tblti_config (encabezado,pie,destinos,paypal_email,po_usuario,po_clave) values
    ('{$d["txtEncabezado"]}','{$d["txtPie"]}','{$d["txtDestinos"]}','{$d["txtPaypalEmail"]}','{$d["txtPoUsuario"]}','{$d["txtPoClave"]}')";
    $r = mysqli_query($nConexion,$sql);

    if(!$r){
      mysqli_query($nConexion,"rollback");
      Mensaje( "Fallo actualizando .".mysqli_error($nConexion), "configurar.php" ) ;
      exit;
    }

    mysqli_query($nConexion,"commit");

    mysqli_close( $nConexion );
    Mensaje( "El registro ha sido actualizado correctamente.", "configurar.php" ) ;
    exit;



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
  function ConfiguracionFormEditar( )
  {
    include("../../vargenerales.php");
    $nConexion    = Conectar();
    $Resultado    = mysqli_query($nConexion, "SELECT * FROM tblti_config" ) ;
    $Registro     = mysqli_fetch_array( $Resultado );
    ?>

    <!-- Formulario Edici�n / Eliminaci�n de Contenidos -->
    <form method="post" action="configurar.php?Accion=Guardar" enctype="multipart/form-data">
      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>EDITAR CONFIGURACI�N</b></td>
        </tr>
      <tr>
        <td class="tituloNombres">Encabezado de factura:</td>
        <td class="contenidoNombres">
          <?php
          $oFCKeditor = new FCKeditor('txtEncabezado') ;
          //$oFCKeditor->ToolbarSet="MyToolbar";
          $oFCKeditor->BasePath = '../../herramientas/FCKeditor/';
          $oFCKeditor->Width  = '100%' ;
          $oFCKeditor->Height = '200' ;
          $oFCKeditor->Value=$Registro["encabezado"];
          $oFCKeditor->Create() ;
          ?>

        </td>
      </tr>
      <tr>
        <td class="tituloNombres">Pie de factura:</td>
        <td class="contenidoNombres">
          <?php
          $oFCKeditor = new FCKeditor('txtPie') ;
          //$oFCKeditor->ToolbarSet="MyToolbar";
          $oFCKeditor->BasePath = '../../herramientas/FCKeditor/';
          $oFCKeditor->Width  = '100%' ;
          $oFCKeditor->Height = '200' ;
          $oFCKeditor->Value=$Registro["pie"];
          $oFCKeditor->Create() ;
          ?>

        </td>
      </tr>

      <tr>
        <td class="tituloNombres">Paypal email:</td>
        <td class="contenidoNombres">
        <input type="text" name="txtPaypalEmail" value="<?=$Registro["paypal_email"];?>" size="100">
        </td>
      </tr>

      <tr>
        <td class="tituloNombres">PagosOnline usuario Id:</td>
        <td class="contenidoNombres">
        <input type="text" name="txtPoUsuario" value="<?=$Registro["po_usuario"];?>" size="100">
        </td>
      </tr>

      <tr>
        <td class="tituloNombres">PagosOnline llave:</td>
        <td class="contenidoNombres">
        <input type="text" name="txtPoClave" value="<?=$Registro["po_clave"];?>" size="100">
        </td>
      </tr>


      <tr>
        <td class="tituloNombres">Tarifas de destinos:</td>
        <td class="contenidoNombres">
        Codigo Pais;Nombre Pais;Codigo Estado;Nombre Estado;Codigo Ciudad;Nombre Ciudad;Valor base;Valor kilo
        <textarea name="txtDestinos" rows="20" cols="100" wrap="off"><?=$Registro["destinos"];?></textarea>


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
            ?><?
            }
            ?>
          </td>
        </tr>
      </table>
    </form>
    <?
    mysqli_free_result( $Resultado );
  }
  ###############################################################################
  ?>
