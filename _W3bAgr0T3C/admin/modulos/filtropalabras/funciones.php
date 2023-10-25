<?
  ###############################################################################
  # contenidos_funciones.php :  Archivo de funciones modulo
  # Desarrollo               :  Estilo y Dise�o - http://www.esidi.com
  # Web                      :  http://www.informaticactiva.com - Oscar Arley Yepes Aristizabal
  ###############################################################################
  include("../../funciones_generales.php");
?>

<?
  ###############################################################################
  # Descripci�n   : Muestra el formulario para ingreso
  # Parametros    : Ninguno.
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function FiltrosFormNuevo()
  {
  ?>
  <link href="../../css/administrador.css" rel="stylesheet" type="text/css">
  <!-- Formulario Ingreso -->
  <form method="post" action="filtros.php?Accion=Guardar" enctype="multipart/form-data">
    <input TYPE="hidden" id="txtIdFiltro" name="txtIdFiltro" value="0">
    <table width="100%">
      <tr>
        <td colspan="2" align="center" class="tituloFormulario"><b>NUEVAS PALABRAS</b></td>
      </tr>
      <tr>
        <td class="tituloNombres">Palabra:</td>
        <td class="contenidoNombres">
          <textarea id="txtPalabra" name="txtPalabra" style="width:400px;height:200px;"></textarea>
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

<?
  ###############################################################################
  # Descripci�n   : Adiciona un nuevo registro o actualiza uno existente a la DB
  # Parametros    : $nId (Si el Cero Nuevo Registro, de lo contrario Actualizar un Registro)
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function FiltrosGuardar($palabras)
  {

    $nConexion = Conectar();

    @ $r = mysqli_query($nConexion,"DELETE FROM tblfiltropalabras");

    foreach( explode("\n",trim($palabras)) as $palabra){
      @ $r = mysqli_query($nConexion,"INSERT INTO tblfiltropalabras ( palabra) VALUES ( '$palabra')");
      if(!$r){
        Mensaje( "Fallo almacenando filtro.".mysqli_error($nConexion), "listar.php" ) ;
        exit;
      }

    }

    mysqli_close($nConexion);
    Mensaje( "El registro ha sido almacenado correctamente.", "listar.php" ) ;
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
  function FiltrosFormEditar( $idFiltro )
  {
    include("../../vargenerales.php");
    $nConexion    = Conectar();
    $Resultado    = mysqli_query($nConexion, "SELECT * FROM tblfiltropalabras" ) ;
    mysqli_close( $nConexion ) ;

    $palabras = "";
    while( $Registro     = mysqli_fetch_array( $Resultado ) ){
      $palabras.=$Registro["palabra"]."\n";
    }
    ?>

    <!-- Formulario Edici�n / Eliminaci�n de Contenidos -->
    <form method="post" action="filtros.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtIdFiltro" name="txtIdFiltro" value="<? echo $idFiltro ; ?>">
      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>EDITAR FILTRO</b></td>
        </tr>
        <tr>
          <td class="tituloNombres">Palabras:<br/>Una por linea!</td>
          <td class="contenidoNombres">
            <textarea id="txtPalabra" name="txtPalabra" style="width:400px;height:200px;"><?=$palabras?></textarea>
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
    mysqli_free_result( $Resultado );
  }
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
  function DireccionesIpFormEditar( )
  {
    include("../../vargenerales.php");
    $nConexion    = Conectar();
    $Resultado    = mysqli_query($nConexion, "SELECT * FROM tblfiltropalabrasip order by direccionip" ) ;
    mysqli_close( $nConexion ) ;

    $palabras = "";
    while( $Registro     = mysqli_fetch_array( $Resultado ) ){
      $palabras.=$Registro["direccionip"]."\n";
    }
    ?>

    <!-- Formulario Edici�n / Eliminaci�n de Contenidos -->
    <form method="post" action="direccionesip.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtIdFiltro" name="txtIdFiltro" value="<? echo $idFiltro ; ?>">
      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>EDITAR DIRECCIONES IP BLOQUEADAS</b></td>
        </tr>
        <tr>
          <td class="tituloNombres">Palabras:<br/>Una por linea!</td>
          <td class="contenidoNombres">
            <textarea id="txtPalabra" name="txtPalabra" style="width:400px;height:200px;"><?=$palabras?></textarea>
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
    mysqli_free_result( $Resultado );
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
  function DireccionesIpGuardar($palabras)
  {

    $nConexion = Conectar();

    @ $r = mysqli_query($nConexion,"DELETE FROM tblfiltropalabrasip");

    foreach( explode("\n",trim($palabras)) as $palabra){
      @ $r = mysqli_query($nConexion,"INSERT INTO tblfiltropalabrasip ( direccionip,intentos) VALUES ( '$palabra',4)");
      if(!$r){
        Mensaje( "Fallo almacenando direcciones ip.".mysqli_error($nConexion), "direccionesip.php" ) ;
        exit;
      }

    }

    mysqli_close($nConexion);
    Mensaje( "El registro ha sido almacenado correctamente.", "direccionesip.php" ) ;
    exit;

  } // FIN: function
  ###############################################################################
?>
  