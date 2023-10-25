<?php
include("../../herramientas/seguridad/seguridad.php");
include ("../../vargenerales.php");
require_once("../../funciones_generales.php");

	$nConexion = Conectar();
	mysqli_set_charset($nConexion,'utf8');
?>
<!DOCTYPE HTML>
<html>
  <head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="../../css/administrador.css" rel="stylesheet" type="text/css">
    <link href="../../herramientas/select-list-actions/css/site.css" rel="stylesheet" type="text/css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

		<title>Generar catálogo</title>

  	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  </head>
  <body>
  <?php include("../../system_menu.php"); ?><br>
  <div class="container">
    <h1 class="tituloFormulario">Generar catálogo</h1>
    <form method="post" action="catalogo.php" enctype="multipart/form-data">
    <table id="listado" cellspacing="0" width="100%">
        <tbody>
            <tr>
                <td>
                  <div id="selector1" class="form-group">
                      <div class="subject-info-box-1">
                          <label>Categorías disponibles</label>
                          <select multiple class="form-control w-100 lstBox1">
						<?php
							$nConexion = Conectar();
							mysqli_set_charset($nConexion,'utf8');
                        $query = "SELECT * FROM tblti_categorias 
                         WHERE idcategoria!=0 AND idcategoria_superior=0 AND 
                         (idcategoria IN (SELECT idcategoria FROM tblti_productos) 
                            OR idcategoria IN 
                            (SELECT c.idcategoria_superior FROM tblti_categorias c INNER JOIN tblti_productos p ON c.idcategoria=p.idcategoria)) 
                             order by orden";
                            
							$result= mysqli_query($nConexion,$query);
								while($rax=mysqli_fetch_assoc($result)): ?>
                                    <option value="<?php echo $rax["idcategoria"];?>"><?php echo $rax["nombre"];?></option>
							<?php endwhile; ?>
                          </select>
                      </div>
        
                      <div class="subject-info-arrows text-center">
                          <br /><br />
                          <input type="button" value=">>" class="btn btn-info btnAllRight" /><br />
                          <input type="button" value=">" class="btn btn-info btnRight" /><br />
                          <input type="button" value="<" class="btn btn-info btnLeft" /><br />
                          <input type="button" value="<<" class="btn btn-info btnAllLeft" />
                      </div>
        
                      <div class="subject-info-box-2">
                          <label>Categorías seleccionadas</label>
                          <select name="categorias[]" multiple class="form-control w-100 lstBox2">
                          </select>
                      </div>
                      <div class="clearfix"></div>
                  </div>
                  <div id="selector2" class="form-group">
                      <div class="subject-info-box-1">
                          <label>Marcas disponibles</label>
                          <select multiple class="form-control w-100 lstBox1">
						<?php
							$nConexion = Conectar();
							mysqli_set_charset($nConexion,'utf8');
                        $query = "SELECT * FROM tblti_marcas WHERE idmarca IN (SELECT idmarca FROM tblti_productos WHERE activo=1) ORDER BY orden";
                            
							$result= mysqli_query($nConexion,$query);
								while($rax=mysqli_fetch_assoc($result)): ?>
                                    <option value="<?php echo $rax["idmarca"];?>"><?php echo $rax["nombre"];?></option>
							<?php endwhile; ?>
                          </select>
                      </div>
        
                      <div class="subject-info-arrows text-center">
                          <br /><br />
                          <input type="button" value=">>" class="btn btn-info btnAllRight" /><br />
                          <input type="button" value=">" class="btn btn-info btnRight" /><br />
                          <input type="button" value="<" class="btn btn-info btnLeft" /><br />
                          <input type="button" value="<<" class="btn btn-info btnAllLeft" />
                      </div>
        
                      <div class="subject-info-box-2">
                          <label>Marcas seleccionadas</label>
                          <select name="marcas[]" multiple class="form-control w-100 lstBox2">
                          </select>
                      </div>
                      <div class="clearfix"></div>
                  </div>
                </td>
            </tr>
            <tr>
                <td colspan="6" class="nuevo">
                    <a href="catalogo.php" class="btn btn-primary">Catálogo completo</a> <input type="submit" class="generar btn btn-success" value="Generar catálogo" title="Generar catálogo" />
                </td>
            </tr>
        </tbody>
    </table>
    </form>
      <br><br><br><br><br>
      <table border="0" width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td class="tablaCreditos">&copy; todos los derechos reservados por F&Eacute;nix Punto Net &nbsp;<a href="mailto:info@fenixpuntonet.com" title="!Esc&iacute;benos!" class="botonAbajo">info@fenixpuntonet.com</a> / <a href="http://www.fenixpuntonet.com" title="Soluciones informáticas" target="_blank" class="botonAbajo">www.fenixpuntonet.com</a></td>
      </tr>
      </table>
    </div>
    <script src="../..//herramientas/select-list-actions/js/jquery.selectlistactions.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	<script>
		$('.btnRight').click(function (e) {
			var id = '#'+$(this).closest('.form-group').attr('id');
			$('select').moveToListAndDelete(id+' .lstBox1', id+' .lstBox2');
			e.preventDefault();
		});

		$('.btnAllRight').click(function (e) {
			var id = '#'+$(this).closest('.form-group').attr('id');
			$('select').moveAllToListAndDelete(id+' .lstBox1', id+' .lstBox2');
			e.preventDefault();
		});

		$('.btnLeft').click(function (e) {
			var id = '#'+$(this).closest('.form-group').attr('id');
			$('select').moveToListAndDelete(id+' .lstBox2', id+' .lstBox1');
			e.preventDefault();
		});

		$('.btnAllLeft').click(function (e) {
			var id = '#'+$(this).closest('.form-group').attr('id');
			$('select').moveAllToListAndDelete(id+' .lstBox2', id+' .lstBox1');
			e.preventDefault();
		});

		$('.generar').on('click', function () {
			$('.lstBox2 option').prop('selected', true);
		});
	</script>
    </body>
</html>