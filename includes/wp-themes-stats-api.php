<?php 

/**
 * WP_themes_stats_api Class.
 */
class WP_themes_stats_api  {
    /**
     * Constructor calling the docs widgets
     */
    function __construct() {    
        add_shortcode( 'wp_theme_active_install', array( $this, 'bsf_display_active_installs' ) );
    }

    function wp_isa_call_wp_api_themes( $action, $api_params = array() ) {
        $url = 'https://api.wordpress.org/themes/info/1.0/';
        if ( $ssl = wp_http_supports( array( 'ssl' ) ) ) {
             $url = set_url_scheme( $url, 'https' );
        }
        $args = (object) $api_params;
        $http_args = array(
            'body' => array(
            'action' => $action,
            'timeout' => 15,
            'request' => serialize( $args )
            )
        ); 
         
        $request = wp_remote_post( $url, $http_args ); 
     
        if ( is_wp_error( $request ) ) {
            // error_log('WP_ERROR = ');error_log( print_r( $request, true ) );
            return false;
        }
     
        return maybe_unserialize( wp_remote_retrieve_body( $request ) );
    }

    function bsf_display_active_installs() {
        
        $wp_theme_name = get_option( 'wp_theme_name' );
        $wp_theme_author = get_option( 'wp_theme_author' );
        $wp_theme_tag = get_option( 'wp_theme_tag' );


        $api_params = array(
            'theme'    => $wp_theme_name,
            'author'    => $wp_theme_author,
            'tag'       => $wp_theme_tag,
            'per_page'  => -1,
            'fields'    => array(
                'homepage'          => false,
                'description'       => false,
                'screenshot_url'    => false,
                'active_installs'   => true
            )
        );
        
        $themes_object = $this->wp_isa_call_wp_api_themes( 'query_themes', $api_params );
         
        $themes_list = $themes_object->themes;

        if( isset( $themes_list[0] ) ) {
             return $themes_list[0]->active_installs;
        }
        else {
            return 'Please Verify Theme Details!';
        }
        // echo "<pre>";
        // print_r($themes_list);
        // echo "</pre>";

    }
}

new WP_themes_stats_api();