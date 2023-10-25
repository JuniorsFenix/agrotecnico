<?
  ###############################################################################
  # productos_funciones.php  :  Archivo de funciones modulo productos / servicios
  # Desarrollo               :  Estilo y Dise�o & Informaticactiva
  # Web                      :  http://www.esidi.com
  #                             http://www.informaticactiva.com
  ###############################################################################
?>
<? include("../../funciones_generales.php"); ?>
<?
  ###############################################################################
  # Nombre        : ProductosFormNuevo
  # Descripci�n   : Muestra el formulario para ingreso de productos nuevos
  # Parametros    : Ninguno.
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function ProductosOpcionesFormNuevo()
  {
		$IdCiudad = $_SESSION["IdCiudad"];
		$IdPlus		= $_GET["idplus"];
		$NomPlus	= $_GET["nomplus"];
?>
    <form method="post" action="productos_opciones.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="0">
			<input type="hidden" id="idplus" name="idplus" value="<?=$IdPlus;?>">
			<input type="hidden" id="nomplus" name="nomplus" value="<?=$NomPlus;?>">
      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>NUEVA OPCION - <?=strtoupper($NomPlus);?></b></td>
        </tr>
        <tr>
          <td class="tituloNombres">Titulo:</td>
          <td class="contenidoNombres"><INPUT id="txtTitulo" type="text" name="txtTitulo" maxLength="50" style="WIDTH: 300px; HEIGHT: 22px"></td>
        </tr>
        <tr>
          <td class="tituloNombres">Precio:</td>
          <td class="contenidoNombres"><INPUT id="txtPrecio" type="text" name="txtPrecio" maxLength="50" style="WIDTH: 100px; HEIGHT: 22px"></td>
        </tr>
					<tr>
						<td colspan="2" class="tituloFormulario">&nbsp;</td>
					</tr>
					<tr>
						<td colspan="2" class="nuevo">
							<input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
							<a href="productos_opciones_listar.php?Id=<?=$IdPlus;?>&nom=<?=$NomPlus;?>"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
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
  # Nombre        : ProductosGuardar
  # Descripci�n   : Adiciona un nuevo registro o actualiza uno existente
  # Parametros    : $nId (Si el Cero Nuevo Registro, de lo contrario Actualizar un Registro)
  #                 $nIdCategoria, $cProducto, $cDetalle, $nPrecio, $cImagen
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function ProductosOpcionesGuardar( $nId,$IdPlus,$cTitulo,$Precio,$cNomPlus )
  {
		$IdCiudad = $_SESSION["IdCiudad"];
    $nConexion = Conectar();
    if ( $nId <= 0 ) // Nuevo Registro
    {
			// Calculo Orden Mayor y Sumo UNO
			$rs_Orden =  mysqli_query($nConexion,"SELECT MAX(orden)+1 AS nuevo_orden FROM tblproductosopciones WHERE (idplus = $IdPlus) and (idciudad = $IdCiudad)");
			$Reg_Orden = mysqli_fetch_object($rs_Orden);
			if ( $Reg_Orden->nuevo_orden == null ){
				$nOrden = 1;
			}else{
				$nOrden = $Reg_Orden->nuevo_orden;
			}
			mysqli_free_result($rs_Orden);
      mysqli_query($nConexion,"INSERT INTO tblproductosopciones ( idplus,titulo,precio,orden,idciudad ) VALUES ( '$IdPlus','$cTitulo','$Precio',$nOrden,$IdCiudad )");
			Log_System( "OPCIONES PRODUCTOS" , "NUEVO" , "OPCION: " . $titulo );
      mysqli_close($nConexion);
      Mensaje( "El registro ha sido almacenado correctamente.", "productos_opciones_listar.php?Id=$IdPlus&nom=$cNomPlus" ) ;
      exit;
    }
    else // Actualizar Registro Existente
    {
			$cTxtSQLUpdate		= "UPDATE tblproductosopciones SET titulo = '$cTitulo',precio = '$Precio' WHERE idopcion = '$nId'";
			mysqli_query($nConexion,$cTxtSQLUpdate  );
			Log_System( "OPCIONES PRODUCTOS" , "EDITA" , "OPCION: " . $cTitulo );
			mysqli_close( $nConexion );
			Mensaje( "El registro ha sido actualizado correctamente.", "productos_opciones_listar.php?Id=$IdPlus&nom=$cNomPlus" ) ;
			exit;
    }
  } // FIN: function UsuariosGuardar
  ###############################################################################
?>
<?
  ###############################################################################
  # Nombre        : ProductosEliminar
  # Descripci�n   : Eliminar un registro 
  # Parametros    : $nId
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function ProductosOpcionesEliminar( $nId , $nIdPlus , $cNomPlus )
  {
    $nConexion = Conectar();
		$reg = mysqli_fetch_object( mysqli_query($nConexion,"SELECT titulo FROM tblproductosopciones WHERE idopcion ='$nId'") );
		mysqli_query($nConexion, "DELETE FROM tblproductosopciones WHERE idopcion ='$nId'" );
		Log_System( "OPCIONES PRODUCTOS" , "ELIMINA" , "OPCION: " . $reg->titulo);
    mysqli_close( $nConexion );
    Mensaje( "El registro ha sido eliminado correctamente.","productos_opciones_listar.php?Id=$nIdPlus&nom=$cNomPlus" );
    exit();
  } // FIN: function UsuariosGuardar
  ###############################################################################
?>
<?
  ###############################################################################
  # Nombre        : ProductosFormEditar
  # Descripci�n   : Muestra el formulario para editar o eliminar registros
  # Parametros    : $nId = ID de registro que se debe mostrar el en formulario
  # Desarrollado  : Estilo y Dise�o & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function ProductosOpcionesFormEditar( $nId , $nIdPlus , $cNomPlus )
  {
		$IdCiudad = $_SESSION["IdCiudad"];
		$RelacionOP_Productos = "S";
		include("../../vargenerales.php");
    $nConexion    	= Conectar();
		$Resultado			= mysqli_query($nConexion, "SELECT * FROM tblproductosopciones WHERE idopcion = '$nId'" ) ;
    mysqli_close( $nConexion ) ;
    $Registro     = mysqli_fetch_array( $Resultado );
?>
    <!-- Formulario Edici�n / Eliminaci�n de Productos -->
    <form method="post" action="productos_opciones.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId"		name="txtId" 		value="<? echo $nId ; ?>">
			<input TYPE="hidden" id="idplus"	name="idplus" 	value="<? echo $nIdPlus ; ?>">
			<input TYPE="hidden" id="nomplus" name="nomplus"	value="<? echo $cNomPlus ; ?>">
      <table width="100%">
        <tr>
          <td colspan="2" align="center" class="tituloFormulario"><b>EDITAR OPCION</b></td>
        </tr>
        <tr>
          <td class="tituloNombres">Titulo:</td>
          <td class="contenidoNombres"><INPUT id="txtTitulo" type="text" name="txtTitulo" maxLength="50" value="<? echo $Registro["titulo"]; ?>" style="WIDTH: 300px; HEIGHT: 22px"></td>
        </tr>
        <tr>
          <td class="tituloNombres">Precio:</td>
          <td class="contenidoNombres"><INPUT id="txtPrecio" type="text" name="txtPrecio" maxLength="50" value="<? echo $Registro["precio"]; ?>" style="WIDTH: 100px; HEIGHT: 22px"></td>
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
							?><a href="productos_opciones.php?Accion=Eliminar&Id=<? echo $nId ;?>&idplus=<?=$nIdPlus;?>&nom=<?=$cNomPlus;?>"><img src="../../image/eliminar.gif" border="0" alt="Eliminar Registro." onClick="javascript: return confirm('�Esta seguro que desea eliminar este registro?')"></a><?
						}
						?>
						<a href="productos_opciones_listar.php?Id=<?=$nIdPlus;?>&nom=<?=$cNomPlus;?>"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
          </td>
        </tr>
      </table>
    </form>
<?
  mysqli_free_result( $Resultado );
  }
