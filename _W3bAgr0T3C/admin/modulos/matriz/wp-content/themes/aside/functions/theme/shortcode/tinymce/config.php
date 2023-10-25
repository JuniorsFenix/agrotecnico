<?php
/*-----------------------------------------------------------------------------------*/
/*	Default Options
/*-----------------------------------------------------------------------------------*/

// Number of posts array
function ux_shortcodes_range ( $range, $all = true, $default = false, $range_start = 1 ) {
	if($all) {
		$number_of_posts['-1'] = 'All';
	}

	if($default) {
		$number_of_posts[''] = 'Default';
	}

	foreach(range($range_start, $range) as $number) {
		$number_of_posts[$number] = $number;
	}

	return $number_of_posts;
}

// Taxonomies
function ux_shortcodes_categories ( $taxonomy, $empty_choice = false ) {
	if($empty_choice == true) {
		$post_categories[''] = 'Default';
	}

	$get_categories = get_categories('hide_empty=0&taxonomy=' . $taxonomy);

	if( ! array_key_exists('errors', $get_categories) ) {
		if( $get_categories && is_array($get_categories) ) {
			foreach ( $get_categories as $cat ) {
				$post_categories[$cat->slug] = $cat->name;
			}
		}

		if(isset($post_categories)) {
			return $post_categories;
		}
	}
}

$choices = array('yes' => 'Yes', 'no' => 'No');
$reverse_choices = array('no' => 'No', 'yes' => 'Yes');
$dec_numbers = array('0.1' => '0.1', '0.2' => '0.2', '0.3' => '0.3', '0.4' => '0.4', '0.5' => '0.5', '0.6' => '0.6', '0.7' => '0.7', '0.8' => '0.8', '0.9' => '0.9', '1' => '1' );

// Fontawesome icons list
$pattern = '/\.(fa-(?:\w+(?:-)?)+):before\s+{\s*content:\s*"(.+)";\s+}/';
$fontawesome_path =  get_template_directory().'/functions/theme/css/font-awesome.min.css';
if( file_exists( $fontawesome_path ) ) {
	if(!class_exists('WP_Filesystem_Direct')){
		require_once(ABSPATH . 'wp-admin/includes/class-wp-filesystem-base.php');
		require_once(ABSPATH . 'wp-admin/includes/class-wp-filesystem-direct.php');
	}
	$wp_filesystem = new WP_Filesystem_Direct('');
	@$subject = $wp_filesystem->get_contents($fontawesome_path);
}

preg_match_all($pattern, $subject, $matches, PREG_SET_ORDER);

$icons = array();

foreach($matches as $match){
	array_push($icons, 'fa ' . $match[1]);
}

$checklist_icons = array ( 'icon-check' => '\f00c', 'icon-star' => '\f006', 'icon-angle-right' => '\f105', 'icon-asterisk' => '\f069', 'icon-remove' => '\f00d', 'icon-plus' => '\f067' );

/*-----------------------------------------------------------------------------------*/
/*	Shortcode Selection Config
/*-----------------------------------------------------------------------------------*/

$ux_shortcodes['shortcode-generator'] = array(
	'no_preview' => true,
	'params' => array(),
	'shortcode' => '',
	'popup_title' => ''
);


