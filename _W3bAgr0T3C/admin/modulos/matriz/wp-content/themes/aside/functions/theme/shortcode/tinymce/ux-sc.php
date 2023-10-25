<?php

// loads the shortcodes class, wordpress is loaded with it
require_once( 'shortcodes.class.php' );

// get popup type
$popup = trim( $_GET['popup'] );
$shortcode = new ux_shortcodes( $popup );

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<body>
<div id="ux-popup">

	<div id="ux-shortcode-wrap">

		<div id="ux-sc-form-wrap">

			<?php
			$select_shortcode = array(
					'select' => __('Choose a Shortcode','ux'),
					'button' => __('Button','ux'),
					'line' => __('Line','ux'),
					'blank' =>__('Blank','ux'),
					'image' => __('Image','ux'),
					'dropcap' => __('Dropcap','ux'),
					'columns' => __('Columns','ux'),
					'fixedcolumns' => __('Fixed Width Columns','ux'),
					'icon' => __('Icon','ux'),
					'lists' => __('Text List','ux'),
					'switching_word' => __('Switching Word','ux')
			);
			?>
			<table id="ux-sc-form-table" class="ux-shortcode-selector">
				<tbody>
					<tr class="form-row">
						<td class="label"><?php _e('Choose Shortcode','ux'); ?></td>
						<td class="field">
							<div class="ux-form-select-field">
							<div class="ux-shortcodes-arrow">&#xf107;</div>
								<select name="ux_select_shortcode" id="ux_select_shortcode" class="ux-form-select ux-input">
									<?php foreach($select_shortcode as $shortcode_key => $shortcode_value): ?>
									<?php if($shortcode_key == $popup): $selected = 'selected="selected"'; else: $selected = ''; endif; ?>
									<option value="<?php echo $shortcode_key; ?>" <?php echo $selected; ?>><?php echo $shortcode_value; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</td>
					</tr>
				</tbody>
			</table>
			<form method="post" id="ux-sc-form">

				<table id="ux-sc-form-table">

					<?php echo $shortcode->output; ?>

					<tbody class="ux-sc-form-button">
						<tr class="form-row">
							<td class="field"><a href="#" class="ux-insert"><?php _e('Insert Shortcode','ux'); ?></a></td>
						</tr>
					</tbody>

				</table>
				<!-- /#ux-sc-form-table -->

			</form>
			<!-- /#ux-sc-form -->

		</div>
		<!-- /#ux-sc-form-wrap -->

		<div class="clear"></div>

	</div>
	<!-- /#ux-shortcode-wrap -->

</div>
<!-- /#ux-popup -->

</body>
</html>