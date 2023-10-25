<?php
require_once("../../herramientas/seguridad/seguridad.php");
require_once("tickets_funciones.php");
require_once("../../vargenerales.php");
if (!isset($_GET["Accion"])) { // Si no se envio la accion muestro la lista
    header("Location: tickets_listar.php");
}
		error_reporting(E_ALL ^E_WARNING);
?>
<html>
    <head>
        <title>Administración de Tickes - Tickets</title>
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
        <?php 
        require_once("../../system_menu.php"); ?>
        <br/>
        <?php
        switch ($_GET["Accion"]) {
            case "Ver":
                TicketsVer($_GET["Id"]);
                break;
            case "Responder":
                TicketsResponder($_POST["txtId"], $_POST["mensaje"], $_POST["estado"], $_FILES["adjunto"]);
                break;
            case "CerrarTicket":
                TicketsCerrarTicket($_GET["idticket"]);
                break;
            case "Nuevo":
                TicketsNuevo($_GET["Id"]);
                break;
            case "Exportar":
                TicketsExportar($_GET["idempresa"], $_GET["idregion"], $_GET["idzona"], $_GET["idsede"], $_GET["tipo"], $_GET["filtro"]);
                break;
            default:
                header("Location: tickets_listar.php");
                break;
        }
        ?>
    </body>
</html>