###############################################################################
	function OpcionesMover( $cDonde, $nIdOpcion, $nOrdenActual , $IdPlus )
	{
		$nConexion    = Conectar();
		
		if ( $cDonde == "Abajo" )
		{
			$NuevoOrden = $nOrdenActual + 1;
			$rs 				= mysqli_query($nConexion, "SELECT * FROM tblproductosopciones WHERE orden > $nOrdenActual AND idplus = $IdPlus ORDER BY orden LIMIT 1"  );
			$Reg_rs			= mysqli_fetch_object( $rs );
			mysqli_free_result( $rs );
			$nId				= $Reg_rs->idopcion;
			mysqli_query($nConexion, "UPDATE tblproductosopciones SET orden = $nOrdenActual WHERE idopcion = $nId"  );
			mysqli_query($nConexion, "UPDATE tblproductosopciones SET orden = $NuevoOrden WHERE idopcion = $nIdOpcion"  );
		}
		
		if ( $cDonde == "Arriba" )
		{
			$NuevoOrden = $nOrdenActual - 1;
			$rs 				= mysqli_query($nConexion, "SELECT * FROM tblproductosopciones WHERE orden < $nOrdenActual AND idplus = $IdPlus ORDER BY orden DESC LIMIT 1"  );
			$Reg_rs			= mysqli_fetch_object( $rs );
			mysqli_free_result( $rs );
			$nId				= $Reg_rs->idopcion;
			mysqli_query($nConexion, "UPDATE tblproductosopciones SET orden = $nOrdenActual WHERE idopcion = $nId"  );
			mysqli_query($nConexion, "UPDATE tblproductosopciones SET orden = $NuevoOrden WHERE idopcion = $nIdOpcion"  );
		}
		mysqli_close( $nConexion );
	}
?>