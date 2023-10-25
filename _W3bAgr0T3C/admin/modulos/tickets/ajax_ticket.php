<?php
require_once("../../funciones_generales.php");
if($_POST['id'])
{
$id=$_POST['id'];
$nConexion = Conectar();
$sql=mysqli_query($nConexion,"select * from tblusuarios_externos where idusuario='$id'");

while($row=mysqli_fetch_array($sql))
{
$correo=$row['correo_electronico'];
echo '<option value="'.$correo.'">'.$correo.'</option>';

}
}
?>