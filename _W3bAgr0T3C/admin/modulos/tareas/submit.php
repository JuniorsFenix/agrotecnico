<?php
	include_once("templates/includes.php");
	global $db;
	$query = "SELECT * from usuarios";
if(isset($_POST['query'])){
  $query.= " WHERE lower(concat(nombre, '', apellido)) like lower('%{$_POST["query"]}%')";
}
  $query.= " ORDER BY apellido";
	$usuarios = $db->query($query);

            foreach($usuarios as $row) {
            ?>
            <li>
                <a class="imagenUsuario" href="/<?php echo $sitioCfg["carpeta"]; ?>/usuarios/<?php echo $row['id']; ?>">
                    <?php if($row["foto"]!=""){ ?>
                    <img src="<?php echo "/$sitioCfg[carpeta]/fotos/perfiles/$row[foto]"; ?>" alt="<?php echo "$row[apellido] $row[nombre]"; ?>"/>
                    <?php } else { ?>
                    <img src="<?php echo "/$sitioCfg[carpeta]/fotos/perfiles/$row[sexo].png"; ?>" alt="<?php echo $row["sexo"]; ?>"/>
                    <?php } ?>
                </a>
                <div class="infoUsuario">
                    <a class="nombreUsuario" href="/<?php echo $sitioCfg["carpeta"]; ?>/usuarios/<?php echo $row['id']; ?>"><?php echo "$row[apellido] $row[nombre]"; ?></a>
                    <?php echo $row['cargo']; ?>
                    <a class="nombreUsuario" href="/<?php echo $sitioCfg["carpeta"]; ?>/usuarios/<?php echo $row['id']; ?>">Ver muro</a>
                </div>
            </li>
            <?php
                }
            ?>