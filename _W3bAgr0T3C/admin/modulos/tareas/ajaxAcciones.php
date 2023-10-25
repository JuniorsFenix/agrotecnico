<?php
  require_once("include/funciones.php");
	
	$check=checkAcciones($_POST['categoria']);
	$acciones = accionesQuery();
	$usuarios = usuariosQuery();

	foreach ($acciones as $r): ?>
	<label class="checkbox">
		<?php echo $r["accion"]; ?><input name="acciones[]" value="<?php echo $r["id"]; ?>" type="checkbox" <?=in_array($r['id'],$check)?"checked":"";?>><br>
		<select name="usuario<?php echo $r["id"]; ?>" style="width: 450px;">
			<?php foreach ($usuarios as $r): ?>
				<option value="<?php echo $r["idusuario"]; ?>"><?php echo $r["nombres"]; ?></option>
			<?php endforeach; ?>
		</select>
	</label>
<?php endforeach; ?>
<script type="text/javascript">
	$('.checkbox input:checked').each(function(i, e) {
		var select = "select[name='usuario"+$(this).val()+"']";
		$( select ).toggle("fast");
	});
</script>