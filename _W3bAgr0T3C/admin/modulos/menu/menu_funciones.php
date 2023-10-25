<?
  ###############################################################################
  # noticias_funciones.php   :  Archivo de funciones modulo faqs
  # Desarrollo               :  Estilo y Diseño & Informaticactiva
  # Web                      :  http://www.esidi.com
  #                             http://www.informaticactiva.com
  ###############################################################################
?>
<? include("../../funciones_generales.php"); ?>
<?
	function ListaPadres()
	{
		$IdCiudad			= $_SESSION["IdCiudad"];
    $nConexion    = Conectar($IdCiudad);
	mysqli_set_charset($nConexion,'utf8');
    $Resultado    = mysqli_query($nConexion, "SELECT idmenu,titulo FROM tblmenu WHERE ( publicar = 'S' ) AND ( idciudad = $IdCiudad ) ORDER BY orden ASC" ) ;
    mysqli_close( $nConexion ) ;
		return $Resultado;
	}

	function ListaContenidos()
	{
		$IdCiudad			= $_SESSION["IdCiudad"];
    $nConexion    = Conectar();
	mysqli_set_charset($nConexion,'utf8');
    $Resultado    = mysqli_query($nConexion, "SELECT idcontenido,clave,titulo FROM tblcontenidos WHERE publicar = 'S' AND ( idciudad = $IdCiudad ) ORDER BY titulo" ) ;
    mysqli_close( $nConexion ) ;
		return $Resultado;
	}
	
	function ListaServicios()
	{
		$IdCiudad			= $_SESSION["IdCiudad"];
    $nConexion    = Conectar();
	mysqli_set_charset($nConexion,'utf8');
    $Resultado    = mysqli_query($nConexion, "SELECT url,servicio FROM tblservicios WHERE publicar = 'S' AND ( idciudad = $IdCiudad ) ORDER BY servicio" ) ;
    mysqli_close( $nConexion ) ;
		return $Resultado;
	}

	function ListaProductos()
	{
		$IdCiudad			= $_SESSION["IdCiudad"];
    $nConexion    = Conectar();
	mysqli_set_charset($nConexion,'utf8');
    $Resultado    = mysqli_query($nConexion, "SELECT url,nombre FROM tblti_productos ORDER BY nombre" ) ;
    mysqli_close( $nConexion ) ;
		return $Resultado;
	}

	function MenuListarSub($Padre)
	{
		// Consulta las SubOpciones de un menu padre
    $nConexion    = Conectar();
	mysqli_set_charset($nConexion,'utf8');
    $Resultado    = mysqli_query($nConexion, "SELECT * FROM tblmenu WHERE padre = $Padre ORDER BY orden ASC" ) ;
    mysqli_close( $nConexion ) ;
		return $Resultado;
	}

	function MenuListar()
	{
		// Consulta todas las opciones del menu para ser listadas
		$IdCiudad			= $_SESSION["IdCiudad"];
    $nConexion    = Conectar();
	mysqli_set_charset($nConexion,'utf8');
    $Resultado    = mysqli_query($nConexion, "SELECT * FROM tblmenu WHERE (padre = 0) AND (idciudad = $IdCiudad) ORDER BY orden ASC" ) ;
    mysqli_close( $nConexion ) ;
		return $Resultado;
	}
	
	function MenuTotalRegistros()
	{
		$IdCiudad			= $_SESSION["IdCiudad"];
    $nConexion    = Conectar();
	mysqli_set_charset($nConexion,'utf8');
    $Resultado    = mysqli_query($nConexion, "SELECT COUNT(idmenu) AS total FROM tblmenu WHERE (padre = 0) AND (idciudad = $IdCiudad)" ) ;
    mysqli_close( $nConexion ) ;
		$RegTotal = mysqli_fetch_object($Resultado);
		$Total = $RegTotal->total;
		mysqli_free_result($Resultado);
		return $Total;
	}
	
	function SubMenuTotalRegistros($Padre)
	{
		$IdCiudad			= $_SESSION["IdCiudad"];
    $nConexion    = Conectar();
	mysqli_set_charset($nConexion,'utf8');
    $Resultado    = mysqli_query($nConexion, "SELECT COUNT(idmenu) AS total FROM tblmenu WHERE padre = $Padre" ) ;
    mysqli_close( $nConexion ) ;
		$RegTotal = mysqli_fetch_object($Resultado);
		$Total = $RegTotal->total;
		mysqli_free_result($Resultado);
		return $Total;
	}
	
	
	function MenuMover($nIdMenu, $nOrden )
	{
		$nConexion    = Conectar();
		mysqli_set_charset($nConexion,'utf8');
		
		mysqli_query($nConexion, "UPDATE tblmenu SET orden = $nOrden WHERE idmenu = $nIdMenu"  );
		
		mysqli_close( $nConexion );
	}


  ###############################################################################
  # Nombre        : FaqsFormNuevo
  # Descripción   : Muestra el formulario para ingreso de productos nuevos
  # Parametros    : Ninguno.
  # Desarrollado  : Estilo y Diseño & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function MenuFormNuevo()
  {
	$rs_ListaContenidos = ListaContenidos();
	$rs_ListaProductos	= ListaProductos();
	$rs_ListaServicios	= ListaServicios();
	$rs_ListaPadres			= ListaPadres();

?>
    <!-- Formulario Ingreso -->
    <form method="post" action="menu.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="0">
			<input type="hidden" id="txtOrden" name="txtOrden" value="0">
      <table>
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>NUEVA OPCIÓN</b></td>
        </tr>
        <tr>
          <td class="tituloNombres">Titulo:</td>
          <td class="contenidoNombres"><input type="text" id="txtTitulo" name="txtTitulo" maxlength="100" size="70"></td>
        </tr>
        <tr>
          <td class="tituloNombres">Modulo:</td>
          <td height="222" class="contenidoNombres">
						<table>
							<tr>
								<td><label><input onClick="VerPanel(1)" type="radio" name="opModulo" value="Contenido" checked>Contenido</label></td>
								<td><label><input onClick="VerPanel(2)" type="radio" name="opModulo" value="Productos">Productos</label></td>
								<td><label><input onClick="VerPanel(3)" type="radio" name="opModulo" value="Servicios">Servicios</label></td>
								<td><label><input onClick="VerPanel(4)" type="radio" name="opModulo" value="Url">Url</label></td>
							</tr>
						</table><br>
						<div id="DivContenidos" style="visibility:visible; position:absolute; ">
						<table border="0" cellpadding="0" cellspacing="0">
							<tr><td><strong>Seleccione Contenido:</strong></td></tr>
							<tr>
								<td>
									<select name="lstContenidos" size="10" style="width:450px;">
									<?
										$Contador = 0;
										while($row=mysqli_fetch_object($rs_ListaContenidos))
										{
											$Contador = $Contador + 1;
											if ( $Contador == 1 )
											{
												echo "<option selected title='$row->titulo' value='$row->clave'>$row->titulo</option>\n";
											}
											else
											{
												echo "<option title='$row->titulo' value='$row->clave'>$row->titulo</option>\n";
											}
											
										}
									?>
									</select>
								</td>
							</tr>
						</table>
						</div>
					
						<div id="DivProductos" style="visibility:hidden; position:absolute;">
						<table border="0" cellpadding="0" cellspacing="0">
							<tr><td><strong>Seleccione Producto:</strong></td></tr>
							<tr>
								<td>
									<select name="lstProductos" size="10" style="width:450px;">
									<?
										$Contador = 0;
										while($row=mysqli_fetch_object($rs_ListaProductos))
										{
											$Contador = $Contador + 1;
											if ( $Contador == 1 )
											{
												echo "<option selected title='$row->nombre' value='$row->url'>$row->nombre</option>\n";
											}
											else
											{
												echo "<option title='$row->nombre' value='$row->url'>$row->nombre</option>\n";
											}
											
										}
									?>
									</select>
								</td>
							</tr>
						</table>
						</div>
						
						<div id="DivServicios" style="visibility:hidden; position:absolute;">
						<table border="0" cellpadding="0" cellspacing="0">
							<tr><td><strong>Seleccione Servicio:</strong></td></tr>
							<tr>
								<td>
									<select name="lstServicios" size="10" style="width:450px;">
									<?
										$Contador = 0;
										while($row=mysqli_fetch_object($rs_ListaServicios))
										{
											$Contador = $Contador + 1;
											if ( $Contador == 1 )
											{
												echo "<option selected title='$row->servicio' value='$row->url'>$row->servicio</option>\n";
											}
											else
											{
												echo "<option title='$row->servicio' value='$row->url'>$row->servicio</option>\n";
											}
											
										}
									?>
									</select>
								</td>
							</tr>
						</table>
						</div>
					
						<div id="DivUrl" style="visibility:hidden; position:absolute;">
						<table border="0" cellpadding="0" cellspacing="0">
							<tr><td><strong>Escriba la URL:</strong></td></tr>
							<tr>
								<td><input type="text" name="txtUrl" id="txtUrl" maxlength="200" style="width:450px;"></td>
							</tr>
						</table>
						</div>
					</td>
        </tr>

				<tr>
					<td class="tituloNombres">Padre:</td>
					<td class="contenidoNombres">
						<select name="cboPadre" style="width:450px;">
						<option value="0" selected>Nivel Superior</option>
						<?
							$Contador = 0;
							while($row=mysqli_fetch_object($rs_ListaPadres))
							{
								echo "<option value='$row->idmenu'>$row->titulo</option>\n";
							}
						?>
						</select>
					</td>
				</tr>

				<tr>
					<td class="tituloNombres">Abrir en nueva ventana:</td>
					<td class="contenidoNombres"><input type="checkbox" id="chkVentana" name="chkVentana" value="S"></td>
				</tr>
                <tr>
                  <td class="tituloNombres">Imagen:</td>
                  <td class="contenidoNombres"><input type="file" id="txtImagen" name="txtImagen"></td>
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
            <a href="menu_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
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
  # Nombre        : MenuGuardar
  # Descripción   : Adiciona un nuevo registro o actualiza uno existente
  # Parametros    : $nId (Si el Cero Nuevo Registro, de lo contrario Actualizar un Registro)
  #                 $nIdCategoria, $cProducto, $cDetalle, $nPrecio, $cImagen
  # Desarrollado  : Estilo y Diseño & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function MenuGuardar( $nId,$nOrden,$cTitulo,$opModulo,$lstContenidos,$lstProductos,$lstServicios,$txtUrl,$cImagen,$cVentana,$cPublicar,$cboPadre )
  {
		$IdCiudad			= $_SESSION["IdCiudad"];
		if ( $cVentana == "S" )
		{
			$En_Nueva_Ventana = "S";
		}
		else
		{
			$En_Nueva_Ventana = "N";
		}

		switch ( $opModulo )
		{
			case "Contenido":
			$cLink 		= "/$lstContenidos";
			$cModulo	= "Contenido";
			$cClave		= $lstContenidos;
			break;
			case "Productos":
			$cLink = "/productos/" . $lstProductos;
			$cModulo	= "Productos";
			$cClave		= $lstProductos;
			break;
			case "Servicios":
			$cLink = "/servicios/" . $lstServicios;
			$cModulo	= "Servicios";
			$cClave		= $lstServicios;
			break;
			case "Url":
			$cLink = $txtUrl;
			$cModulo	= "Url";
			$cClave		= $txtUrl;
			break;
		}


		
    $nConexion = Conectar();
	mysqli_set_charset($nConexion,'utf8');
    if ( $nId <= 0 ) // Nuevo Registro
    {
			// Calculo el Orden Mayor y le sumo uno para el nuevo orden de la opcion (una opcion nueva siempre quedara de ultima)
			//$rs_Orden =  mysqli_query($nConexion,"SELECT MAX(orden)+1 AS nuevo_orden FROM tblmenu");
			$rs_Orden =  mysqli_query($nConexion,"SELECT MAX(orden)+1 AS nuevo_orden FROM tblmenu WHERE (padre = $cboPadre) AND (idciudad = $IdCiudad)");
			
			
			$Reg_Orden = mysqli_fetch_object($rs_Orden);
			if ( $Reg_Orden->nuevo_orden == null )
			{
				$nOrden = 1;
			}
			else
			{
				$nOrden = $Reg_Orden->nuevo_orden;
			}
			mysqli_free_result($rs_Orden);
      mysqli_query($nConexion,"INSERT INTO tblmenu ( titulo,link,orden,imagen,nueva_ventana,publicar,padre,modulo,clave,idciudad ) VALUES ( '$cTitulo','$cLink','$nOrden','$cImagen','$En_Nueva_Ventana','$cPublicar',$cboPadre,'$cModulo','$cClave',$IdCiudad)");
      Log_System( "MENU" , "NUEVO" , "OPCIÓN: " . $cTitulo  );
			mysqli_close($nConexion);
      Mensaje( "El registro ha sido almacenado correctamente.", "menu_listar.php" ) ;
    }
    else // Actualizar Registro Existente
    {
		$sql = "UPDATE tblmenu SET titulo = '$cTitulo', link = '$cLink', orden = '$nOrden', nueva_ventana = '$En_Nueva_Ventana', publicar = '$cPublicar', padre = $cboPadre, modulo = '$cModulo', clave = '$cClave', idciudad = $IdCiudad";
		
	  if ( $cImagen!= "" )
      {
        $sql = $sql . " ,imagen = '$cImagen'"  ;
      }
        $sql = $sql . " WHERE idmenu = '$nId'"  ;	  
    	mysqli_query($nConexion, $sql );
			Log_System( "MENU" , "EDITA" , "OPCIÓN: " . $cTitulo  );
			mysqli_close( $nConexion );
			Mensaje( "El registro ha sido actualizado correctamente.", "menu_listar.php" ) ;
			exit;
		}
  } // FIN: function 
  ###############################################################################
?>
<?
  ###############################################################################
  # Nombre        : FaqsEliminar
  # Descripción   : Eliminar un registro 
  # Parametros    : $nId
  # Desarrollado  : Estilo y Diseño & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function MenuEliminar( $nId )
  {
    $nConexion = Conectar();
	mysqli_set_charset($nConexion,'utf8');
		$reg = mysqli_fetch_object( mysqli_query($nConexion,"SELECT titulo FROM tblmenu WHERE idmenu ='$nId'") );
    mysqli_query($nConexion, "DELETE FROM tblmenu WHERE idmenu ='$nId'" );
    Log_System( "MENU" , "ELIMINA" , "OPCIÓN: " . $reg->titulo  );
		mysqli_close( $nConexion );
    Mensaje( "El registro ha sido eliminado correctamente.","menu_listar.php" );
    exit();
  } // FIN: function UsuariosGuardar
  ###############################################################################
?>
<?
  ###############################################################################
  # Nombre        : FaqsFormEditar
  # Descripción   : Muestra el formulario para editar o eliminar registros
  # Parametros    : $nId = ID de registro que se debe mostrar el en formulario
  # Desarrollado  : Estilo y Diseño & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function MenuFormEditar( $nId )
  {
		$rs_ListaContenidos = ListaContenidos();
		$rs_ListaProductos	= ListaProductos();
		$rs_ListaServicios	= ListaServicios();
		$rs_ListaPadres			= ListaPadres();
		include("../../vargenerales.php");
		
    $nConexion    = Conectar();
	mysqli_set_charset($nConexion,'utf8');
    $Resultado    = mysqli_query($nConexion, "SELECT * FROM tblmenu WHERE idmenu = '$nId'" ) ;
    mysqli_close( $nConexion ) ;
    $Registro     = mysqli_fetch_array( $Resultado );
?>
    <!-- Formulario Edición / Eliminación de Faqs -->
    <form method="post" action="menu.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="<? echo $nId ; ?>">
			<input type="hidden" id="txtOrden" name="txtOrden" value="<? echo $Registro["orden"] ; ?>">
      <table>
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>EDITAR OPCIÓN</b></td>
        </tr>
        <tr>
          <td class="tituloNombres">Titulo:</td>
					<td class="contenidoNombres"><input type="text" id="txtTitulo" name="txtTitulo" maxlength="100" size="70" value="<? echo $Registro["titulo"]; ?>"></td>
        </tr>

        <tr>
	  			<td class="tituloNombres">Modulo:</td>
          <td height="222" class="contenidoNombres">
						<table>
							<tr>
								<td><label><input onClick="VerPanel(1)" type="radio" name="opModulo" <? if ( $Registro["modulo"] == "Contenido"  ) echo "checked"; ?> value="Contenido">Contenido</label></td>
								<td><label><input onClick="VerPanel(2)" type="radio" name="opModulo" <? if ( $Registro["modulo"] == "Productos"  ) echo "checked"; ?> value="Productos">Productos</label></td>
								<td><label><input onClick="VerPanel(3)" type="radio" name="opModulo" <? if ( $Registro["modulo"] == "Servicios"  ) echo "checked"; ?> value="Servicios">Servicios</label></td>
								<td><label><input onClick="VerPanel(4)" type="radio" name="opModulo" <? if ( $Registro["modulo"] == "Url"        ) echo "checked"; ?> value="Url">Url</label></td>
							</tr>
						</table><br>
						<div id="DivContenidos" style="visibility:<? if ( $Registro["modulo"] == "Contenido"  ) { echo "visible"; } else { echo "hidden"; } ?>; position:absolute; ">
							<table border="0" cellpadding="0" cellspacing="0">
								<tr><td><strong>Seleccione Contenido:</strong></td></tr>
								<tr>
									<td>
										<select name="lstContenidos" size="10" style="width:450px;">
										<?
										while($row=mysqli_fetch_object($rs_ListaContenidos))
										{
											if ( $Registro["clave"] == $row->clave )
											{
												echo "<option selected title='$row->titulo' value='$row->clave'>$row->titulo</option>\n";
											}
											else
											{
												echo "<option title='$row->titulo' value='$row->clave'>$row->titulo</option>\n";
											}
										}
										?>
										</select>
									</td>
								</tr>
							</table>
						</div>
						<div id="DivProductos" style="visibility:<? if ( $Registro["modulo"] == "Productos"  ) { echo "visible"; } else { echo "hidden"; } ?>; position:absolute;">
							<table border="0" cellpadding="0" cellspacing="0">
								<tr><td><strong>Seleccione Producto:</strong></td></tr>
								<tr>
									<td>
										<select name="lstProductos" size="10" style="width:450px;">
										<?
										while($row=mysqli_fetch_object($rs_ListaProductos))
										{
											if ( $Registro["clave"] == $row->url )
											{
												echo "<option selected title='$row->nombre' value='$row->url'>$row->nombre</option>\n";
											}
											else
											{
												echo "<option title='$row->nombre' value='$row->url'>$row->nombre</option>\n";
											}
										}
										?>
										</select>
									</td>
								</tr>
							</table>
						</div>
						<div id="DivServicios" style="visibility:<? if ( $Registro["modulo"] == "Servicios"  ) { echo "visible"; } else { echo "hidden"; } ?>; position:absolute;">
						<table border="0" cellpadding="0" cellspacing="0">
							<tr><td><strong>Seleccione Servicio:</strong></td></tr>
							<tr>
								<td>
									<select name="lstServicios" size="10" style="width:450px;">
									<?
										while($row=mysqli_fetch_object($rs_ListaServicios))
										{
											if ( $Registro["clave"] == $row->url )
											{
												echo "<option selected title='$row->servicio' value='$row->url'>$row->servicio</option>\n";
											}
											else
											{
												echo "<option title='$row->servicio' value='$row->url'>$row->servicio</option>\n";
											}
											
										}
									?>
									</select>
								</td>
							</tr>
						</table>
						</div>
					
						<div id="DivUrl" style="visibility:<? if ( $Registro["modulo"] == "Url"  ) { echo "visible"; } else { echo "hidden"; } ?>; position:absolute;">
						<table border="0" cellpadding="0" cellspacing="0">
							<tr><td><strong>Escriba la URL:</strong></td></tr>
							<tr>
								<td><input type="text" name="txtUrl" id="txtUrl" value="<? echo $Registro["clave"]; ?>" maxlength="200" style="width:450px;"></td>
							</tr>
						</table>
						</div>
					</td>
        </tr>

				<tr>
					<td class="tituloNombres">Padre:</td>
					<td class="contenidoNombres">
						<select name="cboPadre" style="width:450px;">
						<option value="0" <? if ( $Registro["padre"] == 0 ) { echo "selected"; } ?>>Nivel Superior</option>
						<?
							$Contador = 0;
							while($row=mysqli_fetch_object($rs_ListaPadres))
							{
								if ( $Registro["padre"] == $row->idmenu )
								{
									echo "<option selected value='$row->idmenu'>$row->titulo</option>\n";
								}
								else
								{
									echo "<option value='$row->idmenu'>$row->titulo</option>\n";
								}
							}
						?>
						</select>
					</td>
				</tr>

				<tr>
					<td class="tituloNombres">Abrir en nueva ventana:</td>
					<td class="contenidoNombres"><input type="checkbox" id="chkVentana" name="chkVentana" <? if ( $Registro["nueva_ventana"] == "S" ) { echo "checked"; }?> value="S"></td>
				</tr>
            <tr>
              <td class="tituloNombres">Imagen:</td>
              <td class="contenidoNombres"><input type="file" id="txtImagen" name="txtImagen"></td>
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
                  ?><img src="<? echo $cRutaVerImgMenu . $Registro["imagen"]; ?>"><?
                }
              ?>
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
						?><a href="menu.php?Accion=Eliminar&Id=<? echo $nId ;?>"><img src="../../image/eliminar.gif" border="0" alt="Eliminar Registro." onClick="javascript: return confirm('¿Esta seguro que desea eliminar este registro?')"></a><?
						}
						?>
            <a href="menu_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
          </td>
        </tr>
      </table>
    </form>
<?
  mysqli_free_result( $Resultado );
  }
  ###############################################################################
?>
