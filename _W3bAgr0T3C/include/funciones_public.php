<?php
require_once dirname(__FILE__) . ("/connect.php");
require_once dirname(__FILE__) . ("/../admin/herramientas/seguridad/validate.php");
require_once dirname(__FILE__) . ("/../admin/herramientas/paginar/dbquery.inc.php");
require_once dirname(__FILE__) . ("/../admin/herramientas/XPM4-v.0.4/MAIL.php");

/*global $IdCiudad;
$IdCiudad=varValidator::validateReqInt("get","ciudad",true);
  if(is_null($IdCiudad)){
  echo "Valor de entrada invalido para la variable ciudad";
  exit;
}*/

function ValCiudad()
{
  /*if ( !isset( $_GET["ciudad"] ) ){
    echo "<script language=\"javascript\">location.href='index.php'</script>";
    exit;
  }
  else{
    if ( $_GET["ciudad"] <= 0 ){
      echo "<script language=\"javascript\">location.href='index.php'</script>";
      exit;
    }
  }*/
}

function CargarMusica($orden = '', $registros = -1)
{
  $sql = "select * from tblmusica";

  if ($orden != "") {
    $sql .= " order by {$orden}";
  }

  if ($registros > 0) {
    $sql .= " limit {$registros}";
  }

  $nConexion    = Conectar();
  $ra = mysqli_query($nConexion, $sql);
  return $ra;
}

function CargarMensajes($orden = '', $registros = -1)
{
  $sql = "select * from tblmensajes where trim(mensaje)<>''";

  if ($orden != "") {
    $sql .= " order by {$orden}";
  }

  if ($registros > 0) {
    $sql .= " limit {$registros}";
  }

  $nConexion    = Conectar();
  $ra = mysqli_query($nConexion, $sql);
  return $ra;
}

function CargarMensaje($idMensaje = -1)
{

  if ($idMensaje != "") {
    $sql = "select * from tblmensajes where idmensaje={$idMensaje}";
    $nConexion    = Conectar();
    $ra = mysqli_query($nConexion, $sql);
    return $ra;
  }
}

// Lista las subcategorias de una categoria recibida como parametro

function CategoriasArchivos($categoria)
{

  $nConexion    = Conectar();
  $sql = "SELECT * FROM tblcategoriasarchivos WHERE url = '$categoria'";
  $ra = mysqli_query($nConexion, $sql);
  return mysqli_fetch_assoc($ra);
}

function CategoriasNoticias($categoria)
{

  $nConexion    = Conectar();
  $sql = "SELECT * FROM tblcategoriasnoticias WHERE url = '$categoria'";
  $ra = mysqli_query($nConexion, $sql);
  return mysqli_fetch_assoc($ra);
}

function Guardar_Bono($txtNombres, $txtNroPersonas, $txtSede, $f_date_a, $f_date_b)
{
  $nConexion    = Conectar();
  mysqli_query($nConexion, "INSERT INTO tblplanes_reg ( nombres , nropersonas , sede , fecha_ent , fecha_sal , fecha_inscripcion ) VALUES ( '$txtNombres' , $txtNroPersonas , '$txtSede' , '$f_date_a' , '$f_date_b' , now() )");
  echo mysqli_error($nConexion);
  mysqli_close($nConexion);
}

function Titulo_Sitio()
{
  $nConexion    = Conectar();
  $cTitulo      = mysqli_fetch_object(mysqli_query($nConexion, "SELECT titulo FROM tblgenerales LIMIT 1"));
  mysqli_close($nConexion);
  return $cTitulo->titulo;
}

function Meta_Tag_Descripcion_Noticias()
{
  $nConexion = Conectar();
  $sql = "SELECT * FROM tblsitio";
  $ra = mysqli_query($nConexion, $sql);
  if (!$ra) {
    return null;
  }
  $row = mysqli_fetch_array($ra);
  echo "<meta name='keywords' content='{$row['noticias']}'>\n";
}

function Meta_Tag_Descripcion_Musica()
{
  $nConexion = Conectar();
  $sql = "SELECT * FROM tblsitio";
  $ra = mysqli_query($nConexion, $sql);
  if (!$ra) {
    return null;
  }
  $row = mysqli_fetch_array($ra);
  echo "<meta name='description' content='{$row['musica']}'>\n";
}

function Meta_Tag_Descripcion_Editoriales()
{
  $nConexion = Conectar();
  $sql = "SELECT * FROM tblsitio";
  $ra = mysqli_query($nConexion, $sql);
  if (!$ra) {
    return null;
  }
  $row = mysqli_fetch_array($ra);
  echo "<meta name='description' content='{$row['editorial']}'>\n";
}

function Meta_Tag_Descripcion_Eventos()
{
  $nConexion = Conectar();
  $sql = "SELECT * FROM tblsitio";
  $ra = mysqli_query($nConexion, $sql);
  if (!$ra) {
    return null;
  }
  $row = mysqli_fetch_array($ra);
  echo "<meta name='description' content='{$row['eventos']}'>\n";
}

function Meta_Tag_Descripcion_Tips()
{
  $nConexion = Conectar();
  $sql = "SELECT * FROM tblsitio";
  $ra = mysqli_query($nConexion, $sql);
  if (!$ra) {
    return null;
  }
  $row = mysqli_fetch_array($ra);
  echo "<meta name='description' content='{$row['tips']}'>\n";
}

function Meta_Tag_Descripcion_Contenido()
{
  $RegContenido = mysqli_fetch_object(VerContenido("MetaTagDescripcionContenido"));
  echo "<meta name='description' content='$RegContenido->contenido'>\n";
}

function Meta_Tag_Descripcion_Foro()
{
  $RegContenido = mysqli_fetch_object(VerContenido("MetaTagDescripcionForo"));
  echo "<meta name='description' content='$RegContenido->contenido'>\n";
}

function Meta_Tag_Descripcion_Galeria()
{
  $nConexion = Conectar();
  $sql = "SELECT * FROM tblsitio";
  $ra = mysqli_query($nConexion, $sql);
  if (!$ra) {
    return null;
  }
  $row = mysqli_fetch_array($ra);
  echo "<meta name='description' content='{$row['galeria']}'>\n";
}


function Meta_Tag_Descripcion_Productos()
{
  $nConexion = Conectar();
  $sql = "SELECT * FROM tblsitio";
  $ra = mysqli_query($nConexion, $sql);
  if (!$ra) {
    return null;
  }
  $row = mysqli_fetch_array($ra);
  return $row['productos'];
}

function Meta_Tag_Descripcion_Servicios()
{
  $nConexion = Conectar();
  $sql = "SELECT * FROM tblsitio";
  $ra = mysqli_query($nConexion, $sql);
  if (!$ra) {
    return null;
  }
  $row = mysqli_fetch_array($ra);
  return $row['servicios'];
}

function Meta_Tag_Descripcion_Videos()
{
  $nConexion = Conectar();
  $sql = "SELECT * FROM tblsitio";
  $ra = mysqli_query($nConexion, $sql);
  if (!$ra) {
    return null;
  }
  $row = mysqli_fetch_array($ra);
  echo "<meta name='description' content='{$row['videos']}'>\n";
}

function Meta_Tag_Descripcion()
{
  $nConexion    = Conectar();
  $reg_MetaTag  = mysqli_fetch_object(mysqli_query($nConexion, "SELECT descripcion FROM tblgenerales LIMIT 1"));
  mysqli_close($nConexion);
  echo "<meta name='description' content='$reg_MetaTag->descripcion'>\n";
}

function Palabras_Claves()
{
  $nConexion    = Conectar();
  $reg_MetaTag  = mysqli_fetch_object(mysqli_query($nConexion, "SELECT palabras_clave FROM tblgenerales LIMIT 1"));
  mysqli_close($nConexion);
  echo "<meta name='keywords' content='$reg_MetaTag->palabras_clave'>\n";
}

function Meta_Tag_General()
{
  $nConexion    = Conectar();
  $reg_MetaTag  = mysqli_fetch_object(mysqli_query($nConexion, "SELECT descripcion,palabras_clave FROM tblgenerales LIMIT 1"));
  mysqli_close($nConexion);
  echo "<meta name='description' content='$reg_MetaTag->descripcion'>\n" . "<meta name='keywords' content='$reg_MetaTag->palabras_clave'>\n";
}

function GuardarVoto($IdEncuesta, $Respuesta, $RespuestaOtro)
{

  //Almacena un voto realizado e imprime los resultados de la votación
  $nConexion    = Conectar();
  $sql = "SELECT CASE WHEN TIMEDIFF(CURRENT_TIMESTAMP,hora) > '24:00:00' THEN 'VOTAR' ELSE 'NO' END AS accion FROM tblencuestas_votantes WHERE ip='{$_SERVER['REMOTE_ADDR']}' ORDER BY id DESC LIMIT 1";

  //  die($sql);


  if ($ra = mysqli_query($nConexion, $sql)) {
    if ($row = mysqli_fetch_assoc($ra)) {
      if (isset($row["accion"]) && $row["accion"] == "NO") {
        die("Su ultimo voto fue durante las ultimas 24 horas, debe esperar para volver a votar");
      }
    }
  } else {
    die("Error consultando si puede votar");
  }

  $sql = "SELECT * FROM tblencuestarespuestas WHERE idencuesta ={$IdEncuesta}";

  //die($sql);

  // Si no existen votos para la encuesta creo el registro, de lo contrario se actualiza
  $Resultado = mysqli_query($nConexion, $sql);
  if (!mysqli_num_rows($Resultado)) {
    //Se crea el nuevo registro para el primer voto
    $txtSQL = "INSERT INTO tblencuestarespuestas (idencuesta,respuesta" . $Respuesta . ",totalvotos) VALUES ($IdEncuesta,1,1)";
  } else {
    // La encuesta ya tiene votos, se actualiza el campo correspondiente
    $txtSQL = "UPDATE tblencuestarespuestas SET totalvotos = totalvotos + 1, respuesta" . $Respuesta . " = respuesta" . $Respuesta . " + 1 WHERE idencuesta = " . $IdEncuesta;
  }

  // Ejecuto Consulta
  mysqli_query($nConexion, $txtSQL);


  if ($Respuesta == "otro") {

    $sql = "SELECT * FROM tblencuestarespuestasotro WHERE idencuesta=" . $IdEncuesta . " AND respuesta ='" . $RespuestaOtro . "'";
    $ra = mysqli_query($nConexion, $sql);

    if (!mysqli_num_rows($ra)) {
      $txtSQL = "INSERT INTO tblencuestarespuestasotro(idencuesta,respuesta) VALUES(" . $IdEncuesta . ",'" . $RespuestaOtro . "')";
    } else {
      $ra = mysqli_fetch_object($ra);
      $txtSQL = "UPDATE tblencuestarespuestasotro SET totalvotos=totalvotos+1 WHERE idencuestaotro=" . $ra->idencuestaotro;
    }
    mysqli_query($nConexion, $txtSQL);
  }


  $sql = "INSERT INTO tblencuestas_votantes(ip) VALUES('{$_SERVER['REMOTE_ADDR']}')";
  //die($sql);
  $ra = mysqli_query($nConexion, $sql);

  if (!$ra) {
    die("Error registrando votación, ip");
  }

  mysqli_close($nConexion);
  mysqli_free_result($Resultado);
  MostrarEstadisticasEncuesta($IdEncuesta);
}

function MostrarEstadisticasEncuesta($IdEncuesta)
{
  // Imprime las estadisticas de una encuesta
  $nConexion        = Conectar();
  $Reg_Encuesta     = mysqli_fetch_object(mysqli_query($nConexion, "SELECT * FROM tblencuestas WHERE idencuesta = $IdEncuesta"));
  $Reg_Respuestas   = mysqli_fetch_object(mysqli_query($nConexion, "SELECT idencuesta,totalvotos,((respuesta1/totalvotos)*100) AS p1,respuesta1,((respuesta2/totalvotos)*100) AS p2,respuesta2,((respuesta3/totalvotos)*100) AS p3,respuesta3,((respuesta4/totalvotos)*100) AS p4,respuesta4,((respuesta5/totalvotos)*100) AS p5,respuesta5,((respuesta6/totalvotos)*100) AS p6,respuesta6,((respuesta7/totalvotos)*100) AS p7,respuesta7,((respuesta8/totalvotos)*100) AS p8,respuesta8,((respuesta9/totalvotos)*100) AS p9,respuesta9,((respuesta10/totalvotos)*100) AS p10,respuesta10,((respuestaOtro/totalvotos)*100) AS pOtro,respuestaOtro FROM tblencuestarespuestas WHERE idencuesta = $IdEncuesta"));

  $sql = "SELECT idencuesta,totalvotos,(totalvotos/(SELECT totalvotos FROM tblencuestarespuestas where idencuesta=" . $IdEncuesta . "))*100 As pOtro,respuesta FROM tblencuestarespuestasotro WHERE idencuesta =" . $IdEncuesta . " GROUP BY respuesta";

  $Reg_respuestas_Otro = mysqli_query($nConexion, $sql);
  //  $Reg_respuestas_Otro = mysqli_fetch_object($Reg_respuestas_Otro);
  mysqli_close($nConexion);
?>
  <table border="0" cellspacing="2" cellpadding="0" align="center">
    <!--<tr><td colspan="4"><div align="center"><strong>Resultados Votación</strong></div></td></tr>-->
    <tr>
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4"><b>
          <div align="justify"><?php echo $Reg_Encuesta->pregunta; ?></div>
        </b></td>
    </tr>
    <tr>
      <td colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td>
        <div align="center"><strong>Respuestas</strong></div>
      </td>
      <td>
        <div align="center"><strong>Grafico</strong></div>
      </td>

      <td>
        <div align="center"><strong>Votos</strong></div>
      </td>
      <td>
        <div align="center"><strong>Porcentaje</strong></div>
      </td>
    </tr>
    <?php
    if (!empty($Reg_Encuesta->respuesta1)) {
    ?>
      <tr>
        <td><?php echo $Reg_Encuesta->respuesta1; ?></td>
        <td><img src="../admin/image/grafico.gif" width="<?php echo 5 * $Reg_Respuestas->p1; ?>" height="20"></td>
        <td>
          <div align="center"><?php echo $Reg_Respuestas->respuesta1; ?></div>
        </td>
        <td>
          <div align="center"><?php echo $Reg_Respuestas->p1 . "%"; ?></div>
        </td>
      </tr>
    <?php
    }
    if (!empty($Reg_Encuesta->respuesta2)) {
    ?>
      <tr>
        <td><?php echo $Reg_Encuesta->respuesta2; ?></td>
        <td><img src="../admin/image/grafico2.gif" width="<?php echo 5 * $Reg_Respuestas->p2; ?>" height="20"></td>
        <td>
          <div align="center"><?php echo $Reg_Respuestas->respuesta2; ?></div>
        </td>
        <td>
          <div align="center"><?php echo $Reg_Respuestas->p2 . "%"; ?></div>
        </td>
      </tr>
    <?php
    }
    if (!empty($Reg_Encuesta->respuesta3)) {
    ?>
      <tr>
        <td><?php echo $Reg_Encuesta->respuesta3; ?></td>
        <td><img src="../admin/image/grafico3.gif" width="<?php echo 5 * $Reg_Respuestas->p3; ?>" height="20"></td>
        <td>
          <div align="center"><?php echo $Reg_Respuestas->respuesta3; ?></div>
        </td>
        <td>
          <div align="center"><?php echo $Reg_Respuestas->p3 . "%"; ?></div>
        </td>
      </tr>
    <?php
    }
    if (!empty($Reg_Encuesta->respuesta4)) {
    ?>
      <tr>
        <td><?php echo $Reg_Encuesta->respuesta4; ?></td>
        <td><img src="../admin/image/grafico4.gif" width="<?php echo 5 * $Reg_Respuestas->p4; ?>" height="20"></td>
        <td>
          <div align="center"><?php echo $Reg_Respuestas->respuesta4; ?></div>
        </td>
        <td>
          <div align="center"><?php echo $Reg_Respuestas->p4 . "%"; ?></div>
        </td>
      </tr>
    <?php
    }
    if (!empty($Reg_Encuesta->respuesta5)) {
    ?>
      <tr>
        <td><?php echo $Reg_Encuesta->respuesta5; ?></td>
        <td><img src="../admin/image/grafico5.gif" width="<?php echo 5 * $Reg_Respuestas->p5; ?>" height="20"></td>
        <td>
          <div align="center"><?php echo $Reg_Respuestas->respuesta5; ?></div>
        </td>
        <td>
          <div align="center"><?php echo $Reg_Respuestas->p5 . "%"; ?></div>
        </td>
      </tr>
    <?php
    }
    if (!empty($Reg_Encuesta->respuesta6)) {
    ?>
      <tr>
        <td><?php echo $Reg_Encuesta->respuesta6; ?></td>
        <td><img src="../admin/image/grafico6.gif" width="<?php echo 5 * $Reg_Respuestas->p6; ?>" height="20"></td>
        <td>
          <div align="center"><?php echo $Reg_Respuestas->respuesta6; ?></div>
        </td>
        <td>
          <div align="center"><?php echo $Reg_Respuestas->p6 . "%"; ?></div>
        </td>
      </tr>
    <?php
    }
    if (!empty($Reg_Encuesta->respuesta7)) {
    ?>
      <tr>
        <td><?php echo $Reg_Encuesta->respuesta7; ?></td>
        <td><img src="../admin/image/grafico7.gif" width="<?php echo 5 * $Reg_Respuestas->p7; ?>" height="20"></td>
        <td>
          <div align="center"><?php echo $Reg_Respuestas->respuesta7; ?></div>
        </td>
        <td>
          <div align="center"><?php echo $Reg_Respuestas->p7 . "%"; ?></div>
        </td>
      </tr>
    <?php
    }
    if (!empty($Reg_Encuesta->respuesta8)) {
    ?>
      <tr>
        <td><?php echo $Reg_Encuesta->respuesta8; ?></td>
        <td><img src="../admin/image/grafico8.gif" width="<?php echo 5 * $Reg_Respuestas->p8; ?>" height="20"></td>
        <td>
          <div align="center"><?php echo $Reg_Respuestas->respuesta8; ?></div>
        </td>
        <td>
          <div align="center"><?php echo $Reg_Respuestas->p8 . "%"; ?></div>
        </td>
      </tr>
    <?php
    }
    if (!empty($Reg_Encuesta->respuesta9)) {
    ?>
      <tr>
        <td><?php echo $Reg_Encuesta->respuesta9; ?></td>
        <td><img src="../admin/image/grafico9.gif" width="<?php echo 5 * $Reg_Respuestas->p9; ?>" height="20"></td>
        <td>
          <div align="center"><?php echo $Reg_Respuestas->respuesta9; ?></div>
        </td>
        <td>
          <div align="center"><?php echo $Reg_Respuestas->p9 . "%"; ?></div>
        </td>
      </tr>
    <?php
    }
    if (!empty($Reg_Encuesta->respuesta10)) {
    ?>
      <tr>
        <td><?php echo $Reg_Encuesta->respuesta10; ?></td>
        <td><img src="../admin/image/grafico10.gif" width="<?php echo 5 * $Reg_Respuestas->p10; ?>" height="20"></td>
        <td>
          <div align="center"><?php echo $Reg_Respuestas->respuesta10; ?></div>
        </td>
        <td>
          <div align="center"><?php echo $Reg_Respuestas->p10 . "%"; ?></div>
        </td>
      </tr>
    <?php
    }
    if (!empty($Reg_Encuesta->respuestaOtro)) {
    ?>
      <tr>
        <td><?php echo $Reg_Encuesta->respuestaOtro; ?></td>
        <td><img src="../admin/image/grafico10.gif" width="<?php echo 5 * $Reg_Respuestas->pOtro; ?>" height="20"></td>
        <td>
          <div align="center"><?php echo $Reg_Respuestas->respuestaOtro; ?></div>
        </td>
        <td>
          <div align="center"><?php echo $Reg_Respuestas->pOtro . "%"; ?></div>
        </td>
      </tr>
    <?php
    }
    ?>
    <tr>
      <td>
        <div align="center"><strong>TOTAL</strong></div>
      </td>
      <td colspan=2>&nbsp;</td>
      <td>
        <div align="center"><strong>100%</strong></div>
      </td>
    </tr>
    <tr>
      <td colspan=4>&nbsp;</td>
    </tr>
    <tr>
      <td colspan=4>
        <div align="center"><strong>Detalle Otro/a</strong></div>
      </td>
    </tr>

    <?php while ($r = mysqli_fetch_assoc($Reg_respuestas_Otro)) : ?>
      <tr>
        <td><?php echo $r["respuesta"]; ?></td>
        <td><img src="../admin/image/grafico10.gif" width="<?php echo 5 * $r["pOtro"]; ?>" height="20"></td>
        <td>
          <div align="center"><?php echo $r["totalvotos"]; ?></div>
        </td>
        <td>
          <div align="center"><?php echo $r["pOtro"] . "%"; ?></div>
        </td>
      </tr>
    <?php
    endwhile;
    ?>
    <tr>
      <td colspan=4>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4">
        <div align="center"><strong>TOTAL VOTOS: <?php echo $Reg_Respuestas->totalvotos; ?></strong></div>
      </td>
    </tr>
  </table>
  <?php
}

function VerContenidosHome($CuantosRegistros)
{
  // Muestra en el HOME los articulos de Contenidos que fueron marcados para ser listados en HOME
  include("../admin/vargenerales.php");

  $nConexion    = Conectar();
  $Resultado = mysqli_query($nConexion, "SELECT * FROM tblcontenidos WHERE (publicar = 'S') AND (verhome = 'S') ORDER BY clave LIMIT $CuantosRegistros");
  mysqli_close($nConexion);

  while ($Registros = mysqli_fetch_object($Resultado)) {
  ?>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="tablaTitulo5">
          <?php echo $Registros->titulo; ?>
        </td>
      </tr>
      <tr>
        <td class="tablaContenido5">
          <?php
          if (!empty($Registros->imagen)) {
          ?>
            <img src="<?php echo $cRutaVerImgContenidos . $Registros->imagen; ?>" alt="<?php echo $Registros->titulo; ?>" width="140" hspace="6" align="left" />
          <?php
          }
          echo substr($Registros->contenido, 0, 250) . "...";
          ?>
          <p align="right">
            <a href="contenido.php?clave=<?php echo $Registros->clave; ?>&ciudad=<?php echo $IdCiudad ?>" class="deMasInfo2d">
              <!--Imprimir Contenido=BotonMasInfoContenidoHome -->
              <?php
              $RegContenido = mysqli_fetch_object(VerContenido("BotonMasInfoContenidoHome"));
              echo $RegContenido->contenido;
              ?>
              <!--Fin Contenido=BotonMasInfoContenidoHome -->
            </a>
          </p>
        </td>
      </tr>
    </table>
    <br />
  <?php
  }
  mysqli_free_result($Resultado);
}

function ImprimirEncuesta()
{
  // Imprime la primera encuesta encontrada cuyo campo activo es igual a S
  // la idea es que solo se permite tener una sola encuesta activa
  $nConexion  = Conectar();
  $Resultado = mysqli_query($nConexion, "SELECT * FROM tblencuestas WHERE (activa = 'S') AND (publicar = 'S') LIMIT 1");
  mysqli_close($nConexion);
  $Registros = mysqli_fetch_object($Resultado);

  if (mysqli_num_rows($Resultado)) {
  ?>

    <form action="votar.php?ciudad=1" method="post">
      <!--<form action="http://www.chiquititaplaza.com/php/votar.php?ciudad=1" method="post">-->
      <input type="hidden" name="txtIdEncuesta" id="txtIdEncuesta" value="<?php echo $Registros->idencuesta; ?>">
      <style>
        .Color_1 {
          background-color: #FCF;
          color: #000;
        }

        .Color_2 {
          background-color: #F9C;
          color: #000;
        }

        .formulario1 {
          padding: 3px;
          width: 100%;
          border: 1px solid #12110F;
        }

        .textoTitulo {
          background-color: #FFF;
          color: #12110F;
          font-size: 12;
          font-style: normal;
          font-weight: bold;
        }

        .textoPregunta {
          background-color: #FFF;
          color: #12110F;
          font-size: 14;
          font-weight: bold;
        }
      </style>
      <table class="formulario1" cellpadding="4" cellspacing="0" border="0" width="90%">
        <tr>
          <td align="center" class="textoPregunta">
            <?php echo $Registros->pregunta; ?>
          </td>
        </tr>
        <?php
        if (!empty($Registros->respuesta1)) {
        ?>
          <tr>
            <td class="Color_1" align="left">
              <input type="radio" name="optRespuestas" value="1">&nbsp;<?php echo $Registros->respuesta1; ?>
            </td>
          </tr>
        <?php
        }
        if (!empty($Registros->respuesta2)) {
        ?>
          <tr>
            <td class="Color_2" align="left">
              <input type="radio" name="optRespuestas" value="2">&nbsp;<?php echo $Registros->respuesta2; ?>
            </td>
          </tr>
        <?php
        }
        if (!empty($Registros->respuesta3)) {
        ?>
          <tr>
            <td class="Color_1" align="left">
              <input type="radio" name="optRespuestas" value="3">&nbsp;<?php echo $Registros->respuesta3; ?>
            </td>
          </tr>
        <?php
        }
        if (!empty($Registros->respuesta4)) {
        ?>
          <tr>
            <td class="Color_2" align="left">
              <input type="radio" name="optRespuestas" value="4">&nbsp;<?php echo $Registros->respuesta4; ?>
            </td>
          </tr>
        <?php
        }
        if (!empty($Registros->respuesta5)) {
        ?>
          <tr>
            <td class="Color_1" align="left">
              <input type="radio" name="optRespuestas" value="5">&nbsp;<?php echo $Registros->respuesta5; ?>
            </td>
          </tr>
        <?php
        }
        if (!empty($Registros->respuesta6)) {
        ?>
          <tr>
            <td class="Color_2" align="left">
              <input type="radio" name="optRespuestas" value="6">&nbsp;<?php echo $Registros->respuesta6; ?>
            </td>
          </tr>
        <?php
        }
        if (!empty($Registros->respuesta7)) {
        ?>
          <tr>
            <td class="Color_1" align="left">
              <input type="radio" name="optRespuestas" value="7">&nbsp;<?php echo $Registros->respuesta7; ?>
            </td>
          </tr>
        <?php
        }
        if (!empty($Registros->respuesta8)) {
        ?>
          <tr>
            <td class="Color_2" align="left">
              <input type="radio" name="optRespuestas" value="8">&nbsp;<?php echo $Registros->respuesta8; ?>
            </td>
          </tr>
        <?php
        }
        if (!empty($Registros->respuesta9)) {
        ?>
          <tr>
            <td class="Color_1" align="left">
              <input type="radio" name="optRespuestas" value="9">&nbsp;<?php echo $Registros->respuesta9; ?>
            </td>
          </tr>
        <?php
        }
        if (!empty($Registros->respuesta10)) {
        ?>
          <tr>
            <td class="Color_2" align="left">
              <input type="radio" name="optRespuestas" value="10">&nbsp;<?php echo $Registros->respuesta10; ?>
            </td>
          </tr>
        <?php
        }
        if (!empty($Registros->respuestaOtro)) {
        ?>
          <tr>
            <td class="Color_2" align="left">
              <input type="radio" id="optRespuestas" name="optRespuestas" value="otro">&nbsp;<?php echo $Registros->respuestaOtro; ?>&nbsp;
              <input type="text" name="optRespuestasOtro" value="" onclick="document.getElementById('optRespuestas').checked=true;">
            </td>
          </tr>
        <?php
        }
        ?>
        <tr>
          <td>Código de Seguridad <br />
            <img id="captcha-encuesta" src="captcha_encuesta.php" alt="" /> <br />
            <a href="#none" style="font-weight:bold;" onclick="document.getElementById('captcha-encuesta').src='captcha_encuesta.php?'+Math.random();">Recargar imagen</a>
            <br />
            <input name="captcha" size="15" maxlength="45" id="textfield4" autocomplete="off" /><br />
          </td>
        </tr>
        <tr>
          <td align="center" align="left">
            <input type="submit" value="Votar" name="Votar">
          </td>
        </tr>
      </table>
    </form>
  <?php
  }
  mysqli_free_result($Resultado);
}

