<?php

  ###############################################################################

  # diremp_empresas_funciones.php   :  Archivo de funciones modulo Empresas Directorio Empresarial

  # Desarrollo               :  Estilo y Dise�o

  # Web                      :  http://www.esidi.com

  ###############################################################################

?>

<?php

include("../../funciones_generales.php");

?>

<?php

  ###############################################################################

  # Nombre        : dirempEmpresassFormNuevo

  # Descripci�n   : Muestra el formulario para ingreso de empresas nuevas

  # Parametros    : Ninguno.

  # Desarrollado  : Estilo y Dise�o

  # Retorno       : Ninguno

  ###############################################################################

  function dirempEmpresasFormNuevo()

  {

    $nConexion    = Conectar();

    $rCategorias = mysqli_query($nConexion, "SELECT * FROM tbldiremp_categorias order by nombre" ) ;

    $rZonas = mysqli_query($nConexion, "SELECT * FROM tbldiremp_zonas order by nombre" ) ;

    mysqli_close( $nConexion ) ;

  

?>

    <!-- Formulario Ingreso de Eventos -->

    <form method="post" action="diremp_empresas.php?Accion=Guardar" enctype="multipart/form-data">

      <input TYPE="hidden" id="txtId" name="txtId" value="0">

      <table width="100%">

        <tr>

          <td colspan="2" align="center" class="tituloFormulario"><b>NUEVA EMPRESA</b></td>

        </tr>

        <tr>

          <td class="tituloNombres">Empresa:</td>

          <td class="contenidoNombres">

              <INPUT id="nombre" type="text" name="nombre" value="" maxLength="150" style="WIDTH: 300px; HEIGHT: 22px">

          </td>

        </tr>

        <tr>

          <td class="tituloNombres">Sector comercial:</td>

          <td class="contenidoNombres">

              <INPUT id="sector_comercial" type="text" name="sector_comercial" value="" maxLength="150" style="WIDTH: 300px; HEIGHT: 22px">

          </td>

        </tr>

        <tr>

          <td class="tituloNombres">Valor minimo:</td>

          <td class="contenidoNombres">

              <INPUT id="valor_minimo" type="text" name="valor_minimo" value="0" maxLength="150" style="WIDTH: 300px; HEIGHT: 22px">

          </td>

        </tr>

        <tr>

          <td class="tituloNombres">Valor m�ximo:</td>

          <td class="contenidoNombres">

              <INPUT id="valor_maximo" type="text" name="valor_maximo" value="0" maxLength="150" style="WIDTH: 300px; HEIGHT: 22px">

          </td>

        </tr>

        <tr>

          <td class="tituloNombres">Descripci�n:</td>

          <td class="contenidoNombres">

              <?php

                /*$oFCKeditor = new FCKeditor('descripcion') ;

                $oFCKeditor->BasePath = '../../herramientas/FCKeditor/';

                $oFCKeditor->Create() ;

                $oFCKeditor->Width  = '100%' ;

                $oFCKeditor->Height = '100' ;*/

                ?>
            <textarea name="descripcion"></textarea>
            <script>
                CKEDITOR.replace( 'descripcion' );
            </script>

          </td>

        </tr>

        <tr>

          <td class="tituloNombres">Direcci�n:</td>

          <td class="contenidoNombres">

              <INPUT id="direccion" type="text" name="direccion" value="" maxLength="150" style="WIDTH: 300px; HEIGHT: 22px">

          </td>

        </tr>

        <tr>

          <td class="tituloNombres">Tel�fono:</td>

          <td class="contenidoNombres">

              <INPUT id="telefono" type="text" name="telefono" value="" maxLength="150" style="WIDTH: 300px; HEIGHT: 22px">

          </td>

        </tr>

        <tr>

          <td class="tituloNombres">Zona:</td>

          <td class="contenidoNombres">

              <select id="codigo_zona" name="codigo_zona">

                  <?php while ($r = mysqli_fetch_array( $rZonas )):?>

                  <option value="<?=$r["codigo_zona"];?>" ><?=$r["nombre"];?></option>

                  <?php endwhile;?>

              </select>

          </td>

        </tr>

        <tr>

          <td class="tituloNombres">Correo electronico:</td>

          <td class="contenidoNombres">

              <INPUT id="correo_electronico" type="text" name="correo_electronico" value="" maxLength="150" style="WIDTH: 300px; HEIGHT: 22px">

          </td>

        </tr>

        <tr>

          <td class="tituloNombres">URL Web:</td>

          <td class="contenidoNombres">

              <INPUT id="url_web" type="text" name="url_web" value="" maxLength="150" style="WIDTH: 300px; HEIGHT: 22px">

          </td>

        </tr>

        <tr>

          <td class="tituloNombres">Imagen:</td>

          <td class="contenidoNombres">

              <INPUT id="imagen" type="file" name="imagen[]" maxLength="150" style="WIDTH: 300px; HEIGHT: 22px">

          </td>

        </tr>



        <tr>

          <td class="tituloNombres">Categoria:</td>

          <td class="contenidoNombres">

              <select id="codigo_categoria" name="codigo_categoria">

                  <?php while ($r = mysqli_fetch_array( $rCategorias )):?>

		  <option value="<?=$r["codigo_categoria"];?>" ><?=$r["nombre"];?></option>

		  <?php endwhile;?>

              </select>

          </td>

        </tr>

        <tr>

          <td class="tituloNombres">Activa:</td>

          <td class="contenidoNombres">

              <select id="codigo_categoria" name="activo">

		  <option value="1" >Si</option>

                  <option value="0" >No</option>

              </select>

          </td>

        </tr>

        <tr>

          <td colspan="2" class="tituloFormulario">&nbsp;</td>

        </tr>

        <tr>

          <td colspan="2"  class="nuevo">

            <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">

            <a href="diremp_empresas_listar.php">

                <img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar.">

            </a>

          </td>

        </tr>

      </table>

    </form>

<?php

  }

  ###############################################################################

