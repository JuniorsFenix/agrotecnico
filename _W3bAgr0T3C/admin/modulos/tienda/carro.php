<?php
require_once dirname(__FILE__)."/../../funciones_generales.php";

class carro {
  var $vcarro="";
  var $vdebug=false;

  function __construct($op=array()){
    if(!session_id()){
      die("No se puede usar el carro sin una sesion");
    }
    $session_id = session_id();
    
    if( isset($op["debug"]) ){
        $this->vdebug=$op["debug"];    
    }

    if( isset($op["carro"]) ){
      $this->vcarro = $op["carro"];
    }

    $nConexion=Conectar();

    if( $this->vcarro){
      $sql="select * from tblti_carro
      where carro={$this->vcarro}
      ";
    }
    else {

      $sql="select * from tblti_carro
      where session_id='{$session_id}'
      and estado='CARRO'
      order by carro desc limit 1
      ";
    }

    $ra = mysqli_query($nConexion,$sql);
    if( !$ra || mysqli_num_rows($ra)==0){
      $sql="insert into tblti_carro (session_id) values ('{$session_id}')";
      $ra = mysqli_query($nConexion,$sql);

      if( !$ra){
        die("Fallo creando carro de compras");
      }

      $this->vcarro = mysqli_insert_id($nConexion);
    }
    else {
      $rax = mysqli_fetch_object($ra);
      $this->vcarro = $rax->carro;
    }

    return;
  }

  function encabezado(){
    $nConexion=Conectar();
    $sql="select * from tblti_carro where carro = {$this->vcarro}";
    $ra = mysqli_query($nConexion,$sql);
    if( !$ra || mysqli_num_rows($ra)==0){
      die("Fallo consultando encabezado del carro {$this->vcarro}");
    }

    return mysqli_fetch_assoc($ra);
  }

  function detalle(){
    $nConexion=Conectar();
    $sql="select * from tblti_carro_detalle
    where carro = {$this->vcarro}
    order by detalle ";

    $ra = mysqli_query($nConexion,$sql);
    if( !$ra ){
      echo mysqli_error($nConexion);
      die("Fallo consultando detalle del carro {$this->vcarro}");
    }

    $r=array();
    while( $rax = mysqli_fetch_Assoc($ra) ){
      $r[] = $rax;
    }
    return $r;
  }

  function updateEncabezado($fields){
    $nConexion=Conectar();
    $sql="update tblti_carro set $fields where carro = {$this->vcarro}";
    $ra = mysqli_query($nConexion,$sql);

    if( !$ra){
      echo $sql;
      die("Fallo actualizando encabezado del carro {$this->vcarro} $fields");
    }
    return true;
  }

  function updateDetalle($fields,$where){
    $nConexion=Conectar();
    $sql="update tblti_carro_detalle set $fields where carro = {$this->vcarro} and {$where}";
    $ra = mysqli_query($nConexion,$sql);

    if( !$ra){
      die("Fallo actualizando detalle del carro {$this->vcarro}");
    }
    return true;
  }

  function add($item,$descripcion,$precio,$unidades,$op=array()){
    $nConexion=Conectar();
    //$op["subtotal"] = (float)$precio * (float)$unidades;
    $op["peso"] = isset($op["peso"]) ? $op["peso"]:0;
    $op["volumen"] = isset($op["volumen"]) ? $op["volumen"]:0;
    $op["extra"] = isset($op["extra"]) ? $op["extra"]:"";



    $sql="select * from tblti_carro_detalle
    where carro={$this->vcarro} and item ='{$item}'";
    $ra = mysqli_query($nConexion,$sql);
    if( mysqli_num_rows($ra) > 0 ){
      $rax = mysqli_fetch_assoc($ra);

      $sql="update tblti_carro_detalle
      set unidades = unidades + $unidades,subtotal = precio * unidades,peso={$op["peso"]},volumen={$op["volumen"]},
      extra = '{$op["extra"]}'
      where detalle = {$rax["detalle"]}";
      $ra = mysqli_query($nConexion,$sql);
      if( !$ra){
        echo mysqli_error($nConexion);
        die("Fallo actualizando unidades en el carro {$this->vcarro} $item");
      }

      $this->actualizarFlete();


      return $rax["detalle"];
    }
    else {
      $sql="insert into tblti_carro_detalle
      (carro,item,descripcion,unidades,precio,subtotal,peso,volumen,extra) values
      ({$this->vcarro},'{$item}','{$descripcion}',{$unidades},{$precio},{$precio}*{$unidades},{$op["peso"]},{$op["volumen"]},'{$op["extra"]}')";
      
      //echo $sql;
      //exit;
      
      
      $ra = mysqli_query($nConexion,$sql);
      if( !$ra){
        if( $this->vdebug ){
            echo $sql;    
        }
        echo mysqli_error($nConexion);
        die("Fallo agregando item al carro {$this->vcarro} $item");
      }

      $this->actualizarFlete();

      return mysqli_insert_id($nConexion);
    }


  }

  function remove($cdet){
    $nConexion=Conectar();
    $sql="delete from tblti_carro_detalle where detalle = $cdet and carro={$this->vcarro}";
    $ra = mysqli_query($nConexion,$sql);

    if( !$ra){
      die("Fallo eliminado item del carro {$this->vcarro}");
    }
    return $this->actualizarFlete();
  }

  function total(){
    $nConexion=Conectar();

    $encabezado = $this->encabezado();
    $detalle = $this->detalle();

    $total = 0.0;
    foreach($detalle as $r){
      $total += $r["subtotal"];
    }
    return $total + $encabezado["total_flete"];
  }

  function actualizarFlete(){
    $nConexion=Conectar();
    $sql="select
    sum(peso*unidades) as total_peso,
    sum( (volumen*unidades)*0.00400 ) as total_volumen
    from
    tblti_carro_detalle where carro={$this->vcarro}";

    $ra = mysqli_query($nConexion,$sql);

    if( !$ra){
      die("Fallo consultando peso y volumen del carro {$this->vcarro}");
    }


    $rax = mysqli_fetch_object($ra);


    $peso = $rax->total_peso > $rax->total_volumen ? $rax->total_peso : $rax->total_volumen;

    $encabezado = $this->encabezado();
    $total_flete = $peso * $encabezado["destino_kilo"];
    $total_flete = $total_flete < $encabezado["destino_base"] ? $encabezado["destino_base"]:$total_flete;    $total_peso = $rax->total_peso ? $rax->total_peso : 0;    $total_volumen = $rax->total_volumen ? $rax->total_volumen : 0;
    return $this->updateEncabezado("total_peso={$total_peso},total_volumen={$total_volumen},total_flete={$total_flete}");
  }


  function setDestino($descripcion,$base,$kilo){
    $this->updateEncabezado("destino_descripcion='{$descripcion}',destino_base={$base},destino_kilo={$kilo}");
    $this->actualizarFlete();
    return;
  }

}
?>