function CargarPlan($Sede)
{
  $nConexion = Conectar();
  if ($Sede > 0) {
    $rsResultado = mysqli_query($nConexion, "SELECT * FROM tblplanes WHERE ( sede = '$Sede' ) AND ( publicar = 'S' ) ORDER BY idplan DESC LIMIT 1");
  } else {
    $rsResultado = mysqli_query($nConexion, "SELECT * FROM tblplanes WHERE ( publicar = 'S' ) ORDER BY sede");
  }
  mysqli_close($nConexion);
  return $rsResultado;
}

function CargarIdPlan($IdPlan)
{
  $nConexion = Conectar();
  $rsResultado = mysqli_query($nConexion, "SELECT * FROM tblplanes WHERE idplan = $IdPlan");
  mysqli_close($nConexion);
  return $rsResultado;
}

function CargarNImagenesAleatorios($CargarNImagenesAleatorias)
{

  $nConexion = Conectar();
  $rsResultado = mysqli_query($nConexion, "SELECT * FROM tblimagenes WHERE (publicar = 'S') ORDER BY RAND() DESC LIMIT $CargarNImagenesAleatorias");
  mysqli_close($nConexion);
  return $rsResultado;
}

function CargarIdImagen($nIdImagen)
{

  $nConexion = Conectar();
  $rsResultado = mysqli_query($nConexion, "SELECT * FROM tblimagenes WHERE (idimagen = $nIdImagen) AND (publicar = 'S')");
  mysqli_close($nConexion);
  return $rsResultado;
}

function ImprimirBanner($cNomBloque)
{
  // Averiguo el IDBloque

  $nConexion    = Conectar();
  $rs_IdBloque  = mysqli_query($nConexion, "SELECT * FROM tblbanners_bloques WHERE bloque = '$cNomBloque'");
  $reg_Bloque   = mysqli_fetch_object($rs_IdBloque);
  $IdBloque     = 0;
  if ($reg_Bloque->bloque == $cNomBloque) {
    $IdBloque = $reg_Bloque->idbloque;
  } else {
    mysqli_close($nConexion);
    mysqli_free_result($rs_IdBloque);
    exit;
  }
  mysqli_free_result($rs_IdBloque);
  $rs_Banner = mysqli_query($nConexion, "SELECT * FROM tblbanners WHERE (publicar = 'S') AND (idbloque = $IdBloque) ORDER BY RAND() DESC LIMIT 1");
  $reg_Banner = mysqli_fetch_object($rs_Banner);
  mysqli_close($nConexion);
  include("../admin/vargenerales.php");
  if (mysqli_num_rows($rs_Banner)) {
  ?>
    <a href="/verbanner/<?php echo $reg_Banner->idbanner ?>" target="_blank" class="afondo">
      <img border="0" src="<?php echo $cRutaVerBanners . $reg_Banner->banner; ?>" class="imagenbanner">
    </a>
  <?php
  }
}

function CargarNServiciosCat($nServicios, $categoria)
{


  $nConexion = Conectar();
  $rsResultado = mysqli_query($nConexion, "SELECT * FROM tblservicios WHERE (publicar = 'S') AND (idcategoria = $categoria) ORDER BY RAND() DESC LIMIT $nServicios");
  mysqli_close($nConexion);
  return $rsResultado;
}

function CargarNServiciosAleatorios($nServicios)
{


  $nConexion = Conectar();
  $rsResultado = mysqli_query($nConexion, "SELECT * FROM tblservicios WHERE (publicar = 'S') ORDER BY RAND() DESC LIMIT $nServicios");
  mysqli_close($nConexion);
  return $rsResultado;
}

function CargarNServicio($nServicios)
{

  $nConexion = Conectar();
  $rsResultado = mysqli_query($nConexion, "SELECT * FROM tblservicios WHERE (publicar = 'S') ORDER BY idservicio DESC LIMIT $nServicios");
  mysqli_close($nConexion);
  return $rsResultado;
}

function CargarCatServicio($nIdServicio)
{

  $nConexion = Conectar();
  $sql = "select * from tblservicios WHERE (idcategoria=$nIdServicio) AND (publicar = 'S') ORDER BY RAND()";
  $rCategoria = mysqli_query($nConexion, $sql);
  mysqli_close($nConexion);
  return $rCategoria;
}

function CargarSubCategoriasServicios($cSubCategoria)
{

  $nConexion            = Conectar();
  $rs_Resultdo  = mysqli_query($nConexion, "SELECT tblcategoriasservicios.idcategoria, tblcategoriasservicios.categoria, tblcategoriasservicios.descripcion, tblcategoriasservicios.imagen, Count(tblcategoriasservicios_1.idcategoria) AS total_subcategorias, Count(tblservicios.idservicio) AS total_servicios, tblcategoriasservicios.idpadre FROM (tblcategoriasservicios LEFT JOIN tblservicios ON tblcategoriasservicios.idcategoria = tblservicios.idcategoria) LEFT JOIN tblcategoriasservicios AS tblcategoriasservicios_1 ON tblcategoriasservicios.idcategoria = tblcategoriasservicios_1.idpadre WHERE GROUP BY tblcategoriasservicios.idcategoria, tblcategoriasservicios.categoria, tblcategoriasservicios.descripcion, tblcategoriasservicios.idpadre HAVING (((tblcategoriasservicios.idpadre)='$cSubCategoria')) ORDER BY tblcategoriasservicios.categoria");
  mysqli_close($nConexion);
  return $rs_Resultdo;
}


function categoriaServiciosAssoc($idcategoria)
{

  $nConexion = Conectar();
  $sql = "select * from tblcategoriasservicios where idcategoria={$idcategoria}";
  $rCategoria = mysqli_query($nConexion, $sql);
  mysqli_close($nConexion);
  return $rCategoria;
}

function categoriaServiciosAssocFromServicio($idservicio)
{
  $nConexion = Conectar();
  $sql = "select nombre,url,descripcion from tblti_categorias where idcategoria={$idservicio}";
  $rCategoria = mysqli_query($nConexion, $sql);
  mysqli_close($nConexion);
  return $rCategoria;
}

function CargarSubCategoriasServiciosOrdCatAsc($cSubCategoria)
{

  $nConexion = Conectar();
  $sql = "(SELECT a.idcategoria, a.categoria, a.descripcion, 
        a.imagen, Count(c.idcategoria) AS total_subcategorias, 
        Count(b.idservicio) AS total_servicios, a.idpadre 
        FROM tblcategoriasservicios a 
        LEFT JOIN tblservicios b ON (a.idcategoria = b.idcategoria) 
        LEFT JOIN tblcategoriasservicios c ON (a.idcategoria = c.idpadre)
        GROUP BY a.idcategoria, a.categoria, a.descripcion, a.idpadre 
        HAVING (((a.idpadre)='{$cSubCategoria}')) 
        ORDER BY a.categoria) categorias";

  $page = new sistema_paginacion($sql);
  $page->ordenar_por("categoria");
  $page->set_condicion("where 1=1");
  $page->set_limite_pagina(4);

  $rs_Resultdo = $page->obtener_consulta();
  $page->set_tabla_transparente();
  $page->set_color_texto("black");
  $page->set_color_enlaces("black", "#FF9900");

  $result = array();
  mysqli_close($nConexion);


  if (!$rs_Resultdo) {
    $result["error"] = true;
    return $result;
  }

  $result["error"] = false;
  $result["rs"] = $rs_Resultdo;
  $result["page"] = $page;

  return $result;
}

function CargarSubCategoriasServiciosOrdCatDesc($cSubCategoria)
{

  $nConexion = Conectar();
  $sql = "(SELECT a.idcategoria, a.categoria, a.descripcion, 
        a.imagen, Count(c.idcategoria) AS total_subcategorias, 
        Count(b.idservicio) AS total_servicios, a.idpadre 
        FROM tblcategoriasservicios a 
        LEFT JOIN tblservicios b ON (a.idcategoria = b.idcategoria) 
        LEFT JOIN tblcategoriasservicios c ON (a.idcategoria = c.idpadre)
        GROUP BY a.idcategoria, a.categoria, a.descripcion, a.idpadre 
        HAVING (((a.idpadre)='{$cSubCategoria}')) 
        ORDER BY a.categoria desc) categorias";


  $page = new sistema_paginacion($sql);
  $page->ordenar_por("categoria desc");
  $page->set_condicion("where 1=1");
  $page->set_limite_pagina(4);

  $rs_Resultdo = $page->obtener_consulta();
  $page->set_tabla_transparente();
  $page->set_color_texto("black");
  $page->set_color_enlaces("black", "#FF9900");

  $result = array();
  mysqli_close($nConexion);


  if (!$rs_Resultdo) {
    $result["error"] = true;
    return $result;
  }

  $result["error"] = false;
  $result["rs"] = $rs_Resultdo;
  $result["page"] = $page;

  return $result;
}

function CargarSubCategoriasServiciosOrdCatId($cSubCategoria)
{

  $nConexion = Conectar();
  $sql = "(SELECT a.idcategoria, a.categoria, a.descripcion, 
        a.imagen, Count(c.idcategoria) AS total_subcategorias, 
        Count(b.idservicio) AS total_servicios, a.idpadre 
        FROM tblcategoriasservicios a 
        LEFT JOIN tblservicios b ON (a.idcategoria = b.idcategoria) 
        LEFT JOIN tblcategoriasservicios c ON (a.idcategoria = c.idpadre)
        GROUP BY a.idcategoria, a.categoria, a.descripcion, a.idpadre 
        HAVING (((a.idpadre)='{$cSubCategoria}')) 
        ORDER BY a.idcategoria) categorias";

  $page = new sistema_paginacion($sql);
  $page->ordenar_por("idcategoria");
  $page->set_condicion("where 1=1");
  $page->set_limite_pagina(4);

  $rs_Resultdo = $page->obtener_consulta();
  $page->set_tabla_transparente();
  $page->set_color_texto("black");
  $page->set_color_enlaces("black", "#FF9900");

  $result = array();
  mysqli_close($nConexion);


  if (!$rs_Resultdo) {
    $result["error"] = true;
    return $result;
  }

  $result["error"] = false;
  $result["rs"] = $rs_Resultdo;
  $result["page"] = $page;

  return $result;
}
function CargarServiciosOrdSerAsc($categoria)
{

  $nConexion = Conectar();
  $sql = "(SELECT * from tblservicios where idcategoria='{$categoria}' order by servicio) servicios";

  $page = new sistema_paginacion($sql);
  $page->ordenar_por("servicio");
  $page->set_condicion("where 1=1");
  $page->set_limite_pagina(4);

  $rs_Resultdo = $page->obtener_consulta();
  $page->set_tabla_transparente();
  $page->set_color_texto("black");
  $page->set_color_enlaces("black", "#FF9900");

  $result = array();
  mysqli_close($nConexion);

  if (!$rs_Resultdo) {
    $result["error"] = true;
    return $result;
  }

  $result["error"] = false;
  $result["rs"] = $rs_Resultdo;
  $result["page"] = $page;

  return $result;
}

function CargarServiciosOrdSerDesc($categoria)
{

  $nConexion = Conectar();
  $sql = "(SELECT * from tblservicios where idcategoria='{$categoria}' order by servicio desc) servicios";

  $page = new sistema_paginacion($sql);
  $page->ordenar_por("servicio desc");
  $page->set_condicion("where 1=1");
  $page->set_limite_pagina(4);

  $rs_Resultdo = $page->obtener_consulta();
  $page->set_tabla_transparente();
  $page->set_color_texto("black");
  $page->set_color_enlaces("black", "#FF9900");

  $result = array();
  mysqli_close($nConexion);

  if (!$rs_Resultdo) {
    $result["error"] = true;
    return $result;
  }

  $result["error"] = false;
  $result["rs"] = $rs_Resultdo;
  $result["page"] = $page;

  return $result;
}

function CargarServiciosOrdSerId($categoria)
{

  $nConexion = Conectar();
  $sql = "(SELECT * from tblservicios where idcategoria='{$categoria}' order by idservicio) servicios";

  $page = new sistema_paginacion($sql);
  $page->ordenar_por("idservicio");
  $page->set_condicion("where 1=1");
  $page->set_limite_pagina(4);

  $rs_Resultdo = $page->obtener_consulta();
  $page->set_tabla_transparente();
  $page->set_color_texto("black");
  $page->set_color_enlaces("black", "#FF9900");

  $result = array();
  mysqli_close($nConexion);

  if (!$rs_Resultdo) {
    $result["error"] = true;
    return $result;
  }

  $result["error"] = false;
  $result["rs"] = $rs_Resultdo;
  $result["page"] = $page;

  return $result;
}

function CargarNNoticiaAleatorios($nNoticia)
{

  $nConexion = Conectar();
  $rsResultado = mysqli_query($nConexion, "SELECT * FROM tblnoticias WHERE (publicar = 'S') ORDER BY RAND() DESC LIMIT $nNoticia");
  mysqli_close($nConexion);
  return $rsResultado;
}

function CargarNEvento($nIdEvento)
{

  $nConexion = Conectar();
  $rsResultado = mysqli_query($nConexion, "SELECT * FROM tbleventos WHERE (publicar = 'S') ORDER BY rand() LIMIT $nIdEvento");
  mysqli_close($nConexion);
  return $rsResultado;
}

function CargarSubCategoriasEventos($cSubCategoria)
{

  $nConexion            = Conectar();
  $rs_Resultdo  = mysqli_query($nConexion, "SELECT tblcategoriaseventos.idcategoria, tblcategoriaseventos.categoria, tblcategoriaseventos.descripcion, tblcategoriaseventos.imagen, Count(tblcategoriaseventos.idcategoria) AS total_subcategorias, Count(tbleventos.idservicio) AS total_eventos, tblcategoriaseventos.idpadre FROM (tblcategoriaseventos LEFT JOIN tbleventos ON tblcategoriaseventos.idcategoria = tbleventos.idcategoria) LEFT JOIN tblcategoriaseventos AS tblcategoriaseventos_1 ON tblcategoriaseventos.idcategoria = tblcategoriaseventos_1.idpadre GROUP BY tblcategoriaseventos.idcategoria, tblcategoriaseventos.categoria, tblcategoriaseventos.descripcion, tblcategoriaseventos.idpadre HAVING (((tblcategoriaseventos.idpadre)='$cSubCategoria')) ORDER BY tblcategoriaseventos.categoria");
  mysqli_close($nConexion);
  return $rs_Resultdo;
}


function categoriaEventosAssoc($idcategoria)
{

  $nConexion = Conectar();
  $sql = "select * from tblcategoriaseventos where idcategoria={$idcategoria}";
  $rCategoria = mysqli_query($nConexion, $sql);
  mysqli_close($nConexion);
  return $rCategoria;
}

function categoriaEventosAssocFromEvento($idevento)
{

  $nConexion = Conectar();
  $sql = "select * 
            from tblcategoriaseventos 
            where idcategoria=(select idcategoria from tbleventos where idevento={$idevento})";
  $rCategoria = mysqli_query($nConexion, $sql);
  mysqli_close($nConexion);
  return $rCategoria;
}

function CargarSubCategoriasEventosOrdCatAsc($cSubCategoria)
{

  $nConexion = Conectar();
  $sql = "(SELECT a.idcategoria, a.categoria, a.descripcion, 
        a.imagen, Count(c.idcategoria) AS total_subcategorias, 
        Count(b.idevento) AS total_servicios, a.idpadre 
        FROM tblcategoriaseventos a 
        LEFT JOIN tbleventos b ON (a.idcategoria = b.idcategoria) 
        LEFT JOIN tblcategoriaseventos c ON (a.idcategoria = c.idpadre)
        GROUP BY a.idcategoria, a.categoria, a.descripcion, a.idpadre 
        HAVING (((a.idpadre)='{$cSubCategoria}')) 
        ORDER BY a.categoria) categorias";

  $page = new sistema_paginacion($sql);
  $page->ordenar_por("categoria");
  $page->set_condicion("where 1=1");
  $page->set_limite_pagina(4);

  $rs_Resultdo = $page->obtener_consulta();
  $page->set_tabla_transparente();
  $page->set_color_texto("black");
  $page->set_color_enlaces("black", "#FF9900");

  $result = array();
  mysqli_close($nConexion);


  if (!$rs_Resultdo) {
    $result["error"] = true;
    return $result;
  }

  $result["error"] = false;
  $result["rs"] = $rs_Resultdo;
  $result["page"] = $page;

  return $result;
}

function CargarSubCategoriasEventosOrdCatDesc($cSubCategoria)
{

  $nConexion = Conectar();
  $sql = "(SELECT a.idcategoria, a.categoria, a.descripcion, 
        a.imagen, Count(c.idcategoria) AS total_subcategorias, 
        Count(b.idevento) AS total_eventos, a.idpadre 
        FROM tblcategoriaseventos a 
        LEFT JOIN tbleventos b ON (a.idcategoria = b.idcategoria) 
        LEFT JOIN tblcategoriaseventos c ON (a.idcategoria = c.idpadre)
        GROUP BY a.idcategoria, a.categoria, a.descripcion, a.idpadre 
        HAVING (((a.idpadre)='{$cSubCategoria}')) 
        ORDER BY a.categoria desc) categorias";


  $page = new sistema_paginacion($sql);
  $page->ordenar_por("categoria desc");
  $page->set_condicion("where 1=1");
  $page->set_limite_pagina(4);

  $rs_Resultdo = $page->obtener_consulta();
  $page->set_tabla_transparente();
  $page->set_color_texto("black");
  $page->set_color_enlaces("black", "#FF9900");

  $result = array();
  mysqli_close($nConexion);


  if (!$rs_Resultdo) {
    $result["error"] = true;
    return $result;
  }

  $result["error"] = false;
  $result["rs"] = $rs_Resultdo;
  $result["page"] = $page;

  return $result;
}

function CargarSubCategoriasEventosOrdCatId($cSubCategoria)
{

  $nConexion = Conectar();
  $sql = "(SELECT a.idcategoria, a.categoria, a.descripcion, 
        a.imagen, Count(c.idcategoria) AS total_subcategorias, 
        Count(b.idevento) AS total_eventos, a.idpadre 
        FROM tblcategoriaseventos a 
        LEFT JOIN tbleventos b ON (a.idcategoria = b.idcategoria) 
        LEFT JOIN tblcategoriaseventos c ON (a.idcategoria = c.idpadre)
        GROUP BY a.idcategoria, a.categoria, a.descripcion, a.idpadre 
        HAVING (((a.idpadre)='{$cSubCategoria}')) 
        ORDER BY a.idcategoria) categorias";

  $page = new sistema_paginacion($sql);
  $page->ordenar_por("idcategoria");
  $page->set_condicion("where 1=1");
  $page->set_limite_pagina(4);

  $rs_Resultdo = $page->obtener_consulta();
  $page->set_tabla_transparente();
  $page->set_color_texto("black");
  $page->set_color_enlaces("black", "#FF9900");

  $result = array();
  mysqli_close($nConexion);


  if (!$rs_Resultdo) {
    $result["error"] = true;
    return $result;
  }

  $result["error"] = false;
  $result["rs"] = $rs_Resultdo;
  $result["page"] = $page;

  return $result;
}

function CargarEventosOrdSerAsc($categoria)
{

  $nConexion = Conectar();
  $sql = "(SELECT * from tbleventos where idcategoria='{$categoria}' order by evento) eventos";

  $page = new sistema_paginacion($sql);
  $page->ordenar_por("evento");
  $page->set_condicion("where 1=1");
  $page->set_limite_pagina(4);

  $rs_Resultdo = $page->obtener_consulta();
  $page->set_tabla_transparente();
  $page->set_color_texto("black");
  $page->set_color_enlaces("black", "#FF9900");

  $result = array();
  mysqli_close($nConexion);

  if (!$rs_Resultdo) {
    $result["error"] = true;
    return $result;
  }

  $result["error"] = false;
  $result["rs"] = $rs_Resultdo;
  $result["page"] = $page;

  return $result;
}

function CargarEventosOrdSerDesc($categoria)
{

  $nConexion = Conectar();
  $sql = "(SELECT * from tbleventos where idcategoria='{$categoria}' order by evento desc) eventos";

  $page = new sistema_paginacion($sql);
  $page->ordenar_por("evento desc");
  $page->set_condicion("where 1=1");
  $page->set_limite_pagina(4);

  $rs_Resultdo = $page->obtener_consulta();
  $page->set_tabla_transparente();
  $page->set_color_texto("black");
  $page->set_color_enlaces("black", "#FF9900");

  $result = array();
  mysqli_close($nConexion);

  if (!$rs_Resultdo) {
    $result["error"] = true;
    return $result;
  }

  $result["error"] = false;
  $result["rs"] = $rs_Resultdo;
  $result["page"] = $page;

  return $result;
}

function CargarEventosOrdSerId($categoria)
{

  $nConexion = Conectar();
  $sql = "(SELECT * from tbleventos where idcategoria='{$categoria}' order by idevento) eventos";

  $page = new sistema_paginacion($sql);
  $page->ordenar_por("idevento");
  $page->set_condicion("where 1=1");
  $page->set_limite_pagina(4);

  $rs_Resultdo = $page->obtener_consulta();
  $page->set_tabla_transparente();
  $page->set_color_texto("black");
  $page->set_color_enlaces("black", "#FF9900");

  $result = array();
  mysqli_close($nConexion);

  if (!$rs_Resultdo) {
    $result["error"] = true;
    return $result;
  }

  $result["error"] = false;
  $result["rs"] = $rs_Resultdo;
  $result["page"] = $page;

  return $result;
}

function VerContenido($cClave)
{

  $nConexion    = Conectar();
  $Resultado    = mysqli_query($nConexion, "SELECT * FROM tblcontenidos WHERE (clave = '$cClave') AND (publicar = 'S')");
  mysqli_close($nConexion);
  return $Resultado;
}

function CargarnNoticias($nNoticias)
{

  $nConexion = Conectar();
  $rsResultado  = mysqli_query($nConexion, "SELECT * FROM tblnoticias WHERE (publicar = 'S') ORDER BY idnoticia DESC LIMIT $nNoticias");
  mysqli_close($nConexion);
  return $rsResultado;
}

function CargarnNoticiasAleatorio($nEditorial)
{

  $nConexion = Conectar();
  $rsResultado  = mysqli_query($nConexion, "SELECT * FROM tblnoticias WHERE (publicar = 'S') ORDER BY RAND() LIMIT $nEditorial");
  mysqli_close($nConexion);
  return $rsResultado;
}

function CargarnEmpsemana($nEmpsemana)
{
  // Carga N Empresas dela semana, normalmente para mostrarlas en el home
  // Solo carga las ultimas empresas de la semana agregadas

  $nConexion = Conectar();
  $rsResultado  = mysqli_query($nConexion, "SELECT * FROM tblempsemana WHERE (publicar = 'S') ORDER BY idempsemana DESC LIMIT $nEmpsemana");
  mysqli_close($nConexion);
  return $rsResultado;
}

function CargarnOfertasemana($nOfertasemana)
{
  // Carga N Ofertas de la semana, normalmente para mostrarlas en el home
  // Solo carga las ultimas ofertas de la semana agregadas

  $nConexion = Conectar();
  $rsResultado  = mysqli_query($nConexion, "SELECT * FROM tblofertasemana WHERE (publicar = 'S') ORDER BY idofertasemana DESC LIMIT $nOfertasemana");
  mysqli_close($nConexion);
  return $rsResultado;
}

function CargarnEmpaisas($nEmpaisas)
{
  // Carga N Ofertas de la semana, normalmente para mostrarlas en el home
  // Solo carga las ultimas ofertas de la semana agregadas

  $nConexion = Conectar();
  $rsResultado  = mysqli_query($nConexion, "SELECT * FROM tblempresaspaisas WHERE (publicar = 'S') ORDER BY idempresapaisa DESC LIMIT $nEmpaisas");
  mysqli_close($nConexion);
  return $rsResultado;
}

function CargarnEditorial($nEditorial)
{

  $nConexion = Conectar();
  $rsResultado  = mysqli_query($nConexion, "SELECT * FROM tbleditorial WHERE (publicar = 'S') ORDER BY ideditorial DESC LIMIT $nEditorial");
  mysqli_close($nConexion);
  return $rsResultado;
}

function CargarnEditorialAleatorio($nEditorial)
{

  $nConexion = Conectar();
  $rsResultado  = mysqli_query($nConexion, "SELECT * FROM tbleditorial WHERE (publicar = 'S') ORDER BY RAND() DESC LIMIT $nEditorial");
  mysqli_close($nConexion);
  return $rsResultado;
}

function CargarFaqsAleatorio($nfaq)
{

  $nConexion = Conectar();
  $rsResultado = mysqli_query($nConexion, "SELECT * FROM tblfaq WHERE (publicar = 'S') ORDER BY RAND() DESC LIMIT $nfaq");
  mysqli_close($nConexion);
  return $rsResultado;
}

function CargarFaqs()
{

  $nConexion = Conectar();
  $rsResultado = mysqli_query($nConexion, "SELECT * FROM tblfaq WHERE (publicar = 'S') ORDER BY idfaq");
  mysqli_close($nConexion);
  return $rsResultado;
}

function CargarSubCategoriasProductos($cSubCategoria)
{

  $nConexion    = Conectar();
  $rs_Resultdo  = mysqli_query($nConexion, "SELECT tblcategoriasproductos.idcategoria, tblcategoriasproductos.categoria, tblcategoriasproductos.descripcion, tblcategoriasproductos.imagen, Count(tblcategoriasproductos_1.idcategoria) AS total_subcategorias, Count(tblproductos.idproducto) AS total_productos, tblcategoriasproductos.idpadre FROM (tblcategoriasproductos LEFT JOIN tblproductos ON tblcategoriasproductos.idcategoria = tblproductos.idcategoria) LEFT JOIN tblcategoriasproductos AS tblcategoriasproductos_1 ON tblcategoriasproductos.idcategoria = tblcategoriasproductos_1.idpadre GROUP BY tblcategoriasproductos.idcategoria, tblcategoriasproductos.categoria, tblcategoriasproductos.descripcion, tblcategoriasproductos.idpadre HAVING (((tblcategoriasproductos.idpadre)='$cSubCategoria')) ORDER BY tblcategoriasproductos.categoria");
  mysqli_close($nConexion);
  return $rs_Resultdo;
}

function CargarMarcas()
{
  $nConexion = Conectar();
  $query = "SELECT tblti_marcas.idmarca, tblti_marcas.nombre FROM tblti_marcas ORDER BY tblti_marcas.orden";
  $rs_Resultado = mysqli_query($nConexion, $query);
  mysqli_close($nConexion);
  return $rs_Resultado;
}

function CargarCategoriasProductos()
{
  $nConexion = Conectar();
  $query = "SELECT tblti_categorias.idcategoria, tblti_categorias.nombre FROM tblti_categorias ORDER BY tblti_categorias.orden";
  $rs_Resultado = mysqli_query($nConexion, $query);
  mysqli_close($nConexion);
  return $rs_Resultado;
}
function CargarCategoriasAgro()
{
  $nConexion = Conectar();
  $query = "SELECT agro_categoria.id, agro_categoria.nombre FROM agro_categoria";
  $rs_Resultado = mysqli_query($nConexion, $query);
  mysqli_close($nConexion);
  return $rs_Resultado;
}
function CargarReferenciasProductos()
{
  $nConexion = Conectar();
  $query = "SELECT tblti_productos.idproducto, tblti_productos.referencia FROM tblti_productos WHERE (inventario > 3) AND activo=1 ORDER BY tblti_productos.orden";
  $rs_Resultado = mysqli_query($nConexion, $query);
  mysqli_close($nConexion);
  // var_dump($rs_Resultado);
  return $rs_Resultado;
}
function CargarNombreProductos()
{
  $nConexion = Conectar();
  $query = "SELECT tblti_productos.idproducto, tblti_productos.nombre FROM tblti_productos WHERE (inventario > 3) AND activo=1  ORDER BY tblti_productos.orden";
  $rs_Resultado = mysqli_query($nConexion, $query);
  mysqli_close($nConexion);
  // var_dump($rs_Resultado);
  return $rs_Resultado;
}



