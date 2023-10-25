<?php
include("../../funciones_generales.php");

if($_POST['tipo'])
{

if($_POST['tipo']==1){ 
	$nConexion    = Conectar();
	$Resultado    = mysqli_query($nConexion, "SELECT * FROM campos" );?>
	  <div class="tab-pane active" id="simple">
            <?php while($r = mysqli_fetch_assoc($Resultado)): ?>
            <div class="selectorField draggableField"  data-index="<?php echo $r["idcampo"];?>">
                <label class="control-label"><?=$r["campo"];?></label>
				<?php if($r["tipo"]=="textarea"){ ?>     
                <textarea class="ctrl-textarea" placeholder="<?=$r["campo"];?>" name="<?=$r["campo"];?>"></textarea>
				<?php } else { ?>     
                <input type="<?=$r["tipo"];?>" placeholder="<?=$r["campo"];?>" class="ctrl-textbox" name="<?=$r["campo"];?>"></input>
            	<?php  } ?>
            </div>
           <?php endwhile; ?>
	  </div>

<?php 
}elseif($_POST['tipo']==2){ ?>
	<ul class="nav nav-tabs">
		<li class="active">
			<a href="#simple" data-toggle="tab">Campos simples</a>
		</li>
		<li>
			<a href="#multiple" data-toggle="tab">Radio/Checkbox/List</a>
		</li>
	</ul>
	  <div class="tab-pane active" id="simple">
		<div class='selectorField draggableField'>
			<label class="control-label">Campo de texto</label>
			<input type="text" placeholder="Texto aquí..." class="ctrl-textbox" name="TextInput"></input>
      		<input type="hidden" name="type[]" value="text"/>
		</div>
		<div class='selectorField draggableField'>
			<label class="control-label">Correo</label>
			<input type="email" placeholder="Correo" class="ctrl-passwordbox" name="Correo"></input>
      		<input type="hidden" name="type[]" value="email"/>
		</div>
		<div class='selectorField draggableField'>
			<label class="control-label">Selección</label>
			<select multiple="multiple" class="ctrl-combobox" name="Combobox[]">
				<option value="option1">Opción 1</option>
				<option value="option2">Opción 2</option>
				<option value="option3">Opción 3</option>
			</select> Una respuesta
      		<input type="hidden" name="type[]" value="select"/>
		</div>
		<div class='selectorField draggableField'>
			<label class="control-label">Area de texto</label>
			<textarea class="ctrl-textarea" placeholder="Area de texto" name="Textarea"></textarea>
      		<input type="hidden" name="type[]" value="textarea"/>
		</div>
		<div class='selectorField draggableField'>
			<label class="control-label">Archivo</label>
			<input type="file" class="ctrl-file" name="File">
      		<input type="hidden" name="type[]" value="file"/>
		</div>
	  </div>
	  
	  <div class="tab-pane" id="multiple">
		<div class='selectorField draggableField radiogroup'>
			<label class="control-label" style="vertical-align:top">Radio buttons</label>
			<div style="display:inline-block;" class="ctrl-radiogroup">
				<label class="radio"><input type="radio" name="radioField[0]" value="option1">Option 1</input></label>
				<label class="radio"><input type="radio" name="radioField[1]" value="option2">Option 2</input></label>
				<label class="radio"><input type="radio" name="radioField[2]" value="option3">Option 3</input></label>
			</div>
      		<input type="hidden" name="type[]" value="radio"/>
		</div>
		<div class='selectorField draggableField checkboxgroup' >
			<label class="control-label" style="vertical-align:top">Checkboxes</label>
			<div style="display:inline-block;" class="ctrl-checkboxgroup">
				<label class="checkbox"><input type="checkbox" name="checkboxField[]" value="option1">Option 1</input></label>
				<label class="checkbox"><input type="checkbox" name="checkboxField[]" value="option2">Option 2</input></label>
				<label class="checkbox"><input type="checkbox" name="checkboxField[]" value="option3">Option 3</input></label>
			</div>
      		<input type="hidden" name="type[]" value="checkbox"/>
		</div>
		<div class='selectorField draggableField selectmultiple'>
			<label class="control-label" style="vertical-align:top">Select</label>
			<div style="display:inline-block;">
				<select multiple="multiple" name="multiple[]" style="width:150px" class="ctrl-selectmultiplelist">
					<option value="option1">Option 1</option>
					<option value="option2">Option 2</option>
					<option value="option3">Option 3</option>
				</select> Multiples respuestas
			</div>
      		<input type="hidden" name="type[]" value="multiple"/>
		</div>
	  </div>

<?php
}

}
?>