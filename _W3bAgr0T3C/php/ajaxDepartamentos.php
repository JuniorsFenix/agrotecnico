<?php
	require_once("../include/connect.php");
    $nConexion = Conectar();
	$sql="select id,state from states where country_id={$_POST['categoria']} order by state";
	$ra = mysqli_query($nConexion,$sql); ?>
	<?php while($rax=mysqli_fetch_assoc($ra)):?>
	<option value="<?=$rax["state"];?>"><?=$rax["state"];?></option>
	<?php endwhile;?>