<?php
  include("../../herramientas/seguridad/seguridad.php");
  include("../../herramientas/paginar/class.paginaZ.php");
  include("../../funciones_generales.php");
  include("../../vargenerales.php");

  $nConexion = Conectar();
  
  $IdCiudad = $_SESSION["IdCiudad"];
  
  $sql = "SELECT * from tblti_espec group by nombre order by nombre";
  $espec = mysqli_query($nConexion,$sql);
?>

<html>
  <head>
    <meta charset="UTF-8">
  
    <link href="../../css/administrador.css" rel="stylesheet" type="text/css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.jqueryui.min.css" />    
		<script src="https://cdn.datatables.net/1.10.20/js/dataTables.jqueryui.min.js"></script>
		<link href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>

		<title>Lista de Especificaciones</title>


  </head>
  <body>
    <?php include("../../system_menu.php"); ?><br>

    <h1 class="tituloFormulario">LISTA DE ESPECIFICACIONES</h1>
    
    <form action="especificaciones_listar.php" method="post">
    </form>

    <table id="listado" border="0" width="100%" cellspacing="0" cellpadding="0">
      <thead>
        <tr>
          <th>Orden</th>
          <th>Id.</th>
          <th>Nombre</th>
          <th>Editar imagen</th>
          <th align="center">Imagen</th>
          <!--<th>Eliminar</th>-->
        </tr>
      </thead>
        
      <tbody class="reorder_ul reorder-photos-list">
        <?php
    
        $ContFilas = 0;
        $ColorFilaPar = "#FFFFFF";
        $ColorFilaImpar	= "#F0F0F0";
    
        while($row = mysqli_fetch_object($espec)) {
        $ContFilas = $ContFilas+ 1 ;
        if ( fmod( $ContFilas,2 ) == 0 ) {
          $ColorFila = $ColorFilaPar;
        }else {
          $ColorFila = $ColorFilaImpar;
        }
        ?>
        <tr id="image_li_<?php echo $row->idmarca; ?>" class="ui-sortable-handle">
          <td bgcolor="<? echo $ColorFila; ?>"><?=$row->orden; ?></td>
          <td bgcolor="<? echo $ColorFila; ?>"><?=$row->idproducto; ?></td>
          <td bgcolor="<? echo $ColorFila; ?>"><?=$row->nombre; ?></td>
          <td bgcolor="<? echo $ColorFila; ?>" align="center">
            <a href="especificaciones.php?Accion=Editar&Id=<?=$row->nombre?>">
              <img src="../../image/seleccionar.gif" border="0" alt="Seleccionar:<?=$row->nombre;?>">
            </a>
          </td>
          <td bgcolor="<? echo $ColorFila; ?>" align="center">
            <?
            if ( !empty($row->imagen) ) {
              ?><a target="_blank" href="<?=$cRutaImagenEspec.$row->imagen;?>">Ver</a>
              <img src="<?=$cRutaImagenEspec.$row->imagen;?>" alt="" height="40" hspace="0" align="center" border="0" />
            <?
            }
            else {
              echo "No Asignada";
            }
            ?>	    
          </td>
<!--      
          <td bgcolor="<? echo $ColorFila; ?>"align="center">
            <a href="especificaciones.php?Accion=Eliminar&Id=<?=$row->idmarca;?>" onClick="return confirm('¿Seguro que desea eliminar este registro?');">
              <img src="../../image/borrar.gif" border="0" >
            </a>
          </td>
-->      
        </tr>
        <?
        }
      ?>
      </tbody>
    </table>
    
    <table>
      <tr>
        <td colspan="8">&nbsp;</td>
      </tr>
<!--
      <tr>
        <td colspan="8" class="nuevo">
          <a href="especificaciones.php?Accion=Adicionar">
            <img src="../../image/nuevo.gif" border="0" alt="Crear Nuevo Registro.">
          </a>
        </td>
      </tr>
-->
    </table>
    
    <br><br><br><br><br>
    
    <table border="0" width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td class="tablaCreditos">&copy; todos los derechos reservados por F&Eacute;nix Punto Net &nbsp;<a href="mailto:info@fenixpuntonet.com" title="!Esc&iacute;benos!" class="botonAbajo">info@fenixpuntonet.com</a> / <a href="http://www.fenixpuntonet.com" title="Soluciones inform�ticas" target="_blank" class="botonAbajo">www.fenixpuntonet.com</a></td>
      </tr>
    </table>
    
    <script type="text/javascript">
    
$(document).ready(function(){
    $('#listado').DataTable( {
      "order": [[ 0, "asc" ]],
      "sScrollY": 400,
      "sScrollX": true,
      "bScrollCollapse": true,
      "bRetrieve": true,
      "oLanguage": {
        "sSearch": "Búsqueda:",
        "sInfo": "Mostrando _START_ a _END_ de _TOTAL_ entradas",
        "sInfoEmpty": "Tabla vacía",
        "sZeroRecords": "No hay coincidencias",
        "sEmptyTable": "No hay coincidencias",
        "sLengthMenu": "Mostrar _MENU_ entradas",
        "oPaginate": {
          "sFirst":    "<<",
          "sPrevious": "<",
          "sNext":     ">",
          "sLast":     ">>"
        }
      }
    });
	
});
</script>

  	</body>
</html>
