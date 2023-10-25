<?
  ###############################################################################

  # empsemana_funciones.php  :  Archivo de funciones modulo noticias

  # Desarrollo               :  Estilo y Dise�o

  # Web                      :  http://www.esidi.com

  # 

  ###############################################################################

?>
<? include("../../funciones_generales.php"); ?>
<?
  ###############################################################################

  # Nombre        : EmpsemanaFormNuevo

  # Descripci�n   : Muestra el formulario para ingreso de productos nuevos

  # Parametros    : Ninguno.

  # Desarrollado  : Estilo y Dise�o & Informaticactiva

  # Retorno       : Ninguno

  ###############################################################################

  function EmpsemanaFormNuevo()

  {

?>
    <!-- Formulario Ingreso de Noticias -->
    <form method="post" action="empsemana.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="0">
      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>NUEVO TESTIMONIO</b></td>
        </tr>
        <tr>
          <td class="tituloNombres">Nombre:</td>
          <td class="contenidoNombres"><INPUT id="txtEmpresa" type="text" name="txtEmpresa" maxLength="100" style="WIDTH: 300px; HEIGHT: 22px"></td>
        </tr>
        <tr>
          <td colspan="2" class="tituloNombres">Descripcion:</td>
          <!--<td class="contenidoNombres"><textarea rows="20" id="txtNoticia" name="txtNoticia" cols="80"></textarea></td>-->
        </tr>
			</table>
            <textarea name="txtDescripcion"></textarea>                
			<script>                    
			CKEDITOR.replace( 'txtDescripcion' );
            </script>
			<table width="100%">
        <tr>
          <td class="tituloNombres">Imagen:</td>
          <td class="contenidoNombres"><input type="file" id="txtImagen[]" name="txtImagen[]"></td>
        </tr>
        <tr>
          <td class="tituloNombres">Tags:</td>
          <td class="contenidoNombres"><INPUT id="txtFuente" type="text" name="txtFuente" maxLength="255" style="WIDTH: 300px; HEIGHT: 22px"></td>
        </tr>
			<?
			if ( Perfil() == "3" )

			{

			?><input type="hidden" name="optPublicar" id="optPublicar" value="N"><?
			}

			else

			{

			?>
			<tr>
				<td class="tituloNombres">Publicar:</td>
				<td class="contenidoNombres">
					<table border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td><label><input type="radio" id="optPublicar" name="optPublicar" value="S">Si</label></td>
							<td width="10"></td>
							<td><label><input type="radio" id="optPublicar" name="optPublicar" value="N" checked>No</label></td>
						</tr>
					</table>
			  </td>
			</tr>
			<?
			}

			?>
        <tr>
          <td colspan="2" class="tituloFormulario">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2"  class="nuevo">
            <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
            <a href="empsemana_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
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

  # Nombre        : EmpsemanaGuardar

  # Descripci�n   : Adiciona un nuevo registro o actualiza uno existente

  # Parametros    : $nId (Si el Cero Nuevo Registro, de lo contrario Actualizar un Registro)

  #                 $nIdC, $cEmpresa, $cDescripcion, $cFuente, $cImagen, $cPublicar

  # Desarrollado  : Estilo y Dise�o 

  # Retorno       : Ninguno

  ###############################################################################

  function EmpsemanaGuardar( $nId,$cEmpresa,$cDescripcion,$cFuente,$cImagen,$cPublicar )

  {

		$IdCiudad = $_SESSION["IdCiudad"];

    $nConexion = Conectar();

    if ( $nId <= 0 ) // Nuevo Registro

    {

      mysqli_query($nConexion,"INSERT INTO tblempsemana ( empresa,descripcion,imagen,fuente,fechapub,publicar,idciudad ) VALUES ( '$cEmpresa','$cDescripcion','$cImagen','$cFuente',Now(),'$cPublicar',$IdCiudad )");

			Log_System( "EMPRESASEMANA" , "NUEVO" , "EMPRESA: " . $cEmpresa );

      mysqli_close($nConexion);

      Mensaje( "El registro ha sido almacenado correctamente.", "empsemana_listar.php" ) ;

      exit;

    }

    else // Actualizar Registro Existente

    {

      if ( !empty($cImagen) )

      {

        mysqli_query($nConexion, "UPDATE tblempsemana SET empresa = '$cEmpresa',descripcion = '$cDescripcion',imagen = '$cImagen',fuente = '$cFuente',publicar='$cPublicar' WHERE idempsemana = '$nId'" );

      }

      else

      {

        mysqli_query($nConexion, "UPDATE tblempsemana SET empresa = '$cEmpresa',descripcion = '$cDescripcion',fuente = '$cFuente',publicar='$cPublicar' WHERE idempsemana = '$nId'" );

      }

			Log_System( "EMPRESASEMANA" , "EDITA" , "EMPRESA: " . $cEmpresa );

      mysqli_close( $nConexion );

      Mensaje( "El registro ha sido actualizado correctamente.", "empsemana_listar.php" ) ;

      exit;

    }

  } // FIN: function 

  ###############################################################################

?>
<?
  ###############################################################################

  # Nombre        : EmpsemanaEliminar

  # Descripci�n   : Eliminar un registro 

  # Parametros    : $nId

  # Desarrollado  : Estilo y Dise�o

  # Retorno       : Ninguno

  ###############################################################################

  function EmpsemanaEliminar( $nId )

  {

    $nConexion = Conectar();

		$reg = mysqli_fetch_object( mysqli_query($nConexion,"SELECT empresa FROM tblempsemana WHERE idempsemana ='$nId'") );

    mysqli_query($nConexion, "DELETE FROM tblempsemana WHERE idempsemana ='$nId'" );

		Log_System( "EMPRESASEMANA" , "ELIMINA" , "EMPRESA: " . $reg->empresa  );

    mysqli_close( $nConexion );

    Mensaje( "El registro ha sido eliminado correctamente.","empsemana_listar.php" );

    exit();

  } // FIN: function UsuariosGuardar

  ###############################################################################

?>
<?
  ###############################################################################

  # Nombre        : EmpsemanaFormEditar

  # Descripci�n   : Muestra el formulario para editar o eliminar registros

  # Parametros    : $nId = ID de registro que se debe mostrar el en formulario

  # Desarrollado  : Estilo y Dise�o

  # Retorno       : Ninguno

  ###############################################################################

  function EmpsemanaFormEditar( $nId )

  {

		include("../../vargenerales.php");

    $nConexion    = Conectar();

    $Resultado    = mysqli_query($nConexion, "SELECT * FROM tblempsemana WHERE idempsemana = '$nId'" ) ;

    mysqli_close( $nConexion ) ;



    $Registro     = mysqli_fetch_array( $Resultado );

?>
    <!-- Formulario Edici�n / Eliminaci�n de Noticias -->
    <form method="post" action="empsemana.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="<? echo $nId ; ?>">
      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>EDITAR TESTIMONIO</b></td>
        </tr>
        <tr>
          <td class="tituloNombres">Nombre:</td>
          <td class="contenidoNombres"><INPUT id="txtEmpresa" type="text" name="txtEmpresa" value="<? echo $Registro["empresa"]; ?>" maxLength="100" style="WIDTH: 300px; HEIGHT: 22px"></td>
        </tr>
        <tr>
          <td colspan="2" class="tituloNombres">Descripcion:</td>
          <!--<td class="contenidoNombres"><textarea rows="20" id="txtNoticia" name="txtNoticia" cols="80"><? //echo $Registro["noticia"]; ?></textarea></td>-->
        </tr>
			</table>
					<?
						/*$oFCKeditor = new FCKeditor('txtDescripcion') ;

						$oFCKeditor->BasePath = '../../herramientas/FCKeditor/';

						$oFCKeditor->Value = $Registro["descripcion"];

						$oFCKeditor->Create() ;

						$oFCKeditor->Width  = '100%' ;

						$oFCKeditor->Height = '400' ;*/

					?>        <textarea name="txtDescripcion"><? echo $Registro["descripcion"]?></textarea>        <script>            CKEDITOR.replace( 'txtDescripcion' );
        </script>
			<table width="100%">
        <tr>
          <td class="tituloNombres">Imagen:</td>
          <td class="contenidoNombres"><input type="file" id="txtImagen[]" name="txtImagen[]"></td>
        </tr>
        <tr>
          <td class="tituloNombres">Imagen Actual:</td>
          <td class="contenidoNombres">
          <?
            if ( empty($Registro["imagen"]) )

            {

              echo "No se asigno una imagen.";

            }

            else

            {

              ?><img src="<? echo $cRutaVerImgEmpsemana . $Registro["imagen"]; ?>"><?
            }

          ?>
          </td>
        <tr>
          <td class="tituloNombres">Tags:</td>
          <td class="contenidoNombres"><INPUT id="txtFuente" type="text" name="txtFuente" value="<? echo $Registro["fuente"]; ?>" maxLength="255" style="WIDTH: 300px; HEIGHT: 22px"></td>
        </tr>
        </tr>
			<?
			if ( Perfil() == "3" )

			{

			?><input type="hidden" name="optPublicar" id="optPublicar" value="<? echo $Registro["publicar"] ?>"><?
			}

			else

			{

			?>
			<tr>
				<td class="tituloNombres">Publicar:</td>
				<td class="contenidoNombres">
					<table border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td><label><input type="radio" id="optPublicar" name="optPublicar" value="S" <? if ( $Registro["publicar"] == "S" ) echo "checked" ?>>Si</label></td>
							<td width="10"></td>
							<td><label><input type="radio" id="optPublicar" name="optPublicar" value="N" <? if ( $Registro["publicar"] == "N" ) echo "checked" ?>>No</label></td>
						</tr>
					</table>
			  </td>
			</tr>
			<?
			}

			?>
        <tr>
          <td colspan="2" class="tituloFormulario">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2" class="nuevo">
            <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
						<?
						if ( Perfil() != "3" )

						{

						?><a href="empsemana.php?Accion=Eliminar&Id=<? echo $nId ;?>"><img src="../../image/eliminar.gif" border="0" alt="Eliminar Registro." onClick="javascript: return confirm('�Esta seguro que desea eliminar este registro?')"></a><?
						}

						?>
            <a href="empsemana_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
          </td>
        </tr>
      </table>
    </form>
<?
  mysqli_free_result( $Resultado );

  }

  ###############################################################################

?>
