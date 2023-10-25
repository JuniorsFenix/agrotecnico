<?php
require_once("funciones_generales.php");
	$sitioCfg = sitioAssoc2();
	$home = $sitioCfg["url"];
	$modulos  = permisos();
require_once('vargenerales.php');
?>
<link rel="stylesheet" type="text/css" href="<?php echo $home; ?>/sadminc/css/menu/css/font-awesome.css">
<link rel="stylesheet" type="text/css" href="<?php echo $home; ?>/sadminc/css/menu/css/menu.css">

<script type="text/javascript" src="<?php echo $home; ?>/sadminc/css/menu/js/function.js"></script>
	
<nav id="navigation">
	<ul id="main-menu">
		<li class="current-menu-item"><a href="<?php echo $home; ?>/sadminc/contenedor.php">Inicio</a></li>
		<li class="parent">
			<a href="#">Sitio</a>
			<ul class="sub-menu">
				<li><a href="<?php echo $home; ?>/sadminc/modulos/idiomas/idiomas_listar.php"><i class="icon-wrench"></i> Información General Sitio</a></li>
        		<?php if(in_array('Usuarios', $modulos)):?>
				<li>
					<a class="parent" href="#"><i class="icon-gift"></i> Administrar Usuarios</a>
					<ul class="sub-menu">
        			<?php if(in_array('Perfiles', $modulos)):?>
						<li><a href="<?php echo $home; ?>/sadminc/modulos/usuarios/perfiles_listar.php">Perfiles</a></li>
        			<?php endif;?>
						<li><a href="<?php echo $home; ?>/sadminc/modulos/usuarios/usuarios_listar.php">Usuarios</a></li>
					</ul>
				</li>
        		<?php endif;?>
				<li><a href="<?php echo $home; ?>/sadminc/modulos/logsistema/log_buscar.php"><i class="icon-gift"></i> Ver Log Sistema</a></li>
        		<?php if(in_array('Menu', $modulos)):?>
				<li><a href="<?php echo $home; ?>/sadminc/modulos/menu/menu_listar.php"><i class="icon-gift"></i> Menú Principal</a></li>
        		<?php endif;?>
			</ul>
		</li>
		<li class="parent">
			<a href="#">Módulos</a>
			<ul class="sub-menu">
				<li><a href="<?php echo $home; ?>/sadminc/modulos/contenidos/contenidos_listar.php"><i class="icon-wrench"></i> Contenidos</a></li>
				<?php 	  		
				$nConexion = Conectar();
				$sql = "select id,titulo,idcategoria from tblmatriz where tipo=1";
				$consulta = mysqli_query($nConexion,$sql);

				while ($row = mysqli_fetch_array($consulta)){
				$sql = "select id,titulo from tblmatriz where idcategoria ='{$row["id"]}' ";
				$categoriasP = mysqli_query($nConexion,$sql);
				$ncategorias = mysqli_num_rows($categoriasP);
				if($ncategorias==0&&$row["idcategoria"]==0):
				?>
				<li><a href="<?php echo $home; ?>/sadminc/modulos/matriz/modulos_listar.php?modulo=<?=$row["id"]?>"><i class="icon-gift"></i> <?=$row["titulo"]?></a></li>
				<?php
				elseif($row["idcategoria"]==0):
				?>
				<li>
					<a class="parent" href="#"><i class="icon-file-alt"></i> <?=$row["titulo"]?></a>
					<ul class="sub-menu">
						<li><a href="<?php echo $home; ?>/sadminc/modulos/matriz/datos-generales.php">Datos Generales</a></li>
						<li><a href="<?php echo $home; ?>/sadminc/modulos/matriz/modulos_categorias_listar.php?modulo=<?=$row["id"]?>">Categorías</a></li>
					</ul>
				</li>
				<?php endif; } ?>
			</ul>
		</li>
		<li class="parent">
			<a href="#">Especiales</a>
			<ul class="sub-menu">
        		<?php if(in_array('Cabezotes', $modulos)):?>
				<li>
					<a class="parent" href="#"><i class="icon-file-alt"></i> Cabezotes JQuery</a>
					<ul class="sub-menu">
						<li><a href="<?php echo $home; ?>/sadminc/modulos/cabezotes/categorias_listar.php">Categorías</a></li>
					</ul>
				</li>
				<?php endif;?>
				<li>
					<a class="parent" href="#"><i class="icon-file-alt"></i> Cinta transportadora</a>
					<ul class="sub-menu">
						<li><a href="<?php echo $home; ?>/sadminc/modulos/cinta_transportadora/categorias_listar.php">Categorías</a></li>
						<li><a href="<?php echo $home; ?>/sadminc/modulos/cinta_transportadora/cabezotes_listar.php">Imágenes</a></li>
					</ul>
				</li>
				<li><a href="<?php echo $home; ?>/sadminc/modulos/videosyoutube/listar_categorias.php"><i class="icon-wrench"></i> Videos Youtube</a></li>
				<li>
					<a class="parent" href="#"><i class="icon-file-alt"></i> Formularios</a>
					<ul class="sub-menu">
					<?php 
					$sql = "select id,titulo from tblmatriz where tipo=2";
					$formularios = mysqli_query($nConexion,$sql);
					while ($form = mysqli_fetch_array($formularios)){ ?>
						<li><a href="<?php echo $home; ?>/sadminc/modulos/matriz/formulario_listar.php?modulo=<?=$form["id"]?>"><?=$form["titulo"]?></a></li>
					<?php } ?>
					</ul>
				</li>
        		<?php if(in_array('Tags', $modulos)):?>	
				<li><a href="<?php echo $home; ?>/sadminc/modulos/tags/tags_listar.php"><i class="icon-wrench"></i> Tags/Palabras Claves</a></li>
				<?php endif;?>
				<li><a href="<?php echo $home; ?>/sadminc/modulos/usuariosExternos/usuarios_listar.php"><i class="icon-wrench"></i> Usuarios</a></li>
			</ul>
		</li>
		<li class="parent">
			<a href="#">Productos</a>
			<ul class="sub-menu">
				<li>
					<a href="<?php echo $home; ?>/sadminc/modulos/tienda/marcas_listar.php"><i class="icon-file-alt"></i> Marcas</a>
					<a href="<?php echo $home; ?>/sadminc/modulos/tienda/especificaciones_listar.php"><i class="icon-file-alt"></i> Especificaciones</a>
					<a href="<?php echo $home; ?>/sadminc/modulos/tienda/colores_listar.php"><i class="icon-file-alt"></i> Colores</a>
					<a href="<?php echo $home; ?>/sadminc/modulos/tienda/listar_categorias.php"><i class="icon-file-alt"></i> Categorías</a>
					<a href="<?php echo $home; ?>/sadminc/modulos/tienda/listar_productos.php?idcategoria=-1"><i class="icon-file-alt"></i> Productos</a>
					<a href="<?php echo $home; ?>/sadminc/modulos/tienda/cupones_listar.php"><i class="icon-gift"></i> Cupones</a>
					<a href="<?php echo $home; ?>/sadminc/modulos/tienda/generar-catalogo.php"><i class="icon-file-alt"></i> Generar catálogo</a>
					<a href="<?php echo $home; ?>/sadminc/modulos/tienda/listar_pedidos.php?idestado=Aprobada"><i class="icon-file-alt"></i> Pedidos</a>
					<a href="<?php echo $home; ?>/sadminc/modulos/importar/subir_archivo.php"><i class="icon-file-alt"></i> Actualizar productos</a>
				</li>
			</ul>
		</li>
		<!--<li class="parent">
			<a href="#">Tareas</a>
			<ul class="sub-menu">
				<li><a href="<?php echo $home; ?>/sadminc/modulos/tareas/configuracion.php"><i class="icon-wrench"></i> Configuración</a></li>
				<li><a href="<?php echo $home; ?>/sadminc/modulos/tareas/empresas_listar.php"><i class="icon-file-alt"></i> Empresas</a></li>
				<li>
					<a class="parent" href="#"><i class="icon-file-alt"></i> Acciones</a>
					<ul class="sub-menu">
						<li><a href="<?php echo $home; ?>/sadminc/modulos/tareas/acciones-categorias.php">Categorías</a></li>
						<li><a href="<?php echo $home; ?>/sadminc/modulos/tareas/acciones.php">Acciones</a></li>
					</ul>
				</li>
				<li><a href="<?php echo $home; ?>/sadminc/modulos/tareas/tareas.php"><i class="icon-wrench"></i> Tareas</a></li>
			</ul>
		</li> -->
        <?php if(in_array('Matriz', $modulos)):?>
		<li class="parent">
			<a href="#">Matriz</a>
			<ul class="sub-menu">
				<li><a href="<?php echo $home; ?>/sadminc/modulos/matriz/categorias_listar.php"><i class="icon-wrench"></i> Categorías</a></li>
				<li><a href="<?php echo $home; ?>/sadminc/modulos/matriz/plantillas_listar.php"><i class="icon-gift"></i> Plantillas</a></li>
				<li><a href="<?php echo $home; ?>/sadminc/modulos/matriz/paginas_listar.php"><i class="icon-wrench"></i> Páginas</a></li>
			</ul>
		</li>
		<?php endif;?>
	</ul>
</nav>