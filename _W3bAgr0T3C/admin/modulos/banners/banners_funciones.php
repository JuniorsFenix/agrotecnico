<?
  ###############################################################################
  # productos_funciones.php  :  Archivo de funciones modulo productos / servicios
  # Desarrollo               :  Estilo y Dise�o & Informaticactiva
  # Web                      :  http://www.esidi.com
  #                             http://www.informaticactiva.com
  ###############################################################################
  
include("../../funciones_generales.php"); 
  function BannersFormNuevo()
  {
?>
    <!-- Formulario Ingreso -->
    <form method="post" action="banners.php?Accion=Guardar" enctype="multipart/form-data" name="frm">
      <input TYPE="hidden" id="txtId" name="txtId" value="0">
      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>NUEVO BANNER</b></td>
        </tr>
        <tr>
          <td class="tituloNombres">Bloque:</td>
          <td class="contenidoNombres">
						<select name="cboBloques" id="cboBloques">
						<?
            $nConexion = Conectar();
            $ResultadoBloque = mysqli_query($nConexion, "SELECT * FROM tblbanners_bloques ORDER BY bloque" );
            mysqli_close($nConexion);
						$nContador = 0;
            while($Registros=mysqli_fetch_object($ResultadoBloque))
            {
							$nContador = $nContador + 1;
							if ( $nContador == 1 )
              {
								?><option selected value="<? echo $Registros->idbloque; ?>"><? echo $Registros->bloque; ?></option><?
							}
							else
							{
								?><option value="<? echo $Registros->idbloque; ?>"><? echo $Registros->bloque; ?></option><?
							}
						}
            mysqli_free_result($ResultadoBloque);
            ?>
						</select>
          </td>
        </tr>
        <tr>
          <td class="tituloNombres">Tipo:</td>
          <td class="contenidoNombres" valign="middle">
					<label><input type="radio" name="cboTipo" id="cboTipo" value="I" checked onclick="prender_url_newwindo()">Imagen</label>
					&nbsp;&nbsp;
					<label><input type="radio" name="cboTipo" id="cboTipo" value="F" onclick="apagar_url_newwindo()">Flash</label>
					</td>
        </tr>
        <tr>
          <td class="tituloNombres">Banner:</td>
          <td class="contenidoNombres"><input type="file" id="txtBanner" name="txtBanner[]"></td>
        </tr>
				<tr>
          <td class="tituloNombres">Enlace:</td>
          <td class="contenidoNombres"><input type="text" name="txtDirWeb" id="txtDirWeb" maxlength="200" style="width:300px" value="http://"></td>
				</tr>
       <tr>
         <td class="tituloNombres">Ventana Nueva:</td>
         <td class="contenidoNombres" valign="middle">
				<label><input type="radio" name="NewWindow" id="NewWindow" value="S" checked>Si</label>
				&nbsp;&nbsp;
				<label><input type="radio" name="NewWindow" id="NewWindow" value="N">No</label>
				</td>
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
          <td colspan="2" class="nuevo">
            <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
            <a href="banners_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
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
  function BannersGuardar( $nId,$IdBloque,$Tipo,$Banner,$DirWeb,$cPublicar,$cNuevaVentana )
  {
		$IdCiudad			= $_SESSION["IdCiudad"];
    $nConexion = Conectar();
    if ( $nId <= 0 ) // Nuevo Registro
    {
      mysqli_query($nConexion,"INSERT INTO tblbanners ( idbloque,tipo,banner,dirweb,publicar,idciudad,nueva_ventana ) VALUES ( '$IdBloque','$Tipo','$Banner','$DirWeb','$cPublicar',$IdCiudad,'$cNuevaVentana' )");
			Log_System( "BANNERS" , "NUEVO" , "BANNERS: " . $Banner );
      mysqli_close($nConexion);
      Mensaje( "El registro ha sido almacenado correctamente.", "banners_listar.php" ) ;
      exit;
    }
    else // Actualizar Registro Existente
    {
		$cTxtSQLUpdate		= "UPDATE tblbanners SET idbloque = '$IdBloque',tipo = '$Tipo',dirweb = '$DirWeb',publicar = '$cPublicar', nueva_ventana = '$cNuevaVentana'";

	  if ( $Banner!= "*" )
      {
        $cTxtSQLUpdate = $cTxtSQLUpdate . " , banner = '$Banner'"  ;
      }
		$cTxtSQLUpdate = $cTxtSQLUpdate . " WHERE idbanner = '$nId'";

	  mysqli_query($nConexion,$cTxtSQLUpdate  );

		Log_System( "BANNERS" , "EDITA" , "BANNER: " . $Banner );

    mysqli_close( $nConexion );

    Mensaje( "El registro ha sido actualizado correctamente.", "banners_listar.php" ) ;

    exit;

    }

  } // FIN: function

  ###############################################################################

?>

<?
  function BannersEliminar( $nId )
  {
    $nConexion = Conectar();
		$reg = mysqli_fetch_object( mysqli_query($nConexion,"SELECT banner FROM tblbanners WHERE idbanner ='$nId'") );
    mysqli_query($nConexion, "DELETE FROM tblbanners WHERE idbanner ='$nId'" );
		Log_System( "BANNERS" , "ELIMINA" , "BANNER: " . $reg->banner );
    mysqli_close( $nConexion );
    Mensaje( "El registro ha sido eliminado correctamente.","banners_listar.php" );
    exit();
  } // FIN: function 
  ###############################################################################
?>

<?

  function BannersFormEditar( $nId )

  {

		include("../../vargenerales.php");

    $nConexion    = Conectar();

    $Resultado    = mysqli_query($nConexion, "SELECT * FROM tblbanners WHERE idbanner = '$nId'" ) ;

    mysqli_close( $nConexion ) ;

    $Registro     = mysqli_fetch_array( $Resultado );

?>

    <!-- Formulario Edici�n / Eliminaci�n -->

    <form method="post" name="frm" action="banners.php?Accion=Guardar" enctype="multipart/form-data">

      <input TYPE="hidden" id="txtId" name="txtId" value="<? echo $nId ; ?>">

      <table width="100%">

        <tr>

          <td colspan="2" align="center" class="tituloFormulario"><b>EDITAR BANNERS</b></td>

        </tr>

        <tr>

          <td class="tituloNombres">Bloque:</td>

          <td class="contenidoNombres">

						<select name="cboBloques" id="cboBloques">

						<?

            $nConexion = Conectar();

            $ResultadoCat = mysqli_query($nConexion, "SELECT * FROM tblbanners_bloques ORDER BY bloque" );

            mysqli_close($nConexion);

            while($Registros=mysqli_fetch_object($ResultadoCat))

            {

							if ( $Registro["idbloque"] == $Registros->idbloque )

              {

								?>

									<option selected value="<? echo $Registros->idbloque; ?>"><? echo $Registros->bloque; ?></option>

								<?

							}

							else

							{

								?>

									<option value="<? echo $Registros->idbloque; ?>"><? echo $Registros->bloque ; ?></option>

								<?

							}

						}

            mysqli_free_result($ResultadoCat);

            ?></select>

          </td>

        </tr>

        <tr>
          <td class="tituloNombres">Tipo:</td>
          <td class="contenidoNombres">
					<label><input type="radio" name="cboTipo" id="cboTipo" value="I" onclick="prender_url_newwindo()" <? if ( $Registro["tipo"] == 'I' ) { echo "checked"; } ?>>Imagen</label>
					&nbsp;&nbsp;
					<label><input type="radio" name="cboTipo" id="cboTipo" value="F" onclick="apagar_url_newwindo()" <? if ( $Registro["tipo"] == 'F' ) { echo "checked"; } ?>>Flash</label>
					</td>
        </tr>

        <tr>

          <td class="tituloNombres">Banner:</td>

          <td class="contenidoNombres"><input type="file" id="txtBanner" name="txtBanner[]"></td>

        </tr>

        <tr>

          <td class="tituloNombres">Banner Actual:</td>

          <td>

          <?

            if ( empty($Registro["banner"]) )

            {

              echo "No se asigno un banner.";

            }

            else

            {

							if ( $Registro["tipo"] == "I" )

							{

							?>

                            <img src="<? echo $cRutaVerBanners . $Registro["banner"]; ?>">

							<?

							}

              else

							{

								//$Tam_Archivo = getimagesize($cRutaVerBanners . $Registro["banner"]);

								$Tam_Archivo = getimagesize($cRutaBanners . $Registro["banner"]);

								?>

								<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" <? echo $Tam_Archivo[3]; ?>>

									<param name="movie" value="<? echo $cRutaVerBanners . $Registro["banner"]; ?>">

									<param name="quality" value="high">

									<embed src="<? echo $cRutaVerBanners . $Registro["banner"]; ?>" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" <? echo $Tam_Archivo[3]; ?>></embed>

								</object>

								<?

							}

            }

          ?>

          </td>

        </tr>

				<tr>
          <td class="tituloNombres">Enlace:</td>
          <td class="contenidoNombres"><input type="text" name="txtDirWeb" id="txtDirWeb" value="<? echo $Registro["dirweb"] ?>" maxlength="200" style="width:300px"></td>
				</tr>
        <tr>
          <td class="tituloNombres">Ventana Nueva:</td>
          <td class="contenidoNombres">
					<label><input type="radio" name="NewWindow" id="NewWindow" value="S" <? if ( $Registro["nueva_ventana"] == 'S' ) { echo "checked"; } ?>>Si</label>
					&nbsp;&nbsp;
					<label><input type="radio" name="NewWindow" id="NewWindow" value="N" <? if ( $Registro["nueva_ventana"] == 'N' ) { echo "checked"; } ?>>No</label>
					</td>
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

						?><a href="banners.php?Accion=Eliminar&Id=<? echo $nId ;?>"><img src="../../image/eliminar.gif" border="0" alt="Eliminar Registro." onClick="javascript: return confirm('�Esta seguro que desea eliminar este registro?')"></a><?

						}

						?>



            

            <a href="banners_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>

          </td>

        </tr>

      </table>

    </form>

<?

  mysqli_free_result( $Resultado );

  }

  ###############################################################################

?>

