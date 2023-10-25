<?php
  include("../../herramientas/seguridad/seguridad.php");
	include("../../vargenerales.php");
	include("menu_funciones.php");
	$permisos  = permisos("Menu");
?>
<html>
  <head>
    <link href="../../css/administrador.css" rel="stylesheet" type="text/css">
<style type="text/css">
body {
	margin-top: 0px;
	margin-bottom:0px;
	margin-left:0px;
	margin-right:0px;
}

ol.vertical {
	margin: 0 0 9px 0;
	min-height: 10px;
	width:50%;
	text-align:left;
}
ol.vertical li {
	display: block;
	margin: 5px;
	padding: 5px;
	border: 1px solid #cccccc;
	color: #0088cc;
	background: #eeeeee;
	cursor: pointer;
}
ol.vertical li.placeholder {
	position: relative;
	margin: 0;
	padding: 0;
	border: none; 
}
ol.vertical li.placeholder:before {
	position: absolute;
	content: "";
	width: 0;
	height: 0;
	margin-top: -5px;
	left: -5px;
	top: -4px;
	border: 5px solid transparent;
	border-left-color: red;
	border-right: none; 
}
ol {
  list-style-type: none;
}
</style>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  </head>
  <body>
	<? include("../../system_menu.php"); ?><br>
    <h1>LISTA DE MENÚ</h1>
        <ol class="default vertical">
		<?php
			$nIdCiudad = $_SESSION["IdCiudad"];
			$rs_Lista = MenuListar($nIdCiudad);
			$Total 		= MenuTotalRegistros($nIdCiudad);
			while($row=mysqli_fetch_object($rs_Lista)) { ?>
              <li data-id="<?php echo $row->idmenu; ?>">
                <?php echo $row->titulo; ?>
				<?php if($permisos["editar"]==1):?><a style="float:right" href="menu.php?Accion=Editar&Id=<?php echo $row->idmenu; ?>"><img src="../../image/seleccionar.gif" border="0" alt="Seleccionar"></a><?php endif;?>
                <ol>  
				<?php
				$rs_SubOpciones = MenuListarSub($row->idmenu);
				$SubTotal				= SubMenuTotalRegistros($row->idmenu);
				if ( $SubTotal > 0 ) {
					while( $rowSub = mysqli_fetch_object( $rs_SubOpciones ) ) { ?>
                    <li data-id="<?php echo $rowSub->idmenu; ?>">
						<?php echo $rowSub->titulo; ?>
                        <?php if($permisos["editar"]==1):?><a style="float:right" href="menu.php?Accion=Editar&Id=<?php echo $rowSub->idmenu; ?>"><img src="../../image/seleccionar.gif" border="0" alt="Seleccionar"></a><?php endif;?>
                        <ol></ol>     
                    </li>
				<?php
					}  
				 }?>
                </ol>
              </li>
			 <?php } ?>
        </ol>   
		  <?php if($permisos["crear"]==1):?>
              <a href="menu.php?Accion=Adicionar"><img src="../../image/nuevo.gif" border="0" alt="Crear Nuevo Registro."></a><br><br>
          <?php endif;?>
          &copy; todos los derechos reservados por F&eacute;nix Punto Net &nbsp;<a href="mailto:info@fenixpuntonet.com" title="!Esc&iacute;benos!" class="botonAbajo">info@fenixpuntonet.com</a> / <a href="http://www.fenixpuntonet.com" title="Soluciones informáticas" target="_blank" class="botonAbajo">www.fenixpuntonet.com</a>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="jquery-sortable-min.js"></script>
	<script>
	$(function  () {
	  $("ol.default").sortable({
		serialize: function (parent, children, isContainer) {
		  var result = $.extend({}, { id : parent.data('id') });
			if (isContainer)
			{
				return children;
			}
			else if (children[0])
			{
				result.children = children;
			}
	
			return result;
	
		}, 
		onDrop: function (item, container, _super) {
			var dataToSend = $("ol.default").sortable("serialize").get();
	
			console.log(dataToSend);
	
			$.ajax({
				url: "ajax_action.php",
				type: "POST",
				data: {"menu":dataToSend},
				cache: false,
				dataType: "json",
				success: function () {}
			});
			_super(item, container);
		}
	  })
	})  
    </script>
  	</body>
</html>
