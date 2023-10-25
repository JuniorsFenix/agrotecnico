<?php
/*  Columns */
	function ux_one_half( $atts, $content = null ) {
	   return '<div class="one-half-c">' . do_shortcode($content) . '</div>';
	}
	add_shortcode('one_half', 'ux_one_half');
	
	function ux_one_half_last( $atts, $content = null ) {
   return '<div class="one-half-c last">' . do_shortcode($content) . '</div><div class="clear"></div>';
	}
	add_shortcode('one_half_last', 'ux_one_half_last');
	//
	function ux_one_third( $atts, $content = null ) {
	   return '<div class="one-third-c">' . do_shortcode($content) . '</div>';
	}
	add_shortcode('one_third', 'ux_one_third');
	
	function ux_one_third_last( $atts, $content = null ) {
   return '<div class="one-third-c last">' . do_shortcode($content) . '</div><div class="clear"></div>';
	}
	add_shortcode('one_third_last', 'ux_one_third_last');
	//
	function tz_two_third( $atts, $content = null ) {
	   return '<div class="two-third-c">' . do_shortcode($content) . '</div>';
	}
	add_shortcode('two_third', 'tz_two_third');
	//
	function tz_two_third_last( $atts, $content = null ) {
	   return '<div class="two-third-c last">' . do_shortcode($content) . '</div><div class="clear"></div>';
	}
	add_shortcode('two_third_last', 'tz_two_third_last');
	//
	function ux_one_fourth( $atts, $content = null ) {
	   return '<div class="one-fourth-c">' . do_shortcode($content) . '</div>';
	}
	add_shortcode('one_fourth', 'ux_one_fourth');
	//
	function ux_one_fourth_last( $atts, $content = null ) {
   return '<div class="one-fourth-c last">' . do_shortcode($content) . '</div><div class="clear"></div>';
	}
	add_shortcode('one_fourth_last', 'ux_one_fourth_last');
	//
	function ux_three_fourth( $atts, $content = null ) {
	   return '<div class="three-fourth-c">' . do_shortcode($content) . '</div>';
	}
	add_shortcode('three_fourth', 'ux_three_fourth');
	//
	function ux_three_fourth_last( $atts, $content = null ) {
	   return '<div class="three-fourth-c last">' . do_shortcode($content) . '</div><div class="clear"></div>';
	}
	add_shortcode('three_fourth_last', 'ux_three_fourth_last');
	//
	function ux_one_fifth( $atts, $content = null ) {
	   return '<div class="one-fifth-c">' . do_shortcode($content) . '</div>';
	}
	add_shortcode('one_fifth', 'ux_one_fifth');	
	//
	function ux_one_fifth_last( $atts, $content = null ) {
	   return '<div class="one-fifth-c last">' . do_shortcode($content) . '</div><div class="clear"></div>';
	}
	add_shortcode('one_fifth_last', 'ux_one_fifth_last');
	//
	function ux_two_fifth( $atts, $content = null ) {
	   return '<div class="two-fifth-c">' . do_shortcode($content) . '</div>';
	}
	add_shortcode('two_fifth', 'ux_two_fifth');	
	//
	function ux_two_fifth_last( $atts, $content = null ) {
	   return '<div class="two-fifth-c last">' . do_shortcode($content) . '</div><div class="clear"></div>';
	}
	add_shortcode('two_fifth_last', 'ux_two_fifth_last');
	//
	function ux_three_fifth( $atts, $content = null ) {
	   return '<div class="three-fifth-c">' . do_shortcode($content) . '</div>';
	}
	add_shortcode('three_fifth', 'ux_three_fifth');	
	//
	function ux_three_fifth_last( $atts, $content = null ) {
	   return '<div class="three-fifth-c last">' . do_shortcode($content) . '</div><div class="clear"></div>';
	}
	add_shortcode('three_fifth_last', 'ux_three_fifth_last');	
	//
	function ux_four_fifth( $atts, $content = null ) {
	   return '<div class="four-fifth-c">' . do_shortcode($content) . '</div>';
	}
	add_shortcode('four_fifth', 'ux_four_fifth');	
	//
	function ux_four_fifth_last( $atts, $content = null ) {
	   return '<div class="four-fifth-c last">' . do_shortcode($content) . '</div><div class="clear"></div>';
	}
	add_shortcode('four_fifth_last', 'ux_four_fifth_last');	
	//
	function ux_one_sixth( $atts, $content = null ) {
	   return '<div class="one-sixth-c">' . do_shortcode($content) . '</div>';
	}
	add_shortcode('one_sixth', 'ux_one_sixth');	
	//
	function ux_one_sixth_last( $atts, $content = null ) {
	   return '<div class="one-sixth-c last">' . do_shortcode($content) . '</div><div class="clear"></div>';
	}
	add_shortcode('one_sixth_last', 'ux_one_sixth_last');
	//
	function ux_five_sixth( $atts, $content = null ) {
	   return '<div class="five-sixth-c">' . do_shortcode($content) . '</div>';
	}
	add_shortcode('five_sixth', 'ux_five_sixth');	
	//
	function ux_five_sixth_last( $atts, $content = null ) {
	   return '<div class="five-sixth-c last">' . do_shortcode($content) . '</div><div class="clear"></div>';
	}
	add_shortcode('five_sixth_last', 'ux_five_sixth_last');
