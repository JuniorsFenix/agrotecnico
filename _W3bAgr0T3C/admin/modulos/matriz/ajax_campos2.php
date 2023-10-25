<?php
include("../../funciones_generales.php");

function opciones($idCampo) {
	$nConexion    = Conectar();
	$opciones    = mysqli_query($nConexion, "SELECT * FROM campos_opciones WHERE idcampo = $idCampo ORDER BY id ASC" );
	return $opciones;
}

if($_POST["id"]){
	if($_POST["id"]!=0){
		$nConexion    = Conectar();
		if($_POST["tipo"]==2){
		$campos    = mysqli_query($nConexion, "SELECT * FROM campos_form WHERE idform = {$_POST["id"]} ORDER BY idcampo ASC" );
		$i = 01;
		 while($r = mysqli_fetch_assoc($campos)): ?>
		<div class="draggableField ui-draggable droppedField" id="10<?php echo $i;?>">
			<label class="control-label"><?php echo $r["campo"];?></label>
			<?php if($r["tipo"]=="textarea"){ ?>
			<textarea class="ctrl-textarea" placeholder="<?php echo $r["campo"];?>" name="<?php echo $r["campo"];?>"></textarea>
			<?php } elseif($r["tipo"]=="text"){ ?> 
			<input class="ctrl-textbox" type="<?=$r["tipo"];?>" placeholder="<?php echo $r["campo"];?>" name="<?php echo $r["campo"];?>"></input>
			<?php } elseif($r["tipo"]=="select"){ ?> 
            <select multiple="multiple" class="ctrl-combobox" name="<?php echo $r["campo"];?>[]">
			<?php $opciones    = opciones($r["idcampo"]);
			while($select = mysqli_fetch_assoc($opciones)): ?> 
                <option value="<?php echo $select["opcion"];?>"><?php echo $select["opcion"];?></option>
	   		<?php endwhile; ?>
            </select> Una respuesta
			<?php } elseif($r["tipo"]=="file"){ ?> 
			<input class="ctrl-file" type="<?php echo $r["tipo"];?>" name="<?php echo $r["campo"];?>">
			<?php } elseif($r["tipo"]=="radio"){ ?>
            <div class="ctrl-radiogroup" style="display: inline-block; z-index: 29;">
				<?php $opciones    = opciones($r["idcampo"]);
				$o=0;
                while($radio = mysqli_fetch_assoc($opciones)): ?> 
                    <label class="radio"><input name="<?php echo "{$r["campo"]}[$o]";?>" value="<?php echo $radio["opcion"];?>" type="<?php echo $r["tipo"];?>"><?php echo $radio["opcion"];?></label>
                <?php $o++; endwhile; ?>
            </div>
			<?php } elseif($r["tipo"]=="checkbox"){ ?>
            <div class="ctrl-checkboxgroup" style="display: inline-block; z-index: 29;">
				<?php $opciones    = opciones($r["idcampo"]);
                while($check = mysqli_fetch_assoc($opciones)): ?> 
                    <label class="checkbox"><input name="<?php echo $r["campo"];?>[]" value="<?php echo $check["opcion"];?>" type="<?php echo $r["tipo"];?>"><?php echo $check["opcion"];?></label>
                <?php endwhile; ?>
            </div>
			<?php } elseif($r["tipo"]=="multiple"){ ?>
            <div style="display: inline-block; z-index: 29;">
            	<select class="ctrl-selectmultiplelist" multiple="multiple" name="<?php echo $r["campo"];?>[]" style="width:230px">
				<?php $opciones    = opciones($r["idcampo"]);
                while($multiple = mysqli_fetch_assoc($opciones)): ?> 
                    <option value="<?php echo $multiple["opcion"];?>"><?php echo $multiple["opcion"];?></option>
                <?php endwhile; ?>
                </select> Multiples respuestas
            </div>
			<?php } else { ?> 
			<input type="<?=$r["tipo"];?>" placeholder="<?php echo $r["campo"];?>" class="ctrl-textbox" name="<?php echo $r["campo"];?>"></input>
			<?php  } ?>   		
            <input type="hidden" name="type[]" value="<?=$r["tipo"];?>"/>
		</div>
	   <?php $i++;
	   endwhile;
		}elseif($_POST["tipo"]==1){
			$campos    = mysqli_query($nConexion, "SELECT * FROM campos ca JOIN campos_matriz cm on (ca.campo=cm.campo) WHERE cm.idmatriz = {$_POST["id"]} ORDER BY cm.id ASC" );
			$i = 01;
             while($r = mysqli_fetch_assoc($campos)): ?>
            <div class="draggableField ui-draggable droppedField" id="10<?php echo $i;?>" data-index="<?php echo $r["idcampo"];?>">
        		<label class="control-label"><?php echo $r["campo"];?></label>
				<?php if($r["tipo"]=="textarea"){ ?>
                <textarea class="ctrl-textarea" placeholder="<?php echo $r["campo"];?>" name="<?php echo $r["campo"];?>"></textarea>
				<?php } else { ?> 
                <input type="<?=$r["tipo"];?>" placeholder="<?php echo $r["campo"];?>" class="ctrl-textbox" name="<?php echo $r["campo"];?>"></input>
            	<?php  } ?>
				<button class="btn btn-danger btn-content" aria-hidden="true">Delete</button>
            </div>
           <?php $i++;
		   endwhile;
		}
	} 
}
?>