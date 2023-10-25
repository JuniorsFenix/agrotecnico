<?
  ###############################################################################
  # categorias_funciones.php :  Archivo de funciones modulo categorias
  # Desarrollo               :  Estilo y Dise�o & Informaticactiva
  # Web                      :  http://www.esidi.com
  #                             http://www.informaticactiva.com
  ###############################################################################
?>
<? include("../../funciones_generales.php"); ?>
<?
  ###############################################################################
  # Nombre        : CategoriasFormNuevo
  # Descripci�n   : Muestra el formulario para ingreso de categorias nuevas
  # Parametros    : Ninguno.
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function CategoriasFormNuevo( $nIdPadre, $cNomPadre )
  {
?>
    <!-- Formulario Ingreso de Categorias -->
    <form action="eventos_categorias.php?Accion=Guardar" method="post" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="0">
			<input type="hidden" id="txtIdPadre" name="txtIdPadre" value="<? echo( $nIdPadre );  ?>">
			<input type="hidden" id="txtNomPadre" name="txtNomPadre" value="<? echo ( $cNomPadre ); ?>">
			<input type="hidden" id="txtIdPadreActual" name="txtIdPadreActual" value="0">
      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario">
						<b>
							<?
								if ( $nIdPadre <= 0 )
								{
									echo "NUEVA CATEGOR�A";
								}
								else
								{
									echo "NUEVA SUB-CATEGOR�A";
								}
							?>
						</b>
					</td>
        </tr>
        <tr>
        		<td class="tituloNombres">Nivel:</td>
        		<td class="contenidoNombres">
							<?
								if ( $nIdPadre <= 0 )
								{
									echo "Superior";
								}
								else
								{
									echo $cNomPadre;
								}
							?>
						</td>
       		</tr>
        <tr>
        		<td class="tituloNombres">Nombre Categor�a:</td>
        		<td class="contenidoNombres"><input id="txtCategoria" type="text" name="txtCategoria" maxlength="100" style="WIDTH: 300px; HEIGHT: 22px"></td>
       		</tr>
        <tr>
        		<td class="tituloNombres" colspan="2">Descripci&oacute;n:</td>
        		<!--<td class="contenidoNombres"><textarea name="txtDescripcion" cols="80" rows="20" id="txtDescripcion"></textarea></td>-->
       		</tr>
				</table>
					<?
						$oFCKeditor = new FCKeditor('txtDescripcion') ;
						$oFCKeditor->BasePath = '../../herramientas/FCKeditor/';
						$oFCKeditor->Create() ;
						$oFCKeditor->Width  = '100%' ;
						$oFCKeditor->Height = '400' ;
					?>
				<table width="100%">
        <tr>
        		<td class="tituloNombres">Imagen:</td>
        		<td class="contenidoNombres"><input name="txtImagen[]" type="file" id="txtImagen[]" maxlength="255" style="WIDTH: 300px; HEIGHT: 22px"></td>
       		</tr>
        <tr>
          <td colspan="2" class="tituloFormulario">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2" class="nuevo">
            <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
            <a href="eventos_categorias_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
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
  # Nombre        : CategoriasGuardar
  # Descripci�n   : Adiciona un nuevo registro o actualiza uno existente
  # Parametros    : cCategoria, nId (Si el Cero Nuevo Registro, de lo contrario Actualizar un Registro)
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function CategoriasGuardar( $nIdPadreActual,$nId,$nIdPadre,$cCategoria,$cDescripcion,$cImagen )
  {
		$IdCiudad = $_SESSION["IdCiudad"];
    $nConexion = Conectar();
    if ( $nId <= 0 ) // Nuevo Registro
    {
			// Si la categoria es de nivel superior, idcategoria es igual al numero total de categorias de nivel superior(0*) + 1
      //mysqli_query($nConexion,"INSERT INTO tblcategoriasproductos ( idpadre,categoria,descripcion,imagen ) VALUES ( '$nIdPadre','$cCategoria','$cDescripcion','$cImagen' )");
			if ( $nIdPadre == 0 )
			{
				$idNuevoPadre					= $nIdPadre;
				$rsContador						= mysqli_query($nConexion,"SELECT MAX( CAST(idcategoria AS UNSIGNED) ) AS contador FROM tblcategoriaseventos WHERE idpadre = '$idNuevoPadre' AND (idciudad = $IdCiudad)");
				$RegistrosRSContador	= mysqli_fetch_object($rsContador);
				$Contador							= $RegistrosRSContador->contador;
				if ( $Contador == null ) 
				{
					$NuevoIdCategoria		= 1;
				}
				else
				{
					$NuevoIdCategoria			= $Contador + 1;
				}
				mysqli_query($nConexion,"INSERT INTO tblcategoriaseventos ( idcategoria,idpadre,categoria,descripcion,imagen,idciudad ) VALUES ('$NuevoIdCategoria','0', '$cCategoria','$cDescripcion','$cImagen',$IdCiudad)");
				Log_System( "EVENTOS CATEGORIAS" , "NUEVO" , "CATEGORIA: " . $cCategoria  );
			} //FIN if ( $nIdPadre == 0 )
			else
			{
				$rsContador = mysqli_query($nConexion,"SELECT COUNT(*)+1 AS contador FROM tblcategoriaseventos WHERE idpadre = '$nIdPadre' AND (idciudad = $IdCiudad)");
				$RegistroRS = mysqli_fetch_object($rsContador);
				$nContador 	= $RegistroRS->contador;
				if ( strlen($nContador) == 1 )
				{
					$nContador = "0" . $nContador;
				}
				$cCodCategoria = $nIdPadre . "." . $nContador ;
				mysqli_query($nConexion,"INSERT INTO tblcategoriaseventos (idcategoria,idpadre,categoria,descripcion,imagen,idciudad) VALUES ('$cCodCategoria','$nIdPadre','$cCategoria','$cDescripcion','$cImagen',$IdCiudad)");
				Log_System( "EVENTOS CATEGORIAS" , "NUEVO" , "CATEGORIA: " . $cCategoria  );
			}
      mysqli_close($nConexion);
      Mensaje( "El registro ha sido almacenado correctamente.", "eventos_categorias_listar.php" ) ;
      exit;
    }
    else // Actualizar Registro Existente
    {
			// Si  IdCategoriaActual es Igual a IdPadre ERROR.
			// Una categoria no puede contenerse ella misma.
			if ( $nId == $nIdPadre )
			{
				Error( "Una categor�a no puede contenerse ella misma." );
				mysqli_close( $nConexion );
				exit;
			}
			//Calculo Nuevo Codigo Categoria solo si cambio la categoria a otra subcategoria
			if ( $nIdPadreActual != $nIdPadre )
			{
				$idNuevoPadre					= $nIdPadre;
				//$rsContador						= mysqli_query($nConexion,"SELECT MAX(idcategoria) AS contador FROM tblcategoriasproductos WHERE idpadre = '$idNuevoPadre'");
				$rsContador						= mysqli_query($nConexion,"SELECT COUNT(*) AS contador FROM tblcategoriaseventos WHERE idpadre = '$idNuevoPadre' AND (idciudad = $IdCiudad)");
				$RegistrosRSContador	= mysqli_fetch_object($rsContador);
				$Contador							= $RegistrosRSContador->contador;
				if ( $Contador == null )
				{
					$NuevoIdCategoria		= $idNuevoPadre . "." . "01";
				} //FIN: if ( $Contador == null )
				else
				{
					$Contador = $Contador + 1;
					if ( strlen($Contador) == 1 )
					{
						$Contador = "0" . $Contador;
						$NuevoIdCategoria = $idNuevoPadre . "." . $Contador;
					}
					else
					{
						$NuevoIdCategoria = $idNuevoPadre . "." . $Contador;
					}
				}
				mysqli_free_result($rsContador);
				
				if ( !empty( $cImagen ) )
				{
					mysqli_query($nConexion, "UPDATE tblcategoriaseventos SET idcategoria = '$NuevoIdCategoria', idpadre = '$idNuevoPadre', categoria = '$cCategoria', descripcion = '$cDescripcion', imagen = '$cImagen' WHERE idcategoria = '$nId' AND (idciudad = $IdCiudad)" );
					Log_System( "eventos CATEGORIAS" , "EDITA" , "CATEGORIA: " . $cCategoria  );
				}
				else
				{
					mysqli_query($nConexion, "UPDATE tblcategoriaseventos SET idcategoria = '$NuevoIdCategoria', idpadre = '$idNuevoPadre', categoria = '$cCategoria', descripcion = '$cDescripcion' WHERE idcategoria = '$nId' AND (idciudad = $IdCiudad)" );
					Log_System( "eventos CATEGORIAS" , "EDITA" , "CATEGORIA: " . $cCategoria  );
				}
				// Actualizo las categorias de los eventos que pertenecian al anterior codigo categoria
				mysqli_query($nConexion,"UPDATE tbleventos SET idcategoria = '$NuevoIdCategoria' WHERE idcategoria =  '$nId' AND (idciudad = $IdCiudad)");
			}
			else // No cambio la categoria actualizo los demas datos
			{
				if ( !empty( $cImagen ) )
				{
					mysqli_query($nConexion, "UPDATE tblcategoriaseventos SET categoria = '$cCategoria', descripcion = '$cDescripcion', imagen = '$cImagen' WHERE idcategoria = '$nId' AND (idciudad = $IdCiudad)" );
					Log_System( "eventos CATEGORIAS" , "EDITA" , "CATEGORIA: " . $cCategoria  );
				}
				else
				{
					mysqli_query($nConexion, "UPDATE tblcategoriaseventos SET categoria = '$cCategoria', descripcion = '$cDescripcion' WHERE idcategoria = '$nId' AND (idciudad = $IdCiudad)" ) or die (mysqli_error($nConexion));
					Log_System( "eventos CATEGORIAS" , "EDITA" , "CATEGORIA: " . $cCategoria  );
				}
			}
      mysqli_close( $nConexion );
      Mensaje( "El registro ha sido actualizado correctamente.", "eventos_categorias_listar.php" ) ;
      exit;
    }
  } // FIN: function 
  ###############################################################################
?>
<?
  ###############################################################################
  # Nombre        : CategoriasEliminar
  # Descripci�n   : Eliminar un registro 
  # Parametros    : $nId
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function CategoriasEliminar( $nId )
  {
		$IdCiudad = $_SESSION["IdCiudad"];
    $nConexion = Conectar();
		$reg = mysqli_fetch_object( mysqli_query($nConexion,"SELECT categoria FROM tblcategoriaseventos WHERE idcategoria ='$nId' AND (idciudad = $IdCiudad)") );
    mysqli_query($nConexion, "DELETE FROM tblcategoriaseventos WHERE idcategoria ='$nId' AND (idciudad = $IdCiudad)" );
		Log_System( "eventos CATEGORIAS" , "ELIMINA" , "CATEGORIA: " . $reg->categoria  );
    mysqli_close( $nConexion );
    Mensaje( "El registro ha sido eliminado correctamente.","eventos_categorias_listar.php" );
    exit();
  } // FIN: function UsuariosGuardar
  ###############################################################################
?>
<?
  ###############################################################################
  # Nombre        : CategoriasFormEditar
  # Descripci�n   : Muestra el formulario para editar o eliminar registros
  # Parametros    : $nId = ID de registro que se debe mostrar el en formulario
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function CategoriasFormEditar( $nId )
  {
		$IdCiudad = $_SESSION["IdCiudad"];
		include("../../vargenerales.php");
    $nConexion    = Conectar();
    $Resultado    = mysqli_query($nConexion, "SELECT tblcategoriaseventos.idcategoria, tblcategoriaseventos.idpadre, tblcategoriaseventos.categoria, tblcategoriaseventos.descripcion, tblcategoriaseventos.imagen, COUNT(tbleventos.idservicio) AS teventos FROM tblcategoriaseventos LEFT OUTER JOIN tbleventos ON tblcategoriaseventos.idcategoria = tbleventos.idservicio WHERE tblcategoriaseventos.idcategoria = '$nId' AND (tblcategoriaseventos.idciudad = $IdCiudad) GROUP BY tblcategoriaseventos.idcategoria, tblcategoriaseventos.idpadre, tblcategoriaseventos.categoria, tblcategoriaseventos.descripcion, tblcategoriaseventos.imagen" ) ;
    $ResultadoSubCat = mysqli_query($nConexion, "SELECT COUNT(tblcategoriaseventos.idcategoria) AS tsubcategorias FROM tblcategoriaseventos WHERE idpadre = '$nId' AND (idciudad = $IdCiudad)" );
		mysqli_close( $nConexion ) ;

    $Registro     = mysqli_fetch_array( $Resultado );
		$RegistroSubCat = mysqli_fetch_array( $ResultadoSubCat );
?>
    <!-- Formulario Edici�n / Eliminaci�n de Categor�as -->
    <form method="post" action="eventos_categorias.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="<? echo $nId ; ?>">
			<input type="hidden" id="txtIdPadreActual" name="txtIdPadreActual" value="<? echo $Registro[ "idpadre" ]; ?>">
      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario">
					<b>
						<?
							if ( $Registro[ "idpadre" ] == 0  )
							{
								?>EDITAR CATEGOR�A<?
							}
							else
							{
								?>EDITAR SUB-CATEGOR�A<?
							}
						?>
						
					</b>
				</td>
        </tr>
				<tr>
					<td class="tituloNombres">Categor�a Padre:</td>
					<td class="contenidoNombres">
						<select name="txtIdPadre" id="txtIdPadre">
						<?
						if ( $Registro[ "idpadre" ] == 0  )
						{
							?><option selected value="0">Nivel Superior</option><?
						}
						else
						{
							?><option value="0">Nivel Superior</option><?
						}
            $nConexion = Conectar();
            $ResultadoCat = mysqli_query($nConexion, "SELECT * FROM tblcategoriaseventos WHERE  (idciudad = $IdCiudad) ORDER BY idcategoria" );
            mysqli_close($nConexion);
            while($Registros=mysqli_fetch_object($ResultadoCat))
            {
							if ( $Registro["idpadre"] == $Registros->idcategoria )
              {
								?>
									<option selected value="<? echo $Registros->idcategoria; ?>"><? echo $Registros->idcategoria . "&nbsp;" . $Registros->categoria ; ?></option>
								<?
							}
							else
							{
								?>
									<option value="<? echo $Registros->idcategoria; ?>"><? echo $Registros->idcategoria . "&nbsp;" . $Registros->categoria ; ?></option>
								<?
							}
						}
            mysqli_free_result($ResultadoCat);
            ?></select>
					</td>
				</tr>
        <tr>
          <td class="tituloNombres">Nombre Categor�a:</td>
          <td class="contenidoNombres"><INPUT id="txtCategoria" type="text" name="txtCategoria" maxLength="100" value="<? echo $Registro[ "categoria" ] ;?>" style="WIDTH: 300px; HEIGHT: 22px"></td>
        </tr>
        <tr>
        		<td colspan="2" class="tituloNombres">Descripci&oacute;n:</td>
        		<!--<td class="contenidoNombres"><textarea name="txtDescripcion" cols="80" rows="20" id="txtDescripcion"><? //echo $Registro[ "descripcion" ] ;?></textarea></td>-->
       		</tr>
				</table>
					<?
						$oFCKeditor = new FCKeditor('txtDescripcion') ;
						$oFCKeditor->BasePath = '../../herramientas/FCKeditor/';
						$oFCKeditor->Value = $Registro["descripcion"];
						$oFCKeditor->Create() ;
						$oFCKeditor->Width  = '100%' ;
						$oFCKeditor->Height = '400' ;
					?>
				<table width="100%">
        <tr>
        		<td class="tituloNombres">Imagen:</td>
        		<td class="contenidoNombres"><input name="txtImagen[]" type="file" id="txtImagen[]" maxlength="255" style="WIDTH: 300px; HEIGHT: 22px"></td>
       		</tr>
        <tr>
        		<td class="tituloNombres">Imagen Actual: </td>
        		<td class="contenidoNombres">
						<?
							if ( empty($Registro["imagen"]) )
							{
								echo "No se asigno una imagen.";
							}
							else
							{
								?><img src="<? echo $cRutaVerImgCategorias_eventos . $Registro["imagen"]; ?>"><?
							}
						?>
						</td>
       		</tr>
        <tr>
          <td class="tituloNombres">Contiene:</td>
          <?
            $cMSGEliminar = "";
						$cEliminable  = "SI";
            if ( (($Registro[ "teventos" ] > 0) or ($RegistroSubCat[ "tsubcategorias" ] > 0)) )
            {
							$cEliminable  = "NO";
							if ( $Registro[ "idpadre" ] == 0  )
							{
								$cMSGEliminar = "Esta categor�a no puede ser eliminada.";
							}
							else
							{
								$cMSGEliminar = "Esta sub-categor�a no puede ser eliminada.";
							}
              
            }
          ?>
          <td class="contenidoNombres"><? echo $RegistroSubCat[ "tsubcategorias" ] . " SubCategor�a(s).<br>" ;?></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td class="contenidoNombres"><? echo $Registro[ "teventos" ] . " Servicio(s).<br>" ?></td>
				</tr>
				<?	
				if ( $cEliminable == "NO" )
				{
				?>
				<tr>
					<td>&nbsp;</td>
					<td class="contenidoNombres"><? echo $cMSGEliminar; ?></td>
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
              if ( $cEliminable == "SI" )
              {
                ?><a href="eventos_categorias.php?Accion=Eliminar&Id=<? echo $nId ;?>"><img src="../../image/eliminar.gif" border="0" alt="Eliminar Registro." onClick="javascript: return confirm('�Esta seguro que desea eliminar este registro?')"></a><?
              }
						}
						?>


            <a href="eventos_categorias_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
          </td>
        </tr>
      </table>
    </form>
<?
  mysqli_free_result( $Resultado );
	mysqli_free_result( $ResultadoSubCat );
  }
  ###############################################################################
?>