/* Center */
	function ux_center( $atts, $content = null ) {
	   return '<div style="text-align:center;position:relative;margin-left:auto;margin-right:auto">' . do_shortcode($content) . '</div>';
	}
	add_shortcode('center', 'ux_center');

/* Tip */
	function ux_tooltip($atts, $content) {
		extract(shortcode_atts(array(
			'link' => '',
			'tip' => ''
		), $atts));
	   $output =  '<a href="'.$link.'" class="tool-tip" title="'.$tip.'">' . do_shortcode($content) . '</a>';
	   return do_shortcode($output);
	}
	add_shortcode('tooltip', 'ux_tooltip');	
	
/* Fixed column */
	function ux_fixed_column($atts, $content) {
	   extract(shortcode_atts(array(
			'width' => '300px',
			'margin_right' => '20px',
			'margin_left' => '20px',
			'margin_top' => '20px',
			'margin_bottom' => '20px'
		), $atts));
		$output = '<div class="fixed_column" style="width:'.$width.'; margin-right:'.$margin_right.'; margin-left:'.$margin_left.'; margin-top:'.$margin_top.'; margin-bottom:'.$margin_bottom.'">' . do_shortcode($content) . '</div>';
		return do_shortcode($output);
	}
	add_shortcode('fixed_column', 'ux_fixed_column');


/* List */
	function ux_list($atts, $content) {
	   extract(shortcode_atts(array(
			'style' => 'check'
		), $atts));
		$output = '<span class="list"><i class="fa '.$style.'"></i><span class="list-inn">' . do_shortcode($content) . '</span></span>';
		return do_shortcode($output);
	}
	add_shortcode('list', 'ux_list');

	
/* icon */
	add_shortcode('icon', 'ux_icon');
	function ux_icon($atts, $content = null) {
	extract(shortcode_atts(array(
			'size' => 'medium'
		), $atts));
		$output = '<i class="fa '.$size.' '. $content .'"></i>';
		return do_shortcode($output);
	}

/*round image*/
	add_shortcode('round', 'ux_round');
	function ux_round($atts, $content = null) {
		extract(shortcode_atts(array(
			'img' => '',
			'link'=> '',
			'width' => '140',
			'height' => '140',
			'radius' => '70',
			'align' => 'center'
		), $atts));
		if($link){
			if($align == 'center'){
				$output = '<a href="'.$link.'"><div style="margin:0 auto; width:'.$width.'px; height:'.$height.'px;-webkit-border-radius:'.$radius.'px;-moz-border-radius:'.$radius.'px; border-radius:'.$radius.'px; background-image:url(' . $img . ')" class="roundimage"></div></a>';
			}else{
				$output = '<a href="'.$link.'"><div style="width:'.$width.'px; height:'.$height.'px;-webkit-border-radius:'.$radius.'px;-moz-border-radius:'.$radius.'px; border-radius:'.$radius.'px; background-image:url(' . $img . ')" class="roundimage"></div></a>';
			}
		}else{
			if($align == 'center'){
				$output = '<div style="margin:0 auto; width:'.$width.'px; height:'.$height.'px;-webkit-border-radius:'.$radius.'px;-moz-border-radius:'.$radius.'px; border-radius:'.$radius.'px; background-image:url(' . $img . ')" class="roundimage"></div>';
			}else{
				$output = '<div style="width:'.$width.'px; height:'.$height.'px;-webkit-border-radius:'.$radius.'px;-moz-border-radius:'.$radius.'px; border-radius:'.$radius.'px; background-image:url(' . $img . ')" class="roundimage"></div>';
			}
		}	
		return do_shortcode($output);
	}