?>



<?php

function dirempGenerarListaCorreos() {

    $sql = "delete from tblboletinescorreos where idlista=1";

    $nConexion = Conectar();

    mysqli_query($nConexion,$sql);





    //Lista de correos para boletines, solo las empresas activas...

    $sql = "select nombre,correo_electronico from tbldiremp_empresas where activo=1";

    $rEmpresas = mysqli_query($nConexion,$sql);

    while ($r = mysqli_fetch_array($rEmpresas)) {

        $sql = "INSERT INTO tblboletinescorreos(correo,nombre,idlista) VALUES('{$r["correo_electronico"]}','{$r["nombre"]}',1)";

        mysqli_query($nConexion,$sql);

    }

    mysqli_close($nConexion);

}

?>

<?php

  ###############################################################################

  # Nombre        : ModhoDeptosGuardar

  # Descripci�n   : Adiciona un nuevo registro o actualiza uno existente

  # Parametros    : $nId , $nombredepto

  # Desarrollado  : Estilo y Dise�o

  # Retorno       : Ninguno

  ###############################################################################

  function dirempEmpresasGuardar( $nId, $nombrempresa,$sector_comercial,$valor_minimo,$valor_maximo,$descripcion,

              $direccion,$telefono,$codigo_zona,$correo_electronico,$url_web,$imagen,$codigo_categoria,$activo,$pendiente_revision )

  {

//	$IdCiudad = $_SESSION["IdCiudad"];

    $nConexion = Conectar();

    if ( $nId <= 0 ) // Nuevo Registro

    {



        $sql = "INSERT INTO tbldiremp_empresas (nombre,sector_comercial,valor_minimo,valor_maximo,descripcion,

              direccion,telefono,codigo_zona,correo_electronico,url_web,imagen,codigo_categoria,activo)

              VALUES ( '{$nombrempresa}','{$sector_comercial}',{$valor_minimo},{$valor_maximo},'{$descripcion}',

              '{$direccion}','{$telefono}',{$codigo_zona},'{$correo_electronico}','{$url_web}','{$imagen}',{$codigo_categoria},{$activo})";

        

      mysqli_query($nConexion,$sql);

      mysqli_close($nConexion);

      dirempGenerarListaCorreos();

      Mensaje( "El registro ha sido almacenado correctamente.", "diremp_empresas_listar.php" ) ;

      exit;

    }

 else // Actualizar Registro Existente

    {

     $imagen = $imagen=="*"?"imagen":"'{$imagen}'";

     $pendiente_revision = $pendiente_revision==""?"":",pendiente_revision={$pendiente_revision} ";

        mysqli_query($nConexion,"UPDATE tbldiremp_empresas SET nombre = '{$nombrempresa}',sector_comercial='{$sector_comercial}',

            valor_minimo={$valor_minimo},valor_maximo={$valor_maximo},descripcion='{$descripcion}',

            direccion='{$direccion}',telefono='{$telefono}',codigo_zona={$codigo_zona},correo_electronico='{$correo_electronico}',

            url_web='{$url_web}',imagen={$imagen},codigo_categoria={$codigo_categoria},activo={$activo}{$pendiente_revision} 

            WHERE codigo_empresa = '{$nId}'");



        mysqli_close($nConexion);

        dirempGenerarListaCorreos();

        Mensaje("El registro ha sido actualizado correctamente.", "diremp_empresas_listar.php");

        exit;

    }

  } // FIN: function 

  ###############################################################################

