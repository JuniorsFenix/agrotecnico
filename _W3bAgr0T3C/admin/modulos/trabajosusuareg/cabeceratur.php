<?
  include("seguridad2.php");
	include("../../funciones_generales.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>
</head>
<body>
<table align="center" width="90%"  border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td bgcolor="#DFDFDF">
			<table align="left" bgcolor="#DFDFDF">
				<tr>
					<td>
						<b class="fecha">
							<?
								session_start();
								echo "Sesión Iniciada por: " . $_SESSION["UsrNombre"] . " " . $_SESSION["UsrApellido"] ;
							?>
						</b>
					</td>
					
				</tr>
			</table>
		</td>
		<td bgcolor="#DFDFDF">
			<table align="right" bgcolor="#DFDFDF">
				<tr>
				<td><a href="editmiregistrotur.php?Accion=Editar&Id=<? echo $_SESSION["UsrId"]; ?>"><img src="../../image/seleccionar.gif" border="0" alt="Editar:<? echo $_SESSION["UsrNombre"]; ?>">editar mis datos</a></td>
					<td><a href="logout.php" class="botonesBloque"><img src="../../image/iconoSesion.gif" border="0" width="18" height="10" align="absmiddle" alt="Cerrar Sesi&oacute;n"></a></td>
					<td><a href="logout.php" class="botonesBloque">cerrar sesi&oacute;n</a></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2" class="tablaPrincipal">	  <table border="0" width="100%" background="image/repetirCabecera.jpg">

          <tr>
            <td height="30" align="center" class="tituloFormulario"><b>SUBIR IMAGENES</b></td>
          </tr>
		  
         <tr>
               <td align="center"> <!-- Formulario Ingreso de Eventos -->
    <form method="post" action="subirfotostur.php?Accion=Guardar" enctype="multipart/form-data">
      <input TYPE="hidden" id="txtId" name="txtId" value="">
      <table width="95%"align="center" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td colspan="" align="right" class="">
                <table width="95%" align="center">
                  <?php // Inicio de subir imagenes 
					  for($i=1;$i<=5;$i++):?>
                  <tr>
                    <td width="37%" align="right" class="tituloNombres">Imagen
                        <?=$i;?>:</td>
                    <td width="63%" align="left" class="contenidoNombres">
                      <input type="file" name="archivo<?=$i;?>">
                    </td>
                  </tr>
                  <?php //Fin subir imagenes
	  				endfor;?>
                </table>
				<tr>
                <input type="hidden" id="txtcreadopor" name="txtcreadopor" value="<? echo $_SESSION["UsrNombre"] ." ".$_SESSION["UsrApellido"]; ?>">
                <td colspan="" align="center" class="tituloFormulario">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="" class="nuevo" align="center">
                  <input name="image" type="image" src="../../image/guardar.gif" alt="Guardar Registro.">
                  <a href="cabeceratur.php"><img src="../../image/cancelar.gif" border="0" alt="Cancelar y Regresar."></a></td>
              </tr>
      </table>
    </form>
	 </td>
     </tr>  
     </table></td>
	</tr>
</table>
</body>
</html>