/*images*/
	add_shortcode('image', 'ux_image');
	function ux_image($atts,$content) {
		extract(shortcode_atts(array(
			'img'     => '',
			'radius'  => '0',
			'align'   => 'left',
			'style'   => '',
			'link'    => '',
			'target'  => 'off',
			'width'   => '',
			'name'    => 'Image name'
		),$atts));

		$target = 'on' ? '_blank' : '_self';

		$output = '<div class="single-image shortcode-image '.$style.' '.$align.'-ux">';

		if ($link !==""){
			$output .= '<a href="'.$link.'" title="'.$name.'" target="'.$target.'"><img src="'.$content.'" alt="'.$name.'" style="border-radius:'.$radius.'px;" class="" /></a></div>';
		} else {
			$output .= '<img src="'.$content.'" alt="'.$name.'"  width="'.$width.'" style="border-radius:'.$radius.'px;" class="" /></div>';
		}

			return do_shortcode($output);
		}	

/*images*/
	add_shortcode('imageborder', 'ux_imageborder');
	function ux_imageborder($atts) {
			extract(shortcode_atts(array(
			'img' =>'',
			'link' =>'',
			'width'=>'80%',
			'name' =>'Image name',
			'style' => 'style1'
			),$atts));
			if ($link !==""){
			$output = '<a href="'.$link.'" title="'.$name.'"><img src="'. $img .'" alt="'.$name.'" width="'.$width.'" class="border-'.$style.'" /></a>';
			} else {
			$output = '<img src="'. $img .'" alt="'.$name.'"  width="'.$width.'" class="border-'.$style.'" />';
			}
			return do_shortcode($output);
		}	
	
/*typography*/
	add_shortcode('p', 'ux_paragraph');
	function ux_paragraph($atts, $content = null) {
		$output = '<p class="paragraph">' . $content . '</p>';
		return do_shortcode($output);
	}

/*Fade title*/
	add_shortcode('switching_word', 'ux_switching_word');
	function ux_switching_word($atts, $content) {

		extract(shortcode_atts(array(
			'size' =>'h2',
			'word1' =>'',
			'word2' =>'',
			'word3' =>'',
			'word4' =>'',
			'word5' =>'',
			'word6' =>'',
			'word7' =>'',
			'word8' =>'',
			'word9' =>'',
			'word10' =>''
			),$atts));

			$w1 = $word1 ? "<span>".$word1."</span>" : '';
			$w2 = $word2 ? "<span>".$word2."</span>" : '';
			$w3 = $word3 ? "<span>".$word3."</span>" : '';
			$w4 = $word4 ? "<span>".$word4."</span>" : '';
			$w5 = $word5 ? "<span>".$word5."</span>" : '';
			$w6 = $word6 ? "<span>".$word6."</span>" : '';
			$w7 = $word7 ? "<span>".$word7."</span>" : '';
			$w8 = $word8 ? "<span>".$word8."</span>" : '';
			$w9 = $word9 ? "<span>".$word9."</span>" : '';
			$w10 = $word10 ? "<span>".$word10."</span>" : '';

		
		$output = '<'.$size.'>' . $content . '<span class="word-fadein-fadeout-ux">'.$w1.$w2.$w3.$w4.$w5.$w6.$w7.$w8.$w9.$w10.'</span></'.$size.'>';
		
		return do_shortcode($output);
	}

	
	add_shortcode('title', 'ux_title');
	function ux_title($atts, $content) {
		extract(shortcode_atts(array(
			'size' => 'h4',
			'color' => 'grey'
		), $atts));
		$output = '<'.$size.' class="typograph '.$color.'">' . $content . '</'.$size.'>';
		return do_shortcode($output);
	}
/*button*/
	add_shortcode('button', 'ux_button');
	function ux_button($atts, $content){
			extract(shortcode_atts(array(
			'color' => 'black',
			'link' => '#'
		), $atts));
			$output = '<a class="ux-btn ' .$color.'" href="'.$link.'">'. $content .'</a>';
			return do_shortcode($output);
		}
		
/*google map*/
	add_shortcode('map', 'idi_map');
	function idi_map($atts, $content) {
			extract(shortcode_atts(array(
			'location' => '',
			'width' => '100%',
			'height' => '300px'
			),$atts));

			$output ='<div class="map rounded" style="width:'.$width.'; height:'.$height.'"><iframe width="100%" height="320" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="'.$location.'&amp;output=embed"></iframe></div>
			';
			return do_shortcode($output);
		}
		
