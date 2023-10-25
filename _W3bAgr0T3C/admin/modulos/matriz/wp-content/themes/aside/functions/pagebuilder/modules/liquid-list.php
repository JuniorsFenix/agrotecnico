<?php
//liquid list template
function ux_pb_module_liquidlist($itemid)
{
	$module_post = ux_pb_item_postid($itemid);

	if ($module_post) {
		global $post;

		//liquid list confing
		$style              = get_post_meta($module_post, 'module_liquidlist_style', true);
		$category           = get_post_meta($module_post, 'module_cat_productos', true);
		$per_page           = get_post_meta($module_post, 'module_liquidlist_per_page', true);
		$pagination         = get_post_meta($module_post, 'module_liquidlist_pagination', true);
		$per_page       = $per_page ? $per_page : -1;

		$orderby            = get_post_meta($module_post, 'module_select_orderby', true);
		$order              = get_post_meta($module_post, 'module_select_order', true);

		require_once dirname(__FILE__) . ("/../../../../../../../../../include/funciones_public.php");
		$sitioCfg = sitioAssoc();
		$home = $sitioCfg["url"];
		$nConexion = Conectar();
		mysqli_set_charset($nConexion, 'utf8');

		switch ($style) {
			case 'categorias': ?>
				<!-- liquid categorias -->
				<div id="categorias">
					<?php
					$sql = "SELECT * FROM tblti_categorias WHERE idcategoria!=0 AND idcategoria IN (SELECT idcategoria FROM tblti_productos) ORDER BY '{$orderby}' {$order} LIMIT $per_page";
					$sql = "SELECT p.*, c.*
					FROM tblti_productos p
					JOIN tblti_categorias c ON p.idcategoria = c.idcategoria
					WHERE c.idcategoria != 0
					AND c.idcategoria_superior = 0
					AND (c.idcategoria IN (SELECT idcategoria FROM tblti_productos)
						OR c.idcategoria IN (SELECT c2.idcategoria_superior
											FROM tblti_categorias c2
											INNER JOIN tblti_productos p2 ON c2.idcategoria = p2.idcategoria))
					ORDER BY c.orden";


					$result = mysqli_query($nConexion, $sql);

					while ($rax = mysqli_fetch_assoc($result)) : ?>
						<?php
						$idmarca = $rax["idmarca"];
						$sqlmarca = " SELECT tblti_marcas.imagen FROM tblti_marcas WHERE idmarca =  $idmarca";
						$resultmarca = mysqli_query($nConexion, $sqlmarca);
						$marca = mysqli_fetch_assoc($resultmarca)
						?>
						<div class='categoria'>
							<div class="margen">
								<div class="categoria--title">
									<img src="<?php echo "$home/fotos/tienda/marcas/{$marca["imagen"]}" ?>">
								</div>
								<a class="imagenA" href='<?php echo "$home/productos/categoria/{$rax["url"]}" ?>'>
									<?php if (empty($rax["imagen"])) {
										echo "<img src='$home/fotos/Image/contenidos/default.jpg' />";
									} else {
										echo "<img src='$home/fotos/tienda/productos/{$rax["imagen"]}' alt='{$rax["nombre"]}' />";
									} ?>
									<h3><?php echo $rax["nombre"] ?></h3>
									<div class="categoria--description">


										<p><?php
											$texto = $rax["descripcion"];
											$longitudMaxima = 250; // Define la longitud máxima deseada

											if (strlen($texto) > $longitudMaxima) {
												$textoRecortado = substr($texto, 0, $longitudMaxima) . "...";
											} else {
												$textoRecortado = $texto;
											}
											echo $textoRecortado;
											?></p>
									</div>
								</a>
								<button onclick="window.location.href='<?php echo "$home/productos/categoria/{$rax["url"]}" ?>';">Ver Más</button>
							</div>
						</div>
					<?php endwhile; ?>
				</div>
				<script type="text/javascript">
					// window.addEventListener("DOMContentLoaded", function() {
					// 	var productosDestadcados = document.querySelector(".categorias--destacados");
					// 	productosDestadcados.style.setProperty("fontWeight", "800", "important");

					// });
					jQuery(document).on('ready', function() {
						jQuery('#destacados').slick({
							arrows: true,
							slidesToShow: 4,
							slidesToScroll: 4,
							responsive: [{
								breakpoint: 1200,
								settings: {
									arrows: false,
									slidesToShow: 2,
									slidesToScroll: 2
								}
							}, {
								breakpoint: 768,
								settings: {
									arrows: false,
									slidesToShow: 1,
									slidesToScroll: 1
								}
							}]
						});
					});
				</script>
				<?php break;

			case 'productos':
				echo "<!-- liquid productos -->";

				$imagenes = array();
				$ras = mysqli_query($nConexion, "SELECT * FROM tblti_imagenes WHERE idimagen<>0 ORDER BY idimagen DESC");
				while ($imagen = mysqli_fetch_assoc($ras)) {
					$imagenes[$imagen["idproducto"]] = $imagen;
				}
				$sql = "";
				if ($category != 0) {
					$sql = "WHERE idcategoria=$category";
				}

				$result = mysqli_query($nConexion, "SELECT * FROM tblti_productos $sql LIMIT $per_page");
				$num_rows = mysqli_num_rows($result);
				while ($rax = mysqli_fetch_assoc($result)) : ?>
					<div class="col-md-3 col-sm-6">
						<a href='<?php echo "$home/productos/{$rax["url"]}" ?>'>
							<?php if (empty($imagenes[$rax["idproducto"]]["imagen"])) {
								echo "<img src='$home/fotos/Image/contenidos/default.jpg' />";
							} else {
								echo "<img src='$home/fotos/tienda/productos/m_{$imagenes[$rax["idproducto"]]["imagen"]}' alt='{$rax["nombre"]}' />";
							} ?>
						</a>
						<h3><?php echo $rax["nombre"] ?></h3>
						<div class="precio">$ <?php echo $rax["precio"] ?></div>
					</div>
				<?php endwhile;
				break;
			case 'destacados':
				$imagenes = array();
				$ras = mysqli_query($nConexion, "SELECT * FROM tblti_imagenes WHERE idimagen<>0 ORDER BY idimagen DESC");
				while ($imagen = mysqli_fetch_assoc($ras)) {
					$imagenes[$imagen["idproducto"]] = $imagen;
				} ?>
				<!-- liquid categorias -->
				<div class="productos-destacados">
					<?php
					$sql = "SELECT * FROM tblti_productos WHERE destacado=1 AND activo=1 ORDER BY nombre ASC LIMIT 5";

					$result = mysqli_query($nConexion, $sql);

					while ($rax = mysqli_fetch_assoc($result)) : ?>
						<?php $productos[] = $rax; ?>
					<?php endwhile; ?>
					<!-- <div class='destacado--container'>
						<h3><?php echo $productos[0]["nombre"] ?></h3>
						<a class="imagenA" href='<?php echo "$home/productos/{$productos[0]["url"]}" ?>'>
							<?php if (empty($imagenes[$productos[0]["idproducto"]]["imagen"])) {
								echo "<img src='$home/fotos/Image/contenidos/default.jpg' />";
							} else {
								echo "<img src='$home/fotos/tienda/productos/m_{$imagenes[$productos[0]["idproducto"]]["imagen"]}' alt='{$productos[0]["nombre"]}' />";
							} ?>
						</a>
						<div class="destacado--buttons">
							<a href="">Añadir al carrito</a>
							<a href="">Ver Más</a>
						</div>
					</div> -->
					<div class="grid">
						<div class="item">
							<div class="item-container">
								<h3><?php echo $productos[0]["nombre"] ?></h3>
								<a class="imagenA" href='<?php echo "$home/productos/{$productos[0]["url"]}" ?>'>
									<?php if (empty($imagenes[$productos[0]["idproducto"]]["imagen"])) {
										echo "<img src='$home/fotos/Image/contenidos/default.jpg' />";
									} else {
										echo "<img src='$home/fotos/tienda/productos/m_{$imagenes[$productos[0]["idproducto"]]["imagen"]}' alt='{$productos[0]["nombre"]}' />";
									} ?>
								</a>
								<div class="destacado--buttons">
									<a href="">Añadir al carrito</a>
									<a href="<?php echo "$home/productos/{$productos[0]["url"]}" ?>">Ver Más</a>
								</div>
							</div>
						</div>
						<div class="item">
							<div class='item-vertical-container'>
								<h3><?php echo $productos[1]["nombre"] ?></h3>
								<span>Referencia: <?php echo $productos[1]["referencia"] ?></span>
								<h2 style="font-weight: 800;">COP <?php echo $productos[1]["precio"] ?></h2>
								<!-- <h1> 197.000</h1> -->
								<div class="destacado--buttons">
									<a href="">Añadir al carrito</a>
									<a href="">Ver Más</a>
								</div>
								<a class="link-imagen" href='<?php echo "$home/productos/{$productos[1]["url"]}" ?>'>
									<?php if (empty($imagenes[$productos[1]["idproducto"]]["imagen"])) {
										echo "<img src='$home/fotos/Image/contenidos/default.jpg' />";
									} else {
										echo "<img src='$home/fotos/tienda/productos/m_{$imagenes[$productos[1]["idproducto"]]["imagen"]}' alt='{$productos[0]["nombre"]}' />";
									} ?>
								</a>
							</div>
						</div>
						<div class="item">
							<div class="item-container" style="align-items: start;">
								<h3><?php echo $productos[2]["nombre"] ?></h3>
								<span>Referencia: <?php echo $productos[2]["referencia"] ?></span>
								<h2 style="font-weight: 800;">COP <?php echo $productos[2]["precio"] ?></h2>
								<div class="destacado--buttons" style="align-items: start; width: 40%;">
									<a href="">Añadir al carrito</a>
									<a href="<?php echo "$home/productos/{$productos[2]["url"]}" ?>">Ver Más</a>
								</div>
								<a class="imagenAbso" href='<?php echo "$home/productos/{$productos[2]["url"]}" ?>'>
									<?php if (empty($imagenes[$productos[2]["idproducto"]]["imagen"])) {
										echo "<img src='$home/fotos/Image/contenidos/default.jpg' />";
									} else {
										echo "<img src='$home/fotos/tienda/productos/m_{$imagenes[$productos[2]["idproducto"]]["imagen"]}' alt='{$productos[0]["nombre"]}' />";
									} ?>
								</a>
							</div>
						</div>
						<div class="item">
							<div class="item-container">
								<h3><?php echo $productos[3]["nombre"] ?></h3>
								<a class="imagenA" href='<?php echo "$home/productos/{$productos[3]["url"]}" ?>'>
									<?php if (empty($imagenes[$productos[3]["idproducto"]]["imagen"])) {
										echo "<img src='$home/fotos/Image/contenidos/default.jpg' />";
									} else {
										echo "<img src='$home/fotos/tienda/productos/m_{$imagenes[$productos[3]["idproducto"]]["imagen"]}' alt='{$productos[3]["nombre"]}' />";
									} ?>
								</a>
								<div class="destacado--buttons">
									<a href="">Añadir al carrito</a>
									<a href="<?php echo "$home/productos/{$productos[3]["url"]}" ?>">Ver Más</a>
								</div>
							</div>
						</div>
						<div class="item">
							<div class="item-container" style="align-items: end;">
								<h3><?php echo $productos[4]["nombre"] ?></h3>
								<span>Referencia: <?php echo $productos[4]["referencia"] ?></span>
								<h2 style="font-weight: 800;">COP <?php echo $productos[4]["precio"] ?></h2>
								<div class="destacado--buttons" style="align-items: start; width: 40%;">
									<a href="">Añadir al carrito</a>
									<a href="<?php echo "$home/productos/{$productos[4]["url"]}" ?>">Ver Más</a>
								</div>
								<a class="imagenAbsoDos" href='<?php echo "$home/productos/{$productos[4]["url"]}" ?>'>
									<?php if (empty($imagenes[$productos[4]["idproducto"]]["imagen"])) {
										echo "<img src='$home/fotos/Image/contenidos/default.jpg' />";
									} else {
										echo "<img src='$home/fotos/tienda/productos/m_{$imagenes[$productos[4]["idproducto"]]["imagen"]}' alt='{$productos[4]["nombre"]}' />";
									} ?>
								</a>
							</div>
						</div>
					</div>

				</div>
				<script type="text/javascript">
					window.addEventListener("DOMContentLoaded", function() {
						var categoriaTitle = document.getElementById("categorias--destacados");
						categoriaTitle.style.setProperty("font-weight", "bolder", "important");

						var productosDestadcados = document.querySelector(".productos-destacados");
						productosDestadcados.style.setProperty("display", "none", "important");
						var destacadosElement = document.getElementById("p-destacados");
						destacadosElement.style.backgroundColor = "#EFEFEF";
					});
					var estado = true;

					function showProductos() {
						var categoriaTitle = document.getElementById("categorias--destacados");
						var destacadosTitle = document.getElementById("productos--destacados");

						if (estado) {
							categoriaTitle.style.setProperty("font-weight", "bolder", "important");
							destacadosTitle.style.setProperty("font-weight", "500", "important");
						} else {
							categoriaTitle.style.setProperty("font-weight", "500", "important");
							destacadosTitle.style.setProperty("font-weight", "bolder", "important");
						}

						elemento = document.querySelector(".productos-destacados")
						if (elemento.style.display === "flex") {
							elemento.style.setProperty("display", "none", "important");
						} else {
							elemento.style.setProperty("display", "flex", "important");
						}
						estado = !estado;
					}

					jQuery(document).on('ready', function() {
						jQuery('#categorias').slick({
							arrows: true,
							slidesToShow: 4,
							slidesToScroll: 4,
							responsive: [{
								breakpoint: 1200,
								settings: {
									arrows: false,
									slidesToShow: 2,
									slidesToScroll: 2
								}
							}, {
								breakpoint: 768,
								settings: {
									arrows: false,
									slidesToShow: 1,
									slidesToScroll: 1
								}
							}]
						});
					});
				</script>
		<?php break;
		} ?>
		<div class="container-isotope clear" data-post="<?php echo $itemid; ?>">
			<a name="<?php echo $itemid; ?>" class="<?php echo $itemid; ?>"></a>
			<div id="isotope-load">
				<div class="ux-loading"></div>
				<div class="ux-loading-transform">
					<div class="loading-dot1">&nbsp;</div>
					<div class="loading-dot2">&nbsp;</div>
				</div>
			</div>
			<div class="isotope masonry isotope-liquid-list <?php if ($image_spacing == '0px') {
																echo 'less-space';
															} ?>" data-space="<?php echo $image_spacing; ?>" style=" <?php echo $isotope_style; ?>" data-size="<?php echo $image_size; ?>" data-width="<?php echo $block_width; ?>" data-words="<?php echo $block_words; ?>" data-social="<?php echo $show_social; ?>" data-ratio="<?php echo $image_ratio; ?>">
				<?php ux_pb_module_load_liquidlist($itemid, 1); ?>
			</div>
		</div>
		<?php
	}
}
add_action('ux-pb-module-template-liquid-list', 'ux_pb_module_liquidlist');

