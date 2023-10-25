<section class="abajo" style="display:none;">
	<div class="container">        
    <div class="row" >        
      <div class="col-md-4">
          <div class="videoWrapper">
          <iframe src="https://www.youtube.com/embed/6XJSekItbUQ" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
          </div>
      </div>

      <div class="col-md-4">
        <?php $nConexion    = Conectar();
        mysqli_set_charset($nConexion,'utf8');
        $Resultado    = mysqli_query($nConexion, "SELECT * FROM tblmatriz WHERE id = 4" ) ;
        $Registro     = mysqli_fetch_array( $Resultado );
        $campos    = mysqli_query($nConexion, "SELECT * FROM campos_form WHERE idform = 4 ORDER BY idcampo ASC" ); ?>
        <div class="contactos">
          <script src="https://www.google.com/recaptcha/api.js?render=6LdyOc0UAAAAADk_iVa344iX7K5st6r0qpImciB-"></script>
          <script>
            grecaptcha.ready(function() {        
              grecaptcha.execute('6LdyOc0UAAAAADk_iVa344iX7K5st6r0qpImciB-', {action: 'home'}).then(function(token) {
                  $('#formulario').append('<input type="hidden" name="token" value="' + token + '">');
                  $('#formulario').append('<input type="hidden" name="action" value="home">');
                  $('#formulario2').append('<input type="hidden" name="token" value="' + token + '">');
                  $('#formulario2').append('<input type="hidden" name="action" value="home">');
              });;
            });
          </script>
    
          <form id="formulario" action="<?php echo $home; ?>/gracias-por-contactarnos" class="formulario3" method="post" onsubmit="return validate1(this)">
            <input id="ciudad" name="ciudad" type="hidden" value="1" />
            <input id="idform" name="idform" type="hidden" value="4" />
            <div class="row">
              <?php while($r = mysqli_fetch_assoc($campos)): 
              if($r["tipo"]=="textarea"){ ?>
                <div class="col-12">
                  <textarea id="textarea" name="<?php echo $r["campo"];?>" rows="2" required placeholder="<?php echo $r["campo"];?>*" ></textarea>
                </div>
              <?php } elseif($r["tipo"]=="file") { ?>
                <tr>
                  <td class="tituloNombres">Adjuntos:
                    <a href="#nolink" onclick="nuevoAdjunto();">
                      <img src="../../image/add.gif" width="16" height="16" />
                    </a>
                  </td>
                  <td class="contenidoNombres" colspan="5">
                    <script type="text/javascript">
                      var indexAdjunto=2;                
                      function nuevoAdjunto(){                    
                        $('.adjuntos').append('<li><input type="file" name="Adjunto' + indexAdjunto + '" /><a href="#nolink" id="remove"><img src="../../image/borrar.gif" width="16" height="16" /></a></li>');
                        indexAdjunto+=1;
                      }
          
                      $(document).on("click", "#remove", function(){
                         $(this).parent('li').remove();
                      });
                    </script>
                    <ul class="adjuntos">
                      <li><input type="file" name="Adjunto1" /></li>
                    </ul>
                  </td>
                </tr>
              <?php } elseif($r["tipo"]=="email") { ?>
                <div class="col-md-6">
                  <input type="email" maxlength="100" name="<?php echo $r["campo"];?>" required placeholder="<?php echo $r["campo"];?>*"  />
                </div>
              <?php  } else { ?>
                <div class="col-md-6"><input maxlength="150" name="<?php echo $r["campo"];?>" required placeholder="<?php echo $r["campo"];?>*" /> </div>
              <?php  } ?>
              <?php endwhile; ?><br />
              
              <p class="antispam">Dejar este campo vacio: <input type="text" name="url" /></p>
              <input class="action-button" name="Submit" type="submit" value="Enviar" size="100"/>
            </div>
          </form>
        </div>
      </div>
      
      <div class="col-md-4">
        <div class="mapa">
          <!--- Sección mapa --->
          <?php //echo CargarMapaGoogle(); ?>                    
          <!--- Sección mapa --->
          <iframe src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d253804.6997415925!2d-75.53334438522388!3d6.3035402933710865!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1sagrotecnico%20sede%20j.o!5e0!3m2!1ses-419!2sco!4v1579522825539!5m2!1ses-419!2sco" width="100%" height="350" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
        </div>
      </div>
      
    </div>
  </div>
</section>

<footer>
	<div class="container">
        <div class="row">
            <div class="col-md-8">
                <?php $RegContenido = mysqli_fetch_object(VerContenido( "footer" ));
                  echo $RegContenido->contenido;
                ?>
    		</div>
            <div class="col-md-4">
                <div class="copy">
                <?php CargarCreditos()?>
        		</div>
    		</div>
		</div>
    </div>
</footer>

<script type="text/javascript" src="<?php echo $home; ?>/php/js/generales.js"></script>
<?php CargarCodigoGoogleAnalitic()?>

	<script>		

    var map = "https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d89751.01313282349!2d-75.50514532743352!3d6.201310126746781!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1sagrotecnico%20j.o!5e0!3m2!1ses-419!2sco!4v1568841891968!5m2!1ses-419!2sco"		
    //var img = "/fotos/Image/Agrotecnico.jpg"

		function mapa(m){
			map = "https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d126922.32796715919!2d-75.52734790944575!3d6.2211035720525985!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1sautollantas+nutibara!5e0!3m2!1ses!2sco!4v1563497860847!5m2!1ses!2sco"
			if(m==1){
				map="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3966.188087320997!2d-75.58878381349183!3d6.238923388450033!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x5329ee67cfc3e7bd!2sAgrotecnico%20j.o!5e0!3m2!1ses-419!2sco!4v1568842541103!5m2!1ses-419!2sco"
        img = "/fotos/Image/Sede Bulerias.jpg"
			}
			if(m==2){
				map="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d4716.584531738732!2d-75.5679617897773!3d6.242762569422604!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x3a79fc1eb4c8bf4b!2sAgrotecnico%20j.o!5e0!3m2!1ses-419!2sco!4v1568842607412!5m2!1ses-419!2sco"
        img = "/fotos/Image/Sede San Juan.jpg"
			}
			if(m==3){
				map="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15867.283701592669!2d-75.3729011721108!3d6.154733030857041!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x989d3ee0edb4d7ca!2sAgrotecnico%20j.o!5e0!3m2!1ses-419!2sco!4v1568842683805!5m2!1ses-419!2sco"
        img = "/fotos/Image/Sede Rio Negro.jpg"
			}
			if(m==4){
				map="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7929.015744419663!2d-75.56462797856453!3d6.457149524888051!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e4437a1f22e904d%3A0xf1c21489889a1f24!2sAgrotecnico%20j.o%20Sede%20San%20Pedro!5e0!3m2!1ses-419!2sco!4v1576086052678!5m2!1ses-419!2sco"
        img = "/fotos/Image/Sede San Pedro.jpg"
      }
			document.getElementById("mapa-frame").src = map
			document.getElementById("mapa-frame").scrollIntoView()
      //document.getElementById("sede").src = img
      
		}
	</script>