function ConfirmarBoletin($nIdConfirma)
{
  $nConexion = Conectar();
  $rs_Resultado = mysqli_query($nConexion, "SELECT * FROM tblregistros WHERE idregistro = $nIdConfirma AND confirmado = 'S'");
  if (mysqli_num_rows($rs_Resultado)) {
    $cError = "2";
  } else {
    mysqli_query($nConexion, "UPDATE tblregistros SET confirmado = 'S' WHERE idregistro = $nIdConfirma");
    $cError = "N";
  }
  mysqli_close($nConexion);
  mysqli_free_result($rs_Resultado);
  return $cError;
}

function GuardarRegistro($cNombres, $cEmail, $nIdCiudad)
{
  $nConexion    = Conectar();
  mysqli_query($nConexion, "INSERT INTO tblregistros (nombres,email,confirmado,idciudad) VALUES ('$cNombres','$cEmail','N',$nIdCiudad)");
  $cIdRegistro = mysqli_insert_id($nConexion);
  mysqli_close($nConexion);
  //Envio Mail de Confirmación
  $cUrlSitio    = "http://www.gravity-force.com";
  $cUrlConfirma = "http://www.gravity-force.com/php/regconfirma.php?registro=$cIdRegistro&ciudad=1";
  $cNomSitio    = "GRAVITY FORCE";
  $cRemitente   = "info@gravity-force.com";
  $cAsunto      = "Verificación Inscripción Boletín " . $cNomSitio;
  $cMensaje     = "Hemos recibido una solicitud para inscribir ";
  $cMensaje     .= "la cuenta " . $cEmail . " a nuestro sistema de boletines.<br><br>";
  $cMensaje     .= "Para activar tu registro solo tienes que visitar la siguiente dirección Web en tu navegador favorito: " . "<a href='$cUrlConfirma'class='deResumenes' title='Confirmar'>" . $cUrlConfirma . "</a>";
  $cMensaje     .= "<br><br><br>Saludos!<br>El equipo de<br>" . $cNomSitio . "<br>" . "<a href='$cUrlSitio'class='deResumenes' title='Confirmar'>" . $cUrlSitio . "</a>";

  //indica que el mail se envía en formato HTML
  $cEncabezado = "From:" . $cRemitente . "\nReply-To:" . $cRemitente . "\n";
  $cEncabezado .= "X-Mailer:PHP/" . phpversion() . "\n";
  $cEncabezado .= "Mime-Version: 1.0\n";
  $cEncabezado .= "Content-Type: text/html";

  //Envio del Mail
  mail($cEmail, $cAsunto, $cMensaje, $cEncabezado);
}

//Sitios sugeridos Aleatorios
function CargarNSitiosAleatorios($nSitios)
{

  $nConexion = Conectar();
  $rsResultado = mysqli_query($nConexion, "SELECT * FROM tblsitiossugeridos WHERE (publicar = 'S') ORDER BY RAND() DESC LIMIT $nSitios");
  mysqli_close($nConexion);
  return $rsResultado;
}

function CargarIdSitios($nIdSitios)
{

  $nConexion = Conectar();
  $rsResultado = mysqli_query($nConexion, "SELECT * FROM tblsitiossugeridos WHERE (idsitio = $nIdSitios) AND (publicar = 'S')");
  mysqli_close($nConexion);
  return $rsResultado;
}

function CargarMenuPpal($Padre)
{

  $nConexion    = Conectar();
  mysqli_set_charset($nConexion, 'utf8');
  $rs_Menu      = mysqli_query($nConexion, "SELECT * FROM tblmenu WHERE (publicar = 'S') AND (padre = $Padre) ORDER BY orden ASC");
  mysqli_close($nConexion);
  return $rs_Menu;
}


function ImprimirMenuPpal($nivel = 0)
{

  include("../admin/vargenerales.php");
  $html = "";
  $rsNivel = CargarMenuPpal($nivel);
  while ($rax = mysqli_fetch_assoc($rsNivel)) {
    $target = trim($rax["nueva_ventana"]) == "N" ? "_self" : "_blank";

    $tmp = call_user_func(__FUNCTION__, $rax["idmenu"]);
    $link = $rax["modulo"] != "Url" ? "/" . $rax["link"] : $rax["link"];

    $html .= "<li><a href=\"{$link}\" target=\"{$target}\">{$rax["titulo"]}</a>";

    if ($tmp != "") {
      $html .= "<ul>{$tmp}</ul><div style=\"position:absolute; top:40px; right:10px;\"></div>";
    }
    $html .= "</li>";
  }


  if ($nivel == 0) {
    echo " <div class=\"dcjq-mega-menu\"><ul id=\"mega-menu-tut\">{$html}</ul></div>";
  } else {
    return $html;
  }
}

function ImprimirMenuPpal3($nivel = 0)
{
  include("../admin/vargenerales.php");
  global $home;
  $html = "";
  $url = "/" . explode('/', $_SERVER['REQUEST_URI'])[1];
  if (!empty($home)) {
    $url = "/" . explode('/', $_SERVER['REQUEST_URI'])[2];
  }
  $rsNivel = CargarMenuPpal($nivel);
  while ($rax = mysqli_fetch_assoc($rsNivel)) {
    $target = trim($rax["nueva_ventana"]) == "N" ? "_self" : "_blank";

    $tmp = call_user_func(__FUNCTION__, $rax["idmenu"]);
    // $imagen = "";

    // if (!empty($rax["imagen"])) {
    //   $imagen = "<img src='$cRutaVerImgMenu{$rax["imagen"]}' alt='{$rax["titulo"]}'/>";
    // }
    $link = "$home/{$rax["link"]}";
    $activo = "";
    if ($url == $link) {
      $activo = "activo";
    }
    $logo = "";
    if ($rax["titulo"] == "logo") {
      $logo = "logo";
    }

    if ($rax["link"] == "quienes-somos") {
      //$activo .= " ocultar";
    }

    // $html .= "<li class='$activo'>
    //               <a href='$link' target='$target'>$imagen 
    //                 {$rax["titulo"]}
    //               </a>";

    $html .= "<li class='$activo'>
                  <a href='$link' target='$target'>
                    <span>{$rax["titulo"]}</span>
                  </a>";

    if ($tmp != "") {
      $html .= "<ul style='z-index:10;'>{$tmp}</ul>";
    }
    $html .= "</li>";
  }


  if ($nivel == 0) {
    echo "<ul class=\"menu-ppal\">{$html}</ul>";
  } else {
    return $html;
  }
}

function ImprimirMenuPie()
{
  $rs_MenuPie = CargarMenuPpal(0);
  echo "| ";
  $Contador = 0;
  while ($reg_MenuPie = mysqli_fetch_object($rs_MenuPie)) {
    $Contador = $Contador + 0;
    if ($Contador >= 4) {
      echo "<br>";
      $Contador = 0;
      echo "| ";
    }
  ?>
    <a href="<?php echo $reg_MenuPie->link; ?>" class="deResumenes" title="<?php echo $reg_MenuPie->titulo; ?>" <?php if ($reg_MenuPie->nueva_ventana == "S") { ?> target="_blank" <?php }  ?>> <?php echo $reg_MenuPie->titulo; ?> </a> | <?php
                                                                                                                                                                                                                                          }
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function CargarLogo()
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          $RegContenido = mysqli_fetch_object(VerContenido("Logo"));
                                                                                                                                                                                                                                          echo $RegContenido->contenido;
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function CargarCreditos()
                                                                                                                                                                                                                                        {

                                                                                                                                                                                                                                          $nConexion = Conectar();
                                                                                                                                                                                                                                          $sql = "SELECT * FROM tblsitio";
                                                                                                                                                                                                                                          $ra = mysqli_query($nConexion, $sql);
                                                                                                                                                                                                                                          if (!$ra) {
                                                                                                                                                                                                                                            return null;
                                                                                                                                                                                                                                          }
                                                                                                                                                                                                                                          $row = mysqli_fetch_array($ra);
                                                                                                                                                                                                                                          echo $row['creditos'];
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function CargarContactos()
                                                                                                                                                                                                                                        {

                                                                                                                                                                                                                                          $nConexion = Conectar();
                                                                                                                                                                                                                                          $RegContenido = mysqli_fetch_object(VerContenido("contactosHome"));
                                                                                                                                                                                                                                          $html = "<strong>$RegContenido->titulo;</strong><br>$RegContenido->contenido;<br>          
            
            
            <script type='text/javascript' src='http://www.skypeassets.com/i/scom/js/skype-uri.js'></script>
<div id='SkypeButton_Call_diremacolombia_1'>
  <script type='text/javascript'>
    Skype.ui({
      'name': 'dropdown',
      'element': 'SkypeButton_Call_diremacolombia_1',
      'participants': ['diremacolombia'],
      'imageColor': 'white',
      'imageSize': 24
    });
  </script>
</div>";
                                                                                                                                                                                                                                          echo $html;
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function tiendaCategoriaAssoc($idcategoria)
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          $nConexion = Conectar();
                                                                                                                                                                                                                                          mysqli_set_charset($nConexion, 'utf8');
                                                                                                                                                                                                                                          $sql = "select * from tblti_categorias where url = '$idcategoria'";
                                                                                                                                                                                                                                          $ra = mysqli_query($nConexion, $sql);
                                                                                                                                                                                                                                          return mysqli_fetch_assoc($ra);
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function tiendaCategoriaAssocId($idcategoria)
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          $nConexion = Conectar();
                                                                                                                                                                                                                                          $sql = "select * from tblti_categorias where idcategoria = '$idcategoria'";
                                                                                                                                                                                                                                          $ra = mysqli_query($nConexion, $sql);
                                                                                                                                                                                                                                          return mysqli_fetch_assoc($ra);
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function tiendaCategoriaAleatoria()
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          $nConexion = Conectar();
                                                                                                                                                                                                                                          $sql = "select * from tblti_categorias where idcategoria !=0 order by rand() limit 1";
                                                                                                                                                                                                                                          $ra = mysqli_query($nConexion, $sql);
                                                                                                                                                                                                                                          return mysqli_fetch_assoc($ra);
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function tiendaCategoriaSuperiorAssoc($idcategoria)
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          $nConexion = Conectar();
                                                                                                                                                                                                                                          $sql = "select * from tblti_categorias where idcategoria in (select idcategoria_superior from tblti_categorias where idcategoria = $idcategoria)";
                                                                                                                                                                                                                                          $ra = mysqli_query($nConexion, $sql);
                                                                                                                                                                                                                                          return mysqli_fetch_assoc($ra);
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function tiendaSubCategorias($idcategoria_superior = "0", $order = "nombre desc")
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          $nConexion = Conectar();
                                                                                                                                                                                                                                          $sql = "select * from tblti_categorias where idcategoria<>0 and idcategoria_superior = $idcategoria_superior order by {$order}";
                                                                                                                                                                                                                                          $ra = mysqli_query($nConexion, $sql);
                                                                                                                                                                                                                                          return $ra;
                                                                                                                                                                                                                                        }


                                                                                                                                                                                                                                        function tiendaProductoAssoc($url)
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          $nConexion = Conectar();
                                                                                                                                                                                                                                          mysqli_set_charset($nConexion, 'utf8');
                                                                                                                                                                                                                                          $sql = "select * from tblti_productos where url = '" . $url . "'";

                                                                                                                                                                                                                                          $sql = "SELECT  P.*,
                                                                                                                                                                                                                                                    U.nombre as uso
                                                                                                                                                                                                                                              FROM  tblti_productos P
                                                                                                                                                                                                                                        LEFT JOIN  agro_usos as U
                                                                                                                                                                                                                                                ON  P.usos = U.id
                                                                                                                                                                                                                                            WHERE  P.url = '{$url}' AND P.activo=1 ";

                                                                                                                                                                                                                                          $ra = mysqli_query($nConexion, $sql);
                                                                                                                                                                                                                                          if (mysqli_num_rows($ra) == 0) {
                                                                                                                                                                                                                                            return false;
                                                                                                                                                                                                                                          }
                                                                                                                                                                                                                                          return mysqli_fetch_assoc($ra);
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function tiendaProductoMasVendidos($limit = "1")
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          $nConexion = Conectar();
                                                                                                                                                                                                                                          $sql = "select * from tblti_productos where masvendidos=1 order by rand() limit {$limit}";
                                                                                                                                                                                                                                          $ra = mysqli_query($nConexion, $sql);
                                                                                                                                                                                                                                          return $ra;
                                                                                                                                                                                                                                        }


                                                                                                                                                                                                                                        function tiendaProductoOfertas($limit = "1")
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          $nConexion = Conectar();
                                                                                                                                                                                                                                          $sql = "select * from tblti_productos where promocion=1 order by rand() limit {$limit}";
                                                                                                                                                                                                                                          $ra = mysqli_query($nConexion, $sql);

                                                                                                                                                                                                                                          return $ra;
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function tiendaProductoPathImagen($rax, $n)
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          return "../fotos/tienda/productos/{$rax["idproducto"]}_{$n}_{$rax["imagen_{$n}"]}";
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function tiendaProductosAleatorios($idcategoria = -1, $limit = 5)
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          $where = "1=1";
                                                                                                                                                                                                                                          if ($idcategoria != -1) {
                                                                                                                                                                                                                                            $where = "idcategoria = {$idcategoria}";
                                                                                                                                                                                                                                          }

                                                                                                                                                                                                                                          $nConexion = Conectar();
                                                                                                                                                                                                                                          $sql = "select * from tblti_productos where {$where} order by rand() limit $limit";
                                                                                                                                                                                                                                          $ra = mysqli_query($nConexion, $sql);
                                                                                                                                                                                                                                          return $ra;
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function CargarExpresso($idcategoria = -1, $limit = 5)
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          $where = "1=1";
                                                                                                                                                                                                                                          if ($idcategoria != -1) {
                                                                                                                                                                                                                                            $where = "idcategoria = {$idcategoria}";
                                                                                                                                                                                                                                          }

                                                                                                                                                                                                                                          $nConexion = Conectar();
                                                                                                                                                                                                                                          $sql = "select * from tblarchivos where {$where} order by idarchivo desc limit $limit";
                                                                                                                                                                                                                                          $ra = mysqli_query($nConexion, $sql);
                                                                                                                                                                                                                                          return $ra;
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function tiendaProductos($idcategoria, $order = "referencia asc")
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          $nConexion = Conectar();
                                                                                                                                                                                                                                          $sql = "select * from tblti_productos where idcategoria = $idcategoria order by {$order}";
                                                                                                                                                                                                                                          $ra = mysqli_query($nConexion, $sql);
                                                                                                                                                                                                                                          return $ra;
                                                                                                                                                                                                                                        }


                                                                                                                                                                                                                                        function tiendaProductoAnteriorAssoc($rx)
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          $nConexion = Conectar();
                                                                                                                                                                                                                                          $sql = "select * from tblti_productos where idcategoria={$rx["idcategoria"]} and idproducto < {$rx["idproducto"]} order by idproducto desc limit 1 ";
                                                                                                                                                                                                                                          $ra = mysqli_query($nConexion, $sql);
                                                                                                                                                                                                                                          if (mysqli_num_rows($ra) == 0) {
                                                                                                                                                                                                                                            return false;
                                                                                                                                                                                                                                          }
                                                                                                                                                                                                                                          return mysqli_fetch_assoc($ra);
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function tiendaProductoSiguienteAssoc($rx)
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          $nConexion = Conectar();
                                                                                                                                                                                                                                          $sql = "select * from tblti_productos where idcategoria={$rx["idcategoria"]} and idproducto > {$rx["idproducto"]} order by idproducto asc limit 1 ";
                                                                                                                                                                                                                                          $ra = mysqli_query($nConexion, $sql);
                                                                                                                                                                                                                                          if (mysqli_num_rows($ra) == 0) {
                                                                                                                                                                                                                                            return false;
                                                                                                                                                                                                                                          }
                                                                                                                                                                                                                                          return mysqli_fetch_assoc($ra);
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function tiendaProductosRelacionados($idproducto, $order = "referencia asc")
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          $nConexion = Conectar();
                                                                                                                                                                                                                                          $sql = "select b.* from tblti_productos_asociados a join tblti_productos b  on (a.idproductoa=b.idproducto) 
    where a.idproducto={$idproducto} order by {$order}";

                                                                                                                                                                                                                                          $ra = mysqli_query($nConexion, $sql);
                                                                                                                                                                                                                                          return $ra;
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function foroCategorias()
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          $nConexion = Conectar();
                                                                                                                                                                                                                                          $sql = "select * from tblforo_categorias order by nombre";
                                                                                                                                                                                                                                          $ra = mysqli_query($nConexion, $sql);

                                                                                                                                                                                                                                          if (!$ra) {
                                                                                                                                                                                                                                            die("Fallo consultando categorias del foro");
                                                                                                                                                                                                                                          }
                                                                                                                                                                                                                                          return $ra;
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function foroCategoriasUltimoTemaAssoc($idCategoria)
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          $nConexion = Conectar();
                                                                                                                                                                                                                                          $sql = "select *, 
    (select count(*) from tblforo_temas where idcategoria={$idCategoria} ) as temas, 
    (select count(*) from tblforo_comentarios where idtema in (select idtema from tblforo_temas where idcategoria={$idCategoria} ) ) as mensajes 
    from tblforo_temas where idcategoria={$idCategoria} order by idtema desc limit 1";
                                                                                                                                                                                                                                          $ra = mysqli_query($nConexion, $sql);

                                                                                                                                                                                                                                          if (!$ra) {
                                                                                                                                                                                                                                            echo $sql;
                                                                                                                                                                                                                                            die("Fallo consultando ultimo tema del foro");
                                                                                                                                                                                                                                          }

                                                                                                                                                                                                                                          if (mysqli_num_rows($ra) == 0) {
                                                                                                                                                                                                                                            return false;
                                                                                                                                                                                                                                          }

                                                                                                                                                                                                                                          return mysqli_fetch_assoc($ra);
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function foroCategoriaAssoc($idCategoria)
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          $nConexion = Conectar();
                                                                                                                                                                                                                                          $sql = "select * from tblforo_categorias where idcategoria={$idCategoria}";
                                                                                                                                                                                                                                          $ra = mysqli_query($nConexion, $sql);

                                                                                                                                                                                                                                          if (!$ra) {
                                                                                                                                                                                                                                            die("Fallo consultando categoria del foro");
                                                                                                                                                                                                                                          }
                                                                                                                                                                                                                                          return mysqli_fetch_assoc($ra);
                                                                                                                                                                                                                                        }


                                                                                                                                                                                                                                        function foroTemas($idCategoria)
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          $nConexion = Conectar();
                                                                                                                                                                                                                                          $sql = "select *,
    (select count(*) from tblforo_comentarios where idtema=tblforo_temas.idtema) as comentarios,
    (select fechahora from tblforo_comentarios where idtema=tblforo_temas.idtema order by idcomentario desc limit 1) as ultima_fechahora,
    (select usuario from tblforo_comentarios where idtema=tblforo_temas.idtema order by idcomentario desc limit 1) as ultimo_usuario
    from tblforo_temas where idcategoria={$idCategoria} order by fechahora desc";
                                                                                                                                                                                                                                          $ra = mysqli_query($nConexion, $sql);

                                                                                                                                                                                                                                          if (!$ra) {
                                                                                                                                                                                                                                            die("Fallo consultando temas del foro");
                                                                                                                                                                                                                                          }
                                                                                                                                                                                                                                          return $ra;
                                                                                                                                                                                                                                        }


                                                                                                                                                                                                                                        function foroTemaAssoc($idTema)
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          $nConexion = Conectar();
                                                                                                                                                                                                                                          $sql = "select * from tblforo_temas where idtema={$idTema}";
                                                                                                                                                                                                                                          $ra = mysqli_query($nConexion, $sql);

                                                                                                                                                                                                                                          if (!$ra) {
                                                                                                                                                                                                                                            die("Fallo consultando tema del foro");
                                                                                                                                                                                                                                          }
                                                                                                                                                                                                                                          return mysqli_fetch_assoc($ra);
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function foroTemaVisitar($idTema)
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          $nConexion = Conectar();
                                                                                                                                                                                                                                          $sql = "update tblforo_temas set lecturas=lecturas+1 where idtema={$idTema}";
                                                                                                                                                                                                                                          $ra = mysqli_query($nConexion, $sql);

                                                                                                                                                                                                                                          if (!$ra) {
                                                                                                                                                                                                                                            die("Fallo actualizando visitas del tema");
                                                                                                                                                                                                                                          }
                                                                                                                                                                                                                                          return true;
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function foroComentarios($idTema)
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          $nConexion = Conectar();
                                                                                                                                                                                                                                          $sql = "select * from tblforo_comentarios where idtema = {$idTema} order by fechahora asc";
                                                                                                                                                                                                                                          $ra = mysqli_query($nConexion, $sql);

                                                                                                                                                                                                                                          if (!$ra) {
                                                                                                                                                                                                                                            die("Fallo consultando comentarios del foro");
                                                                                                                                                                                                                                          }
                                                                                                                                                                                                                                          return $ra;
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function foroComentariosAleatorio($orden = '', $registros = -1)
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          $sql = "select * from tblforo_comentarios where trim(mensaje)<>''";
                                                                                                                                                                                                                                          if ($orden != "") {
                                                                                                                                                                                                                                            $sql .= " order by {$orden}";
                                                                                                                                                                                                                                          }
                                                                                                                                                                                                                                          if ($registros > 0) {
                                                                                                                                                                                                                                            $sql .= " limit {$registros}";
                                                                                                                                                                                                                                          }
                                                                                                                                                                                                                                          $nConexion    = Conectar();
                                                                                                                                                                                                                                          $ra = mysqli_query($nConexion, $sql);
                                                                                                                                                                                                                                          return $ra;
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        /******************************************************************************/

                                                                                                                                                                                                                                        function videosYoutubeCategoriaAssoc($idcategoria)
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          $nConexion = Conectar();
                                                                                                                                                                                                                                          $sql = "select * from tblvideosyoutube_categorias where idcategoria = $idcategoria";
                                                                                                                                                                                                                                          $ra = mysqli_query($nConexion, $sql);
                                                                                                                                                                                                                                          return mysqli_fetch_assoc($ra);
                                                                                                                                                                                                                                        }


                                                                                                                                                                                                                                        function videosYoutubeSubCategorias($idcategoria_superior = "0", $order = "vpath asc")
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          $nConexion = Conectar();
                                                                                                                                                                                                                                          $sql = "select * from tblvideosyoutube_categorias 
    where idcategoria<>0 and idcategoria_superior = $idcategoria_superior order by {$order}";

                                                                                                                                                                                                                                          $ra = mysqli_query($nConexion, $sql);
                                                                                                                                                                                                                                          return $ra;
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function musicaCategorias()
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          $nConexion = Conectar();
                                                                                                                                                                                                                                          $sql = "select * from tblcategoriasmusica";

                                                                                                                                                                                                                                          $ra = mysqli_query($nConexion, $sql);
                                                                                                                                                                                                                                          return $ra;
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function musica($idcategoria = -1, $order = "idmusica desc")
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          $nConexion = Conectar();
                                                                                                                                                                                                                                          $sql = "select * from tblmusica ";
                                                                                                                                                                                                                                          if ($idcategoria != -1) {
                                                                                                                                                                                                                                            $sql .= " where idcategoria = $idcategoria ";
                                                                                                                                                                                                                                          }

                                                                                                                                                                                                                                          $sql .= " order by {$order}";
                                                                                                                                                                                                                                          $ra = mysqli_query($nConexion, $sql);
                                                                                                                                                                                                                                          return $ra;
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function videosYoutube($idcategoria = -1, $order = "idvideo desc")
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          $nConexion = Conectar();
                                                                                                                                                                                                                                          mysqli_set_charset($nConexion, 'utf8');
                                                                                                                                                                                                                                          $sql = "select * from tblvideosyoutube ";
                                                                                                                                                                                                                                          if ($idcategoria != -1) {
                                                                                                                                                                                                                                            $sql .= " where idcategoria = $idcategoria ";
                                                                                                                                                                                                                                          }

                                                                                                                                                                                                                                          $sql .= " order by {$order}";
                                                                                                                                                                                                                                          $ra = mysqli_query($nConexion, $sql);
                                                                                                                                                                                                                                          return $ra;
                                                                                                                                                                                                                                        }


                                                                                                                                                                                                                                        function videosYoutubeAssoc($idvideo)
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          $nConexion = Conectar();
                                                                                                                                                                                                                                          mysqli_set_charset($nConexion, 'utf8');
                                                                                                                                                                                                                                          $sql = "select * from tblvideosyoutube where idvideo={$idvideo}";
                                                                                                                                                                                                                                          $ra = mysqli_query($nConexion, $sql);
                                                                                                                                                                                                                                          if (mysqli_num_rows($ra) == 0) {
                                                                                                                                                                                                                                            return false;
                                                                                                                                                                                                                                          }

                                                                                                                                                                                                                                          $rax = mysqli_fetch_assoc($ra);
                                                                                                                                                                                                                                          return $rax;
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function videosYoutubeEmbed($raVideo, $op)
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          $op["w"] = isset($op["w"]) ? $op["w"] : "400";
                                                                                                                                                                                                                                          $op["h"] = isset($op["h"]) ? $op["h"] : "300";

                                                                                                                                                                                                                                          $url = $raVideo["url"];
                                                                                                                                                                                                                                          $url = str_replace("watch?v=", "/v/", $url);
                                                                                                                                                                                                                                          ob_start();
                                                                                                                                                                                                                                            ?>
  <object width="<?php echo $op["w"]; ?>" height="<?php echo $op["h"]; ?>">
    <param name="movie" value="<?php echo $url ?>&hl=es_ES&fs=1&">
    </param>
    <param name="allowFullScreen" value="true">
    </param>
    <param name="allowscriptaccess" value="always">
    </param><embed src="<?php echo $url; ?>&hl=es_ES&fs=1&" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="<?php echo $op["w"]; ?>" height="<?php echo $op["h"]; ?>"></embed>
  </object>
