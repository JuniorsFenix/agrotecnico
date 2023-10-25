<section class="abajo" style="display:none;">
  <div class="container">
    <div class="row">
      <div class="col-md-4">
        <?php $nConexion    = Conectar();
        mysqli_set_charset($nConexion, 'utf8');
        $Resultado    = mysqli_query($nConexion, "SELECT * FROM tblmatriz WHERE id = 4");
        $Registro     = mysqli_fetch_array($Resultado);
        $campos    = mysqli_query($nConexion, "SELECT * FROM campos_form WHERE idform = 4 ORDER BY idcampo ASC"); ?>
        <div class="contactos">
          <!-- <script src="https://www.google.com/recaptcha/api.js?render=6LcO1LkiAAAAAGwLdVrntWO0FIaoj8E-n8gidnxN"></script> -->
          <!-- <script>
            grecaptcha.ready(function() {
              grecaptcha.execute('6LcO1LkiAAAAAGwLdVrntWO0FIaoj8E-n8gidnxN', {
                action: 'home'
              }).then(function(token) {
                $('.formulario-captcha .token').val(token);
              });
            });
          </script> -->
          <script src="https://www.google.com/recaptcha/api.js?render=6Le2UngjAAAAAAngkVY8AQ2URakgQMqJtu_xCtBq"></script>
          <script>
            grecaptcha.ready(function() {
              grecaptcha.execute('6Le2UngjAAAAAAngkVY8AQ2URakgQMqJtu_xCtBq', {
                action: 'home'
              }).then(function(token) {
                $('.formulario-captcha .token').val(token);
              });
            });

            function closeWhatsapp() {
              var whatsapp = document.querySelector(".botonWhatsapp");
              whatsapp.style.display = "none";
            }
          </script>
          <form id="formulario" action="<?php echo $home; ?>/gracias-por-contactarnos" class="formulario3 formulario-captcha" method="post" onsubmit="return validate1(this)">
            <input type="hidden" name="action" value="home">
            <input type="hidden" name="token" class="token" value="">
            <input name="ciudad" type="hidden" value="1" />
            <input id="idform" name="idform" type="hidden" value="4" />
            <div class="row">
              <div class="col-md-6 text-center">
                <h2>CONTÁCTENOS</h2>
                <div class="row">
                  <div class="col-md-3"></div>
                  <div class="col-md-6 ml-5 ">
                    <p class="text-left h6">Si tienes alguna duda, sugerencia, queja o comentario, déjanos un mensaje y en muy poco tiempo te responderemos.</p>
                  </div>
                  <div class="col-md-3"></div>
                </div>

              </div>
              <div class="col-md-6 d-flex flex-wrap pr-5">
                <?php while ($r = mysqli_fetch_assoc($campos)) :
                  if ($r["tipo"] == "textarea") { ?>
                    <div class="col-12">
                      <textarea id="textarea" name="<?php echo $r["campo"]; ?>" rows="2" required placeholder="<?php echo $r["campo"]; ?>*"></textarea>
                    </div>
                  <?php } elseif ($r["tipo"] == "file") { ?>
                    <tr>
                      <td class="tituloNombres">Adjuntos:
                        <a href="#nolink" onclick="nuevoAdjunto();">
                          <img src="../../image/add.gif" width="16" height="16" />
                        </a>
                      </td>
                      <td class="contenidoNombres" colspan="5">
                        <script type="text/javascript">
                          var indexAdjunto = 2;

                          function nuevoAdjunto() {
                            $('.adjuntos').append('<li><input type="file" name="Adjunto' + indexAdjunto + '" /><a href="#nolink" id="remove"><img src="../../image/borrar.gif" width="16" height="16" /></a></li>');
                            indexAdjunto += 1;
                          }

                          $(document).on("click", "#remove", function() {
                            $(this).parent('li').remove();
                          });
                        </script>
                        <ul class="adjuntos">
                          <li><input type="file" name="Adjunto1" /></li>
                        </ul>
                      </td>
                    </tr>
                  <?php } elseif ($r["tipo"] == "email") { ?>
                    <div class="col-md-6">
                      <input type="email" maxlength="100" name="<?php echo $r["campo"]; ?>" required placeholder="<?php echo $r["campo"]; ?>*" />
                    </div>
                  <?php  } else { ?>
                    <div class="col-md-6"><input maxlength="150" name="<?php echo $r["campo"]; ?>" required placeholder="<?php echo $r["campo"]; ?>*" /> </div>
                  <?php  } ?>
                <?php endwhile; ?><br />
                <p class="antispam">Dejar este campo vacio: <input type="text" name="url" /></p>
                <div class="col-md-12 text-right">
                  <input class="action-button " name="Submit" type="submit" value="Enviar" size="100" />
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