//liquid list load template
function ux_pb_module_load_liquidlist($itemid, $paged)
{
	$module_post = ux_pb_item_postid($itemid);

	if ($module_post) {
		global $post;
		//liquid list confing
		$style              = get_post_meta($module_post, 'module_liquidlist_style', true);
		$effect             = get_post_meta($module_post, 'module_liquidlist_mouseover_effect', true);
		$image_spacing      = get_post_meta($module_post, 'module_liquidlist_image_spacing', true);
		$image_size         = get_post_meta($module_post, 'module_liquidlist_image_size', true);
		$loading_color      = get_post_meta($module_post, 'module_liquidlist_loading_color', true);
		$category           = get_post_meta($module_post, 'module_cat_productos', true);
		$orderby            = get_post_meta($module_post, 'module_select_orderby', true);
		$order              = get_post_meta($module_post, 'module_select_order', true);
		$advanced_settings  = get_post_meta($module_post, 'module_advanced_settings', true);
		$select_image_ratio = get_post_meta($module_post, 'module_liquidlist_image_ratio', true);
		$per_page           = get_post_meta($module_post, 'module_liquidlist_per_page', true);

		$animation_style    = $advanced_settings == 'on' ? ux_pb_module_animation_style($itemid, 'liquid-list') : false;
		$per_page           = $per_page ? $per_page : -1;

		$block_color = false;
		switch ($loading_color) {
			case 'featured_color':
				$block_color = 'featured_color';
				break;
			case 'grey':
				$block_color = 'bg-theme-color-10';
				break;
		}

		$image_ratio = false;
		switch ($select_image_ratio) {
			case 'landscape':
				$image_ratio = 'image-thumb';
				break;
			case 'square':

				if ($image_size == 'large') {
					$image_ratio = 'image-thumb-1';
				} else {
					$image_ratio = 'imagebox-thumb';
				}
				break;
			case 'auto':
				$image_ratio = 'standard-thumb';
				break;
		}

		$container3d    = $effect == 'on' ? 'hover-effect' : false;
		$back_con_style = 'padding-left: ' . $image_spacing . ';';
		$back_tit_style = 'margin-top: -' . $image_spacing . ';';
		$back_bg_style  = 'left: ' . $image_spacing . '; top: -' . $image_spacing . ';';
		$block_color    = $block_color ? $block_color : false;
		$image_ratio    = $image_ratio ? $image_ratio : 'image-thumb';
		//$inside_style   = $style == 'magazine' ? 'padding:' . $image_spacing . ' 0 0 ' . $image_spacing . ';' : 'margin:' . $image_spacing . ' 0 0 ' . $image_spacing;
		$inside_style   = 'padding:' . $image_spacing . ' 0 0 ' . $image_spacing . ';';

		$sticky = get_option('sticky_posts');

		$get_sticky = get_posts(array(
			'posts_per_page' => $per_page,
			'paged'          => $paged,
			'cat'            => $category,
			'orderby'        => $orderby,
			'order'          => $order,
			'post__in'       => $sticky,
			'meta_query' => array(
				'relation' => 'AND',
				array(
					'key' => '_thumbnail_id',
					'compare' => 'EXISTS'
				)
			)
		));

		$get_posts = get_posts(array(
			'posts_per_page' => $per_page,
			'paged'          => $paged,
			'cat'            => $category,
			'orderby'        => $orderby,
			'order'          => $order,
			'post__not_in'   => $sticky,
			'meta_query' => array(
				'relation' => 'AND',
				array(
					'key' => '_thumbnail_id',
					'compare' => 'EXISTS'
				)
			)
		));

		if ($style == 'magazine') {
			$get_posts = get_posts(array(
				'posts_per_page' => $per_page,
				'paged'          => $paged,
				'cat'            => $category,
				'orderby'        => $orderby,
				'order'          => $order,
				'post__not_in'   => $sticky,
			));
		}

		if ($sticky) {
			$get_posts = array_merge_recursive($get_sticky, $get_posts);
		}

		foreach ($get_posts as $num => $post) {
			setup_postdata($post);
			$bg_color = ux_get_post_meta(get_the_ID(), 'theme_meta_bg_color');
			$bg_color = $bg_color ? 'bg-' . ux_theme_switch_color($bg_color) : 'post-bgcolor-default';
			$bg_color = $loading_color == 'featured_color' ? $bg_color : $block_color;

			switch ($style) {
				case 'image': ?>
					<!-- liquid image -->

					<div class="width2 isotope-item <?php echo $container3d; ?> <?php echo $animation_style; ?>">
						<div class="inside liquid_inside brick-inside" style=" <?php echo $inside_style; ?>">

							<div class="brick-content brick-hover <?php echo $bg_color; ?>">
								<a href="<?php the_permalink(); ?>" class="liquid_list_image" data-postid="<?php the_ID(); ?>" data-color="<?php echo $bg_color; ?>" data-type="<?php echo $style; ?>">
									<div class="brick-hover-mask">
										<h3 class="brick-title"><?php the_title(); ?></h3>

									</div>
									<?php if (has_post_thumbnail()) {
										the_post_thumbnail($image_ratio);
									} ?>
								</a>
							</div><!--End brick-content-->

						</div><!--End inside-->
						<div style="display:none; <?php echo 'margin:' . $image_spacing . ' 0 0 ' . $image_spacing . ';'; ?>" class="inside liquid-loading-wrap <?php echo $bg_color; ?>">
							<div class="ux-loading"></div>
							<div class="ux-loading-transform">
								<div class="loading-dot1">&nbsp;</div>
								<div class="loading-dot2">&nbsp;</div>
							</div>


							<?php echo get_the_post_thumbnail(get_the_ID(), $image_ratio, array('class' => 'liquid-hide')); ?>
						</div>
					</div>
				<?php
					break;

				case 'magazine':
					echo "<!-- liquid magazine -->";

					$get_post_format = (get_post_format() == '') ? 'standard' : get_post_format(); ?>
					<div class="width2 isotope-item <?php echo $get_post_format; ?> <?php echo $animation_style; ?>">
						<div class="inside liquid_inside" style=" <?php echo $inside_style; ?>">
							<div class="liquid-item">
								<div class="item_topbar <?php echo $bg_color; ?>"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="item_link liquid_list_image" data-postid="<?php the_ID(); ?>" data-color="<?php echo $bg_color; ?>" data-type="<?php echo $style; ?>"></a></div>

								<?php if (has_post_format('quote')) {
									$ux_quote = ux_get_post_meta(get_the_ID(), 'theme_meta_quote');  ?>
									<div class="item_des <?php echo $bg_color; ?>">
										<i class="icon-m-quote-left center-ux"></i>
										<p><?php echo $ux_quote; ?></p>

									</div>
								<?php } elseif (has_post_format('link')) {
									$ux_link_item = ux_get_post_meta(get_the_ID(), 'theme_meta_link_item'); ?>
									<div class="item_des <?php echo $bg_color; ?>">
										<h2 class="item_title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="liquid_list_image" data-postid="<?php the_ID(); ?>" data-color="<?php echo $bg_color; ?>" data-type="<?php echo $style; ?>"><?php the_title(); ?></a></h2>
										<?php if (get_the_excerpt()) { ?><div class="item-des-p hidden-phone"><?php the_excerpt(); ?></div><?php } ?>
										<div class="item-link-wrap">
											<?php foreach ($ux_link_item['name'] as $i => $name) {
												$url = $ux_link_item['url'][$i]; ?>

												<p class="item-link"><a title="<?php echo $name; ?>" href="<?php echo esc_url($url); ?>"><?php echo $name; ?></a></p>
											<?php } ?>
										</div>

									</div>
									<?php } elseif (has_post_format('audio')) {
									$ux_audio_type = ux_get_post_meta(get_the_ID(), 'theme_meta_audio_type');
									$ux_audio_artist = ux_get_post_meta(get_the_ID(), 'theme_meta_audio_artist');
									$ux_audio_mp3 = ux_get_post_meta(get_the_ID(), 'theme_meta_audio_mp3');
									$ux_audio_soundcloud = ux_get_post_meta(get_the_ID(), 'theme_meta_audio_soundcloud');
									if ($ux_audio_type == 'soundcloud') {  ?>
										<div class="item_des <?php echo $bg_color; ?>">
											<h2 class="item_title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="liquid_list_image" data-postid="<?php the_ID(); ?>" data-color="<?php echo $bg_color; ?>" data-type="<?php echo $style; ?>"><?php the_title(); ?></a></h2>
											<div class="soundcloudWrapper">
												<iframe width="100%" height="166" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=<?php echo $ux_audio_soundcloud; ?>&amp;color=ff3900&amp;auto_play=false&amp;show_artwork=false"></iframe>
											</div>

										</div>
									<?php } else { ?>
										<div class="item_des <?php echo $bg_color; ?>">
											<h2 class="item_title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="liquid_list_image" data-postid="<?php the_ID(); ?>" data-color="<?php echo $bg_color; ?>" data-type="<?php echo $style; ?>"><?php the_title(); ?></a></h2>
										</div>
										<ul class="audio_player_list <?php echo $bg_color; ?>">
											<?php foreach ($ux_audio_mp3['name'] as $i => $name) {
												$url = $ux_audio_mp3['url'][$i]; ?>
												<li class="audio-unit"><span id="audio-<?php echo get_the_ID() . '-' . $i; ?>" class="audiobutton pause" rel="<?php echo esc_url($url); ?>"></span><span class="songtitle" title="<?php echo $name; ?>"><?php echo $name; ?></span></li>
											<?php } ?>
										</ul>
									<?php
									}
								} elseif (has_post_format('video')) {
									$ux_video_embeded_code = ux_get_post_meta(get_the_ID(), 'theme_meta_video_embeded_code'); ?>

									<?php if ($ux_video_embeded_code) {
										if (strstr($ux_video_embeded_code, "youtu") && !(strstr($ux_video_embeded_code, "iframe"))) { ?>
											<div class="videoWrapper">
												<iframe src="http://www.youtube.com/embed/<?php echo ux_theme_get_youtube($ux_video_embeded_code); ?>?rel=0&controls=1&showinfo=0&theme=light&autoplay=0&wmode=transparent"></iframe>
											<?php } elseif (strstr($ux_video_embeded_code, "vimeo") && !(strstr($ux_video_embeded_code, "iframe"))) { ?>
												<div class="videoWrapper" style="padding-bottom:49%">
													<iframe src="http://player.vimeo.com/video/<?php echo ux_theme_get_vimeo($ux_video_embeded_code); ?>?title=0&amp;byline=0&amp;portrait=0" width="100%" height="auto" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
												<?php } else { ?>
													<div class="videoWrapper">
												<?php
												echo $ux_video_embeded_code;
											}
										} ?>
													</div>
													<div class="item_des <?php echo $bg_color; ?>">
														<h2 class="item_title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="liquid_list_image" data-postid="<?php the_ID(); ?>" data-color="<?php echo $bg_color; ?>" data-type="<?php echo $style; ?>"><?php the_title(); ?></a></h2>

													</div>
												<?php
											} elseif (has_post_format('gallery')) {
												$ux_portfolio = ux_get_post_meta(get_the_ID(), 'theme_meta_portfolio'); ?>

													<div class="liqd-gallery item_des <?php echo $bg_color; ?>">

														<?php if ($ux_portfolio) { ?>

															<?php if (has_post_thumbnail()) {
																$thumb_src_full = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full');
																$thumb_src_360 = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'standard-thumb'); ?>

																<?php foreach ($ux_portfolio as $num => $image) {

																	$thumb_src_full = wp_get_attachment_image_src($image, 'full'); ?>

																	<a href="<?php echo $thumb_src_full[0]; ?>" class="lightbox liqd-gallery-img" rel="post<?php the_ID(); ?>" title="<?php the_title(); ?>">
																		<i class="icon-m-pt-portfolio centered-ux"></i>
																		<img alt="<?php the_title(); ?>" src="<?php echo $thumb_src_360[0]; ?>" class="isotope-list-thumb">
																	</a>

															<?php } //end foreach

															} ?>

														<?php } ?>

														<h2 class="item_title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="liquid_list_image" data-postid="<?php the_ID(); ?>" data-color="<?php echo $bg_color; ?>" data-type="<?php echo $style; ?>"><?php the_title(); ?></a></h2>
														<?php if (get_the_excerpt()) { ?><div class="item-des-p hidden-phone"><?php the_excerpt(); ?></div><?php } ?>

													</div><!--End item_des-->
													<?php } else {
													if (has_post_thumbnail()) {
														$thumb_src_full = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full');
														$thumb_src_360 = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'standard-thumb'); ?>
														<a href="<?php echo $thumb_src_full[0]; ?>" class="lightbox" rel="post<?php the_ID(); ?>" title="<?php the_title(); ?>">
															<img alt="<?php the_title(); ?>" src="<?php echo $thumb_src_360[0]; ?>" class="isotope-list-thumb">
														</a>
													<?php } ?>
													<div class="item_des <?php echo $bg_color; ?>">
														<h2 class="item_title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="liquid_list_image" data-postid="<?php the_ID(); ?>" data-color="<?php echo $bg_color; ?>" data-type="<?php echo $style; ?>"><?php the_title(); ?></a></h2>
														<?php if (get_the_excerpt()) { ?><div class="item-des-p hidden-phone"><?php the_excerpt(); ?></div><?php } ?>
														<div class="like clear"></div><!--End like-->
													</div>
												<?php } ?>
												</div>
											</div><!--End inside-->
											<div style="display:none; <?php echo 'margin:' . $image_spacing . ' 0 0 ' . $image_spacing . ';'; ?>" class="inside liquid-loading-wrap <?php echo $bg_color; ?>">
												<div class="ux-loading"></div>
												<div class="ux-loading-transform">
													<div class="loading-dot1">&nbsp;</div>
													<div class="loading-dot2">&nbsp;</div>
												</div>
												<div class="liquid-hide"></div>
											</div>
							</div><!--End isotope-item-->
			<?php
					break;
			}
		}
		wp_reset_postdata();
	}
}