// Buttons shortcode config
$ux_shortcodes['button'] = array(
	'params' => array(
		'content' => array(
			'std' => 'Button Text',
			'type' => 'text',
			'label' => __('Text', 'ux'),
			'desc' => __('Add the button\'s text', 'ux'),
		),
		'link' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Link', 'ux'),
			'desc' => __('Add the button\'s url eg http://example.com', 'ux')
		),
		'color' => array(
			'type' => 'select',
			'label' => __('Color', 'ux'),
			'desc' => __('Select the button\'s color', 'ux'),
			'options' => array(
				'btn-dark' => 'Dark',
				'btn-light' => 'Light'
			)
		)
	),
	'shortcode' => '[button link="{{link}}" color="{{color}}"] {{content}} [/button]',
	'popup_title' => __('Insert Button Shortcode', 'ux')
);
// swich word config
$ux_shortcodes['switching_word'] = array(
	'params' => array(
		'content' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Main words', 'ux'),
			'desc' => __('Add the main words', 'ux'),
		),
		'word1' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Word 1', 'ux'),
			'desc' => ''
		),
		'word2' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Word 2', 'ux'),
			'desc' => ''
		),
		'word3' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Word 3', 'ux'),
			'desc' => __('It is optional', 'ux'),
		),
		'word4' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Word 4', 'ux'),
			'desc' => __('It is optional', 'ux'),
		),
		'word5' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Word 5', 'ux'),
			'desc' => __('It is optional', 'ux'),
		),
		'size' => array(
			'type' => 'select',
			'label' => __('Size', 'ux'),
			'desc' => __('Select the words size', 'ux'),
			'options' => array(
				'h1' => 'H1',
				'h2' => 'h2',
				'h3' => 'h3',
				'h4' => 'h4',
				'h5' => 'h5',
				'h6' => 'h6',
				'p' => 'p'
			)
		)
	),
	'shortcode' => '[switching_word size="{{size}}" word1="{{word1}}" word2="{{word2}}" word3="{{word3}}" word4="{{word4}}" word5="{{word5}}"] {{content}} [/switching_word]',
	'popup_title' => __('Insert Switching Word', 'ux')
);
// Dropcap
$ux_shortcodes['dropcap'] = array(
	'params' => array(
		'content' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Letter', 'ux'),
			'desc' => '',
			)
	),
	'shortcode' => '[dropcap]{{content}}[/dropcap]',
	'popup_title' => __('Insert First Letter Shortcode', 'ux')
);
// Icon
$ux_shortcodes['icon'] = array(
	'params' => array(
		'content' => array(
			'std' => 'check',
			'type' => 'iconpicker',
			'options' => $icons,
			'label' => __('Select icon', 'ux'),
			'desc' => __('Add the icon', 'ux'),
		),
			'size' => array(
				'std' => 'medium',
				'type' => 'select',
				'label' => __('Size', 'ux'),
				'options' => array(
					'fa-lg' => 'Small',
					'fa-2x' => 'Medium',
					'fa-3x' => 'Big'
					)
			)
		
	),
	'shortcode' => '[icon size="{{size}}"]{{content}}[/icon]',
	'popup_title' => __('Insert Face Shortcode', 'ux')
);


// Lists

$ux_shortcodes['lists'] = array(
	'params' => array(
		'style' => array(
			'std' => 'check',
			'label' => __('List Icon', 'ux'),
			'type' => 'iconpicker',
			'options' => $icons,
			'desc' => __('Add the icon', 'ux')
		),
			'content' => array(
				'std' => '',
				'type' => 'textarea',
				'label' => __('List Content', 'ux'),
				'desc' => ''
			)
		
	),
	'shortcode' => '[list style="{{style}}"] {{content}} [/list]',
	'popup_title' => __('Insert Text List Shortcode', 'ux')
);
// Image 
$ux_shortcodes['image'] = array(
	'params' => array(
		'content' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Image URL', 'ux'),
			'desc' => __('Add the image\'s url', 'ux'),
		),
		'align' => array(
			'std' => '',
			'type' => 'select',
			'label' => __('Align', 'ux'),
			'desc' => '',
			'options' => array(
				'left' => 'Left',
				'center' => 'Center',
				'right' => 'Right'
			)
		),
		'radius' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Radius', 'ux'),
			'desc' => __('Add the image\'s radius value, eg: 10', 'ux')
		),
		'style' => array(
			'type' => 'select',
			'label' => __('Style', 'ux'),
			'desc' => __('Select the style', 'ux'),
			'options' => array(
				'' => 'Standard',
				'shadow' => 'Shadow'
			)
		),
		'name' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Image Name', 'ux'),
			'desc' => __('Add the image\'s name, it is optional', 'ux'),
		),
		'link' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Image Link URL', 'ux'),
			'desc' => __('Add the image\'s link url, it is optional.', 'ux'),
		),
		'target' => array(
			'std' => '',
			'type' => 'checkbox',
			'label' => __('Open Link in New Tab', 'ux'),

		)	
		
	),
	'shortcode' => '[image align="{{align}}" radius="{{radius}}" style="{{style}}" name="{{name}}" link="{{link}}" target="{{target}}"]{{content}}[/image]',
	'popup_title' => __('Insert Image Shortcode', 'ux')
);
// Blank shortcode config
$ux_shortcodes['blank'] = array(
	'params' => array(
		'des' => array(
			'std' => '',
			'type' => 'description',
			'label' => __('Description', 'ux'),
			'desc' => __('The blank shortcode would clear float', 'ux')
		)
		
	),
	'shortcode' => '[blank] ',
	'popup_title' => __('Insert Blank Shortcode', 'ux')
);