<?php
                                                                                                                                                                                                                                          $html = ob_get_contents();
                                                                                                                                                                                                                                          ob_end_clean();
                                                                                                                                                                                                                                          return $html;
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function videosYoutubePreview($raVideo, $op = array())
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          $url = explode("watch?v=", $raVideo);
                                                                                                                                                                                                                                          $url = explode("&", $url[1]);
                                                                                                                                                                                                                                          $url = $url[0];
                                                                                                                                                                                                                                          return "http://img.youtube.com/vi/{$url}/mqdefault.jpg";
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function captchaValida($d, $nombre)
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          //die(print_r($_SESSION,1));
                                                                                                                                                                                                                                          if ($_SESSION["CAPTCHA_{$nombre}"] != $d["captcha"]) {
                                                                                                                                                                                                                                            return "Te has confundido introduciendo el código";
                                                                                                                                                                                                                                          }
                                                                                                                                                                                                                                          return true;
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        /*******************************************************************************/

                                                                                                                                                                                                                                        function usuariosCargarAssoc($correo)
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          $nConexion = Conectar();
                                                                                                                                                                                                                                          $sql = "select * from tblusuarios_externos where correo_electronico='{$correo}'";
                                                                                                                                                                                                                                          $ra = mysqli_query($nConexion, $sql);

                                                                                                                                                                                                                                          if (!$ra) {
                                                                                                                                                                                                                                            die("Fallo consultando usuario");
                                                                                                                                                                                                                                          }
                                                                                                                                                                                                                                          return mysqli_fetch_assoc($ra);
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function updateSession()
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          $nConexion = Conectar();
                                                                                                                                                                                                                                          $sql = "select * from tblusuarios_externos where idusuario=:idusuario";

                                                                                                                                                                                                                                          $ca = new DbQuery($nConexion);
                                                                                                                                                                                                                                          $ca->prepare($sql);
                                                                                                                                                                                                                                          $ca->bindValue(":idusuario", $_SESSION["usuario"]["idusuario"], false);
                                                                                                                                                                                                                                          $ca->exec();

                                                                                                                                                                                                                                          $rax = $ca->assoc();
                                                                                                                                                                                                                                          $_SESSION["usuario"] = $rax;
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function usuariosRegistrar($d)
                                                                                                                                                                                                                                        {

                                                                                                                                                                                                                                          $nConexion = Conectar();
                                                                                                                                                                                                                                          $rUsuario = usuariosCargarAssoc($d["correo"]);

                                                                                                                                                                                                                                          if ($rUsuario["correo_electronico"] == $d["correo"]) {
                                                                                                                                                                                                                                            return "Error, correo electrónico ya registrado";
                                                                                                                                                                                                                                          }

                                                                                                                                                                                                                                          $clave = hash("sha256", $d["clave"]);

                                                                                                                                                                                                                                          $sql = "INSERT INTO tblusuarios_externos (nombre,apellido,telefono,clave,correo_electronico)
    VALUES ('{$d["nombre"]}','{$d["apellido"]}','{$d["telefono"]}','{$clave}','{$d["correo"]}')";

                                                                                                                                                                                                                                          $ra = mysqli_query($nConexion, $sql);
                                                                                                                                                                                                                                          if (!$ra) {
                                                                                                                                                                                                                                            return "Fallo insertando nuevo usuario";
                                                                                                                                                                                                                                          }
                                                                                                                                                                                                                                          return true;
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function usuarioRecuperarClave($d)
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          if ($d["correo_electronico"] == "") {
                                                                                                                                                                                                                                            die("Debe ingresar el correo electronico");
                                                                                                                                                                                                                                          }

                                                                                                                                                                                                                                          $nConexion = Conectar();
                                                                                                                                                                                                                                          $sql = "SELECT * FROM tblusuarios_externos WHERE correo_electronico='{$d['correo_electronico']}'";
                                                                                                                                                                                                                                          $ra = mysqli_query($nConexion, $sql);
                                                                                                                                                                                                                                          if (!$ra) {
                                                                                                                                                                                                                                            die("Error consultando información de usuario para reenviar clave");
                                                                                                                                                                                                                                          }
                                                                                                                                                                                                                                          $usuarioInfo = mysqli_fetch_assoc($ra);
                                                                                                                                                                                                                                          if ($usuarioInfo["correo_electronico"] != $d["correo_electronico"]) {
                                                                                                                                                                                                                                            die("Error, no se encontro información del usuario con para el correo {$d['correo_electronico']}");
                                                                                                                                                                                                                                          }

                                                                                                                                                                                                                                          $clave = substr(md5(rand() . rand()), 0, 7);

                                                                                                                                                                                                                                          $hclave = hash("sha256", $clave);

                                                                                                                                                                                                                                          $sql = "update tblusuarios_externos set clave='{$hclave}' where correo_electronico='{$d["correo_electronico"]}'";
                                                                                                                                                                                                                                          $ra = mysqli_query($nConexion, $sql);
                                                                                                                                                                                                                                          if (!$ra) {
                                                                                                                                                                                                                                            die("Error, fallo asignando nueva clave.");
                                                                                                                                                                                                                                          }

                                                                                                                                                                                                                                          $m = new MAIL();
                                                                                                                                                                                                                                          $host = str_replace("www.", "", $_SERVER["HTTP_HOST"]);

                                                                                                                                                                                                                                          $m->addHeader("charset", "utf-8");
                                                                                                                                                                                                                                          $m->from("soporte@{$host}", "Departamento de Soporte");
                                                                                                                                                                                                                                          //$m->addto("juanfeh@hotmail.com","{$_SESSION["usuario"]["nombre"]}");
                                                                                                                                                                                                                                          $m->addto("{$usuarioInfo["correo_electronico"]}", "{$usuarioInfo["nombre"]}");
                                                                                                                                                                                                                                          $m->subject("Clave Zona Usuarios Clickee");


                                                                                                                                                                                                                                          $html = "<html><head><title>Clave Zona Usuarios Clickee</title></head>
  <body>Se ha generado una nueva clave para que pueda ingresar a Clickee.com. Sus nuevos datos de acceso son:<br><br>
  Usuario: {$usuarioInfo['usuario']}<br>Clave: {$clave}</body></html>";

                                                                                                                                                                                                                                          $m->html($html);

                                                                                                                                                                                                                                          $cHost = $host;
                                                                                                                                                                                                                                          $cPort = 25;
                                                                                                                                                                                                                                          $cUser = "soporte@clickee.com";
                                                                                                                                                                                                                                          $cPass = "mhyy964";

                                                                                                                                                                                                                                          $c = $m->Connect($cHost, $cPort, $cUser, $cPass);
                                                                                                                                                                                                                                          $status = $m->send($c);

                                                                                                                                                                                                                                          if (!$status) {
                                                                                                                                                                                                                                            die("Error enviando mensaje");
                                                                                                                                                                                                                                          }

                                                                                                                                                                                                                                          return true;
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function usuariosAutenticar($correo, $clave)
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          if (trim($correo) == "") {
                                                                                                                                                                                                                                            return false;
                                                                                                                                                                                                                                          }
                                                                                                                                                                                                                                          $nConexion = Conectar();
                                                                                                                                                                                                                                          $sql = "select 
    a.*,
    DATE_FORMAT(a.fecha_nacimiento,'%b %d') as cumpleano,
    b.idsede as tickets_idsede,
    b.tipo as tickets_tipo,
    b.attr_tipo as tickets_attr_tipo,
    d.idzona as tickets_idzona,
    e.idregion as tickets_idregion,
    f.idempresa as tickets_idempresa
    
    from tblusuarios_externos a
    left join tbltk_sedes_usuarios b on (a.idusuario=b.idusuario)
    left join tbltk_sedes c on (b.idsede=c.idsede)
    left join tbltk_zonas d on (c.idzona=d.idzona)
    left join tbltk_regiones e on (d.idregion=e.idregion)
    left join tbltk_empresas f on (e.idempresa=f.idempresa)
    
    where a.correo_electronico=:correo and a.activo=1";

                                                                                                                                                                                                                                          $ca = new DbQuery($nConexion);
                                                                                                                                                                                                                                          $ca->prepare($sql);
                                                                                                                                                                                                                                          $ca->bindValue(":correo", $correo, true);

                                                                                                                                                                                                                                          if (!$ca->exec()) {
                                                                                                                                                                                                                                            return ("Error consultando usuario");
                                                                                                                                                                                                                                          }
                                                                                                                                                                                                                                          if ($ca->size() == 0) {
                                                                                                                                                                                                                                            return ("Correo electrónico no registrado");
                                                                                                                                                                                                                                          }

                                                                                                                                                                                                                                          $rax = $ca->assoc();
                                                                                                                                                                                                                                          $clave = hash("sha256", $clave);

                                                                                                                                                                                                                                          //die($rax["clave"]."  ".$clave);

                                                                                                                                                                                                                                          if ($rax["clave"] !== $clave) {
                                                                                                                                                                                                                                            return "Clave de acceso incorrecta";
                                                                                                                                                                                                                                          }

                                                                                                                                                                                                                                          $_SESSION["loggedin"] = true;
                                                                                                                                                                                                                                          $_SESSION["usuario"] = $rax;

                                                                                                                                                                                                                                          $ca->prepareUpdate("tblusuarios_externos", "insession,last_timesession", "correo_electronico=:correo");
                                                                                                                                                                                                                                          $ca->bindValue(":insession", "true", false);
                                                                                                                                                                                                                                          $ca->bindValue(":last_timesession", "CURRENT_TIMESTAMP", false);
                                                                                                                                                                                                                                          $ca->bindValue(":correo", $correo, true);
                                                                                                                                                                                                                                          if (!$ca->exec()) {
                                                                                                                                                                                                                                            return ("Fallo registrando sesión");
                                                                                                                                                                                                                                          }

                                                                                                                                                                                                                                          return true;
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function usuariosFinSesion()
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          if (isset($_SESSION["usuario"])) {
                                                                                                                                                                                                                                            $nConexion = Conectar();
                                                                                                                                                                                                                                            $ca = new DbQuery($nConexion);
                                                                                                                                                                                                                                            $ca->prepareUpdate("tblusuarios_externos", "insession", "idusuario=:idusuario");
                                                                                                                                                                                                                                            $ca->bindValue(":insession", "false", false);
                                                                                                                                                                                                                                            $ca->bindValue(":idusuario", $_SESSION["usuario"]["idusuario"], false);
                                                                                                                                                                                                                                            if (!$ca->exec()) {
                                                                                                                                                                                                                                              die("Fallo registrando fin de sesión");
                                                                                                                                                                                                                                            }
                                                                                                                                                                                                                                          }
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function usuariosLogueados()
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          $nConexion = Conectar();
                                                                                                                                                                                                                                          $ca = new DbQuery($nConexion);
                                                                                                                                                                                                                                          $ca->prepareSelect("tblusuarios_externos", "count(*) as usuarios", "insession and current_timestamp - interval 20 minute <= last_timesession");
                                                                                                                                                                                                                                          if (!$ca->exec()) {
                                                                                                                                                                                                                                            die("Fallo registrando fin de sesión");
                                                                                                                                                                                                                                          }
                                                                                                                                                                                                                                          $r = $ca->fetch();
                                                                                                                                                                                                                                          return $r["usuarios"];
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function usuariosVerificar()
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          global $IdCiudad;
                                                                                                                                                                                                                                          if (!isset($_SESSION["usuario"])) {
                                                                                                                                                                                                                                            header("Location: /home");
                                                                                                                                                                                                                                          }
                                                                                                                                                                                                                                          return true;
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function usuariosIdDesdeCorreo($correo)
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          $nConexion = Conectar();
                                                                                                                                                                                                                                          $sql = "select idusuario from tblusuarios_externos where lower(correo_electronico)=lower('{$correo}')";
                                                                                                                                                                                                                                          $ra = mysqli_query($nConexion, $sql);
                                                                                                                                                                                                                                          if (mysqli_num_rows($ra) == 0) {
                                                                                                                                                                                                                                            return 0;
                                                                                                                                                                                                                                          }

                                                                                                                                                                                                                                          $rax = mysqli_fetch_assoc($ra);
                                                                                                                                                                                                                                          return $rax["idusuario"];
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function usuariosInfoDesdeId($idUsuario)
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          $nConexion = Conectar();
                                                                                                                                                                                                                                          $sql = "select * 
  from tblusuarios_externos 
  where idusuario={$idUsuario}";

                                                                                                                                                                                                                                          $ra = mysqli_query($nConexion, $sql);
                                                                                                                                                                                                                                          if (mysqli_num_rows($ra) == 0) {
                                                                                                                                                                                                                                            return 0;
                                                                                                                                                                                                                                          }

                                                                                                                                                                                                                                          $rax = mysqli_fetch_assoc($ra);
                                                                                                                                                                                                                                          return $rax;
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function usuariosArchivosContar($correo)
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          $nConexion = Conectar();
                                                                                                                                                                                                                                          $sql = "select tipo,count(*) as count from tblusuarios_archivos where correo_electronico='{$correo}' group by tipo";

                                                                                                                                                                                                                                          $ra = mysqli_query($nConexion, $sql);
                                                                                                                                                                                                                                          if (!$ra) {
                                                                                                                                                                                                                                            die("Fallo consultando cantidad de archivos");
                                                                                                                                                                                                                                          }

                                                                                                                                                                                                                                          $result = array("OFFICE" => 0, "FOTO" => 0, "VIDEOS" => 0);

                                                                                                                                                                                                                                          while ($r = mysqli_fetch_array($ra)) {
                                                                                                                                                                                                                                            $result[$r["tipo"]] = $r["count"];
                                                                                                                                                                                                                                          }

                                                                                                                                                                                                                                          return $result;
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function usuariosArchivosCargar($correo, $tipo, $filtro = "")
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          $nConexion = Conectar();
                                                                                                                                                                                                                                          $sql = "select * from tblusuarios_archivos where correo_electronico='{$correo}' and tipo='{$tipo}'";

                                                                                                                                                                                                                                          if ($filtro != "") {
                                                                                                                                                                                                                                            $sql .= " and {$filtro}";
                                                                                                                                                                                                                                          }

                                                                                                                                                                                                                                          $sql .= " order by fechahora desc";
                                                                                                                                                                                                                                          $ra = mysqli_query($nConexion, $sql);
                                                                                                                                                                                                                                          if (!$ra) {
                                                                                                                                                                                                                                            die("Fallo consultando archivos");
                                                                                                                                                                                                                                          }
                                                                                                                                                                                                                                          return $ra;
                                                                                                                                                                                                                                        }


                                                                                                                                                                                                                                        function usuariosArchivosGuardar($idarchivo, $tipo, $correo, $nombre, $descripcion, $archivo)
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          $nConexion = Conectar();

                                                                                                                                                                                                                                          $archivoSql = !is_null($archivo) ? ",archivo='{$archivo["name"]}'" : "";

                                                                                                                                                                                                                                          if (is_null($idarchivo)) {
                                                                                                                                                                                                                                            $sql = "insert into tblusuarios_archivos (tipo,correo_electronico,nombre,descripcion,archivo) 
        values ('{$tipo}','{$correo}','{$nombre}','{$descripcion}','{$archivo["name"]}')";
                                                                                                                                                                                                                                          } else {
                                                                                                                                                                                                                                            $sql = "update tblusuarios_archivos set nombre='{$nombre}',descripcion='{$descripcion}'
        {$archivoSql}
        where idarchivo={$idarchivo}";
                                                                                                                                                                                                                                          }

                                                                                                                                                                                                                                          if (!mysqli_query($nConexion, $sql)) {
                                                                                                                                                                                                                                            return "Fallo almacenando archivo";
                                                                                                                                                                                                                                          }

                                                                                                                                                                                                                                          if (!is_null($idarchivo)) {
                                                                                                                                                                                                                                            $id = $idarchivo;
                                                                                                                                                                                                                                          } else {
                                                                                                                                                                                                                                            $id = mysqli_insert_id($nConexion);
                                                                                                                                                                                                                                          }

                                                                                                                                                                                                                                          if (!is_null($archivo)) {
                                                                                                                                                                                                                                            if (!move_uploaded_file($archivo['tmp_name'], "../fotos/usuariosarchivos/{$id}")) {
                                                                                                                                                                                                                                              return "Fallo cargango archivo";
                                                                                                                                                                                                                                            }
                                                                                                                                                                                                                                          }

                                                                                                                                                                                                                                          return $id;
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function usuariosArchivosAssoc($idarchivo)
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          $nConexion = Conectar();
                                                                                                                                                                                                                                          $sql = "select * from tblusuarios_archivos where idarchivo={$idarchivo}";
                                                                                                                                                                                                                                          $ra = mysqli_query($nConexion, $sql);
                                                                                                                                                                                                                                          if (!$ra) {
                                                                                                                                                                                                                                            die("Fallo consultando archivo {$idarchivo}");
                                                                                                                                                                                                                                          }
                                                                                                                                                                                                                                          return mysqli_fetch_assoc($ra);
                                                                                                                                                                                                                                        }


                                                                                                                                                                                                                                        function usuariosArchivosEliminar($correo, $tipo, $idarchivo)
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          $nConexion = Conectar();
                                                                                                                                                                                                                                          $sql = "delete from tblusuarios_archivos 
    where correo_electronico='{$correo}' and tipo='{$tipo}' and idarchivo={$idarchivo}";


                                                                                                                                                                                                                                          $ra = mysqli_query($nConexion, $sql);
                                                                                                                                                                                                                                          if (!$ra) {
                                                                                                                                                                                                                                            die("Fallo eliminando archivo {$idarchivo}");
                                                                                                                                                                                                                                          }
                                                                                                                                                                                                                                          @unlink("../fotos/usuariosarchivos/{$idarchivo}");

                                                                                                                                                                                                                                          return true;
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function hostName()
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          $host = str_replace("www.", "", strtolower($_SERVER["HTTP_HOST"]));
                                                                                                                                                                                                                                          return $host;
                                                                                                                                                                                                                                        }


                                                                                                                                                                                                                                        function enviarCorreo($from, $fromName, $to, $toName, $subject, $message)
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          if (filter_var($to, FILTER_VALIDATE_EMAIL) === false) {
                                                                                                                                                                                                                                            die("Correo invalido en {__FUNCTION__} Asunto:{$subject} Correo:{$to}");
                                                                                                                                                                                                                                          }


                                                                                                                                                                                                                                          $m = new MAIL();
                                                                                                                                                                                                                                          $host = hostName();


                                                                                                                                                                                                                                          $from = !empty($from) ? $from : "soporte@{$host}";
                                                                                                                                                                                                                                          $fromName = !empty($fromName) ? $fromName : "Soporte";

                                                                                                                                                                                                                                          $m->addHeader("charset", "utf-8");
                                                                                                                                                                                                                                          $m->from($from, $fromName);
                                                                                                                                                                                                                                          $m->addto($to, $toName);
                                                                                                                                                                                                                                          $m->subject($subject);

                                                                                                                                                                                                                                          $m->html($message);

                                                                                                                                                                                                                                          $cHost = $host;
                                                                                                                                                                                                                                          $cPort = 25;
                                                                                                                                                                                                                                          $cUser = "solicitudes@{$host}";
                                                                                                                                                                                                                                          $cPass = "/060371*";

                                                                                                                                                                                                                                          $c = $m->Connect($cHost, $cPort, $cUser, $cPass);
                                                                                                                                                                                                                                          $status = $m->send($c);

                                                                                                                                                                                                                                          if (!$status) {
                                                                                                                                                                                                                                            die("Error enviando mensaje");
                                                                                                                                                                                                                                          }

                                                                                                                                                                                                                                          return true;
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function galeriaCategoriaAssoc($idCategoria)
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          $sql = "select * from tblcategoriasimagenes where idcategoria={$idCategoria}";
                                                                                                                                                                                                                                          $ra = mysqli_query($nConexion, $sql);
                                                                                                                                                                                                                                          if (mysqli_num_rows($ra) == 0) {
                                                                                                                                                                                                                                            return false;
                                                                                                                                                                                                                                          }

                                                                                                                                                                                                                                          return mysqli_fetch_assoc($ra);
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function revolutionSlider($idcategoria, $idFT = "jquery")
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          global $cRutaVerCabezotesjq;
                                                                                                                                                                                                                                          $html = '';
                                                                                                                                                                                                                                          $imgs = '';
                                                                                                                                                                                                                                          $nConexion = Conectar();

                                                                                                                                                                                                                                          $sql = "select a.* from tblcabezotes a where a.idcategoria={$idcategoria} order by orden";

                                                                                                                                                                                                                                          $rsImagenes = mysqli_query($nConexion, $sql);

                                                                                                                                                                                                                                          $html .= "
      <div class='tp-banner-container '>
        <div class='tp-banner '>
          <ul class='content--parallax'>";

                                                                                                                                                                                                                                          while ($rax = mysqli_fetch_assoc($rsImagenes)) {
                                                                                                                                                                                                                                            $html .= "<li data-transition='fade' data-slotamount='1' data-masterspeed='1000' data-saveperformance='off' data-title='Slide '>
        <img src='{$cRutaVerCabezotesjq}{$rax['archivo']}' alt='slide1' data-bgposition='center center' data-bgfit='cover' data-bgrepeat='no-repeat'>";
                                                                                                                                                                                                                                            if (!empty($rax['descripcion'])) {
                                                                                                                                                                                                                                              $html .= "	<div class='tp-caption lfb' data-x='center' data-y='center' data-voffset='160' data-speed='600' data-start='1100' data-easing='Power4.easeOut' data-endeasing='Power4.easeIn' style='z-index: 4;'>{$rax['descripcion']}</div>";
                                                                                                                                                                                                                                            }
                                                                                                                                                                                                                                            $html .= "	</li>";
                                                                                                                                                                                                                                          }
                                                                                                                                                                                                                                          $html .= "
          </ul>
        </div>
      </div>";

                                                                                                                                                                                                                                          return $html;
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function cabezoteJquery($idcategoria, $idFT = "jquery")
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          global $cRutaVerCabezotesjq;
                                                                                                                                                                                                                                          global $home;
                                                                                                                                                                                                                                          $html = '';
                                                                                                                                                                                                                                          $imgs = '';
                                                                                                                                                                                                                                          $nConexion = Conectar();

                                                                                                                                                                                                                                          $sql = "select opacidad,textura from tblcabezotes_categorias where idcategoria={$idcategoria}";

                                                                                                                                                                                                                                          $rCategorias = mysqli_query($nConexion, $sql);
                                                                                                                                                                                                                                          $efectos = mysqli_fetch_assoc($rCategorias);

                                                                                                                                                                                                                                          $propiedades = array();
                                                                                                                                                                                                                                          foreach ($efectos as $k => $v) {
                                                                                                                                                                                                                                            $propiedades[$k] = preg_match("/^[0-9]*\.?,?[0-9]*$/", $v) ? $v * 1 : $v;
                                                                                                                                                                                                                                          }

                                                                                                                                                                                                                                          $sql = "select a.* from tblcabezotes a where a.idcategoria={$idcategoria} order by orden";

                                                                                                                                                                                                                                          $rsImagenes = mysqli_query($nConexion, $sql);

                                                                                                                                                                                                                                          $opacitad = $propiedades["opacidad"];
                                                                                                                                                                                                                                          $textura = $propiedades["textura"];

                                                                                                                                                                                                                                          $html .= "
    <div class='slider' data-0='top: 0px;' data-500='top: -200px;'>
      <link href='$home/css/camera.css' rel='stylesheet' type='text/css' />
      <script type='text/javascript' src='$home/php/js/camera.min.js'></script>
    <script type='text/javascript' src='$home/php/js/jquery.easing.1.3.js'></script>
      <style>
                .{$textura} .camera_overlayer{
                    opacity:{$opacitad};
                }
            </style>
            <div class='camera_wrap camera_emboss {$textura}' id='camera_wrap_1'>";

                                                                                                                                                                                                                                          while ($rax = mysqli_fetch_assoc($rsImagenes)) {
                                                                                                                                                                                                                                            $html .= "	<div data-src='{$cRutaVerCabezotesjq}{$rax['archivo']}' data-link='{$rax['url']}' data-target='{$rax['target']}' data-thumb='{$cRutaVerCabezotesjq}{$rax['archivo']}'>";
                                                                                                                                                                                                                                            if (!empty($rax['descripcion'])) {
                                                                                                                                                                                                                                              $html .= "	<div class='ei-title fadeIn'>{$rax['descripcion']}</div>";
                                                                                                                                                                                                                                            }
                                                                                                                                                                                                                                            $html .= "	</div>";
                                                                                                                                                                                                                                          }
                                                                                                                                                                                                                                          $html .= "</div>";
                                                                                                                                                                                                                                          $html .= "
        <script type='text/javascript'>
            $(function() {
                $('#camera_wrap_1').camera({
            playPause: false,
            height: '37%'
          });
            });
        </script>
    </div>";

                                                                                                                                                                                                                                          return $html;
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function cabezoteJqueryIn($idcategoria, $idFT = "jquery")
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          global $cRutaVerCabezotesjq;
                                                                                                                                                                                                                                          global $home;
                                                                                                                                                                                                                                          $html = '';
                                                                                                                                                                                                                                          $imgs = '';
                                                                                                                                                                                                                                          $nConexion = Conectar();

                                                                                                                                                                                                                                          $sql = "select opacidad,textura,altura from tblcabezotes_categorias where idcategoria={$idcategoria}";

                                                                                                                                                                                                                                          $rCategorias = mysqli_query($nConexion, $sql);
                                                                                                                                                                                                                                          $efectos = mysqli_fetch_assoc($rCategorias);

                                                                                                                                                                                                                                          $propiedades = array();
                                                                                                                                                                                                                                          foreach ($efectos as $k => $v) {
                                                                                                                                                                                                                                            $propiedades[$k] = preg_match("/^[0-9]*\.?,?[0-9]*$/", $v) ? $v * 1 : $v;
                                                                                                                                                                                                                                          }

                                                                                                                                                                                                                                          $sql = "select a.* from tblcabezotes a where a.idcategoria={$idcategoria} order by orden";

                                                                                                                                                                                                                                          $rsImagenes = mysqli_query($nConexion, $sql);

                                                                                                                                                                                                                                          if (mysqli_num_rows($rsImagenes) == 0) {
                                                                                                                                                                                                                                            return;
                                                                                                                                                                                                                                          }

                                                                                                                                                                                                                                          $opacitad = $propiedades["opacidad"];
                                                                                                                                                                                                                                          $textura = $propiedades["textura"];
                                                                                                                                                                                                                                          $altura = $propiedades["altura"];

                                                                                                                                                                                                                                          $html .= "
    <div class='slider'>
      <link href='$home/css/camera.css' rel='stylesheet' type='text/css' />
      <script type='text/javascript' src='$home/php/js/camera.min.js'></script>
    <script type='text/javascript' src='$home/php/js/jquery.easing.1.3.js'></script>
      <style>
                .{$textura} .camera_overlayer{
                    opacity:{$opacitad};
                }
            </style>
            <div class='camera_wrap camera_emboss {$textura}' id='camera_wrap_1'>";

                                                                                                                                                                                                                                          while ($rax = mysqli_fetch_assoc($rsImagenes)) {
                                                                                                                                                                                                                                            $html .= "	<div data-src='{$cRutaVerCabezotesjq}{$rax['archivo']}' data-link='{$rax['url']}' data-target='{$rax['target']}' data-thumb='{$cRutaVerCabezotesjq}{$rax['archivo']}'>";
                                                                                                                                                                                                                                            if (!empty($rax['descripcion'])) {
                                                                                                                                                                                                                                              $html .= "	<div class='ei-title fadeIn'>{$rax['descripcion']}</div>";
                                                                                                                                                                                                                                            }
                                                                                                                                                                                                                                            $html .= "	</div>";
                                                                                                                                                                                                                                          }
                                                                                                                                                                                                                                          $html .= "</div>";
                                                                                                                                                                                                                                          $html .= "
        <script type='text/javascript'>
            $(function() {
                $('#camera_wrap_1').camera({
          playPause: false,
          height: '$altura%',
          time: 4000,
          hover: false,
          minHeight: '100px'
          });
            });
        </script>
    </div>";

                                                                                                                                                                                                                                          return $html;
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function cabezoteSkitter($idcategoria, $idFT = "cabezote")
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          global $cRutaVerCabezotesjq;
                                                                                                                                                                                                                                          $html = '';
                                                                                                                                                                                                                                          $imgs = '';
                                                                                                                                                                                                                                          $nConexion = Conectar();

                                                                                                                                                                                                                                          $sql = "select width,height,intervalo,numbers,navigation,label,thumbs,dots,preview,controls,controls_position 
    from tblcabezotes_categorias where idcategoria={$idcategoria}";

                                                                                                                                                                                                                                          $rCategorias = mysqli_query($nConexion, $sql);
                                                                                                                                                                                                                                          $efectos = mysqli_fetch_assoc($rCategorias);

                                                                                                                                                                                                                                          $propiedades = array();
                                                                                                                                                                                                                                          foreach ($efectos as $k => $v) {
                                                                                                                                                                                                                                            $propiedades[$k] = preg_match("/^[0-9]*\.?,?[0-9]*$/", $v) ? $v * 1 : $v;
                                                                                                                                                                                                                                          }

                                                                                                                                                                                                                                          $sql = "select a.* from tblcabezotes a where a.idcategoria={$idcategoria} order by rand()";

                                                                                                                                                                                                                                          $rsImagenes = mysqli_query($nConexion, $sql);

                                                                                                                                                                                                                                          $width = $propiedades["width"];
                                                                                                                                                                                                                                          $height = $propiedades["height"];

                                                                                                                                                                                                                                          $html .= "<div class=\"{$idFT} box_skitter\" style=\"width:{$width}px; height:{$height}px;\">";
                                                                                                                                                                                                                                          $html .= "	<ul>";

                                                                                                                                                                                                                                          while ($rax = mysqli_fetch_assoc($rsImagenes)) {
                                                                                                                                                                                                                                            $html .= "		<li>";
                                                                                                                                                                                                                                            $html .= "		<a href=\"{$rax['url']}\" target=\"{$rax['target']}\"><img src=\"{$cRutaVerCabezotesjq}{$rax['archivo']}\" class=\"{$rax['efecto']}\" /></a>";
                                                                                                                                                                                                                                            $html .= "		<div class=\"label_text\">";
                                                                                                                                                                                                                                            $html .= "		<p>{$rax['descripcion']}</p>";
                                                                                                                                                                                                                                            $html .= "		</div>";
                                                                                                                                                                                                                                            $html .= "		</li>";
                                                                                                                                                                                                                                          }
                                                                                                                                                                                                                                          $html .= "	</ul>";
                                                                                                                                                                                                                                          $html .= "</div>";
                                                                                                                                                                                                                                          $html .= "<div id=\"orlas\">";
                                                                                                                                                                                                                                          $html .= "</div>";

                                                                                                                                                                                                                                          $html .= "	<script>
  $(document).ready(function() {
    $('.{$idFT}').skitter({
      interval: {$propiedades['intervalo']},
      navigation: {$propiedades['navigation']},
      label: {$propiedades['label']},
      thumbs: {$propiedades['thumbs']},
      dots: {$propiedades['dots']}, 
       preview: {$propiedades['preview']},
      controls: {$propiedades['controls']},
      controls_position: \"{$propiedades['controls_position']}\", 
       numbers_align: \"{$propiedades['numbers']}\"
    });
  });
