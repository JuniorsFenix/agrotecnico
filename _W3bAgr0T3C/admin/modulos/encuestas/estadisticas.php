<?

  include("../../herramientas/seguridad/seguridad.php");

  include("../../funciones_generales.php");

	include("../../vargenerales.php");



	// Imprime las estadisticas de una encuesta

	$IdEncuesta = $_GET["id"];

	$nConexion			= Conectar();

	$Reg_Encuesta		= mysqli_fetch_object( mysqli_query($nConexion,"SELECT * FROM tblencuestas WHERE idencuesta = $IdEncuesta") );

	$Reg_Respuestas		= mysqli_fetch_object( mysqli_query($nConexion,"SELECT idencuesta,totalvotos,((respuesta1/totalvotos)*100) AS p1,respuesta1,((respuesta2/totalvotos)*100) AS p2,respuesta2,((respuesta3/totalvotos)*100) AS p3,respuesta3,((respuesta4/totalvotos)*100) AS p4,respuesta4,((respuesta5/totalvotos)*100) AS p5,respuesta5,((respuesta6/totalvotos)*100) AS p6,respuesta6,((respuesta7/totalvotos)*100) AS p7,respuesta7,((respuesta8/totalvotos)*100) AS p8,respuesta8,((respuesta9/totalvotos)*100) AS p9,respuesta9,((respuesta10/totalvotos)*100) AS p10,respuesta10,((respuestaOtro/totalvotos)*100) AS pOtro,respuestaOtro FROM tblencuestarespuestas WHERE idencuesta = $IdEncuesta") );

	$sql = "SELECT idencuesta,totalvotos,(totalvotos/(SELECT totalvotos FROM tblencuestarespuestas where idencuesta=".$IdEncuesta."))*100 As pOtro,respuesta FROM tblencuestarespuestasotro WHERE idencuesta =".$IdEncuesta." GROUP BY respuesta";
	$Reg_respuestas_Otro = mysqli_query($nConexion,$sql);
	
	mysqli_close($nConexion);

	?>

<html>

  <head>

    <link href="../../css/administrador.css" rel="stylesheet" type="text/css">

<style type="text/css">

<!--

body {

	margin-top: 0px;

	margin-bottom:0px;

	margin-left:0px;

	margin-right:0px;

}

-->

</style>

  </head>

  <body>

