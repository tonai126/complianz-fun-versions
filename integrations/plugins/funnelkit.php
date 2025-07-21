<?php
 defined( 'ABSPATH' ) or die( "you do not have access to this page!" );
 
 
 /**
  * Set analytics as suggested statistics tool in the wizard (pre-checked)
  */
 
  function cmplz_funnelkit_set_default( $value, $fieldname, $field ) {
     if ( $fieldname === 'compile_statistics' ) {
         return "google-analytics";
     }
     return $value;
 }
 add_filter( 'cmplz_default_value', 'cmplz_funnelkit_set_default', 20, 3 );
 
 
 
 add_filter( 'cmplz_known_script_tags', 'cmplz_funnelkit_script' );
 function cmplz_funnelkit_script( $tags ) {
     // $tags[] = '';
     $tags[] = array(
         'name' => 'funnelkit',
         'category' => 'statistics',
         'urls' => array(
             'tracks.min.js',
         ),
     );
     return $tags;
 }
 

/**
 * Add notice to tell a user to choose Analytics
 *
 * @param $notices
 * @return array
 */
function cmplz_funnelkit_compile_statistics_notice($notices) {
	$text = '';
	$found_key = false;
	//find notice with field_id 'compile_statistics' and replace it with our own
	foreach ($notices as $key=>$notice) {
		if ($notice['field_id']==='compile_statistics') {
			$found_key = $key;
		}
	}

	$notice = [
		'field_id' => 'compile_statistics',
		'label'    => 'default',
		'title'    => __( "Statistics plugin detected", 'complianz-gdpr' ),
		'text'     => cmplz_sprintf( __( "You use %s, which means the answer to this question should be Google Analytics.", 'complianz-gdpr' ), 'FunnelKit' )
		              .' '.$text,
	];

	if ($found_key){
		$notices[$found_key] = $notice;
	} else {
		$notices[] = $notice;
	}
	return $notices;
}
add_filter( 'cmplz_field_notices', 'cmplz_funnelkit_compile_statistics_notice' );


 /**
  * Add social media to the list of detected items, so it will get set as default, and will be added to the notice about it
  *
  * @param $social_media
  *
  * @return array
  */
 function cmplz_funnelkit_detected_social_media( $social_media ) {
 
     if ( ! in_array( 'facebook', $social_media ) ) {
         $social_media[] = 'facebook';
     }
     if ( ! in_array( 'tiktok', $social_media ) ) {
         $social_media[] = 'tiktok';
     }
     if ( ! in_array( 'pinterest', $social_media ) ) {
         $social_media[] = 'pinterest';
     }
     if(! in_array( 'snapchat', $social_media) ) {
         $social_media[] = 'snapchat';
     }
     return $social_media;
 }
 add_filter( 'cmplz_detected_social_media', 'cmplz_funnelkit_detected_social_media' );
 
 
 /**
  * nascondo i campi in google analytics
  */
 
 function cmplz_funnelkit_filter_fields( $fields ) {
     $index = cmplz_get_field_index('compile_statistics_more_info', $fields);
     if ( $index!==false ) {
         unset($fields[$index]['help']);
     }
 
     return cmplz_remove_field( $fields,
         [
             'configuration_by_complianz',
             'ua_code',
             'aw_code',
             'additional_gtags_stats',
             'additional_gtags_marketing',
             'consent-mode',
             'gtag-basic-consent-mode',
             'cmplz-gtag-urlpassthrough',
             'cmplz-gtag-ads_data_redaction',
             'gtm_code',
             'cmplz-tm-template',
             'gtm_code_head'
         ]);
 }
 
 add_filter( 'cmplz_fields', 'cmplz_funnelkit_filter_fields', 2000, 1 );