?>

<?php

function dirempEmpresasNextId(){

    $nConexion    = Conectar();

    $Resultado    = mysqli_query($nConexion, "SELECT max(codigo_empresa)+1 as next FROM tbldiremp_empresas" ) ;

    $Registro     = mysqli_fetch_array( $Resultado );

    mysqli_close( $nConexion ) ;

    return $Registro["next"];

}

?>

<?

  ###############################################################################

  # Nombre        : dirempEmpresasEliminar

  # Descripci�n   : Eliminar un registro 

  # Parametros    : $nId

  # Desarrollado  : Estilo y Dise�o

  # Retorno       : Ninguno

  ###############################################################################

  function dirempEmpresasEliminar( $nId )

  {

    $nConexion = Conectar();

    mysqli_query($nConexion, "DELETE FROM tbldiremp_empresas WHERE codigo_empresa ={$nId}" );

    mysqli_close( $nConexion );

    dirempGenerarListaCorreos();

    Mensaje( "El registro ha sido eliminado correctamente.","diremp_empresas_listar.php" );

    exit();

  } // FIN: function dirempEmpresasGuardar

  ###############################################################################

?>

<?php

  ###############################################################################

  # Nombre        : dirempEmpresasFormEditar

  # Descripci�n   : Muestra el formulario para editar o eliminar registros

  # Parametros    : $nId = ID de registro que se debe mostrar el en formulario

  # Desarrollado  : Estilo y Dise�o

  # Retorno       : Ninguno

  ###############################################################################

  function dirempEmpresasFormEditar( $nId )

  {

	include("../../vargenerales.php");

    $nConexion    = Conectar();

    $Resultado    = mysqli_query($nConexion, "SELECT * FROM tbldiremp_empresas WHERE codigo_empresa = {$nId}" ) ;

    $Registro     = mysqli_fetch_array( $Resultado );

    $rCategorias = mysqli_query($nConexion, "SELECT * FROM tbldiremp_categorias" ) ;

    $rZonas = mysqli_query($nConexion, "SELECT * FROM tbldiremp_zonas" ) ;

    mysqli_close( $nConexion ) ;

?>

    <!-- Formulario Edici�n / Eliminaci�n de Deptos Arrendamientos -->

    <form method="post" action="diremp_empresas.php?Accion=Guardar" enctype="multipart/form-data">

      <input TYPE="hidden" id="txtId" name="txtId" value="<?php echo $nId ; ?>">

      <table width="100%">

        <tr>

          <td colspan="2" align="center" class="tituloFormulario"><b>EDITAR EMPRESA</b></td>

        </tr>

        <tr>

          <td class="tituloNombres">Empresa:</td>

          <td class="contenidoNombres">

              <INPUT id="nombre" type="text" name="nombre" value="<? echo $Registro["nombre"]; ?>" maxLength="150" style="WIDTH: 300px; HEIGHT: 22px">

          </td>

        </tr>

        <tr>

          <td class="tituloNombres">Sector comercial:</td>

          <td class="contenidoNombres">

              <INPUT id="sector_comercial" type="text" name="sector_comercial" value="<? echo $Registro["sector_comercial"]; ?>" maxLength="150" style="WIDTH: 300px; HEIGHT: 22px">

          </td>

        </tr>

        <tr>

          <td class="tituloNombres">Valor minimo:</td>

          <td class="contenidoNombres">

              <INPUT id="valor_minimo" type="text" name="valor_minimo" value="<? echo $Registro["valor_minimo"]; ?>" maxLength="150" style="WIDTH: 300px; HEIGHT: 22px">

          </td>

        </tr>

        <tr>

          <td class="tituloNombres">Valor m�ximo:</td>

          <td class="contenidoNombres">

              <INPUT id="valor_maximo" type="text" name="valor_maximo" value="<? echo $Registro["valor_maximo"]; ?>" maxLength="150" style="WIDTH: 300px; HEIGHT: 22px">

          </td>

        </tr>

        <tr>

          <td class="tituloNombres">Descripci�n:</td>

          <td class="contenidoNombres">

              <?php

                /*$oFCKeditor = new FCKeditor('descripcion') ;

                $oFCKeditor->BasePath = '../../herramientas/FCKeditor/';

                $oFCKeditor->Value = $Registro["descripcion"];

                $oFCKeditor->Create() ;

                $oFCKeditor->Width  = '100%' ;

                $oFCKeditor->Height = '100' ;*/

                ?>
        <textarea name="descripcion"><? echo $Registro["descripcion"]?></textarea>
        <script>
            CKEDITOR.replace( 'descripcion' );
        </script>

          </td>

        </tr>

        <tr>

          <td class="tituloNombres">Direcci�n:</td>

          <td class="contenidoNombres">

              <INPUT id="direccion" type="text" name="direccion" value="<? echo $Registro["direccion"]; ?>" maxLength="150" style="WIDTH: 300px; HEIGHT: 22px">

          </td>

        </tr>

        <tr>

          <td class="tituloNombres">Tel�fono:</td>

          <td class="contenidoNombres">

              <INPUT id="telefono" type="text" name="telefono" value="<? echo $Registro["telefono"]; ?>" maxLength="150" style="WIDTH: 300px; HEIGHT: 22px">

          </td>

        </tr>

        <tr>

          <td class="tituloNombres">Zona:</td>

          <td class="contenidoNombres">

              <select id="codigo_zona" name="codigo_zona">

                  <?php while ($r = mysqli_fetch_array( $rZonas )):?>

                  <option value="<?=$r["codigo_zona"];?>" <?=($r["codigo_zona"]==$Registro["codigo_zona"]?"selected":"");?>><?=$r["nombre"];?></option>

                  <?php endwhile;?>

              </select>

          </td>

        </tr>

        <tr>

          <td class="tituloNombres">Correo electronico:</td>

          <td class="contenidoNombres">

              <INPUT id="correo_electronico" type="text" name="correo_electronico" value="<? echo $Registro["correo_electronico"]; ?>" maxLength="150" style="WIDTH: 300px; HEIGHT: 22px">

          </td>

        </tr>

        <tr>

          <td class="tituloNombres">URL Web:</td>

          <td class="contenidoNombres">

              <INPUT id="url_web" type="text" name="url_web" value="<? echo $Registro["url_web"]; ?>" maxLength="150" style="WIDTH: 300px; HEIGHT: 22px">

          </td>

        </tr>

        <tr>

          <td class="tituloNombres">Imagen:</td>

          <td class="contenidoNombres">

              <INPUT id="imagen" type="file" name="imagen[]" maxLength="150" style="WIDTH: 300px; HEIGHT: 22px">

          </td>

        </tr>

        <tr>

          <td class="tituloNombres">Imagen Actual:</td>

          <td>

          <?php

            if ( empty($Registro["imagen"]) ) {

                echo "No se asigno una imagen.";

            }

            else {

              ?>

              <img src="<?=$cRutaVerImagenDirEmp.$Registro["imagen"]; ?>">

          <?php

            }

          ?>

          </td>

        </tr>

        <tr>

          <td class="tituloNombres">Categoria:</td>

          <td class="contenidoNombres">

              <select id="codigo_categoria" name="codigo_categoria">

                  <?php while ($r = mysqli_fetch_array( $rCategorias )):?>

		  <option value="<?=$r["codigo_categoria"];?>" <?=($r["codigo_categoria"]==$Registro["codigo_categoria"]?"selected":"");?>><?=$r["nombre"];?></option>

		  <?php endwhile;?>

              </select>

          </td>

        </tr>

        <tr>

          <td class="tituloNombres">Activa:</td>

          <td class="contenidoNombres">

              <select id="codigo_categoria" name="activo">

		  <option value="1" <?php echo $Registro["activo"] == 1 ? "selected":"";?>>Si</option>

                  <option value="0" <?php echo $Registro["activo"] == 0 ? "selected":"";?>>No</option>

              </select>

          </td>

        </tr>

        <?php if ( $Registro["pendiente_revision"] == 1 ):?>

        <tr>

          <td class="tituloNombres">Pendiente revisi�n:</td>

          <td class="contenidoNombres">

              <select id="pendiente_revision" name="pendiente_revision">

		  <option value="1" <?php echo $Registro["pendiente_revision"] == 1 ? "selected":"";?>>Si</option>

                  <option value="0" <?php echo $Registro["pendiente_revision"] == 0 ? "selected":"";?>>No</option>

              </select>

          </td>

        </tr>

        <?php endif;?>

        <tr>

          <td colspan="2" class="tituloFormulario">&nbsp;</td>

        </tr>

        <tr>

          <td colspan="2" class="nuevo">

            <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">

            <a href="diremp_empresas.php?Accion=Eliminar&Id=<? echo $nId ;?>">

                <img src="../../image/eliminar.gif" border="0" alt="Eliminar Registro." onClick="javascript: return confirm('�Esta seguro que desea eliminar este registro?')">

            </a>

            <a href="diremp_empresas_listar.php">

                <img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar.">

            </a>

          </td>

        </tr>

      </table>

    </form>

<?php

  mysqli_free_result( $Resultado );

  }

  ###############################################################################

  

  

  function file_get_contents_utf8($fn) {

     $content = file_get_contents($fn);

      return mb_convert_encoding($content, 'UTF-8',

          mb_detect_encoding($content, 'ISO-8859-1, UTF-8', true));

  } 



  function dirempEmpresasProcesarImportacion($file){

      $datos = file_get_contents($_FILES["archivo"]["tmp_name"]);

      

      $rowCount = 0;



      $filas = explode("\n", $datos);

      echo print_r($filas,1)."<br>";

      $nConexion = Conectar();

      foreach ( $filas as $f ) {

          $f = str_getcsv($f,";");

          if( empty ($f) ) continue;

          

          foreach($f as $k=>$v){

              $f[$k] = trim($v);

          }





          $sql = "INSERT INTO tbldiremp_empresas (nombre,sector_comercial,valor_minimo,valor_maximo,descripcion,

                  direccion,telefono,codigo_zona,correo_electronico,url_web,imagen,codigo_categoria,activo)

                  VALUES ( '{$f["0"]}','{$f["1"]}',{$f["2"]},{$f["3"]},'{$f["4"]}',

                  '{$f["5"]}','{$f["6"]}',{$f["7"]},'{$f["8"]}','{$f["9"]}','',{$f["10"]},1)";



          if ( !mysqli_query($nConexion,$sql) ) 

             continue;



          echo "<br/><br/>{$sql}<br/><br/>";

          

          $rowCount++;

      }

      

      mysqli_close($nConexion);

      dirempGenerarListaCorreos();

      

      die("Empresas registradas {$rowCount}");

  }

  

  

  

?>