<? include("../../system_menu.php"); ?><br>



	<table border="0" cellspacing="2" cellpadding="0" align="center">

	<tr><td colspan="4"><div align="center"><strong>Resultados Votaci�n</strong></div></td></tr>

	<tr><td colspan="4">&nbsp;</td></tr>

	<tr><td colspan="4"><div align="justify"><? echo $Reg_Encuesta->pregunta; ?></div></td></tr>

	<tr><td colspan="4">&nbsp;</td></tr>

	<tr>

		<td><div align="center"><strong>Respuestas</strong></div></td>

		<td><div align="center"><strong>Grafico</strong></div></td>

		<td><div align="center"><strong>Votos</strong></div></td>

		<td><div align="center"><strong>Porcentaje</strong></div></td>

	</tr>

	<?

		if ( !empty( $Reg_Encuesta->respuesta1 ) )

		{

		?>

		<tr>

			<td><? echo $Reg_Encuesta->respuesta1; ?></td>

			<td><img src="../../image/grafico.gif" width="<? echo 5*$Reg_Respuestas->p1; ?>" height="5"></td>

			<td><div align="center"><? echo $Reg_Respuestas->respuesta1; ?></div></td>

			<td><div align="center"><? echo $Reg_Respuestas->p1."%"; ?></div></td>

		</tr>

		<?

		}

	?>



	<?

		if ( !empty( $Reg_Encuesta->respuesta2 ) )

		{

		?>

		<tr>

			<td><? echo $Reg_Encuesta->respuesta2; ?></td>

			<td><img src="../../image/grafico2.gif" width="<? echo 5*$Reg_Respuestas->p2; ?>" height="5"></td>

			<td><div align="center"><? echo $Reg_Respuestas->respuesta2; ?></div></td>

			<td><div align="center"><? echo $Reg_Respuestas->p2."%"; ?></div></td>

		</tr>

		<?

		}

	?>



	<?

		if ( !empty( $Reg_Encuesta->respuesta3 ) )

		{

		?>

		<tr>

			<td><? echo $Reg_Encuesta->respuesta3; ?></td>

			<td><img src="../../image/grafico3.gif" width="<? echo 5*$Reg_Respuestas->p3; ?>" height="5"></td>

			<td><div align="center"><? echo $Reg_Respuestas->respuesta3; ?></div></td>

			<td><div align="center"><? echo $Reg_Respuestas->p3."%"; ?></div></td>

		</tr>

		<?

		}

	?>



	<?

		if ( !empty( $Reg_Encuesta->respuesta4 ) )

		{

		?>

		<tr>

			<td><? echo $Reg_Encuesta->respuesta4; ?></td>

			<td><img src="../../image/grafico4.gif" width="<? echo 5*$Reg_Respuestas->p4; ?>" height="5"></td>

			<td><div align="center"><? echo $Reg_Respuestas->respuesta4; ?></div></td>

			<td><div align="center"><? echo $Reg_Respuestas->p4."%"; ?></div></td>

		</tr>

		<?

		}

	?>



	<?

		if ( !empty( $Reg_Encuesta->respuesta5 ) )

		{

		?>

		<tr>

			<td><? echo $Reg_Encuesta->respuesta5; ?></td>

			<td><img src="../../image/grafico5.gif" width="<? echo 5*$Reg_Respuestas->p5; ?>" height="5"></td>

			<td><div align="center"><? echo $Reg_Respuestas->respuesta5; ?></div></td>

			<td><div align="center"><? echo $Reg_Respuestas->p5."%"; ?></div></td>

		</tr>

		<?

		}

	?>



	<?

		if ( !empty( $Reg_Encuesta->respuesta6 ) )

		{

		?>

		<tr>

			<td><? echo $Reg_Encuesta->respuesta6; ?></td>

			<td><img src="../../image/grafico6.gif" width="<? echo 5*$Reg_Respuestas->p6; ?>" height="5"></td>

			<td><div align="center"><? echo $Reg_Respuestas->respuesta6; ?></div></td>

			<td><div align="center"><? echo $Reg_Respuestas->p6."%"; ?></div></td>

		</tr>

		<?

		}

	?>



	<?

		if ( !empty( $Reg_Encuesta->respuesta7 ) )

		{

		?>

		<tr>

			<td><? echo $Reg_Encuesta->respuesta7; ?></td>

			<td><img src="../../image/grafico7.gif" width="<? echo 5*$Reg_Respuestas->p7; ?>" height="5"></td>

			<td><div align="center"><? echo $Reg_Respuestas->respuesta7; ?></div></td>

			<td><div align="center"><? echo $Reg_Respuestas->p7."%"; ?></div></td>

		</tr>

		<?

		}

	?>



	<?

		if ( !empty( $Reg_Encuesta->respuesta8 ) )

		{

		?>

		<tr>

			<td><? echo $Reg_Encuesta->respuesta8; ?></td>

			<td><img src="../../image/grafico8.gif" width="<? echo 5*$Reg_Respuestas->p8; ?>" height="5"></td>

			<td><div align="center"><? echo $Reg_Respuestas->respuesta8; ?></div></td>

			<td><div align="center"><? echo $Reg_Respuestas->p8."%"; ?></div></td>

		</tr>

		<?

		}

	?>



	<?

		if ( !empty( $Reg_Encuesta->respuesta9 ) )

		{

		?>

		<tr>

			<td><? echo $Reg_Encuesta->respuesta9; ?></td>

			<td><img src="../../image/grafico9.gif" width="<? echo 5*$Reg_Respuestas->p9; ?>" height="5"></td>

			<td><div align="center"><? echo $Reg_Respuestas->respuesta9; ?></div></td>

			<td><div align="center"><? echo $Reg_Respuestas->p9."%"; ?></div></td>

		</tr>

		<?

		}

	?>
	<?
		if ( !empty( $Reg_Encuesta->respuesta10 ) ) {
		?>
		<tr>
			<td><? echo $Reg_Encuesta->respuesta10; ?></td>
			<td><img src="../../image/grafico10.gif" width="<? echo 5*$Reg_Respuestas->p10; ?>" height="5"></td>
			<td><div align="center"><? echo $Reg_Respuestas->respuesta10; ?></div></td>
			<td><div align="center"><? echo $Reg_Respuestas->p10."%"; ?></div></td>
		</tr>
		<?
		}
	?>
	<?

		if ( !empty( $Reg_Encuesta->respuestaOtro ) ) {
		?>
		<tr>
			<td><? echo $Reg_Encuesta->respuestaOtro; ?></td>
			<td><img src="../../image/grafico3.gif" width="<? echo 5*$Reg_Respuestas->pOtro; ?>" height="5"></td>
			<td><div align="center"><? echo $Reg_Respuestas->respuestaOtro; ?></div></td>
			<td><div align="center"><? echo $Reg_Respuestas->pOtro."%"; ?></div></td>
		</tr>
		<?
		}
	?>

<tr>
  <td><div align="center"><strong>TOTAL</strong></div></td>
  <td colspan=2>&nbsp;</td>
  <td ><div align="center"><strong>100%</strong></div></td></tr>
<tr><td colspan=4>&nbsp;</td></tr>
<tr><td colspan=4><div align="center"><strong>Detalle Otro/a</strong></div></td></tr>

            <?php while($r = mysqli_fetch_assoc($Reg_respuestas_Otro)):?>
            <tr>
              <td><?=$r["respuesta"];?></td>
              <td><img src="../../image/grafico10.gif" width="<?=5*$r["pOtro"]; ?>" height="5"></td>
              <td><div align="center"><?=$r["totalvotos"]; ?></div></td>
              <td><div align="center"><?=$r["pOtro"]."%"; ?></div></td>
            </tr>
            <?
            endwhile;
          ?>          
<tr><td colspan=4>&nbsp;</td></tr>          

	<tr><td colspan="4"><div align="center"><strong>TOTAL VOTOS: <? echo $Reg_Respuestas->totalvotos; ?></strong></div></td></tr>

	</table>

 	</body>

</html>