<footer>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <?php $RegContenido = mysqli_fetch_object(VerContenido("footer"));
        echo $RegContenido->contenido;
        ?>
      </div>
    </div>
  </div>
  <!-- <div class="col-md-4">
        <div class="copy">
          <?php CargarCreditos() ?>
        </div>
      </div> -->

  <style>
    .whatsapp--cerrar {
      position: absolute;
      top: -8px;
      right: 5px;
      background-color: #C8E638;
      width: 18px;
      height: 18px;
      border-radius: 100%;
      display: flex;
      justify-content: center;
      align-items: center;
      cursor: pointer;
    }

    .whatsapp--cerrar:hover {
      transform: scale(1.1);
      background-color: #d4ff6a;
    }

    .whatsapp--cerrar>span {
      font-weight: 800;
      font-size: 0.7rem;
    }

    .botonWhatsapp {
      position: fixed;
      width: 206px;
      height: 71px;
      bottom: 0px;
      right: 0px;
      background-color: #243A44;
      z-index: 1000;
      border-top-left-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 7px 10px;

    }

    .whatsapp--botones {
      display: flex;
      flex-direction: column;
      gap: 5px;
      width: 60%;
      height: 100%;
    }

    .whatsapp--boton {
      width: 100%;
      height: 45%;
      padding: 5px 8px;
      background-color: #FFFFFF;
      color: #243A44;
      border-radius: 20px;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .whatsapp--boton:hover {
      background-color: #f0ffcb;
    }

    .whatsapp--boton>a {
      font-size: 0.7rem;
      text-transform: capitalize;
      font-weight: 500;
    }

    .whatsapp--boton>a:hover {
      text-decoration: none;
      color: #243A44;
    }

    .whatsapp--icono {
      width: 40%;
      height: 100%;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .whatsapp--icono>a {
      height: 100%;
      width: 100%;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 0;
      margin: 0;
    }

    .whatsapp--icono>a>img {
      height: 100%;
    }

    .contenerdor--redes-general {
      position: fixed;
      width: 50px;
      height: 150px;
      top: 40%;
      left: 5%;
      z-index: 1000;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: space-around;
    }

    .contenerdor--redes-general>a {
      width: 100%;
      height: 30%;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .contenerdor--redes-general>a>img {
      width: 100%;
      height: 100%;
      max-width: 40px;
      max-height: 40px;
    }
  </style>
  <?php $RegContenido = mysqli_fetch_object(VerContenido("whatsapp"));
  echo $RegContenido->contenido;
  ?>
</footer>

<script type="text/javascript" src="<?php echo $home; ?>/php/js/generales.js"></script>

<script>
  var map = "https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d89751.01313282349!2d-75.50514532743352!3d6.201310126746781!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1sagrotecnico%20j.o!5e0!3m2!1ses-419!2sco!4v1568841891968!5m2!1ses-419!2sco"
  //var img = "/fotos/Image/Agrotecnico.jpg"

  function mapa(m) {
    map = "https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d126922.32796715919!2d-75.52734790944575!3d6.2211035720525985!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1sautollantas+nutibara!5e0!3m2!1ses!2sco!4v1563497860847!5m2!1ses!2sco"
    if (m == 1) {
      map = "https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3966.188087320997!2d-75.58878381349183!3d6.238923388450033!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x5329ee67cfc3e7bd!2sAgrotecnico%20j.o!5e0!3m2!1ses-419!2sco!4v1568842541103!5m2!1ses-419!2sco"
      img = "/fotos/Image/Sede Bulerias.jpg"
    }
    if (m == 2) {
      map = "https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d4716.584531738732!2d-75.5679617897773!3d6.242762569422604!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x3a79fc1eb4c8bf4b!2sAgrotecnico%20j.o!5e0!3m2!1ses-419!2sco!4v1568842607412!5m2!1ses-419!2sco"
      img = "/fotos/Image/Sede San Juan.jpg"
    }
    if (m == 3) {
      map = "https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15867.283701592669!2d-75.3729011721108!3d6.154733030857041!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x989d3ee0edb4d7ca!2sAgrotecnico%20j.o!5e0!3m2!1ses-419!2sco!4v1568842683805!5m2!1ses-419!2sco"
      img = "/fotos/Image/Sede Rio Negro.jpg"
    }
    if (m == 4) {
      map = "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7929.015744419663!2d-75.56462797856453!3d6.457149524888051!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e4437a1f22e904d%3A0xf1c21489889a1f24!2sAgrotecnico%20j.o%20Sede%20San%20Pedro!5e0!3m2!1ses-419!2sco!4v1576086052678!5m2!1ses-419!2sco"
      img = "/fotos/Image/Sede San Pedro.jpg"
    }
    document.getElementById("mapa-frame").src = map
    document.getElementById("mapa-frame").scrollIntoView()
    //document.getElementById("sede").src = img
  }
</script>