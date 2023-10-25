<?
  ###############################################################################
  # contenidos_funciones.php :  Archivo de funciones modulo
  # Desarrollo               :  Estilo y Diseño - http://www.esidi.com
  # Web                      :  http://www.informaticactiva.com - Oscar Arley Yepes Aristizabal
  ###############################################################################
  require_once("../../funciones_generales.php");
	include("../../vargenerales.php");
	include("../../herramientas/SimpleImage/SimpleImage.php");

  ini_set("memory_limit","50M");
  ini_set("upload_max_filesize", "30M");
  ini_set("max_execution_time","180");//3 MINUTOS
  ini_set("post_max_size","30M");

  function ProductosFormNuevo($IdCategoria){
    $nConexion = Conectar();
	mysqli_set_charset($nConexion,'utf8');
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
        <td class="tituloNombres">Categoría:</td>
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
        <td class="contenidoNombres" colspan="5"><INPUT id="Referencia" type="text" name="Referencia" value="" maxLength="200" style="width:200px; "> Activo<input type="checkbox" name="referencia_activo" checked></td>
      </tr>
      <tr>
        <td class="tituloNombres">Código WO:</td>
        <td class="contenidoNombres" colspan="5"><INPUT id="codigowo" type="text" name="codigowo" value="" maxLength="200" style="width:200px; "> </td>
      </tr>
      <tr>
        <td class="tituloNombres">Nombre:</td>
        <td class="contenidoNombres" colspan="5"><INPUT id="nombre" type="text" name="nombre" maxLength="200" style="width:200px; "></td>
      </tr>
      <tr>
        <td class="tituloNombres">Descripcion:</td>
        <td class="contenidoNombres" colspan="5">
            <textarea name="descripcion"></textarea>
            <script>
                CKEDITOR.replace( 'descripcion' );
            </script>
        </td>
      </tr>
      
      <tr>
        <td class="tituloNombres">Especificaciones:
          <a href="#nolink" onclick="nuevoCampo();"><img src="../../image/add.gif" width="16" height="16" /></a>
        </td>
        <td class="contenidoNombres" colspan="5">
		    <script type="text/javascript">
          function nuevoCampo(){
              $('.campos').append('<li>Nombre: <input type="text" name="nombreEspec[]" /> Descripcion: <input type="text" name="descripcionEspec[]" /><a href="#nolink" class="remove"><img src="../../image/borrar.gif" width="16" height="16" /></a></li>');
          }
        </script>
        <ul class="campos">
          <li>Nombre: <input type="text" name="nombreEspec[]" /> Descripcion: <input type="text" name="descripcionEspec[]" /></li>
        </ul>
        </td>
      </tr>


      <tr>
        <td class="tituloNombres">Peso: (Kg)</td>
        <td class="contenidoNombres" colspan="5">
          <INPUT id="peso" type="text" name="peso" maxLength="200" style="width:200px; " pattern="[0-9]+([\.][0-9]+)?">  (Punto decimal)
        </td>
      </tr>
      <tr>
        <td class="tituloNombres">Alto: (cm)</td>
        <td class="contenidoNombres" colspan="5">
          <INPUT id="alto" type="number" name="alto" maxLength="200" style="width:200px; " pattern="^[0-9]+">  (Sin decimales)
        </td>
      </tr>
      <tr>
        <td class="tituloNombres">Ancho: (cm)</td>
        <td class="contenidoNombres" colspan="5">
          <INPUT id="ancho" type="number" name="ancho" maxLength="200" style="width:200px; " pattern="^[0-9]+">  (Sin decimales)
        </td>
      </tr>
      <tr>
        <td class="tituloNombres">Largo: (cm)</td>
        <td class="contenidoNombres" colspan="5">
          <INPUT id="largo" type="number" name="largo" maxLength="200" style="width:200px; " pattern="^[0-9]+">  (Sin decimales)
        </td>
      </tr>
      <tr>
        <td class="tituloNombres">Mantenimiento</td>
        <td class="contenidoNombres" colspan="5">
          <INPUT type="number" name="mantenimiento" maxLength="200" style="width:200px; " pattern="^[0-9]+"> días
        </td>
      </tr>


      <tr>
        <td class="tituloNombres">Usos:</td>
        <td class="contenidoNombres" colspan="5">
          <select name="IdUsos">
            <?php
              $ra =mysqli_query($nConexion,"select * from agro_usos order by id");
              while( $rax=mysqli_fetch_object($ra) ){
                ?><option value="<?=$rax->id;?>" ><?=$rax->nombre;?></option><?
              }
            ?>
        </td>
      </tr>

      <tr>
        <td class="tituloNombres">Categorias de Usos: Para seleccionar varios, deje presionado Ctrl y haga click en los que desee seleccionar.</td>
        <td class="contenidoAsoc">
          <?php
            $sql="select * from agro_categoria order by nombre";
            $ra = mysqli_query($nConexion,$sql);
          ?>        
          <select name="agro_categoria[]" multiple size="5" style="width:100%;" >
            <?php while($rax=mysqli_fetch_assoc($ra)):?>
              <option value="<?=$rax["id"];?>" ><?=$rax["nombre"];?></option>
            <?php endwhile;?>
          </select>
        </td>
        <td class="tituloNombres">Accesorios relacionados.</td>
        <td class="contenidoAsoc">
        <?php
        $sql="SELECT idproducto, nombre FROM tblti_productos WHERE idcategoria=135 ORDER BY nombre";
        $ra = mysqli_query($nConexion,$sql);
        ?>        
        <select name="accesorios[]" multiple size="20" style="width:100%;" >
        <?php while($rax=mysqli_fetch_assoc($ra) ):?>
            <option value="<?=$rax["idproducto"];?>"><?=$rax["nombre"];?></option>
        <?php endwhile;?>
        </select>
        </td>
      </tr>
      
      <tr>
        <td colspan="4" align="center" class="tituloFormulario"><b>POSICIONAMIENTO</b></td>
      </tr>
      <tr>
        <td class="tituloNombres">Título:</td>
        <td class="contenidoNombres" colspan="5"><input type="text" name="titulo" class="seocounter_title" maxLength="200" style="width: 825px; height: 22px"></td>
      </tr>
      <tr>
        <td class="tituloNombres">Descripción:</td>
        <td class="contenidoNombres" colspan="5">
            <textarea name="metaDescripcion" class="seocounter_meta" cols="100" rows="10"></textarea>
        </td>
      </tr>
      <tr>
        <td class="tituloNombres">Tags: Para seleccionar varios, deje presionado Ctrl y haga click en los que desee seleccionar.</td>
        <td class="contenidoAsoc">
        <?php
        $sql="select url,nombre from tbltags_palabras where tag=1 order by nombre";
        $ra = mysqli_query($nConexion,$sql);
        ?>        
        <select name="Tags[]" multiple size="20" style="width:100%;" >
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
        <select name="Palabras[]" multiple size="20" style="width:100%;" >
        <?php while($rax=mysqli_fetch_assoc($ra)):?>
            <option value="<?=$rax["nombre"];?>"><?=$rax["nombre"];?></option>
        <?php endwhile;?>
        </select>
        </td>
      </tr>
      <tr>
        <td class="tituloNombres">Marca:</td>
        <td class="contenidoNombres" colspan="5">
        <select name="IdMarca">
        <?php
        $ra =mysqli_query($nConexion,"select * from tblti_marcas order by nombre");
        while( $rax=mysqli_fetch_object($ra) ){
          ?><option value="<?=$rax->idmarca;?>" ><?=$rax->nombre;?></option><?
        }
        ?>
        </select> Activo<input type="checkbox" name="marca_activo">
        </td>
      </tr>
      <tr>
        <td class="tituloNombres">Material: Activo<input type="checkbox" name="material_activo"></td>
        <td class="contenidoAsoc">
        <?php
        $sql="select id,nombre from tblti_deportes";
        $ra = mysqli_query($nConexion,$sql);
        ?>        
        <select name="material[]" multiple size="10" style="width:100%;" >
        <?php while($rax=mysqli_fetch_assoc($ra)):?>
            <option value="<?=$rax["id"];?>"><?=$rax["nombre"];?></option>
        <?php endwhile;?>
        </select>
        </td>
        <td class="tituloNombres">Colores: Activo<input type="checkbox" name="colores_activo"></td>
        <td class="contenidoAsoc">
        <?php
        $sql="select id,nombre from tblti_colores";
        $ra = mysqli_query($nConexion,$sql);
        ?>        
        <select name="colores[]" multiple size="20" style="width:100%;" >
        <?php while($rax=mysqli_fetch_assoc($ra)):?>
            <option value="<?=$rax["id"];?>"><?=$rax["nombre"];?></option>
        <?php endwhile;?>
        </select>
        </td>
      </tr>
      <tr>
        <td class="tituloNombres">Inventario:</td>
        <td class="contenidoNombres" colspan="5"><INPUT type="text" name="Inventario" value="1" maxLength="200" style="width:200px; "> Activo<input type="checkbox" name="inventario_activo"></td>
      </tr>
      <tr>
        <td class="tituloNombres">Precio:</td>
        <td class="contenidoNombres" colspan="5"><INPUT type="text" name="precio" maxLength="200" style="width:200px; "> Activo<input type="checkbox" name="precio_activo"></td>
      </tr>

      <tr>
        <td class="tituloNombres">Precio Anterior: </td>
        <td class="contenidoNombres" colspan="5"><INPUT type="text" name="PrecioAnt" maxLength="200" style="width:200px; "> Activo<input type="checkbox" name="precio_activo"></td>
      </tr>

      <tr>
        <td class="tituloNombres">IVA: </td>
        <td class="contenidoNombres" colspan="5"><INPUT type="number" name="iva" maxLength="3" style="width:100px;" value="19">%</td>
      </tr>

      <tr>
        <td class="tituloNombres">Activo:</td>
        <td class="contenidoNombres" colspan="5">
        <select name="activo">
            <option value="1" >SI</option>
            <option value="0" >NO</option>
        </select>
        </td>
      </tr> 
      <tr>
        <td class="tituloNombres">Promoción:</td>
        <td class="contenidoNombres" colspan="5">
        <input type="checkbox" name="Promocion" class="Promocion">
        </td>
      </tr>
      <tr class="promo" style="display:none;">
      <td class="tituloNombres">Imagen Promoci&oacute;n:</td>
      <td class="contenidoNombres" colspan="5"><input type="file" name="ImagenPromo" /></td>
      </tr>
		<script type="text/javascript">	
			$(document).ready(function(){
				$('.Promocion').change(function(){
					if(this.checked)
						$('.promo').fadeIn('slow');
					else
						$('.promo').fadeOut('slow');
			
				});
			});
		</script>   
      <tr>        
          <td class="tituloNombres">Destacado:</td>        
          <td class="contenidoNombres" colspan="5">        
          <select name="destacado">        
          <?php foreach(array(0=>"No",1=>"Si") as $k=>$v):?>          
          <option value="<?=$k;?>"><?=$v;?></option>        
          <?php endforeach;?>        
          </select>        
          </td>      
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
            
            $('.files').append('<li><input type="file" name="Imagen' + indexImagen + '" /><a href="#nolink" class="remove"><img src="../../image/borrar.gif" width="16" height="16" /></a></li>');
            indexImagen+=1;
        }

        $(document).on("click", ".remove", function(){
		   $(this).parent('li').remove();
		});
        </script>
        <ul class="files">
        <li><input type="file" name="Imagen1" /></li>
        </ul>
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
	mysqli_set_charset($nConexion,'utf8');
	setlocale(LC_ALL, 'en_US.UTF8');
    $url = slug($d["nombre"]);
	$promocion = isset($d["Promocion"]) ? 1 : 0;
	$referencia_activo = isset($d["referencia_activo"]) ? 1 : 0;
	$descripcion_activo = isset($d["descripcion_activo"]) ? 1 : 0;
	$precio_activo = isset($d["precio_activo"]) ? 1 : 0;
	$precioa_activo = isset($d["precioa_activo"]) ? 1 : 0;
	$colores_activo = isset($d["colores_activo"]) ? 1 : 0;
	$marca_activo = isset($d["marca_activo"]) ? 1 : 0;
	$material_activo = isset($d["material_activo"]) ? 1 : 0;
	$tags = "";
	$palabras = "";
	$material = "";
	$colores = "";
  $usoscat = "";
  
	if (!empty($d["agro_categoria"])){
    $agro_categoria = implode(',', $d["agro_categoria"]);
	}
	if (!empty($d["Tags"])){
    $tags = implode(',', $d["Tags"]);
	}
	if (!empty($d["Palabras"])){
    $palabras = implode(', ', $d["Palabras"]);
	}
	if (!empty($d["material"])){
    $material = implode(',', $d["material"]);
	}
	if (!empty($d["colores"])){
    $colores = implode(',', $d["colores"]);
  }
  
  /*$sql = mysqli_query($nConexion, "SELECT * FROM tblti_marcas WHERE idmarca = {$d["IdMarca"]}" );
  
  $Registro = mysqli_fetch_array( $sql );*/
    if ( $d["IdProducto"] == "0" ) // Nuevo Registro
    {
      $sql="insert  into tblti_productos
                    (idciudad,idcategoria,nombre,url,descripcion,
                    codigowo,titulo,metaDescripcion,tags,palabras,material,
                    color,idmarca,activo,promocion,precio,
                    precioant,iva,destacado,referencia,inventario, 
                    referencia_activo, descripcion_activo, precio_activo, 
                    precioa_activo, colores_activo, 
                    marca_activo, material_activo, usos, usoscat,
                    peso, alto, ancho, largo, mantenimiento ) 
            values  ({$_SESSION["IdCiudad"]},'{$d["IdCategoria"]}',
                    '{$d["nombre"]}','$url','{$d["descripcion"]}',
                    '{$d["codigowo"]}','{$d["titulo"]}','{$d["metaDescripcion"]}',
                    '$tags','$palabras','$material','$colores',
                    '{$d["IdMarca"]}','{$d["activo"]}','$promocion',
                    '{$d["precio"]}','{$d["PrecioAnt"]}',{$d["iva"]},{$d["destacado"]},
                    '{$d["Referencia"]}','{$d["Inventario"]}', 
                    $referencia_activo, $descripcion_activo, 
                    $precio_activo, $precioa_activo, $colores_activo, 
                    $marca_activo, $material_activo, 
                    '{$d["IdUsos"]}', '{$agro_categoria}',
                    '{$d["peso"]}', '{$d["alto"]}', '{$d["ancho"]}', '{$d["largo"]}', '{$d["mantenimiento"]}' ) ";
      @ $r = mysqli_query($nConexion,$sql);
	  
      $d["IdProducto"] = mysqli_insert_id($nConexion);

      if( is_array($d["nombreEspec"]) ){
        foreach($d["nombreEspec"] as $key => $value){
          $nombreEspec = trim($d["nombreEspec"][$key]);
          $descripcionEspec = trim($d["descripcionEspec"][$key]);

          $sql = "SELECT * FROM tblti_espec where nombre = '{$nombreEspec}' GROUP by nombre";
          $result = mysqli_query($nConexion,$sql);
          $img = mysqli_fetch_assoc($result);
          
          $sql = "INSERT INTO tblti_espec 
                              (idproducto, nombre, descripcion, imagen) 
                       VALUES ({$d["IdProducto"]}, '{$nombreEspec}', 
                              '{$descripcionEspec}', '{$img["imagen"]}')";
                              
          mysqli_query($nConexion,$sql);
        }
      }

      if( is_array($d["accesorios"]) ){
        foreach($d["accesorios"] as $value){
          
          $sql = "INSERT INTO tblti_productos_asociados (idproducto, idproductoa) VALUES ({$d["IdProducto"]}, $value)";
                              
          mysqli_query($nConexion,$sql);
        }
      }


	  
	  if( isset( $files["ImagenPromo"]["tmp_name"] ) && $files["ImagenPromo"]["tmp_name"]!="" ) {
			
				$NomImagen = $d["IdProducto"] . "_" . "promo" . "_" . $files["ImagenPromo"]["name"];
	
			  $image = new SimpleImage();
			  $image->load($files["ImagenPromo"]["tmp_name"]);
			  $image->resizeToWidth(500);
			  $image->save($cRutaImagenTienda . $NomImagen);
				
				$sql="update tblti_productos set imagen_promo='{$NomImagen} where idproducto = {$d["IdProducto"]}";
				
      $r = mysqli_query($nConexion,$sql);
	  
	  }

      for($i=1;$i<=20;$i++){
		  $NomImagen="*";
			    
			if( isset( $files["Imagen{$i}"]["tmp_name"] ) && $files["Imagen{$i}"]["tmp_name"]!="" ) {
			
				$NomImagenG = $d["IdProducto"] . "_" . $i . "_" . $files["Imagen{$i}"]["name"];
				$NomImagenM = "m_" . $d["IdProducto"] . "_" . $i . "_" . $files["Imagen{$i}"]["name"];
				$NomImagenP = "p_" . $d["IdProducto"] . "_" . $i . "_" . $files["Imagen{$i}"]["name"];

        try {
          $image = new \claviska\SimpleImage();

          $image
            ->fromFile($files["Imagen{$i}"]["tmp_name"])
            ->resize(1600)
            ->overlay('watermark.png','center',.3)
            ->toFile($cRutaImagenTienda . $NomImagenG);

          $image
            ->fromFile($files["Imagen{$i}"]["tmp_name"])
            ->resize(500)
            ->overlay('watermark-small.png','center',.3)
            ->toFile($cRutaImagenTienda . $NomImagenM);

          $image
            ->fromFile($files["Imagen{$i}"]["tmp_name"])
            ->resize(200)
            ->toFile($cRutaImagenTienda . $NomImagenP);
        } catch(Exception $err) {
          echo $err->getMessage();
        }
				
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

      $sql="UPDATE  tblti_productos 
               SET  idciudad={$_SESSION["IdCiudad"]}, idcategoria='{$d["IdCategoria"]}',
                    nombre='{$d["nombre"]}', url='$url', descripcion='{$d["descripcion"]}', 
                    titulo='{$d["titulo"]}', metaDescripcion='{$d["metaDescripcion"]}', 
                    tags='$tags', palabras='$palabras', material='$material', 
                    color='$colores', idmarca='{$d["IdMarca"]}', 
                    idcategoria='{$d["IdCategoria"]}', activo='{$d["activo"]}', 
                    promocion='{$promocion}', precio='{$d["precio"]}', 
                    precioant='{$d["PrecioAnt"]}', iva={$d["iva"]}, destacado={$d["destacado"]}, 
                    referencia='{$d["Referencia"]}', codigowo='{$d["codigowo"]}', 
                    inventario={$d["Inventario"]}, referencia_activo='{$referencia_activo}', 
                    descripcion_activo='{$descripcion_activo}', 
                    precio_activo='{$precio_activo}', precioa_activo='{$precioa_activo}', 
                    colores_activo='{$colores_activo}', marca_activo='{$marca_activo}', 
                    material_activo='{$material_activo}',
                    usos='{$d["IdUsos"]}', usoscat='$agro_categoria',
                    peso='{$d["peso"]}', alto='{$d["alto"]}', ancho='{$d["ancho"]}', largo='{$d["largo"]}', mantenimiento='{$d["mantenimiento"]}'
             where  idproducto = {$d["IdProducto"]}";

      $r = mysqli_query($nConexion,$sql);

      if(!$r){
        Mensaje( "Fallo actualizando.".mysqli_error($nConexion), "listar_productos.php" ) ;
        exit;
      }

      $sql="DELETE FROM tblti_espec WHERE idproducto={$d["IdProducto"]}";
      mysqli_query($nConexion,$sql);

      if( is_array($d["nombreEspec"]) ){
        foreach($d["nombreEspec"] as $key => $value){
          $nombreEspec = trim($d["nombreEspec"][$key]);
          $descripcionEspec = trim($d["descripcionEspec"][$key]);

          $sql = "SELECT * FROM tblti_espec where nombre = '{$nombreEspec}' GROUP by nombre";
          $result = mysqli_query($nConexion,$sql);
          $img = mysqli_fetch_assoc($result);
          
          $sql = "INSERT INTO tblti_espec 
                              (idproducto, nombre, descripcion, imagen) 
                       VALUES ({$d["IdProducto"]}, '{$nombreEspec}', 
                              '{$descripcionEspec}', '{$img["imagen"]}')";
                              
          mysqli_query($nConexion,$sql);
        }
      }

      $sql="DELETE FROM tblti_productos_asociados WHERE idproducto={$d["IdProducto"]}";
      mysqli_query($nConexion,$sql);

      if( is_array($d["accesorios"]) ){
        foreach($d["accesorios"] as $value){
          
          $sql = "INSERT INTO tblti_productos_asociados (idproducto, idproductoa) VALUES ({$d["IdProducto"]}, $value)";
                              
          mysqli_query($nConexion,$sql);
        }
      }

	for($i=1;$i<=20;$i++){
		  $NomImagen="*";
			    
			if( isset( $files["Imagen{$i}"]["tmp_name"] ) && $files["Imagen{$i}"]["tmp_name"]!="" ) {
			
				$NomImagenG = $d["IdProducto"] . "_" . $i . "_" . $files["Imagen{$i}"]["name"];
				$NomImagenM = "m_" . $d["IdProducto"] . "_" . $i . "_" . $files["Imagen{$i}"]["name"];
				$NomImagenP = "p_" . $d["IdProducto"] . "_" . $i . "_" . $files["Imagen{$i}"]["name"];

        try {
          $image = new \claviska\SimpleImage();

          $image
            ->fromFile($files["Imagen{$i}"]["tmp_name"])
            ->resize(1600)
            ->overlay('watermark.png','center',.3)
            ->toFile($cRutaImagenTienda . $NomImagenG);

          $image
            ->fromFile($files["Imagen{$i}"]["tmp_name"])
            ->resize(500)
            ->overlay('watermark-small.png','center',.3)
            ->toFile($cRutaImagenTienda . $NomImagenM);

          $image
            ->fromFile($files["Imagen{$i}"]["tmp_name"])
            ->resize(200)
            ->toFile($cRutaImagenTienda . $NomImagenP);
        } catch(Exception $err) {
          echo $err->getMessage();
        }
				
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
	mysqli_set_charset($nConexion,'utf8');
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
	mysqli_set_charset($nConexion,'utf8');
    $Resultado    = mysqli_query($nConexion, "SELECT * FROM tblti_productos where idproducto = $idProducto" ) ;
    $Registro     = mysqli_fetch_array( $Resultado );
    $tags=explode(",",$Registro["tags"]);
    $palabras=explode(", ",$Registro["palabras"]);
    $material=explode(",",$Registro["material"]);
    $color=explode(",",$Registro["color"]);
    
    $usoscat=explode(",",$Registro["usoscat"]);
    $query    = mysqli_query($nConexion, "SELECT idproductoa FROM tblti_productos_asociados WHERE idproducto=$idProducto" ) ;
    $accesorios = array();
    while ($row = mysqli_fetch_assoc($query)) {
      $accesorios[] = $row["idproductoa"];
    }
    
	$fotos    = mysqli_query($nConexion,"SELECT * FROM tblti_imagenes WHERE idproducto = $idProducto");
	$espec    = mysqli_query($nConexion,"SELECT * FROM tblti_espec WHERE idproducto = $idProducto ORDER BY id");
	$permisos  = permisos("Productos");
    ?>

    <!-- Formulario Edición / Eliminación de Contenidos -->
    <form method="post" action="productos.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="IdProducto" name="IdProducto" value="<? echo $idProducto ; ?>">
      <table width="100%">
        <tr>
          <td colspan="4" align="center" class="tituloFormulario"><b>EDITAR PRODUCTO</b></td>
        </tr>
      <tr>
        <td class="tituloNombres">Categoría:</td>
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
        <td class="contenidoNombres" colspan="5"><INPUT id="Referencia" type="text" name="Referencia" value="<?php echo $Registro["referencia"]; ?>" maxLength="200" style="width:200px; "> Activo<input type="checkbox" <?=$Registro["referencia_activo"]==1?"checked='checked'":"";?>  name="referencia_activo"></td>
      </tr>
      <tr>
        <td class="tituloNombres">Código WO:</td>
        <td class="contenidoNombres" colspan="5">
          <INPUT id="codigowo" type="text" name="codigowo" value="<?php echo $Registro["codigowo"]; ?>" maxLength="200" style="width:200px;"> 
        </td>
      </tr>      
      <tr>
        <td class="tituloNombres">Nombre:</td>
        <td class="contenidoNombres" colspan="5"><INPUT id="nombre" type="text" name="nombre" value="<?php echo $Registro["nombre"]; ?>" maxLength="200" style="width:200px; "></td>
      </tr>
      <tr>
        <td class="tituloNombres">Descripcion:</td>
        <td class="contenidoNombres" colspan="5">
            <textarea name="descripcion"><?php echo $Registro["descripcion"]?></textarea>
            <script>
                CKEDITOR.replace( 'descripcion' );
            </script>
        </td>
      </tr>
      <tr>
        <td class="tituloNombres">Especificaciones:
          <a href="#nolink" onclick="nuevoCampo();"><img src="../../image/add.gif" width="16" height="16" /></a>
        </td>
        <td class="contenidoNombres" colspan="5">
		    <script type="text/javascript">
          function nuevoCampo(){
              $('.campos').append('<li>Nombre: <input type="text" name="nombreEspec[]" /> Descripcion: <input type="text" name="descripcionEspec[]" /><a href="#nolink" class="remove"><img src="../../image/borrar.gif" width="16" height="16" /></a></li>');
          }
        </script>
        <ul class="campos">
	      <?php while($campos = mysqli_fetch_object($espec) ):?>
          <li>Nombre: <input type="text" name="nombreEspec[]" value="<?php echo $campos->nombre ?>" /> Descripcion: <input type="text" name="descripcionEspec[]" value="<?php echo $campos->descripcion ?>" />
          <a href="#nolink" class="remove"><img src="../../image/borrar.gif" width="16" height="16" /></a>
          </li>
        <?php endwhile;?>
        </ul>
        </td>
      </tr>


      <tr>
        <td class="tituloNombres">Peso: (Kg)</td>
        <td class="contenidoNombres" colspan="5">
          <INPUT id="peso" type="text" name="peso" value="<?=$Registro["peso"];?>" maxLength="200" style="width:200px; " pattern="[0-9]+([\.][0-9]+)?">  (Punto decimal)
        </td>
      </tr>
      <tr>
        <td class="tituloNombres">Alto: (cm)</td>
        <td class="contenidoNombres" colspan="5">
          <INPUT id="alto" type="number" name="alto" value="<?=$Registro["alto"];?>" maxLength="200" style="width:200px; " pattern="^[0-9]+">  (Sin decimales)
        </td>
      </tr>
      <tr>
        <td class="tituloNombres">Ancho: (cm)</td>
        <td class="contenidoNombres" colspan="5">
          <INPUT id="ancho" type="number" name="ancho" value="<?=$Registro["ancho"];?>" maxLength="200" style="width:200px; " pattern="^[0-9]+">  (Sin decimales)
        </td>
      </tr>
      <tr>
        <td class="tituloNombres">Largo: (cm)</td>
        <td class="contenidoNombres" colspan="5">
          <INPUT id="largo" type="number" name="largo" value="<?=$Registro["largo"];?>" maxLength="200" style="width:200px; " pattern="^[0-9]+">  (Sin decimales)
        </td>
      </tr>
      <tr>
        <td class="tituloNombres">Mantenimiento</td>
        <td class="contenidoNombres" colspan="5">
          <INPUT type="number" name="mantenimiento" value="<?=$Registro["mantenimiento"];?>" maxLength="200" style="width:200px; " pattern="^[0-9]+"> días
        </td>
      </tr>

      
      <tr>
        <td class="tituloNombres">Usos:</td>
        <td class="contenidoNombres" colspan="5">
          <select name="IdUsos">
            <?php
              $ra =mysqli_query($nConexion,"select * from agro_usos order by id");
              while( $rax=mysqli_fetch_object($ra) ){
                ?><option value="<?=$rax->id;?>" <?=$rax->id==$Registro["usos"]?"selected":"";?> ><?=$rax->nombre;?></option><?
              }
            ?>
        </td>
      </tr>

      <tr>
        <td class="tituloNombres">Categorias de Usos: Para seleccionar varios, deje presionado Ctrl y haga click en los que desee seleccionar.</td>
        <td class="contenidoAsoc">
          <?php
            $sql="select * from agro_categoria order by nombre";
            $ra = mysqli_query($nConexion,$sql);
          ?>        
          <select name="agro_categoria[]" multiple size="5" style="width:100%;" >
            <?php while($rax=mysqli_fetch_assoc($ra)):?>
              <option value="<?=$rax["id"];?>" <?=in_array($rax["id"],$usoscat)?"selected":"";?> ><?=$rax["nombre"];?></option>
            <?php endwhile;?>
          </select>
        </td>
        <td class="tituloNombres">Accesorios relacionados.</td>
        <td class="contenidoAsoc">
        <?php
        $sql="SELECT idproducto, nombre FROM tblti_productos WHERE idcategoria=135 ORDER BY nombre";
        $ra = mysqli_query($nConexion,$sql);
        ?>        
        <select name="accesorios[]" multiple size="20" style="width:100%;" >
        <?php while($rax=mysqli_fetch_assoc($ra) ):?>
            <option value="<?=$rax["idproducto"];?>" <?=in_array($rax["idproducto"],$accesorios)?"selected":"";?>><?=$rax["nombre"];?></option>
        <?php endwhile;?>
        </select>
        </td>
      </tr>

      
      <tr>
        <td colspan="4" align="center" class="tituloFormulario"><b>POSICIONAMIENTO</b></td>
      </tr>
      <tr>
        <td class="tituloNombres">Título:</td>
        <td class="contenidoNombres" colspan="5"><input type="text" name="titulo" value="<?php echo $Registro["titulo"]; ?>" class="seocounter_title" maxLength="200" style="width: 823px; height: 22px"></td>
      </tr>
      <tr>
        <td class="tituloNombres">Descripción:</td>
        <td class="contenidoNombres" colspan="5">
            <textarea name="metaDescripcion" class="seocounter_meta" cols="100" rows="10"><?php echo $Registro["metaDescripcion"]?></textarea>
        </td>
      </tr>
      
      <tr>
        <td class="tituloNombres">Tags: Para seleccionar varios, deje presionado Ctrl y haga click en los que desee seleccionar.</td>
        <td class="contenidoAsoc">
          <?php
            $sql="select url,nombre from tbltags_palabras where tag=1 order by nombre";
            $ra = mysqli_query($nConexion,$sql);
          ?>        
          <select name="Tags[]" multiple size="20" style="width:100%;" >
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
          <select name="Palabras[]" multiple size="20" style="width:100%;" >
            <?php while($rax=mysqli_fetch_assoc($ra)):?>
              <option value="<?=$rax["nombre"];?>" <?=in_array($rax["nombre"],$palabras)?"selected":"";?> ><?=$rax["nombre"];?></option>
            <?php endwhile;?>
          </select>
        </td>
      </tr>
      
      <tr>
        <td class="tituloNombres">Marca:</td>
        <td class="contenidoNombres" colspan="5">
        <select name="IdMarca">
        <?php
        $ra =mysqli_query($nConexion,"select * from tblti_marcas order by nombre");
        while( $rax=mysqli_fetch_object($ra) ){
          ?><option value="<?=$rax->idmarca;?>" <?=$rax->idmarca==$Registro["idmarca"]?"selected":"";?> ><?=$rax->nombre;?></option><?
        }
        ?>
        </select> Activo<input type="checkbox" <?=$Registro["marca_activo"]==1?"checked='checked'":"";?>  name="marca_activo">
        </td>
      </tr>
      
      <tr>
        <td class="tituloNombres">Material:  Activo<input type="checkbox" <?=$Registro["material_activo"]==1?"checked='checked'":"";?>  name="material_activo"></td>
        <td class="contenidoAsoc">
        <?php
        $sql="select id,nombre from tblti_deportes";
        $ra = mysqli_query($nConexion,$sql);
        ?>        
        <select name="material[]" multiple size="10" style="width:100%;" >
        <?php while($rax=mysqli_fetch_assoc($ra)):?>
            <option value="<?=$rax["id"];?>" <?=in_array($rax["id"],$material)?"selected":"";?>><?=$rax["nombre"];?></option>
        <?php endwhile;?>
        </select>
        </td>
        <td class="tituloNombres">Colores: Activo<input type="checkbox" <?=$Registro["colores_activo"]==1?"checked='checked'":"";?>  name="colores_activo"></td>
        <td class="contenidoAsoc">
        <?php
        $sql="select id,nombre from tblti_colores";
        $ra = mysqli_query($nConexion,$sql);
        ?>        
        <select name="colores[]" multiple size="20" style="width:100%;" >
        <?php while($rax=mysqli_fetch_assoc($ra)):?>
            <option value="<?=$rax["id"];?>" <?=in_array($rax["id"],$color)?"selected":"";?>><?=$rax["nombre"];?></option>
        <?php endwhile;?>
        </select>
        </td>
      </tr>
      <tr>
        <td class="tituloNombres">Inventario:</td>
        <td class="contenidoNombres" colspan="5"><INPUT id="Iva" type="text" name="Inventario" value="<?=$Registro["inventario"];?>" maxLength="200" style="width:200px; "> Activo<input type="checkbox" <?=$Registro["inventario_activo"]==1?"checked='checked'":"";?>  name="inventario_activo"></td>
      </tr>
      <tr>
        <td class="tituloNombres">Precio:</td>
        <td class="contenidoNombres" colspan="5"><INPUT id="precio" type="text" name="precio" maxLength="200" style="width:200px;" value="<?=$Registro["precio"];?>"> Activo<input type="checkbox" <?=$Registro["precio_activo"]==1?"checked='checked'":"";?>  name="precio_activo"></td>
      </tr>

      <tr>
        <td class="tituloNombres">Precio Anterior: </td>
        <td class="contenidoNombres" colspan="5"><INPUT id="PrecioAnt" type="text" name="PrecioAnt" value="<?=$Registro["precioant"];?>" maxLength="200" style="width:200px; "> Activo<input type="checkbox" <?=$Registro["precioa_activo"]==1?"checked='checked'":"";?>  name="precioa_activo"></td>
      </tr>

      <tr>
        <td class="tituloNombres">IVA: </td>
        <td class="contenidoNombres" colspan="5"><INPUT type="number" name="iva" maxLength="3" style="width:100px;" value="<?php echo $Registro["iva"];?>">%</td>
      </tr>

      <tr>
        <td class="tituloNombres">Activo:</td>
        <td class="contenidoNombres" colspan="5">
        <select name="activo">
            <option value="1"  <?=$Registro["activo"]==1?"selected":"";?>>SI</option>
            <option value="0"  <?=$Registro["activo"]==0?"selected":"";?>>NO</option>
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
          <td class="contenidoNombres" colspan="5"><input type="file" name="ImagenPromo" /></td>
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
		<script type="text/javascript">	
			$(document).ready(function(){
				$('.Promocion').change(function(){
					if(this.checked)
						$('.promo').fadeIn('slow');
					else
						$('.promo').fadeOut('slow');
			
				});
			});
		</script>   
      <tr>        
          <td class="tituloNombres">Destacado:</td>        
          <td class="contenidoNombres" colspan="5">        
          <select name="destacado">        
          <?php foreach(array(1=>"Si",0=>"No") as $k=>$v):?>          
          <option value="<?=$k;?>" <?=$k==$Registro["destacado"]?"selected":"";?>><?=$v;?></option>        
          <?php endforeach;?>        
          </select>        
          </td>      
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
        e.preventDefault();
        delete_image($(this).data('imagen'));
    });
});
    </script>
        <ul class="files">
      <?php $i=1; ?>
	  <?php while($Fotos = mysqli_fetch_object($fotos) ):?>
          <li class="<? echo $Fotos->imagen; ?>"><input type="file" name="Imagen<?=$i;?>">
          <a href="#nolink" class="delete" data-imagen="<? echo $Fotos->imagen; ?>"><img src="../../image/borrar.gif" width="16" height="16" /></a>
          </li>
          <li class="<? echo $Fotos->imagen; ?>"><input type="hidden" name="id_<?=$i;?>" value="<?=$Fotos->idimagen;?>"></li>
		  <li class="<? echo $Fotos->imagen; ?>"><img src="<? echo $cRutaVerImagenTienda."m_".$Fotos->imagen; ?>" width="200"/></li>
      <?php $i+=1; 
	  endwhile;?>
        </ul>
        <?php echo "
		<script type=\"text/javascript\">
        var indexImagen={$i};
        
        function nuevaImagen(){
            
            $('.files').append('<li><input type=\"file\" name=\"Imagen' + indexImagen + '\" /><a href=\"#nolink\" class=\"remove\"><img src=\"../../image/borrar.gif\" width=\"16\" height=\"16\" /></a><input type=\"hidden\" name=\"id_' + indexImagen + '\" value=\"\"/></li>');
            indexImagen+=1;
        }

        $(document).on('click', '.remove', function(){
		   $(this).parent('li').remove();
		});
        </script>";?>
      
        </td>
      </tr>
        <tr>
          <td colspan="4" class="tituloFormulario">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="4" class="nuevo">
            <input type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
            <?php if($permisos["eliminar"]==1):?><a href="productos.php?Accion=Eliminar&Id=<? echo $idProducto; ?>"><img src="../../image/eliminar.gif" border="0" alt="Eliminar Registro." onClick="javascript: return confirm('¿Esta seguro que desea eliminar este registro?')"></a><?php endif;?>
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
