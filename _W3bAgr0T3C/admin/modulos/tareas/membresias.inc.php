<?php

class Membresias {

    public static function membresiaCargar() {

        if ($_SESSION["idmembresia"] == 0) {
            return false;
        }

		global $db;

	$stmt = $db->prepare("UPDATE tblmb_categorias SET nombre=:categoria WHERE idcategoria=:id");	
	$stmt->bindValue(':categoria', $d["nombre"], PDO::PARAM_STR);
	$stmt->bindValue(':id', $d["idcategoria"], PDO::PARAM_INT);
	
        $stmt = $db->prepare("SELECT * FROM tblmb_membresias where idmembresia=:idmembresia");
        $stmt->bindValue(":idmembresia", $_SESSION["idmembresia"], PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() == 0) {
            return false;
        }

        return $stmt->fetch();
    }

    public static function contenidosCargar($p = array()) {
        $result = array();

        if ($_SESSION["idmembresia"] == 0) {
            return $result;
        }

	global $db;

        $stmt = $db->prepare("SELECT a.* FROM tblmb_categorias a join tblmb_membresias_categorias b on (a.idcategoria=b.idcategoria) WHERE a.estado='activo' and b.idmembresia=:idmembresia limit 6");
        $stmt->bindValue(":idmembresia", $_SESSION["idmembresia"], PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetchAll();
        $count = count($result);
        for ($i = 0; $i < $count; $i++) {
            $stmt = $db->prepare("SELECT a.idcontenido,a.nombre,imagen,substr(a.contenido,1,200) as contenido FROM tblmb_contenidos a join tblmb_contenidos_categorias b on (a.idcontenido=b.idcontenido) join tblmb_membresias_categorias c on (b.idcategoria=c.idcategoria) WHERE b.idcategoria = :idcategoria and a.tipo='contenido' and a.estado=1 and c.idmembresia=:idmembresia ORDER BY a.fecha_publicacion desc limit 1");
            $stmt->bindValue(":idcategoria", $result[$i]["idcategoria"], PDO::PARAM_INT);
            $stmt->bindValue(":idmembresia", $_SESSION["idmembresia"], PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() == 0) {
                unset($result[$i]);
                continue;
            }
            $result[$i]["contenidos"] = $stmt->fetchAll();
        }
        return $result;
    }
	
	    public static function videosCargar($p = array()) {
        $result = array();

        if ($_SESSION["idmembresia"] == 0) {
            return $result;
        }

	global $db;

        $stmt = $db->prepare("SELECT a.* FROM tblmb_categorias a join tblmb_membresias_categorias b on (a.idcategoria=b.idcategoria) WHERE a.estado='activo' and b.idmembresia=:idmembresia limit 6");
        $stmt->bindValue(":idmembresia", $_SESSION["idmembresia"], PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetchAll();
        $count = count($result);
        for ($i = 0; $i < $count; $i++) {
            $stmt = $db->prepare("SELECT a.id_video,a.titulo,a.url,substr(a.descripcion,1,200) as contenido FROM videos a join tblmb_videos_categorias b on (a.id_video=b.idvideo) join tblmb_membresias_categorias c on (b.idcategoria=c.idcategoria) WHERE b.idcategoria = :idcategoria and a.activo=1 and c.idmembresia=:idmembresia limit 1");
            $stmt->bindValue(":idcategoria", $result[$i]["idcategoria"], PDO::PARAM_INT);
            $stmt->bindValue(":idmembresia", $_SESSION["idmembresia"], PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() == 0) {
                unset($result[$i]);
                continue;
            }
            $result[$i]["contenidos"] = $stmt->fetchAll();
        }
        return $result;
    }


    public static function contenidoCargar($p) {
        if (!isset($p["idcategoria"]) || $p["idcategoria"] == "") {
            return false;
        }
        if (!isset($p["idcontenido"]) || $p["idcontenido"] == "") {
            return false;
        }
        if ($_SESSION["idmembresia"] == 0) {
            return false;
        }
	global $db;

        $campos = "a.nombre,a.contenido,c.nombre as categoria,a.archivo,a.imagen,a.fecha_publicacion,a.url_informacion";
        $stmt = $db->prepare("SELECT $campos FROM tblmb_contenidos a join tblmb_contenidos_categorias b on (a.idcontenido=b.idcontenido and b.idcategoria=:idcategoria)
                join tblmb_categorias c on (b.idcategoria=c.idcategoria)
                join tblmb_membresias_categorias d on (c.idcategoria=d.idcategoria) WHERE a.idcontenido=:idcontenido and a.estado=1 and d.idmembresia=:idmembresia");
        $stmt->bindValue(":idcategoria", $p["idcategoria"], PDO::PARAM_INT);
        $stmt->bindValue(":idcontenido", $p["idcontenido"], PDO::PARAM_INT);
        $stmt->bindValue(":idmembresia", $_SESSION["idmembresia"], PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() == 0) {
            return false;
        }

        return $stmt->fetch();
    }

    public static function archivosCargar($p = array()) {
        $result = array();

        if ($_SESSION["idmembresia"] == 0) {
            return $result;
        }

	global $db;

        $stmt = $db->prepare("SELECT a.* FROM tblmb_categorias a join tblmb_membresias_categorias b on (a.idcategoria=b.idcategoria) WHERE a.estado='activo' and b.idmembresia=:idmembresia ORDER BY rand() limit 5");
        $stmt->bindValue(":idmembresia", $_SESSION["idmembresia"], PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetchAll();
        $count = count($result);
        for ($i = 0; $i < $count; $i++) {
            $stmt = $db->prepare("SELECT a.* FROM tblmb_contenidos a join tblmb_contenidos_categorias b on (a.idcontenido=b.idcontenido)
                    join tblmb_membresias_categorias c on (b.idcategoria=c.idcategoria) WHERE b.idcategoria=:idcategoria and a.tipo='archivo' and a.estado=1 and c.idmembresia=:idmembresia ORDER BY a.fecha_publicacion desc limit 4");
            $stmt->bindValue(":idcategoria", $result[$i]["idcategoria"], PDO::PARAM_INT);
            $stmt->bindValue(":idmembresia", $_SESSION["idmembresia"], PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->rowCount() == 0) {
                unset($result[$i]);
                continue;
            }
            $result[$i]["archivos"] = $stmt->fetchAll();
        }


        return array_unique($result);
    }

    public static function archivosAleatorios($p) {
        $limit = isset($p["limit"]) ? $p["limit"] : "6";
        $result = array();
        if ($_SESSION["idmembresia"] == 0) {
            return $result;
        }
	global $db;

        $stmt = $db->prepare("SELECT a.idcontenido FROM tblmb_contenidos a join tblmb_contenidos_categorias b on (a.idcontenido=b.idcontenido) join tblmb_membresias_categorias c on (b.idcategoria=c.idcategoria) WHERE a.estado=1 and a.tipo='archivo' and c.idmembresia=:idmembresia ORDER BY rand() limit {$limit}");
        $stmt->bindValue(":idmembresia", $_SESSION["idmembresia"], PDO::PARAM_INT);
        $stmt->execute();
        $rContenidos = $stmt->fetchAll();
        foreach ($rContenidos as $r) {
            $stmt = $db->prepare("SELECT a.*,b.idcategoria FROM tblmb_contenidos a join tblmb_contenidos_categorias b on (a.idcontenido=b.idcontenido)
                    join tblmb_membresias_categorias c on (b.idcategoria=c.idcategoria) WHERE a.idcontenido=:idcontenido and c.idmembresia=:idmembresia limit 1");
            $stmt->bindValue(":idcontenido", $r["idcontenido"], PDO::PARAM_INT);
            $stmt->bindValue(":idmembresia", $_SESSION["idmembresia"], PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() == 0)
                continue;
            $result[] = $stmt->fetch();
        }

        return $result;
    }

    public static function contenidosAleatorios($p) {
        $limit = isset($p["limit"]) ? $p["limit"] : "6";
        $result = array();
        if ($_SESSION["idmembresia"] == 0) {
            return $result;
        }
	global $db;

        $stmt = $db->prepare("SELECT a.idcontenido FROM tblmb_contenidos a join tblmb_contenidos_categorias b on (a.idcontenido=b.idcontenido)
                join tblmb_membresias_categorias c on (b.idcategoria=c.idcategoria) WHERE a.estado=1 and a.tipo='contenido' and c.idmembresia=:idmembresia ORDER BY rand() limit {$limit}");
        $stmt->bindValue(":idmembresia", $_SESSION["idmembresia"], PDO::PARAM_INT);
        $stmt->execute();
        $rContenidos = $stmt->fetchAll();
        foreach ($rContenidos as $r) {
            $stmt = $db->prepare("SELECT a.*,b.idcategoria FROM tblmb_contenidos a join tblmb_contenidos_categorias b on (a.idcontenido=b.idcontenido)
                    join tblmb_membresias_categorias c on (b.idcategoria=c.idcategoria) WHERE a.idcontenido=:idcontenido and c.idmembresia=:idmembresia limit 1");
            $stmt->bindValue(":idcontenido", $r["idcontenido"], PDO::PARAM_INT);
            $stmt->bindValue(":idmembresia", $_SESSION["idmembresia"], PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->rowCount() == 0)
                continue;
            $result[] = $stmt->fetch();
        }

        return $result;
    }

    public static function categoriaCargarArchivos($p) {
        $result = array();
        if ($_SESSION["idmembresia"] == 0) {
            return $result;
        }
	global $db;

        $stmt = $db->prepare("SELECT a.* FROM tblmb_categorias a join tblmb_membresias_categorias b on (a.idcategoria=b.idcategoria) WHERE a.idcategoria=:idcategoria and a.estado='activo' and b.idmembresia=:idmembresia");
        $stmt->bindValue(":idcategoria", $p["idcategoria"], PDO::PARAM_INT);
        $stmt->bindValue(":idmembresia", $_SESSION["idmembresia"], PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() == 0) {
            return false;
        }

        $result["enc"] = $stmt->fetch();


        $stmt = $db->prepare("SELECT a.idcontenido,a.nombre,a.fecha_publicacion FROM tblmb_contenidos a join tblmb_contenidos_categorias b on (a.idcontenido=b.idcontenido)
                join tblmb_membresias_categorias c on (b.idcategoria=c.idcategoria) WHERE b.idcategoria=:idcategoria and a.tipo='archivo' and estado='activo' and c.idmembresia=:idmembresia ORDER BY a.fecha_publicacion");
        $stmt->bindValue(":idcategoria", $p["idcategoria"], PDO::PARAM_INT);
        $stmt->bindValue(":idmembresia", $_SESSION["idmembresia"], PDO::PARAM_INT);
        $result["page"] = $stmt->execPage($p["pager"]);

        return $result;
    }

    public static function categoriaCargarContenidos($p) {
        $result = array();
        if ($_SESSION["idmembresia"] == 0) {
            return $result;
        }
	global $db;

        $stmt = $db->prepare("SELECT a.* FROM tblmb_categorias a join tblmb_membresias_categorias b on (a.idcategoria=b.idcategoria) WHERE a.idcategoria=:idcategoria and a.estado='activo' and b.idmembresia=:idmembresia");
        $stmt->bindValue(":idcategoria", $p["idcategoria"], PDO::PARAM_INT);
        $stmt->bindValue(":idmembresia", $_SESSION["idmembresia"], PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() == 0) {
            return false;
        }

        $result["enc"] = $stmt->fetch();


        $stmt = $db->prepare("SELECT a.idcontenido,a.nombre,imagen,substr(a.contenido,1,200) as contenido FROM tblmb_contenidos a join tblmb_contenidos_categorias b on (a.idcontenido=b.idcontenido)
                join tblmb_membresias_categorias c on (b.idcategoria=c.idcategoria) WHERE b.idcategoria=:idcategoria and a.tipo='contenido' and estado='activo' and c.idmembresia=:idmembresia ORDER BY a.fecha_publicacion");
        $stmt->bindValue(":idcategoria", $p["idcategoria"], PDO::PARAM_INT);
        $stmt->bindValue(":idmembresia", $_SESSION["idmembresia"], PDO::PARAM_INT);
        $result["page"] = $stmt->execPage($p["pager"]);

        return $result;
    }

}

?>
