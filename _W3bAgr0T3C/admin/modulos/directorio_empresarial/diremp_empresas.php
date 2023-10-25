<?php

include("../../herramientas/FCKeditor/fckeditor.php");

include("../../herramientas/seguridad/seguridad.php");

include("diremp_empresas_funciones.php");

include("../../herramientas/upload/uploaderFunction.php");

include("../../vargenerales.php");

if (!isset($_GET["Accion"])) { // Si no se envio la accion muestro la lista

    header("Location: diremp_empresas_listar.php");

}

?>

<html>

    <head>

        <title>Administraci&oacute;n de Empresas Directorio Empresarial</title>

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
<script src="../../herramientas/ckeditor/ckeditor.js"></script>



    </head>

    <body>

        <? include("../../system_menu.php"); ?><br>

        <?php

        /* Determinar si viene el parametro que establece una accion:

          Adicionar  = Nuevo Registro

          Editar     = Editar Registro

          Eliminar   = Eliminar Registro

          Si no esta determinada la variable accion entonces se muestra la grilla con los registros

         */

        switch ($_GET["Accion"]) {

            case "Adicionar":

                dirempEmpresasFormNuevo();

                break;

            case "Editar":

                dirempEmpresasFormEditar($_GET["Id"]);

                break;

            case "Eliminar":

                dirempEmpresasEliminar($_GET["Id"]);

                break;

            case "Importar":

                dirempEmpresasImportar();

                break;

            case "ProcesarImportacion":

                dirempEmpresasProcesarImportacion($_FILES["archivo"]["tmp_name"]);

                break;

            case "Guardar":

                $prefijo = $_POST["txtId"];



                

                $ArchivoImg = $_FILES['imagen']['name'][0];



                $NomImagen = "*"; // * Indica que no se asigno un archivo



                if (!empty($ArchivoImg)) {

                    $_FILES['imagen']['name'][0] = ($prefijo==0?dirempEmpresasNextId():$prefijo)."_".$_FILES['imagen']['name'][0];

                    $tipos = array("image/png", "image/jpeg", "image/gif", "image/pjpeg", "application/x-shockwave-flash");

                    $size = 400000;

                    $Campofile = "imagen";

                    $folder = $cRutaImagenDirEmp;

                    if (uploader($Campofile, $folder, $size, $tipos)) {

                        foreach ($uploader_archivos_copiados as $imagen => $detalles) {

                            $NomImagen = $imagen;

                        }

                    }

                }

                $pendiente_revision = isset($_POST["pendiente_revision"])?$_POST["pendiente_revision"]:"";

                dirempEmpresasGuardar($_POST["txtId"], $_POST["nombre"], $_POST["sector_comercial"], $_POST["valor_minimo"], $_POST["valor_maximo"],

                        $_POST["descripcion"], $_POST["direccion"], $_POST["telefono"], $_POST["codigo_zona"], $_POST["correo_electronico"],

                        $_POST["url_web"], $NomImagen, $_POST["codigo_categoria"],$_POST["activo"],$pendiente_revision);

                break;

            default:

                header("Location: diremp_empresas_listar.php");

                break;

        }

        ?>

    </body>

</html>



