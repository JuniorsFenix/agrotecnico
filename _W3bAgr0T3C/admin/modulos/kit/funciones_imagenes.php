<?
  ###############################################################################
  # contenidos_funciones.php :  Archivo de funciones modulo
  # Desarrollo               :  Estilo y Diseño - http://www.esidi.com
  # Web                      :  http://www.informaticactiva.com - Oscar Arley Yepes Aristizabal
  ###############################################################################
  require_once("../../funciones_generales.php");
	include("../../vargenerales.php");
	include("../../herramientas/upload/SimpleImage.php");

  ini_set("memory_limit","50M");
  ini_set("upload_max_filesize", "30M");
  ini_set("max_execution_time","180");//3 MINUTOS
  ini_set("post_max_size","30M");
  

  $sexo = array(
    "Hombre",
    "Mujer",
    "Niño",
    "Niña",
    "Unisex"
  );

  function ProductosFormNuevo($IdCategoria){
  	global $sexo;
    $nConexion = Conectar();
  ?>
  
  <link href="../../css/administrador.css" rel="stylesheet" type="text/css">
  <!-- Formulario Ingreso -->
  <form method="post" action="productos.php?Accion=Guardar" enctype="multipart/form-data">
    <input TYPE="hidden" id="IdProducto" name="IdProducto" value="0">
    <table width="100%">
      <tr>
        <td colspan="4" align="center" class="tituloFormulario"><b>NUEVO PRODUCTO</b></td>
      </tr>
      <tr>
        <td class="tituloNombres">Categoria:</td>
        <td class="contenidoNombres" colspan="5">
        <select name="IdCategoria">
        <?php
        $ra =mysqli_query($nConexion,"select * from tblti_categorias where idcategoria<>-1 order by vpath");
        while( $rax=mysqli_fetch_object($ra) ){
          ?><option value="<?=$rax->idcategoria;?>" <?=$rax->idcategoria==$IdCategoria?"selected":"";?> ><?=$rax->vpath;?></option><?
        }
        ?>
        </select>
        </td>
      </tr>
        <tr>
          <td class="tituloNombres">Referencia:</td>
          <td class="contenidoNombres" colspan="5"><INPUT id="txtReferencia" type="text" name="txtReferencia" value="<? echo $Registro["referencia"]; ?>" maxLength="200" style="width:200px; "></td>
        </tr>

      <tr>
        <td class="tituloNombres">Nombre:</td>
        <td class="contenidoNombres" colspan="5"><INPUT id="txtNombre" type="text" name="txtNombre" maxLength="200" style="width:200px; "></td>
      </tr>
      <tr>
        <td class="tituloNombres">Descripcion:</td>
        <td class="contenidoNombres" colspan="5">
            <textarea name="txtDescripcion"></textarea>
            <script>
                CKEDITOR.replace( 'txtDescripcion' );
            </script>
        </td>
      </tr>
      <tr>
        <td class="tituloNombres">Tags: Para seleccionar varios, deje presionado Ctrl y haga click en los que desee seleccionar.</td>
        <td class="contenidoAsoc">
        <?php
        $sql="select url,nombre from tbltags_palabras where tag=1 order by nombre";
        $ra = mysqli_query($nConexion,$sql);
        ?>        
        <select name="txtTags[]" multiple size="20" style="width:100%;" >
        <?php while($rax=mysqli_fetch_assoc($ra)):?>
            <option value="<?=$rax["url"];?>"><?=$rax["nombre"];?></option>
        <?php endwhile;?>
        </select>
        </td>
        <td class="tituloNombres">Palabras Clave: Para seleccionar varios, deje presionado Ctrl y haga click en los que desee seleccionar.</td>
        <td class="contenidoAsoc">
        <?php
        $sql="select idpalabra,nombre from tbltags_palabras where keyword=1 order by nombre";
        $ra = mysqli_query($nConexion,$sql);
        ?>        
        <select name="txtPalabras[]" multiple size="20" style="width:100%;" >
        <?php while($rax=mysqli_fetch_assoc($ra)):?>
            <option value="<?=$rax["nombre"];?>"><?=$rax["nombre"];?></option>
        <?php endwhile;?>
        </select>
        </td>
      </tr>
      <tr>
        <td class="tituloNombres">Inventario:</td>
        <td class="contenidoNombres" colspan="5"><INPUT id="txtIva" type="text" name="txtInventario" value="0" maxLength="200" style="width:200px; "></td>
      </tr>
      <tr>
        <td class="tituloNombres">Inventario Activo:</td>
        <td class="contenidoNombres" colspan="5">
            <select name="txtInventarioActivo">
                <option value="0" >NO</option>
                <option value="1" >SI</option>
            </select>
        </td>
      </tr>      
      <tr>
        <td class="tituloNombres">Iva:</td>
        <td class="contenidoNombres" colspan="5"><INPUT id="txtIva" type="text" name="txtIva" value="0" maxLength="200" style="width:200px; "></td>
      </tr>

      <tr>
        <td class="tituloNombres">Precio:</td>
        <td class="contenidoNombres" colspan="5"><INPUT id="txtPrecio" type="text" name="txtPrecio" value="0" maxLength="200" style="width:200px; "></td>
      </tr>

      <tr>
        <td class="tituloNombres">Precio Anterior: </td>
        <td class="contenidoNombres" colspan="5"><INPUT id="txtPrecioAnt" type="text" name="txtPrecioAnt" value="0" maxLength="200" style="width:200px; "></td>
      </tr>

      <tr>
        <td class="tituloNombres">Peso: </td>
        <td class="contenidoNombres" colspan="5"><INPUT id="txtPeso" type="text" name="txtPeso" value="0" maxLength="200" style="width:200px; "></td>
      </tr>

      <tr>
        <td class="tituloNombres">Volumen: </td>
        <td class="contenidoNombres" colspan="5"><INPUT id="txtVolumen" type="text" name="txtVolumen" value="0" maxLength="200" style="width:200px; "></td>
      </tr>

      <tr>
        <td class="tituloNombres">Activo:</td>
        <td class="contenidoNombres" colspan="5">
        <select name="txtActivo">
        <?php foreach(array(1=>"Si",0=>"No") as $k=>$v):?>
          <option value="<?=$k;?>" ><?=$v;?></option>
        <?php endforeach;?>
        </select>
        </td>
      </tr>
      <tr>
        <td class="tituloNombres">Promoción:</td>
        <td class="contenidoNombres" colspan="5">
        <input type="checkbox" name="txtPromocion" class="txtPromocion">
        </td>
      </tr>
      <tr class="promo" style="display:none;">
      <td class="tituloNombres">Imagen Promoci&oacute;n:</td>
      <td class="contenidoNombres" colspan="5"><input type="file" name="txtImagenPromo" /></td>
      </tr>
		<script type="text/javascript">	
			$(document).ready(function(){
				$('.txtPromocion').change(function(){
					if(this.checked)
						$('.promo').fadeIn('slow');
					else
						$('.promo').fadeOut('slow');
			
				});
			});
		</script>   
      <tr>        
          <td class="tituloNombres">Mas Vendido:</td>        
          <td class="contenidoNombres" colspan="5">        
          <select name="txtMasVendidos">        
          <?php foreach(array(0=>"No",1=>"Si") as $k=>$v):?>          
          <option value="<?=$k;?>"><?=$v;?></option>        
          <?php endforeach;?>        
          </select>        
          </td>      
      </tr>
      <tr>
        <td class="tituloNombres">Tallas(separadas por coma): </td>
        <td class="contenidoNombres" colspan="5"><INPUT id="txtTallas" type="text" name="txtTallas" value="0" maxLength="200" style="width:200px; "></td>
      </tr>
        <tr>
            <td class="tituloNombres">Imágenes:
                <a href="#nolink" onclick="nuevaImagen();">
                <img src="../../image/add.gif" width="16" height="16" />
                </a></td>
        <td class="contenidoNombres" colspan="5">
		<script type="text/javascript">
        var indexImagen=2;
        
        function nuevaImagen(){
            
            $('.files').append('<li><input type="file" name="txtImagen' + indexImagen + '" /><a href="#nolink" id="remove"><img src="../../image/borrar.gif" width="16" height="16" /></a></li>');
            indexImagen+=1;
        }

        $(document).on("click", "#remove", function(){
		   $(this).parent('li').remove();
		});
        </script>
        <ul class="files">
        <li><input type="file" name="txtImagen1" /></li>
        </ul>
        <?php if($_SESSION["UsrPerfil"]==1):?>
        <br/>
        Tama&ntilde;o Grande<input id="txtSize" type="text" name="txtSize" value="1024" maxLength="200" style="width:200px; "><br/>
        Tama&ntilde;o Mediano<input id="txtSizeM" type="text" name="txtSizeM" value="500" maxLength="200" style="width:200px; "><br/>
        Tama&ntilde;o Peque&ntilde;o<input id="txtSizeS" type="text" name="txtSizeS" value="150" maxLength="200" style="width:200px; "><br/>
        <?php endif;?>
        </td>
      </tr>

      <tr>
        <td colspan="4" class="tituloFormulario">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4" class="nuevo">
          <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
          <a href="listar_productos.php?idcategoria=<?=$IdCategoria;?>"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
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
  # Descripción   : Adiciona un nuevo registro o actualiza uno existente a la DB
  # Parametros    : $nId (Si el Cero Nuevo Registro, de lo contrario Actualizar un Registro)
  # Desarrollado  : Estilo y Diseño & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function ProductosGuardar( $d,$files )
  {
	include("../../vargenerales.php");
    //creo el directorio si no existe
    if( !is_dir("../../../fotos/tienda/productos") ){
      @ mkdir("../../../fotos/tienda/productos");
    }
    

    $nConexion = Conectar();
	setlocale(LC_ALL, 'en_US.UTF8');
    $url = slug($d["txtNombre"]);
	if (!empty($d["txtTags"])){
	$tags = implode(',', $d["txtTags"]);
	}
	if (!empty($d["txtPalabras"])){
	$palabras = implode(', ', $d["txtPalabras"]);
	}
	$hombre = isset($d["Hombre"]) ? 1 : 0;
	$mujer = isset($d["Mujer"]) ? 1 : 0;
	$nino = isset($d["Niño"]) ? 1 : 0;
	$nina = isset($d["Niña"]) ? 1 : 0;
	$unisex = isset($d["Unisex"]) ? 1 : 0;
	$promocion = isset($d["txtPromocion"]) ? 1 : 0;
    if ( $d["IdProducto"] == "0" ) // Nuevo Registro
    {
      $sql="insert into tblti_productos
      ( idciudad,idcategoria,nombre,descripcion,idmarca,activo,promocion,precio,tags,palabras,precioant,peso,volumen,iva,masvendidos,referencia,tallas,inventario,url,hombre,mujer,nino,nina,unisex,inventario_activo) values
      ({$_SESSION["IdCiudad"]},'{$d["IdCategoria"]}','{$d["txtNombre"]}','{$d["txtDescripcion"]}','{$d["IdMarca"]}',
      '{$d["txtActivo"]}','{$promocion}','{$d["txtPrecio"]}','$tags','$palabras','{$d["txtPrecioAnt"]}','{$d["txtPeso"]}','{$d["txtVolumen"]}',{$d["txtIva"]},{$d["txtMasVendidos"]},'{$d["txtReferencia"]}','{$d["txtTallas"]}',{$d["txtInventario"]},'{$url}','{$hombre}','{$mujer}','{$nino}','{$nina}','{$unisex}',{$d["txtInventarioActivo"]})";

      @ $r = mysqli_query($nConexion,$sql);
	  
      $d["IdProducto"] = mysqli_insert_id($nConexion);
      
      if( is_array($d["colores_asociados"]) ){
	      foreach($d["colores_asociados"] as $r){
	          $sql="insert into tblti_colores_asociados (idproducto,idproductoa) values ({$d["IdProducto"]},{$r})";
	          mysqli_query($nConexion,$sql);                   
	      }
      }
      
      if( is_array($d["tecnologias_asociadas"]) ){
	      foreach($d["tecnologias_asociadas"] as $r){
	          $sql="insert into tblti_tecnologias_asociadas (idproducto,idproductoa) values ({$d["IdProducto"]},{$r})";
	          mysqli_query($nConexion,$sql);                   
	      }
      }
	  
	  if( isset( $files["txtImagenPromo"]["tmp_name"] ) && $files["txtImagenPromo"]["tmp_name"]!="" ) {
			
				$NomImagen = $d["IdProducto"] . "_" . "promo" . "_" . $files["txtImagenPromo"]["name"];
	
			  $image = new SimpleImage();
			  $image->load($files["txtImagenPromo"]["tmp_name"]);
			  $image->resizeToWidth(500);
			  $image->save($cRutaImagenTienda . $NomImagen);
				
				$sql="update tblti_productos set imagen_promo='{$NomImagen} where idproducto = {$d["IdProducto"]}";
				
      $r = mysqli_query($nConexion,$sql);
	  
	  }

      if(!$r){
        Mensaje( "Fallo almacenando ".mysqli_error($nConexion), "listar_productos.php" ) ;
        exit;
      }


		if(!isset($d["txtSize"])){
			$d["txtSize"]=1024;
		}
		if(!isset($d["txtSizeM"])){
			$d["txtSizeM"]=500;
		}
		if(!isset($d["txtSizeS"])){
			$d["txtSizeS"]=150;
		}

      for($i=1;$i<=20;$i++){
		  $NomImagen="*";
			    
			if( isset( $files["txtImagen{$i}"]["tmp_name"] ) && $files["txtImagen{$i}"]["tmp_name"]!="" ) {
			
				$NomImagenG = $d["IdProducto"] . "_" . $i . "_" . $files["txtImagen{$i}"]["name"];
				$NomImagenM = "m_" . $d["IdProducto"] . "_" . $i . "_" . $files["txtImagen{$i}"]["name"];
				$NomImagenP = "p_" . $d["IdProducto"] . "_" . $i . "_" . $files["txtImagen{$i}"]["name"];
	
			  $image = new SimpleImage();
			  $image->load($files["txtImagen{$i}"]["tmp_name"]);
			  $image->resizeToWidth($d["txtSize"]);
			  $image->save($cRutaImagenTienda . $NomImagenG);
			  $image->resizeToWidth($d["txtSizeM"]);
			  $image->save($cRutaImagenTienda . $NomImagenM);
			  $image->resizeToWidth($d["txtSizeS"]);
			  $image->save($cRutaImagenTienda . $NomImagenP);
				
				$sql="insert into tblti_imagenes (idproducto,imagen) values ('{$d["IdProducto"]}','{$NomImagenG}')";

      $r = mysqli_query($nConexion,$sql);

      
      if(!$r){
        Mensaje( "Fallo actualizando imagenes.".mysqli_error($nConexion), "listar_productos.php?idcategoria={$d["IdCategoria"]}" ) ;
        exit;
      }

      
      
				}        
      }
     mysqli_close($nConexion);
      Mensaje( "El registro ha sido almacenado correctamente.", "listar_productos.php?idcategoria={$d["IdCategoria"]}" ) ;
      exit;
    }
    else // Actualizar Registro Existente
    {

      $sql="update tblti_productos set idciudad={$_SESSION["IdCiudad"]}, nombre='{$d["txtNombre"]}', 
	  descripcion='{$d["txtDescripcion"]}', idmarca='{$d["IdMarca"]}', idcategoria='{$d["IdCategoria"]}', activo='{$d["txtActivo"]}', promocion='{$promocion}', precio='{$d["txtPrecio"]}',
	  tags='$tags',palabras='$palabras', 
	  precioant='{$d["txtPrecioAnt"]}', peso='{$d["txtPeso"]}', volumen='{$d["txtVolumen"]}', 
	  iva={$d["txtIva"]}, masvendidos={$d["txtMasVendidos"]}, referencia='{$d["txtReferencia"]}', 
	  tallas='{$d["txtTallas"]}', inventario={$d["txtInventario"]}, url='{$url}', hombre='{$hombre}', mujer='{$mujer}', nino='{$nino}', nina='{$nina}', unisex='{$unisex}', inventario_activo={$d["txtInventarioActivo"]} where idproducto = {$d["IdProducto"]}";

      $r = mysqli_query($nConexion,$sql);

      if(!$r){
        Mensaje( "Fallo actualizando.".mysqli_error($nConexion), "listar_productos.php" ) ;
        exit;
      }

	for($i=1;$i<=20;$i++){
		  $NomImagen="*";
			    
			if( isset( $files["txtImagen{$i}"]["tmp_name"] ) && $files["txtImagen{$i}"]["tmp_name"]!="" ) {
			
				$NomImagenG = $d["IdProducto"] . "_" . $i . "_" . $files["txtImagen{$i}"]["name"];
				$NomImagenM = "m_" . $d["IdProducto"] . "_" . $i . "_" . $files["txtImagen{$i}"]["name"];
				$NomImagenP = "p_" . $d["IdProducto"] . "_" . $i . "_" . $files["txtImagen{$i}"]["name"];
	
			  $image = new SimpleImage();
			  $image->load($files["txtImagen{$i}"]["tmp_name"]);
			  $image->resizeToWidth($d["txtSize"]);
			  $image->save($cRutaImagenTienda . $NomImagenG);
			  $image->resizeToWidth($d["txtSizeM"]);
			  $image->save($cRutaImagenTienda . $NomImagenM);
			  $image->resizeToWidth($d["txtSizeS"]);
			  $image->save($cRutaImagenTienda . $NomImagenP);
				
				$sql="INSERT into tblti_imagenes (idimagen,idproducto,imagen) values ('{$d["id_{$i}"]}','{$d["IdProducto"]}','{$NomImagenG}') ON DUPLICATE KEY UPDATE idproducto='{$d["IdProducto"]}',imagen='{$NomImagenG}'";

      $r = mysqli_query($nConexion,$sql);

      if(!$r){
        Mensaje( "Fallo actualizando imagenes.".mysqli_error($nConexion), "listar_productos.php?idcategoria={$d["IdCategoria"]}" ) ;
        exit;
      }
	  
      /*mysqli_close($nConexion);
      Mensaje( "El registro ha sido almacenado correctamente.", "listar_productos.php?idcategoria={$d["IdCategoria"]}" ) ;
      exit;*/

				}        
      }
      
      $sql="delete from tblti_productos_asociados where idproducto = {$d["IdProducto"]}";
      mysqli_query($nConexion,$sql);
      
      if( is_array($d["productos_asociados"]) ){
	      foreach($d["productos_asociados"] as $r){
	          $sql="insert into tblti_productos_asociados (idproducto,idproductoa) values ({$d["IdProducto"]},{$r})";
	          mysqli_query($nConexion,$sql);                   
	      }
      }
	  
      $sql="delete from tblti_colores_asociados where idproducto = {$d["IdProducto"]}";
      mysqli_query($nConexion,$sql);
      
      if( is_array($d["colores_asociados"]) ){
	      foreach($d["colores_asociados"] as $r){
	          $sql="insert into tblti_colores_asociados (idproducto,idproductoa) values ({$d["IdProducto"]},{$r})";
	          mysqli_query($nConexion,$sql);                   
	      }
      }
	  
      $sql="delete from tblti_tecnologias_asociadas where idproducto = {$d["IdProducto"]}";
      mysqli_query($nConexion,$sql);
      
      if( is_array($d["tecnologias_asociadas"]) ){
	      foreach($d["tecnologias_asociadas"] as $r){
	          $sql="insert into tblti_tecnologias_asociadas (idproducto,idproductoa) values ({$d["IdProducto"]},{$r})";
	          mysqli_query($nConexion,$sql);                   
	      }
      }
	  if( isset( $files["txtImagenPromo"]["tmp_name"] ) && $files["txtImagenPromo"]["tmp_name"]!="" ) {
			
				$NomImagen = $d["IdProducto"] . "_" . "promo" . "_" . $files["txtImagenPromo"]["name"];
	
			  $image = new SimpleImage();
			  $image->load($files["txtImagenPromo"]["tmp_name"]);
			  $image->resizeToWidth(500);
			  $image->save($cRutaImagenTienda . $NomImagen);
				
				$sql="update tblti_productos set imagen_promo='{$NomImagen}' where idproducto = '{$d["IdProducto"]}'";
				
      $r = mysqli_query($nConexion,$sql);
	  
	  }
      

      mysqli_close( $nConexion );
      Mensaje( "El registro ha sido actualizado correctamente.", "listar_productos.php?idcategoria={$d["IdCategoria"]}" ) ;
      exit;
    }



  } // FIN: function
  ###############################################################################
?>

<?
  ###############################################################################
  # Descripción   : Eliminar un registro
  # Parametros    : $nId
  # Desarrollado  : Estilo y Diseño & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function ProductosEliminar( $idProducto )
  {
    $nConexion = Conectar();
    mysqli_query($nConexion, "DELETE FROM tblti_productos WHERE idproducto = $idProducto " );

    Log_System( "TIENDA" , "ELIMINA" , "PRODUCTO: " . $idProducto  );
    mysqli_close( $nConexion );
    Mensaje( "El registro ha sido eliminado correctamente.","listar_productos.php" );
    exit();
  } // FIN: function
  ###############################################################################
?>

<?
  ###############################################################################
  # Nombre        : ContenidosFormEditar
  # Descripción   : Muestra el formulario para editar o eliminar registros
  # Parametros    : $nId = ID de registro que se debe mostrar el en formulario
  # Desarrollado  : Estilo y Diseño & Informaticactiva
  # Retorno       : Ninguno
  ###############################################################################
  function ProductosFormEditar( $idProducto )
  {
    include("../../vargenerales.php");
    $nConexion    = Conectar();
    $Resultado    = mysqli_query($nConexion, "SELECT * FROM tblti_productos where idproducto = $idProducto" ) ;
    $Registro     = mysqli_fetch_array( $Resultado );
    $tags=explode(",",$Registro["tags"]);
    $palabras=explode(", ",$Registro["palabras"]);
	$fotos    = mysqli_query($nConexion,"SELECT * FROM tblti_imagenes WHERE idproducto = $idProducto");
  	global $sexo;
    
    $rsAsociados = mysqli_query($nConexion,"select * from tblti_productos_asociados where idproducto = {$idProducto}");
    $asociados=array();
    while($rax = mysqli_fetch_assoc($rsAsociados)){
        $asociados[] = $rax["idproductoa"];
    }
    
    $rsColores = mysqli_query($nConexion,"select * from tblti_colores_asociados where idproducto = {$idProducto}");
    $colores=array();
    while($rax = mysqli_fetch_assoc($rsColores)){
        $colores[] = $rax["idproductoa"];
    }
	
    $rsTecnologias = mysqli_query($nConexion,"select * from tblti_tecnologias_asociadas where idproducto = {$idProducto}");
    $tecnologias=array();
    while($rax = mysqli_fetch_assoc($rsTecnologias)){
        $tecnologias[] = $rax["idproductoa"];
    }
    ?>

    <!-- Formulario Edición / Eliminación de Contenidos -->
    <form method="post" action="productos.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="IdProducto" name="IdProducto" value="<? echo $idProducto ; ?>">
      <table width="100%">
        <tr>
          <td colspan="4" align="center" class="tituloFormulario"><b>EDITAR PRODUCTO</b></td>
        </tr>
      <tr>
        <td class="tituloNombres">Categoria:</td>
        <td class="contenidoNombres" colspan="5">
        <select name="IdCategoria">
        <?php
        $ra =mysqli_query($nConexion,"select * from tblti_categorias where idcategoria<>0  order by vpath");
        while( $rax=mysqli_fetch_object($ra) ){
          ?><option value="<?=$rax->idcategoria;?>" <?=$rax->idcategoria==$Registro["idcategoria"]?"selected":"";?> ><?=$rax->vpath;?></option><?
        }
        ?>
        </select>
        </td>
      </tr>
        <tr>
          <td class="tituloNombres">Referencia:</td>
          <td class="contenidoNombres" colspan="5"><INPUT id="txtReferencia" type="text" name="txtReferencia" value="<? echo $Registro["referencia"]; ?>" maxLength="200" style="width:200px; "></td>
        </tr>

        <tr>
          <td class="tituloNombres">Nombre:</td>
          <td class="contenidoNombres" colspan="5"><INPUT id="txtNombre" type="text" name="txtNombre" value="<? echo $Registro["nombre"]; ?>" maxLength="200" style="width:200px; "></td>
        </tr>
      <tr>
        <td class="tituloNombres">Descripcion:</td>
        <td class="contenidoNombres" colspan="5">
            <textarea name="txtDescripcion"><? echo $Registro["descripcion"]?></textarea>
            <script>
                CKEDITOR.replace( 'txtDescripcion' );
            </script>
        </td>
      <tr>
        <td class="tituloNombres">Tags: Para seleccionar varios, deje presionado Ctrl y haga click en los que desee seleccionar.</td>
        <td class="contenidoAsoc">
        <?php
        $sql="select url,nombre from tbltags_palabras where tag=1 order by nombre";
        $ra = mysqli_query($nConexion,$sql);
        ?>        
        <select name="txtTags[]" multiple size="20" style="width:100%;" >
        <?php while($rax=mysqli_fetch_assoc($ra)):?>
            <option value="<?=$rax["url"];?>" <?=in_array($rax["url"],$tags)?"selected":"";?> ><?=$rax["nombre"];?></option>
        <?php endwhile;?>
        </select>
        </td>
        <td class="tituloNombres">Palabras Clave: Para seleccionar varios, deje presionado Ctrl y haga click en los que desee seleccionar.</td>
        <td class="contenidoAsoc">
        <?php
        $sql="select idpalabra,nombre from tbltags_palabras where keyword=1 order by nombre";
        $ra = mysqli_query($nConexion,$sql);
        ?>        
        <select name="txtPalabras[]" multiple size="20" style="width:100%;" >
        <?php while($rax=mysqli_fetch_assoc($ra)):?>
            <option value="<?=$rax["nombre"];?>" <?=in_array($rax["nombre"],$palabras)?"selected":"";?> ><?=$rax["nombre"];?></option>
        <?php endwhile;?>
        </select>
        </td>
      </tr>
      <tr>
        <td class="tituloNombres">Inventario:</td>
        <td class="contenidoNombres" colspan="5"><INPUT id="txtIva" type="text" name="txtInventario" value="<?=$Registro["inventario"];?>" maxLength="200" style="width:200px; "></td>
      </tr>
      <tr>
        <td class="tituloNombres">Inventario Activo:</td>
        <td class="contenidoNombres" colspan="5">
            <select name="txtInventarioActivo">
                <option value="1" <?=$Registro["inventario_activo"]==1?"selected":"";?> >SI</option>
                <option value="0" <?=$Registro["inventario_activo"]==0?"selected":"";?> >NO</option>
            </select>
        </td>
      </tr>
      
      <tr>
        <td class="tituloNombres">Iva:</td>
        <td class="contenidoNombres" colspan="5"><INPUT id="txtIva" type="text" name="txtIva" value="<?=$Registro["iva"];?>" maxLength="200" style="width:200px; "></td>
      </tr>
      <tr>
        <td class="tituloNombres">Precio:</td>
        <td class="contenidoNombres" colspan="5"><INPUT id="txtPrecio" type="text" name="txtPrecio" value="<?=$Registro["precio"];?>" maxLength="200" style="width:200px; "></td>
      </tr>
      <tr>
        <td class="tituloNombres">Precio Anterior: </td>
        <td class="contenidoNombres" colspan="5"><INPUT id="txtPrecioAnt" type="text" name="txtPrecioAnt" value="<?=$Registro["precioant"];?>" maxLength="200" style="width:200px; "></td>
      </tr>

      <tr>
        <td class="tituloNombres">Peso: </td>
        <td class="contenidoNombres" colspan="5"><INPUT id="txtPeso" type="text" name="txtPeso" value="<?=$Registro["peso"];?>" maxLength="200" style="width:200px; "></td>
      </tr>

      <tr>
        <td class="tituloNombres">Volumen: </td>
        <td class="contenidoNombres" colspan="5"><INPUT id="txtVolumen" type="text" name="txtVolumen" value="<?=$Registro["volumen"];?>" maxLength="200" style="width:200px; "></td>
      </tr>

      <tr>
        <td class="tituloNombres">Activo:</td>
        <td class="contenidoNombres" colspan="5">
        <select name="txtActivo">
        <?php foreach(array(1=>"Si",0=>"No") as $k=>$v):?>
          <option value="<?=$k;?>" <?=$k==$Registro["activo"]?"selected":"";?>><?=$v;?></option>
        <?php endforeach;?>
        </select>
        </td>
      </tr>
      <tr>
        <td class="tituloNombres">Promoción:</td>
        <td class="contenidoNombres" colspan="5">
        <input type="checkbox" <?=$Registro["promocion"]==1?"checked='checked'":"";?> name="txtPromocion" class="txtPromocion">
        </td>
      </tr>
      <tr class="promo" <?=$Registro["promocion"]==1?"style='display:table-row;'":"style='display:none;'";?>>
          <td class="tituloNombres">Imagen Promoci&oacute;n:</td>
          <td class="contenidoNombres" colspan="5"><input type="file" name="txtImagenPromo" /></td>
      </tr>
		<script type="text/javascript">	
			$(document).ready(function(){
				$('.txtPromocion').change(function(){
					if(this.checked)
						$('.promo').fadeIn('slow');
					else
						$('.promo').fadeOut('slow');
			
				});
			});
		</script>
            <?
                if ( $Registro["promocion"]==1  )
                {?>
                
                <tr>
                    <td class="tituloNombres">Imagen Actual:</td>
                    <td class="contenidoNombres" colspan="5">
                    <?
                        if ( empty( $Registro["imagen_promo"] ) )
                        {
                            echo "No se asigno una imagen.";
                        }
                        else
                        {
                            ?><img src="<? echo $cRutaVerImagenTienda . $Registro['imagen_promo']; ?>"><?
                        }
                    ?>
                    </td>
                </tr> 
                <?    
                }
            ?>    
      <tr>        
      <td class="tituloNombres">Mas Vendido:</td>        <td class="contenidoNombres" colspan="5">        <select name="txtMasVendidos">        <?php foreach(array(1=>"Si",0=>"No") as $k=>$v):?>          <option value="<?=$k;?>" <?=$k==$Registro["masvendidos"]?"selected":"";?>><?=$v;?></option>        <?php endforeach;?>        </select>        
      </td>      
      </tr>
      
      <tr>
        <td class="tituloNombres">Tallas(separadas por coma): </td>
        <td class="contenidoNombres" colspan="5"><INPUT id="txtTallas" type="text" name="txtTallas" value="<?=$Registro["tallas"];?>" maxLength="200" style="width:200px; "></td>
      </tr>

      <tr>
        <td class="tituloNombres">Imágenes:
            <a href="#nolink" onclick="nuevaImagen();">
                <img src="../../image/add.gif" width="16" height="16" />
            </a>
        </td>
        <td class="contenidoNombres" colspan="5">
        
	<script type="text/javascript">
		function delete_image(file)
		{
		  var status = confirm("Esta seguro que desea eliminar la imagen?");  
		  if(status==true)
		  {
			var clases = $("."+file);
			$.ajax({
			  type:"POST",
			  url:"eliminar.php",
			  data:{file:file},
			  success: function(data){
				  window.location.reload(true);
			  }
			});
		  }
		 }
		 
	$(function(){
    $('.delete').on('click', function(e){
        e.preventDefault(); // stops the link doing what it normally 
                            // would do which is jump to page top with href="#"
        delete_image($(this).data('imagen'));
    });
});
    </script>
        <ul class="files">
      <?php $i=1; ?>
	  <?php while($Fotos = mysqli_fetch_object($fotos) ):?>
          <li class="<? echo $Fotos->imagen; ?>"><input type="file" name="txtImagen<?=$i;?>">
          <a href="#nolink" class="delete" data-imagen="<? echo $Fotos->imagen; ?>"><img src="../../image/borrar.gif" width="16" height="16" /></a>
          </li>
          <li class="<? echo $Fotos->imagen; ?>"><input type="hidden" name="id_<?=$i;?>" value="<?=$Fotos->idimagen;?>"></li>
		  <li class="<? echo $Fotos->imagen; ?>"><img src="<? echo $cRutaVerImagenTienda."m_".$Fotos->imagen; ?>" width="200"/></li>
      <?php $i+=1; 
	  endwhile;?>
        </ul>
        <?php if($_SESSION["UsrPerfil"]==1):?>
        <br/>
        Tama&ntilde;o Grande<input id="txtSize" type="text" name="txtSize" value="1024" maxLength="200" style="width:200px; "><br/>
        Tama&ntilde;o Mediano<input id="txtSizeM" type="text" name="txtSizeM" value="500" maxLength="200" style="width:200px; "><br/>
        Tama&ntilde;o Peque&ntilde;o<input id="txtSizeS" type="text" name="txtSizeS" value="150" maxLength="200" style="width:200px; "><br/>
        <?php endif;?>
        <?php echo "
		<script type=\"text/javascript\">
        var indexImagen={$i};
        
        function nuevaImagen(){
            
            $('.files').append('<li><input type=\"file\" name=\"txtImagen' + indexImagen + '\" /><a href=\"#nolink\" id=\"remove\"><img src=\"../../image/borrar.gif\" width=\"16\" height=\"16\" /></a><input type=\"hidden\" name=\"id_' + indexImagen + '\" value=\"\"/></li>');
            indexImagen+=1;
        }

        $(document).on('click', '#remove', function(){
		   $(this).parent('li').remove();
		});
        </script>";?>
      
        </td>
      </tr>

      <tr>
        <td class="tituloNombres">Productos asociados: </td>
        <td class="contenidoNombres" colspan="5">
        <?php
        $sql="select idproducto,nombre from tblti_productos where idproducto<>{$idProducto}";
        $ra = mysqli_query($nConexion,$sql);
        ?>        
        <select name="productos_asociados[]" multiple size="20" style="width:100%;" >
        <?php while($rax=mysqli_fetch_assoc($ra)):?>
            <option value="<?=$rax["idproducto"];?>"  <?=in_array($rax["idproducto"],$asociados)?"selected":"";?> ><?=$rax["nombre"];?></option>
        <?php endwhile;
    mysqli_close( $nConexion );?>
        </select>
        </td>
      </tr>

        <tr>
          <td colspan="4" class="tituloFormulario">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="4" class="nuevo">
            <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
            <?
            if ( Perfil() != "3" )
            {
            ?><a href="productos.php?Accion=Eliminar&Id=<? echo $idProducto; ?>"><img src="../../image/eliminar.gif" border="0" alt="Eliminar Registro." onClick="javascript: return confirm('¿Esta seguro que desea eliminar este registro?')"></a><?
            }
            ?>
            <a href="listar_productos.php?idcategoria=<? echo $Registro["idcategoria"]; ?>"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a>
          </td>
        </tr>
      </table>
    </form>
    <?
    mysqli_free_result( $Resultado );
  }
  ###############################################################################
  ?>
