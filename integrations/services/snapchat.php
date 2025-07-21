<?php
defined( 'ABSPATH' ) or die( "you do not have access to this page!" );

add_filter( 'cmplz_known_script_tags', 'cmplz_snapchat_script' );
function cmplz_snapchat_script( $tags ) {
	$tags[] = array(
		'name' => 'snapchat',
		'category' => 'marketing',
		'urls' => array(
			'snapchat.com',
            'snapchat.com/embed.js',
            'snapchat.com/spotlight',
		),
        'placeholder' => 'snapchat',
        'enable_placeholder' => '1',
        'placeholder_class' => 'snapchat-embed',
	);
	return $tags;
}

/**
 * Add custom snapchat css; hiding the view on snapchat button
 */
add_action( 'cmplz_banner_css', 'cmplz_snapchat_css' );
function cmplz_snapchat_css() {
	?>
        <style>    
        .snapchat-embed > div  {
            display: none !important;
        }
        </style>   
	<?php
}
add_action( 'wp_footer', 'cmplz_snapchat_css' );