</script>
";

                                                                                                                                                                                                                                          return $html;
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function cintaTransportadora($idcategoria)
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          global $cRutaVerImgCinta;
                                                                                                                                                                                                                                          $nConexion = Conectar();

                                                                                                                                                                                                                                          $sql = "select a.* from tblimagenes_cinta a where a.idcategoria={$idcategoria} order by rand()";

                                                                                                                                                                                                                                          $rsImagenes = mysqli_query($nConexion, $sql);

                                                                                                                                                                                                                                          $html = "";

                                                                                                                                                                                                                                          while ($rax = mysqli_fetch_assoc($rsImagenes)) {
                                                                                                                                                                                                                                            $html .= "<div class='product-category hover-squared'><a href='{$rax['url']}'><img src='{$cRutaVerImgCinta}{$rax['archivo']}' data-lazy='{$cRutaVerImgCinta}{$rax['archivo']}' alt='Cliente'></a></div>";
                                                                                                                                                                                                                                          };

                                                                                                                                                                                                                                          return $html;
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function fondos($idcategoria, $nombre)
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          global $cRutaVerImgFondos;
                                                                                                                                                                                                                                          $nConexion = Conectar();

                                                                                                                                                                                                                                          $sql = "select height,velocidad,transicion 
    from tblfondos_categorias where idcategoria={$idcategoria}";

                                                                                                                                                                                                                                          $rCategorias = mysqli_query($nConexion, $sql);
                                                                                                                                                                                                                                          $propiedades = mysqli_fetch_assoc($rCategorias);

                                                                                                                                                                                                                                          $sql = "select a.* from tblimagenes_fondo a where a.idcategoria={$idcategoria} order by rand()";

                                                                                                                                                                                                                                          $rsImagenes = mysqli_query($nConexion, $sql);

                                                                                                                                                                                                                                          $html .= "
      <script type=\"text/javascript\">
                    jQuery(document).ready(function(){
                        jQuery('#{$nombre}').skdslider({'delay':{$propiedades['velocidad']}, 'fadeSpeed': {$propiedades['transicion']},'showNextPrev':false,'showPlayButton':false,'autoStart':true, 'showNav':false,});
                    });
            </script>
            <div id='{$nombre}' class='skdslider' data-500='margin-top: 0px;' data-1400='margin-top: -100px;'>
                <ul>";

                                                                                                                                                                                                                                          while ($rax = mysqli_fetch_assoc($rsImagenes)) {
                                                                                                                                                                                                                                            $html .= "<li><img src=\"{$cRutaVerImgFondos}{$rax['imagen']}\"/></li>";
                                                                                                                                                                                                                                          }

                                                                                                                                                                                                                                          $html .= "
                </ul>
            </div>";

                                                                                                                                                                                                                                          return $html;
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function pantallaLed($idcategoria)
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          $nConexion = Conectar();

                                                                                                                                                                                                                                          $sql = "select width,height,velocidad 
    from tblpantalla_led where idcategoria={$idcategoria}";

                                                                                                                                                                                                                                          $rCategorias = mysqli_query($nConexion, $sql);
                                                                                                                                                                                                                                          $propiedades = mysqli_fetch_assoc($rCategorias);

                                                                                                                                                                                                                                          $sql = "select * from tbltexto_pantalla a where idcategoria={$idcategoria} order by rand()";

                                                                                                                                                                                                                                          $rsTexto = mysqli_query($nConexion, $sql);

                                                                                                                                                                                                                                          $html .= "
<script type=\"text/javascript\">

/***********************************************
* Conveyor belt slideshow script- © Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
***********************************************/


//Specify the slider's width (in pixels)
var sliderwidth=\"{$propiedades['width']}px\"
//Specify the slider's height
var sliderheight=\"{$propiedades['height']}px\"
//Specify the slider's slide speed (larger is faster 1-10)
var slidespeed={$propiedades['velocidad']}
//configure background color:
slidebgcolor=\"\"

//Specify the slider's images
var leftrightslide=new Array(";

                                                                                                                                                                                                                                          while ($rax = mysqli_fetch_assoc($rsTexto)) {
                                                                                                                                                                                                                                            $html .= "'{$rax['texto']}',";
                                                                                                                                                                                                                                          }
                                                                                                                                                                                                                                          $html .= "''
)
var finalslide=''

//Specify gap between each image (use HTML):
var imagegap=\"&nbsp;&nbsp;&nbsp;\"

//Specify pixels gap between each slideshow rotation (use integer):
var slideshowgap=60


////NO NEED TO EDIT BELOW THIS LINE////////////

var copyspeed=slidespeed
leftrightslide='<nobr>'+leftrightslide.join(imagegap)+'</nobr>'
var iedom=document.all||document.getElementById
if (iedom)
document.write('<span id=\"temp\" style=\"visibility:hidden;position:absolute;top:-100px;left:-9000px\">'+leftrightslide+'</span>')
var actualwidth=''
var cross_slide, ns_slide

