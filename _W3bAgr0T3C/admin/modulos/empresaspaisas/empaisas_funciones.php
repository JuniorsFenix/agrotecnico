<?

  ###############################################################################

  # empaisas_funciones.php      :  Archivo de funciones modulo Empresas Paisas

  # Desarrollo               :  Estilo y Dise�o

  # Web                      :  http://www.esidi.com

  ###############################################################################

?>

<?

   include("../../funciones_generales.php"); 

   include("../../vargenerales.php");

   require_once '../../herramientas/FCKeditor/fckeditor.php';

?>

<?

  ###############################################################################

  # Nombre        : EmpaisasFormNuevo

  # Descripci�n   : Muestra el formulario para ingreso de productos nuevos

  # Parametros    : Ninguno.

  # Desarrollado  : Estilo y Dise�o

  # Retorno       : Ninguno

  ###############################################################################

  function EmpaisasFormNuevo()

  {

      //$editor_txtContenido = new FCKeditor("txtcomentario");

      $IdCiudad = $_SESSION["IdCiudad"];

?>

    <!-- Formulario Ingreso de Bienes Ra�ces -->

    <form method="post" name="main" action="empaisas.php?Accion=Guardar" enctype="multipart/form-data">

      <input TYPE="hidden" id="txtId" name="txtId" value="0">

      <table width="100%">

        <tr>

          <td colspan="2" align="center" class="tituloFormulario"><b>NUEVA EMPRESA PAISA</b></td>

        </tr>

        <tr>

          <td class="tituloNombres">Empresa:</td>

          <td class="contenidoNombres"><select name="id_nombempaisa" id="id_nombempaisa" onchange="incluir(this.form.id_nombempaisa[selectedIndex].value);">

	<option value="">Seleccione Empresa...</option>



            <?

			$nConexion = Conectar();

			$sql_padre="select * from tblnombempaisa order by nombempaisa asc"; 

			$sql_hija="select * from tblsucempaisa order by id_nombempaisa,nombresucempaisa asc";

            $query=mysqli_query($nConexion,$sql_padre);

			while($row=mysqli_fetch_array($query)){

                echo "<option value=".$row["id_nombempaisa"].">".$row["id_nombempaisa"]." ".$row["nombempaisa"]."</option>";

	        }

			?>	

			   

	  <!--         <input TYPE="hidden" id="Nomempresa" name="Nomempresa" value="<? //echo $row["nombempaisa"]; ?>">	  -->

			<?			 

            ?>

          </select>

		  </td>

        </tr>

		        <tr>

          <td class="tituloNombres">Sucursal:</td>

          <td class="contenidoNombres">		  

		  <select name="sub" id="sub">

          </select>

		  </td>

<script lang="jscript"> 

function valores(campo1,campo2){ 

    this.campo1=campo1; 

    this.campo2=campo2; 

} 

<? 

$query_s=mysqli_query($nConexion,$sql_hija); 

$indice=0; 

$id_nombempaisa=0; 

while($row=mysqli_fetch_array($query_s)){ 

    if($id_nombempaisa!=$row["id_nombempaisa"]){ 

        $indice=0; 

        $id_nombempaisa=$row["id_nombempaisa"]; 

        echo "var mimatriz".$id_nombempaisa."= new Array();\n"; 

    } 

    echo "mimatriz".$id_nombempaisa."[".$indice."]=new valores('".$row["nombresucempaisa"]."','".$row["nombresucempaisa"]."');\n";

	$indice++;

} 

?> 

var i; 

function incluir(array){ 

    clear(); 

    array=eval("mimatriz" + array); 

    for(i=0; i<array.length; i++){ 

        var objeto=new Option(array[i].campo1, array[i].campo2); 

        main.sub.options[i]=objeto; 

    } 

    main.sub.disabled=false; 

    main.sub.focus(); 

}

function clear(){ 

    main.sub.length=0; 

} 

main.sub.disabled=true; 

</script>

          



        </tr>

		  <tr>

          <td class="tituloNombres">Categoria:</td>

          <td class="contenidoNombres"><span class="texto">

            <select name="Categoria" id="Categoria">

              <?

            $nConexion = Conectar();

            $ResultadoCat = mysqli_query($nConexion, "SELECT * FROM tblcategempaisa ORDER BY nombrecategoria" );

            mysqli_close($nConexion);

						$nContador = 0;

            while($Registros=mysqli_fetch_object($ResultadoCat))

            {

							$nContador = $nContador + 1;

							if ( $nContador == 1 )

              {

								?>

              <option selected value="<? echo $Registros->nombrecategoria; ?>"><? echo $Registros->id_categoria . "&nbsp;" . $Registros->nombrecategoria ; ?></option>

              <?

							}

							else

							{

								?>

              <option value="<? echo $Registros->nombrecategoria; ?>"><? echo $Registros->id_categoria . "&nbsp;" . $Registros->nombrecategoria ; ?></option>

              <?

							}

						}

            mysqli_free_result($ResultadoCat);

            ?>

            </select>

          </span></td>

        </tr>

        <tr>

          <td colspan="2" class="tituloNombres">Descripcion:</td>

          <!--<td class="contenidoNombres"><textarea rows="20" id="txtNoticia" name="txtNoticia" cols="80"></textarea></td>-->

        </tr>

			</table>

					<?

						/*$oFCKeditor = new FCKeditor('txtDescripcion') ;

						$oFCKeditor->BasePath = '../../herramientas/FCKeditor/';

						$oFCKeditor->Create() ;

						$oFCKeditor->Width  = '100%' ;

						$oFCKeditor->Height = '400' ;*/

					?>
                    <textarea name="txtDescripcion"></textarea>
                    <script>
                        CKEDITOR.replace( 'txtDescripcion' );
                    </script>

			<table width="100%">		

		  <tr>

          <td class="tituloNombres">Precio M�nimo:</td>

          <td class="contenidoNombres"><INPUT id="txtPreciomin" type="text" name="txtPreciomin" maxLength="100" style="WIDTH: 100px; HEIGHT: 22px"></td>

        </tr>

		  <tr>

          <td class="tituloNombres">Precio M�ximo:</td>

          <td class="contenidoNombres"><INPUT id="txtPreciomax" type="text" name="txtPreciomax" maxLength="100" style="WIDTH: 100px; HEIGHT: 22px"></td>

        </tr>

		  <tr>

          <td class="tituloNombres">Direcci�n:</td>

          <td class="contenidoNombres"><INPUT id="txtDireccion" type="text" name="txtDireccion" maxLength="100" style="WIDTH: 300px; HEIGHT: 22px"></td>

        </tr>					

		    <tr>

          <td class="tituloNombres">Telefono:</td>

          <td class="contenidoNombres"><INPUT id="txtTelefono" type="text" name="txtTelefono" maxLength="100" style="WIDTH: 150px; HEIGHT: 22px"></td>

        </tr>

	        <tr>

          <td class="tituloNombres">E-mail:</td>

          <td class="contenidoNombres"><INPUT id="txtEmail" type="text" name="txtEmail" maxLength="100" style="WIDTH: 300px; HEIGHT: 22px"></td>

        </tr>

		    <tr>

          <td class="tituloNombres">URL:</td>

          <td class="contenidoNombres"><INPUT id="txtUrl" type="text" name="txtUrl" maxLength="100" style="WIDTH: 300px; HEIGHT: 22px"></td>

        </tr>

			<tr>

          <td class="tituloNombres">Ciudad:</td>

          <td class="contenidoNombres"><INPUT id="txtCiudad" type="text" name="txtCiudad" maxLength="100" style="WIDTH: 150px; HEIGHT: 22px"></td>

        </tr>

		    <tr>

          <td class="tituloNombres">Pa�s:</td>

          <td class="contenidoNombres"><INPUT id="txtPais" type="text" name="txtPais" maxLength="100" style="WIDTH: 150px; HEIGHT: 22px"></td>

        </tr>			



	  </table>



			<table width="100%">

        <tr>

          <td class="tituloNombres">Imagen / Logo:</td>

          <td class="contenidoNombres"><input type="file" id="txtImagen[]" name="txtImagen[]"></td>

        </tr>

			<?

			if ( Perfil() == "3" )

			{

			?><input type="hidden" name="optPublicar" id="optPublicar" value="N"><?

			}

			else

			{

			?>

			<?

			}

			?>

        <tr>

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

        </tr>

        <tr>

          <td colspan="2"  class="nuevo">

            <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">

            <a href="empaisas_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>

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

  # Nombre        : EmpaisasGuardar

  # Descripci�n   : Adiciona un nuevo registro o actualiza uno existente

  # Parametros    : $nId (Si es Cero Nuevo Registro, de lo contrario Actualizar un Registro)

  #                 $nId, $cdepto, $cmunicipio, $cagencia, $cnombre, $cedad, $cestatura, 			  

  #					$cpeso, $cojos, $ccabello, $cpiel, $ccamisa, $cpantalon, $ccalzado, 

  #                 $cpasarela, $cfotografia, $cprotocolo, $cropainterior, $cropaexterior, 

  #                 $ctrajedebanio, $cPublicar

  # Desarrollado  : Estilo y Dise�o

  # Retorno       : Ninguno

  ###############################################################################

  function EmpaisasGuardar( $nId,$cEmpresa,$cSucursal,$cCategoria,$cDescripcion,$cPreciomin,$cPreciomax,$cDireccion,$cTelefono,$cEmail,$cUrl,$cCiudad,$cPais,$cImagen,$cPublicar)

  {

	$IdCiudad = $_SESSION["IdCiudad"];

    $nConexion = Conectar();



    if ( $nId <= 0 ) // Nuevo Registro

    {

      mysqli_query($nConexion,"INSERT INTO tblempresaspaisas ( nomempresa,sucursal,categoria,descripcion,preciomin,preciomax,direccion,telefono,email,url,ciudad,pais,imagen,publicar) VALUES ( '$cEmpresa','$cSucursal','$cCategoria','$cDescripcion','$cPreciomin','$cPreciomax','$cDireccion','$cTelefono','$cEmail','$cUrl','$cCiudad','$cPais','$cImagen','$cPublicar')");

	  

	  Log_System( "EMPRESASPAISAS" , "NUEVO" , "EMPRESA: " . $cEmpresa );

      mysqli_close($nConexion);

      Mensaje( "El registro ha sido almacenado correctamente.", "empaisas_listar.php" ) ;

      exit;

    }

    else // Actualizar Registro Existente

    {

      if ( !empty($cImagen) )

      {

        mysqli_query($nConexion, "UPDATE tblempresaspaisas SET nomempresa = '$cEmpresa',sucursal = '$cSucursal',categoria = '$cCategoria',descripcion = '$cDescripcion',preciomin = '$cPreciomin',preciomax = '$cPreciomax',direccion = '$cDireccion',telefono = '$cTelefono',email = '$cEmail',url = '$cUrl',ciudad = '$cCiudad',pais = '$cPais',imagen = '$cImagen',publicar = '$cPublicar' WHERE idempresapaisa = '$nId'" );

      }

      else

      {

        mysqli_query($nConexion, "UPDATE tblempresaspaisas SET nomempresa = '$cEmpresa',sucursal = '$cSucursal',categoria = '$cCategoria',descripcion = '$cDescripcion',preciomin = '$cPreciomin',preciomax = '$cPreciomax',direccion = '$cDireccion',telefono = '$cTelefono',email = '$cEmail',url = '$cUrl',ciudad = '$cCiudad',pais = '$cPais',publicar = '$cPublicar' WHERE idempresapaisa = '$nId'" );

      }

	  Log_System( "EMPRESASPAISAS" , "EDITA" , "EMPRESA: " . $cEmpresa );

      mysqli_close( $nConexion );

      Mensaje( "El registro ha sido actualizado correctamente.", "empaisas_listar.php" ) ;

      exit;

    }

  } // FIN: function 

  ###############################################################################

?>

<?

  ###############################################################################

  # Nombre        : EmpaisasEliminar

  # Descripci�n   : Eliminar un registro 

  # Parametros    : $nId

  # Desarrollado  : Estilo y Dise�o

  # Retorno       : Ninguno

  ###############################################################################

  function EmpaisasEliminar( $nId )

  {

    $nConexion = Conectar();

	$reg = mysqli_fetch_object( mysqli_query($nConexion,"SELECT * FROM tblempresaspaisas WHERE idempresapaisa ='$nId'") );

    mysqli_query($nConexion, "DELETE FROM tblempresaspaisas WHERE idempresapaisa ='$nId'" ) ;

	Log_System( "EMPRESASPAISAS" , "ELIMINA" , "EMPRESA: " . $reg->nomempresa  );

    mysqli_close( $nConexion );

    Mensaje( "El registro ha sido eliminado correctamente.","empaisas_listar.php" );

    exit();

  } // FIN: function EmpaisasEliminar

  ###############################################################################

?>

<?

  ###############################################################################

  # Nombre        : EmpaisasFormEditar

  # Descripci�n   : Muestra el formulario para editar o eliminar registros

  # Parametros    : $nId = ID de registro que se debe mostrar el en formulario

  # Desarrollado  : Estilo y Dise�o

  # Retorno       : Ninguno

  ###############################################################################

  function EmpaisasFormEditar( $nId )

  {

	include("../../vargenerales.php");

    $nConexion = Conectar();

    $Resultado = mysqli_query($nConexion, "SELECT * FROM tblempresaspaisas WHERE idempresapaisa = '$nId'" ) ;

    //mysqli_close( $nConexion ) ;

	$Registro = mysqli_fetch_array( $Resultado );

	$idsucu=$Registro["sucursal"];

	$Resultado2 = mysqli_query($nConexion, "SELECT * FROM tblsucempaisa WHERE id_sucempaisa = '$idsucu'" ) ;

    $Registro2 = mysqli_fetch_array( $Resultado2 );

	$nomsucu=$Registro2["nombresucempaisa"];

	mysqli_close( $nConexion ) ;

	

?>

    <!-- Formulario Edici�n / Eliminaci�n de Bienes Arrendamientos -->

    <form method="post" name="main" action="empaisas.php?Accion=Guardar" enctype="multipart/form-data">

      <input TYPE="hidden" id="txtId" name="txtId" value="<? echo $nId ; ?>">

      <table width="100%">

        <tr>

          <td colspan="2" align="center" class="tituloFormulario"><b>MODIFICAR EMPRESAS PAISAS</b></td>

        </tr>

        <tr>

          <td class="tituloNombres">Empresa:</td>

		  <td class="contenidoNombres"><select name="id_nombempaisa" id="id_nombempaisa" onchange="incluir(this.form.id_nombempaisa[selectedIndex].value);">

	<option value=""><? echo $Registro["nomempresa"] ; ?></option>

            <?

			$nConexion = Conectar();

			$sql_padre="select * from tblnombempaisa order by nombempaisa asc"; 

			$sql_hija="select * from tblsucempaisa order by id_nombempaisa,nombresucempaisa asc";

            $query=mysqli_query($nConexion,$sql_padre);

			while($row=mysqli_fetch_array($query)){ 

                echo "<option value=".$row["id_nombempaisa"].">".$row["id_nombempaisa"]." ".$row["nombempaisa"]."</option>";



            } 

            ?>

	  <!--         <input TYPE="hidden" id="Nomempresa" name="Nomempresa" value="<? //echo $row["nombempaisa"]; ?>">	  -->

			<?			 

            ?>

          </select>

		  

		  </td>

        </tr>

		        <tr>

          <td class="tituloNombres">Sucursal:</td>

          <td class="contenidoNombres">		  

		  <select name="sub" id="sub">

		  <option value=""><? echo $Registro["sucursal"] ; ?></option>

		  </select></td>

<script lang="jscript"> 

function valores(campo1,campo2){ 

    this.campo1=campo1; 

    this.campo2=campo2; 

} 

<? 

$query_s=mysqli_query($nConexion,$sql_hija); 

$indice=0; 

$id_depto=0; 

while($row=mysqli_fetch_array($query_s)){ 

    if($id_nombempaisa!=$row["id_nombempaisa"]){ 

        $indice=0; 

        $id_nombempaisa=$row["id_nombempaisa"]; 

        echo "var mimatriz".$id_nombempaisa."= new Array();\n"; 

    } 

    echo "mimatriz".$id_nombempaisa."[".$indice."]=new valores('".$row["nombresucempaisa"]."','".$row["nombresucempaisa"]."');\n";

	$indice++;

} 

?> 

var i; 

function incluir(array){ 

    clear(); 

    array=eval("mimatriz" + array); 

    for(i=0; i<array.length; i++){ 

        var objeto=new Option(array[i].campo1, array[i].campo2); 

        main.sub.options[i]=objeto; 

    } 

    main.sub.disabled=false; 

    main.sub.focus(); 

} 

function clear(){ 

    main.sub.length=0; 

} 

main.sub.disabled=true; 

</script>

          		  

		  <tr>

          <td class="tituloNombres">Categoria:</td>

          <td class="contenidoNombres"><select name="Categoria" id="Categoria">

            <?

            $nConexion = Conectar();

            $ResultadoCat = mysqli_query($nConexion, "SELECT * FROM tblcategempaisa ORDER BY nombrecategoria" );

            mysqli_close($nConexion);

            while($Registros=mysqli_fetch_object($ResultadoCat))

            {

							if ( $Registro["categoria"] == $Registros->nombrecategoria )

              {

								?>

            <option selected value="<? echo $Registros->nombrecategoria; ?>"><? echo $Registros->id_categoria . "&nbsp;" . $Registros->nombrecategoria ; ?></option>

            <?

							}

							else

							{

								?>

            <option value="<? echo $Registros->nombrecategoria; ?>"><? echo $Registros->id_categoria . "&nbsp;" . $Registros->nombrecategoria ; ?></option>

            <?

							}

						}

            mysqli_free_result($ResultadoCat);

            ?>

          </select></td>

		  </tr>

        <tr>

          <td colspan="2" class="tituloNombres">Descripcion:</td>

          <!--<td class="contenidoNombres"><textarea rows="20" id="txtNoticia" name="txtNoticia" cols="80"></textarea></td>-->

        </tr>

	  </table>

					<?

						/*$oFCKeditor = new FCKeditor('txtDescripcion') ;

						$oFCKeditor->BasePath = '../../herramientas/FCKeditor/';

						$oFCKeditor->Value = $Registro["descripcion"];

						$oFCKeditor->Create() ;

						$oFCKeditor->Width  = '100%' ;

						$oFCKeditor->Height = '400' ;*/

					?>
        <textarea name="txtDescripcion"><? echo $Registro["txtDescripcion"]?></textarea>
        <script>
            CKEDITOR.replace( 'txtDescripcion' );
        </script>

			<table width="100%"> 

		<tr>

          <td class="tituloNombres">Precio M�nimo:</td>

          <td class="contenidoNombres"><INPUT id="txtPreciomin" type="text" name="txtPreciomin" maxLength="100" style="WIDTH: 100px; HEIGHT: 22px" value="<? echo $Registro["preciomin"]; ?>"></td>

        </tr>

		  <tr>

          <td class="tituloNombres">Precio M�ximo:</td>

          <td class="contenidoNombres"><INPUT id="txtPreciomax" type="text" name="txtPreciomax" maxLength="100" style="WIDTH: 100px; HEIGHT: 22px" value="<? echo $Registro["preciomax"]; ?>"></td>

        </tr>

		  <tr>

          <td class="tituloNombres">Direcci�n:</td>

          <td class="contenidoNombres"><INPUT id="txtDireccion" type="text" name="txtDireccion" maxLength="100" style="WIDTH: 300px; HEIGHT: 22px" value="<? echo $Registro["direccion"]; ?>"></td>

        </tr>					

		    <tr>

          <td class="tituloNombres">Telefono:</td>

          <td class="contenidoNombres"><INPUT id="txtTelefono" type="text" name="txtTelefono" maxLength="100" style="WIDTH: 150px; HEIGHT: 22px" value="<? echo $Registro["telefono"]; ?>"></td>

        </tr>

	        <tr>

          <td class="tituloNombres">E-mail:</td>

          <td class="contenidoNombres"><INPUT id="txtEmail" type="text" name="txtEmail" maxLength="100" style="WIDTH: 300px; HEIGHT: 22px" value="<? echo $Registro["email"]; ?>"></td>

        </tr>

		    <tr>

          <td class="tituloNombres">URL:</td>

          <td class="contenidoNombres"><INPUT id="txtUrl" type="text" name="txtUrl" maxLength="100" style="WIDTH: 300px; HEIGHT: 22px" value="<? echo $Registro["url"]; ?>"></td>

        </tr>

			<tr>

          <td class="tituloNombres">Ciudad:</td>

          <td class="contenidoNombres"><INPUT id="txtCiudad" type="text" name="txtCiudad" maxLength="100" style="WIDTH: 150px; HEIGHT: 22px" value="<? echo $Registro["ciudad"]; ?>"></td>

        </tr>

		    <tr>

          <td class="tituloNombres">Pa�s:</td>

          <td class="contenidoNombres"><INPUT id="txtPais" type="text" name="txtPais" maxLength="100" style="WIDTH: 150px; HEIGHT: 22px" value="<? echo $Registro["pais"]; ?>"></td>

        </tr>	 

        <tr>

          <td width="29%" class="tituloNombres">Imagen / Logo:</td>

          <td width="71%" class="contenidoNombres"><input type="file" id="txtImagen[]" name="txtImagen[]"></td>

        </tr>

		        <tr>

          <td class="tituloNombres">Imagen / Logo Actual:</td>

          <td class="contenidoNombres">

          <?

            if ( empty($Registro["fotomodelo"]) )

            {

              echo "No se asigno una imagen.";

            }

            else

            {

              ?><img src="<? echo $cRutaVerImgEmpaisas . $Registro["imagen"]; ?>"><?

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

							<td><label>

							    <input type="radio" id="radio" name="optPublicar" value="N" <? if ( $Registro["publicar"] == "N" ) echo "checked" ?>>

						    No</label></td>

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

						?><a href="empaisas.php?Accion=Eliminar&Id=<? echo $nId ;?>"><img src="../../image/eliminar.gif" border="0" alt="Eliminar Registro." onClick="javascript: return confirm('�Esta seguro que desea eliminar este registro?')"></a><?

						}

						?>

            <a href="empaisas_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>

          </td>

        </tr>

      </table>

    </form>

<?

  mysqli_free_result( $Resultado );

  }

  ###############################################################################

?>