//liquid list charlength
function ux_pb_view_liquid_charlength($charlength)
{
	$excerpt = get_the_excerpt();
	$charlength++;

	if (mb_strlen($excerpt) > $charlength) {
		$subex = mb_substr($excerpt, 0, $charlength - 5);
		$exwords = explode(' ', $subex);
		$excut = - (mb_strlen($exwords[count($exwords) - 1]));
		if ($excut < 0) {
			echo mb_substr($subex, 0, $excut);
		} else {
			echo $subex;
		}
		echo '...';
	} else {
		echo $excerpt;
	}
}

//liquid list view load
function ux_pb_view_liquid_load($post_id, $block_words, $show_social, $image_ratio)
{
	global $post;

	$post = get_post($post_id);
	setup_postdata($post);

	$bg_color = ux_get_post_meta(get_the_ID(), 'theme_meta_bg_color');
	$bg_color = $bg_color ? 'bg-' . ux_theme_switch_color($bg_color) : 'post-bgcolor-default';

	$show_social = ($show_social == 'true') ? true : false; ?>
			<section class="liquid-expand-wrap" style="display:none;">
				<h1 class="liquid-title <?php echo $bg_color; ?>">
					<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
					<i class="icon-m-close-thin liquid-item-close"></i>
				</h1>
				<div class="liquid-body">
					<?php if (get_the_excerpt()) { ?>
						<div class="liquid-body-des">
							<?php if ($block_words) {
								ux_pb_view_liquid_charlength($block_words);
							} else {
								the_excerpt();
							} ?>
						</div><!--End liquid-body-des-->
						<?php
					}

					if (has_post_format('gallery')) {
						$ux_portfolio = ux_get_post_meta(get_the_ID(), 'theme_meta_portfolio');
						if ($ux_portfolio) { ?>
							<!-- liquid gallery -->

							<ul class="liquid-body-thumbs clearfix">
								<?php foreach ($ux_portfolio as $num => $image) {
									$thumb_src_full = wp_get_attachment_image_src($image, 'full');
									$thumb_src = wp_get_attachment_image_src($image, 'imagebox-thumb'); ?>
									<li><a href="<?php echo $thumb_src_full[0]; ?>" title="<?php echo get_the_title($image); ?>" class="imgwrap lightbox" data-rel="post<?php the_ID(); ?>"><img width="100" height="100" src="<?php echo $thumb_src[0]; ?>" /></a></li>
								<?php } ?>
							</ul>
						<?php
						}
					} elseif (has_post_format('audio')) {
						$ux_audio_type = ux_get_post_meta(get_the_ID(), 'theme_meta_audio_type');
						$ux_audio_artist = ux_get_post_meta(get_the_ID(), 'theme_meta_audio_artist');
						$ux_audio_mp3 = ux_get_post_meta(get_the_ID(), 'theme_meta_audio_mp3');
						$ux_audio_soundcloud = ux_get_post_meta(get_the_ID(), 'theme_meta_audio_soundcloud'); ?>
						<div class="liquid-body-audio">
							<?php if ($ux_audio_type == 'soundcloud') {

								if ($ux_audio_soundcloud) { ?>
									<iframe width="100%" height="166" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=<?php echo $ux_audio_soundcloud; ?>&amp;color=ff3900&amp;auto_play=false&amp;show_artwork=true"></iframe>
								<?php
								}
							} else {
								if ($ux_audio_mp3) { ?>
									<ul class="audio_player_list">
										<?php foreach ($ux_audio_mp3['name'] as $i => $name) {
											$url = $ux_audio_mp3['url'][$i]; ?>
											<li class="audio-unit"><span id="audio-<?php echo get_the_ID() . '-' . $i; ?>" class="audiobutton pause" rel="<?php echo esc_url($url); ?>"></span><span class="songtitle" title="<?php echo $name; ?>"><?php echo $name; ?></span></li>
										<?php } ?>
									</ul>
							<?php
								}
							} ?>
						</div>
					<?php
					} elseif (has_post_format('quote')) {
						$ux_quote = ux_get_post_meta(get_the_ID(), 'theme_meta_quote'); ?>
						<div class="liquid-body-quote">
							<div class="quote-wrap"><i class="icon-m-quote-left"></i><?php echo $ux_quote; ?></div><!--End quote-wrap-->
						</div><!--End liquid-body-quote-->
						<?php
					} elseif (has_post_format('video')) {
						$ux_video_embeded_code = ux_get_post_meta(get_the_ID(), 'theme_meta_video_embeded_code');

						if ($ux_video_embeded_code) { ?>
							<div class="liquid-body-video video-wrap video-16-9">
								<?php if (strstr($ux_video_embeded_code, "youtu") && !(strstr($ux_video_embeded_code, "iframe"))) { ?>
									<iframe src="http://www.youtube.com/embed/<?php echo ux_theme_get_youtube($ux_video_embeded_code); ?>?rel=0&controls=1&showinfo=0&theme=light&autoplay=0&wmode=transparent"></iframe>
								<?php } elseif (strstr($ux_video_embeded_code, "vimeo") && !(strstr($ux_video_embeded_code, "iframe"))) { ?>
									<iframe src="http://player.vimeo.com/video/<?php echo ux_theme_get_vimeo($ux_video_embeded_code); ?>?title=0&amp;byline=0&amp;portrait=0" width="100%" height="auto" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
								<?php } else {
									echo $ux_video_embeded_code;
								} ?>
							</div>
						<?php
						}
					} elseif (has_post_format('link')) {
						$ux_link_item = ux_get_post_meta(get_the_ID(), 'theme_meta_link_item');
						if ($ux_link_item) { ?>
							<div class="liquid-body-link">
								<ul class="link-wrap">
									<?php foreach ($ux_link_item['name'] as $i => $name) {
										$url = $ux_link_item['url'][$i]; ?>
										<li><a title="<?php echo $name; ?>" href="<?php echo esc_url($url); ?>"><i class="icon-m-link"></i><?php echo $name; ?></a></li>
									<?php } ?>
								</ul>
							</div><!--End liquid-body-link-->
						<?php
						}
					} else {
						if (has_post_thumbnail()) { ?>
							<div class="liquid-body-img">
								<?php echo get_the_post_thumbnail(get_the_ID(), 'full'); ?>
							</div>
					<?php
						}
					} ?>

				</div><!--End liquid-body-->

				<div class="liquid-more">
					<a href="<?php the_permalink(); ?>" class="liquid-more-icon <?php if ($show_social) {
																					echo 'liquid-more-icon-right';
																				} ?>" title="<?php the_title(); ?>"><i class="icon-m-right-arrow-curved"></i><?php _e('Read more...', 'ux'); ?></a>
					<?php if ($show_social) { ?>
						<ul class="post_social clearfix hidden-phone">
							<input value="<?php the_permalink(); ?>" name="url" type="hidden" />
							<input value="<?php the_title(); ?>" name="title" type="hidden" />
							<input value="<?php echo wp_get_attachment_url(get_post_thumbnail_id()); ?>" name="media" type="hidden" />
							<li>
								<a class="share postshareicon-facebook-wrap" href="javascript:;">
									<span class="icon postshareicon-facebook"><i class="fa fa-facebook"></i></span>
									<span class="count">0</span>
								</a>
							</li>

							<li>
								<a class="share postshareicon-twitter-wrap" href="javascript:;">
									<span class="icon postshareicon-twitter"><i class="fa fa-twitter"></i></span>
									<span class="count">0</span>
								</a>
							</li>
							<?php if (has_post_thumbnail()) { ?>
								<li>
									<a class="share postshareicon-pinterest-wrap" href="javascript:;">
										<span class="icon postshareicon-pinterest"><i class="fa fa-pinterest"></i></span>
										<span class="count">0</span>
									</a>
								</li>
							<?php } ?>
						</ul>
					<?php } ?>
				</div><!--End liquid-more-->

			</section>
		<?php
		wp_reset_postdata();
	}

	//liquid list select fields
	function ux_pb_module_liquidlist_select($fields)
	{
		$fields['module_liquidlist_style'] = array(
			array('title' => __('Productos', 'ux'), 'value' => 'productos'),
			array('title' => __('Productos destacados', 'ux'), 'value' => 'destacados'),
			array('title' => __('Categorías', 'ux'), 'value' => 'categorias')
		);

		$fields['module_latestpost_showfunction'] = array(
			array('title' => __('Title', 'ux'), 'value' => 'title'),
			array('title' => __('Read More Button', 'ux'), 'value' => 'read_more_button')
		);

		$fields['module_liquidlist_pagination'] = array(
			array('title' => __('No', 'ux'), 'value' => 'no'),
			array('title' => __('Page Number', 'ux'), 'value' => 'page_number'),
			array('title' => __('Load More', 'ux'), 'value' => 'twitter')
		);

		return $fields;
	}
	add_filter('ux_pb_module_select_fields', 'ux_pb_module_liquidlist_select');

	//liquid list config fields
	function ux_pb_module_liquidlist_fields($module_fields)
	{
		$module_fields['liquid-list'] = array(
			'id' => 'liquid-list',
			'animation' => 'class-3',
			'title' => __('Liquid list', 'ux'),
			'item' =>  array(
				array(
					'title' => __('Seleccionar', 'ux'),
					'description' => __('Seleccione si quiere mostrar productos o categorías', 'ux'),
					'type' => 'select',
					'name' => 'module_liquidlist_style',
					'default' => 'image'
				),

				array(
					'title' => __('Category', 'ux'),
					'description' => __('The posts under the category you selected would be shown in this module', 'ux'),
					'type' => 'categoryP',
					'name' => 'module_cat_productos',
					'taxonomy' => 'category',
					'default' => '0',
					'control' => array(
						'name' => 'module_liquidlist_style',
						'value' => 'productos'
					)
				),

				array(
					'title' => __('Order by', 'ux'),
					'description' => __('Select sequence rules for the list', 'ux'),
					'type' => 'orderby',
					'name' => 'module_select_orderby',
					'default' => 'date'
				),

				array(
					'title' => __('Pagination', 'ux'),
					'description' => __('The "Twitter" option is to show a "Load More" button on the bottom of the list', 'ux'),
					'type' => 'select',
					'name' => 'module_liquidlist_pagination',
					'default' => 'no'
				),

				array(
					'title' => __('Number per Page', 'ux'),
					'description' => __('How many items should be displayed per page, leave it empty to show all items in one page', 'ux'),
					'type' => 'text',
					'name' => 'module_liquidlist_per_page'
				),

				array(
					'title' => __('Advanced Settings', 'ux'),
					'description' => __('magin and animations', 'ux'),
					'type' => 'switch',
					'name' => 'module_advanced_settings',
					'default' => 'off'
				),

				array(
					'title' => __('Bottom Margin', 'ux'),
					'description' => __('the spacing outside the bottom of module', 'ux'),
					'type' => 'select',
					'name' => 'module_bottom_margin',
					'default' => 'bottom-space-40',
					'control' => array(
						'name' => 'module_advanced_settings',
						'value' => 'on'
					)
				),

				array(
					'title' => __('Scroll in Animation', 'ux'),
					'description' => __('enable to select Scroll in animation effect', 'ux'),
					'type' => 'switch',
					'name' => 'module_scroll_in_animation',
					'default' => 'off',
					'control' => array(
						'name' => 'module_advanced_settings',
						'value' => 'on'
					)
				),

				array(
					'title' => __('Scroll in Animation Effect', 'ux'),
					'description' => __('animation effect when the module enter the scene', 'ux'),
					'type' => 'select',
					'name' => 'module_scroll_animation_two',
					'default' => 'fadein',
					'control' => array(
						'name' => 'module_scroll_in_animation',
						'value' => 'on'
					)
				)
			)
		);
		return $module_fields;
	}
	add_filter('ux_pb_module_fields', 'ux_pb_module_liquidlist_fields');
		?>