function fillup(){
if (iedom){
cross_slide=document.getElementById? document.getElementById(\"test2\") : document.all.test2
cross_slide2=document.getElementById? document.getElementById(\"test3\") : document.all.test3
cross_slide.innerHTML=cross_slide2.innerHTML=leftrightslide
actualwidth=document.all? cross_slide.offsetWidth : document.getElementById(\"temp\").offsetWidth
cross_slide2.style.left=actualwidth+slideshowgap+\"px\"
}
else if (document.layers){
ns_slide=document.ns_slidemenu.document.ns_slidemenu2
ns_slide2=document.ns_slidemenu.document.ns_slidemenu3
ns_slide.document.write(leftrightslide)
ns_slide.document.close()
actualwidth=ns_slide.document.width
ns_slide2.left=actualwidth+slideshowgap
ns_slide2.document.write(leftrightslide)
ns_slide2.document.close()
}
lefttime=setInterval(\"slideleft()\",30)
}
window.onload=fillup

function slideleft(){
if (iedom){
if (parseInt(cross_slide.style.left)>(actualwidth*(-1)+8))
cross_slide.style.left=parseInt(cross_slide.style.left)-copyspeed+\"px\"
else
cross_slide.style.left=parseInt(cross_slide2.style.left)+actualwidth+slideshowgap+\"px\"

if (parseInt(cross_slide2.style.left)>(actualwidth*(-1)+8))
cross_slide2.style.left=parseInt(cross_slide2.style.left)-copyspeed+\"px\"
else
cross_slide2.style.left=parseInt(cross_slide.style.left)+actualwidth+slideshowgap+\"px\"

}
else if (document.layers){
if (ns_slide.left>(actualwidth*(-1)+8))
ns_slide.left-=copyspeed
else
ns_slide.left=ns_slide2.left+actualwidth+slideshowgap

if (ns_slide2.left>(actualwidth*(-1)+8))
ns_slide2.left-=copyspeed
else
ns_slide2.left=ns_slide.left+actualwidth+slideshowgap
}
}


if (iedom||document.layers){
with (document){
if (iedom){
write('<div style=\"position:relative;margin: 0 auto;width:'+sliderwidth+';height:'+sliderheight+';overflow:hidden\">')
write('<div style=\"position:absolute;width:'+sliderwidth+';height:'+sliderheight+';background-color:'+slidebgcolor+'\" onMouseover=\"copyspeed=0\" onMouseout=\"copyspeed=slidespeed\">')
write('<div id=\"test2\" style=\"position:absolute;left:0px;top:0px\"></div>')
write('<div id=\"test3\" style=\"position:absolute;left:-1000px;top:0px\"></div>')
write('</div></div>')
}
else if (document.layers){
write('<ilayer width='+sliderwidth+' height='+sliderheight+' name=\"ns_slidemenu\" bgColor='+slidebgcolor+'>')
write('<layer name=\"ns_slidemenu2\" left=0 top=0 onMouseover=\"copyspeed=0\" onMouseout=\"copyspeed=slidespeed\"></layer>')
write('<layer name=\"ns_slidemenu3\" left=0 top=0 onMouseover=\"copyspeed=0\" onMouseout=\"copyspeed=slidespeed\"></layer>')
write('</ilayer>')
}
}
}
</script>
";

                                                                                                                                                                                                                                          return $html;
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function bannerAnimado($idcategoria, $nombre)
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          global $cRutaImgCabezotesjq;
                                                                                                                                                                                                                                          $html = '';
                                                                                                                                                                                                                                          $nConexion = Conectar();


                                                                                                                                                                                                                                          // Inicio banner nuevo
                                                                                                                                                                                                                                          $sql = "select height,velocidad,transicion 
    from tblbanners_categorias where idcategoria={$idcategoria}";

                                                                                                                                                                                                                                          $rCategorias = mysqli_query($nConexion, $sql);
                                                                                                                                                                                                                                          $propiedades = mysqli_fetch_assoc($rCategorias);

                                                                                                                                                                                                                                          $sql = "select a.* from tblimagenes_banners a where a.idcategoria={$idcategoria} order by rand()";

                                                                                                                                                                                                                                          $rsImagenes = mysqli_query($nConexion, $sql);

                                                                                                                                                                                                                                          $html .= "
      <script type=\"text/javascript\">
                    jQuery(document).ready(function(){
                        jQuery('#{$nombre}').skdslider({'delay':{$propiedades['velocidad']}, 'fadeSpeed': {$propiedades['transicion']},'showNextPrev':false,'showPlayButton':false,'autoStart':true, 'showNav':false,});
                    });
            </script>
      <style type=\"text/css\">
        #{$nombre}, #{$nombre} ul.slides li{
          height: {$propiedades['height']}px;
        }
        #{$nombre}{
          position: relative;
        }
      </style>
            <div id=\"{$nombre}\" class=\"skdslider\">
                <ul>";

                                                                                                                                                                                                                                          while ($rax = mysqli_fetch_assoc($rsImagenes)) {
                                                                                                                                                                                                                                            $html .= "<li><a href='vercabezote.php?id={$rax['idbanner']}&ciudad={$IdCiudad}' target=\"{$rax['target']}\"><img src=\"{$cRutaImgCabezotesjq}{$rax['imagen']}\"/></a></li>";
                                                                                                                                                                                                                                          }

                                                                                                                                                                                                                                          $html .= "
                </ul>
            </div>";

                                                                                                                                                                                                                                          return $html;
                                                                                                                                                                                                                                        }


                                                                                                                                                                                                                                        function fbMegusta($url, $width = 500, $font = "arial")
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          /*$src="<script src=\"http://connect.facebook.net/es_LA/all.js#xfbml=1\"></script>";
    $src.="<fb:like href=\"{$url}\" show_faces=\"false\" width=\"{$width}\" font=\"{$font}\"></fb:like>";*/

                                                                                                                                                                                                                                          $src = "<script src=\"http://connect.facebook.net/es_LA/all.js#xfbml=1\"></script><fb:like href=\"{$url}\" show_faces=\"true\" min-width=\"{$width}\" font=\"{$font}\"></fb:like>";

                                                                                                                                                                                                                                          return $src;
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function fbComentarios($url, $width = 500, $posts = "4")
                                                                                                                                                                                                                                        {
?>
  <div id="fb-root">&nbsp;</div>
  <script src="http://connect.facebook.net/es_LA/all.js#xfbml=1"></script>
  <fb:comments href="<?php echo $url; ?>" width="<?php echo $width; ?>" num_posts="<?php echo $posts; ?>"></fb:comments>
<?php
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function usuariosMuroDatosPersonales($d, $f)
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          $fields_mostrar = array(
                                                                                                                                                                                                                                            "mostrar_nombre" => "Nombre", "mostrar_apellido" => "Apellido", "mostrar_cumpleano" => "Cumpleaños",
                                                                                                                                                                                                                                            "mostrar_fecha_nacimiento" => "Fecha nacimiento", "mostrar_barrio" => "Barrio", "mostrar_telefono" => "Teléfono", "mostrar_celular" => "Celular",
                                                                                                                                                                                                                                            "mostrar_correo_electronico" => "Correo electrónico", "mostrar_correo_electronico_auxiliar" => "Correo electrónico auxiliar",
                                                                                                                                                                                                                                            "mostrar_sitio_web" => "Sitio web", "mostrar_ciudad" => "Ciudad", "mostrar_pais" => "País", "mostrar_twitter" => "Twitter", "mostrar_pin_bb" => "Pin BB",
                                                                                                                                                                                                                                            "mostrar_facebook" => "Facebook", "mostrar_profesion" => "Profesión",
                                                                                                                                                                                                                                            "mostrar_gustos" => "Gustos", "mostrar_foto" => "Foto"
                                                                                                                                                                                                                                          );

                                                                                                                                                                                                                                          if ($d["clave"] != $d["clave2"]) {
                                                                                                                                                                                                                                            return "Error, claves no son iguales";
                                                                                                                                                                                                                                          }

                                                                                                                                                                                                                                          $nConexion = Conectar();
                                                                                                                                                                                                                                          //die(print_r($d,1));
                                                                                                                                                                                                                                          //die(print_r($f,1));
                                                                                                                                                                                                                                          if (isset($f["foto"])) {
                                                                                                                                                                                                                                            $upload_dir = "../fotos/perfiles/";
                                                                                                                                                                                                                                            $name = $_SESSION["usuario"]["idusuario"];
                                                                                                                                                                                                                                            if ($f["foto"]["error"] == UPLOAD_ERR_OK) {
                                                                                                                                                                                                                                              if (!move_uploaded_file($f["foto"]["tmp_name"], $upload_dir . $name)) {
                                                                                                                                                                                                                                                die("Fallo cargando archivo al servidor");
                                                                                                                                                                                                                                              }
                                                                                                                                                                                                                                            }
                                                                                                                                                                                                                                          }    //die($sql);

                                                                                                                                                                                                                                          $sql = "update tblusuarios_externos set correo_electronico=correo_electronico";
                                                                                                                                                                                                                                          foreach ($fields_mostrar as $k => $v) {
                                                                                                                                                                                                                                            $sql .= ",{$k}=0";
                                                                                                                                                                                                                                          }
                                                                                                                                                                                                                                          $sql .= " WHERE correo_electronico='{$_SESSION["usuario"]["correo_electronico"]}'";


                                                                                                                                                                                                                                          $ra = mysqli_query($nConexion, $sql);
                                                                                                                                                                                                                                          if (!$ra) {
                                                                                                                                                                                                                                            return "Fallo actualizando información muro usuario";
                                                                                                                                                                                                                                          }

                                                                                                                                                                                                                                          $clave = "";
                                                                                                                                                                                                                                          if ($d["clave"] != "")
                                                                                                                                                                                                                                            $clave = hash("sha256", $d["clave"]);

                                                                                                                                                                                                                                          $clave = $clave == "" ? "" : "clave='{$clave}',";

                                                                                                                                                                                                                                          $sql = "UPDATE tblusuarios_externos SET {$clave} 
            nombre='{$d["nombre"]}',
            apellido='{$d["apellido"]}',
            cedula='{$d["cedula"]}',
            fecha_nacimiento='{$d["fecha_nacimiento"]}',
            correo_electronico='{$d["correo"]}',
            correo_electronico_auxiliar='{$d["correo_electronico_auxiliar"]}',
            barrio='{$d["barrio"]}',
            telefono='{$d["telefono"]}',
            celular='{$d["celular"]}',
            ciudad='{$d["ciudad"]}',
            pais='{$d["pais"]}',
            sitio_web='{$d["sitio_web"]}',
            twitter='{$d["twitter"]}',
            pin_bb='{$d["pin_bb"]}',
            facebook='{$d["facebook"]}',
            profesion='{$d["profesion"]}',
            gustos='{$d["gustos"]}'
            ";

                                                                                                                                                                                                                                          foreach ($d as $k => $v) {
                                                                                                                                                                                                                                            if (strpos($k, "mostrar") !== false) {
                                                                                                                                                                                                                                              $sql .= ",{$k}=1";
                                                                                                                                                                                                                                            }
                                                                                                                                                                                                                                          }

                                                                                                                                                                                                                                          $sql .= " WHERE correo_electronico='{$_SESSION["usuario"]["correo_electronico"]}'";

                                                                                                                                                                                                                                          $ra = mysqli_query($nConexion, $sql);
                                                                                                                                                                                                                                          if (!$ra) {
                                                                                                                                                                                                                                            return "Fallo actualizando información muro usuario";
                                                                                                                                                                                                                                          }


                                                                                                                                                                                                                                          if ($d["clave"] != "") {
                                                                                                                                                                                                                                            //$clave = hash("sha256",$d["clave"]);
                                                                                                                                                                                                                                            $estado = usuariosAutenticar($d["correo"], $d["clave"]);
                                                                                                                                                                                                                                          } else {
                                                                                                                                                                                                                                            $estado = actualizarDatosSesion($d["correo"]);
                                                                                                                                                                                                                                          }


                                                                                                                                                                                                                                          if ($estado == false) {
                                                                                                                                                                                                                                            die("Usuario o clave invalidos");
                                                                                                                                                                                                                                          }

                                                                                                                                                                                                                                          return true;
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function actualizarDatosSesion($correo)
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          if (trim($correo) == "") {
                                                                                                                                                                                                                                            return false;
                                                                                                                                                                                                                                          }
                                                                                                                                                                                                                                          $nConexion = Conectar();
                                                                                                                                                                                                                                          $sql = "select 
    a.*,
    DATE_FORMAT(a.fecha_nacimiento,'%b %d') as cumpleano,
    b.idsede as tickets_idsede,
    b.tipo as tickets_tipo,
    b.attr_tipo as tickets_attr_tipo,
    d.idzona as tickets_idzona,
    e.idregion as tickets_idregion,
    f.idempresa as tickets_idempresa
    
    from tblusuarios_externos a
    left join tbltk_sedes_usuarios b on (a.idusuario=b.idusuario)
    left join tbltk_sedes c on (b.idsede=c.idsede)
    left join tbltk_zonas d on (c.idzona=d.idzona)
    left join tbltk_regiones e on (d.idregion=e.idregion)
    left join tbltk_empresas f on (e.idempresa=f.idempresa)
    
    where a.correo_electronico='{$correo}' and a.activo=1";


                                                                                                                                                                                                                                          $ra = mysqli_query($nConexion, $sql);

                                                                                                                                                                                                                                          if (!$ra) {
                                                                                                                                                                                                                                            die("Fallo consultando usuario");
                                                                                                                                                                                                                                          }
                                                                                                                                                                                                                                          $rax = mysqli_fetch_assoc($ra);

                                                                                                                                                                                                                                          unset($rax["clave"]);

                                                                                                                                                                                                                                          $_SESSION["usuario"] = $rax;
                                                                                                                                                                                                                                          return true;
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function registrarInscripcionCorreoBoletin($p)
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          $result = captchaValida($p, "BOLETIN");
                                                                                                                                                                                                                                          if ($result !== true) {
                                                                                                                                                                                                                                            Mensaje($result, "home.php?ciudad={$p["idciudad"]}"); //." get ".print_r($_GET,1)." session ".print_r($_SESSION,1));
                                                                                                                                                                                                                                          }

                                                                                                                                                                                                                                          if (!isset($p["nombre"]) || $p["nombre"] == "") {
                                                                                                                                                                                                                                            Mensaje("Error, no se ingreso nombre", "home.php?ciudad={$p["idciudad"]}");
                                                                                                                                                                                                                                          }

                                                                                                                                                                                                                                          if (!isset($p["correo"]) || $p["correo"] == "") {
                                                                                                                                                                                                                                            Mensaje("Error, no se ingreso correo", "home.php?ciudad={$p["idciudad"]}");
                                                                                                                                                                                                                                          }

                                                                                                                                                                                                                                          $nConexion = Conectar();
                                                                                                                                                                                                                                          $sql = "SELECT * FROM tblboletinescorreos WHERE correo='{$p["idciudad"]}'";

                                                                                                                                                                                                                                          $ra = mysqli_query($nConexion, $sql);

                                                                                                                                                                                                                                          if (mysqli_num_rows($ra) == 0) {
                                                                                                                                                                                                                                            $sql = "INSERT INTO tblboletinescorreos(correo,nombre,idlista) VALUES('{$p["correo"]}','{$p["nombre"]}',1)";
                                                                                                                                                                                                                                            $ra = mysqli_query($nConexion, $sql);
                                                                                                                                                                                                                                            if (!$ra) {
                                                                                                                                                                                                                                              Mensaje("Error registrando correo", "home.php?ciudad={$p["idciudad"]}");
                                                                                                                                                                                                                                            }
                                                                                                                                                                                                                                          } else {
                                                                                                                                                                                                                                            Mensaje("El correo fue registrado anteriormente", "home.php?ciudad={$p["idciudad"]}");
                                                                                                                                                                                                                                          }

                                                                                                                                                                                                                                          header("Location: home.php?ciudad={$p["idciudad"]}");
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function usuarioInformacionMuro($idusuario)
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          if (trim($idusuario) == "") {
                                                                                                                                                                                                                                            return false;
                                                                                                                                                                                                                                          }
                                                                                                                                                                                                                                          $nConexion = Conectar();
                                                                                                                                                                                                                                          $sql = "select *,DATE_FORMAT(fecha_nacimiento,'%b %d') as cumpleano from tblusuarios_externos where idusuario={$idusuario}";
                                                                                                                                                                                                                                          $ra = mysqli_query($nConexion, $sql);

                                                                                                                                                                                                                                          if (!$ra) {
                                                                                                                                                                                                                                            die("Fallo consultando usuario");
                                                                                                                                                                                                                                          }
                                                                                                                                                                                                                                          $rax = mysqli_fetch_assoc($ra);
                                                                                                                                                                                                                                          return $rax;
                                                                                                                                                                                                                                        }


                                                                                                                                                                                                                                        function usuarioDatosPublicosMuro($idusuario)
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          $html = "";
                                                                                                                                                                                                                                          $fields_mostrar = array(
                                                                                                                                                                                                                                            "mostrar_nombre" => "Nombre", "mostrar_apellido" => "Apellido", "mostrar_cumpleano" => "Cumpleaños",
                                                                                                                                                                                                                                            "mostrar_fecha_nacimiento" => "Fecha nacimiento", "mostrar_barrio" => "Barrio", "mostrar_telefono" => "Teléfono",
                                                                                                                                                                                                                                            "mostrar_celular" => "Celular", "mostrar_correo_electronico" => "Correo electrónico",
                                                                                                                                                                                                                                            "mostrar_correo_electronico_auxiliar" => "Correo electrónico auxiliar", "mostrar_sitio_web" => "Sitio web",
                                                                                                                                                                                                                                            "mostrar_ciudad" => "Ciudad", "mostrar_pais" => "País", "mostrar_twitter" => "Twitter", "mostrar_pin_bb" => "Pin BB",
                                                                                                                                                                                                                                            "mostrar_facebook" => "Facebook", "mostrar_profesion" => "Profesión",
                                                                                                                                                                                                                                            "mostrar_gustos" => "Gustos", "mostrar_foto" => "Foto"
                                                                                                                                                                                                                                          );

                                                                                                                                                                                                                                          $usuario_info = usuarioInformacionMuro($idusuario);
                                                                                                                                                                                                                                          foreach ($fields_mostrar as $k => $v) {
                                                                                                                                                                                                                                            if ($v == "Foto") continue;

                                                                                                                                                                                                                                            if ($usuario_info[$k]) {
                                                                                                                                                                                                                                              $html .= "<span class=\"tablaLogueoMuroTitulosNegrita\">{$v}: </span>{$usuario_info[str_replace("mostrar_", "",$k)]}<br/>";
                                                                                                                                                                                                                                            }
                                                                                                                                                                                                                                          }
                                                                                                                                                                                                                                          return $html;
                                                                                                                                                                                                                                        }



                                                                                                                                                                                                                                        function comentarMuro($modulo, $item, $usuario, $comentario)
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          require_once("../admin/herramientas/XPM4-v.0.4/MAIL.php");
                                                                                                                                                                                                                                          $nConexion = Conectar();
                                                                                                                                                                                                                                          $sql = "insert into tblcomentarios (modulo,iditem,usuario,nombre,correo_electronico,comentario) 
    values ('{$modulo}',{$item},'{$usuario}','','','{$comentario}')";

                                                                                                                                                                                                                                          $ra = mysqli_query($nConexion, $sql);
                                                                                                                                                                                                                                          if (!$ra) {
                                                                                                                                                                                                                                            return "Fallo almacenando comentario";
                                                                                                                                                                                                                                          }

                                                                                                                                                                                                                                          if ($modulo == "COMENTARIO") {
                                                                                                                                                                                                                                            $sql = "select * from tblusuarios_externos where idusuario=(select iditem from tblcomentarios where idcomentario={$item})";
                                                                                                                                                                                                                                          } else {
                                                                                                                                                                                                                                            $sql = "select * from tblusuarios_externos where idusuario={$item}";
                                                                                                                                                                                                                                          }

                                                                                                                                                                                                                                          $ra = mysqli_query($nConexion, $sql);

                                                                                                                                                                                                                                          if (!$ra) {
                                                                                                                                                                                                                                            die("Error, {$sql}");
                                                                                                                                                                                                                                          }

                                                                                                                                                                                                                                          $usuarioInfo = mysqli_fetch_assoc($ra);

                                                                                                                                                                                                                                          $rMails = array();
                                                                                                                                                                                                                                          if ($modulo ==  "COMENTARIO") {
                                                                                                                                                                                                                                            $sql = "select distinct * from tblusuarios_externos where 
            (idusuario in (select usuario from tblcomentarios where iditem={$item}) or 
            idusuario=(select usuario from tblcomentarios where idcomentario={$item}))";

                                                                                                                                                                                                                                            $ra = mysqli_query($nConexion, $sql);

                                                                                                                                                                                                                                            if (!$ra) {
                                                                                                                                                                                                                                              die("Error, {$sql}");
                                                                                                                                                                                                                                            }

                                                                                                                                                                                                                                            while ($rax = mysqli_fetch_assoc($ra)) {
                                                                                                                                                                                                                                              $rMails[] = $rax;
                                                                                                                                                                                                                                            }
                                                                                                                                                                                                                                          } else {
                                                                                                                                                                                                                                            $rMails[] = array("correo_electronico" => $usuarioInfo["correo_electronico"], "nombre" => $usuarioInfo["nombre"]);
                                                                                                                                                                                                                                          }


                                                                                                                                                                                                                                          $sql = "select * from tblusuarios_externos where idusuario={$usuario}";
                                                                                                                                                                                                                                          $ra = mysqli_query($nConexion, $sql);
                                                                                                                                                                                                                                          $usuarioComenta = mysqli_fetch_assoc($ra);


                                                                                                                                                                                                                                          //if ( $usuarioInfo["usuario"] != $_SESSION["usuario"]["usuario"] ) {

                                                                                                                                                                                                                                          $m = new MAIL();
                                                                                                                                                                                                                                          $host = str_replace("www.", "", $_SERVER["HTTP_HOST"]);

                                                                                                                                                                                                                                          $m->addHeader("charset", "utf-8");
                                                                                                                                                                                                                                          $m->from("soporte@{$host}", "{$host}");
                                                                                                                                                                                                                                          $m->addto("soporte@auditoriavisual.com", "{$_SESSION["usuario"]["nombre"]}");
                                                                                                                                                                                                                                          foreach ($rMails as $r) {
                                                                                                                                                                                                                                            $m->addto($r["correo_electronico"], $r["nombre"]);
                                                                                                                                                                                                                                          }

                                                                                                                                                                                                                                          $m->subject(utf8_encode("{$usuarioComenta["nombre"]} comentó en tu muro."));

                                                                                                                                                                                                                                          $req = explode("?", $_SERVER["REQUEST_URI"]);

                                                                                                                                                                                                                                          //die(print_r($req,1));

                                                                                                                                                                                                                                          $url = "{$_SERVER["HTTP_HOST"]}{$req[0]}?ciudad=1&idusuario={$usuarioInfo["idusuario"]}";


                                                                                                                                                                                                                                          $html = "<html><head><title>Muro {$usuarioInfo["nombre"]} Auditoria Visual</title></head>
        <body>{$usuarioComenta["nombre"]} comentó en tu muro.<br/><br/>
        {$usuarioComenta["nombre"]} escribió: \"{$comentario}\"<br/><br/>
        <a href=\"{$url}\">Ver comentario</a>
        <br/>
        </body></html>";



                                                                                                                                                                                                                                          $m->html($html);

                                                                                                                                                                                                                                          $cHost = $host;
                                                                                                                                                                                                                                          $cPort = 25;
                                                                                                                                                                                                                                          $cUser = "soporte@auditoriavisual.com";
                                                                                                                                                                                                                                          $cPass = "viauvi11";

                                                                                                                                                                                                                                          $c = $m->Connect($cHost, $cPort, $cUser, $cPass);
                                                                                                                                                                                                                                          $status = $m->send($c);

                                                                                                                                                                                                                                          if (!$status) {
                                                                                                                                                                                                                                            die("Error enviando mensaje");
                                                                                                                                                                                                                                          }
                                                                                                                                                                                                                                          //}
                                                                                                                                                                                                                                          return true;
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function borrarComentarioMuro($idcomentario)
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          $nConexion = Conectar();
                                                                                                                                                                                                                                          $sql = "select * from tblcomentarios 
            where idcomentario={$idcomentario} and 
            (usuario='{$_SESSION["usuario"]["idusuario"]}' or iditem='{$_SESSION["usuario"]["idusuario"]}')";

                                                                                                                                                                                                                                          $ra = mysqli_query($nConexion, $sql);

                                                                                                                                                                                                                                          $r = mysqli_fetch_array($ra);


                                                                                                                                                                                                                                          if ($r["idcomentario"] != "") {
                                                                                                                                                                                                                                            $sql = "delete from tblcomentarios 
                where idcomentario={$idcomentario} and 
                (usuario='{$_SESSION["usuario"]["idusuario"]}' or iditem='{$_SESSION["usuario"]["idusuario"]}')";

                                                                                                                                                                                                                                            $ra = mysqli_query($nConexion, $sql);

                                                                                                                                                                                                                                            if (!$ra) {
                                                                                                                                                                                                                                              return false;
                                                                                                                                                                                                                                            }

                                                                                                                                                                                                                                            $p = $r["iditem"] != "" ? $r["iditem"] : "''";
                                                                                                                                                                                                                                            $sql = "delete from tblcomentarios where iditem={$idcomentario}";

                                                                                                                                                                                                                                            $ra = mysqli_query($nConexion, $sql);

                                                                                                                                                                                                                                            if (!$ra) {
                                                                                                                                                                                                                                              return false;
                                                                                                                                                                                                                                            }
                                                                                                                                                                                                                                          } else {
                                                                                                                                                                                                                                            $sql = "select * from tblcomentarios where idcomentario={$idcomentario} and usuario='{$_SESSION["usuario"]["idusuario"]}'";

                                                                                                                                                                                                                                            $ra = mysqli_query($nConexion, $sql);

                                                                                                                                                                                                                                            $r1 = mysqli_fetch_array($ra);

                                                                                                                                                                                                                                            if ($r1["iditem"] != "") {
                                                                                                                                                                                                                                              $sql = "delete from tblcomentarios where idcomentario={$idcomentario} and usuario='{$_SESSION["usuario"]["idusuario"]}'";
                                                                                                                                                                                                                                              $ra = mysqli_query($nConexion, $sql);
                                                                                                                                                                                                                                              if (!$ra) {
                                                                                                                                                                                                                                                return false;
                                                                                                                                                                                                                                              }
                                                                                                                                                                                                                                            } else {
                                                                                                                                                                                                                                              $sql = "select * from tblcomentarios where idcomentario={$idcomentario}";
                                                                                                                                                                                                                                              $ra = mysqli_query($nConexion, $sql);

                                                                                                                                                                                                                                              $r3 = mysqli_fetch_array($ra);

                                                                                                                                                                                                                                              if ($r3["iditem"] != "") {
                                                                                                                                                                                                                                                $sql = "select * from tblcomentarios where idcomentario={$r3["iditem"]} and usuario='{$_SESSION["usuario"]["idusuario"]}'";

                                                                                                                                                                                                                                                $ra = mysqli_query($nConexion, $sql);

                                                                                                                                                                                                                                                $r2 = mysqli_fetch_array($ra);
                                                                                                                                                                                                                                                if ($r2["idcomentario"] != "") {
                                                                                                                                                                                                                                                  $sql = "delete from tblcomentarios where idcomentario={$idcomentario}";
                                                                                                                                                                                                                                                  $ra = mysqli_query($nConexion, $sql);
                                                                                                                                                                                                                                                  if (!$ra) {
                                                                                                                                                                                                                                                    return false;
                                                                                                                                                                                                                                                  }
                                                                                                                                                                                                                                                }
                                                                                                                                                                                                                                              }
                                                                                                                                                                                                                                            }
                                                                                                                                                                                                                                          }


                                                                                                                                                                                                                                          return true;
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function comentariosAntiguos($modulo, $item, $idusuario, $IdCiudad)
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          $param = $idusuario != "" ? "&idusuario={$idusuario}" : "";
                                                                                                                                                                                                                                          $nConexion = Conectar();
                                                                                                                                                                                                                                          $sql = "select *,fechahora as tiempo from tblcomentarios where modulo='{$modulo}' and iditem={$item} order by fechahora desc";
                                                                                                                                                                                                                                          $ra = mysqli_query($nConexion, $sql);
                                                                                                                                                                                                                                          $html = "";
                                                                                                                                                                                                                                          while ($rax = mysqli_fetch_array($ra)) {

                                                                                                                                                                                                                                            $ru = usuarioInformacionMuro($rax["usuario"]);
                                                                                                                                                                                                                                            $html .= "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
                                                                                                                                                                                                                                            $html .= "<tr>";
                                                                                                                                                                                                                                            $html .= "<td class=\"tablaLogueoMuroFotoContenido\">";
                                                                                                                                                                                                                                            if (file_exists("../fotos/perfiles/{$ru["idusuario"]}")) {
                                                                                                                                                                                                                                              $html .= "<img src=\"../fotos/perfiles/{$ru["idusuario"]}\" width=\"53\" height=\"35px\"/>";
                                                                                                                                                                                                                                            } else {
                                                                                                                                                                                                                                              $html .= "<img src=\"../fotos/perfiles/0\" width=\"53\" height=\"35px\"/>";
                                                                                                                                                                                                                                            }
                                                                                                                                                                                                                                            $html .= "</td>";
                                                                                                                                                                                                                                            $html .= "<td class=\"tablaLogueoMuroContenido\">";
                                                                                                                                                                                                                                            $html .= "<a href=\"logueoMuro.php?ciudad=1&idusuario={$ru["idusuario"]}\" class=\"deMasInfoMuro2\">{$ru["nombre"]} {$ru["apellido"]}</a>";
                                                                                                                                                                                                                                            $html .= "<br/>";
                                                                                                                                                                                                                                            $html .= "<span class=\"tablaLogueoMuroTitulosNegrita\">{$rax["tiempo"]}</span>";

                                                                                                                                                                                                                                            $flag_borrar = false;
                                                                                                                                                                                                                                            if ($rax["usuario"] == $_SESSION["usuario"]["idusuario"] || $item == $_SESSION["usuario"]["idusuario"]) {
                                                                                                                                                                                                                                              $html .= "| <a href=\"{$_SERVER["PHP_SELF"]}?ciudad={$IdCiudad}&action=borrarcomentario&idcomentario={$rax["idcomentario"]}{$param}\" class=\"deMasInfoMuro1\">Borrar Comentario</a>";
                                                                                                                                                                                                                                              $flag_borrar = true;
                                                                                                                                                                                                                                            }

                                                                                                                                                                                                                                            $html .= "<br/><br/>";
                                                                                                                                                                                                                                            $html .= "{$rax["comentario"]}";

                                                                                                                                                                                                                                            $sql = "select *,fechahora as tiempo from tblcomentarios where modulo='COMENTARIO' and iditem={$rax["idcomentario"]} order by fechahora ";


                                                                                                                                                                                                                                            $rcoments = mysqli_query($nConexion, $sql);

                                                                                                                                                                                                                                            $html .= "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
                                                                                                                                                                                                                                            $html .= "<tr>";
                                                                                                                                                                                                                                            $html .= "<td class=\"tablaLogueoMuroContenidoRespuesta\">";
                                                                                                                                                                                                                                            if (mysqli_num_rows($rcoments) > 0) {

                                                                                                                                                                                                                                              while ($rex = mysqli_fetch_array($rcoments)) {
                                                                                                                                                                                                                                                $ru2 = usuarioInformacionMuro($rex["usuario"]);
                                                                                                                                                                                                                                                $html .= "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
                                                                                                                                                                                                                                                $html .= "<tr>";
                                                                                                                                                                                                                                                $html .= "<td class=\"tablaLogueoMuroFotoContenido\">";
                                                                                                                                                                                                                                                if (file_exists("../fotos/perfiles/{$ru2["idusuario"]}")) {
                                                                                                                                                                                                                                                  $html .= "<img src=\"../fotos/perfiles/{$ru2["idusuario"]}\" width=\"53\" height=\"35px\"/>";
                                                                                                                                                                                                                                                } else {
                                                                                                                                                                                                                                                  $html .= "<img src=\"../fotos/perfiles/0\" width=\"53\" height=\"35px\"/>";
                                                                                                                                                                                                                                                }
                                                                                                                                                                                                                                                $html .= "</td>";
                                                                                                                                                                                                                                                $html .= "<td class=\"tablaLogueoMuroContenido\">";
                                                                                                                                                                                                                                                $html .= "<a href=\"logueoMuro.php?ciudad=1&idusuario={$ru2["idusuario"]}\" class=\"deMasInfoMuro2\">{$ru2["nombre"]} {$ru2["apellido"]}</a>";
                                                                                                                                                                                                                                                $html .= "<br/>";
                                                                                                                                                                                                                                                $html .= "<span class=\"tablaLogueoMuroTitulosNegrita\">{$rex["tiempo"]}</span>";

                                                                                                                                                                                                                                                if ($flag_borrar === true || $rex["usuario"] == $_SESSION["usuario"]["idusuario"]) {
                                                                                                                                                                                                                                                  $html .= "| <a href=\"{$_SERVER["PHP_SELF"]}?ciudad={$IdCiudad}&action=borrarcomentario&idcomentario={$rex["idcomentario"]}{$param}\" class=\"deMasInfoMuro1\">Borrar Comentario</a>";
                                                                                                                                                                                                                                                }

                                                                                                                                                                                                                                                $html .= "<br/><br/>";
                                                                                                                                                                                                                                                $html .= "{$rex["comentario"]}";
                                                                                                                                                                                                                                                $html .= "</td>";
                                                                                                                                                                                                                                                $html .= "</tr>";
                                                                                                                                                                                                                                                $html .= "</table>";
                                                                                                                                                                                                                                              }
                                                                                                                                                                                                                                            }

                                                                                                                                                                                                                                            $html .= "</td>";
                                                                                                                                                                                                                                            $html .= "</tr>";
                                                                                                                                                                                                                                            $html .= "<tr>";
                                                                                                                                                                                                                                            $html .= "<td class=\"tablaLogueoMuroContenidoRespuestaComentario\">";
                                                                                                                                                                                                                                            $html .= comentarMuroHtml("form_comentario_muro_{$rax["idcomentario"]}", "COMENTARIO", $rax["idcomentario"], $item, $IdCiudad);
                                                                                                                                                                                                                                            $html .= "</td>";
                                                                                                                                                                                                                                            $html .= "</tr>";
                                                                                                                                                                                                                                            $html .= "</table>";


                                                                                                                                                                                                                                            $html .= "</td>";
                                                                                                                                                                                                                                            $html .= "</tr>";
                                                                                                                                                                                                                                            $html .= "</table>";
                                                                                                                                                                                                                                            $html .= "<br/>";
                                                                                                                                                                                                                                          }
                                                                                                                                                                                                                                          return $html;
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function comentarMuroHtml($name_form, $modulo, $item, $idusuario, $IdCiudad)
                                                                                                                                                                                                                                        {

                                                                                                                                                                                                                                          $param = $idusuario != "" ? "&idusuario={$idusuario}" : "";
                                                                                                                                                                                                                                          $html = "";
                                                                                                                                                                                                                                          $html .= "<label>";
                                                                                                                                                                                                                                          $html .= "<form name=\"{$name_form}\" action=\"{$_SERVER["PHP_SELF"]}?ciudad={$IdCiudad}&action=comentar{$param}\" method=\"post\" id=\"{$name_form}\">";
                                                                                                                                                                                                                                          $html .= "<input type=\"hidden\" name=\"modulo\" value=\"{$modulo}\"/>";
                                                                                                                                                                                                                                          $html .= "<input type=\"hidden\" name=\"item\" value=\"{$item}\"/>";
                                                                                                                                                                                                                                          $html .= "<textarea name=\"comentario\" cols=\"60\" rows=\"1\" placeholder=\"Escriba en este muro\" onKeyPress=\"enviarComentario(event,this.parentNode);\"></textarea><br/>";
                                                                                                                                                                                                                                          $html .= "<input type=\"submit\" value=\"Comentar\"/>";
                                                                                                                                                                                                                                          $html .= "</form>";
                                                                                                                                                                                                                                          $html .= "</label>";
                                                                                                                                                                                                                                          return $html;
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function trmBanRep()
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          $url = "http://obiee.banrep.gov.co/analytics/saw.dll?Go&NQUser=publico&NQPassword=publico&Path=/shared/Consulta%20Series%20Estadisticas%20desde%20Excel/1.%20Tasa%20de%20Cambio%20Peso%20Colombiano/1.1%20TRM%20-%20Disponible%20desde%20el%2027%20de%20noviembre%20de%201991/TRM%20para%20un%20dia";
                                                                                                                                                                                                                                          @$content = file_get_contents($url);
                                                                                                                                                                                                                                          if (!$content) {
                                                                                                                                                                                                                                            return 0;
                                                                                                                                                                                                                                          }

                                                                                                                                                                                                                                          $content = strtolower(strip_tags($content));

                                                                                                                                                                                                                                          //Tasa de cambio representativa del mercado (TRM) del dÃ­a miÃ©rcoles 12 de enero de 2011 : $ 1856.79 pesos colombianos por dÃ³lar estadounidense

                                                                                                                                                                                                                                          $y = date("Y");
                                                                                                                                                                                                                                          $d = date("d");
                                                                                                                                                                                                                                          $pattern = "/{$d}\\s+de\\s+[a-z]+\\s+de\\s+{$y}\\s+:\\s+\\$\\s+([0-9\\.]+)/";

                                                                                                                                                                                                                                          $matches = array();
                                                                                                                                                                                                                                          preg_match_all($pattern, $content, $matches);


                                                                                                                                                                                                                                          if (count($matches)) {
                                                                                                                                                                                                                                            return 0;
                                                                                                                                                                                                                                          }

                                                                                                                                                                                                                                          //print_r($matches);
                                                                                                                                                                                                                                          return $matches[1][0];
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function trmSuperFinanciera()
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          @$content = file_get_contents("http://www.superfinanciera.gov.co/Cifras/informacion/diarios/tcrm/tcrm.htm");
                                                                                                                                                                                                                                          if (!$content) {
                                                                                                                                                                                                                                            return 0;
                                                                                                                                                                                                                                          }


                                                                                                                                                                                                                                          $pattern  = "/[0-9]{1,3},[0-9]{3}\\.[0-9]{0,2}/";
                                                                                                                                                                                                                                          $matches = array();
                                                                                                                                                                                                                                          preg_match_all($pattern, $content, $matches);

                                                                                                                                                                                                                                          if (count($matches) == 0) {
                                                                                                                                                                                                                                            return 0;
                                                                                                                                                                                                                                          }

                                                                                                                                                                                                                                          $trm = $matches[0][0];

                                                                                                                                                                                                                                          if (empty($trm)) {
                                                                                                                                                                                                                                            return 0;
                                                                                                                                                                                                                                          }


                                                                                                                                                                                                                                          $pattern = "/: ([0-9]{1,2}) de [a-zA-Z]+ de [0-9]{4}/";
                                                                                                                                                                                                                                          preg_match($pattern, $content, $matches);

                                                                                                                                                                                                                                          $trm = str_replace(",", "", $trm);
                                                                                                                                                                                                                                          return $trm;
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function trm()
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          if (!session_id()) session_start();

                                                                                                                                                                                                                                          if (isset($_SESSION["trm"][date("Y-m-d")])) {
                                                                                                                                                                                                                                            return $_SESSION["trm"][date("Y-m-d")];
                                                                                                                                                                                                                                          }

                                                                                                                                                                                                                                          $trm = 0;
                                                                                                                                                                                                                                          $trmBanRep = (float) trmBanRep();
                                                                                                                                                                                                                                          $trmSuperFinanciera = (float) trmSuperFinanciera();

                                                                                                                                                                                                                                          if ($trmBanRep) {
                                                                                                                                                                                                                                            $trm = $trmBanRep;
                                                                                                                                                                                                                                          } else if ($trmSuperFinanciera) {
                                                                                                                                                                                                                                            $trm = $trmSuperFinanciera;
                                                                                                                                                                                                                                          } else {
                                                                                                                                                                                                                                            return ("No se encontraton trms validas");
                                                                                                                                                                                                                                          }

                                                                                                                                                                                                                                          $_SESSION["trm"] = array();
                                                                                                                                                                                                                                          $_SESSION["trm"][date("Y-m-d")] = $trm;
                                                                                                                                                                                                                                          return $trm;
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function sitioAssoc()
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          $nConexion = Conectar();
                                                                                                                                                                                                                                          $sql = "select s.*, p.estilo from tblsitio s LEFT JOIN plantillas p ON s.idplantilla=p.idplantilla LIMIT 1";
                                                                                                                                                                                                                                          $ra = mysqli_query($nConexion, $sql);

                                                                                                                                                                                                                                          return mysqli_fetch_assoc($ra);
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function datosGenerales()
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          $nConexion = Conectar();
                                                                                                                                                                                                                                          $sql = "select * from tbldatos_generales";
                                                                                                                                                                                                                                          $ra = mysqli_query($nConexion, $sql);

                                                                                                                                                                                                                                          return mysqli_fetch_assoc($ra);
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function CargarMapaGoogle()
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          $nConexion = Conectar();
                                                                                                                                                                                                                                          $sql = "select * from tblsitio limit 1";
                                                                                                                                                                                                                                          $ra = mysqli_query($nConexion, $sql);

                                                                                                                                                                                                                                          $sitioCfg = mysqli_fetch_assoc($ra);

                                                                                                                                                                                                                                          return $sitioCfg['nombre'];
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function busqueda($q)
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          global $IdCiudad;
                                                                                                                                                                                                                                          $sql = array();

                                                                                                                                                                                                                                          //Archivos
                                                                                                                                                                                                                                          $sql[] = "select
  'Archivos' as seccion, 
  titulo as titulo,
  detalle as contenido,
  match(titulo,detalle) against('{$q}') as score,
  concat('listar_archivos.php?categoria=',idarchivo,'&ciudad={$IdCiudad}') as url 
  from tblarchivos 
  where match(titulo,detalle) against('{$q}')  or lower(titulo) like '%{$q}%' or lower(detalle) like '%{$q}%'";


                                                                                                                                                                                                                                          //CategoriaArchivos
                                                                                                                                                                                                                                          $sql[] = "select
  'Categoria de Archivos' as seccion, 
  categoria as titulo,
  descripcion as contenido,
  match(categoria,descripcion) against('{$q}') as score,
  concat('cat_archivos.php?cat_archivo=',idcategoria,'&ciudad={$IdCiudad}') as url 
  from tblcategoriasarchivos 
  where match(categoria,descripcion) against('{$q}')  or lower(categoria) like '%{$q}%' or lower(descripcion) like '%{$q}%'";


                                                                                                                                                                                                                                          //CategoriaProductos
                                                                                                                                                                                                                                          $sql[] = "select
  'Categoria de Productos' as seccion, 
  categoria as titulo,
  descripcion as contenido,
  match(categoria,descripcion) against('{$q}') as score,
  concat('productos.php?categoria=',idcategoria,'&ciudad={$IdCiudad}') as url 
  from tblcategoriasproductos 
  where match(categoria,descripcion) against('{$q}')  or lower(categoria) like '%{$q}%' or lower(descripcion) like '%{$q}%'";


                                                                                                                                                                                                                                          //CategoriaServicios
                                                                                                                                                                                                                                          $sql[] = "select
  'Categoria de Servicios' as seccion, 
  categoria as titulo,
  descripcion as contenido,
  match(categoria,descripcion) against('{$q}') as score,
  concat('servicioslistar.php?categoria=',idcategoria,'&ciudad={$IdCiudad}') as url 
  from tblcategoriasservicios 
  where match(categoria,descripcion) against('{$q}')  or lower(categoria) like '%{$q}%' or lower(descripcion) like '%{$q}%'";

                                                                                                                                                                                                                                          //Contenidos
                                                                                                                                                                                                                                          $sql[] = "select
  'Contenidos' as seccion,
  titulo as titulo,
  contenido as contenido,
  match(titulo,contenido) against('{$q}') as score,
  concat('contenido.php?clave=',clave,'&ciudad={$IdCiudad}') as url
  from tblcontenidos
  where match(titulo,contenido) against('{$q}') or lower(titulo) like '%{$q}%' or lower(contenido) like '%{$q}%'
  ";

                                                                                                                                                                                                                                          //CategoriaDirectorio
                                                                                                                                                                                                                                          $sql[] = "select
  'Directorio' as seccion, 
  nombre as titulo,
  descripcion as contenido,
  match(nombre,descripcion) against('{$q}') as score,
  concat('empaisastodas.php?&ciudad={$IdCiudad}') as url 
  from tbldiremp_empresas 
  where match(nombre,descripcion) against('{$q}')  or lower(nombre) like '%{$q}%' or lower(descripcion) like '%{$q}%'";


                                                                                                                                                                                                                                          //Editorial 
                                                                                                                                                                                                                                          $sql[] = "select
  'Editorial' as seccion,
  titulo as titulo,
  contenido as contenido,
  match(titulo,contenido) against('{$q}') as score,
  concat('editorialver.php?editorial=',ideditorial,'&ciudad={$IdCiudad}') as url
  from tbleditorial
  where match(titulo,contenido) against('{$q}') or lower(titulo) like '%{$q}%' or lower(contenido) like '%{$q}%'";


                                                                                                                                                                                                                                          //Eventos 
                                                                                                                                                                                                                                          $sql[] = "select
  'Evento' as seccion,
  evento as titulo,
  detalle as contenido,
  match(evento,detalle) against('{$q}') as score,
  concat('eventosver.php?evento=',idevento,'&ciudad={$IdCiudad}') as url
  from tbleventos
  where match(evento,detalle) against('{$q}') or lower(evento) like '%{$q}%' or lower(detalle) like '%{$q}%'";


                                                                                                                                                                                                                                          //FAQ 
                                                                                                                                                                                                                                          $sql[] = "select
  'Faq' as seccion,
  pregunta as titulo,
  respuesta as contenido,
  match(pregunta,respuesta) against('{$q}') as score,
  concat('faq.php?&ciudad={$IdCiudad}') as url
  from tblfaq
  where match(pregunta,respuesta) against('{$q}') or lower(pregunta) like '%{$q}%' or lower(respuesta) like '%{$q}%'";


                                                                                                                                                                                                                                          //Foro 
                                                                                                                                                                                                                                          $sql[] = "select
  'Foro' as seccion,
  titulo as titulo,
  mensaje as contenido,
  match(titulo,mensaje) against('{$q}') as score,
  concat('foroTemaVer.php?idtema=',idtema,'&ciudad={$IdCiudad}') as url
  from tblforo_temas
  where match(titulo,mensaje) against('{$q}') or lower(titulo) like '%{$q}%' or lower(mensaje) like '%{$q}%'";

                                                                                                                                                                                                                                          //Imagenes
                                                                                                                                                                                                                                          $sql[] = "select
  'Imagenes' as seccion,
  imagen as titulo,
  descripcion as contenido,
  match(imagen,descripcion) against('{$q}') as score,
  concat('galeria.php?galeria=',idimagen,'&ciudad={$IdCiudad}') as url
  from tblimagenes
  where match(imagen,descripcion) against('{$q}') or lower(imagen) like '{$q}' or lower(descripcion) like '{$q}'
  ";


                                                                                                                                                                                                                                          //Mensaje 
                                                                                                                                                                                                                                          $sql[] = "select
  'Pizarra Virtual' as seccion,
  titulo as titulo,
  mensaje as contenido,
  match(titulo,mensaje) against('{$q}') as score,
  concat('mensajes.php?&ciudad={$IdCiudad}') as url
  from tblmensajes
  where match(titulo,mensaje) against('{$q}') or lower(titulo) like '%{$q}%' or lower(mensaje) like '%{$q}%'";


                                                                                                                                                                                                                                          //Musica 
                                                                                                                                                                                                                                          $sql[] = "select
  'Pizarra Virtual' as seccion,
  nombre as titulo,
  artista as contenido,
  match(nombre,artista) against('{$q}') as score,
  concat('musica.php?&ciudad={$IdCiudad}') as url
  from tblmusica
  where match(nombre,artista) against('{$q}') or lower(nombre) like '%{$q}%' or lower(artista) like '%{$q}%'";

                                                                                                                                                                                                                                          //Noticias
                                                                                                                                                                                                                                          $sql[] = "select
  'Noticias' as seccion, 
  titular as titulo,
  noticia as contenido,
  match(titular,noticia) against('{$q}') as score,
  concat('noticiasver.php?noticia=',idnoticia,'&ciudad={$IdCiudad}') as url 
  from tblnoticias 
  where match(titular,noticia) against('{$q}')  or lower(titular) like '%{$q}%' or lower(noticia) like '%{$q}%'";


                                                                                                                                                                                                                                          //Productos
                                                                                                                                                                                                                                          $sql[] = "select
  'Productos' as seccion, 
  producto as titulo,
  detalle as contenido,
  match(producto,detalle) against('{$q}') as score,
  concat('productosver.php?producto=',idproducto,'&ciudad={$IdCiudad}') as url 
  from tblproductos 
  where match(producto,detalle) against('{$q}')  or lower(producto) like '%{$q}%' or lower(detalle) like '%{$q}%'";


                                                                                                                                                                                                                                          //Servicios
                                                                                                                                                                                                                                          $sql[] = "select
  'Servicios' as seccion, 
  servicio as titulo,
  detalle as contenido,
  match(servicio,detalle) against('{$q}') as score,
  concat('serviciosver.php?servicio=',idservicio,'&ciudad={$IdCiudad}') as url 
  from tblservicios 
  where match(servicio,detalle) against('{$q}')  or lower(servicio) like '%{$q}%' or lower(detalle) like '%{$q}%'";


                                                                                                                                                                                                                                          //Sitios Amigos
                                                                                                                                                                                                                                          $sql[] = "select
  'Sitios' as seccion, 
  nombre as titulo,
  descripcion as contenido,
  match(nombre,descripcion) against('{$q}') as score,
  concat('sitiosver.php?sitio=',idsitio,'&ciudad={$IdCiudad}') as url 
  from tblsitiossugeridos 
  where match(nombre,descripcion) against('{$q}')  or lower(nombre) like '%{$q}%' or lower(descripcion) like '%{$q}%'";


                                                                                                                                                                                                                                          //Videos
                                                                                                                                                                                                                                          $sql[] = "select
  'Videos' as seccion, 
  nombre as titulo,
  descripcion as contenido,
  match(nombre,descripcion) against('{$q}') as score,
  concat('videos.php?idvideo=',idvideo,'&size=normal&ciudad={$IdCiudad}') as url 
  from tblvideos 
  where match(nombre,descripcion) against('{$q}') or lower(nombre) like '%{$q}%' or lower(descripcion) like '%{$q}%'";


                                                                                                                                                                                                                                          //Videos Youtube
                                                                                                                                                                                                                                          $sql[] = "select
  'Videos Youtube' as seccion, 
  nombre as titulo,
  descripcion as contenido,
  match(nombre,descripcion) against('{$q}') as score,
  concat('videosYoutube.php?idvideo=',idvideo,'&size=normal&ciudad={$IdCiudad}') as url 
  from tblvideosyoutube
  where match(nombre,descripcion) against('{$q}') or lower(nombre) like '%{$q}%' or lower(descripcion) like '%{$q}%'";


                                                                                                                                                                                                                                          //consulta final
                                                                                                                                                                                                                                          //$sql = " ( ".implode(" union all ",$sql)." ) busqueda "; //." order by score desc";
                                                                                                                                                                                                                                          $sql = "  " . implode(" union all ", $sql) . " "; //." order by score desc";
                                                                                                                                                                                                                                          //echo $sql;
                                                                                                                                                                                                                                          $nConexion = Conectar();

                                                                                                                                                                                                                                          $ca = new DbQuery($nConexion);
                                                                                                                                                                                                                                          $ca->prepare($sql);

                                                                                                                                                                                                                                          $pag = isset($_GET["pag"]) ? $_GET["pag"] : 1;
                                                                                                                                                                                                                                          $page = $ca->execPage(array("pager" => true, "page" => $pag, "count" => $count, "pagerVars" => "ciudad=1&{$pageVars}"));
                                                                                                                                                                                                                                          return $page;

                                                                                                                                                                                                                                          //paginador y consulta
                                                                                                                                                                                                                                          /*$page = new sistema_paginacion($sql);
  $page->ordenar_por("score desc");
  $page->set_condicion("where 1=1");
  $page->set_limite_pagina(8);
  $rsBusqueda = $page->obtener_consulta();
  $page->set_tabla_transparente();
  $page->set_color_texto("black");
  $page->set_color_enlaces("black","#FF9900
  $result = array();
  
  if ( !$rsBusqueda ) {
    $result["error"] = true;
    return $result;
  }
  
  $result["error"] = false;
  $result["rs"] = $rsBusqueda;
  $result["page"] = $page;
  
  return $result;*/
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function EvaluacionesGenerarGraficas($idevaluacion, $idsede, $idzona, $idregion, $filtro)
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          global $colores;
                                                                                                                                                                                                                                          $IdCiudad = $_SESSION["IdCiudad"];
                                                                                                                                                                                                                                          $nConexion = Conectar();
                                                                                                                                                                                                                                          $ca = new DbQuery($nConexion);

                                                                                                                                                                                                                                          $where = "1=1 ";
                                                                                                                                                                                                                                          if ($filtro != "") {
                                                                                                                                                                                                                                            $where .= "and ( upper(b.nombre) like upper('%{$filtro}%') or upper(c.nombre) like upper('%{$filtro}%') 
        or upper(f.nombre) like upper('%{$filtro}%') or upper(e.nombre) like upper('%{$filtro}%') 
        or upper(d.nombre) like upper('%{$filtro}%') ) ";
                                                                                                                                                                                                                                          }
                                                                                                                                                                                                                                          if ($idsede != "todas") {
                                                                                                                                                                                                                                            $where .= "and a.idsede='{$idsede}' ";
                                                                                                                                                                                                                                          }
                                                                                                                                                                                                                                          if ($idzona != "todas") {
                                                                                                                                                                                                                                            $where .= "and d.idzona='{$idzona}' ";
                                                                                                                                                                                                                                          }
                                                                                                                                                                                                                                          if ($idregion != "todas") {
                                                                                                                                                                                                                                            $where .= "and e.idregion='{$idregion}' ";
                                                                                                                                                                                                                                          }
                                                                                                                                                                                                                                          if ($idevaluacion != "0") {
                                                                                                                                                                                                                                            $where .= "and a.idevaluacion='{$idevaluacion}' ";
                                                                                                                                                                                                                                          }

                                                                                                                                                                                                                                          $campos = "a.idsede,a.idevaluacion,a.fechahora,b.nombre as sede,c.nombre as plantilla_evaluacion,f.nombre as empresa,d.nombre as zona,e.nombre as region,
        b.idevaluacion as codigo_plantilla";


                                                                                                                                                                                                                                          $ca->prepareSelect(
                                                                                                                                                                                                                                            "tbltk_evaluaciones_vals a 
    join tbltk_sedes b on (a.idsede=b.idsede) 
    join tbltk_pevaluaciones c on (b.idevaluacion=c.idevaluacion)
    join tbltk_zonas d on (b.idzona=d.idzona) 
    join tbltk_regiones e on (d.idregion=e.idregion)
    join tbltk_empresas f on (e.idempresa=f.idempresa)",
                                                                                                                                                                                                                                            $campos,
                                                                                                                                                                                                                                            $where
                                                                                                                                                                                                                                          );
                                                                                                                                                                                                                                          //echo $ca->preparedQuery();
                                                                                                                                                                                                                                          $ca->exec();

                                                                                                                                                                                                                                          $rEvaluaciones = $ca->fetchAll();

