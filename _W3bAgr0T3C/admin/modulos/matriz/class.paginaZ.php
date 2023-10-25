<? error_reporting(0);
	include_once("../../../include/connect.php");
/**************************************************************************
        PaginaZ v1.1

        Autor: Zubyc (webmaster@php-hispano.net)

        Este script se encarga de paginar una tabla de una base de datos,
        diviendo los registros en p�ginas de un tama�o definido.
        Servir�a tanto para paginar resultados de b�squedas como noticias,
        im�genes,...

        No est� recomendado para aquellas personas sin conocimientos previos de
        PHP ya que no ser� capaz de sacar el m�ximo provecho a este script.


        Este c�digo es de libre distribuci�n y por tanto puedes modificarlo
        a tu propio riesgo. Al ser totalmente gratuito s�lo te pido que mantengas
        esta informaci�n al usar este script.

        Para cualquier sugerencia o notificaci�n enviadme un email a la direcci�n
                        webmaster@php-hispano.net

                   Todas vuestras opiniones ser�n bien recibidas :)



        Mejoras en la versi�n 1.1

        - Arreglado un peque�o fallo al crear el n�mero de enlaces
        - Se han a�adido las siguientes funcionas para modificar los colores
             de ciertas partes del script:

                   set_color_tabla($color);
                   set_tabla_transparente()
                   set_color_texto($color)
                   set_color_enlaces($color_inactivo,$color_activo)





/***************************************************************************/


  class sistema_paginacion{




     /****************************************************************
                               DATOS A CONFIGURAR
     /****************************************************************/

     /* Colores  -  Configurable a gusto del consumidor :)*/

     var $color_link_inactivo="white";    /* Color del enlace cuando el raton no esta por encima */
     var $color_link_activo="yellow";     /* Color del enlace al pasar el raton por encima */
     var $color_texto="white";            /* Color del texto normal (Que no es enlace) */
     var $color_tablas="#A4A4A4";         /* Color de fondo de la tabla que contiene los enlaces */

    /**************************************************************************/
    /* MUY IMPORTANTE!!!: NO MODIFICAR NADA A PARTIR DE ESTA LINEA               */
    /***************************************************************************/

     /* Datos para la creacion de las paginas �NO MODIFICAR!  */

     var $numero_por_pagina;     /* N�mero de registros a mostrar por pagina */
     var $numero_paginas;
     var $total;
     var $condiciones;           /* Condiciones para realizar el query ...p.e. where visible=1.. */
     var $id_inicio=0;
     var $campos="";


     /* Datos para la conexion a la base de datos  (Deben ser modificados) */

     var $nombre_tabla;     /* Esta variable se establece al crear la clase */
     var $campo_ordenacion; /* Campo de la tabla por el que se ordenan los resultados */

      /* Error */

     var $error=0;
     var $estilos_creados=0;
     var $url;

     /************* METODOS DE LA CLASE *****************/


         // Constructor -> establece el nombre de tabla donde consultar
         function sistema_paginacion($tabla)
         {
            global $id_inicio;
						
						if ( isset( $_GET["id_inicio"] ) ){
							$id_inicio = $_GET["id_inicio"];
						}
						
            $this->nombre_tabla=$tabla;
            $nConexion = Conectar();



            if(isset($id_inicio))
              $this->id_inicio=$id_inicio;
            else
              $this->id_inicio=0;



         }


         function crear_estilos()
         {
            echo "<style type='text/css'>
                       A.paginaZ
                       {
                            text-decoration:none;
                            color: $this->color_link_inactivo;
                       }
                       A.paginaZ:hover
                       {
                            text-decoration:none;
                            color: $this->color_link_activo;
                       }
                </style>";

         }


         // Constructor -> establece el nombre de tabla y las condiciones para la consulta
         function set_condicion($cond)
         {
            $this->condiciones=$cond;
         }



         // Obtiene la pagina en la que estamos a partir del id_inicio
         function obtener_pagina_actual()
         {
           $pagina_actual=($this->id_inicio/$this->numero_por_pagina)+1;
           return($pagina_actual);
         }


         /* Establece el campo por el que se realizara la ordenacion de registros */
         function ordenar_por($campo)
         {
              $this->campo_ordenacion=$campo;
         }


         /* Obtiene el numero total de registros a paginar (No modificar!) */
         function obtener_total()
         {
            $query="SELECT count(*) as total from $this->nombre_tabla ";

            if ($this->condiciones!="")
            {
               $query.=" $this->condiciones";
            }

            $nConexion = Conectar();
            mysqli_select_db($this->sql_db);

            $result=mysqli_query($nConexion,$query);

            $row=mysqli_fetch_object($result);
            $this->total=$row->total;


         }




        // Obtiene el numero de paginas a crear
        function obtener_numero_paginas()
        {
            $this->obtener_total();

            $this->numero_paginas=$this->total/$this->numero_por_pagina;

          // Si hay alguna pagina con menos del maximo tb se a�ade
           if (($this->total%$this->numero_por_pagina)>0)
              $this->numero_paginas++;

           $this->numero_paginas=floor($this->numero_paginas);

        }




        //Establece un numero maximo de elementos por pagina
        function set_limite_pagina($num)
        {
          $this->numero_por_pagina=$num;
          $this->obtener_numero_paginas();
        }




        /* Obtiene la url donde enlazar (NO MODIFICAR!!!!) */
        function obtener_url()
        {
          global $HTTP_GET_VARS;

          while (list ($clave, $val) = each ($HTTP_GET_VARS)) {
            if($clave!="id_inicio")
               $variables .= $clave."=".$val."&";
          }

          if(strpos($variables, "&"))    $pag_devuelta = $HTTP_REFERER."?".$variables;
          else                           $pag_devuelta = $HTTP_REFERER."?";

           $this->url=$pag_devuelta;
        }




        
        function set_campos($campos){
        	$this->campos = $campos;
        }


         // Devuelve una variable $result con los resultados de la consulta
         function obtener_consulta()
         {

            $nConexion = Conectar();
            mysqli_select_db($this->sql_db);

            $campos = trim($this->campos)!=""?$this->campos:"*";
            $query="SELECT {$campos} from $this->nombre_tabla ";

            if ($this->condiciones!="")     $query.=" $this->condiciones";
            if($this->campo_ordenacion!="") $query.=" order by $this->campo_ordenacion ";

            $query.=" limit $this->id_inicio,$this->numero_por_pagina";
			echo $query;
            $result=mysqli_query($nConexion,$query);
			echo mysqli_error($nConexion);
            return($result);

         }



         function error($num)
         {
            $this->error=$num;
            switch($num)
            {
            case 1:echo "Error al conectar a la BD";break;
            case 2:break;
            case 3:break;
            case 4:break;
            }
         }



         function set_color_tabla($color)
         {
            $this->color_tablas=$color;
         }

         function set_tabla_transparente()
         {
            $this->color_tablas="NO";
         }

          function set_color_texto($color)
         {
            $this->color_texto=$color;
         }

         function set_color_enlaces($color_inactivo,$color_activo)
         {
            $this->color_link_inactivo=$color_inactivo;
            $this->color_link_activo=$color_activo;
         }




         /*************************************************************
              METODOS QUE MUESTRAN LOS DATOS POR PANTALLA
         ***************************************************************/






         /* Muestra por pantalla una informaci�n del tipo  "PAGINA X de X" */

         function mostrar_numero_pagina()
         {
                      /* Crea el tipo de enlace mediante CSS si no esta creado ya */
            if (!$this->estilos_creados) {$this->crear_estilos(); $this->estilos_creados=1; }


           $pagina_actual=$this->obtener_pagina_actual();

           echo "
            <table >
            <tr ";if ($this->color_tablas!="NO") echo "bgcolor='$this->color_tablas'";
             echo " >
            <td style='border:1px solid #000000'>
              &nbsp;&nbsp;
               <b><font color='$this->color_texto'>  P&aacute;gina $pagina_actual de $this->numero_paginas
              &nbsp;&nbsp;
              </td>
            </table>
          ";
         }




          // Imprime por pantalla los enlaces a cada pagina
         function mostrar_enlaces()
         {
           /* Crea el tipo de enlace mediante CSS si no esta creado ya */
           if (!$this->estilos_creados) {$this->crear_estilos(); $this->estilos_creados=1; }


           /* Obtiene la pagina en la que nos encontramos */
           $pagina_actual=$this->obtener_pagina_actual();

           /* Obtenemos la url donde enlazar */
           if (!$this->url) $this->obtener_url();




           echo "
           <table width='100%' border='0'>

           <tr>

          <td ";if ($this->color_tablas!="NO")
                     echo " bgcolor='$this->color_tablas'";
           echo " style='border:1px solid #000000'> ";


           echo "


           <font color='$this->color_texto'>&nbsp;&nbsp;<b>P&aacute;ginas
           ";



           for($i=0;$i<=$this->numero_paginas-1;$i++)
           {
              $numero_inicial=$i*$this->numero_por_pagina;
              $numero_final=$numero_inicial+$numero_por_pagina;

              $enlace_num=$this->url."id_inicio=$numero_inicial";

             $pagina=$i+1;

             echo " - ";

                if($pagina_actual!=$pagina)
                     echo " <a class='paginaZ' href='$enlace_num'>$pagina</a> ";
                else
                     echo "<u>$pagina</u>";
           }

           /* Mostramos el enlace de >>Siguiente si es necesario */

           $numero_siguiente=$this->id_inicio+$this->numero_por_pagina;
           $enlace_sig=$this->url."id_inicio=$numero_siguiente";

           if(isset($this->id_inicio)&&($this->id_inicio+$this->numero_por_pagina<$this->total))
                   echo "&nbsp; <a class='paginaZ' href='$enlace_sig'>&gt;&gt; Siguiente </a>";


          echo "&nbsp;&nbsp;</td>


          </table>";

         }


  }

?>
