<?php
  // dias sin ivA

  date_default_timezone_set('America/Bogota');
  $fecha_actual = strtotime(date("d-m-Y"));
  $fecha[] = strtotime("17-06-2022");
  
  if(in_array($fecha_actual, $fecha)){
    define("DIASINIVA", true);
  }else{
    define("DIASINIVA", false);
  }