?>

  <br />
  <table>

    <?php
                                                                                                                                                                                                                                          $j = 0;
                                                                                                                                                                                                                                          foreach ($rEvaluaciones as $evaluacion) {
                                                                                                                                                                                                                                            shuffle($colores);
                                                                                                                                                                                                                                            $ca->prepareSelect(
                                                                                                                                                                                                                                              "tbltk_evaluaciones_vals_det a 
            join tbltk_pevaluaciones_det b on (a.idconcepto=b.idconcepto)",
                                                                                                                                                                                                                                              "a.valor,b.descripcion as pregunta",
                                                                                                                                                                                                                                              "a.idevaluacion=:idevaluacion"
                                                                                                                                                                                                                                            );
                                                                                                                                                                                                                                            $ca->bindValue(":idevaluacion", $evaluacion["idevaluacion"], false);

                                                                                                                                                                                                                                            $ca->exec();
                                                                                                                                                                                                                                            $cantidad = $ca->size();


                                                                                                                                                                                                                                            $rPreguntas = $ca->fetchAll();


                                                                                                                                                                                                                                            $url = "http://chart.apis.google.com/chart
            ?chf=a,s,000000
            &chxl=0:|0|1|2|3|4|5
            &chxr=0,0,6
            &chxs=0,676767,12.5,-1,l,676767
            &chxt=y
            &cht=bvg
            &chg=-1,20
            &chma=|6";

                                                                                                                                                                                                                                            $chbh = "&chbh=a,9";
                                                                                                                                                                                                                                            if ($cantidad == 1) {
                                                                                                                                                                                                                                              $chbh = "&chbh=100,9,10";
                                                                                                                                                                                                                                            }

                                                                                                                                                                                                                                            $url .= $chbh;
                                                                                                                                                                                                                                            $url .= "&chtt={$evaluacion["sede"]}";

                                                                                                                                                                                                                                            $h = 250;
                                                                                                                                                                                                                                            if ($cantidad > 11) {
                                                                                                                                                                                                                                              $h = $h + (20 * ($cantidad - 11));
                                                                                                                                                                                                                                            }

                                                                                                                                                                                                                                            $url .= "&chs=400x{$h}";

                                                                                                                                                                                                                                            $chds = "&chds=" . substr(str_repeat('0,5,', $cantidad), 0, strlen(str_repeat('0,5,', $cantidad)) - 1);

                                                                                                                                                                                                                                            $url .= $chds;

                                                                                                                                                                                                                                            $url .= "&chco=" . implode(',', array_slice($colores, 0, $cantidad));

                                                                                                                                                                                                                                            $chd = "&chd=t:";
                                                                                                                                                                                                                                            $chdl = "&chdl=";
                                                                                                                                                                                                                                            $chm = "&chm=";
                                                                                                                                                                                                                                            $i = 1;
                                                                                                                                                                                                                                            $htmlPreguntas = "";
                                                                                                                                                                                                                                            foreach ($rPreguntas as $pregunta) {
                                                                                                                                                                                                                                              $chd .= "{$pregunta["valor"]}|";
                                                                                                                                                                                                                                              $chdl .= "p+{$i}|";
                                                                                                                                                                                                                                              $tmp = $i - 1;
                                                                                                                                                                                                                                              $chm .= "N,000000,{$tmp},-1,14|";
                                                                                                                                                                                                                                              $htmlPreguntas .= "{$i}-{$pregunta["pregunta"]}<br/>";
                                                                                                                                                                                                                                              $i++;
                                                                                                                                                                                                                                            }
                                                                                                                                                                                                                                            $chd = substr($chd, 0, strlen($chd) - 1);
                                                                                                                                                                                                                                            $chdl = substr($chdl, 0, strlen($chdl) - 1);
                                                                                                                                                                                                                                            $chm = substr($chm, 0, strlen($chm) - 1);


                                                                                                                                                                                                                                            $url .= "{$chd}{$chdl}{$chm}";

                                                                                                                                                                                                                                            $url = str_replace(" ", "", $url);

                                                                                                                                                                                                                                            if ($j == 0) { ?>
        <tr>
          <td style="width: 15%;">&nbsp;</td>
          <td>
          <?php } else { ?>
          </td>
          <td>
          <?php } ?>
          <table>
            <tr>
              <td>
                <strong>Empresa:</strong> <?php echo $evaluacion["empresa"]; ?><br />
                <strong>Sede:</strong> <?php echo $evaluacion["sede"]; ?><br />
                <strong>Fecha:</strong> <?php echo $evaluacion["fechahora"]; ?><br />
                <strong>Plantilla evaluación:</strong> <?php echo $evaluacion["plantilla_evaluacion"]; ?><br />
                <br />
                <strong>Preguntas:</strong><br /><br />
                <?php echo $htmlPreguntas; ?>
                <br />
              </td>
            </tr>
            <tr>
              <td>
                <img src="<?php echo $url; ?>" alt='img.' /><br /><br />
              </td>
            </tr>
          </table>
          <?php if ($j == 0) { ?>
          </td>
        <?php } else { ?>
          </td>
          <td style="width: 15%;">&nbsp;</td>
        <tr>
      <?php
                                                                                                                                                                                                                                              $j = -1;
                                                                                                                                                                                                                                            }
                                                                                                                                                                                                                                            $j++;
                                                                                                                                                                                                                                          }
      ?>

  </table>
  <br /><br />
<?php
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function EvaluacionesGenerarPDF($idevaluacion, $idsede, $idzona, $idregion, $filtro)
                                                                                                                                                                                                                                        {

                                                                                                                                                                                                                                          $cRuta = "../fotos/tickets/";

                                                                                                                                                                                                                                          ob_clean();
                                                                                                                                                                                                                                          ob_start();
                                                                                                                                                                                                                                          global $colores;
                                                                                                                                                                                                                                          $IdCiudad = $_SESSION["IdCiudad"];
                                                                                                                                                                                                                                          $nConexion = Conectar();
                                                                                                                                                                                                                                          $ca = new DbQuery($nConexion);

                                                                                                                                                                                                                                          $where = "1=1 ";
                                                                                                                                                                                                                                          if ($filtro != "") {
                                                                                                                                                                                                                                            $where .= "and ( upper(b.nombre) like upper('%{$filtro}%') or upper(c.nombre) like upper('%{$filtro}%') 
        or upper(f.nombre) like upper('%{$filtro}%') or upper(e.nombre) like upper('%{$filtro}%') 
        or upper(d.nombre) like upper('%{$filtro}%') ) ";
                                                                                                                                                                                                                                          }
                                                                                                                                                                                                                                          if ($idsede != "todas") {
                                                                                                                                                                                                                                            $where .= "and a.idsede='{$idsede}' ";
                                                                                                                                                                                                                                          }
                                                                                                                                                                                                                                          if ($idzona != "todas") {
                                                                                                                                                                                                                                            $where .= "and d.idzona='{$idzona}' ";
                                                                                                                                                                                                                                          }
                                                                                                                                                                                                                                          if ($idregion != "todas") {
                                                                                                                                                                                                                                            $where .= "and e.idregion='{$idregion}' ";
                                                                                                                                                                                                                                          }
                                                                                                                                                                                                                                          if ($idevaluacion != "0") {
                                                                                                                                                                                                                                            $where .= "and a.idevaluacion='{$idevaluacion}' ";
                                                                                                                                                                                                                                          }

                                                                                                                                                                                                                                          $campos = "a.idsede,a.idevaluacion,a.fechahora,b.nombre as sede,c.nombre as plantilla_evaluacion,f.nombre as empresa,d.nombre as zona,e.nombre as region,
        b.idevaluacion as codigo_plantilla";


                                                                                                                                                                                                                                          $ca->prepareSelect(
                                                                                                                                                                                                                                            "tbltk_evaluaciones_vals a 
    join tbltk_sedes b on (a.idsede=b.idsede) 
    join tbltk_pevaluaciones c on (b.idevaluacion=c.idevaluacion)
    join tbltk_zonas d on (b.idzona=d.idzona) 
    join tbltk_regiones e on (d.idregion=e.idregion)
    join tbltk_empresas f on (e.idempresa=f.idempresa)",
                                                                                                                                                                                                                                            $campos,
                                                                                                                                                                                                                                            $where
                                                                                                                                                                                                                                          );
                                                                                                                                                                                                                                          //echo $ca->preparedQuery();
                                                                                                                                                                                                                                          $ca->exec();

                                                                                                                                                                                                                                          $rEvaluaciones = $ca->fetchAll();


                                                                                                                                                                                                                                          $pdf = new fpdf();
                                                                                                                                                                                                                                          $pdf->AddPage();
                                                                                                                                                                                                                                          $pdf->SetFont('Arial', 'B', 11);

                                                                                                                                                                                                                                          $rFiles = array();

                                                                                                                                                                                                                                          foreach ($rEvaluaciones as $evaluacion) {
                                                                                                                                                                                                                                            shuffle($colores);
                                                                                                                                                                                                                                            $ca->prepareSelect(
                                                                                                                                                                                                                                              "tbltk_evaluaciones_vals_det a 
            join tbltk_pevaluaciones_det b on (a.idconcepto=b.idconcepto)",
                                                                                                                                                                                                                                              "a.valor,b.descripcion as pregunta",
                                                                                                                                                                                                                                              "a.idevaluacion=:idevaluacion"
                                                                                                                                                                                                                                            );
                                                                                                                                                                                                                                            $ca->bindValue(":idevaluacion", $evaluacion["idevaluacion"], false);

                                                                                                                                                                                                                                            $ca->exec();
                                                                                                                                                                                                                                            $cantidad = $ca->size();


                                                                                                                                                                                                                                            $rPreguntas = $ca->fetchAll();


                                                                                                                                                                                                                                            $url = "http://chart.apis.google.com/chart
            ?chf=a,s,000000
            &chxl=0:|0|1|2|3|4|5
            &chxr=0,0,6
            &chxs=0,676767,12.5,-1,l,676767
            &chxt=y
            &cht=bvg
            &chg=-1,20
            &chma=|6";

                                                                                                                                                                                                                                            $chbh = "&chbh=a,9";
                                                                                                                                                                                                                                            if ($cantidad == 1) {
                                                                                                                                                                                                                                              $chbh = "&chbh=100,9,10";
                                                                                                                                                                                                                                            }

                                                                                                                                                                                                                                            $url .= $chbh;
                                                                                                                                                                                                                                            $url .= "&chtt={$evaluacion["sede"]}";

                                                                                                                                                                                                                                            $h = 250;
                                                                                                                                                                                                                                            if ($cantidad > 11) {
                                                                                                                                                                                                                                              $h = $h + (20 * ($cantidad - 11));
                                                                                                                                                                                                                                            }

                                                                                                                                                                                                                                            $url .= "&chs=400x{$h}";

                                                                                                                                                                                                                                            $chds = "&chds=" . substr(str_repeat('0,5,', $cantidad), 0, strlen(str_repeat('0,5,', $cantidad)) - 1);

                                                                                                                                                                                                                                            $url .= $chds;

                                                                                                                                                                                                                                            $url .= "&chco=" . implode(',', array_slice($colores, 0, $cantidad));

                                                                                                                                                                                                                                            $chd = "&chd=t:";
                                                                                                                                                                                                                                            $chdl = "&chdl=";
                                                                                                                                                                                                                                            $chm = "&chm=";

                                                                                                                                                                                                                                            $pdf->SetFont('Arial', 'B', 12);
                                                                                                                                                                                                                                            $pdf->Cell(5);
                                                                                                                                                                                                                                            $pdf->Cell(22, 5, ("Empresa: "));
                                                                                                                                                                                                                                            $pdf->SetFont('Arial', '', 12);
                                                                                                                                                                                                                                            $pdf->Cell(100, 5, ("{$evaluacion["empresa"]}"));
                                                                                                                                                                                                                                            $pdf->Ln();
                                                                                                                                                                                                                                            $pdf->SetFont('Arial', 'B', 12);
                                                                                                                                                                                                                                            $pdf->Cell(5);
                                                                                                                                                                                                                                            $pdf->Cell(15, 5, ("Sede: "));
                                                                                                                                                                                                                                            $pdf->SetFont('Arial', '', 12);
                                                                                                                                                                                                                                            $pdf->Cell(100, 5, ("{$evaluacion["sede"]}"));
                                                                                                                                                                                                                                            $pdf->Ln();
                                                                                                                                                                                                                                            $pdf->SetFont('Arial', 'B', 12);
                                                                                                                                                                                                                                            $pdf->Cell(5);
                                                                                                                                                                                                                                            $pdf->Cell(17, 5, ("Fecha: "));
                                                                                                                                                                                                                                            $pdf->SetFont('Arial', '', 12);
                                                                                                                                                                                                                                            $pdf->Cell(100, 5, ("{$evaluacion["fechahora"]}"));
                                                                                                                                                                                                                                            $pdf->Ln();
                                                                                                                                                                                                                                            $pdf->SetFont('Arial', 'B', 12);
                                                                                                                                                                                                                                            $pdf->Cell(5);
                                                                                                                                                                                                                                            $pdf->Cell(44, 5, ("Plantilla evaluación: "));
                                                                                                                                                                                                                                            $pdf->SetFont('Arial', '', 12);
                                                                                                                                                                                                                                            $pdf->Cell(125, 5, ("{$evaluacion["plantilla_evaluacion"]}"));
                                                                                                                                                                                                                                            $pdf->Ln();
                                                                                                                                                                                                                                            $pdf->Ln();
                                                                                                                                                                                                                                            $pdf->SetFont('Arial', 'B', 12);
                                                                                                                                                                                                                                            $pdf->Cell(5);
                                                                                                                                                                                                                                            $pdf->Cell(60, 5, ("Preguntas"));
                                                                                                                                                                                                                                            $pdf->Ln();
                                                                                                                                                                                                                                            $pdf->SetFont('Arial', '', 12);
                                                                                                                                                                                                                                            $i = 1;

                                                                                                                                                                                                                                            foreach ($rPreguntas as $pregunta) {
                                                                                                                                                                                                                                              $chd .= "{$pregunta["valor"]}|";
                                                                                                                                                                                                                                              $chdl .= "p+{$i}|";
                                                                                                                                                                                                                                              $tmp = $i - 1;
                                                                                                                                                                                                                                              $chm .= "N,000000,{$tmp},-1,14|";
                                                                                                                                                                                                                                              $pdf->Cell(5);
                                                                                                                                                                                                                                              $pdf->Cell(60, 5, ("{$i}-{$pregunta["pregunta"]}"));
                                                                                                                                                                                                                                              $pdf->Ln();
                                                                                                                                                                                                                                              $i++;
                                                                                                                                                                                                                                            }
                                                                                                                                                                                                                                            $chd = substr($chd, 0, strlen($chd) - 1);
                                                                                                                                                                                                                                            $chdl = substr($chdl, 0, strlen($chdl) - 1);
                                                                                                                                                                                                                                            $chm = substr($chm, 0, strlen($chm) - 1);

                                                                                                                                                                                                                                            $url .= "{$chd}{$chdl}{$chm}";

                                                                                                                                                                                                                                            $url = trim(str_replace("\n", "", $url));
                                                                                                                                                                                                                                            $url = trim(str_replace("\r", "", $url));
                                                                                                                                                                                                                                            $url = trim(str_replace(" ", "", $url));

                                                                                                                                                                                                                                            $filename = "{$cRuta}{$evaluacion["sede"]}_{$evaluacion["fechahora"]}.png";
                                                                                                                                                                                                                                            file_put_contents($filename, file_get_contents($url));

                                                                                                                                                                                                                                            $rFiles[] = $filename;

                                                                                                                                                                                                                                            if ($pdf->GetY() + 60 > 280) {
                                                                                                                                                                                                                                              $pdf->AddPage();
                                                                                                                                                                                                                                            }

                                                                                                                                                                                                                                            $pdf->Ln(2);
                                                                                                                                                                                                                                            $pdf->Cell(60, 60, $pdf->Image($filename, $pdf->GetX(), $pdf->GetY(), 95, 60, 'PNG'));
                                                                                                                                                                                                                                            $pdf->SetY($pdf->GetY() + 60);
                                                                                                                                                                                                                                            $pdf->Ln(10);
                                                                                                                                                                                                                                          }

                                                                                                                                                                                                                                          foreach ($rFiles as $filename) {
                                                                                                                                                                                                                                            unlink($filename);
                                                                                                                                                                                                                                          }

                                                                                                                                                                                                                                          $pdf->Output();
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function usuarioSedesHabilitadas()
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          if (!isset($_SESSION["usuario"])) return;

                                                                                                                                                                                                                                          $nConexion = Conectar();
                                                                                                                                                                                                                                          $ca = new DbQuery($nConexion);

                                                                                                                                                                                                                                          $result = array();

                                                                                                                                                                                                                                          switch ($_SESSION["usuario"]["tickets_tipo"]) {
                                                                                                                                                                                                                                            case "operario":
                                                                                                                                                                                                                                              $ca->prepareSelect("tbltk_sedes a", "a.idsede,a.nombre", "a.idsede=:idsede");
                                                                                                                                                                                                                                              $ca->bindValue(":idsede", $_SESSION["usuario"]["tickets_idsede"], false);
                                                                                                                                                                                                                                              $ca->exec();
                                                                                                                                                                                                                                              $result = $ca->fetchAll();
                                                                                                                                                                                                                                              break;
                                                                                                                                                                                                                                            case "admin":
                                                                                                                                                                                                                                              $ca->prepareSelect(
                                                                                                                                                                                                                                                "tbltk_sedes a JOIN tbltk_zonas b ON ( a.idzona = b.idzona )
                                JOIN tbltk_regiones c ON ( b.idregion = c.idregion )
                                JOIN tbltk_empresas d ON (c.idempresa=d.idempresa)",
                                                                                                                                                                                                                                                "a.idsede,a.nombre",
                                                                                                                                                                                                                                                "d.idempresa={$_SESSION["usuario"]["tickets_idempresa"]}"
                                                                                                                                                                                                                                              );
                                                                                                                                                                                                                                              $ca->exec();
                                                                                                                                                                                                                                              $result = $ca->fetchAll();
                                                                                                                                                                                                                                              break;
                                                                                                                                                                                                                                            case "region":
                                                                                                                                                                                                                                              $ca->prepareSelect(
                                                                                                                                                                                                                                                "tbltk_sedes a JOIN tbltk_zonas b ON ( a.idzona = b.idzona )
                                JOIN tbltk_regiones c ON ( b.idregion = c.idregion )",
                                                                                                                                                                                                                                                "a.idsede,a.nombre",
                                                                                                                                                                                                                                                "c.idregion={$_SESSION["usuario"]["tickets_attr_tipo"]}"
                                                                                                                                                                                                                                              );
                                                                                                                                                                                                                                              $ca->exec();
                                                                                                                                                                                                                                              $result = $ca->fetchAll();
                                                                                                                                                                                                                                              break;
                                                                                                                                                                                                                                            case "zona":
                                                                                                                                                                                                                                              $ca->prepareSelect(
                                                                                                                                                                                                                                                "tbltk_sedes a JOIN tbltk_zonas b ON ( a.idzona = b.idzona )",
                                                                                                                                                                                                                                                "a.idsede,a.nombre",
                                                                                                                                                                                                                                                "b.idzona={$_SESSION["usuario"]["tickets_attr_tipo"]}"
                                                                                                                                                                                                                                              );
                                                                                                                                                                                                                                              $ca->exec();
                                                                                                                                                                                                                                              $result = $ca->fetchAll();
                                                                                                                                                                                                                                              break;
                                                                                                                                                                                                                                            default:
                                                                                                                                                                                                                                              break;
                                                                                                                                                                                                                                          }
                                                                                                                                                                                                                                          return $result;
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function usuarioZonasHabilitadas()
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          if (!isset($_SESSION["usuario"])) return;

                                                                                                                                                                                                                                          $nConexion = Conectar();
                                                                                                                                                                                                                                          $ca = new DbQuery($nConexion);

                                                                                                                                                                                                                                          $result = array();

                                                                                                                                                                                                                                          switch ($_SESSION["usuario"]["tickets_tipo"]) {
                                                                                                                                                                                                                                            case "operario":
                                                                                                                                                                                                                                              $ca->prepareSelect("tbltk_zonas a", "a.idzona,a.nombre", "a.idzona=:idzona");
                                                                                                                                                                                                                                              $ca->bindValue(":idzona", $_SESSION["usuario"]["tickets_idzona"], false);
                                                                                                                                                                                                                                              $ca->exec();
                                                                                                                                                                                                                                              $result = $ca->fetchAll();
                                                                                                                                                                                                                                              break;
                                                                                                                                                                                                                                            case "admin":
                                                                                                                                                                                                                                              $ca->prepareSelect(
                                                                                                                                                                                                                                                "tbltk_zonas b JOIN tbltk_regiones c ON ( b.idregion = c.idregion )
                                JOIN tbltk_empresas d ON (c.idempresa=d.idempresa)",
                                                                                                                                                                                                                                                "b.idzona,b.nombre",
                                                                                                                                                                                                                                                "d.idempresa={$_SESSION["usuario"]["tickets_idempresa"]}"
                                                                                                                                                                                                                                              );
                                                                                                                                                                                                                                              $ca->exec();
                                                                                                                                                                                                                                              $result = $ca->fetchAll();
                                                                                                                                                                                                                                              break;
                                                                                                                                                                                                                                            case "region":
                                                                                                                                                                                                                                              $ca->prepareSelect(
                                                                                                                                                                                                                                                "tbltk_zonas b JOIN tbltk_regiones c ON ( b.idregion = c.idregion )",
                                                                                                                                                                                                                                                "b.idzona,b.nombre",
                                                                                                                                                                                                                                                "c.idregion={$_SESSION["usuario"]["tickets_attr_tipo"]}"
                                                                                                                                                                                                                                              );
                                                                                                                                                                                                                                              $ca->exec();
                                                                                                                                                                                                                                              $result = $ca->fetchAll();
                                                                                                                                                                                                                                              break;
                                                                                                                                                                                                                                            case "zona":
                                                                                                                                                                                                                                              $ca->prepareSelect("tbltk_zonas a", "a.idzona,a.nombre", "a.idzona=:idzona");
                                                                                                                                                                                                                                              $ca->bindValue(":idzona", $_SESSION["usuario"]["tickets_idzona"], false);
                                                                                                                                                                                                                                              $ca->exec();
                                                                                                                                                                                                                                              $result = $ca->fetchAll();
                                                                                                                                                                                                                                              break;
                                                                                                                                                                                                                                            default:
                                                                                                                                                                                                                                              break;
                                                                                                                                                                                                                                          }
                                                                                                                                                                                                                                          return $result;
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function usuarioRegionesHabilitadas()
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          if (!isset($_SESSION["usuario"])) return;

                                                                                                                                                                                                                                          $nConexion = Conectar();
                                                                                                                                                                                                                                          $ca = new DbQuery($nConexion);

                                                                                                                                                                                                                                          $result = array();

                                                                                                                                                                                                                                          switch ($_SESSION["usuario"]["tickets_tipo"]) {
                                                                                                                                                                                                                                            case "operario":
                                                                                                                                                                                                                                              $ca->prepareSelect("tbltk_regiones a", "a.idregion,a.nombre", "a.idregion=:idregion");
                                                                                                                                                                                                                                              $ca->bindValue(":idregion", $_SESSION["usuario"]["tickets_idregion"], false);
                                                                                                                                                                                                                                              $ca->exec();
                                                                                                                                                                                                                                              $result = $ca->fetchAll();
                                                                                                                                                                                                                                              break;
                                                                                                                                                                                                                                            case "admin":
                                                                                                                                                                                                                                              $ca->prepareSelect(
                                                                                                                                                                                                                                                "tbltk_regiones c JOIN tbltk_empresas d ON (c.idempresa=d.idempresa)",
                                                                                                                                                                                                                                                "c.idregion,c.nombre",
                                                                                                                                                                                                                                                "d.idempresa={$_SESSION["usuario"]["tickets_idempresa"]}"
                                                                                                                                                                                                                                              );
                                                                                                                                                                                                                                              $ca->exec();
                                                                                                                                                                                                                                              $result = $ca->fetchAll();
                                                                                                                                                                                                                                              break;
                                                                                                                                                                                                                                            case "region":
                                                                                                                                                                                                                                              $ca->prepareSelect("tbltk_regiones a", "a.idregion,a.nombre", "a.idregion=:idregion");
                                                                                                                                                                                                                                              $ca->bindValue(":idregion", $_SESSION["usuario"]["tickets_idregion"], false);
                                                                                                                                                                                                                                              $ca->exec();
                                                                                                                                                                                                                                              $result = $ca->fetchAll();
                                                                                                                                                                                                                                              break;
                                                                                                                                                                                                                                            case "zona":
                                                                                                                                                                                                                                              $ca->prepareSelect("tbltk_regiones a", "a.idregion,a.nombre", "a.idregion=:idregion");
                                                                                                                                                                                                                                              $ca->bindValue(":idregion", $_SESSION["usuario"]["tickets_idregion"], false);
                                                                                                                                                                                                                                              $ca->exec();
                                                                                                                                                                                                                                              $result = $ca->fetchAll();
                                                                                                                                                                                                                                              break;
                                                                                                                                                                                                                                            default:
                                                                                                                                                                                                                                              break;
                                                                                                                                                                                                                                          }
                                                                                                                                                                                                                                          return $result;
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function ReservasTipoHabitacionCargar()
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          $nConexion = Conectar();
                                                                                                                                                                                                                                          $sql = "SELECT * FROM tbltipohabitacion ORDER BY descripcion";
                                                                                                                                                                                                                                          $ra = mysqli_query($nConexion, $sql);
                                                                                                                                                                                                                                          if (!$ra) {
                                                                                                                                                                                                                                            return null;
                                                                                                                                                                                                                                          }
                                                                                                                                                                                                                                          return $ra;
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function ReservasTipoReservasCargar()
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          $nConexion = Conectar();
                                                                                                                                                                                                                                          $sql = "SELECT * FROM tbltiporeserva ORDER BY descripcion";
                                                                                                                                                                                                                                          $ra = mysqli_query($nConexion, $sql);
                                                                                                                                                                                                                                          if (!$ra) {
                                                                                                                                                                                                                                            return null;
                                                                                                                                                                                                                                          }
                                                                                                                                                                                                                                          return $ra;
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function ReservasEmpresaCubreCargar()
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          $nConexion = Conectar();
                                                                                                                                                                                                                                          $sql = "SELECT * FROM tblempresacubre ORDER BY descripcion";
                                                                                                                                                                                                                                          $ra = mysqli_query($nConexion, $sql);
                                                                                                                                                                                                                                          if (!$ra) {
                                                                                                                                                                                                                                            return null;
                                                                                                                                                                                                                                          }
                                                                                                                                                                                                                                          return $ra;
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function ReservasEmpresaCubreConsulta($d)
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          $nConexion = Conectar();
                                                                                                                                                                                                                                          $sql = "SELECT * FROM tblempresacubre WHERE idempresacubre={$d}";
                                                                                                                                                                                                                                          $ra = mysqli_query($nConexion, $sql);
                                                                                                                                                                                                                                          if (!$ra) {
                                                                                                                                                                                                                                            return null;
                                                                                                                                                                                                                                          }
                                                                                                                                                                                                                                          $row = mysqli_fetch_assoc($ra);
                                                                                                                                                                                                                                          return $row;
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function ReservasTipoReservasConsulta($d)
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          $nConexion = Conectar();
                                                                                                                                                                                                                                          $sql = "SELECT * FROM tbltiporeserva WHERE idtiporeserva={$d}";
                                                                                                                                                                                                                                          $ra = mysqli_query($nConexion, $sql);
                                                                                                                                                                                                                                          if (!$ra) {
                                                                                                                                                                                                                                            return null;
                                                                                                                                                                                                                                          }
                                                                                                                                                                                                                                          $row = mysqli_fetch_assoc($ra);
                                                                                                                                                                                                                                          return $row;
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function ReservasTipoHabitacionConsulta($d)
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          $nConexion = Conectar();
                                                                                                                                                                                                                                          $sql = "SELECT * FROM tbltipohabitacion WHERE idtipohabitacion={$d}";
                                                                                                                                                                                                                                          $ra = mysqli_query($nConexion, $sql);
                                                                                                                                                                                                                                          if (!$ra) {
                                                                                                                                                                                                                                            return null;
                                                                                                                                                                                                                                          }
                                                                                                                                                                                                                                          $row = mysqli_fetch_assoc($ra);
                                                                                                                                                                                                                                          return $row;
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function CargarMetaVerificacionGoogle()
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          $nConexion = Conectar();
                                                                                                                                                                                                                                          $sql = "SELECT * FROM tblsitio";
                                                                                                                                                                                                                                          $ra = mysqli_query($nConexion, $sql);
                                                                                                                                                                                                                                          if (!$ra) {
                                                                                                                                                                                                                                            return null;
                                                                                                                                                                                                                                          }
                                                                                                                                                                                                                                          $row = mysqli_fetch_array($ra);
                                                                                                                                                                                                                                          echo $row['google'];
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function CargarMetaIdFaceBook()
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          $nConexion = Conectar();
                                                                                                                                                                                                                                          $sql = "SELECT * FROM tblsitio";
                                                                                                                                                                                                                                          $ra = mysqli_query($nConexion, $sql);
                                                                                                                                                                                                                                          if (!$ra) {
                                                                                                                                                                                                                                            return null;
                                                                                                                                                                                                                                          }
                                                                                                                                                                                                                                          $row = mysqli_fetch_array($ra);
                                                                                                                                                                                                                                          echo $row['idfacebook'];
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function CargarMetaSiteNameFaceBook()
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          $RegContenido = mysqli_fetch_object(VerContenido("FacebookSiteName"));
                                                                                                                                                                                                                                          echo $RegContenido->contenido;
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function CargarCodigoGoogleAnalitic()
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          $nConexion = Conectar();
                                                                                                                                                                                                                                          $sql = "SELECT * FROM tblsitio";
                                                                                                                                                                                                                                          $ra = mysqli_query($nConexion, $sql);
                                                                                                                                                                                                                                          if (!$ra) {
                                                                                                                                                                                                                                            return null;
                                                                                                                                                                                                                                          }
                                                                                                                                                                                                                                          $row = mysqli_fetch_array($ra);
                                                                                                                                                                                                                                          echo "<!-- Global site tag (gtag.js) - Google Analytics -->

