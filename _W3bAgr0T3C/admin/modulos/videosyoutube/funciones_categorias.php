<?
  ###############################################################################
  # contenidos_funciones.php :  Archivo de funciones modulo
  # Desarrollo               :  Estilo y Dise�o - http://www.esidi.com
  # Web                      :  http://www.informaticactiva.com - Oscar Arley Yepes Aristizabal
  ###############################################################################
  require_once("../../funciones_generales.php");

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
  function CategoriasFormNuevo()
  {
    $nConexion = Conectar();
  ?>
  <link href="../../css/administrador.css" rel="stylesheet" type="text/css">
  <!-- Formulario Ingreso -->
  <form method="post" action="categorias.php?Accion=Guardar" enctype="multipart/form-data">
    <input TYPE="hidden" id="IdCategoria" name="IdCategoria" value="0">
    <table width="100%">
      <tr>
        <td colspan="2" align="center" class="tituloFormulario"><b>NUEVA CATEGOR�A</b></td>
      </tr>
      <tr>
        <td class="tituloNombres">Categoria Superior:</td>
        <td class="contenidoNombres">
        <select name="IdCategoriaSuperior">
        <?php
        $ra =mysqli_query($nConexion,"select * from tblvideosyoutube_categorias order by vpath");
        while( $rax=mysqli_fetch_object($ra) ){
          ?><option value="<?=$rax->idcategoria;?>"><?=$rax->vpath;?></option><?
        }
        ?>
        </select>
        </td>
      </tr>

      <tr>
        <td class="tituloNombres">Nombre:</td>
        <td class="contenidoNombres"><INPUT id="txtNombre" type="text" name="txtNombre" maxLength="200" style="width:200px; "></td>
      </tr>
      <tr>
        <td class="tituloNombres">Descripcion:</td>
        <td class="contenidoNombres">
          <?php
          /*$oFCKeditor = new FCKeditor('txtDescripcion') ;
          $oFCKeditor->ToolbarSet="MyToolbar";
          $oFCKeditor->BasePath = '../../herramientas/FCKeditor/';
          $oFCKeditor->Width  = '100%' ;
          $oFCKeditor->Height = '200' ;
          $oFCKeditor->Value=$Registro["descripcion"];
          $oFCKeditor->Create() ;*/
          ?>
            <textarea name="txtDescripcion"></textarea>
            <script>
                CKEDITOR.replace( 'txtDescripcion' );
            </script>

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
  ###############################################################################
  # Descripci�n   : Adiciona un nuevo registro o actualiza uno existente a la DB
  # Parametros    : $nId (Si el Cero Nuevo Registro, de lo contrario Actualizar un Registro)
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function CategoriasGuardar( $d )
  {

    $nConexion = Conectar();
    if ( $d["IdCategoria"] == "0" ) // Nuevo Registro
    {
      $sql="select vpath from tblvideosyoutube_categorias where idcategoria = {$d["IdCategoriaSuperior"]} ";
      $ra = mysqli_query($nConexion,$sql);
      $dCat = mysqli_fetch_assoc( $ra );

      $vpath = $dCat["vpath"];
      if( $vpath=="/" ) $vpath="";
      $vpath="{$vpath}/{$d["txtNombre"]}";

      $sql="insert into tblvideosyoutube_categorias
      ( idciudad, nombre,descripcion,vpath,idcategoria_superior) values
      ({$_SESSION["IdCiudad"]},'{$d["txtNombre"]}','{$d["txtDescripcion"]}','{$vpath}',{$d["IdCategoriaSuperior"]})";
      

      @ $r = mysqli_query($nConexion,$sql);

      if(!$r){
        Mensaje( "Fallo almacenando ".mysqli_error($nConexion), "listar_categorias.php" ) ;
        exit;
      }

      mysqli_close($nConexion);
      Mensaje( "El registro ha sido almacenado correctamente.", "listar_categorias.php" ) ;
      exit;
    }
    else // Actualizar Registro Existente
    {
      mysqli_query($nConexion,"begin");
      $sql="select vpath from tblvideosyoutube_categorias where idcategoria = {$d["IdCategoriaSuperior"]} ";
      $ra = mysqli_query($nConexion,$sql);
      $dCat = mysqli_fetch_assoc( $ra );

      $vpath = $dCat["vpath"];
      if( $vpath=="/" ) $vpath="";
      $vpath="{$vpath}/{$d["txtNombre"]}";

      $sql="select * from tblvideosyoutube_categorias where idcategoria = {$d["IdCategoria"]} ";
      $ra = mysqli_query($nConexion,$sql);
      $dCat = mysqli_fetch_assoc( $ra );

      $sql="update tblvideosyoutube_categorias set vpath=replace(vpath,'{$dCat["vpath"]}','{$vpath}')
      where idcategoria_superior = {$d["IdCategoria"]}";

      $ra = mysqli_query($nConexion,$sql);
      if( !$ra){
        mysqli_query($nConexion,"rollback");
        Mensaje("Fallo actualizando categorias hijas");
        exit;
      }


      $sql="update tblvideosyoutube_categorias set idciudad={$_SESSION["IdCiudad"]},
      nombre='{$d["txtNombre"]}',descripcion='{$d["txtDescripcion"]}',vpath='{$vpath}',idcategoria_superior={$d["IdCategoriaSuperior"]}
      where idcategoria = {$d["IdCategoria"]}";

      $r = mysqli_query($nConexion,$sql);

      if(!$r){
        mysqli_query($nConexion,"rollback");
        Mensaje( "Fallo actualizando video.".mysqli_error($nConexion), "listar_categorias.php" ) ;
        exit;
      }

      mysqli_query($nConexion,"commit");

      mysqli_close( $nConexion );
      Mensaje( "El registro ha sido actualizado correctamente.", "listar_categorias.php" ) ;
      exit;
    }



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
  function CategoriasEliminar( $idCategoria )
  {
    $nConexion = Conectar();

    


    mysqli_query($nConexion, "DELETE FROM tblvideosyoutube_categorias WHERE idcategoria = $idCategoria " );

    Log_System( "TIENDA" , "ELIMINA" , "CATEGORIA: " . $idCategoria  );
    mysqli_close( $nConexion );
    Mensaje( "El registro ha sido eliminado correctamente.","listar_categorias.php" );
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
  function CategoriasFormEditar( $idCategoria )
  {
    include("../../vargenerales.php");
    $nConexion    = Conectar();
    $Resultado    = mysqli_query($nConexion, "SELECT * FROM tblvideosyoutube_categorias where idcategoria = $idCategoria" ) ;
    $Registro     = mysqli_fetch_array( $Resultado );
    ?>

    <!-- Formulario Edici�n / Eliminaci�n de Contenidos -->
    <form method="post" action="categorias.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="IdCategoria" name="IdCategoria" value="<? echo $idCategoria ; ?>">
      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>EDITAR CATEGORIA</b></td>
        </tr>
      <tr>
        <td class="tituloNombres">Categoria Superior:</td>
        <td class="contenidoNombres">
        <select name="IdCategoriaSuperior">
        <?php
        $ra =mysqli_query($nConexion,"select * from tblvideosyoutube_categorias  where idcategoria<>{$idCategoria} order by vpath");
        while( $rax=mysqli_fetch_object($ra) ){
          ?><option value="<?=$rax->idcategoria;?>" <?=$rax->idcategoria==$Registro["idcategoria_superior"]?"selected":"";?> ><?=$rax->vpath;?></option><?
        }
        ?>
        </select>
        </td>
      </tr>

        <tr>
          <td class="tituloNombres">Nombre:</td>
          <td class="contenidoNombres"><INPUT id="txtNombre" type="text" name="txtNombre" value="<? echo $Registro["nombre"]; ?>" maxLength="200" style="width:200px; "></td>
        </tr>
      <tr>
        <td class="tituloNombres">Descripcion:</td>
        <td class="contenidoNombres">
          <?php
          /*$oFCKeditor = new FCKeditor('txtDescripcion') ;
          $oFCKeditor->ToolbarSet="MyToolbar";
          $oFCKeditor->BasePath = '../../herramientas/FCKeditor/';
          $oFCKeditor->Width  = '100%' ;
          $oFCKeditor->Height = '200' ;
          $oFCKeditor->Value=$Registro["descripcion"];
          $oFCKeditor->Create() ;*/
          ?>
            <textarea name="txtDescripcion"><? echo $Registro["descripcion"]?></textarea>
            <script>
                CKEDITOR.replace( 'txtDescripcion' );
            </script>

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
            ?><a href="categorias.php?Accion=Eliminar&Id=<? echo $idCategoria; ?>"><img src="../../image/eliminar.gif" border="0" alt="Eliminar Registro." onClick="javascript: return confirm('�Esta seguro que desea eliminar este registro?')"></a><?
            }
            ?>
            <a href="listar_categorias.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
          </td>
        </tr>
      </table>
    </form>
    <?
    mysqli_free_result( $Resultado );
  }
  ###############################################################################
  ?>
