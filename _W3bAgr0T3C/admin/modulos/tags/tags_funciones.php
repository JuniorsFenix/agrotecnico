<?php
  ###############################################################################
  # noticias_funciones.php   :  Archivo de funciones modulo Editorial
  # Desarrollo               :  Estilo y Diseño & Informaticactiva
  # Web                      :  http://www.esidi.com
  #                             http://www.informaticactiva.com
  ###############################################################################
 include("../../funciones_generales.php");
  ###############################################################################
  # Nombre        : EditorialFormNuevo
  # Descripción   : Muestra el formulario para ingreso de productos nuevos
  # Parametros    : Ninguno.
  # Desarrollado  : Estilo y Diseño & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function TagsFormNuevo()
  {
?>
    <!-- Formulario Ingreso de Editorial -->
    <form method="post" action="tags.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="0">
      <table width="100%">
        <tr>
          <td colspan="3" align="center" class="tituloFormulario"><b>NUEVA PALABRA/TAG</b></td>
        </tr>
        <tr>
            <td id="append">
		<script type="text/javascript">
		$(document).ready(function() {
			$('.chk_boxes_tag').click(function(){
				var chk = $(this).attr('checked')?true:false;
				$('.chkTag').attr('checked',chk);
			});
			
			$('.chk_boxes_key').click(function(){
				var chk = $(this).attr('checked')?true:false;
				$('.chkKey').attr('checked',chk);
			});
			
			$("#append").on("focus blur", "input[type=text]", function()
			{ $(this).toggleClass("focus"); });
			
			$("#append").on("keyup", ".focus", function (e) {
			   var palabra = $(this).val();
			   var name = $(this).attr('name');
			   $.post('ajax_tags.php', {'palabra':palabra}, function(data) {
			   $("."+name).html(data);
			   });
			});
		});
        </script>
		<script type="text/javascript">
        var index=2;
        
        function nuevoTag(){
            
            $('#append').append('<div class="tags">\
                <div class="tagsIzquierda">\
                    <b>Nombre</b> <INPUT id="txtTitulo" type="text" name="txtTitulo' + index + '" maxLength="100" style="WIDTH: 300px; HEIGHT: 22px"><span class="txtTitulo' + index + '"></span>\
                </div>\
                <div class="tagsDerecha">\
                    <label>\
                    <b>Tag</b> <input type="checkbox" class="chkTag" name="txtTag' + index + '">\
                    </label>\
                </div>\
                <div class="tagsDerecha">\
                    <label>\
                    <b>Keyword</b> <input type="checkbox" class="chkKey" name="txtPalabra' + index + '">\
                    </label>\
                </div>\
                <div class="clear"></div>\
            </div>');
            index+=1;
        }
        </script>
            <div class="tags">
                <div class="tagsIzquierda">
                <a href="#nolink" onclick="nuevoTag();">
                <img src="../../image/add.gif" width="16" height="16" />
                </a>A&ntilde;adir otra palabra
                </div>
                <div class="tagsDerecha">
                    <label>
                    <b>Seleccionar todos</b> <input type="checkbox"  class="chk_boxes_tag">
                    </label>
                </div>
                <div class="tagsDerecha">
                    <label>
                    <b>Seleccionar todos</b> <input type="checkbox"  class="chk_boxes_key">
                    </label>
                </div>
                <div class="clear"></div>
            </div>
            <div class="tags">
                <div class="tagsIzquierda">
                    <b>Nombre</b> <INPUT id="txtTitulo" type="text" name="txtTitulo1" maxLength="100" style="WIDTH: 300px; HEIGHT: 22px"><span class="txtTitulo1"></span>
                </div>
                <div class="tagsDerecha">
                    <label>
                    <b>Tag</b> <input type="checkbox" class="chkTag" name="txtTag1">
                    </label>
                </div>
                <div class="tagsDerecha">
                    <label>
                    <b>Keyword</b> <input type="checkbox" class="chkKey" name="txtPalabra1">
                    </label>
                </div>
                <div class="clear"></div>
            </div>
            </td>
        </tr>
        <tr>
          <td colspan="3" class="tituloFormulario" style="text-align:left"></td>
        </tr>
        <tr>
          <td colspan="3"  class="nuevo">
            <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
            <a href="tags_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
          </td>
        </tr>
      </table>
    </form>
<?
  }
  ###############################################################################

  ###############################################################################
  # Nombre        : EditorialGuardar
  # Descripción   : Adiciona un nuevo registro o actualiza uno existente
  # Parametros    : $nId (Si el Cero Nuevo Registro, de lo contrario Actualizar un Registro)
  #                 $nIdCategoria, $cProducto, $cDetalle, $nPrecio, $cImagen
  # Desarrollado  : Estilo y Diseño & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function TagsGuardar( $d )
  {
		$IdCiudad = $_SESSION["IdCiudad"];
		setlocale(LC_ALL, 'en_US.UTF8');
    $nConexion = Conectar();
	mysqli_set_charset($nConexion,'utf8');
    if ( $d["txtId"] <= 0 ) // Nuevo Registro
    {
		for($i=1;$i<=40;$i++){
			    
			if( isset( $d["txtTitulo{$i}"] ) && $d["txtTitulo{$i}"]!="" ) {
				
				$nombre =  $d["txtTitulo{$i}"];
				$url = slug($nombre);
				if(isset($d["txtTag{$i}"])){
				  $tag = 1;
				}
				else{
				  $tag = 0;
				}
				if(isset($d["txtPalabra{$i}"])){
				  $palabra = 1;
				}
				else{
				  $palabra = 0;
				}

			  mysqli_query($nConexion,"INSERT INTO tbltags_palabras ( nombre,url,tag,keyword,idciudad ) VALUES ('$nombre','$url','$tag','$palabra',$IdCiudad )");
					Log_System( "TAGS" , "NUEVO" , "TITULO: " . $cTitulo  );
			}
		}
      mysqli_close($nConexion);
	  Mensaje( "El registro ha sido almacenado correctamente.", "tags_listar.php" ) ;
	  exit;
    }
    else // Actualizar Registro Existente
    {
		$nombre =  $d["txtTitulo"];
		$url = slug($d["txtTitulo"]);
		if(isset($d["txtTag"])){
		  $tag = 1;
		}
		else{
		  $tag = 0;
		}
		if(isset($d["txtPalabra"])){
		  $palabra = 1;
		}
		else{
		  $palabra = 0;
		}
        mysqli_query($nConexion, "UPDATE tbltags_palabras SET nombre = '$nombre',url = '$url',tag = '$tag',keyword = '$palabra' WHERE idpalabra = {$d["txtId"]}" );
				Log_System( "TAGS" , "EDITA" , "TITULO: " . $d["txtTitulo"]  );
      mysqli_close( $nConexion );
      Mensaje( "El registro ha sido actualizado correctamente.", "tags_listar.php" ) ;
      exit;
    }
  } // FIN: function 
  ###############################################################################

  ###############################################################################
  # Nombre        : EditorialEliminar
  # Descripción   : Eliminar un registro 
  # Parametros    : $nId
  # Desarrollado  : Estilo y Diseño & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function TagsEliminar( $nId )
  {
    $nConexion = Conectar();
	mysqli_set_charset($nConexion,'utf8');
		$reg = mysqli_fetch_object( mysqli_query($nConexion,"SELECT nombre FROM tbltags_palabras WHERE idpalabra ='$nId'") );
    mysqli_query($nConexion, "DELETE FROM tbltags_palabras WHERE idpalabra ='$nId'" );
		Log_System( "TAGS" , "ELIMINA" , "TITULO: " . $reg->nombre  );
    mysqli_close( $nConexion );
    Mensaje( "El registro ha sido eliminado correctamente.","tags_listar.php" );
    exit();
  } // FIN: function UsuariosGuardar
  ###############################################################################

  ###############################################################################
  # Nombre        : EditorialFormEditar
  # Descripción   : Muestra el formulario para editar o eliminar registros
  # Parametros    : $nId = ID de registro que se debe mostrar el en formulario
  # Desarrollado  : Estilo y Diseño & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function TagsFormEditar( $nId )
  {
	include("../../vargenerales.php");
    $nConexion    = Conectar();
	mysqli_set_charset($nConexion,'utf8');
    $Resultado    = mysqli_query($nConexion, "SELECT * FROM tbltags_palabras WHERE idpalabra = '$nId'" ) ;
    mysqli_close( $nConexion ) ;

    $Registro     = mysqli_fetch_array( $Resultado );
?>
    <!-- Formulario Edición / Eliminación de Editorial -->
    <form method="post" action="tags.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="<? echo $nId ; ?>">
      <table width="100%">
        <tr>
          <td colspan="3" align="center" class="tituloFormulario"><b>NUEVA PALABRA/TAG</b></td>
        </tr>
        <tr>
        <td>
            <div class="tags">
                <div class="tagsIzquierda">
                    <b>Nombre</b> <INPUT id="txtTitulo" type="text" name="txtTitulo" value="<? echo $Registro["nombre"]; ?>" maxLength="100" style="WIDTH: 300px; HEIGHT: 22px">
                </div>
                <div class="tagsDerecha">
                    <label>
                    <b>Tag</b> <input type="checkbox" name="txtTag" <? if ( $Registro["tag"] == "1" ) echo "checked" ?>>
                    </label>
                </div>
                <div class="tagsDerecha">
                    <label>
                    <b>Keyword</b> <input type="checkbox" name="txtPalabra" <? if ( $Registro["keyword"] == "1" ) echo "checked" ?>>
                    </label>
                </div>
                <div class="clear"></div>
            </div>
            </td>
        </tr>
        <tr>
          <td colspan="3" class="tituloFormulario">&nbsp;</td>
        </tr>

        <tr>
          <td colspan="2" class="nuevo">
            <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
						<?
						if ( Perfil() != "3" )
						{
						?><a href="tags.php?Accion=Eliminar&Id=<? echo $nId ;?>"><img src="../../image/eliminar.gif" border="0" alt="Eliminar Registro." onClick="javascript: return confirm('¿Esta seguro que desea eliminar este registro?')"></a><?
						}
						?>
            <a href="tags_listar.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
          </td>
        </tr>
      </table>
    </form>
<?
  mysqli_free_result( $Resultado );
  }
  ###############################################################################
?>