<script async src='https://www.googletagmanager.com/gtag/js?id={$row["analytics"]}'></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', '{$row["analytics"]}');
</script>";
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function CargarMetaEmpresa()
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          $RegContenido = mysqli_fetch_object(VerContenido("CodigoMetaEmpresa"));
                                                                                                                                                                                                                                          echo $RegContenido->contenido;
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function CargarQR()
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          $RegContenido = mysqli_fetch_object(VerContenido("CodigoQR"));
                                                                                                                                                                                                                                          echo $RegContenido->contenido;
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function CargarFecha()
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          date_default_timezone_set("America/Bogota");
                                                                                                                                                                                                                                          $tiempo = getdate(time());
                                                                                                                                                                                                                                          $dia = $tiempo['wday'];
                                                                                                                                                                                                                                          $dia_mes = $tiempo['mday'];
                                                                                                                                                                                                                                          $mes = $tiempo['mon'];
                                                                                                                                                                                                                                          $year = $tiempo['year'];
                                                                                                                                                                                                                                          $hora = $tiempo['hours'];
                                                                                                                                                                                                                                          $minutos = $tiempo['minutes'];
                                                                                                                                                                                                                                          $segundos = $tiempo['seconds'];


                                                                                                                                                                                                                                          switch ($dia) {
                                                                                                                                                                                                                                            case "1":
                                                                                                                                                                                                                                              $dia_nombre = "Lunes";
                                                                                                                                                                                                                                              break;
                                                                                                                                                                                                                                            case "2":
                                                                                                                                                                                                                                              $dia_nombre = "Martes";
                                                                                                                                                                                                                                              break;
                                                                                                                                                                                                                                            case "3":
                                                                                                                                                                                                                                              $dia_nombre = "Mi&eacute;rcoles";
                                                                                                                                                                                                                                              break;
                                                                                                                                                                                                                                            case "4":
                                                                                                                                                                                                                                              $dia_nombre = "Jueves";
                                                                                                                                                                                                                                              break;
                                                                                                                                                                                                                                            case "5":
                                                                                                                                                                                                                                              $dia_nombre = "Viernes";
                                                                                                                                                                                                                                              break;
                                                                                                                                                                                                                                            case "6":
                                                                                                                                                                                                                                              $dia_nombre = "S&aacute;bado";
                                                                                                                                                                                                                                              break;
                                                                                                                                                                                                                                            case "0":
                                                                                                                                                                                                                                              $dia_nombre = "Domingo";
                                                                                                                                                                                                                                              break;
                                                                                                                                                                                                                                          }
                                                                                                                                                                                                                                          switch ($mes) {
                                                                                                                                                                                                                                            case "1":
                                                                                                                                                                                                                                              $mes_nombre = "Enero";
                                                                                                                                                                                                                                              break;
                                                                                                                                                                                                                                            case "2":
                                                                                                                                                                                                                                              $mes_nombre = "Febrero";
                                                                                                                                                                                                                                              break;
                                                                                                                                                                                                                                            case "3":
                                                                                                                                                                                                                                              $mes_nombre = "Marzo";
                                                                                                                                                                                                                                              break;
                                                                                                                                                                                                                                            case "4":
                                                                                                                                                                                                                                              $mes_nombre = "Abril";
                                                                                                                                                                                                                                              break;
                                                                                                                                                                                                                                            case "5":
                                                                                                                                                                                                                                              $mes_nombre = "Mayo";
                                                                                                                                                                                                                                              break;
                                                                                                                                                                                                                                            case "6":
                                                                                                                                                                                                                                              $mes_nombre = "Junio";
                                                                                                                                                                                                                                              break;
                                                                                                                                                                                                                                            case "7":
                                                                                                                                                                                                                                              $mes_nombre = "Julio";
                                                                                                                                                                                                                                              break;
                                                                                                                                                                                                                                            case "8":
                                                                                                                                                                                                                                              $mes_nombre = "Agosto";
                                                                                                                                                                                                                                              break;
                                                                                                                                                                                                                                            case "9":
                                                                                                                                                                                                                                              $mes_nombre = "Septiembre";
                                                                                                                                                                                                                                              break;
                                                                                                                                                                                                                                            case "10":
                                                                                                                                                                                                                                              $mes_nombre = "Octubre";
                                                                                                                                                                                                                                              break;
                                                                                                                                                                                                                                            case "11":
                                                                                                                                                                                                                                              $mes_nombre = "Noviembre";
                                                                                                                                                                                                                                              break;
                                                                                                                                                                                                                                            case "12":
                                                                                                                                                                                                                                              $mes_nombre = "Diciembre";
                                                                                                                                                                                                                                              break;
                                                                                                                                                                                                                                          }
                                                                                                                                                                                                                                          echo $dia_nombre . " " . $dia_mes . " de " . $mes_nombre . " de " . $year;
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function CargarHora()
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          date_default_timezone_set("America/Bogota");
                                                                                                                                                                                                                                          $hora = date('h:i a', time() - 3600 * date('I'));
                                                                                                                                                                                                                                          print "&nbsp;$hora&nbsp;";
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function CargarMapaNavegacion()
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          $RegContenido = mysqli_fetch_object(VerContenido("MapaNavegacion"));
                                                                                                                                                                                                                                          echo $RegContenido->contenido;
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function CargarFormulario()
                                                                                                                                                                                                                                        { ?>
  <form action="/gracias-por-contactarnos" class="formulario3" enctype="multipart/form-data" method="post" onsubmit="return validate1(this)">
    <h2>Contáctenos</h2>
    <input id="ciudad" name="ciudad" type="hidden" value="1" />
    <label>Nombre*</label>
    <input type="text" name="nombre" maxlength="255" placeholder="Nombre" class="mitad" />
    <input type="text" name="apellido" maxlength="255" placeholder="Apellido" class="mitad" />
    <label>Correo Electrónico*</label>
    <input type="email" maxlength="100" name="mail" required placeholder="myname@example.com" />
    <label>Teléfono*</label>
    <input type="tel" maxlength="100" name="telefono" required pattern="\d+" />
    <label>País*</label>
    <input type="text" maxlength="255" name="pais" required />
    <label>Empresa*</label>
    <input type="text" maxlength="255" name="empresa" required />
    <label>Cargo</label>
    <input type="text" maxlength="100" name="cargo" />
    <label># de Empleados*</label>
    <select name="empleados" required>
      <option value="Menos de 8"> Menos de 8 </option>
      <option value="8 - 20"> 8 - 20 </option>
      <option value="21 - 60"> 21 - 60 </option>
      <option value="61 - 100"> 61 - 100 </option>
      <option value="100 - +"> 100 - + </option>
    </select>
    <p class="antispam">Dejar este campo vacio: <input type="text" name="url" /></p>
    <label>Comentarios*</label>
    <textarea id="textarea" name="comentarios" rows="2" required></textarea><br />
    <input class="action-button" id="cmdEnviar" name="Submit" type="submit" value="Enviar" size="100" />
  </form>

<?php
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function array_unique_compact($a)
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          $tmparr = array_unique($a);
                                                                                                                                                                                                                                          $newarr = array_values($tmparr);
                                                                                                                                                                                                                                          return $newarr;
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function SocialMedia()
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          include("../admin/vargenerales.php");
                                                                                                                                                                                                                                          $facebook = mysqli_fetch_object(VerContenido("TabFacebook"));
                                                                                                                                                                                                                                          $twitter = mysqli_fetch_object(VerContenido("TabTwitter"));
                                                                                                                                                                                                                                          $youtube = mysqli_fetch_object(VerContenido("TabYoutube"));
                                                                                                                                                                                                                                          $social = '<div id="social">
            <ul class="tabs">
                <li class="facebook"><img src="' . $cRutaVerImgContenidos . $facebook->imagen . '" /></li>
                <li class="twitter"><img src="' . $cRutaVerImgContenidos . $twitter->imagen . '" /></li>
                <li class="youtube"><img src="' . $cRutaVerImgContenidos . $youtube->imagen . '" /></li>
            </ul>
            <ul id="content">
              <li class="facebook">' . $facebook->contenido . '</li>
                <li class="twitter">' . $twitter->contenido . '</li>
                <li class="youtube">' . $youtube->contenido . '</li>
            </ul>
      </div>';
                                                                                                                                                                                                                                          echo $social;
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function CargarServicio($url)
                                                                                                                                                                                                                                        {

                                                                                                                                                                                                                                          $nConexion = Conectar();
                                                                                                                                                                                                                                          $rsResultado = mysqli_query($nConexion, "SELECT * FROM tblservicios WHERE (url = '$url') AND (publicar = 'S')");
                                                                                                                                                                                                                                          mysqli_close($nConexion);
                                                                                                                                                                                                                                          return $rsResultado;
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function CargarNoticia($url)
                                                                                                                                                                                                                                        {

                                                                                                                                                                                                                                          $nConexion = Conectar();
                                                                                                                                                                                                                                          $rsResultado = mysqli_query($nConexion, "SELECT * FROM tblnoticias WHERE (url = '$url') AND (publicar = 'S')");
                                                                                                                                                                                                                                          mysqli_close($nConexion);
                                                                                                                                                                                                                                          return $rsResultado;
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function CargarBoletin($url)
                                                                                                                                                                                                                                        {

                                                                                                                                                                                                                                          $nConexion = Conectar();
                                                                                                                                                                                                                                          $rsResultado = mysqli_query($nConexion, "SELECT * FROM tblboletinesprensa WHERE (url = '$url') AND (publicar = 'S')");
                                                                                                                                                                                                                                          mysqli_close($nConexion);
                                                                                                                                                                                                                                          return $rsResultado;
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function CargarAgenda($url)
                                                                                                                                                                                                                                        {

                                                                                                                                                                                                                                          $nConexion = Conectar();
                                                                                                                                                                                                                                          $rsResultado = mysqli_query($nConexion, "SELECT * FROM tblagendas WHERE (url = '$url') AND (publicar = 'S')");
                                                                                                                                                                                                                                          mysqli_close($nConexion);
                                                                                                                                                                                                                                          return $rsResultado;
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function CargarOfertasemana($url)
                                                                                                                                                                                                                                        {

                                                                                                                                                                                                                                          $nConexion = Conectar();
                                                                                                                                                                                                                                          $rsResultado = mysqli_query($nConexion, "SELECT * FROM tblofertasemana WHERE (url = '$url') AND (publicar = 'S')");
                                                                                                                                                                                                                                          mysqli_close($nConexion);
                                                                                                                                                                                                                                          return $rsResultado;
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function CargarEmpsemana($url)
                                                                                                                                                                                                                                        {

                                                                                                                                                                                                                                          $nConexion = Conectar();
                                                                                                                                                                                                                                          $rsResultado = mysqli_query($nConexion, "SELECT * FROM tblempsemana WHERE (url = '$url') AND (publicar = 'S')");
                                                                                                                                                                                                                                          mysqli_close($nConexion);
                                                                                                                                                                                                                                          return $rsResultado;
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function CargarEvento($url)
                                                                                                                                                                                                                                        {

                                                                                                                                                                                                                                          $nConexion = Conectar();
                                                                                                                                                                                                                                          $rsResultado = mysqli_query($nConexion, "SELECT * FROM tbleventos WHERE (url = '$url') AND (publicar = 'S')");
                                                                                                                                                                                                                                          mysqli_close($nConexion);
                                                                                                                                                                                                                                          return $rsResultado;
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function CargarEditorial($url)
                                                                                                                                                                                                                                        {

                                                                                                                                                                                                                                          $nConexion = Conectar();
                                                                                                                                                                                                                                          $rsResultado = mysqli_query($nConexion, "SELECT * FROM tbleditorial WHERE (url = '$url') AND (publicar = 'S')");
                                                                                                                                                                                                                                          mysqli_close($nConexion);
                                                                                                                                                                                                                                          return $rsResultado;
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function CreditosEstilo()
                                                                                                                                                                                                                                        {
?>
  Design/Frameworks/hosting by <a href="http://www.estilod.com/" target="_blank"><img alt="Estilo y Dise&ntilde;o" src="/fotos/Image/contenidos/logoEstilod.png" style="width: 100px; margin-bottom: -7px; height: 26px;" /></a>
<?php
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function CargarIdServicio($nIdServicio)
                                                                                                                                                                                                                                        {

                                                                                                                                                                                                                                          $nConexion = Conectar();
                                                                                                                                                                                                                                          $rsResultado = mysqli_query($nConexion, "SELECT * FROM tblservicios WHERE (idservicio = $nIdServicio) AND (publicar = 'S')");
                                                                                                                                                                                                                                          mysqli_close($nConexion);
                                                                                                                                                                                                                                          return $rsResultado;
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function getItemsByCategory($sid = 0)
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          $nConexion = Conectar();
                                                                                                                                                                                                                                          $list = array();
                                                                                                                                                                                                                                          $sql = "SELECT idcategoria, nombre FROM tblti_categorias WHERE idcategoria_superior = $sid ORDER BY RAND() LIMIT 1";
                                                                                                                                                                                                                                          $rs = mysqli_query($nConexion, $sql);
                                                                                                                                                                                                                                          while ($obj = mysqli_fetch_object($rs)) {
                                                                                                                                                                                                                                            $list[$obj->nombre] = getItems($obj->idcategoria);
                                                                                                                                                                                                                                          }
                                                                                                                                                                                                                                          return $list;
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function getItems($cid)
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          $nConexion = Conectar();
                                                                                                                                                                                                                                          $list = array();
                                                                                                                                                                                                                                          $sql = "SELECT * FROM tblti_productos  WHERE idcategoria = $cid ORDER BY RAND() LIMIT 1";
                                                                                                                                                                                                                                          $rs = mysqli_query($nConexion, $sql);
                                                                                                                                                                                                                                          while ($obj = mysqli_fetch_object($rs)) {
                                                                                                                                                                                                                                            $list[] = array($obj->idproducto, $obj->nombre, $obj->url);
                                                                                                                                                                                                                                          }
                                                                                                                                                                                                                                          return $list;
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function slug2($str, $replace = array(), $delimiter = '-')
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          if (!empty($replace)) {
                                                                                                                                                                                                                                            $str = str_replace((array)$replace, ' ', $str);
                                                                                                                                                                                                                                          }

                                                                                                                                                                                                                                          $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
                                                                                                                                                                                                                                          $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
                                                                                                                                                                                                                                          $clean = strtolower(trim($clean, '-'));
                                                                                                                                                                                                                                          $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

                                                                                                                                                                                                                                          return $clean;
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        /* EFP */
                                                                                                                                                                                                                                        function VerSitioConfig($campo)
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          // uso:		echo VerSitioConfig('url_facebook');
                                                                                                                                                                                                                                          $nConexion = Conectar();
                                                                                                                                                                                                                                          $sql = "select $campo from tblsitio limit 1";
                                                                                                                                                                                                                                          $ra = mysqli_query($nConexion, $sql);
                                                                                                                                                                                                                                          $sitioCfg = mysqli_fetch_assoc($ra);

                                                                                                                                                                                                                                          return $sitioCfg[$campo];
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function verContenidoEFP($clave)
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          $nConexion = Conectar();
                                                                                                                                                                                                                                          $sql = "SELECT * FROM tblcontenidos WHERE (clave = '$clave') AND (publicar = 'S')";
                                                                                                                                                                                                                                          $ra = mysqli_query($nConexion, $sql);
                                                                                                                                                                                                                                          $contenido = mysqli_fetch_assoc($ra);

                                                                                                                                                                                                                                          //if($_SESSION["lenguaje"] == "es"){
                                                                                                                                                                                                                                          echo $contenido["contenido"];
                                                                                                                                                                                                                                          //}else{
                                                                                                                                                                                                                                          //  echo $contenido["contenidoEN"];
                                                                                                                                                                                                                                          //}
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function traducir($texto)
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          if (!session_id()) session_start();
                                                                                                                                                                                                                                          $lenguaje = $_SESSION["lenguaje"];

                                                                                                                                                                                                                                          if (!$_SESSION["lenguaje"]) {
                                                                                                                                                                                                                                            $_SESSION["lenguaje"] = "es";
                                                                                                                                                                                                                                          }

                                                                                                                                                                                                                                          $traduccion = $texto;
                                                                                                                                                                                                                                          //if($_SESSION["lenguaje"]!="es"){
                                                                                                                                                                                                                                          $nConexion = Conectar();
                                                                                                                                                                                                                                          mysqli_set_charset($nConexion, 'utf8');

                                                                                                                                                                                                                                          $query = "SELECT * FROM traductor where es like '$texto%' LIMIT 1";

                                                                                                                                                                                                                                          $result = mysqli_query($nConexion, $query);
                                                                                                                                                                                                                                          $row = mysqli_fetch_assoc($result);

                                                                                                                                                                                                                                          $traduccion = "%" . $texto . "%";
                                                                                                                                                                                                                                          if ($row[$lenguaje]) {
                                                                                                                                                                                                                                            $traduccion = $row[$lenguaje];
                                                                                                                                                                                                                                          }
                                                                                                                                                                                                                                          //}

                                                                                                                                                                                                                                          //strtoupper, ucfirst, ucwords, mb_strtoupper 
                                                                                                                                                                                                                                          return ucfirst($traduccion);
                                                                                                                                                                                                                                        }

                                                                                                                                                                                                                                        function getpais()
                                                                                                                                                                                                                                        {
                                                                                                                                                                                                                                          ///////////////////////////////////////////////////////
                                                                                                                                                                                                                                          //		Determina Direccion iP cliente
                                                                                                                                                                                                                                          ///////////////////////////////////////////////////////
                                                                                                                                                                                                                                          if (!empty($_SERVER["HTTP_CLIENT_IP"])) {
                                                                                                                                                                                                                                            //check for ip from share internet
                                                                                                                                                                                                                                            $p_ip = $_SERVER["HTTP_CLIENT_IP"];
                                                                                                                                                                                                                                          } elseif (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
                                                                                                                                                                                                                                            // Check for the Proxy User
                                                                                                                                                                                                                                            $p_ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
                                                                                                                                                                                                                                          } else {
                                                                                                                                                                                                                                            $p_ip = $_SERVER["REMOTE_ADDR"];
                                                                                                                                                                                                                                          }

                                                                                                                                                                                                                                          //  $p_ip      = $_SERVER['REMOTE_ADDR'];

                                                                                                                                                                                                                                          $p_ips = explode(',', $p_ip);  #varios valores separados por coma
                                                                                                                                                                                                                                          $p_ip = $p_ips[0];        #Primer valor de ip
                                                                                                                                                                                                                                          $p_ipa = $p_ips[0] . "," . $p_ips[1];        #2 valor de ip


                                                                                                                                                                                                                                          $context = stream_context_create(array(
                                                                                                                                                                                                                                            'http' => array(
                                                                                                                                                                                                                                              'timeout' => 10   // Timeout in seconds
                                                                                                                                                                                                                                            )
                                                                                                                                                                                                                                          ));

                                                                                                                                                                                                                                          ///////////////////////////////////////////////////////
                                                                                                                                                                                                                                          //		Determina isp a partir de ip (ip-api.com)
                                                                                                                                                                                                                                          ///////////////////////////////////////////////////////
                                                                                                                                                                                                                                          // http://ip-api.com/docs/unban

                                                                                                                                                                                                                                          // 45 x min
                                                                                                                                                                                                                                          //$url = 'http://ip-api.com/json/'.$p_ip;
                                                                                                                                                                                                                                          // 10000 x mes
                                                                                                                                                                                                                                          $url = 'http://api.ipstack.com/' . $p_ip . '?access_key=14ef92677343180fd9011375f87fa6e4';

                                                                                                                                                                                                                                          $query = json_decode(file_get_contents($url, 0, $context));

                                                                                                                                                                                                                                          $p_codepais = "CO"; // Default
                                                                                                                                                                                                                                          if ($query) {
                                                                                                                                                                                                                                            //$p_codepais	= $query->countryCode;
                                                                                                                                                                                                                                            $p_codepais  = $query->country_code;
                                                                                                                                                                                                                                          }

                                                                                                                                                                                                                                          //$p_codepais = "US"; // Forzar Pais
                                                                                                                                                                                                                                          //var_dump($p_codepais);

                                                                                                                                                                                                                                          $_SESSION["pais"] = trim($p_codepais);

                                                                                                                                                                                                                                          return $p_codepais;
                                                                                                                                                                                                                                        }

?>