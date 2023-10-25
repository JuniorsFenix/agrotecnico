<?php
	require_once("../include/connect.php");
    $nConexion = Conectar();
	$departamento = $_POST["departamentoId"];
    $sql="select name from cities where state_id=$departamento";
    $ciudades = mysqli_query($nConexion,$sql);
	 while($rax=mysqli_fetch_assoc($ciudades)):?>
    <option value='<?php echo "$rax[name]";?>'><?php echo "$rax[name]";?></option>
    <?php endwhile;?>