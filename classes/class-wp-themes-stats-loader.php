<?php 

if ( ! class_exists( 'WP_themes_stats_loader' ) ) {
    /**
     * Responsible for setting up constants, classes and includes.
     *
     * @since 1.0
     */
    final class WP_themes_stats_loader {
        /**
         * The unique instance of the plugin.
         *
         * @var Instance variable
         */
        private static $instance;

        /**
         * Gets an instance of our plugin.
         */
        /**
         * Gets an instance of our plugin.
         */
        public static function get_instance() {

            if ( null === self::$instance ) {
                self::$instance = new self();
            }

            return self::$instance;
        }

        /**
         * Constructor.
         */
        private function __construct() {

            $this->define_constants();
            $this->load_files();
        }

        /**
         * Define constants.
         *
         * @since 1.0
         * @return void
         */
        private function define_constants() {

            $file = dirname( dirname( __FILE__ ) );
            define( 'WP_THEMES_STATS_VERSION', '1.0.0' );
            define( 'WP_THEMES_STATS_DIR_NAME', plugin_basename( $file ) );
            define( 'WP_THEMES_STATS_BASE_FILE', trailingslashit( $file ) . WP_THEMES_STATS_DIR_NAME . '.php' );
            define( 'WP_THEMES_STATS_BASE_DIR', plugin_dir_path( WP_THEMES_STATS_BASE_FILE ) );
            define( 'WP_THEMES_STATS_BASE_URL', plugins_url( '/',  WP_THEMES_STATS_BASE_FILE ) );
        }

        /**
         * Loads classes and includes.
         *
         * @since 1.0
         * @return void
         */
        static private function load_files() {
            require_once WP_THEMES_STATS_BASE_DIR . 'includes/wp-themes-stats-api.php';
        }
    }

$wp_themes_stats_loader = WP_themes_stats_loader::get_instance();

}