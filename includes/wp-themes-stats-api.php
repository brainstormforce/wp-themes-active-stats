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

        if ( false === ( $value = get_transient( 'bsf_active_status' ) ) ){

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
            $remote_body = maybe_unserialize( wp_remote_retrieve_body( $request ) );

            update_option( 'bsf_active_install' , $remote_body );
            set_transient( 'bsf_active_status', $remote_body, 604800 );
            
            return $remote_body;
        }
        else {
            return get_option( 'bsf_active_install', true );
        } 

    }

    function bsf_display_active_installs( $atts ) {
        $atts = shortcode_atts(
        array(
            'theme_name' => $atts['theme_name'],
            'theme_author' => $atts['theme_author'],
        ), $atts );

        $wp_theme_name = $atts['theme_name'];
        $wp_theme_author = $atts['theme_author'];

        if( '' != $wp_theme_name && false != $wp_theme_name ) {
            $api_params = array(
                'theme'     => $wp_theme_name,
                'author'    => $wp_theme_author,
                'per_page'  => 1,
                'fields'    => array(
                    'homepage'          => false,
                    'description'       => false,
                    'screenshot_url'    => false,
                    'active_installs'   => true
                )
            );
            $themes_object = $this->wp_isa_call_wp_api_themes( 'query_themes', $api_params );
            //print_r($themes_object);
            $themes_list = ( is_object( $themes_object ) && isset( $themes_object->themes ) ) ? $themes_object->themes : array();

            if( isset( $themes_list[0] ) ) {
                 return $themes_list[0]->active_installs;
            }
            return 'Please Verify Theme Details!';
        }
        return 'Please Verify Theme Details!';
    }
}

new WP_themes_stats_api();