/* Contact form */
	add_shortcode('form', 'idi_form');
	function idi_form($atts, $content) {
			extract(shortcode_atts(array(
			'title' => '',
			'name' =>'Name',
			'url' => $_SERVER["REQUEST_URI"],
			'button'  => 'Send',
			'email' =>'Email'
			),$atts));

			if($title){
			$output ='<div class="contactform"><h2>'.$title.'</h2>';
			}else{
			$output ='<div class="contactform">'; 
			}
			$output .='<form action="'.$url.'" id="contact-form" class="contact_form" method="POST">
			<p><input type="text" id="idi_name" name="idi_name" class="requiredField" value="'.$name.'*" onblur="if (this.value ==\'\' ) {this.value = \''.$name.'*\';}" onfocus="if (this.value == \''.$name.'*\' || this.value == \'Required\' ) { this.value = \'\'; }" /></p>
			<p><input type="text" id="idi_mail" name="idi_mail" class="requiredField email" value="'.$email.'*" onblur="if (this.value ==\'\' ) {this.value = \''.$email.'*\';}" onfocus="if (this.value == \''.$email.'*\' || this.value  == \'Required\' || this.value == \'Invalid email\' ) {this.value = \'\';}" /></p>
			<p><textarea rows="4" name="idi_text" id="idi_text" cols="4" class="requiredField inputError"  onfocus="if (this.value == \'Required\') {this.value = \'\';}"></textarea></p>
			<input type="hidden" value="send" name="ux_short_form" />
			<p class="btnarea"><input type="submit" id="idi_send" name="idi_send" class="idi_send" value="'.$button.'" /></p>
			</form>
			</div>
			';
			return do_shortcode($output);
		}		
/*Message Box*/
	add_shortcode('mbox', 'ux_mbox');
	function ux_mbox($atts, $content) {
			extract(shortcode_atts(array(
			'width' => '95%',
			'color' => 'blue'
			),$atts));
			$output = '<div style="width:'.$width.'" class="messagebox_'.$color.'"><span class="messagebox_text">'. $content .'</span></div>';
			return do_shortcode($output);
		}

/*Social icon*/
	add_shortcode('social', 'ux_social');
	function ux_social($atts, $content) {
			extract(shortcode_atts(array(
			'social_type' => 'facebook',
			'social_link' => 'http://facebook.com/yourname'
			),$atts));
			$output = '<a href="'.$social_link.'" class="social_shortcode social_shortcode_'.$social_type.'"><span></span></a>';
			return do_shortcode($output);
		}	
			
/*hr line*/	
	add_shortcode('clear', 'ux_clear');
	function ux_clear() {
		$output = '<p class="clearfix"></p>';
		return do_shortcode($output);
	}
	add_shortcode('blank', 'ux_blank');
	function ux_blank() {
		$output = '<p class="clearfix"></p>';
		return do_shortcode($output);
	}
	add_shortcode('half_line', 'ux_half_line');
	function ux_half_line() {
		$output = '<span class="line_blank_half"></span>';
		return do_shortcode($output);
	}
	add_shortcode('line', 'ux_line');
	function ux_line($atts) {
			extract(shortcode_atts(array(
			'width' => '100%',
			'style' => 'solid',
			'color' => 'grey'
			),$atts));
			$output = '<div style="width:'.$width.'" class="line line_'.$style.' line_'.$color.'"></div>';
			return do_shortcode($output);
	}

	/*SWF*/
	add_shortcode('swf', 'ux_swf');
	function ux_swf($atts, $content) {
			extract(shortcode_atts(array(
			'width' => '600',
			'height' => '400'
			),$atts));
			$output = '<embed wmode="opaque" allowfullscreen="true" allowscriptaccess="always" src="'.$content.'" quality="high" type="application/x-shockwave-flash" width="'.$width.'" height="'.$height.'"></embed>';
			return do_shortcode($output);
	}
	/*Fonts color*/
	add_shortcode('font', 'ux_color');
	function ux_color($atts, $content) {
			extract(shortcode_atts(array(
			'color' => 'dark',
			),$atts));
			$output = '<span class="font'.$color.'">'.$content.'</span>';
			return do_shortcode($output);
	}
	/*First letter */
	add_shortcode('dropcap', 'ux_dropcap');
	function ux_dropcap( $atts, $content = null ) {
	   return '<span class="dropcap">' . do_shortcode($content) . '</span>';
	}
	/*Toggle*/
	add_shortcode('toggle', 'ux_toggle');
	function ux_toggle($atts, $content) {
			extract(shortcode_atts(array(
			'title' => 'Toggle Title'
			),$atts));
			$output = '<div class="toggle"><h6 class="toggle-title">'.$title.'</h6><p class="toggle-des">'.$content.'</p></div>';
			return do_shortcode($output);
	}
	/*image fix*/
	function ux_image_fix( $atts, $content = null ) {
	   return '<div class="image-wrap">' . do_shortcode($content) . '</div>';
	}
	add_shortcode('image_fix', 'ux_image_fix');
	
	//require theme shortcodes
	//require_once locate_template('/functions/theme/shortcodes/tinymce.loader.php');
?>