// Lines shortcode config
$ux_shortcodes['line'] = array(
	'params' => array(
		'color' => array(
			'type' => 'select',
			'label' => __('Color', 'ux'),
			'desc' => __('Select the Line\'s colour', 'ux'),
			'options' => array(
				'blue' => 'Blue',
				'red' => 'Red',
				'pink' => 'Pink',
				'green' => 'Green',
				'brown' => 'Brown',
				'grey' => 'Grey',
				'dark' => 'Dark',
				'black' => 'Black'
			)
		),
		'style' => array(
			'type' => 'select',
			'label' => __('Style', 'ux'),
			'desc' => __('Select the Line\'s type', 'ux'),
			'options' => array(
				'solid' => 'Solid',
				'dot' => 'Dot',
				'dashed' => 'Dashed'
			)
		),
		'width' => array(
			'std' => '',
			'type' => 'text',
			'label' => __('Width', 'ux'),
			'desc' => __('Add the Line\'s width eg 95%', 'ux')
		)
	),
	'shortcode' => '[line width="{{width}}" color="{{color}}" style="{{style}}"] ',
	'popup_title' => __('Insert Line Shortcode', 'ux')
);
// Columns
$ux_shortcodes['columns'] = array(
	'params' => array(),
	'shortcode' => ' {{child_shortcode}} ', // as there is no wrapper shortcode
	'popup_title' => __('Insert Columns Shortcode', 'ux'),
	'no_preview' => true,
	
	// child shortcode is clonable & sortable
	'child_shortcode' => array(
		'params' => array(
			'column' => array(
				'type' => 'select',
				'label' => __('Column Type', 'ux'),
				'desc' => __('Select the type, ie width of the column.', 'ux'),
				'options' => array(
					'one_third' => 'One Third',
					'one_third_last' => 'One Third Last',
					'two_third' => 'Two Thirds',
					'two_third_last' => 'Two Thirds Last',
					'one_half' => 'One Half',
					'one_half_last' => 'One Half Last',
					'one_fourth' => 'One Fourth',
					'one_fourth_last' => 'One Fourth Last',
					'three_fourth' => 'Three Fourth',
					'three_fourth_last' => 'Three Fourth Last',
					'one_fifth' => 'One Fifth',
					'one_fifth_last' => 'One Fifth Last',
					'two_fifth' => 'Two Fifth',
					'two_fifth_last' => 'Two Fifth Last',
					'three_fifth' => 'Three Fifth',
					'three_fifth_last' => 'Three Fifth Last',
					'four_fifth' => 'Four Fifth',
					'four_fifth_last' => 'Four Fifth Last',
					'one_sixth' => 'One Sixth',
					'one_sixth_last' => 'One Sixth Last',
					'five_sixth' => 'Five Sixth',
					'five_sixth_last' => 'Five Sixth Last'
				)
			),
			'content' => array(
				'std' => '',
				'type' => 'textarea',
				'label' => __('Column Content', 'ux'),
				'desc' => __('Add the column content.', 'ux'),
			)
		),
		'shortcode' => '[{{column}}] {{content}} [/{{column}}] ',
		'clone_button' => __('Add a new Column', 'ux')
	)
);



// Fixed Column
$ux_shortcodes['fixedcolumns'] = array(
	'params' => array(),
	'shortcode' => ' {{child_shortcode}} ', // as there is no wrapper shortcode
	'popup_title' => __('Insert Fixed Columns Shortcode', 'ux'),
	'no_preview' => true,
	
	// child shortcode is clonable & sortable
	'child_shortcode' => array(
		'params' => array(
			'width' => array(
				'std' => '300px',
				'type' => 'text',
				'label' => __('Width', 'ux'),
				'desc' => __('e.g. 300px', 'ux')
			),
			'margin_top' => array(
				'std' => '20px',
				'type' => 'text',
				'label' => __('Margin Top', 'ux'),
				'desc' => __('Column spacing on the top, e.g. 20px', 'ux')
			),
			'margin_left' => array(
				'std' => '20px',
				'type' => 'text',
				'label' => __('Margin Left', 'ux'),
				'desc' => __('Column spacing on the left, e.g. 20px', 'ux')
			),
			'margin_bottom' => array(
				'std' => '20px',
				'type' => 'text',
				'label' => __('Margin Bottom', 'ux'),
				'desc' => __('Column spacing on the bottom, e.g. 20px', 'ux')
			),
			'margin_right' => array(
				'std' => '20px',
				'type' => 'text',
				'label' => __('Margin Right', 'ux'),
				'desc' => __('Column spacing on the right, e.g. 20px', 'ux')
			),
			'content' => array(
				'std' => '',
				'type' => 'textarea',
				'label' => __('Content', 'ux'),
				'desc' => ''
			)
		),
		'shortcode' => '[fixed_column margin_top="{{margin_top}}"  margin_right="{{margin_right}}" margin_bottom="{{margin_bottom}}" margin_left="{{margin_left}}" width="{{width}}"] {{content}} [/fixed_column] ',
		'clone_button' => __('Add Fixed Columns', 'ux')
	)
);
?>