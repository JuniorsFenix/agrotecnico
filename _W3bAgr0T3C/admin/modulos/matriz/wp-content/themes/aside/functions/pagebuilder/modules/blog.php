<?php
//blog template
function ux_pb_module_blog($itemid)
{
	$module_post = ux_pb_item_postid($itemid);

	if ($module_post) {
		//blog confing
		$type              = get_post_meta($module_post, 'module_blog_type', true);
		$per_page          = get_post_meta($module_post, 'module_blog_per_page', true);
		$category          = get_post_meta($module_post, 'module_blog_category', true);
		$pagination        = get_post_meta($module_post, 'module_blog_pagination', true);
		$orderby           = get_post_meta($module_post, 'module_blog_orderby', true);
		$order             = get_post_meta($module_post, 'module_select_order', true);
		$get_categories    = get_categories('parent=' . $category);
		$per_page          = $per_page ? $per_page : -1;
		require_once dirname(__FILE__) . ("/../../../../../../../../../include/funciones_public.php");
		$sitioCfg = sitioAssoc();
		$home = $sitioCfg["url"];
		$nConexion = Conectar();
		mysqli_set_charset($nConexion, 'utf8');

		switch ($type) {
			case 'masonry_list': ?>

				<style type="text/css">
					.paginacion div {
						display: inline-block;
						margin-right: 5px;
						margin-top: 5px
					}

					.paginacion .cell a {
						border-radius: 3px;
						font-size: 11px;
						color: #333;
						padding: 8px;
						text-decoration: none;
						border: 1px solid #d3d3d3;
						background-color: #f8f8f8;
					}

					.paginacion .cell a:hover {
						border: 1px solid #c6c6c6;
						background-color: #f0f0f0;
					}

					.paginacion .cell_active span {
						border-radius: 3px;
						font-size: 11px;
						color: #333;
						padding: 8px;
						border: 1px solid #c6c6c6;
						background-color: #e9e9e9;
					}

					.paginacion .cell_disabled span {
						border-radius: 3px;
						font-size: 11px;
						color: #777777;
						padding: 8px;
						border: 1px solid #dddddd;
						background-color: #ffffff;
					}
				</style>
				<div class="paginacion">
					<div><a href="#" id="1"></a></div>
				</div>
				<div class="row contenidoMatriz" style="margin-top: 20px;">
				</div>
				<div class="paginacion">
					<div><a href="#" id="1"></a></div>
				</div>
				<script type="text/javascript">
					jQuery('document').ready(function() {
						jQuery(".paginacion a").trigger('click');
					});

					jQuery('.paginacion').on('click', 'a', function(e) {
						var page = this.id;
						var paginacion = '';

						var data = {
							page: page,
							per_page: '<?php echo $per_page ?>',
							category: '<?php echo $category ?>',
							orderby: '<?php echo $orderby ?>',
							order: '<?php echo $order ?>'
						};

						jQuery.ajax({
							type: 'POST',
							url: '<?php echo $home; ?>/php/paginacion.php',
							data: data,
							dataType: 'json',
							timeout: 3000,
							success: function(data) {
								jQuery('.contenidoMatriz').html(data.articleList);

								if (page == 1) paginacion += '<div class="cell_disabled"><span>Anterior</span></div>';
								else paginacion += '<div class="cell"><a href="#" id="' + (page - 1) + '">Anterior</span></a></div>';

								for (var i = parseInt(page) - 3; i <= parseInt(page) + 3; i++) {
									if (i >= 1 && i <= data.numPage) {
										paginacion += '<div';
										if (i == page) paginacion += ' class="cell_active"><span>' + i + '</span>';
										else paginacion += ' class="cell"><a href="#" id="' + i + '">' + i + '</a>';
										paginacion += '</div>';
									}
								}

								if (page == data.numPage) paginacion += '<div class="cell_disabled"><span>Siguiente</span></div>';
								else paginacion += '<div class="cell"><a href="#" id="' + (parseInt(page) + 1) + '">Siguiente</a></div>';

								jQuery('.paginacion').html(paginacion);
							},
							error: function() {}
						});
						return false;
					});
				</script>
				<?php
				break;

			case 'standard_list':
				$Resultado    = mysqli_query($nConexion, "SELECT * FROM tblmatriz WHERE id = $category");
				$matriz     = mysqli_fetch_array($Resultado);
				$tabla = $matriz["tabla"];

				$Resultado    = mysqli_query($nConexion, "SELECT * FROM `$tabla` WHERE publicar='S' ORDER BY $orderby $order LIMIT $per_page");

				$sql = "select id,titulo from tblmatriz where idcategoria ='{$matriz["id"]}' ";
				$categoriasP = mysqli_query($nConexion, $sql);
				$ncategorias = mysqli_num_rows($categoriasP);

				if ($ncategorias == 0) :
					$campos    = mysqli_query($nConexion, "SELECT * FROM campos ca JOIN campos_matriz cm on (ca.campo=cm.campo) WHERE cm.idmatriz = '$category' ORDER BY cm.id ASC");
				?>
					<div class="game-changer">
						<?php echo "<div class='$tabla'>";
						while ($Registro = mysqli_fetch_assoc($Resultado)) :
							$fotos    = mysqli_query($nConexion, "SELECT * FROM imagenes_matriz WHERE idmatriz = $category and idcontenido = {$Registro["id"]} LIMIT 1"); ?>
							<div itemscope>
								<a class="imagenA" href="<?php echo "$home/$tabla/{$Registro["url"]}"; ?>">
									<?php if (!mysqli_num_rows($fotos)) { ?>
										<img src="<?php echo "$home/fotos/Image/contenidos/"; ?>default.jpg" />
									<?php }
									while ($Fotos = mysqli_fetch_object($fotos)) : ?>
										<img src="<?php echo "$home/fotos/Image/" . $tabla . "/" . $Fotos->imagen; ?>" />
									<?php endwhile;  ?>
								</a>
								<div class="campos">
									<?php while ($r = mysqli_fetch_assoc($campos)) :
										if ($r["campo"] == "Resumen") {
											echo "<p>" . $Registro["Resumen"] . "</p>";
										} elseif ($r["campo"] == "Titulo") { ?>
											<h3><a class="link" href="<?php echo "$home/$tabla/{$Registro["url"]}"; ?>"><?php echo $Registro[$r["campo"]]; ?></a></h3>
										<?php  } elseif ($r["campo"] == "Subtitulo") { ?>
											<h4><?php echo $Registro[$r["campo"]]; ?></h4>
									<?php  }
									endwhile;
									mysqli_data_seek($campos, 0); ?>
									<a class="link ver-mas" href="<?php echo "$home/$tabla/{$Registro["url"]}"; ?>">Ver más</a>
								</div>
							</div>
						<?php endwhile; ?>
					</div>
					</div>
					<?php else :
					$Resultado    = mysqli_query($nConexion, "SELECT * FROM tblmatriz WHERE idcategoria={$matriz["id"]} ORDER BY id ASC LIMIT $per_page");
					echo "<div class='$tabla'>";
					while ($Registro = mysqli_fetch_assoc($Resultado)) : ?>
						<div itemscope itemtype="http://schema.org/NewsArticle">
							<div class="background">
								<a class="imagenA" href="<?php echo "$home/{$Registro["tabla"]}"; ?>">
									<?php if (empty($Registro["imagen"])) { ?>
										<img src="<?php echo "$home/fotos/Image/contenidos/"; ?>default.jpg" />
									<?php } else {
									?><img src="<?php echo "$home/fotos/Image/" . $Registro["tabla"] . "/p_" . $Registro["imagen"]; ?>"><?
																																	} ?>
								</a>
								<div class="campos">
									<h3><a class="link" href="<?php echo "$home/{$Registro["tabla"]}"; ?>"><?php echo $Registro["titulo"]; ?></a></h3>
									<a class="link" href="<?php echo "$home/{$Registro["tabla"]}"; ?>">Más información</a>
								</div>
							</div>
						</div>
					<?php endwhile; ?>
					</div>
				<?php endif;
				if ($category == 2) { ?>
					<script type="text/javascript">
						jQuery(document).on('ready', function() {
							jQuery('.<?php echo "$tabla"; ?>').slick({
								arrows: true,
								slidesToShow: 1,
								slidesToScroll: 1,
								responsive: [{
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
				<?php
				} elseif ($category != 5) { ?>
					<script type="text/javascript">
						jQuery(document).on('ready', function() {
							jQuery('.<?php echo "$tabla"; ?>').slick({
								arrows: true,
								slidesToShow: 3,
								slidesToScroll: 3,
								responsive: [{
									breakpoint: 1200,
									settings: {
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
				<?php } ?>

				<?php if ($count > 2) {
					ux_view_module_pagenums($itemid, 'blog', $per_page, $count, $pagination);
				}
				break;
		}
	}
}
add_action('ux-pb-module-template-blog', 'ux_pb_module_blog');


//blog load template
function ux_pb_module_load_blog($itemid, $paged)
{
	$module_post = ux_pb_item_postid($itemid);

	if ($module_post) {
		//blog confing
		$type              = get_post_meta($module_post, 'module_blog_type', true);
		$per_page          = get_post_meta($module_post, 'module_blog_per_page', true);
		$pagination        = get_post_meta($module_post, 'module_blog_pagination', true);
		$category          = get_post_meta($module_post, 'module_blog_category', true);
		$orderby           = get_post_meta($module_post, 'module_blog_orderby', true);
		$order             = get_post_meta($module_post, 'module_select_order', true);
		$advanced_settings = get_post_meta($module_post, 'module_advanced_settings', true);
		$post_meta         = get_post_meta($module_post, 'module_blog_meta', true);
		$blog_center         = get_post_meta($module_post, 'module_blog_center', true);
		$per_page          = $per_page ? $per_page : -1;
		$animation_style   = $advanced_settings == 'on' ? ux_pb_module_animation_style($itemid, 'blog') : false;

		switch ($type) {
			case 'masonry_list':
				global $post;

				$sticky = get_option('sticky_posts');

				$get_sticky = get_posts(array(
					'posts_per_page' => $per_page,
					'paged'          => $paged,
					'cat'            => $category,
					'orderby'        => $orderby,
					'order'          => $order,
					'post__in'       => $sticky
				));

				$get_blogs = get_posts(array(
					'posts_per_page' => $per_page,
					'orderby'        => $orderby,
					'paged'          => $paged,
					'order'          => $order,
					'cat'            => $category,
					'post__not_in'   => $sticky,
				));

				if ($sticky) {
					$get_blogs = array_merge_recursive($get_sticky, $get_blogs);
				}

				foreach ($get_blogs as $post) {
					setup_postdata($post);
					$get_post_format = (!get_post_format()) ? 'standard' : get_post_format();
					$blog_categories = get_the_category(get_the_ID());
					$separator = ' ';
					$output = '';
					if ($blog_categories) {
						foreach ($blog_categories as $category) {
							$output .= 'filter_' . $category->slug . $separator;
						}
					}

					$bg_color = ux_get_post_meta(get_the_ID(), 'theme_meta_bg_color');
					$bg_color = $bg_color ? 'bg-' . ux_theme_switch_color($bg_color) : 'post-bgcolor-default';

				?>
					<div class="<?php echo trim($output, $separator); ?> width2 isotope-item <?php echo $get_post_format; ?> <?php echo $animation_style; ?>">
						<div class="inside" style="margin:40px 0 0 40px;">
							<div>
								<div class="item_topbar <?php echo $bg_color; ?>"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="item_link"></a></div>

								<?php // ux_pb_module_blog_format($get_post_format); 
								switch ($get_post_format) {
									case 'quote':
										$ux_quote = ux_get_post_meta(get_the_ID(), 'theme_meta_quote'); ?>
										<div class="item_des <?php echo $bg_color; ?>">
											<i class="icon-m-quote-left center-ux"></i>
											<p><?php echo $ux_quote; ?></p>
											<div class="like clear"></div><!--End like-->
										</div>
										<?php
										break;

									case 'link':
										$ux_link_item = ux_get_post_meta(get_the_ID(), 'theme_meta_link_item');
										if ($ux_link_item) { ?>
											<div class="item_des <?php echo $bg_color; ?>">
												<h2 class="item_title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
												<?php if (get_the_excerpt()) { ?><div class="item-des-p"><?php the_excerpt(); ?></div><?php } ?>
												<div class="item-link-wrap">
													<?php foreach ($ux_link_item['name'] as $i => $name) {
														$url = $ux_link_item['url'][$i]; ?>
														<p class="item-link"><a title="<?php echo $name; ?>" href="<?php echo esc_url($url); ?>"><?php echo $name; ?></a></p>
													<?php } ?>
												</div>
												<div class="like clear"></div><!--End like-->
											</div>
											<?php
										}
										break;

									case 'audio':
										$ux_audio_type = ux_get_post_meta(get_the_ID(), 'theme_meta_audio_type');
										$ux_audio_artist = ux_get_post_meta(get_the_ID(), 'theme_meta_audio_artist');
										$ux_audio_mp3 = ux_get_post_meta(get_the_ID(), 'theme_meta_audio_mp3');
										$ux_audio_soundcloud = ux_get_post_meta(get_the_ID(), 'theme_meta_audio_soundcloud');
										switch ($ux_audio_type) {
											case 'self-hosted-audio': ?>
												<div class="item_des <?php echo $bg_color; ?>">
													<h2 class="item_title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
												</div>
												<ul class="audio_player_list <?php echo $bg_color; ?>">
													<?php foreach ($ux_audio_mp3['name'] as $i => $name) {
														$url = $ux_audio_mp3['url'][$i]; ?>
														<li class="audio-unit"><span id="audio-<?php echo get_the_ID() . '-' . $i; ?>" class="audiobutton pause" rel="<?php echo esc_url($url); ?>"></span><span class="songtitle" title="<?php echo $name; ?>"><?php echo $name; ?></span></li>
													<?php } ?>
												</ul>
											<?php
												break;

											case 'soundcloud': ?>
												<div class="item_des <?php echo $bg_color; ?>">
													<h2 class="item_title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
													<div class="soundcloudWrapper">
														<?php if ($ux_audio_soundcloud) { ?>
															<iframe width="100%" height="166" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=<?php echo $ux_audio_soundcloud; ?>&amp;color=ff3900&amp;auto_play=false&amp;show_artwork=false"></iframe>
														<?php } ?>
													</div>
													<div class="like clear"></div><!--End like-->
												</div>
										<?php
												break;
										}
										break;

									case 'video':
										$ux_video_embeded_code = ux_get_post_meta(get_the_ID(), 'theme_meta_video_embeded_code'); ?>

										<?php if ($ux_video_embeded_code) {
											if (strstr($ux_video_embeded_code, "youtu") && !(strstr($ux_video_embeded_code, "iframe"))) { ?>
												<div class="videoWrapper youtube">
													<iframe src="http://www.youtube.com/embed/<?php echo ux_theme_get_youtube($ux_video_embeded_code); ?>?rel=0&controls=1&showinfo=0&theme=light&autoplay=0&wmode=transparent">
													</iframe>
												</div>
											<?php } elseif (strstr($ux_video_embeded_code, "vimeo") && !(strstr($ux_video_embeded_code, "iframe"))) { ?>
												<div class="videoWrapper vimeo">
													<iframe src="http://player.vimeo.com/video/<?php echo ux_theme_get_vimeo($ux_video_embeded_code); ?>?title=0&amp;byline=0&amp;portrait=0" width="100%" height="auto" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
												</div>
										<?php } else {
												echo '<div class="videoWrapper">' . $ux_video_embeded_code . '</div>';
											}
										} ?>


										<div class="item_des <?php echo $bg_color; ?>">
											<h2 class="item_title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
											<div class="like clear"></div><!--End like-->
										</div>
									<?php
										break;

									case 'gallery':
										$ux_portfolio = ux_get_post_meta(get_the_ID(), 'theme_meta_portfolio'); ?>
										<div class="item_des  <?php echo $bg_color; ?>">


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
												}
											}
											?>
											<h2 class="item_title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
											<?php if (get_the_excerpt()) { ?><div class="item-des-p"><?php the_excerpt(); ?></div><?php } ?>
										</div><!--End item_des-->
										<?php
										break;

									default:
										if (has_post_thumbnail()) {
											$thumb_src_full = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full');
											$thumb_src_360 = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'standard-thumb'); ?>
											<a href="<?php echo $thumb_src_full[0]; ?>" class="lightbox" rel="post<?php the_ID(); ?>" title="<?php the_title(); ?>">
												<img alt="<?php the_title(); ?>" src="<?php echo $thumb_src_360[0]; ?>" class="isotope-list-thumb">
											</a>
										<?php } ?>
										<div class="item_des <?php echo $bg_color; ?>">
											<h2 class="item_title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
											<?php if (get_the_excerpt()) { ?><div class="item-des-p"><?php the_excerpt(); ?></div><?php } ?>
											<div class="like clear"></div><!--End like-->
										</div>
								<?php
										break;
								} ?>

							</div>
						</div><!--End inside-->
					</div><!--End isotope-item-->
				<?php
				}
				wp_reset_postdata();
				break;

			case 'standard_list':
				global $post;

				$sticky = get_option('sticky_posts');

				$get_sticky = get_posts(array(
					'posts_per_page' => $per_page,
					'paged'          => $paged,
					'cat'            => $category,
					'orderby'        => $orderby,
					'order'          => $order,
					'post__in'       => $sticky
				));

				$get_blogs = get_posts(array(
					'posts_per_page' => $per_page,
					'orderby'        => $orderby,
					'paged'          => $paged,
					'order'          => $order,
					'cat'            => $category,
					'post__not_in'   => $sticky,
					/*,
					'tax_query' => array(
						'relation' => 'AND',
						array(
							'taxonomy' => 'post_format',
							'field' => 'slug',
							'terms' => array(
								'post-format-gallery',
								'post-format-image',
								'post-format-quote',
								'post-format-link',
								'post-format-audio',
								'post-format-video'
							),
							'operator' => 'NOT IN'
						)
					)*/
				));

				if ($sticky) {
					$get_blogs = array_merge_recursive($get_sticky, $get_blogs);
				}

				foreach ($get_blogs as $post) {
					setup_postdata($post);
					$get_post_format = (!get_post_format()) ? 'standard' : get_post_format();
					$thumb_src_full = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full');
					$standard_blog_thumb_src = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'standard-blog-thumb');

					$bg_color = ux_get_post_meta(get_the_ID(), 'theme_meta_bg_color');
					$bg_color = $bg_color ? 'bg-' . ux_theme_switch_color($bg_color) : 'post-bgcolor-default';

					$min_height = $thumb_src_full ? false : 'min-height:300px;'; ?>
					<section class="blog-item <?php echo $animation_style;
												if ($blog_center == 'on') echo ' blog-item-center' ?>">
						<div class="date-block">
							<p class="date-block-m"><?php echo get_the_time('M'); ?></p>
							<p class="date-block-big"><?php echo get_the_time('d'); ?></p>
							<p class="date-block-y"><?php echo get_the_time('Y'); ?></p>
							<!--<p class="blog-avatar"><a href="#"><?php //echo get_avatar(get_the_author_meta('ID')); 
																	?></a></p>-->
							<div class="date-block-bg <?php echo $bg_color; ?>"></div>
						</div><!--End .date-block-->

						<div class="blog-item-main">
							<h2><a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

							<?php // ux_pb_module_blog_format($get_post_format); 
							switch ($get_post_format) {
								case 'quote':
									$ux_quote = ux_get_post_meta(get_the_ID(), 'theme_meta_quote');
							?>

									<div class="standard-blog-quote">
										<i class="icon-m-quote-left"></i>
										<p><?php echo $ux_quote; ?></p>
									</div>

									<div class="blog-item-excerpt"><?php the_excerpt(); ?></div><!--End blog-item-excerpt-->

									<?php
									break;

								case 'link':
									$ux_link_item = ux_get_post_meta(get_the_ID(), 'theme_meta_link_item');

									if ($ux_link_item) { ?>

										<div class="standard-blog-link-wrap">
											<?php foreach ($ux_link_item['name'] as $i => $name) {
												$url = $ux_link_item['url'][$i]; ?>
												<a class="standard-blog-item-link" title="<?php echo $name; ?>" href="<?php echo esc_url($url); ?>"><?php echo $name; ?></a>
											<?php } ?>
										</div>

									<?php
									} //end if

									break;

								case 'audio':
									$ux_audio_type = ux_get_post_meta(get_the_ID(), 'theme_meta_audio_type');
									$ux_audio_artist = ux_get_post_meta(get_the_ID(), 'theme_meta_audio_artist');
									$ux_audio_mp3 = ux_get_post_meta(get_the_ID(), 'theme_meta_audio_mp3');
									$ux_audio_soundcloud = ux_get_post_meta(get_the_ID(), 'theme_meta_audio_soundcloud'); ?>

									<div class="blog-item-excerpt"><?php the_excerpt(); ?></div><!--End blog-item-excerpt-->

									<?php
									switch ($ux_audio_type) {
										case 'self-hosted-audio': ?>

											<ul class="audio_player_list">
												<?php foreach ($ux_audio_mp3['name'] as $i => $name) {
													$url = $ux_audio_mp3['url'][$i]; ?>
													<li class="audio-unit">
														<span id="audio-<?php echo get_the_ID() . '-' . $i; ?>" class="audiobutton pause" rel="<?php echo esc_url($url); ?>"></span>
														<span class="songtitle" title="<?php echo $name; ?>"><?php echo $name; ?></span>
													</li>
												<?php } ?>
											</ul>
										<?php
											break;

										case 'soundcloud': ?>

											<div class="soundcloudWrapper">
												<?php if ($ux_audio_soundcloud) { ?>
													<iframe width="100%" height="166" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=<?php echo $ux_audio_soundcloud; ?>&amp;color=ff3900&amp;auto_play=false&amp;show_artwork=false"></iframe>
												<?php } ?>
											</div>

									<?php
											break;
									}
									break;

								case 'video':
									$ux_video_embeded_code = ux_get_post_meta(get_the_ID(), 'theme_meta_video_embeded_code'); ?>

									<?php if (get_the_excerpt()) { ?>
										<div class="blog-item-excerpt"><?php the_excerpt(); ?></div>
									<?php } ?>


									<?php if ($ux_video_embeded_code) {
										if (strstr($ux_video_embeded_code, "youtu") && !(strstr($ux_video_embeded_code, "iframe"))) { ?>
											<div class="videoWrapper youtube">
												<iframe src="http://www.youtube.com/embed/<?php echo ux_theme_get_youtube($ux_video_embeded_code); ?>?rel=0&controls=1&showinfo=0&theme=light&autoplay=0&wmode=transparent"></iframe>
											</div>
										<?php } elseif (strstr($ux_video_embeded_code, "vimeo") && !(strstr($ux_video_embeded_code, "iframe"))) { ?>
											<div class="videoWrapper vimeo">
												<iframe src="http://player.vimeo.com/video/<?php echo ux_theme_get_vimeo($ux_video_embeded_code); ?>?title=0&amp;byline=0&amp;portrait=0" width="100%" height="auto" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
											</div>
									<?php } else {
											echo '<div class="videoWrapper">' . $ux_video_embeded_code . '</div>';
										}
									} ?>



								<?php
									break;

								case 'gallery':
									$ux_portfolio = ux_get_post_meta(get_the_ID(), 'theme_meta_portfolio'); ?>

									<?php if (get_the_excerpt()) { ?>
										<div class="blog-item-excerpt"><?php the_excerpt(); ?></div>
									<?php } ?>


									<?php if ($ux_portfolio) { ?>
										<div class="standard-blog-gallery">

											<?php foreach ($ux_portfolio as $num => $image) {

												$thumb_src_full = wp_get_attachment_image_src($image, 'full');
												$thumb_src = wp_get_attachment_image_src($image, 'imagebox-thumb');
												//if($num < 3){ 
											?>

												<a href="<?php echo $thumb_src_full[0]; ?>" class="lightbox" rel="post<?php the_ID(); ?>" title="<?php echo get_the_title($image); ?>">
													<img src="<?php echo $thumb_src[0]; ?>" alt="<?php the_title(); ?>" />
												</a>

											<?php
												//}
											} ?>

										</div>

									<?php } ?>


								<?php
									break;

								default: ?>

									<div class="blog-item-excerpt">
										<?php the_excerpt(); ?>
									</div><!--End blog-item-excerpt-->

									<?php

									if (has_post_thumbnail()) {
										$thumb_src_full = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full');
										$thumb_src_360 = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'standard-thumb'); ?>
										<div class="blog-item-img">
											<a class="lightbox ux-hover-wrap" href="<?php echo $thumb_src_full[0]; ?>">
												<div class="blog-item-img-hover ux-hover-icon-wrap"><i class="icon-m-view"></i></div>
												<img alt="" src="<?php echo $thumb_src_360[0]; ?>">
											</a>
										</div>

							<?php }

									break;
							} ?>

							<?php if ($post_meta != 'off') { ?>
								<ul class="blog_meta">
									<li class="blog_meta_date"><i class="fa fa-calendar"></i><?php echo get_the_time('F j Y'); ?></li>
									<li class="blog_meta_cate"><i class="fa fa-folder-o"></i><?php the_category(' / '); ?></li>
									<?php $posttags = get_the_tags();
									if ($posttags) { ?><li class="blog_meta_cate"><i class="fa fa-tag"></i><?php the_tags('', ' / ', ''); ?></li><?php } ?>
									<li class="blog_meta_auhtor"><i class="fa fa-user"></i><?php the_author(); ?></li>
								</ul><!--End .blog_meta-->
							<?php } ?>

						</div><!--End .blog-item-main-->

					</section>
				<?php
				}
				wp_reset_postdata(); ?>
				<div class="clearfix"></div>
<?php
				break;
		}
	}
}

//blog select fields
function ux_pb_module_blog_select($fields)
{
	$fields['module_blog_type'] = array(
		array('title' => __('Listado', 'ux'), 'value' => 'masonry_list'),
		array('title' => __('Vista Previa', 'ux'), 'value' => 'standard_list')
	);

	$fields['module_blog_pagination'] = array(
		array('title' => __('No', 'ux'), 'value' => 'no'),
		array('title' => __('Números', 'ux'), 'value' => 'page_number'),
		array('title' => __('Cargar más', 'ux'), 'value' => 'twitter')
	);

	$fields['module_blog_orderby'] = array(
		array('title' => __('ID', 'ux'), 'value' => 'id'),
		array('title' => __('Orden', 'ux'), 'value' => 'orden')
	);

	return $fields;
}
add_filter('ux_pb_module_select_fields', 'ux_pb_module_blog_select');

//blog config fields
function ux_pb_module_blog_fields($module_fields)
{
	$module_fields['blog'] = array(
		'id' => 'blog',
		'animation' => 'class-3',
		'title' => __('Blog', 'ux'),
		'item' =>  array(
			array(
				'title' => __('List Type', 'ux'),
				'description' => '',
				'type' => 'select',
				'name' => 'module_blog_type',
				'default' => 'standard_list'
			),

			array(
				'title' => __('Category', 'ux'),
				'description' => __('The Posts under the category you selected would be shown in this module', 'ux'),
				'type' => 'category',
				'name' => 'module_blog_category',
				'default' => '0'
			),

			array(
				'title' => __('Post Number per Page', 'ux'),
				'description' => __('How many items should be displayed per page, leave it empty to show all items in one page', 'ux'),
				'type' => 'text',
				'name' => 'module_blog_per_page'
			),

			array(
				'title' => __('Order by', 'ux'),
				'description' => __('select sequence rules for the list', 'ux'),
				'type' => 'orderby',
				'name' => 'module_blog_orderby',
				'default' => 'id'
			),

			array(
				'title' => __('Pagination', 'ux'),
				'description' => __('The "Twitter" option is to show a "Load More" button on the bottom of the list', 'ux'),
				'type' => 'select',
				'name' => 'module_blog_pagination',
				'default' => 'no'
			),

			array(
				'title' => __('Enable Post Meta', 'ux'),
				'description' => __('Turn on it to enable post meta information', 'ux'),
				'type' => 'switch',
				'name' => 'module_blog_meta',
				'default' => 'off',
				'control' => array(
					'name' => 'module_blog_type',
					'value' => 'standard_list'
				)
			),

			array(
				'title' => __('Align Centered', 'ux'),
				'description' => '',
				'type' => 'switch',
				'name' => 'module_blog_center',
				'default' => 'on',
				'control' => array(
					'name' => 'module_blog_type',
					'value' => 'standard_list'
				)
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
				'title' => __('Animación Parallax', 'ux'),
				'description' => __('Activar para seleccionar el efecto', 'ux'),
				'type' => 'switch',
				'name' => 'module_scroll_in_animation',
				'default' => 'off',
				'control' => array(
					'name' => 'module_advanced_settings',
					'value' => 'on'
				)
			),

			array(
				'title' => __('Efecto de Animación Parallax', 'ux'),
				'description' => __('Efecto cuando el contenido entre a la pantalla', 'ux'),
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
add_filter('ux_pb_module_fields', 'ux_pb_module_blog_fields');
?>