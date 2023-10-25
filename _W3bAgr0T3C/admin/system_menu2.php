<?php
require_once("funciones_generales.php");
	$sitioCfg = sitioAssoc2();
	$home = $sitioCfg["url"];
	$modulos  = permisos();
require_once('vargenerales.php');
?>
<script type="text/javascript" src="<?=$home?>/sadminc/herramientas/JSCookMenu/JSCookMenu.js"></script>
<link rel="stylesheet" href="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/theme.css" type="text/css">
<script type="text/javascript" src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/theme.js"></script>
<!--<script type="text/javascript" src="menu_sadminc.js"></script>-->
<table border="0" cellpadding="0" cellspacing="0" width="100%">
  <tr>
    <td bgcolor="#EFEBDE">
      <div id="myMenuID" align="left"></div>
      <script language="JavaScript" type="text/javascript">
      var myMenu =
      [
        
        [null, 'Inicio', '<?=$home?>/sadminc/contenedor.php', null, 'Panel de Control'],
        _cmSplit,
        [null, 'Sitio', null, null, null,
          ['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_opgenerales.png"/>','Informaci&oacute;n General Sitio','<?=$home?>/sadminc/modulos/idiomas/idiomas_listar.php',null,null],
          _cmSplit,
        <?php if(in_array('Usuarios', $modulos)):?>
		  ['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_usuarios.png"/>','Administrar Usuarios',null,null,null,
        <?php if(in_array('Perfiles', $modulos)):?>
			['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_transparente.png"/>','Perfiles','<?=$home?>/sadminc/modulos/usuarios/perfiles_listar.php',null,null],
        <?php endif;?>
			['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_transparente.png"/>','Usuarios','<?=$home?>/sadminc/modulos/usuarios/usuarios_listar.php',null,null]
		  ],
          _cmSplit,
        <?php endif;?>
          ['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_logsistema.png"/>', 'Ver Log Sistema', '<?=$home?>/sadminc/modulos/logsistema/log_buscar.php', null, null],
          _cmSplit,
          //['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_regboletin.png"/>', 'Ver Registros Bolet&iacute;n', '<?=$home?>/sadminc/modulos/boletines/registros_listar.php', null, null],
          //_cmSplit,
        	<?php if(in_array('Menu', $modulos)):?>
          ['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_menu.png"/>', 'Men&uacute; Principal', '<?=$home?>/sadminc/modulos/menu/menu_listar.php', null, null]
        <?php endif;?>
		],
        _cmSplit,
        <?php if($_SESSION["UsrPerfil"]==1 || $_SESSION["UsrPerfil"]==2 || $_SESSION["UsrPerfil"]==3 || $_SESSION["UsrPerfil"]==4 || $_SESSION["UsrPerfil"]==5):?>
        [null, 'M&oacute;dulos', null, null, null,
          /*['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','Archivos de descarga',null,null,null,
			['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_transparente.png"/>','Categorice las Descargas','<?=$home?>/sadminc/modulos/archivos/archivos_categorias_listar.php',null,null],
			['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_transparente.png"/>','Subir Archivos','<?=$home?>/sadminc/modulos/archivos/archivos_listar.php',null,null]
          ],*/
		  
          /*['<img src="<?=$home;?>sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','Banners Publicitarios',null,null,null,
            ['<img src="<?=$home;?>sadminc/herramientas/JSCookMenu/ThemeOffice/icon_transparente.png"/>','Bloques de Banners','<?=$home;?>sadminc/modulos/banners/bloques_listar.php',null,null],
			['<img src="<?=$home;?>sadminc/herramientas/JSCookMenu/ThemeOffice/icon_transparente.png"/>','Banners','<?=$home;?>sadminc/modulos/banners/banners_listar.php',null,null],
          ],*/
		  
          /*['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','Mapa',null,null,null,
            ['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_transparente.png"/>','Imagen','<?=$home?>/sadminc/modulos/mapa/mapas_listar.php',null,null],
			['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_transparente.png"/>','Lugares','<?=$home?>/sadminc/modulos/mapa/lugares_listar.php',null,null],
          ],*/
		  
		  //['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','Cabezote Animado','<?=$home?>/sadminc/modulos/cabezotes/cabezotes_listar.php',null,null],
		  
		  /*['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','Cabezotes JQuery',null,null,null,
            ['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_transparente.png"/>','Cabezotes','<?=$home?>/sadminc/modulos/cabezotes/cabezotes_listar.php',null,null],
			['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_transparente.png"/>','Categorias','<?=$home?>/sadminc/modulos/cabezotes/categorias_listar.php',null,null],
          ],*/
		  
		  ['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','Cinta Transportadora',null,null,null,
			['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_transparente.png"/>','Categorias','<?=$home?>/sadminc/modulos/cinta_transportadora/categorias_listar.php',null,null],
            ['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_transparente.png"/>','Im&aacute;genes','<?=$home?>/sadminc/modulos/cinta_transportadora/cabezotes_listar.php',null,null],
          ],
		  
		  /*['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','Pantalla Led',null,null,null,
			['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_transparente.png"/>','Categorias','<?=$home?>/sadminc/modulos/pantalla_led/categorias_listar.php',null,null],
            ['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_transparente.png"/>','Frases','<?=$home?>/sadminc/modulos/pantalla_led/frases_listar.php',null,null],
          ],*/
		  
		  /*['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','Fondos',null,null,null,
			['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_transparente.png"/>','Categor&iacute;as','<?=$home?>/sadminc/modulos/fondos/categorias_listar.php',null,null],
            ['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_transparente.png"/>','Imágenes','<?=$home?>/sadminc/modulos/fondos/fondos_listar.php',null,null],
          ],*/
		  
        	<?php if(in_array('Contenidos', $modulos)):?>
		  ['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','Contenidos','<?=$home?>/sadminc/modulos/contenidos/contenidos_listar.php',null,null],
        <?php endif;?>
		  
		  /*['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','Noticias',null,null,null,
			['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_transparente.png"/>','Datos Generales','<?=$home?>/sadminc/modulos/noticias/datos-generales.php',null,null],
			//['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_transparente.png"/>','Categor&iacute;as','<?=$home?>/sadminc/modulos/noticias/noticias_categorias_listar.php',null,null],
			['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_transparente.png"/>','Subir Noticias','<?=$home?>/sadminc/modulos/noticias/noticias_listar.php',null,null]
		  ],*/
		  
		  //['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','Agendas Gremiales','<?=$home?>/sadminc/modulos/agendasGremiales/agendas_listar.php',null,null],
		  //['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','Boletines de Prensa','<?=$home?>/sadminc/modulos/boletinesPrensa/boletines_listar.php',null,null],
		  //['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','Editorial','<?=$home?>/sadminc/modulos/editorial/editorial_listar.php',null,null],
		  
		  /*['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','Eventos',null,null,null,
			//['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_transparente.png"/>','Categor&iacute;as','<?=$home?>/sadminc/modulos/eventos/eventos_categorias_listar.php',null,null],
			['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_transparente.png"/>','Datos Generales','<?=$home?>/sadminc/modulos/eventos/datos-generales.php',null,null],
			['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_transparente.png"/>','Subir Eventos','<?=$home?>/sadminc/modulos/eventos/eventos_listar.php',null,null]
		  ],*/
		  
			//['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','Frases','<?=$home?>/sadminc/modulos/empsemana/empsemana_listar.php',null,null],
		  
		  //['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','Encuestas y sus Estad&iacute;sticas','<?=$home?>/sadminc/modulos/encuestas/encuestas_listar.php',null,null],
		  
		  //['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','Reservaciones','<?=$home?>/sadminc/modulos/agendaEventos/agenda_listar.php',null,null],
		  
		  /*['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','Usuarios registrados',null,null,null,
            ['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_transparente.png"/>','Usuarios','<?=$home?>/sadminc/modulos/usuariosExternos/usuarios_listar.php',null,null],
			['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_transparente.png"/>','Archivos usuarios','<?=$home?>/sadminc/modulos/usuariosExternosArchivos/usuarios_listar.php',null,null]
          ],*/
		  
		  /*['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','Faqs','<?=$home?>/sadminc/modulos/faqs/faqs_listar.php',null,null],*/
		  
        <?php if($_SESSION["UsrPerfil"]==1 || $_SESSION["UsrPerfil"]==2):?>
		  /*['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','Tarjetas de cumpleaños',null,null,null,
			['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_transparente.png"/>','Listado de las Tarjetas','<?=$home?>/sadminc/modulos/tarjetas/tarjetas_listar.php',null,null],
			['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_transparente.png"/>','Listado de Frases','<?=$home?>/sadminc/modulos/frases/frases_listar.php',null,null],
			['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_transparente.png"/>','Enviar Tarjeta','<?=$home?>/sadminc/modulos/tarjetas/enviar.php',null,null],
			['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_transparente.png"/>','Ingresar Datos Nuevos','http://www.concertacionempresarial.com/php/contenido.php?clave=FormDatos&ciudad=1',null,null]
          ],*/
        <?php endif;?>
          
        	<?php if(in_array('Tips', $modulos)):?>
		  /*['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','Tips',null,null,null,
			['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_transparente.png"/>','Datos Generales','<?=$home?>/sadminc/modulos/servicios/datos-generales.php',null,null],
              //['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_transparente.png"/>','Categor&iacute;as','<?=$home?>/sadminc/modulos/servicios/servicios_categorias_listar.php',null,null],
			  ['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_transparente.png"/>','Tips','<?=$home?>/sadminc/modulos/servicios/servicios_listar.php',null,null],
          ],*/
        <?php endif;?>
			<?php 	  		
			$nConexion = Conectar();
			$sql = "select id,titulo,idcategoria from tblmatriz where tipo=1";
			$consulta = mysqli_query($nConexion,$sql);
						
			while ($row = mysqli_fetch_array($consulta)){
			$sql = "select id,titulo from tblmatriz where idcategoria ='{$row["id"]}' ";
			$categorias = mysqli_query($nConexion,$sql);
			$ncategorias = mysqli_num_rows($categorias);
        	if($ncategorias==0&&$row["idcategoria"]==0):
			?>
			['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','<?=$row["titulo"]?>','<?=$home?>/sadminc/modulos/matriz/modulos_listar.php?modulo=<?=$row["id"]?>',null,null],
			<?php
        	elseif($row["idcategoria"]==0):
			?>
			['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','<?=$row["titulo"]?>',null,null,null,
				['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','Datos Generales','<?=$home?>/sadminc/modulos/matriz/datos-generales.php',null,null],
				<?php while ($cat = mysqli_fetch_array($categorias)){ ?>
				['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','<?=$cat["titulo"]?>','<?=$home?>/sadminc/modulos/matriz/modulos_listar.php?modulo=<?=$cat["id"]?>',null,null],
				<?php } ?>
			],
			<?php endif; } ?>
          
		 /* ['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','Tips especiales','<?=$home?>/sadminc/modulos/sitios_sugeridos/sitiossugeridos_listar.php',null,null],*/
        
		],
        <?php endif;?>
        _cmSplit,
        [null, 'Especiales', null, null, null,
          /*['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','Gran Hotel',null,null,null,
          	['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_transparente.png"/>','Planes','<?=$home?>/sadminc/modulos/planes/planes_listar.php',null,null],
          	['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_transparente.png"/>','Bonos','<?=$home?>/sadminc/modulos/planes/planes_bonos_listar.php',null,null]
          ],*/
          //['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','Clientes Im&aacute;genes','<?=$home?>/sadminc/modulos/clientes_img/clientes_img_listar.php',null,null],
          
		  //['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','Ciudades','<?=$home?>/sadminc/modulos/ciudades/ciudades_listar.php',null,null],
          
		  //['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','Videos','<?=$home?>/sadminc/modulos/videos/listar_categorias.php',null,null],
          
			/*['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','Tickets',null,null,null,
				['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_transparente.png"/>','Empresas','<?=$home?>/sadminc/modulos/tickets/empresas_listar.php',null,null],
				['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_transparente.png"/>','Regiones','<?=$home?>/sadminc/modulos/tickets/regiones_listar.php',null,null],
				['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_transparente.png"/>','Zonas','<?=$home?>/sadminc/modulos/tickets/zonas_listar.php',null,null],
				['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_transparente.png"/>','Sedes','<?=$home?>/sadminc/modulos/tickets/sedes_listar.php',null,null],
				['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_transparente.png"/>','Usuarios','<?=$home?>/sadminc/modulos/tickets/usuarios_listar.php',null,null],
				['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_transparente.png"/>','Tickets','<?=$home?>/sadminc/modulos/tickets/tickets_empresas.php',null,null],
					['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','Evaluaciones',null,null,null,
						['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_transparente.png"/>','Plantillas Evaluaciones','<?=$home?>/sadminc/modulos/tickets/evaluaciones/p_evaluaciones_listar.php',null,null],
						['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_transparente.png"/>','Preguntas','<?=$home?>/sadminc/modulos/tickets/evaluaciones/preguntas_listar.php',null,null],
						['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_transparente.png"/>','Evaluaciones Realizadas','<?=$home?>/sadminc/modulos/tickets/evaluaciones/evaluaciones_listar.php',null,null],
					],
			],*/
		  
			  /*['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','Membresia',null,null,null,
				['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','Membresias','<?=$home?>/sadminc/modulos/membresias/membresias_listar.php',null,null],
                                ['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','Categorias','<?=$home?>/sadminc/modulos/membresias/categorias_listar.php',null,null],
                                ['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','Documentos','<?=$home?>/sadminc/modulos/membresias/contenidos_listar.php',null,null],
                                ['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','Archivos','<?=$home?>/sadminc/modulos/membresias/archivos_listar.php',null,null],
				['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','Usuarios','<?=$home?>/sadminc/modulos/membresias/usuarios_listar.php',null,null],
			  ],*/

			//['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','Videos YouTube','<?=$home?>/sadminc/modulos/videosyoutube/listar_categorias.php',null,null],
			
			/*['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','M&uacute;sica/MP3',null,null,null,
				['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','Categor&iacute;as','<?=$home?>/sadminc/modulos/musica/categorias_listar.php',null,null],
				['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','M&uacute;sica/MP3','<?=$home?>/sadminc/modulos/musica/listar.php',null,null],
			],*/
			
			//['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','RadioBlog','<?=$home?>/sadminc/modulos/radioblog/listar.php',null,null],
			
			//['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','Pizarra Virtual','<?=$home?>/sadminc/modulos/mensajes/listar.php',null,null],
			
			//['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','Filtro de Palabras','<?=$home?>/sadminc/modulos/filtropalabras/listar.php',null,null],
			
			//['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','Direccion IP Bloqueadas','<?=$home?>/sadminc/modulos/filtropalabras/direccionesip.php',null,null],
	  
			/*['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','Boletines Electr&oacute;nicos',null,null,null,
				//['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','Listado de los Boletines','<?=$home?>/sadminc/modulos/generador_boletines/boletines_listar.php',null,null],
				['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','Correos Electr&oacute;nicos','<?=$home?>/sadminc/modulos/boletines/registrar_correo.php',null,null],
				['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','Listas de Correos','<?=$home?>/sadminc/modulos/boletines/registrar_lista.php',null,null],
			],*/
			
			//['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','Reservaciones de la Agenda','<?=$home?>/sadminc/modulos/agenda/listar.php',null,null],
			
			//['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','Registro de Personas','<?=$home?>/sadminc/modulos/registrodatos/registros_listar.php',null,null],
			
			//['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','Incripciones Ciudad Aventura 2010','<?=$home?>/sadminc/modulos/registrodatosINSCRIPCIONES/registros_listar.php',null,null],
			
			/*['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','Foro',null,null,null,
				['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','Categorias del Foro','<?=$home?>/sadminc/modulos/foro/listar_categorias.php',null,null],
				['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','Temas del Foro','<?=$home?>/sadminc/modulos/foro/listar_temas.php',null,null],
				['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','Comentarios del Foro','<?=$home?>/sadminc/modulos/foro/listar_comentarios.php',null,null],
			],*/
			
			/*['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','preguntas al Especialista',null,null,null,
				['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','Profesiones','<?=$home?>/sadminc/modulos/especialistas/listar_profesiones.php',null,null],
				['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','Especialistas','<?=$home?>/sadminc/modulos/especialistas/listar_especialistas.php',null,null],
				['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','Preguntas','<?=$home?>/sadminc/modulos/especialistasPreguntas/listar.php',null,null],
			],*/
			
			//['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','Frase del D&iacute;a','<?=$home?>/sadminc/modulos/ofertasemana/ofertasemana_listar.php',null,null],  
			
			//['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','Comentarios Generales','<?=$home?>/sadminc/modulos/comentarios/listar.php',null,null],
		  
        	<?php if(in_array('Cabezotes', $modulos)):?>
		  ['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','Cabezotes JQuery',null,null,null,
			['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_transparente.png"/>','Categor&iacute;as','<?=$home?>/sadminc/modulos/cabezotes/categorias_listar.php',null,null],
          ],
			<?php endif;?>
			
        	<?php if(in_array('Galeria', $modulos)):?>
		  ['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','Galer&iacute;a Fotos',null,null,null,
            ['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_transparente.png"/>','Categorice las Fotos','<?=$home?>/sadminc/modulos/imagenes/imagenes_categorias_listar.php',null,null],
			['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_transparente.png"/>','Fotos','<?=$home?>/sadminc/modulos/imagenes/imagenes_listar.php',null,null]
          ],
			<?php endif;?>
			  
        	<?php if(in_array('Productos', $modulos)):?>	
			  ['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','Productos',null,null,null,
				['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_transparente.png"/>','Datos Generales','<?=$home?>/sadminc/modulos/tienda/datos-generales.php',null,null],
				//['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_transparente.png"/>','Mensajes Correos','<?=$home?>/sadminc/modulos/tienda/informacion.php',null,null],
				['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','Categor&iacute;as','<?=$home?>/sadminc/modulos/tienda/listar_categorias.php',null,null],
				//['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','Marcas','<?=$home?>/sadminc/modulos/tienda/marcas_listar.php',null,null],
				//['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','Colores','<?=$home?>/sadminc/modulos/tienda/colores_listar.php',null,null],
				//['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','Materiales','<?=$home?>/sadminc/modulos/tienda/deportes_listar.php',null,null],
				//['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','Tecnolog&iacute;as','<?=$home?>/sadminc/modulos/tienda/tecnologias_listar.php',null,null],
				//['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','Cupones','<?=$home?>/sadminc/modulos/tienda/cupones_cat_listar.php',null,null],
				['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','Pedidos','<?=$home?>/sadminc/modulos/tienda/listar_pedidos.php',null,null],
				//['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','Configurar','<?=$home?>/sadminc/modulos/tienda/configurar.php',null,null],
			  ],
			<?php endif;?>
			
		  ['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','Formularios',null,null,null,
				<?php 
				$sql = "select id,titulo from tblmatriz where tipo=2";
				$formularios = mysqli_query($nConexion,$sql);
				while ($form = mysqli_fetch_array($formularios)){ ?>
				['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','<?=$form["titulo"]?>','<?=$home?>/sadminc/modulos/matriz/formulario_listar.php?modulo=<?=$form["id"]?>',null,null],
				<?php } ?>
          ],
			  
			//['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','Modificar CSS','<?=$home?>/sadminc/modulos/css/css_listar.php',null,null],
			
			/*['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','Documentos Especiales',null,null,null,
				['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','Plantillas','<?=$home?>/sadminc/modulos/documentos/plantillas_listar.php',null,null],
				['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','Contenidos','<?=$home?>/sadminc/modulos/documentos/contenidos_listar.php',null,null],
				['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','Enviar','<?=$home?>/sadminc/modulos/documentos/enviar.php',null,null],
				['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','Ver Registro','<?=$home?>/sadminc/modulos/documentos/registros_listar.php',null,null],
			
			],*/
			
        	<?php if(in_array('Tags', $modulos)):?>	
			['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','Tags/Palabras Claves','<?=$home?>/sadminc/modulos/tags/tags_listar.php',null,null],
			//['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','Invitados','<?=$home?>/sadminc/modulos/invitados/registrar_correo.php',null,null],
			  
			  /*['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','Usuarios Registrados',null,null,null,
				['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','Datos Usuarios','<?=$home?>/sadminc/modulos/trabajosusuareg/archivos_login_listar_usuareg.php',null,null],
				['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_modulos.png"/>','Trabajos Usuarios','<?=$home?>/sadminc/modulos/trabajosusuareg/archivos_usuareg_listar.php',null,null],
			  ],*/	 
			],
			<?php endif;?>
        _cmSplit,
        <?php if(in_array('Matriz', $modulos)):?>
        [null, 'Matriz', null, null, null,
          ['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_opgenerales.png"/>','Categorias','<?=$home?>/sadminc/modulos/matriz/categorias_listar.php',null,null],
          ['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_opgenerales.png"/>','Plantillas','<?=$home?>/sadminc/modulos/matriz/plantillas_listar.php',null,null],
          //['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_opgenerales.png"/>','Paginas estaticas','<?=$home?>/sadminc/modulos/matriz/estaticas_listar.php',null,null],
          ['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_opgenerales.png"/>','Paginas','<?=$home?>/sadminc/modulos/matriz/paginas_listar.php',null,null],
          //['<img src="<?=$home?>/sadminc/herramientas/JSCookMenu/ThemeOffice/icon_opgenerales.png"/>','Formularios','<?=$home?>/sadminc/modulos/matriz/formularios_listar.php',null,null],
		],
			<?php endif;?>
			];
			</script>

      <!-- FIN Menu-->

      <!-- Imprimir Menu -->
      <script language="JavaScript" type="text/javascript">
      cmDraw ('myMenuID', myMenu, 'hbr', cmThemeOffice, 'ThemeOffice');
      </script>
      <!-- FIN Imprimir Menu -->
    </td>
  </tr>
</table>